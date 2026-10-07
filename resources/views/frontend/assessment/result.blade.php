@extends('frontend.assessment.layout')

@section('title', 'Your result')

@section('styles')
        .res { max-width: 760px; margin: 0 auto; padding: 48px 24px 64px; }
        .banner { border-radius: 14px; padding: 32px; color: #fff; background: var(--teal); }
        .banner.fail { background: var(--dark); }
        .banner .tag { letter-spacing: .14em; font-size: 12px; font-weight: bold; text-transform: uppercase; opacity: .85; }
        .banner h1 { color: #fff; margin: 8px 0 6px; font-size: 40px; }
        .banner .score { font-size: 18px; }
        .topic { margin-top: 18px; }
        .topic .row { display: flex; justify-content: space-between; gap: 12px; font-weight: bold; }
        .topic .row span:last-child { color: var(--teal); }
        .track { height: 8px; background: var(--line); border-radius: 8px; overflow: hidden; margin-top: 6px; }
        .track i { display: block; height: 100%; background: var(--teal); }
        .marker { position: relative; }
        @media print { header.top, .noprint { display: none; } body { background: #fff; } }
@endsection

@section('content')
    @php
        $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.');
        $passed = $attendant->passed;
    @endphp
    <div class="res">
        <div class="banner {{ $passed ? '' : 'fail' }}">
            <div class="tag">{{ $attendant->name }} · {{ $assessment->title }}</div>
            <h1>{{ $passed ? 'You passed.' : 'Not passed yet.' }}</h1>
            <div class="score"><strong>{{ $fmt($attendant->score) }} / {{ $fmt($attendant->total_marks) }}</strong> marks &middot; {{ $fmt($attendant->percentage) }}% &middot; pass mark {{ $assessment->pass_mark }}%</div>
        </div>

        <div class="card" style="margin-top:24px">
            <h2>Score by topic</h2>
            @foreach($attendant->module_scores as $m)
                @php $pct = $m['total'] > 0 ? $m['score'] / $m['total'] * 100 : 0; @endphp
                <div class="topic">
                    <div class="row"><span>{{ $m['title'] }}</span><span>{{ $fmt($m['score']) }} / {{ $fmt($m['total']) }}</span></div>
                    <div class="track"><i style="width: {{ $pct }}%"></i></div>
                    <div class="small">{{ $m['correct'] }} of {{ $m['questions'] }} correct</div>
                </div>
            @endforeach
            @if($attendant->wasAutoSubmitted())
                <div class="alert" style="margin-top:22px">This assessment was submitted automatically because you left the assessment page. Questions you had not answered are marked as unanswered.</div>
            @endif
            <p class="small" style="margin-top:22px">
                Submitted {{ $attendant->submitted_at->format('d M Y, H:i') }}. Your final submission is saved and cannot be changed.
                Your trainer will discuss next steps with you.
            </p>
            @if($passed)
                <a href="{{ route('assessment.certificate') }}" class="btn noprint" style="text-align:center;text-decoration:none">Download your certificate</a>
            @endif
            <button type="button" class="btn ghost noprint" onclick="window.print()">Print or save this result</button>
        </div>
    </div>
@endsection
