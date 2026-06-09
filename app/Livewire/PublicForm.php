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

        $this->validate($rules, [], [
            'formData.first_name' => 'first name',
            'formData.email' => 'email address',
            'formData.phone' => 'phone number',
            'formData.nin' => 'NIN',
            'formData.date_of_birth' => 'date of birth',
            'formData.next_of_kin_name' => 'next of kin name',
            'formData.next_of_kin_phone' => 'next of kin phone',
            'formData.personal_statement' => 'personal statement',
            'formData.business_description' => 'business description',
            'formData.skills_talents' => 'skills & talents',
            'formData.time_commitment' => 'time commitment',
            'formData.hear_about' => 'how you heard about us',
            'formData.applied_before' => 'applied before',
            'formData.gender' => 'gender',
            'formData.education_level' => 'education level',
            'formData.district' => 'district',
            'formData.county' => 'county',
            'formData.sub_county' => 'sub-county',
            'formData.village' => 'village',
        ]);

        $data = $this->formData;
        foreach ($this->consent as $key => $value) {
            if ($value) {
                $data[$key] = 'checked';
            }
        }

        FormSubmission::create([
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
