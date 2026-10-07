@extends('backend.partials.master')

@section('content')
    @php $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.'); @endphp

    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.assessments.show', $assessment->id) }}" class="text-muted small">&larr; {{ $assessment->title }}</a>
                    <div class="d-flex justify-content-between flex-wrap align-items-start mt-1">
                        <div>
                            <h3 class="mb-1">{{ $attendant->name }}
                                @if($attendant->isSubmitted())
                                    <span class="badge badge-{{ $attendant->passed ? 'success' : 'danger' }} rounded align-middle" style="font-size:.5em">{{ $attendant->passed ? 'PASS' : 'FAIL' }}</span>
                                @endif
                            </h3>
                            <p class="text-muted mb-0">
                                {{ $attendant->email ?: 'No email on file' }}@if($attendant->company) &middot; {{ $attendant->company }}@endif
                                &middot; code <code>{{ $attendant->access_code }}</code>
                            </p>
                            @if($attendant->wasAutoSubmitted())
                                <p class="mb-0 mt-2"><span class="badge badge-warning rounded">Auto-submitted</span>
                                    <small class="text-muted">The attendant left the assessment page, so it was submitted automatically with the answers saved so far.</small></p>
                            @endif
                        </div>
                        @if($attendant->isSubmitted())
                            <div class="mt-2">
                                <a href="{{ route('admin.assessments.attendants.pdf', $attendant->id) }}" class="btn btn-primary btn-sm">Download PDF result</a>
                                @if($attendant->passed)
                                    <a href="{{ route('admin.assessments.attendants.certificate', $attendant->id) }}" class="btn btn-success btn-sm">Download certificate</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$attendant->isSubmitted())
        <div class="alert alert-info">This attendant has not submitted yet (status: {{ $attendant->status }}).</div>
    @else
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card"><div class="card-body text-center">
                        <h2 class="mb-0">{{ $fmt($attendant->score) }} / {{ $fmt($attendant->total_marks) }}</h2>
                        <p class="text-muted mb-0">{{ $fmt($attendant->percentage) }}% &middot; pass mark {{ $assessment->pass_mark }}%</p>
                    </div></div>
            </div>
            @foreach($attendant->module_scores as $m)
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card"><div class="card-body">
                            <strong>{{ $m['title'] }}</strong>
                            <h4 class="mb-0 mt-1">{{ $fmt($m['score']) }} / {{ $fmt($m['total']) }}</h4>
                            <small class="text-muted">{{ $m['correct'] }} of {{ $m['questions'] }} correct</small>
                        </div></div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card"><div class="card-body">
                        <h5 class="mb-3">Answer review</h5>
                        <p class="text-muted small">Submitted {{ $attendant->submitted_at->format('d M Y H:i') }}. Marked against the questions as they are now.</p>
                        @foreach($assessment->modules as $module)
                            <h6 class="mt-4">{{ $module->title }}</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead><tr><th style="width:4%">#</th><th>Question</th><th style="width:22%">Their answer</th><th style="width:22%">Correct answer</th><th style="width:7%">Marks</th></tr></thead>
                                    <tbody>
                                    @foreach($module->questions as $question)
                                        @php
                                            $given = ($attendant->answers ?? [])[$question->id] ?? null;
                                            $ok = $question->isCorrect($given);
                                        @endphp
                                        <tr class="{{ $ok ? '' : 'table-danger' }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $question->body }}</td>
                                            <td>{{ $question->answerLabel($given) }}</td>
                                            <td>{{ $question->correctLabel() }}</td>
                                            <td>{{ $ok ? $fmt($assessment->marksFor($question)) : '0' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div></div>
            </div>
        </div>
    @endif
@endsection
