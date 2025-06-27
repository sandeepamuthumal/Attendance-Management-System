@extends('layouts.app')

@section('title')
    My Students
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">
        <!-- Students List -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>My Students</h3>
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
        });

        function loadStudents() {
            showTableLoading();

            const filters = {
                search: $('#filter_search').val(),
                class_id: $('#filter_class').val()
            };

            $.ajax({
                url: '{{ route("teacher.students.load") }}',
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
