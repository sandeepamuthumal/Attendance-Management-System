@extends('layouts.app')

@section('title')
    Student Management
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">
        <!-- Students List -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>Student Management</h3>
                        </div>
                        <div class="list-product-header">
                            <div>
                                <div class="light-box">
                                    <a data-bs-toggle="collapse" href="#collapseFilters" title="Filter Students"
                                       role="button" aria-expanded="false" aria-controls="collapseFilters">
                                        <i class="filter-icon show" data-feather="filter"></i>
                                        <i class="icon-close filter-close hide"></i>
                                    </a>
                                </div>
                                <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
                                    <i class="fa-solid fa-plus"></i> Add Student
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters Section -->
                        <div class="collapse" id="collapseFilters">
                            <div class="list-product-body pb-3">
                                <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3">
                                    <div class="col">
                                        <input type="text" class="form-control" id="filter_search"
                                               placeholder="Search students..." onkeyup="debounceSearch()">
                                    </div>
                                    <div class="col">
                                        <select class="form-select" id="filter_class" onchange="loadStudents();">
                                            <option value="">All Classes</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">
                                                    {{ $class->class_name }} - {{ $class->subject->subject }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-secondary w-100" onclick="clearFilters()">
                                            <i class="bi bi-arrow-clockwise"></i> Clear Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Overlay -->
                        <div id="table-loading" class="text-center py-4" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading students...</p>
                        </div>

                        <!-- Data Table -->
                        <div class="table-responsive">
                            <table class="display" id="student-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact No</th>
                                        <th>Classes</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .btn-group-sm > .btn, .btn-sm {
            margin-right: 5px;
        }

        .filter-icon, .icon-close {
            width: 20px;
            height: 20px;
        }

        .light-box a {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 8px;
            margin-right: 10px;
            display: inline-block;
        }

        .badge {
            font-size: 0.75em;
        }

        .table-loading {
            position: relative;
        }

        .table-loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 10;
        }
    </style>
@endpush

@section('scripts')
    <script>
        let studentDataTable = null;
        let searchTimeout = null;

        $(document).ready(function() {
            loadStudents();

            // Status change handlers
            $(document).on('click', '.activate-student', function() {
                const studentId = $(this).data('id');
                changeStudentStatus(studentId, 'activate');
            });

            $(document).on('click', '.deactivate-student', function() {
                const studentId = $(this).data('id');
                changeStudentStatus(studentId, 'deactivate');
            });

            $(document).on('click', '.delete-student', function() {
                const studentId = $(this).data('id');
                deleteStudent(studentId);
            });
        });

        function loadStudents() {
            showTableLoading();

            const filters = {
                search: $('#filter_search').val(),
                class_id: $('#filter_class').val()
            };

            $.ajax({
                url: '{{ route("admin.students.load") }}',
                method: 'GET',
                data: filters,
                success: function(response) {
                    console.log("Students loaded successfully", response);

                    if (studentDataTable) {
                        studentDataTable.destroy();
                    }

                    studentDataTable = $('#student-table').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['pageLength', 'csv', 'excel', 'pdf', 'print'],
                        pageLength: 25,
                        lengthChange: true,
                        order: [[0, 'asc']],
                        destroy: true,
                        data: response,
                        columns: [
                            { data: 'student_id', title: 'Student ID' },
                            { data: 'name', title: 'Name' },
                            { data: 'email', title: 'Email' },
                            { data: 'contact_no', title: 'Contact No' },
                            { data: 'classes', title: 'Classes' },
                            { data: 'created_date', title: 'Created Date' },
                            {
                                data: 'action',
                                title: 'Action',
                                orderable: false,
                                render: function(data, type, row) {
                                    return data;
                                }
                            }
                        ],
                        responsive: true,
                        language: {
                            processing: "Loading students...",
                            emptyTable: "No students found",
                            zeroRecords: "No matching students found",
                            info: "Showing _START_ to _END_ of _TOTAL_ students",
                            infoEmpty: "Showing 0 to 0 of 0 students",
                            infoFiltered: "(filtered from _MAX_ total students)"
                        }
                    });

                    hideTableLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading students:', error);
                    hideTableLoading();
                    toastr.error('Failed to load students. Please try again.');
                }
            });
        }

        function debounceSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadStudents();
            }, 500);
        }

        function clearFilters() {
            $('#filter_search').val('');
            $('#filter_class').val('');
            loadStudents();
        }

        function changeStudentStatus(studentId, action) {
            const actionText = action === 'activate' ? 'activate' : 'deactivate';
            const confirmText = `Are you sure you want to ${actionText} this student?`;

            Swal.fire({
                title: confirmText,
                text: action === 'deactivate' ? 'Student will not be able to attend classes.' : 'Student will be able to attend classes again.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'activate' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${actionText}!`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/students/${action}/${studentId}`,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)}d!`,
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadStudents();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || `Failed to ${action} student`,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function deleteStudent(studentId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone. Student will be permanently deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/students/delete/${studentId}`,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            loadStudents();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Failed to delete student',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function showTableLoading() {
            $('#table-loading').show();
            $('#student-table').hide();
        }

        function hideTableLoading() {
            $('#table-loading').hide();
            $('#student-table').show();
        }
    </script>
@endsection
