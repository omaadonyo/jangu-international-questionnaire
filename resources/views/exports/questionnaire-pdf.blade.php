<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Questionnaire Responses</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1a1a1a; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .subtitle { color: #666; font-size: 11px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 5px 6px; text-align: left; border: 1px solid #ddd; }
        th { background: #f5f5f5; font-weight: bold; font-size: 9px; text-transform: uppercase; }
        tr:nth-child(even) { background: #fafafa; }
        .status { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 9px; }
        .pending { background: #fef3c7; color: #92400e; }
        .reviewed { background: #dbeafe; color: #1e40af; }
        .accepted { background: #d1fae5; color: #065f46; }
        .rejected { background: #fee2e2; color: #991b1b; }
        .page-break { page-break-after: always; }
        .summary-box { display: inline-block; margin-right: 20px; margin-bottom: 10px; }
        .summary-box strong { font-size: 14px; }
    </style>
</head>
<body>
    <h1>Questionnaire Responses</h1>
    <p class="subtitle">Generated on {{ $generatedAt }} &mdash; {{ $submissions->count() }} total responses</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>District</th>
                <th>Education</th>
                <th>Heard via</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td>{{ $s->first_name ?: 'N/A' }}</td>
                    <td>{{ $s->data['email'] ?? '—' }}</td>
                    <td>{{ $s->data['phone'] ?? '—' }}</td>
                    <td>{{ $s->data['gender'] ?? '—' }}</td>
                    <td>{{ $s->data['district'] ?? '—' }}</td>
                    <td>{{ $s->data['education_level'] ?? '—' }}</td>
                    <td>{{ $s->data['hear_about'] ?? '—' }}</td>
                    <td><span class="status {{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="10">No responses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
