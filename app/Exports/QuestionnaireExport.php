<?php

namespace App\Exports;

use App\Models\FormSubmission;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionnaireExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(
        private string $search = '',
        private string $statusFilter = '',
    ) {}

    public function query(): Builder
    {
        $query = FormSubmission::query();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $q = $this->search;
            $query->where(function ($query) use ($q) {
                $query->where('first_name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('data', 'like', "%{$q}%");
            });
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Middle Name',
            'Last Name',
            'Email',
            'Phone',
            'District',
            'County',
            'Sub-County',
            'Village',
            'Date of Birth',
            'Gender',
            'NIN',
            'Education Level',
            'Education (Other)',
            'TikTok',
            'Next of Kin',
            'Relationship',
            'Next of Kin Phone',
            'Next of Kin NIN',
            'How did you hear?',
            'Hear About (Other)',
            'Recommender',
            'Personal Statement',
            'Business',
            'Previous Programs',
            'Skills & Talents',
            'Applied Before',
            'Times Applied',
            'Time Commitment',
            'Time Other',
            'Status',
            'Submitted At',
        ];
    }

    public function map($submission): array
    {
        $d = $submission->data;

        return [
            $submission->id,
            $d['first_name'] ?? '',
            $d['middle_name'] ?? '',
            $d['last_name'] ?? '',
            $d['email'] ?? '',
            $d['phone'] ?? '',
            $d['district'] ?? '',
            $d['county'] ?? '',
            $d['sub_county'] ?? '',
            $d['village'] ?? '',
            $d['date_of_birth'] ?? '',
            $d['gender'] ?? '',
            $d['nin'] ?? '',
            $d['education_level'] ?? '',
            $d['education_other'] ?? '',
            $d['tiktok'] ?? '',
            $d['next_of_kin_name'] ?? '',
            $d['next_of_kin_relationship'] ?? '',
            $d['next_of_kin_phone'] ?? '',
            $d['next_of_kin_nin'] ?? '',
            $d['hear_about'] ?? '',
            $d['hear_about_other'] ?? '',
            $d['recommender'] ?? '',
            $d['personal_statement'] ?? '',
            $d['business_description'] ?? '',
            $d['previous_programs'] ?? '',
            $d['skills_talents'] ?? '',
            $d['applied_before'] ?? '',
            $d['applied_times'] ?? '',
            $d['time_commitment'] ?? '',
            $d['time_commitment_other'] ?? '',
            $submission->status,
            $submission->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Responses';
    }
}
