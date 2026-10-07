@extends('backend.partials.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.assessments.show', $assessment->id) }}" class="text-muted small">&larr; {{ $assessment->title }}</a>
                    <h3 class="mt-1">Confirm attendants</h3>
                    <p class="text-muted">
                        <strong>{{ $valid }}</strong> of {{ count($rows) }} rows are ready to add.
                        @if($valid < count($rows)) Rows with a problem are skipped. Fix them in Excel and upload again if needed. @endif
                    </p>

                    @if(!$assessment->isOpen())
                        <div class="alert alert-warning">This assessment is <strong>{{ $assessment->status }}</strong>. Emails will go out, but attendants cannot start until you set it to Active in Settings.</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead><tr><th style="width:4%">#</th><th>Full name</th><th>Email</th><th>Company</th><th>Check</th></tr></thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr class="{{ $row['problem'] ? 'table-danger' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row['name'] }}</td>
                                    <td>{{ $row['email'] }}</td>
                                    <td>{{ $row['company'] }}</td>
                                    <td>@if($row['problem']) {{ $row['problem'] }} @else <span class="text-success">Ready</span> @endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <form action="{{ route('admin.assessments.attendants.import.confirm', $assessment->id) }}" method="post" class="mt-3">
                        @csrf
                        <div class="form-check mb-3">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="send_emails" value="1" checked>
                                Email each new attendant their full assessment link and personal access code
                            </label>
                        </div>
                        <a href="{{ route('admin.assessments.show', $assessment->id) }}" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary" @disabled($valid === 0)>Confirm and add {{ $valid }} attendant(s)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
