<?php

namespace App\Livewire;

use App\Exports\QuestionnaireExport;
use App\Models\FormField;
use App\Models\FormSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Title('Questionnaire Responses')]
class Questionnaire extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $activeTab = 'responses';

    // Responses tab
    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $statusFilter = '';

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public ?FormSubmission $selectedSubmission = null;

    public bool $showSubmissionDetail = false;

    public bool $editingSubmission = false;

    // Form Fields tab
    public bool $showFieldForm = false;

    public ?FormField $editingField = null;

    public string $fieldKey = '';

    public string $fieldLabel = '';

    public string $fieldType = 'text';

    public string $fieldPlaceholder = '';

    public string $fieldDescription = '';

    public string $fieldSection = '';

    public string $fieldOptions = '';

    public bool $fieldRequired = false;

    public bool $fieldActive = true;

    public int $fieldSortOrder = 0;

    protected $queryString = ['sortField', 'sortDirection'];

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // --- Submission methods ---
    public function viewSubmission(int $id): void
    {
        $this->selectedSubmission = FormSubmission::findOrFail($id);
        $this->editingSubmission = false;
        $this->showSubmissionDetail = true;
    }

    public function closeSubmission(): void
    {
        $this->selectedSubmission = null;
        $this->showSubmissionDetail = false;
        $this->editingSubmission = false;
    }

    public function updatedShowSubmissionDetail($value): void
    {
        if (! $value) {
            $this->selectedSubmission = null;
            $this->editingSubmission = false;
        }
    }

    public function toggleEditSubmission(): void
    {
        $this->editingSubmission = ! $this->editingSubmission;
    }

    public function saveSubmission(): void
    {
        if (! $this->selectedSubmission) {
            return;
        }

        $this->selectedSubmission->save();
        $this->editingSubmission = false;
        Flux::toast(variant: 'success', text: 'Submission updated.');
    }

    public function updateStatus(int $id, string $status): void
    {
        $submission = FormSubmission::findOrFail($id);
        $submission->update(['status' => $status]);

        if ($this->selectedSubmission?->id === $id) {
            $this->selectedSubmission = $submission;
        }

        Flux::toast(variant: 'success', text: 'Status updated.');
    }

    public function deleteSubmission(int $id): void
    {
        FormSubmission::findOrFail($id)->delete();
        $this->closeSubmission();
        Flux::toast(variant: 'success', text: 'Submission deleted.');
    }

    public function exportExcel(): BinaryFileResponse
    {
        return Excel::download(new QuestionnaireExport(
            $this->search,
            $this->statusFilter,
        ), 'questionnaire-responses.xlsx');
    }

    public function exportPdf()
    {
        $submissions = $this->getFilteredQuery()->get();

        $pdf = Pdf::loadView('exports.questionnaire-pdf', [
            'submissions' => $submissions,
            'generatedAt' => now()->format('d M Y, H:i'),
        ]);

        return response()->streamDownload(
            fn () => print ($pdf->output()),
            'questionnaire-responses.pdf'
        );
    }

    // --- Form Fields methods ---
    public function createField(): void
    {
        $this->resetFieldForm();
        $this->editingField = null;
        $this->fieldSortOrder = FormField::max('sort_order') + 1;
        $this->showFieldForm = true;
    }

    public function editField(int $id): void
    {
        $field = FormField::findOrFail($id);
        $this->editingField = $field;
        $this->fieldKey = $field->key;
        $this->fieldLabel = $field->label;
        $this->fieldType = $field->type;
        $this->fieldPlaceholder = $field->placeholder ?? '';
        $this->fieldDescription = $field->description ?? '';
        $this->fieldSection = $field->section ?? '';
        $this->fieldOptions = is_array($field->options) ? implode("\n", $field->options) : ($field->options ?? '');
        $this->fieldRequired = $field->required;
        $this->fieldActive = $field->active;
        $this->fieldSortOrder = $field->sort_order;
        $this->showFieldForm = true;
    }

    public function saveField(): void
    {
        $this->validate([
            'fieldKey' => 'required|alpha_dash',
            'fieldLabel' => 'required',
            'fieldType' => 'required|in:text,textarea,email,tel,select,radio,date,section_header,url,checkbox,consent',
            'fieldSection' => 'nullable',
        ]);

        $options = null;
        if (in_array($this->fieldType, ['select', 'radio', 'checkbox'])) {
            $options = array_map('trim', explode("\n", $this->fieldOptions));
            $options = array_filter($options);
        }

        $data = [
            'key' => $this->fieldKey,
            'label' => $this->fieldLabel,
            'type' => $this->fieldType,
            'placeholder' => $this->fieldPlaceholder,
            'description' => $this->fieldDescription,
            'section' => $this->fieldSection,
            'options' => $options,
            'required' => $this->fieldRequired,
            'active' => $this->fieldActive,
            'sort_order' => $this->fieldSortOrder,
        ];

        if ($this->editingField) {
            $this->editingField->update($data);
            Flux::toast(variant: 'success', text: 'Field updated.');
        } else {
            FormField::create($data);
            Flux::toast(variant: 'success', text: 'Field created.');
        }

        $this->showFieldForm = false;
        $this->resetFieldForm();
    }

    public function deleteField(int $id): void
    {
        FormField::findOrFail($id)->delete();
        $this->showFieldForm = false;
        Flux::toast(variant: 'success', text: 'Field deleted.');
    }

    public function toggleFieldActive(int $id): void
    {
        $field = FormField::findOrFail($id);
        $field->update(['active' => ! $field->active]);
    }

    public function moveFieldUp(int $id): void
    {
        $field = FormField::findOrFail($id);
        $prev = FormField::where('sort_order', '<', $field->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if ($prev) {
            $temp = $field->sort_order;
            $field->update(['sort_order' => $prev->sort_order]);
            $prev->update(['sort_order' => $temp]);
        }
    }

    public function moveFieldDown(int $id): void
    {
        $field = FormField::findOrFail($id);
        $next = FormField::where('sort_order', '>', $field->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        if ($next) {
            $temp = $field->sort_order;
            $field->update(['sort_order' => $next->sort_order]);
            $next->update(['sort_order' => $temp]);
        }
    }

    private function resetFieldForm(): void
    {
        $this->fieldKey = '';
        $this->fieldLabel = '';
        $this->fieldType = 'text';
        $this->fieldPlaceholder = '';
        $this->fieldDescription = '';
        $this->fieldSection = '';
        $this->fieldOptions = '';
        $this->fieldRequired = false;
        $this->fieldActive = true;
        $this->fieldSortOrder = 0;
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    #[Computed]
    public function submissions()
    {
        return $this->getFilteredQuery()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);
    }

    #[Computed]
    public function stats(): array
    {
        $total = FormSubmission::count();
        $genderCounts = FormSubmission::query()
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.gender')) as gender, COUNT(*) as count")
            ->groupBy('gender')
            ->pluck('count', 'gender');

        $educationCounts = FormSubmission::query()
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.education_level')) as education, COUNT(*) as count")
            ->groupBy('education')
            ->pluck('count', 'education');

        $hearAboutCounts = FormSubmission::query()
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.hear_about')) as source, COUNT(*) as count")
            ->groupBy('source')
            ->pluck('count', 'source');

        $statusCounts = FormSubmission::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $recent = FormSubmission::where('created_at', '>=', now()->subDays(7))->count();

        return [
            'total' => $total,
            'gender' => $genderCounts,
            'education' => $educationCounts,
            'hear_about' => $hearAboutCounts,
            'status' => $statusCounts,
            'recent' => $recent,
            'pending' => $statusCounts['pending'] ?? 0,
        ];
    }

    #[Computed]
    public function formFields()
    {
        return FormField::orderBy('sort_order')->get();
    }

    protected function getFilteredQuery()
    {
        $query = FormSubmission::query();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('data', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.questionnaire');
    }
}
