<?php

namespace App\Livewire;

use App\Mail\NewApplicationMail;
use App\Models\FormField;
use App\Models\FormSubmission;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PublicForm extends Component
{
    public array $formData = [];

    public array $consent = [];

    public bool $submitted = false;

    public int $currentStep = 0;

    public function mount(): void
    {
        foreach ($this->fields as $field) {
            if ($field->type === 'consent') {
                $this->consent[$field->key] = false;
            } elseif (! in_array($field->type, ['section_header'])) {
                $this->formData[$field->key] = '';
            }
        }
    }

    #[Computed]
    public function fields()
    {
        return FormField::where('active', true)
            ->orderBy('sort_order')
            ->get();
    }

    #[Computed]
    public function groupedFields(): array
    {
        $groups = [];
        $currentSection = null;

        foreach ($this->fields as $field) {
            if ($field->type === 'section_header') {
                $currentSection = $field->label;
                $groups[$currentSection] = [];
            } elseif ($currentSection) {
                $groups[$currentSection][] = $field;
            } else {
                $groups['General'][] = $field;
            }
        }

        return $groups;
    }

    #[Computed]
    public function sectionKeys(): array
    {
        return array_keys($this->groupedFields);
    }

    #[Computed]
    public function currentSection(): string
    {
        $keys = $this->sectionKeys;

        return $keys[$this->currentStep] ?? '';
    }

    #[Computed]
    public function progressPercent(): int
    {
        $keys = $this->sectionKeys;
        $total = count($keys);

        return $total > 0 ? (int) round((($this->currentStep + 1) / $total) * 100) : 0;
    }

    public function nextStep(): void
    {
        $keys = $this->sectionKeys;
        $rules = $this->buildRulesForStep($this->currentStep);

        if (! empty($rules)) {
            $this->validate($rules);
        }

        if ($this->currentStep < count($keys) - 1) {
            $this->currentStep++;
        }
    }

    public function prevStep(): void
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
        }
    }

    public function goToStep(int $step): void
    {
        $keys = $this->sectionKeys;

        if ($step >= 0 && $step < count($keys) && $step <= $this->currentStep + 1) {
            $this->currentStep = $step;
        }
    }

    private function buildRulesForStep(int $step): array
    {
        $keys = $this->sectionKeys;
        $section = $keys[$step] ?? '';
        $fieldsInSection = $this->groupedFields[$section] ?? [];
        $rules = [];

        foreach ($fieldsInSection as $field) {
            if ($field->type === 'consent') {
                $rules["consent.{$field->key}"] = $field->required ? 'accepted' : 'nullable';
            } elseif (! in_array($field->type, ['section_header'])) {
                $rule = $field->required ? 'required' : 'nullable';
                if ($field->type === 'email') {
                    $rule .= '|email';
                } elseif ($field->type === 'url') {
                    $rule .= '|url';
                } elseif ($field->type === 'tel') {
                    $rule .= '|min:10';
                }
                $rules["formData.{$field->key}"] = $rule;
            }
        }

        return $rules;
    }

    public function submit(): void
    {
        $rules = [];

        foreach ($this->fields as $field) {
            if ($field->type === 'consent') {
                $rules["consent.{$field->key}"] = $field->required ? 'accepted' : 'nullable';
            } elseif (! in_array($field->type, ['section_header'])) {
                $rule = $field->required ? 'required' : 'nullable';
                if ($field->type === 'email') {
                    $rule .= '|email';
                } elseif ($field->type === 'url') {
                    $rule .= '|url';
                } elseif ($field->type === 'tel') {
                    $rule .= '|min:10';
                }
                $rules["formData.{$field->key}"] = $rule;
            }
        }

        $this->validate($rules);

        $data = $this->formData;
        foreach ($this->consent as $key => $value) {
            if ($value) {
                $data[$key] = 'checked';
            }
        }

        $submission = FormSubmission::create([
            'data' => $data,
            'first_name' => $data['first_name'] ?? null,
            'email' => $data['email'] ?? null,
            'status' => 'pending',
        ]);

        $this->submitted = true;

        try {
            Mail::to('info@janguinternational.org')->send(new NewApplicationMail($submission));
        } catch (\Throwable $e) {
            Log::warning('Failed to send notification email: '.$e->getMessage());
        }

        Flux::toast(variant: 'success', text: 'Application submitted successfully!');
    }

    public function render()
    {
        return view('livewire.public-form');
    }
}
