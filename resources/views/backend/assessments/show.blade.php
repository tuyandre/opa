@extends('backend.partials.master')

@section('content')
    @php
        $statusClass = ['Active' => 'success', 'Closed' => 'danger', 'Draft' => 'warning'][$assessment->status] ?? 'secondary';
        $totalMarks = $assessment->totalMarks();
        $activeTab = session('tab', request('tab', 'attendants'));
    @endphp

    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-wrap align-items-start">
                        <div>
                            <a href="{{ route('admin.assessments.index') }}" class="text-muted small">&larr; All assessments</a>
                            <h3 class="mt-1 mb-1">{{ $assessment->title }}
                                <span class="badge badge-{{ $statusClass }} rounded align-middle" style="font-size:.5em">{{ $assessment->status }}</span>
                            </h3>
                            <p class="text-muted mb-0">
                                {{ $assessment->questions->count() }} questions &middot; {{ rtrim(rtrim(number_format($totalMarks, 2), '0'), '.') }} marks
                                &middot; pass mark {{ $assessment->pass_mark }}% &middot; {{ $assessment->suggested_minutes }} min suggested
                                @if($assessment->client) &middot; {{ $assessment->client->name }} @endif
                            </p>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#settingsModal">Settings</button>
                            <a href="{{ route('admin.assessments.export', $assessment->id) }}" class="btn btn-outline-primary btn-sm">Export CSV</a>
                            <a href="{{ route('admin.assessments.report', $assessment->id) }}" class="btn btn-primary btn-sm">Download PDF report</a>
                        </div>
                    </div>

                    <div class="input-group mt-3">
                        <div class="input-group-prepend"><span class="input-group-text">Attendant link</span></div>
                        <input type="text" class="form-control" id="publicLink" readonly value="{{ $assessment->publicUrl() }}">
                        <div class="input-group-append"><button class="btn btn-outline-primary" type="button" id="copyLink">Copy</button></div>
                    </div>
                    @if(!$assessment->isOpen())
                        <small class="text-danger">This assessment is {{ $assessment->status }}. Set it to Active in Settings so attendants can start.</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row">
        @foreach([
            ['Invited', $stats['invited']],
            ['Submitted', $stats['submitted']],
            ['Passed', $stats['passed']],
            ['Failed', $stats['failed']],
            ['Average score', $stats['average'] !== null ? $stats['average'] . '%' : '—'],
            ['Pass rate', $stats['pass_rate'] !== null ? $stats['pass_rate'] . '%' : '—'],
        ] as [$label, $value])
            <div class="col-6 col-md-2 grid-margin stretch-card">
                <div class="card"><div class="card-body text-center py-3">
                        <h3 class="mb-0">{{ $value }}</h3>
                        <small class="text-muted">{{ $label }}</small>
                    </div></div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link {{ $activeTab === 'attendants' ? 'active' : '' }}" data-toggle="tab" href="#tab-attendants">Attendants &amp; results ({{ $assessment->attendants->count() }})</a></li>
                        <li class="nav-item"><a class="nav-link {{ $activeTab === 'questions' ? 'active' : '' }}" data-toggle="tab" href="#tab-questions">Modules &amp; questions ({{ $assessment->questions->count() }})</a></li>
                        <li class="nav-item"><a class="nav-link {{ $activeTab === 'summary' ? 'active' : '' }}" data-toggle="tab" href="#tab-summary">Summary</a></li>
                    </ul>

                    <div class="tab-content pt-4" style="border:0;padding-left:0;padding-right:0">

                        {{-- ================= Attendants & results ================= --}}
                        <div class="tab-pane fade {{ $activeTab === 'attendants' ? 'show active' : '' }}" id="tab-attendants">
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#attendantModal">Add attendant</button>
                                <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#bulkModal">Add several at once</button>
                                <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#importModal">Import from Excel</button>
                                @php $pendingInvites = $assessment->attendants->filter(fn($a) => $a->email && !$a->invited_at && !$a->isSubmitted())->count(); @endphp
                                <form action="{{ route('admin.assessments.attendants.send', $assessment->id) }}" method="post" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="mode" value="pending">
                                    <button type="submit" class="btn btn-success btn-sm" @disabled($pendingInvites === 0)>Email invitations ({{ $pendingInvites }} not yet sent)</button>
                                </form>
                                <form action="{{ route('admin.assessments.attendants.send', $assessment->id) }}" method="post" class="d-inline"
                                      onsubmit="return confirm('Send the invitation email again to every attendant who has not submitted?');">
                                    @csrf
                                    <input type="hidden" name="mode" value="all">
                                    <button type="submit" class="btn btn-outline-success btn-sm">Resend to all</button>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Attendant</th>
                                        <th>Access code</th>
                                        <th>Status</th>
                                        <th>Score</th>
                                        <th>Result</th>
                                        <th>Submitted</th>
                                        <th style="width:1%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($assessment->attendants as $a)
                                        <tr>
                                            <td>
                                                <strong>{{ $a->name }}</strong>
                                                <br><small class="text-muted">{{ $a->email ?: 'No email on file' }}@if($a->company) &middot; {{ $a->company }}@endif</small>
                                                @if($a->email)
                                                    <br><small class="{{ $a->invited_at ? 'text-success' : 'text-muted' }}">{{ $a->invited_at ? 'Invited ' . $a->invited_at->format('d M H:i') : 'Not invited yet' }}</small>
                                                @endif
                                            </td>
                                            <td><code>{{ $a->access_code }}</code></td>
                                            <td>{{ $a->status }}</td>
                                            <td>
                                                @if($a->isSubmitted())
                                                    {{ rtrim(rtrim(number_format($a->score, 2), '0'), '.') }} / {{ rtrim(rtrim(number_format($a->total_marks, 2), '0'), '.') }}
                                                    <small class="text-muted">({{ rtrim(rtrim(number_format($a->percentage, 2), '0'), '.') }}%)</small>
                                                @else — @endif
                                            </td>
                                            <td>
                                                @if($a->isSubmitted())
                                                    <span class="badge badge-{{ $a->passed ? 'success' : 'danger' }} rounded">{{ $a->passed ? 'PASS' : 'FAIL' }}</span>
                                                    @if($a->wasAutoSubmitted())
                                                        <span class="badge badge-warning rounded" title="The attendant left the assessment page, so it was submitted automatically">Auto-submitted</span>
                                                    @endif
                                                @else — @endif
                                            </td>
                                            <td>{{ $a->submitted_at ? $a->submitted_at->format('d M Y H:i') : '—' }}</td>
                                            <td class="text-nowrap">
                                                @if($a->isSubmitted())
                                                    <a href="{{ route('admin.assessments.attendants.result', $a->id) }}" class="btn btn-primary btn-sm">View</a>
                                                    <a href="{{ route('admin.assessments.attendants.pdf', $a->id) }}" class="btn btn-outline-primary btn-sm">PDF</a>
                                                @endif
                                                @if($a->email && !$a->isSubmitted())
                                                    <button class="btn btn-outline-success btn-sm js-post" data-url="{{ route('admin.assessments.attendants.send-one', $a->id) }}"
                                                            data-title="{{ $a->invited_at ? 'Send the invitation again?' : 'Send invitation?' }}" data-text="Email the link and access code to {{ $a->email }}.">Email</button>
                                                @endif
                                                @if($a->status !== 'Not started')
                                                    <button class="btn btn-outline-warning btn-sm js-post" data-url="{{ route('admin.assessments.attendants.reset', $a->id) }}"
                                                            data-title="Reset this attempt?" data-text="{{ $a->name }}'s answers and score will be erased and the same code can be used again.">Reset</button>
                                                @endif
                                                <button class="btn btn-outline-danger btn-sm js-post" data-url="{{ route('admin.assessments.attendants.delete', $a->id) }}"
                                                        data-title="Remove attendant?" data-text="{{ $a->name }} and any result will be deleted.">Remove</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center text-muted">No attendants yet. Add them to generate personal access codes.</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= Modules & questions ================= --}}
                        <div class="tab-pane fade {{ $activeTab === 'questions' ? 'show active' : '' }}" id="tab-questions">
                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#moduleModal" id="addModuleBtn">Add module</button>
                            </div>

                            @forelse($assessment->modules as $module)
                                <div class="card mb-3" style="border:1px solid #dee2e6">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <h5 class="mb-0">{{ $loop->iteration }}. {{ $module->title }}
                                                <small class="text-muted">
                                                    {{ $module->questions->count() }} questions &middot;
                                                    {{ rtrim(rtrim(number_format($module->questions->sum(fn($q) => $assessment->marksFor($q)), 2), '0'), '.') }} marks
                                                </small>
                                            </h5>
                                            <div>
                                                <button class="btn btn-primary btn-sm js-add-question" data-url="{{ route('admin.assessments.questions.store', $module->id) }}" data-module="{{ $module->title }}">Add question</button>
                                                <button class="btn btn-outline-primary btn-sm js-edit-module" data-url="{{ route('admin.assessments.modules.update', $module->id) }}" data-title="{{ $module->title }}">Rename</button>
                                                <button class="btn btn-outline-danger btn-sm js-post" data-url="{{ route('admin.assessments.modules.delete', $module->id) }}"
                                                        data-title="Delete module?" data-text="'{{ $module->title }}' and its {{ $module->questions->count() }} question(s) will be deleted.">Delete</button>
                                            </div>
                                        </div>

                                        @if($module->questions->isNotEmpty())
                                            <div class="table-responsive mt-3">
                                                <table class="table table-sm mb-0">
                                                    <tbody>
                                                    @foreach($module->questions as $question)
                                                        <tr>
                                                            <td style="width:3%"><strong>{{ $loop->iteration }}</strong></td>
                                                            <td>
                                                                {{ $question->body }}
                                                                <div class="small text-muted mt-1">
                                                                    @if($question->isChoice())
                                                                        @foreach($question->options as $key => $text)
                                                                            <span class="{{ $key === $question->correct_answer ? 'text-success font-weight-bold' : '' }}">{{ $key }}. {{ $text }}</span>@if(!$loop->last) &nbsp;|&nbsp; @endif
                                                                        @endforeach
                                                                    @else
                                                                        Numeric answer: <strong class="text-success">{{ $question->correctLabel() }}</strong>
                                                                        @if((float) $question->tolerance > 0.01) (&plusmn;{{ rtrim(rtrim(number_format($question->tolerance, 4), '0'), '.') }}) @endif
                                                                    @endif
                                                                    @if($question->marks !== null) &middot; {{ rtrim(rtrim(number_format($question->marks, 2), '0'), '.') }} marks @endif
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap text-muted small" style="width:1%">
                                                                @if(($stats['question_rates'][$question->id] ?? null) !== null)
                                                                    {{ $stats['question_rates'][$question->id] }}% correct
                                                                @endif
                                                            </td>
                                                            <td class="text-nowrap" style="width:1%">
                                                                <button class="btn btn-outline-primary btn-sm js-edit-question"
                                                                        data-url="{{ route('admin.assessments.questions.update', $question->id) }}"
                                                                        data-module="{{ $module->title }}"
                                                                        data-question="{{ json_encode([
                                                                            'type' => $question->type, 'body' => $question->body, 'options' => $question->options,
                                                                            'correct' => $question->correct_answer, 'tolerance' => (float) $question->tolerance,
                                                                            'unit' => $question->unit, 'marks' => $question->marks,
                                                                        ]) }}">Edit</button>
                                                                <button class="btn btn-outline-danger btn-sm js-post" data-url="{{ route('admin.assessments.questions.delete', $question->id) }}"
                                                                        data-title="Delete question?" data-text="This cannot be undone.">&times;</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted mt-3 mb-0">No questions in this module yet.</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No modules yet. Add a module (a topic such as "Accounting fundamentals"), then add its questions.</p>
                            @endforelse
                            @if($stats['submitted'] > 0)
                                <small class="text-muted">Editing a question after attendants have submitted does not change their saved scores.</small>
                            @endif
                        </div>

                        {{-- ================= Summary ================= --}}
                        <div class="tab-pane fade {{ $activeTab === 'summary' ? 'show active' : '' }}" id="tab-summary">
                            @if($stats['submitted'] === 0)
                                <p class="text-muted">The summary appears once the first attendant submits.</p>
                            @else
                                <p>
                                    <strong>{{ $stats['submitted'] }}</strong> of {{ $stats['invited'] }} attendants submitted.
                                    <strong>{{ $stats['passed'] }}</strong> passed and <strong>{{ $stats['failed'] }}</strong> failed
                                    ({{ $stats['pass_rate'] }}% pass rate at {{ $assessment->pass_mark }}%).
                                    Scores range from {{ $stats['lowest'] }}% to {{ $stats['highest'] }}%, average {{ $stats['average'] }}%.
                                </p>
                                <h6 class="mt-4">Average score by module</h6>
                                @foreach($stats['modules'] as $m)
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between"><span>{{ $m['title'] }}</span><strong>{{ $m['average_pct'] !== null ? $m['average_pct'] . '%' : '—' }}</strong></div>
                                        <div class="progress" style="height:8px"><div class="progress-bar {{ ($m['average_pct'] ?? 0) >= $assessment->pass_mark ? 'bg-success' : 'bg-danger' }}" style="width: {{ $m['average_pct'] ?? 0 }}%"></div></div>
                                    </div>
                                @endforeach
                                <p class="mt-4 mb-0 text-muted">Use <strong>Download PDF report</strong> for the full ranked results, or <strong>Export CSV</strong> for Excel.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Settings modal --}}
    <div class="modal fade" id="settingsModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.assessments.update', $assessment->id) }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Assessment settings</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">@include('backend.assessments._form')</div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Module modal (add + rename) --}}
    <div class="modal fade" id="moduleModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.assessments.modules.store', $assessment->id) }}" method="post" id="moduleForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="moduleModalTitle">New module</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Module title</label>
                            <input type="text" name="title" id="moduleTitle" class="form-control" placeholder="e.g. Accounting fundamentals" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Question modal (add + edit) --}}
    <div class="modal fade" id="questionModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="post" id="questionForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="questionModalTitle">Question</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Question type</label>
                                <select name="type" id="qType" class="form-control">
                                    <option value="choice">Multiple choice</option>
                                    <option value="number">Calculation (number)</option>
                                </select>
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Marks (leave empty for the default {{ rtrim(rtrim(number_format($assessment->marks_per_question, 2), '0'), '.') }})</label>
                                <input type="number" step="0.01" name="marks" id="qMarks" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Question</label>
                            <textarea name="body" id="qBody" class="form-control" rows="3" required></textarea>
                        </div>

                        <div id="choiceFields">
                            @foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $key)
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_choice" value="{{ $key }}" class="mr-2 q-correct" id="correct{{ $key }}">
                                            <label for="correct{{ $key }}" class="mb-0"><strong>{{ $key }}</strong></label>
                                        </div>
                                    </div>
                                    <input type="text" name="options[{{ $key }}]" class="form-control q-option" placeholder="Option {{ $key }}{{ $loop->index >= 4 ? ' (optional)' : '' }}">
                                </div>
                            @endforeach
                            <small class="text-muted">Tick the radio button next to the correct option. Leave unused options empty.</small>
                        </div>

                        <div id="numberFields" style="display:none">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Correct answer</label>
                                    <input type="text" name="correct_number" id="qNumber" class="form-control" placeholder="e.g. 11000000">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Accepted +/- difference</label>
                                    <input type="number" step="any" min="0" name="tolerance" id="qTolerance" class="form-control" value="0.01">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Unit shown to attendant</label>
                                    <input type="text" name="unit" id="qUnit" class="form-control" placeholder="RWF, %, ratio">
                                </div>
                            </div>
                            <small class="text-muted">Commas, spaces and unit text typed by the attendant are ignored when marking.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save question</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Attendant modal --}}
    <div class="modal fade" id="attendantModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.assessments.attendants.store', $assessment->id) }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add attendant</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"><label>Full name</label><input type="text" name="name" class="form-control" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" placeholder="Used to check the code on sign-in"></div>
                        <div class="form-group"><label>Company</label><input type="text" name="company" class="form-control"></div>
                        <small class="text-muted">A personal access code (OPA-XXXXXX) is generated automatically. Share it privately with the attendant.</small>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Excel import modal --}}
    <div class="modal fade" id="importModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.assessments.attendants.import', $assessment->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import attendants from Excel</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <ol class="pl-3">
                            <li class="mb-2"><a href="{{ route('admin.assessments.attendants.template', $assessment->id) }}" class="btn btn-outline-primary btn-sm">Download Excel template</a></li>
                            <li class="mb-2">Fill in one person per row: full name, email, company.</li>
                            <li>Upload it below. You will see a preview first, then confirm to add everyone and email their link and code.</li>
                        </ol>
                        <div class="form-group mt-3">
                            <label>Excel file (.xlsx or .csv)</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload and preview</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk attendants modal --}}
    <div class="modal fade" id="bulkModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.assessments.attendants.bulk', $assessment->id) }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add several attendants</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>One attendant per line: name, email, company</label>
                            <textarea name="list" class="form-control" rows="8" placeholder="Jane Uwase, jane@company.com, Acme Ltd&#10;Eric Habimana, eric@company.com"></textarea>
                        </div>
                        <small class="text-muted">Email and company are optional. Each attendant gets their own access code.</small>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add all</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form id="postForm" method="post" style="display:none">@csrf</form>
@endsection

@section('scripts')
    <script>
        $(function () {
            // Copy the public link
            $('#copyLink').on('click', function () {
                var input = document.getElementById('publicLink');
                input.select();
                (navigator.clipboard ? navigator.clipboard.writeText(input.value) : Promise.resolve(document.execCommand('copy')))
                    .then(function () { $('#copyLink').text('Copied'); setTimeout(function () { $('#copyLink').text('Copy'); }, 1500); });
            });

            // Confirm-then-POST for deletes and resets
            $(document).on('click', '.js-post', function () {
                var url = $(this).data('url');
                Swal.fire({
                    title: $(this).data('title'), text: $(this).data('text'), icon: 'warning',
                    showCancelButton: true, confirmButtonText: 'Yes, continue', reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) { $('#postForm').attr('action', url).submit(); }
                });
            });

            // Module modal
            var addModuleUrl = $('#moduleForm').attr('action');
            $('#addModuleBtn').on('click', function () {
                $('#moduleForm').attr('action', addModuleUrl); $('#moduleTitle').val(''); $('#moduleModalTitle').text('New module');
            });
            $(document).on('click', '.js-edit-module', function () {
                $('#moduleForm').attr('action', $(this).data('url')); $('#moduleTitle').val($(this).data('title'));
                $('#moduleModalTitle').text('Rename module'); $('#moduleModal').modal('show');
            });

            // Question modal
            function showType() {
                var isChoice = $('#qType').val() === 'choice';
                $('#choiceFields').toggle(isChoice); $('#numberFields').toggle(!isChoice);
            }
            $('#qType').on('change', showType);

            function resetQuestionForm() {
                $('#questionForm')[0].reset(); $('.q-correct').prop('checked', false);
                $('#qTolerance').val('0.01'); showType();
            }

            $(document).on('click', '.js-add-question', function () {
                resetQuestionForm();
                $('#questionForm').attr('action', $(this).data('url'));
                $('#questionModalTitle').text('Add question to ' + $(this).data('module'));
                $('#questionModal').modal('show');
            });

            $(document).on('click', '.js-edit-question', function () {
                var q = $(this).data('question');
                resetQuestionForm();
                $('#questionForm').attr('action', $(this).data('url'));
                $('#questionModalTitle').text('Edit question in ' + $(this).data('module'));
                $('#qType').val(q.type); $('#qBody').val(q.body); $('#qMarks').val(q.marks);
                if (q.type === 'choice') {
                    $.each(q.options || {}, function (key, text) { $('input[name="options[' + key + ']"]').val(text); });
                    $('#correct' + q.correct).prop('checked', true);
                } else {
                    $('#qNumber').val(q.correct); $('#qTolerance').val(q.tolerance); $('#qUnit').val(q.unit);
                }
                showType();
                $('#questionModal').modal('show');
            });
        });
    </script>
@endsection
