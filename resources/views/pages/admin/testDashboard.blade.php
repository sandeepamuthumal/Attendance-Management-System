@extends('layouts.app')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2>Admin Dashboard</h2>
                    <p class="mb-0 text-title-gray">Welcome back! Let's start from where you left.</p>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Advanced Filters --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">
                                        <i class="fas fa-calendar-alt me-1"></i>Date Range
                                    </label>
                                    <select name="date_range" class="form-select form-select-sm" id="dateRange">
                                        <option value="today" selected>Today</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="this_week">This Week</option>
                                        <option value="last_week">Last Week</option>
                                        <option value="this_month">This Month</option>
                                        <option value="last_month">Last Month</option>
                                        <option value="custom">Custom Range</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">
                                        <i class="fas fa-chalkboard me-1"></i>Class
                                    </label>
                                    <select name="class_id" class="form-select form-select-sm" id="classFilter">
                                        <option value="">All Classes</option>
                                        @foreach ($classes ?? [] as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small text-muted mb-1">
                                        <i class="fas fa-book me-1"></i>Subject
                                    </label>
                                    <select name="subject" class="form-select form-select-sm" id="subjectFilter">
                                        <option value="">All Subjects</option>
                                        @foreach ($subjects ?? [] as $subject)
                                            <option value="{{ $subject }}">{{ $subject }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-filter me-1"></i>Apply Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI Cards with Trend Indicators --}}
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 kpi-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="kpi-icon bg-primary-light">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <span class="badge bg-success-light text-success">
                                <i class="fas fa-arrow-up"></i> {{ $stats['trends']['students'] ?? '0' }}%
                            </span>
                        </div>
                        <h6 class="text-muted mb-1">Total Students</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['overview']['total_students'] }}</h2>
                        <small class="text-muted">
                            <i class="fas fa-user-plus me-1"></i>
                            +{{ $stats['new_students'] ?? 0 }} this month
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 kpi-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="kpi-icon bg-success-light">
                                <i class="fas fa-chalkboard-teacher text-success"></i>
                            </div>
                            <span class="badge bg-info-light text-info">
                                <i class="fas fa-equals"></i> 0%
                            </span>
                        </div>
                        <h6 class="text-muted mb-1">Active Classes</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['overview']['total_classes'] }}</h2>
                        <small class="text-muted">
                            <i class="fas fa-calendar-day me-1"></i>
                            {{ $stats['classes_today'] ?? 0 }} scheduled today
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 kpi-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="kpi-icon bg-info-light">
                                <i class="fas fa-user-graduate text-info"></i>
                            </div>
                            <span class="badge bg-success-light text-success">
                                <i class="fas fa-arrow-up"></i> {{ $stats['trends']['enrollments'] ?? '0' }}%
                            </span>
                        </div>
                        <h6 class="text-muted mb-1">Total Enrollments</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['overview']['total_enrollments'] }}</h2>
                        <small class="text-muted">
                            <i class="fas fa-percentage me-1"></i>
                            {{ $stats['enrollment_rate'] ?? 0 }}% capacity
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100 kpi-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="kpi-icon bg-warning-light">
                                <i class="fas fa-calendar-check text-warning"></i>
                            </div>
                            <span
                                class="badge {{ ($stats['today_attendance']['attendance_rate'] ?? 0) >= 75 ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }}">
                                {{ $stats['today_attendance']['attendance_rate'] ?? 0 }}%
                            </span>
                        </div>
                        <h6 class="text-muted mb-1">Today's Attendance</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['today_attendance']['present_today'] ?? 0 }}</h2>
                        <small class="text-muted">
                            <i class="fas fa-users me-1"></i>
                            of {{ $stats['today_attendance']['total_students'] ?? 0 }} students
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Analytics Row --}}
        <div class="row mb-4">
            {{-- Attendance Trend Chart --}}
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-chart-line text-primary me-2"></i>Attendance Analytics
                                </h5>
                                <small class="text-muted">Daily attendance trends and patterns</small>
                            </div>
                            <div class="btn-group btn-group-sm" role="group">
                                <input type="radio" class="btn-check" name="chartView" id="daily" checked>
                                <label class="btn btn-outline-primary" for="daily">Daily</label>

                                <input type="radio" class="btn-check" name="chartView" id="weekly">
                                <label class="btn btn-outline-primary" for="weekly">Weekly</label>

                                <input type="radio" class="btn-check" name="chartView" id="monthly">
                                <label class="btn btn-outline-primary" for="monthly">Monthly</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceTrendChart" height="80"></canvas>

                        {{-- Statistics Summary --}}
                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-4 text-center">
                                <div class="stat-box">
                                    <h4 class="mb-0 text-success">{{ $stats['analytics']['avg_present'] ?? 0 }}%</h4>
                                    <small class="text-muted">Avg. Present</small>
                                </div>
                            </div>
                            <div class="col-4 text-center border-start">
                                <div class="stat-box">
                                    <h4 class="mb-0 text-danger">{{ $stats['analytics']['avg_absent'] ?? 0 }}%</h4>
                                    <small class="text-muted">Avg. Absent</small>
                                </div>
                            </div>
                            <div class="col-4 text-center border-start">
                                <div class="stat-box">
                                    <h4 class="mb-0 text-primary">{{ $stats['analytics']['peak_day'] ?? 'N/A' }}</h4>
                                    <small class="text-muted">Peak Day</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance Distribution Pie Chart --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-pie text-success me-2"></i>Today's Distribution
                        </h5>
                        <small class="text-muted">Real-time attendance breakdown</small>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <canvas id="attendancePieChart" height="200"></canvas>
                        </div>

                        {{-- Legend --}}
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="legend-dot bg-success me-2"></span>
                                    <span class="small">Present</span>
                                </div>
                                <strong
                                    class="text-success">{{ $stats['today_attendance']['present_today'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="legend-dot bg-danger me-2"></span>
                                    <span class="small">Absent</span>
                                </div>
                                <strong class="text-danger">{{ $stats['today_attendance']['absent_today'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="legend-dot bg-warning me-2"></span>
                                    <span class="small">Late</span>
                                </div>
                                <strong class="text-warning">{{ $stats['today_attendance']['late_today'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Class Performance & Recent Activity --}}
        <div class="row mb-4">
            {{-- Top Performing Classes --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-trophy text-warning me-2"></i>Class Performance
                                </h5>
                                <small class="text-muted">Ranked by attendance rate</small>
                            </div>
                            <span class="badge bg-primary">Top 5</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (!empty($stats['class_attendance']))
                            @foreach ($stats['class_attendance'] as $index => $class)
                                <div class="class-performance-item mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="rank-badge me-3">
                                            <span
                                                class="badge {{ $index == 0 ? 'bg-warning' : ($index == 1 ? 'bg-secondary' : 'bg-bronze') }}">
                                                #{{ $index + 1 }}
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $class['class_name'] }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-book me-1"></i>{{ $class['subject'] }} •
                                                <i class="fas fa-layer-group me-1"></i>{{ $class['grade'] }}
                                            </small>
                                        </div>
                                        <div class="text-end">
                                            <h5
                                                class="mb-0 {{ $class['attendance_rate'] >= 80 ? 'text-success' : ($class['attendance_rate'] >= 60 ? 'text-warning' : 'text-danger') }}">
                                                {{ $class['attendance_rate'] }}%
                                            </h5>
                                            <small
                                                class="text-muted">{{ $class['present_today'] }}/{{ $class['total_students'] }}</small>
                                        </div>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar {{ $class['attendance_rate'] >= 80 ? 'bg-success' : ($class['attendance_rate'] >= 60 ? 'bg-warning' : 'bg-danger') }}"
                                            style="width: {{ $class['attendance_rate'] }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No class data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Recent Attendance Activity --}}
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-clock text-info me-2"></i>Live Activity Feed
                                </h5>
                                <small class="text-muted">Real-time attendance updates</small>
                            </div>
                            <span class="badge bg-success pulse-badge">
                                <i class="fas fa-circle"></i> Live
                            </span>
                        </div>
                    </div>
                    <div class="card-body activity-feed">
                        @if (!empty($stats['recent_attendance']))
                            @foreach ($stats['recent_attendance'] as $attendance)
                                <div class="activity-item">
                                    <div class="activity-icon bg-success-light">
                                        <i class="fas fa-user-check text-success"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-0">{{ $attendance['student_name'] }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-id-card me-1"></i>{{ $attendance['student_id'] }}
                                                </small>
                                            </div>
                                            <small class="text-muted">{{ $attendance['time'] }}</small>
                                        </div>
                                        <div class="mt-1">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-chalkboard me-1"></i>{{ $attendance['class_name'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Heatmap & Quick Stats --}}
        <div class="row mb-4">
            {{-- Attendance Heatmap --}}
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-fire text-danger me-2"></i>Weekly Attendance Heatmap
                        </h5>
                        <small class="text-muted">Hourly attendance patterns across the week</small>
                    </div>
                    <div class="card-body">
                        <canvas id="attendanceHeatmap" height="60"></canvas>
                    </div>
                </div>
            </div>

            {{-- Quick Stats Cards --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-success-light me-3">
                                <i class="fas fa-award text-success fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1">Perfect Attendance</h6>
                                <h3 class="mb-0">{{ $stats['perfect_attendance'] ?? 0 }}</h3>
                                <small class="text-muted">Students this month</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-danger-light me-3">
                                <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1">At Risk Students</h6>
                                <h3 class="mb-0">{{ $stats['at_risk_students'] ?? 0 }}</h3>
                                <small class="text-muted">
                                    < 75% attendance</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-info-light me-3">
                                <i class="fas fa-clock text-info fa-2x"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-muted mb-1">Avg. Check-in Time</h6>
                                <h3 class="mb-0">{{ $stats['avg_checkin_time'] ?? '8:15 AM' }}</h3>
                                <small class="text-muted">Daily average</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('attendance.scanner') }}" class="btn btn-primary w-100 py-3">
                                    <i class="fas fa-qrcode fa-2x d-block mb-2"></i>
                                    <span class="fw-bold">Mark Attendance</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('attendance.reports') }}" class="btn btn-info w-100 py-3">
                                    <i class="fas fa-file-download fa-2x d-block mb-2"></i>
                                    <span class="fw-bold">Export Reports</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('admin.students.create') }}" class="btn btn-success w-100 py-3">
                                    <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                                    <span class="fw-bold">Add Student</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ url('admin/classes') }}" class="btn btn-warning w-100 py-3">
                                    <i class="fas fa-cog fa-2x d-block mb-2"></i>
                                    <span class="fw-bold">Manage Classes</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('css')
    <style>
        :root {
            --primary-light: #e3f2fd;
            --success-light: #e8f5e9;
            --info-light: #e0f7fa;
            --warning-light: #fff3e0;
            --danger-light: #ffebee;
        }

        .card {
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        /* KPI Cards */
        .kpi-card .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .bg-primary-light {
            background-color: var(--primary-light);
        }

        .bg-success-light {
            background-color: var(--success-light);
        }

        .bg-info-light {
            background-color: var(--info-light);
        }

        .bg-warning-light {
            background-color: var(--warning-light);
        }

        .bg-danger-light {
            background-color: var(--danger-light);
        }

        /* Activity Feed */
        .activity-feed {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-content {
            flex-grow: 1;
        }

        /* Pulse Animation */
        .pulse-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        /* Legend Dot */
        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Class Performance */
        .class-performance-item {
            padding: 12px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .bg-bronze {
            background-color: #cd7f32;
        }

        /* Stat Icons */
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .kpi-card h2 {
                font-size: 1.5rem;
            }

            .activity-feed {
                max-height: 300px;
            }
        }

        /* Scrollbar Styling */
        .activity-feed::-webkit-scrollbar {
            width: 6px;
        }

        .activity-feed::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .activity-feed::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .activity-feed::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // Pusher Real-time Updates
        Pusher.logToConsole = false;

        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
        });

        var channel = pusher.subscribe('attendance-channel');
        channel.bind('AttendanceMarked', function(data) {
            // Update dashboard in real-time
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: `${data.student_name} marked attendance`,
                text: `at ${data.time}`,
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });

            // Reload stats (you can make this more efficient with Livewire)
            setTimeout(() => location.reload(), 2000);
        });

        // Chart.js Configurations
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#6c757d';

        // Attendance Trend Chart
        const trendCtx = document.getElementById('attendanceTrendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['weekly_attendance']['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!},
                datasets: [{
                    label: 'Present',
                    data: {!! json_encode($stats['weekly_attendance']['present'] ?? [15, 18, 16, 20, 19, 12, 8]) !!},
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#28a745',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }, {
                    label: 'Absent',
                    data: {!! json_encode($stats['weekly_attendance']['absent'] ?? [6, 3, 5, 1, 2, 9, 13]) !!},
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#dc3545',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }, {
                    label: 'Late',
                    data: {!! json_encode($stats['weekly_attendance']['late'] ?? [2, 1, 1, 0, 1, 1, 0]) !!},
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#ffc107',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' students';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                            callback: function(value) {
                                return value;
                            }
                        },
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Attendance Pie Chart
        const pieCtx = document.getElementById('attendancePieChart').getContext('2d');
        const pieChart = new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    data: [
                        {{ $stats['today_attendance']['present_today'] ?? 0 }},
                        {{ $stats['today_attendance']['absent_today'] ?? 0 }},
                        {{ $stats['today_attendance']['late_today'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Attendance Heatmap (Bar Chart representation)
        const heatmapCtx = document.getElementById('attendanceHeatmap').getContext('2d');
        const heatmapChart = new Chart(heatmapCtx, {
            type: 'bar',
            data: {
                labels: ['8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00'],
                datasets: [{
                    label: 'Monday',
                    data: [18, 20, 19, 21, 15, 18, 17, 16, 12],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }, {
                    label: 'Tuesday',
                    data: [19, 21, 20, 20, 16, 19, 18, 17, 13],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                }, {
                    label: 'Wednesday',
                    data: [17, 19, 18, 19, 14, 17, 16, 15, 11],
                    backgroundColor: 'rgba(255, 206, 86, 0.6)',
                }, {
                    label: 'Thursday',
                    data: [20, 21, 21, 22, 17, 20, 19, 18, 14],
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                }, {
                    label: 'Friday',
                    data: [19, 20, 19, 20, 16, 18, 17, 16, 13],
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ' at ' + context.label + ': ' + context.parsed
                                    .y + ' students';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: false,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        stacked: false,
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart View Switcher
        document.querySelectorAll('input[name="chartView"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const view = this.id;
                // You can implement AJAX call here to load different data
                console.log('Switching to ' + view + ' view');

                // Example: Update chart with new data
                // trendChart.data.labels = newLabels;
                // trendChart.data.datasets[0].data = newData;
                // trendChart.update();
            });
        });

        // Filter Form Auto-submit
        document.getElementById('filterForm').addEventListener('change', function(e) {
            if (e.target.id !== 'dateRange' || e.target.value !== 'custom') {
                // Auto-submit for quick filtering (optional)
                // this.submit();
            }
        });

        // Real-time Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour12: true,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            // You can display this in your header if needed
        }
        setInterval(updateClock, 1000);

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading animation when filtering
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function() {
                const btn = this.querySelector('button[type="submit"]');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
                btn.disabled = true;
            });
        }
    </script>
@endsection
