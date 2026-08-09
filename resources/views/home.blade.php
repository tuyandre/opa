@extends('backend.partials.master')

@section('content')

    <?php
    use App\Constants\VariableConstants;
    use App\Models\TrainingSession;
    use App\Models\TrainingService;
    use App\Models\RegistrationStudent;
    use App\Models\ContactUs;

    $ROOT_FOLDER = url()->to('/') . VariableConstants::ROOT_FOLDER;

    $training_session = TrainingSession::all();
    $services = TrainingService::all();
    $students = RegistrationStudent::all();
    $contact_us = ContactUs::all();

    // Sessions by status (doughnut)
    $statusCounts = TrainingSession::selectRaw('status, count(*) as cnt')->groupBy('status')->pluck('cnt', 'status');
    $sessionStatusLabels = ['Active', 'Inactive', 'Completed'];
    $sessionStatusData = array_map(fn($label) => (int) ($statusCounts[$label] ?? 0), $sessionStatusLabels);

    // Registrations per month, last 6 months (bar)
    $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->startOfMonth());
    $monthlyCounts = RegistrationStudent::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, count(*) as cnt")
        ->where('created_at', '>=', $months->first())
        ->groupBy('ym')
        ->pluck('cnt', 'ym');
    $monthLabels = $months->map(fn($m) => $m->format('M Y'))->all();
    $monthData = $months->map(fn($m) => (int) ($monthlyCounts[$m->format('Y-m')] ?? 0))->all();

    $recentStudents = RegistrationStudent::with('session')->latest()->take(8)->get();
    ?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        Welcome, {{auth()->user()->name}}
                    </h4>
                    <h6 class="font-weight-normal text-muted mb-0">All systems are running smoothly</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card opa-stat-card" style="background: #146c77">
                <div class="card-body">
                    <div class="opa-stat-icon"><i class="mdi mdi-calendar-clock"></i></div>
                    <div>
                        <p class="opa-stat-label">Training Sessions</p>
                        <p class="opa-stat-value">{{$training_session->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card opa-stat-card" style="background: #17808d">
                <div class="card-body">
                    <div class="opa-stat-icon"><i class="mdi mdi-widgets"></i></div>
                    <div>
                        <p class="opa-stat-label">Services</p>
                        <p class="opa-stat-value">{{$services->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card opa-stat-card" style="background: #0c444b">
                <div class="card-body">
                    <div class="opa-stat-icon"><i class="mdi mdi-account-multiple"></i></div>
                    <div>
                        <p class="opa-stat-label">Students Registered</p>
                        <p class="opa-stat-value">{{$students->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card opa-stat-card" style="background: #105861">
                <div class="card-body">
                    <div class="opa-stat-icon"><i class="mdi mdi-email-outline"></i></div>
                    <div>
                        <p class="opa-stat-label">Contact Us</p>
                        <p class="opa-stat-value">{{$contact_us->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Registrations per Month</h5>
                    <canvas id="registrationsChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-4 stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sessions by Status</h5>
                    <canvas id="sessionStatusChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Registrations</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Session</th>
                                <th>Status</th>
                                <th>Registered</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentStudents as $student)
                                <tr>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->session->session_title ?? '-' }}</td>
                                    <td>
                                        @if($student->reply_status == 1)
                                            @if($student->status == 'Accepted')
                                                <span class="badge badge-success">Accepted</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->created_at->format('M j, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No registrations yet.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script>
        // Wait for full 'load' so CSS/fonts have settled, then build the charts.
        // The theme's own sidebar/layout scripts (off-canvas.js, template.js) keep
        // adjusting the main content area's width for a moment after 'load' fires,
        // so Chart.js can still measure a 0-width container at construction time.
        // Chart.js never re-measures on its own without a resize, so force one
        // shortly after creation to pick up the settled layout.
        window.addEventListener('load', function () {
            var registrationsChart = new Chart(document.getElementById('registrationsChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($monthLabels),
                    datasets: [{
                        label: 'Registrations',
                        data: @json($monthData),
                        backgroundColor: '#146c77',
                        borderRadius: 4,
                    }]
                },
                options: {
                    legend: {display: false},
                    scales: {
                        yAxes: [{ticks: {beginAtZero: true, precision: 0}}]
                    }
                }
            });

            var sessionStatusChart = new Chart(document.getElementById('sessionStatusChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json($sessionStatusLabels),
                    datasets: [{
                        data: @json($sessionStatusData),
                        backgroundColor: ['#146c77', '#9aa1a6', '#e50031'],
                    }]
                },
                options: {
                    legend: {position: 'bottom'}
                }
            });

            setTimeout(function () {
                registrationsChart.resize();
                sessionStatusChart.resize();
            }, 350);
        });
    </script>
@endsection
