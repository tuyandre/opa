<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $assessment->title }} - Report</title>
    <style>
        @page { margin: 36px 40px; }
        body { font-family: 'Century Gothic', Futura, 'Avant Garde', Verdana, sans-serif; font-size: 11px; color: #101820; }
        h1 { font-size: 20px; margin: 0 0 4px; color: #101820; }
        h2 { font-size: 13px; margin: 22px 0 8px; color: #146c77; text-transform: uppercase; letter-spacing: 1px; }
        .org { color: #146c77; font-weight: bold; letter-spacing: 1px; font-size: 10px; text-transform: uppercase; }
        .muted { color: #4c4e56; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #146c77; color: #fff; text-align: left; padding: 6px; font-size: 10px; }
        td { padding: 6px; border-bottom: 1px solid #d9dee2; vertical-align: top; }
        .kpi td { border: 0; text-align: center; padding: 10px 4px; background: #f2f7f8; }
        .kpi .n { font-size: 20px; font-weight: bold; color: #146c77; }
        .pass { color: #146c77; font-weight: bold; }
        .fail { color: #e50031; font-weight: bold; }
        .footer { margin-top: 24px; font-size: 9px; color: #4c4e56; }
    </style>
</head>
<body>
@php $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.'); @endphp

<div class="org">Office of Professional Auditors</div>
<h1>{{ $assessment->title }}</h1>
<div class="muted">
    Assessment report &middot; {{ now()->format('d M Y') }}
    @if($assessment->version) &middot; Version {{ $assessment->version }} @endif
    @if($assessment->client) &middot; {{ $assessment->client->name }} @endif
    <br>{{ $assessment->questions->count() }} questions &middot; {{ $fmt($assessment->totalMarks()) }} marks &middot; pass mark {{ $assessment->pass_mark }}%
</div>

<h2>Summary</h2>
<table class="kpi"><tr>
        <td><div class="n">{{ $stats['invited'] }}</div>Invited</td>
        <td><div class="n">{{ $stats['submitted'] }}</div>Submitted</td>
        <td><div class="n">{{ $stats['passed'] }}</div>Passed</td>
        <td><div class="n">{{ $stats['failed'] }}</div>Failed</td>
        <td><div class="n">{{ $stats['pass_rate'] !== null ? $stats['pass_rate'] . '%' : '—' }}</div>Pass rate</td>
        <td><div class="n">{{ $stats['average'] !== null ? $stats['average'] . '%' : '—' }}</div>Average</td>
    </tr></table>

@if($stats['submitted'] > 0)
    <p>
        {{ $stats['passed'] }} of {{ $stats['submitted'] }} attendants who submitted reached the {{ $assessment->pass_mark }}% pass mark.
        Scores ranged from {{ $stats['lowest'] }}% to {{ $stats['highest'] }}%.
    </p>

    <h2>Average score by module</h2>
    <table>
        <thead><tr><th>Module</th><th style="width:20%">Average</th></tr></thead>
        <tbody>
        @foreach($stats['modules'] as $m)
            <tr><td>{{ $m['title'] }}</td><td>{{ $m['average_pct'] !== null ? $m['average_pct'] . '%' : '—' }}</td></tr>
        @endforeach
        </tbody>
    </table>
@endif

<h2>Results by attendant</h2>
<table>
    <thead>
    <tr>
        <th>#</th><th>Attendant</th><th>Company</th><th>Status</th>
        @foreach($assessment->modules as $module)<th>{{ \Illuminate\Support\Str::limit($module->title, 14) }}</th>@endforeach
        <th>Score</th><th>%</th><th>Result</th>
    </tr>
    </thead>
    <tbody>
    @foreach($assessment->attendants as $a)
        @php $byModule = collect($a->module_scores ?? [])->keyBy('module_id'); @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->name }}<br><span class="muted">{{ $a->email }}</span></td>
            <td>{{ $a->company }}</td>
            <td>{{ $a->status }}</td>
            @foreach($assessment->modules as $module)
                <td>{{ $byModule->has($module->id) ? $fmt($byModule[$module->id]['score']) : '—' }}</td>
            @endforeach
            <td>{{ $a->isSubmitted() ? $fmt($a->score) . '/' . $fmt($a->total_marks) : '—' }}</td>
            <td>{{ $a->isSubmitted() ? $fmt($a->percentage) : '—' }}</td>
            <td class="{{ $a->passed ? 'pass' : 'fail' }}">{{ $a->isSubmitted() ? ($a->passed ? 'PASS' : 'FAIL') : '—' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">This assessment measures knowledge and scenario-based decisions. It does not replace direct observation of practical exercises.</div>
</body>
</html>
