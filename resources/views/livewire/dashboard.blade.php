<div>
    <div wire:poll.5000ms></div>
    {{-- Total Stats --}}
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Students</h6>
                            <h2 class="mb-0 pt-3 fw-bold fw-1">{{ $stats['overview']['total_students'] }}</h2>
                        </div>
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Classes</h6>
                            <h2 class="mb-0 pt-3 fw-bold">{{ $stats['overview']['total_classes'] }}</h2>
                        </div>
                        <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Enrollments</h6>
                            <h2 class="mb-0 pt-3 fw-bold">{{ $stats['overview']['total_enrollments'] }}</h2>
                        </div>
                        <i class="fas fa-user-graduate fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Today's Attendance</h6>
                            <h2 class="mb-0 pt-3 fw-bold">{{ $stats['overview']['total_attendance_today'] }}</h2>
                        </div>
                        <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance Summary --}}
    <div class="row mb-4">

        {{-- Attendance Distribution Pie Chart --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-chart-pie text-success me-2"></i>Today's Attendance Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center justify-content-center mb-2" wire:ignore>
                        <div style="width: 140px; height: 140px;">
                            <canvas id="attendancePieChart"></canvas>
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="mb-2">
                                <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                                <h4 class="mb-0 text-success">{{ $stats['today_attendance']['present_today'] }}</h4>
                                <small class="text-muted">Present</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-2">
                                <i class="fas fa-user-times fa-2x text-danger mb-2"></i>
                                <h4 class="mb-0 text-danger">{{ $stats['today_attendance']['absent_today'] }}</h4>
                                <small class="text-muted">Absent</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-2">
                                <i class="fas fa-percentage fa-2x text-primary mb-2"></i>
                                <h4 class="mb-0 text-primary">{{ $stats['today_attendance']['attendance_rate'] }}%</h4>
                                <small class="text-muted">Rate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Attendance Trend Chart --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div>
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-chart-line text-primary me-2"></i>Attendance Analytics
                            </h5>
                            <small class="text-muted">Weekly attendance trends and patterns</small>
                        </div>
                        <span class="badge bg-danger pulse-badge">
                            <i class="fas fa-circle"></i> Live
                        </span>
                    </div>
                </div>
                <div class="card-body" wire:ignore>
                    <canvas id="attendanceTrendChart" height="80"></canvas>
                </div>
            </div>
        </div>


        {{-- Recent Attendance Activity --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center w-100">
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
                                        <span class="badge bg-dark">
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


        {{-- Quick Actions --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('attendance.scanner') }}" class="btn btn-primary w-100">
                                <i class="fas fa-qrcode me-1"></i>Mark Attendance
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('attendance.reports') }}" class="btn btn-info w-100">
                                <i class="fas fa-chart-line me-1"></i>View Reports
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <a href="{{ route('admin.students.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-user-plus me-1"></i>Add Student
                            </a>
                        </div>
                        <div class="col-md-12 mb-3">
                            <a href="{{ url('admin/classes') }}" class="btn btn-warning w-100">
                                <i class="fas fa-chalkboard-teacher me-1"></i>Manage Classes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
