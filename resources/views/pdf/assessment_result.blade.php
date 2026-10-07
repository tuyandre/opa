<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $assessment->title }} - {{ $attendant->name }}</title>
    <style>
        @page { margin: 36px 40px; }
        body { font-family: 'Century Gothic', Futura, 'Avant Garde', Verdana, sans-serif; font-size: 11px; color: #101820; }
        h1 { font-size: 20px; margin: 0 0 4px; }
        h2 { font-size: 13px; margin: 22px 0 8px; color: #146c77; text-transform: uppercase; letter-spacing: 1px; }
        .org { color: #146c77; font-weight: bold; letter-spacing: 1px; font-size: 10px; text-transform: uppercase; }
        .muted { color: #4c4e56; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #146c77; color: #fff; text-align: left; padding: 6px; font-size: 10px; }
        td { padding: 6px; border-bottom: 1px solid #d9dee2; vertical-align: top; }
        .score { background: #f2f7f8; padding: 14px; margin-top: 14px; }
        .big { font-size: 26px; font-weight: bold; color: #146c77; }
        .pass { color: #146c77; font-weight: bold; }
        .fail { color: #e50031; font-weight: bold; }
        .wrong td { background: #fdecef; }
    </style>
</head>
<body>
@php $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.'); @endphp

<div class="org">Office of Professional Auditors</div>
<h1>{{ $assessment->title }}</h1>
<div class="muted">Individual result &middot; submitted {{ $attendant->submitted_at->format('d M Y H:i') }}</div>

<p>
    <strong>{{ $attendant->name }}</strong><br>
    <span class="muted">{{ $attendant->email }}@if($attendant->company) &middot; {{ $attendant->company }}@endif</span>
</p>

<div class="score">
    <span class="big">{{ $fmt($attendant->score) }} / {{ $fmt($attendant->total_marks) }}</span>
    &nbsp; {{ $fmt($attendant->percentage) }}%
    &nbsp; <span class="{{ $attendant->passed ? 'pass' : 'fail' }}">{{ $attendant->passed ? 'PASS' : 'FAIL' }}</span>
    <span class="muted"> (pass mark {{ $assessment->pass_mark }}%)</span>
</div>

<h2>Score by module</h2>
<table>
    <thead><tr><th>Module</th><th style="width:18%">Marks</th><th style="width:18%">Correct</th></tr></thead>
    <tbody>
    @foreach($attendant->module_scores as $m)
        <tr><td>{{ $m['title'] }}</td><td>{{ $fmt($m['score']) }} / {{ $fmt($m['total']) }}</td><td>{{ $m['correct'] }} of {{ $m['questions'] }}</td></tr>
    @endforeach
    </tbody>
</table>

<h2>Answer review</h2>
@foreach($assessment->modules as $module)
    <p><strong>{{ $module->title }}</strong></p>
    <table>
        <thead><tr><th style="width:5%">#</th><th>Question</th><th style="width:22%">Answer</th><th style="width:22%">Correct</th></tr></thead>
        <tbody>
        @foreach($module->questions as $question)
            @php $given = ($attendant->answers ?? [])[$question->id] ?? null; @endphp
            <tr class="{{ $question->isCorrect($given) ? '' : 'wrong' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $question->body }}</td>
                <td>{{ $question->answerLabel($given) }}</td>
                <td>{{ $question->correctLabel() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach
</body>
</html>
