@extends('layouts.app')

@section('title')
    Class Management
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">

        {{-- Add Class Modal --}}
        <div class="modal fade bd-example-modal-lg" id="add-class-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Add New Class</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="add-class-form">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Class Name</label>
                                    <input class="form-control" name="class_name" type="text" placeholder="e.g., Mathematics A" required>
                                    <span class="text-danger" id="class_nameError"></span>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Year</label>
                                    <select class="form-select" name="year" required>
                                        <option value="">Choose Year...</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="yearError"></span>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Subject</label>
                                    <select class="form-select" name="subjects_id" required>
                                        <option value="">Choose Subject...</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="subjects_idError"></span>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Grade</label>
                                    <select class="form-select" name="grades_id" required>
                                        <option value="">Choose Grade...</option>
                                        @foreach($grades as $gd)
                                            <option value="{{ $gd->id }}">{{ $gd->grade }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="grades_idError"></span>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Teacher</label>
                                    <select class="form-select" name="teachers_id" required>
                                        <option value="">Choose Teacher...</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->user->full_name }} - {{ $teacher->subject->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="teachers_idError"></span>
                                </div>
                                <div class="col-12 mb-3 d-none">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" id="status" checked>
                                        <label class="form-check-label" for="status">
                                            Active Class
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-class-btn">CREATE CLASS</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Class Modal --}}
        <div class="modal fade bd-example-modal-lg" id="edit-class-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Edit Class</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="edit-class-form">
                            <input type="hidden" name="class_id" id="edit_class_id">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Class Name</label>
                                    <input class="form-control" name="class_name" id="edit_class_name" type="text" placeholder="e.g., Mathematics A" required>
                                    <span class="text-danger" id="edit_class_nameError"></span>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Year</label>
                                    <select class="form-select" name="year" id="edit_year" required>
                                        <option value="">Choose Year...</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="edit_yearError"></span>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Subject</label>
                                    <select class="form-select" name="subjects_id" id="edit_subjects_id" required>
                                        <option value="">Choose Subject...</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="edit_subjects_idError"></span>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Grade</label>
                                    <select class="form-select" name="grades_id" id="edit_grades_id" required>
                                        <option value="">Choose Grade...</option>
                                        @foreach($grades as $gd)
                                            <option value="{{ $gd->id }}">{{ $gd->grade }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="edit_grades_idError"></span>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Teacher</label>
                                    <select class="form-select" name="teachers_id" id="edit_teachers_id" required>
                                        <option value="">Choose Teacher...</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->user->full_name }} - {{ $teacher->subject->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="edit_teachers_idError"></span>
                                </div>
                                <div class="col-12 mb-3 d-none">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status" value="1" id="edit_status">
                                        <label class="form-check-label" for="edit_status">
                                            Active Class
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="update-class-btn">UPDATE CLASS</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Classes List --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>Class Management</h3>
                        </div>
                        <div class="list-product-header">
                            <div>
                                <div class="light-box">
                                    <a data-bs-toggle="collapse" href="#collapseFilters" title="Filter Classes"
                                       role="button" aria-expanded="false" aria-controls="collapseFilters">
                                        <i class="filter-icon show" data-feather="filter"></i>
                                        <i class="icon-close filter-close hide"></i>
                                    </a>
                                </div>
                                <button class="btn btn-primary" title="Add New Class" data-bs-toggle="modal"
                                    data-bs-target="#add-class-modal">
                                    <i class="fa-solid fa-plus"></i> Add Class
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Filters Section --}}
                        <div class="collapse" id="collapseFilters">
                            <div class="list-product-body pb-3">
                                <div class="row row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 g-3">
                                    <div class="col">
                                        <select class="form-select" id="filter_year" onchange="loadClasses();">
                                            <option value="">All Years</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-select" id="filter_grade" onchange="loadClasses();">
                                            <option value="">All Grades</option>
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-select" id="filter_subject" onchange="loadClasses();">
                                            <option value="">All Subjects</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-select" id="filter_teacher" onchange="loadClasses();">
                                            <option value="">All Teachers</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->user->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Loading Overlay --}}
                        <div id="table-loading" class="text-center py-4" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading classes...</p>
                        </div>

                        {{-- Data Table --}}
                        <div class="table-responsive">
                            <table class="display" id="class-table">
                                <thead>
                                    <tr>
                                        <th>Class Name</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Grade</th>
                                        <th>Year</th>
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

        .badge {
            font-size: 0.75em;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        /* SPA Loading States */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-overlay .spinner-border {
            width: 3rem;
            height: 3rem;
            color: #667eea;
        }

        /* Button loading states */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Form validation styles */
        .is-invalid {
            border-color: #dc3545;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        /* DataTable custom styles */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 4px 8px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #667eea !important;
            border-color: #667eea !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #5a6fd8 !important;
            border-color: #5a6fd8 !important;
            color: white !important;
        }
    </style>
@endpush

@section('scripts')
    <script>
        // Global variables
        let classDataTable = null;
        let currentFilters = {};

        $(document).ready(function() {
            initializeClassManagement();
        });

        function initializeClassManagement() {
            // Load classes initially
            loadClasses();

            // Initialize event handlers
            initializeEventHandlers();

            // Initialize form validation
            initializeFormValidation();

            console.log('Class Management SPA initialized successfully');
        }

        function initializeEventHandlers() {
            // Add Class
            $('#add-class-btn').click(function() {
                submitClassForm('#add-class-form', '{{ route("classes.store") }}', 'POST', '#add-class-modal', '#add-class-btn', 'CREATE CLASS');
            });

            // Edit Class
            $(document).on('click', '.edit-class', function() {
                const classId = $(this).data('id');
                editClass(classId);
            });

            // Update Class
            $('#update-class-btn').click(function() {
                submitClassForm('#edit-class-form', '{{ route("classes.update") }}', 'POST', '#edit-class-modal', '#update-class-btn', 'UPDATE CLASS');
            });

            // Activate/Deactivate Class
            $(document).on('click', '.activate-class', function() {
                const classId = $(this).data('id');
                changeClassStatus(classId, 'activate');
            });

            $(document).on('click', '.deactivate-class', function() {
                const classId = $(this).data('id');
                changeClassStatus(classId, 'deactivate');
            });

            // Delete Class
            $(document).on('click', '.delete-class', function() {
                const classId = $(this).data('id');
                deleteClass(classId);
            });

            // Modal reset handlers
            $('#add-class-modal').on('hidden.bs.modal', function() {
                resetForm('#add-class-form');
                clearErrors();
            });

            $('#edit-class-modal').on('hidden.bs.modal', function() {
                resetForm('#edit-class-form');
                clearErrors();
            });

            // Real-time search in DataTable
            $('#class-table_filter input').on('keyup', debounce(function() {
                if (classDataTable) {
                    classDataTable.search(this.value).draw();
                }
            }, 300));
        }

        function initializeFormValidation() {
            // Real-time validation
            $('input[name="class_name"]').on('blur', function() {
                validateClassName($(this));
            });

            $('select[name="year"]').on('change', function() {
                validateYear($(this));
            });

            // Form submission validation
            $('#add-class-form, #edit-class-form').on('submit', function(e) {
                e.preventDefault();
                return false;
            });
        }

        function loadClasses() {
            showTableLoading();

            // Get filter values
            currentFilters = {
                status: $('#filter_status').val(),
                year: $('#filter_year').val(),
                grade_id: $('#filter_grade').val(),
                subject_id: $('#filter_subject').val(),
                teacher_id: $('#filter_teacher').val()
            };

            $.ajax({
                url: '{{ route("classes.load") }}',
                method: 'GET',
                data: currentFilters,
                success: function(response) {
                    console.log("Classes loaded successfully", response);

                    // Destroy existing DataTable
                    if (classDataTable) {
                        classDataTable.destroy();
                    }

                    // Initialize new DataTable
                    classDataTable = $('#class-table').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'pageLength', 'csv', 'excel', 'pdf', 'print'
                        ],
                        pageLength: 25,
                        lengthChange: true,
                        order: [[0, 'asc']],
                        destroy: true,
                        data: response,
                        columns: [
                            { data: 'class_name', title: 'Class Name' },
                            { data: 'subject', title: 'Subject' },
                            { data: 'teacher', title: 'Teacher' },
                            { data: 'grade', title: 'Grade' },
                            { data: 'year', title: 'Year' },
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
                            processing: "Loading classes...",
                            emptyTable: "No classes found",
                            zeroRecords: "No matching classes found",
                            info: "Showing _START_ to _END_ of _TOTAL_ classes",
                            infoEmpty: "Showing 0 to 0 of 0 classes",
                            infoFiltered: "(filtered from _MAX_ total classes)"
                        },
                        drawCallback: function(settings) {
                            // Re-initialize tooltips after table draw
                            $('[title]').tooltip();
                        }
                    });

                    hideTableLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading classes:', error);
                    hideTableLoading();

                    showErrorMessage('Failed to load classes. Please try again.');

                    // Initialize empty DataTable
                    if (classDataTable) {
                        classDataTable.destroy();
                    }

                    classDataTable = $('#class-table').DataTable({
                        data: [],
                        columns: [
                            { data: 'class_name', title: 'Class Name' },
                            { data: 'subject', title: 'Subject' },
                            { data: 'teacher', title: 'Teacher' },
                            { data: 'grade', title: 'Grade' },
                            { data: 'year', title: 'Year' },
                            { data: 'status_badge', title: 'Status' },
                            { data: 'created_date', title: 'Created Date' },
                            { data: 'action', title: 'Action' }
                        ]
                    });
                }
            });
        }

        function editClass(classId) {
            showGlobalLoading();
            clearErrors();

            $.ajax({
                url: '{{ route("classes.edit") }}',
                method: 'GET',
                data: { id: classId },
                success: function(response) {
                    console.log("Class data loaded for edit", response);

                    const classData = response.class;

                    // Populate form fields
                    $('#edit_class_id').val(classData.id);
                    $('#edit_class_name').val(classData.class_name);
                    $('#edit_year').val(classData.year);
                    $('#edit_subjects_id').val(classData.subjects_id);
                    $('#edit_grades_id').val(classData.grades_id);
                    $('#edit_teachers_id').val(classData.teachers_id);
                    $('#edit_status').prop('checked', classData.status);

                    $('#edit-class-modal').modal('show');
                    hideGlobalLoading();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading class data:', error);
                    hideGlobalLoading();
                    showErrorMessage('Failed to load class data. Please try again.');
                }
            });
        }

        function submitClassForm(formId, url, method, modalId, buttonId, originalText) {
            const form = $(formId);
            const formData = new FormData(form[0]);
            const button = $(buttonId);

            // Add CSRF token
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            // Validate form before submission
            if (!validateClassForm(formId)) {
                return false;
            }

            // Show loading state
            setButtonLoading(button, true);
            clearErrors();

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Class form submitted successfully", response);

                    showSuccessMessage(response.message || 'Operation completed successfully');
                    $(modalId).modal('hide');
                    resetForm(formId);
                    loadClasses();
                },
                error: function(xhr) {
                    console.error("Class form submission error", xhr);

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON?.errors || {};
                        displayErrors(errors);
                        showErrorMessage('Please fix the validation errors');
                    } else {
                        const message = xhr.responseJSON?.message || 'Something went wrong';
                        showErrorMessage(message);
                    }
                },
                complete: function() {
                    setButtonLoading(button, false, originalText);
                }
            });
        }

        function validateClassForm(formId) {
            const form = $(formId);
            let isValid = true;

            // Clear previous errors
            clearErrors();

            // Check required fields
            form.find('input[required], select[required]').each(function() {
                const field = $(this);
                const value = field.val();
                const fieldName = field.attr('name');

                if (!value || value.trim() === '') {
                    displayFieldError(fieldName, 'This field is required');
                    isValid = false;
                }
            });

            // Class name validation
            const className = form.find('input[name="class_name"]').val();
            if (className && className.length < 2) {
                displayFieldError('class_name', 'Class name must be at least 2 characters');
                isValid = false;
            }

            // Year validation
            const year = parseInt(form.find('select[name="year"]').val());
            const currentYear = new Date().getFullYear();
            if (year && (year < 2020 || year > currentYear + 5)) {
                displayFieldError('year', `Year must be between 2020 and ${currentYear + 5}`);
                isValid = false;
            }

            return isValid;
        }

        function validateClassName(element) {
            const value = element.val().trim();
            const fieldName = element.attr('name');

            if (value.length > 0 && value.length < 2) {
                displayFieldError(fieldName, 'Class name must be at least 2 characters');
                return false;
            } else {
                clearFieldError(fieldName);
                return true;
            }
        }

        function validateYear(element) {
            const value = parseInt(element.val());
            const fieldName = element.attr('name');
            const currentYear = new Date().getFullYear();

            if (value && (value < 2020 || value > currentYear + 5)) {
                displayFieldError(fieldName, `Year must be between 2020 and ${currentYear + 5}`);
                return false;
            } else {
                clearFieldError(fieldName);
                return true;
            }
        }

        function changeClassStatus(classId, action) {
            const actionText = action === 'activate' ? 'activate' : 'deactivate';
            const confirmText = `Are you sure you want to ${actionText} this class?`;

            Swal.fire({
                title: confirmText,
                text: action === 'deactivate' ? 'Students will not be able to attend this class.' : 'This class will be available for attendance.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'activate' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${actionText}!`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showGlobalLoading();

                    $.ajax({
                        url: `/admin/classes/${action}/${classId}`,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(`Class ${action}d successfully`, response);

                            Swal.fire({
                                title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)}d!`,
                                text: response.message || `Class has been ${action}d successfully.`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            loadClasses();
                            hideGlobalLoading();
                        },
                        error: function(xhr) {
                            console.error(`Error ${action}ing class:`, xhr);
                            hideGlobalLoading();

                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || `Failed to ${action} class`,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function deleteClass(classId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone. All attendance records for this class will be lost!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showGlobalLoading();

                    $.ajax({
                        url: `/admin/classes/delete/${classId}`,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Class deleted successfully', response);

                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message || 'Class has been deleted successfully.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            loadClasses();
                            hideGlobalLoading();
                        },
                        error: function(xhr) {
                            console.error('Error deleting class:', xhr);
                            hideGlobalLoading();

                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Failed to delete class',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        // Utility Functions
        function resetForm(formId) {
            const form = $(formId);
            form[0].reset();

            // Reset select elements
            form.find('select').each(function() {
                $(this).val('');
            });

            // Reset checkboxes
            form.find('input[type="checkbox"]').prop('checked', false);

            // Clear hidden fields except CSRF token
            form.find('input[type="hidden"]:not([name="_token"])').val('');

            console.log(`Form ${formId} reset successfully`);
        }

        function clearErrors() {
            $('.text-danger').text('');
            $('.form-control, .form-select').removeClass('is-invalid');
        }

        function displayErrors(errors) {
            $.each(errors, function(field, messages) {
                displayFieldError(field, messages[0]);
            });
        }

        function displayFieldError(field, message) {
            // Handle both regular and edit form errors
            const errorSelectors = [
                `#${field}Error`,
                `#edit_${field}Error`
            ];

            const inputSelectors = [
                `[name="${field}"]`,
                `#${field}`,
                `#edit_${field}`
            ];

            // Display error message
            errorSelectors.forEach(selector => {
                const errorElement = $(selector);
                if (errorElement.length) {
                    errorElement.text(message);
                }
            });

            // Add invalid class to input
            inputSelectors.forEach(selector => {
                const inputElement = $(selector);
                if (inputElement.length) {
                    inputElement.addClass('is-invalid');
                }
            });
        }

        function clearFieldError(field) {
            const errorSelectors = [
                `#${field}Error`,
                `#edit_${field}Error`
            ];

            const inputSelectors = [
                `[name="${field}"]`,
                `#${field}`,
                `#edit_${field}`
            ];

            // Clear error message
            errorSelectors.forEach(selector => {
                const errorElement = $(selector);
                if (errorElement.length) {
                    errorElement.text('');
                }
            });

            // Remove invalid class from input
            inputSelectors.forEach(selector => {
                const inputElement = $(selector);
                if (inputElement.length) {
                    inputElement.removeClass('is-invalid');
                }
            });
        }

        function showTableLoading() {
            $('#table-loading').show();
            $('#class-table').hide();
        }

        function hideTableLoading() {
            $('#table-loading').hide();
            $('#class-table').show();
        }

        function showGlobalLoading() {
            if (!$('#global-loading').length) {
                $('body').append(`
                    <div id="global-loading" class="loading-overlay" style="display: flex;">
                        <div class="text-center text-white">
                            <div class="spinner-border mb-3" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Processing request...</p>
                        </div>
                    </div>
                `);
            } else {
                $('#global-loading').show();
            }
        }

        function hideGlobalLoading() {
            $('#global-loading').hide();
        }

        function setButtonLoading(button, isLoading, originalText = null) {
            if (isLoading) {
                button.prop('disabled', true).addClass('btn-loading');
                if (originalText) {
                    button.data('original-text', button.text());
                    button.text('Please Wait...');
                }
            } else {
                button.prop('disabled', false).removeClass('btn-loading');
                if (originalText) {
                    button.text(originalText);
                } else if (button.data('original-text')) {
                    button.text(button.data('original-text'));
                }
            }
        }

        function showSuccessMessage(message) {
            toastr.success(message, 'Success', {
                timeOut: 4000,
                fadeOut: 1000,
                progressBar: true
            });
        }

        function showErrorMessage(message) {
            toastr.error(message, 'Error', {
                timeOut: 5000,
                fadeOut: 1000,
                progressBar: true
            });
        }

        function showInfoMessage(message) {
            toastr.info(message, 'Info', {
                timeOut: 4000,
                fadeOut: 1000,
                progressBar: true
            });
        }

        // Debounce function for search
        function debounce(func, wait, immediate) {
            let timeout;
            return function executedFunction() {
                const context = this;
                const args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        // Export functions for debugging
        window.ClassManagement = {
            loadClasses,
            editClass,
            changeClassStatus,
            deleteClass,
            currentFilters,
            classDataTable
        };

        // Handle browser back/forward buttons for SPA experience
        window.addEventListener('popstate', function(event) {
            // Handle browser navigation if needed
            console.log('Browser navigation detected');
        });

        // Auto-refresh classes every 5 minutes
        setInterval(function() {
            if (document.visibilityState === 'visible') {
                console.log('Auto-refreshing classes...');
                loadClasses();
            }
        }, 5 * 60 * 1000);

        // Handle page visibility change
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                // Refresh data when user returns to the page
                loadClasses();
            }
        });

        // Keyboard shortcuts
        $(document).keydown(function(e) {
            // Ctrl+N or Cmd+N for new class
            if ((e.ctrlKey || e.metaKey) && e.which === 78) {
                e.preventDefault();
                $('#add-class-modal').modal('show');
            }

            // ESC to close modals
            if (e.which === 27) {
                $('.modal').modal('hide');
            }

            // F5 to refresh data
            if (e.which === 116) {
                e.preventDefault();
                loadClasses();
                showInfoMessage('Data refreshed');
            }
        });

        console.log('Class Management SPA loaded successfully');
        console.log('Available shortcuts: Ctrl+N (New Class), F5 (Refresh), ESC (Close Modal)');
    </script>
@endsection
