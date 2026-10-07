@extends('frontend.assessment.layout')

@section('title', $assessment->title ?? 'Assessment')

@section('styles')
        .grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 64px; align-items: start; }
        .stats { display: flex; gap: 36px; margin: 36px 0 24px; }
        .stats strong { display: block; font-size: 28px; }
        .stats span { color: var(--grey); font-size: 14px; }
        .modules { border-top: 1px solid var(--line); margin-top: 8px; }
        .modules div { display: flex; align-items: center; gap: 14px; padding: 15px 0; border-bottom: 1px solid var(--line); }
        .modules .n { color: var(--teal); font-weight: bold; font-size: 13px; }
        .modules .t { font-weight: bold; font-size: 17px; flex: 1; }
        .modules .m { color: var(--grey); font-size: 13px; }
        .rules { margin-top: 22px; background: #fdecef; border-left: 4px solid var(--red); border-radius: 8px; padding: 14px 16px; font-size: 14px; }
        .rules strong:first-child { display: block; color: var(--red); margin-bottom: 6px; }
        .rules ul { margin: 0; padding-left: 18px; }
        .rules li { margin: 4px 0; }
        label.agree { display: flex; align-items: flex-start; gap: 10px; font-weight: bold; margin: 14px 0 0; cursor: pointer; }
        label.agree input { width: 18px; height: 18px; margin-top: 2px; accent-color: var(--teal); flex: none; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; gap: 32px; } }
@endsection

@section('content')
    @php $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.'); @endphp
    <div class="wrap">
        <div class="grid">
            <div>
                <div class="eyebrow">Final assessment{{ $assessment && $assessment->client ? ' · ' . $assessment->client->name : '' }}</div>
                @if($assessment)
                    <h1>{{ $assessment->title }}</h1>
                    @if($assessment->description)<p class="lead">{{ $assessment->description }}</p>@endif

                    <div class="stats">
                        <div><strong>{{ $assessment->questions->count() }}</strong><span>Questions</span></div>
                        <div><strong>{{ $fmt($assessment->totalMarks()) }}</strong><span>Total marks</span></div>
                        <div><strong>{{ $assessment->suggested_minutes }} min</strong><span>Suggested time</span></div>
                    </div>

                    <div class="modules">
                        @foreach($assessment->modules as $module)
                            <div>
                                <span class="n">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="t">{{ $module->title }}</span>
                                <span class="m">{{ $fmt($module->questions->sum(fn($q) => $assessment->marksFor($q))) }} marks</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h1>Put your training into practice.</h1>
                    <p class="lead">Enter the personal code your trainer gave you to start.</p>
                @endif
            </div>

            <div class="card">
                <h2>Your assessment</h2>
                <p class="small">Use the personal code provided by your trainer. Already started? Enter the same code to resume your saved draft or view your submitted score.</p>

                @if($assessment && !$assessment->isOpen())
                    <div class="alert">This assessment is not open right now. Please contact your trainer.</div>
                @endif

                <form method="post" action="{{ $slug ? route('assessment.start', $slug) : route('assessment.start') }}" autocomplete="off">
                    @csrf
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                    @error('name')<div class="error">{{ $message }}</div>@enderror

                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required>
                    @error('email')<div class="error">{{ $message }}</div>@enderror

                    <label for="access_code">Personal access code</label>
                    <input type="text" id="access_code" name="access_code" value="{{ old('access_code') }}" placeholder="OPA-..." style="text-transform:uppercase" required>
                    @error('access_code')<div class="error">{{ $message }}</div>@enderror

                    <div class="rules" role="note">
                        <strong>Read before you start</strong>
                        <ul>
                            <li>Stay on this page from start to finish.</li>
                            <li>Do not switch tabs or windows, minimise the browser, or open another app.</li>
                            <li>If you leave, your assessment is <strong>submitted automatically</strong> with the answers you have so far. It cannot be reopened.</li>
                        </ul>
                    </div>
                    <label class="agree" for="agree">
                        <input type="checkbox" id="agree" name="agree" value="1" {{ old('agree') ? 'checked' : '' }} required>
                        <span>I understand and I am ready to start.</span>
                    </label>
                    @error('agree')<div class="error">{{ $message }}</div>@enderror

                    <button type="submit" class="btn">Start or resume assessment</button>
                </form>

                @if($assessment)
                    <div class="note">
                        One final submission per code. Each correct answer earns {{ $fmt($assessment->marks_per_question) }} marks.
                        Answer all questions; there is no negative marking. A calculator is allowed. Pass mark: {{ $assessment->pass_mark }}%.
                    </div>
                @endif
                <p class="small" style="margin-top:18px">Your name, email, answers and score are saved for the trainer's assessment report. Use your assigned code only. Keep it private.</p>
            </div>
        </div>
    </div>
@endsection
