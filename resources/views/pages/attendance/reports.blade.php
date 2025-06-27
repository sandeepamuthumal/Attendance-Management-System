@extends('layouts.app')

@section('title')
    Attendance Report
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="row mb-4 pt-3">
            <div class="col-12">
                <h2>Attendance Report</h2>
                <p class="text-muted">Generate attendance reports with filters</p>
            </div>
        </div>

        {{-- Filters Card --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>Report Filters
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('attendance.reports') }}" id="reportForm">
                    <input type="hidden" name="generate_report" value="1">

                    <div class="row">
                        {{-- Class Filter --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="class_id">Class</label>
                            <select class="form-select" name="class_id" id="class_id" onchange="loadStudents()">
                                <option value="">All Classes</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }} ({{ $class->subject->subject ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Student Filter --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="student_id">Student</label>
                            <select class="form-select" name="student_id" id="student_id">
                                <option value="">All Students</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" id="studentHelp">
                                @if (empty($students) && request('class_id'))
                                    No students found for selected class
                                @elseif(empty($students))
                                    Select a class to filter by student
                                @endif
                            </small>
                        </div>

                        {{-- Start Date --}}
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ request('start_date', \Carbon\Carbon::today()->subDays(7)->format('Y-m-d')) }}"
                                required>
                            @error('start_date')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ request('end_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
                            @error('end_date')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Generate Report
                                </button>
                                <a href="{{ route('attendance.reports') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-refresh me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Results Section --}}
        @if ($showResults)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2"></i>Attendance Records
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    @if (!empty($attendanceRecords) && count($attendanceRecords) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover display" id="attendance-table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendanceRecords as $record)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                                            <td>{{ $record->created_at->format('h:i A') }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ $record->student->student_id }}</span>
                                            </td>
                                            <td>{{ $record->student->first_name }} {{ $record->student->last_name }}</td>
                                            <td>{{ $record->enrollment->class->class_name }}</td>
                                            <td>{{ $record->enrollment->class->subject->subject ?? 'N/A' }}</td>
                                            <td>{{ $record->enrollment->class->grade->grade ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No attendance records found</h5>
                            <p class="text-muted">Try adjusting your filters and search again.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@endpush

@section('scripts')
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script>
         var table = $('#attendance-table').DataTable({
            createdRow: function(row, data, index) {
                $(row).addClass('selected')
            },
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            "order": [],
            dom: 'Bfrtip',
            buttons: [
                'pageLength', 'csv', 'excel', 'pdf', 'print'
            ],
        });

        function loadStudents() {
            const classId = document.getElementById('class_id').value;
            const studentSelect = document.getElementById('student_id');
            const studentHelp = document.getElementById('studentHelp');

            // Clear current options
            studentSelect.innerHTML = '<option value="">All Students</option>';

            if (!classId) {
                studentSelect.disabled = false;
                studentHelp.textContent = 'Select a class to filter by student';
                return;
            }

            // Show loading
            studentSelect.disabled = true;
            studentHelp.textContent = 'Loading students...';

            // Fetch students for selected class
            fetch(`{{ route('attendance.report.students') }}?class_id=${classId}`)
                .then(response => response.json())
                .then(students => {
                    studentSelect.disabled = false;

                    if (students.length === 0) {
                        studentHelp.textContent = 'No students found for selected class';
                        return;
                    }

                    students.forEach(student => {
                        const option = document.createElement('option');
                        option.value = student.id;
                        option.textContent =
                            `${student.student_id} - ${student.first_name} ${student.last_name}`;
                        studentSelect.appendChild(option);
                    });

                    studentHelp.textContent = `${students.length} students available`;
                })
                .catch(error => {
                    console.error('Error loading students:', error);
                    studentSelect.disabled = false;
                    studentHelp.textContent = 'Error loading students';
                });
        }

        // Set max date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('start_date').max = today;
            document.getElementById('end_date').max = today;
        });
    </script>
@endsection
