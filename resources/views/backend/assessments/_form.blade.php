{{-- Shared create/edit fields for an assessment. $assessment is null when creating. --}}
@php $v = fn($field, $default = null) => old($field, $assessment->{$field} ?? $default); @endphp
<div class="row">
    <div class="col-md-8 form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $v('title') }}" required>
    </div>
    <div class="col-md-4 form-group">
        <label>Version</label>
        <input type="text" name="version" class="form-control" value="{{ $v('version', '1.0') }}" placeholder="1.0">
    </div>
</div>
<div class="form-group">
    <label>Description (shown to attendants)</label>
    <textarea name="description" class="form-control" rows="3">{{ $v('description') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label>Client / company (optional)</label>
        <select name="client_id" class="form-control">
            <option value="">— None —</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected($v('client_id') == $client->id)>{{ $client->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label>Training session (optional)</label>
        <select name="training_session_id" class="form-control">
            <option value="">— None —</option>
            @foreach($sessions as $session)
                <option value="{{ $session->id }}" @selected($v('training_session_id') == $session->id)>{{ $session->session_title }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-3 form-group">
        <label>Pass mark (%)</label>
        <input type="number" name="pass_mark" class="form-control" min="1" max="100" value="{{ $v('pass_mark', 70) }}" required>
    </div>
    <div class="col-md-3 form-group">
        <label>Marks per question</label>
        <input type="number" step="0.01" name="marks_per_question" class="form-control" value="{{ $v('marks_per_question', 2.5) }}" required>
    </div>
    <div class="col-md-3 form-group">
        <label>Suggested minutes</label>
        <input type="number" name="suggested_minutes" class="form-control" min="1" value="{{ $v('suggested_minutes', 60) }}" required>
    </div>
    <div class="col-md-3 form-group">
        <label>Status</label>
        <select name="status" class="form-control" required>
            @foreach(['Draft', 'Active', 'Closed'] as $status)
                <option value="{{ $status }}" @selected($v('status', 'Draft') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
</div>
<small class="text-muted">Only <strong>Active</strong> assessments accept attendants. Individual questions can override the default marks.</small>
