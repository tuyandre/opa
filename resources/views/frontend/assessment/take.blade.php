@extends('frontend.assessment.layout')

@section('title', $assessment->title)

@section('styles')
        .bar { position: sticky; top: 0; z-index: 5; background: #fff; border-bottom: 1px solid var(--line); padding: 10px 24px; }
        .bar .in { max-width: 820px; margin: 0 auto; display: flex; align-items: center; gap: 18px; font-size: 14px; }
        .track { flex: 1; height: 8px; background: var(--line); border-radius: 8px; overflow: hidden; }
        .track i { display: block; height: 100%; width: 0; background: var(--teal); transition: width .2s; }
        .saved { color: var(--grey); font-size: 12px; min-width: 70px; text-align: right; }
        .paper { max-width: 820px; margin: 0 auto; padding: 32px 24px 64px; }
        .module { margin-top: 36px; }
        .module h2 { border-bottom: 3px solid var(--teal); padding-bottom: 8px; }
        .module .meta { color: var(--grey); font-size: 13px; margin: 6px 0 4px; }
        .q { background: #fff; border: 1px solid var(--line); border-radius: 12px; padding: 20px 22px; margin-top: 14px; }
        .q .body { font-weight: bold; margin-bottom: 12px; }
        .q .body em { color: var(--teal); font-style: normal; margin-right: 6px; }
        .opt { display: flex; gap: 10px; align-items: flex-start; padding: 10px 12px; border: 1px solid var(--line); border-radius: 8px; margin-top: 8px; cursor: pointer; }
        .opt:hover { border-color: var(--teal); }
        .opt input { margin-top: 5px; accent-color: var(--teal); }
        .opt.on { border-color: var(--teal); background: var(--tint); }
        .opt b { color: var(--teal); }
        .num { display: flex; align-items: center; gap: 10px; max-width: 360px; }
        .num span { color: var(--grey); font-size: 14px; white-space: nowrap; }
        .num input { margin: 0; }
        .submitbox { margin-top: 36px; text-align: center; }
        .submitbox .btn { max-width: 320px; margin: 18px auto 0; }
        .stay { background: #fdecef; border-left: 4px solid var(--red); border-radius: 8px; padding: 10px 14px; font-size: 14px; margin: 14px 0 6px; }
        .stay strong { color: var(--red); }
        body.gated { overflow: hidden; }
        .screen { position: fixed; inset: 0; z-index: 50; background: rgba(16,24,32,.94); display: flex; align-items: center; justify-content: center; padding: 20px; overflow-y: auto; }
        .screen[hidden] { display: none; }
        .screen .box { background: #fff; border-radius: 14px; border-top: 5px solid var(--red); max-width: 560px; width: 100%; padding: 30px; }
        .screen .box.teal { border-top-color: var(--teal); }
        .screen h2 { font-size: 24px; margin: 0 0 10px; }
        .screen ul { padding-left: 20px; margin: 12px 0 0; }
        .screen li { margin: 8px 0; }
        .screen .btn { margin-top: 24px; }
@endsection

@section('content')
    {{-- Shown before the attendant starts (and again on resume/refresh): the "stay on this page" rule. --}}
    <div class="screen" id="gate" role="dialog" aria-modal="true" aria-labelledby="gateTitle">
        <div class="box">
            <div class="eyebrow">Before you begin</div>
            <h2 id="gateTitle">Stay on this page until you submit</h2>
            <ul>
                <li>Do <strong>not</strong> switch tabs or windows, minimise the browser, open another app or click outside this page.</li>
                <li>If you leave, your assessment is <strong>submitted automatically</strong> with the answers saved so far. It <strong>cannot be reopened</strong>.</li>
                <li>Your answers save as you go. A final submission cannot be changed.</li>
                <li>Have your calculator ready before you start.</li>
            </ul>
            <button type="button" class="btn" id="beginBtn">I understand. Begin assessment</button>
        </div>
    </div>

    {{-- Shown the moment the attendant leaves the page. --}}
    <div class="screen" id="lock" role="alertdialog" aria-modal="true" aria-labelledby="lockTitle" hidden>
        <div class="box">
            <div class="eyebrow">Assessment closed</div>
            <h2 id="lockTitle">You left the assessment page</h2>
            <p>Your assessment has been submitted automatically with the answers you had saved. It cannot be reopened.</p>
            <button type="button" class="btn" id="lockBtn">See my result</button>
        </div>
    </div>

    @php $answers = $attendant->answers ?? []; $total = $assessment->questions->count(); $n = 0; @endphp

    <div class="bar"><div class="in">
            <span><strong id="answered">0</strong> / {{ $total }} answered</span>
            <div class="track"><i id="track"></i></div>
            <span class="saved" id="saved"></span>
        </div></div>

    <form method="post" action="{{ route('assessment.submit') }}" id="paper" class="paper">
        @csrf
        <div class="eyebrow">{{ $attendant->name }}</div>
        <h1 style="font-size:32px">{{ $assessment->title }}</h1>
        <div class="stay"><strong>Stay on this page.</strong> Leaving it (another tab, window or app) submits your assessment automatically.</div>
        <p class="small">Answer all {{ $total }} questions. For calculations, enter the number only; commas are fine. Your answers save automatically. A final submission cannot be changed.</p>

        @foreach($assessment->modules as $module)
            <section class="module">
                <h2>{{ $module->title }}</h2>
                <div class="meta">{{ $module->questions->count() }} questions</div>

                @foreach($module->questions as $question)
                    @php $n++; $given = $answers[$question->id] ?? ''; @endphp
                    <div class="q">
                        <div class="body"><em>Q{{ $n }}.</em>{{ $question->body }}</div>
                        @if($question->isChoice())
                            @foreach($question->options as $key => $text)
                                <label class="opt {{ $given === $key ? 'on' : '' }}">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" {{ $given === $key ? 'checked' : '' }}>
                                    <span><b>{{ $key }}.</b> {{ $text }}</span>
                                </label>
                            @endforeach
                        @else
                            <div class="num">
                                <input type="text" inputmode="decimal" autocomplete="off" name="answers[{{ $question->id }}]" value="{{ $given }}" placeholder="Your answer">
                                @if($question->unit)<span>{{ $question->unit }}</span>@endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </section>
        @endforeach

        <div class="submitbox">
            <p class="small" id="warn"></p>
            <button type="submit" class="btn" id="submitBtn">Submit final answers</button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        (function () {
            var form = document.getElementById('paper');
            var total = {{ $total }};
            var timer = null, dirty = false, submitting = false;
            var armed = false, left = false, finishing = false;
            var submitUrl = @json(route('assessment.submit'));
            var resultUrl = @json(route('assessment.result'));
            var gate = document.getElementById('gate'), lock = document.getElementById('lock');

            document.body.classList.add('gated');

            function answeredCount() {
                var names = {};
                form.querySelectorAll('input[name^="answers"]').forEach(function (el) {
                    if ((el.type === 'radio' && el.checked) || (el.type === 'text' && el.value.trim() !== '')) { names[el.name] = true; }
                });
                return Object.keys(names).length;
            }

            function refresh() {
                var done = answeredCount();
                document.getElementById('answered').textContent = done;
                document.getElementById('track').style.width = (total ? done / total * 100 : 0) + '%';
                form.querySelectorAll('.opt').forEach(function (l) { l.classList.toggle('on', l.querySelector('input').checked); });
            }

            function save() {
                if (!dirty) { return; }
                dirty = false;
                var label = document.getElementById('saved');
                label.textContent = 'Saving…';
                fetch('{{ route('assessment.save') }}', {
                    method: 'POST', body: new FormData(form), credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                }).then(function (r) { label.textContent = r.ok ? 'Saved' : 'Not saved'; if (!r.ok) { dirty = true; } })
                  .catch(function () { label.textContent = 'Offline - will retry'; dirty = true; });
            }

            function changed() { dirty = true; refresh(); clearTimeout(timer); timer = setTimeout(save, 1200); }

            form.addEventListener('change', changed);
            form.addEventListener('input', function (e) { if (e.target.type === 'text') { changed(); } });
            setInterval(save, 15000);
            window.addEventListener('beforeunload', function (e) { if (dirty && !submitting) { e.preventDefault(); e.returnValue = ''; } });

            // --- "Stay on this page": leaving after the attendant has begun submits automatically ---
            document.getElementById('beginBtn').addEventListener('click', function () {
                gate.hidden = true;
                document.body.classList.remove('gated');
                armed = true;
            });

            function answersData() {
                var fd = new FormData(form);
                fd.set('auto', 'left_page');
                return fd;
            }

            function onLeave() {
                if (!armed || left || submitting) { return; }
                left = true;
                armed = false;
                dirty = false; // answers go out with the submission below; no "leave site?" prompt
                lock.hidden = false;
                document.body.classList.add('gated');
                // sendBeacon still goes out while the page is hidden or closing
                var sent = false;
                try { sent = navigator.sendBeacon && navigator.sendBeacon(submitUrl, answersData()); } catch (e) { sent = false; }
                if (!sent) {
                    fetch(submitUrl, { method: 'POST', body: answersData(), keepalive: true, credentials: 'same-origin' }).catch(function () {});
                }
            }

            // Make sure it is saved, then show the result (also used if the beacon was dropped).
            function finish() {
                if (finishing) { return; }
                finishing = true;
                var btn = document.getElementById('lockBtn');
                btn.disabled = true;
                btn.textContent = 'Opening your result…';
                fetch(submitUrl, { method: 'POST', body: answersData(), credentials: 'same-origin' })
                    .catch(function () {})
                    .then(function () { window.location.href = resultUrl; });
            }

            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'hidden') { onLeave(); }
                else if (left) { finish(); }
            });
            window.addEventListener('blur', onLeave);
            window.addEventListener('focus', function () { if (left) { finish(); } });
            document.getElementById('lockBtn').addEventListener('click', finish);

            form.addEventListener('submit', function (e) {
                var unanswered = total - answeredCount();
                var msg = unanswered > 0
                    ? unanswered + ' question(s) are unanswered. There is no negative marking. Submit anyway? This cannot be changed.'
                    : 'Submit your final answers? This cannot be changed.';
                armed = false; // the confirm box itself takes focus from the page; that is not "leaving"
                if (!confirm(msg)) { e.preventDefault(); armed = true; return; }
                submitting = true;
                document.getElementById('submitBtn').disabled = true;
            });

            refresh();
        })();
    </script>
@endsection
