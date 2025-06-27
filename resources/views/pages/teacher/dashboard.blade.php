@extends('layouts.app')

@section('title')
    Teacher Dashboard
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2>Teacher Dashboard</h2>
                    <p class="mb-0 text-title-gray">Welcome back! Let’s start from where you left.</p>
                </div>
                <div class="col-sm-6 col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Teacher</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Total Students</h6>
                                <h2 class="mb-0">{{ $stats['overview']['total_students'] }}</h2>
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
                                <h2 class="mb-0">{{ $stats['overview']['total_classes'] }}</h2>
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
                                <h2 class="mb-0">{{ $stats['overview']['total_enrollments'] }}</h2>
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
                                <h2 class="mb-0">{{ $stats['overview']['total_attendance_today'] }}</h2>
                            </div>
                            <i class="fas fa-calendar-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Today's Attendance Summary --}}
        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Today's Attendance Summary
                        </h5>
                    </div>
                    <div class="card-body">
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

                        {{-- Progress Bar --}}
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Attendance Progress</span>
                                <span>{{ $stats['today_attendance']['present_today'] }}/{{ $stats['today_attendance']['total_students'] }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $stats['today_attendance']['attendance_rate'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Attendance --}}
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>Recent Attendance
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (!empty($stats['recent_attendance']))
                            <div class="list-group list-group-flush">
                                @foreach ($stats['recent_attendance'] as $attendance)
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">{{ $attendance['student_name'] }}</h6>
                                                <small class="text-muted">
                                                    {{ $attendance['student_id'] }} • {{ $attendance['class_name'] }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted d-block">{{ $attendance['date'] }}</small>
                                                <small class="text-success">{{ $attendance['time'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-clipboard-list fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No recent attendance records</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

      
    </div>
@endsection
