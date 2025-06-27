@extends('layouts.app')

@section('title')
    Edit Student - {{ $student->full_name }}
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>Edit Student - {{ $student->student_id }}</h3>
                        </div>
                        <div class="breadcrumb-section">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.students.profile', $student->id) }}">{{ $student->full_name }}</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="editTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab"
                                        data-bs-target="#basic-info" type="button" role="tab">
                                    <i class="fa fa-user"></i> Basic Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="classes-tab" data-bs-toggle="tab"
                                        data-bs-target="#classes" type="button" role="tab">
                                    <i class="fa fa-graduation-cap"></i> Classes
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="editTabsContent">
                            <!-- Basic Information Tab -->
                            <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                                <form id="student-edit-form" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                   value="{{ $student->first_name }}" required>
                                            <div class="invalid-feedback" id="first_nameError"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                   value="{{ $student->last_name }}" required>
                                            <div class="invalid-feedback" id="last_nameError"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" name="email"
                                                   value="{{ $student->email }}" required>
                                            <div class="invalid-feedback" id="emailError"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NIC Number</label>
                                            <input type="text" class="form-control" name="nic"
                                                   value="{{ $student->nic }}" required>
                                            <div class="invalid-feedback" id="nicError"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Student Contact Number</label>
                                            <input type="text" class="form-control" name="contact_no"
                                                   value="{{ $student->contact_no }}" required>
                                            <div class="invalid-feedback" id="contact_noError"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Parent Contact Number</label>
                                            <input type="text" class="form-control" name="parent_contact_no"
                                                   value="{{ $student->parent_contact_no }}" required>
                                            <div class="invalid-feedback" id="parent_contact_noError"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" rows="4" required>{{ $student->address }}</textarea>
                                        <div class="invalid-feedback" id="addressError"></div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.students.profile', $student->id) }}" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> Back to Profile
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Student
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Classes Tab -->
                            <div class="tab-pane fade" id="classes" role="tabpanel">
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Manage Class Enrollments</h5>
                                        <button class="btn btn-primary" onclick="updateClassEnrollments()">
                                            <i class="fa fa-save"></i> Update Enrollments
                                        </button>
                                    </div>

                                    <!-- Class Filters -->
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label">Filter by Grade</label>
                                            <select class="form-select" id="filter_grade" onchange="filterEditClasses()">
                                                <option value="">All Grades</option>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Filter by Subject</label>
                                            <select class="form-select" id="filter_subject" onchange="filterEditClasses()">
                                                <option value="">All Subjects</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Search Classes</label>
                                            <input type="text" class="form-control" id="search_edit_classes"
                                                   placeholder="Search classes..." onkeyup="filterEditClasses()">
                                        </div>
                                    </div>

                                    <!-- Available Classes Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="select_all_edit_classes">
                                                            <label class="form-check-label" for="select_all_edit_classes">
                                                                Select All
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th>Class Name</th>
                                                    <th>Subject</th>
                                                    <th>Teacher</th>
                                                    <th>Grade</th>
                                                    <th>Year</th>
                                                    <th>Current Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="edit_classes_table_body">
                                                @foreach($classes as $class)
                                                    <tr class="edit-class-row"
                                                        data-grade="{{ $class->grades_id }}"
                                                        data-subject="{{ $class->subjects_id }}"
                                                        data-search="{{ strtolower($class->class_name . ' ' . $class->subject->subject . ' ' . $class->teacher->user->full_name) }}">
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input edit-class-checkbox"
                                                                       type="checkbox"
                                                                       name="class_ids[]"
                                                                       value="{{ $class->id }}"
                                                                       id="edit_class_{{ $class->id }}"
                                                                       {{ in_array($class->id, $enrolledClassIds) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="edit_class_{{ $class->id }}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $class->class_name }}</td>
                                                        <td>{{ $class->subject->subject }}</td>
                                                        <td>{{ $class->teacher->user->full_name }}</td>
                                                        <td>{{ $class->grade->grade_name }}</td>
                                                        <td>{{ $class->year }}</td>
                                                        <td>
                                                            @if(in_array($class->id, $enrolledClassIds))
                                                                <span class="badge bg-success">Enrolled</span>
                                                            @else
                                                                <span class="badge bg-secondary">Not Enrolled</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        .nav-tabs .nav-link {
            color: #495057;
        }

        .nav-tabs .nav-link.active {
            color: #134D80;
            font-weight: 500;
        }

        .tab-content {
            min-height: 400px;
        }

        .edit-class-row {
            transition: all 0.3s ease;
        }

        .edit-class-row.hidden {
            display: none;
        }

        .table-hover .edit-class-row:hover {
            background-color: #f8f9fa;
        }

        .invalid-feedback {
            display: block;
        }

        .is-invalid {
            border-color: #dc3545;
        }
    </style>
@endpush

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle tab switching
            const hash = window.location.hash;
            if (hash === '#step-3' || hash === '#classes') {
                $('#classes-tab').tab('show');
            }

            // Form submission
            $('#student-edit-form').submit(function(e) {
                e.preventDefault();
                updateStudentInfo();
            });

            // Select all classes checkbox
            $('#select_all_edit_classes').change(function() {
                const isChecked = $(this).is(':checked');
                $('.edit-class-checkbox:visible').prop('checked', isChecked);
            });

            // Real-time validation
            $('input[name="email"]').on('blur', validateEmail);
            $('input[name="nic"]').on('blur', validateNIC);
            $('input[name="contact_no"], input[name="parent_contact_no"]').on('blur', validateContactNumber);
        });

        function updateStudentInfo() {
            const formData = new FormData($('#student-edit-form')[0]);
            const submitBtn = $('#student-edit-form button[type="submit"]');

            setButtonLoading(submitBtn, true);
            clearErrors();

            $.ajax({
                url: '{{ route("admin.students.update") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success('Student information updated successfully');
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        displayErrors(errors);
                        toastr.error('Please fix the validation errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                },
                complete: function() {
                    setButtonLoading(submitBtn, false, 'Update Student');
                }
            });
        }

        function updateClassEnrollments() {
            const selectedClasses = [];
            $('.edit-class-checkbox:checked').each(function() {
                selectedClasses.push($(this).val());
            });

            const formData = new FormData($('#student-edit-form')[0]);
            //add student-edit-form to formData
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('student_id', '{{ $student->id }}');
            selectedClasses.forEach(classId => {
                formData.append('class_ids[]', classId);
            });

            console.log(formData);

            const updateBtn = $('.btn-primary:contains("Update Enrollments")');
            setButtonLoading(updateBtn, true);

            $.ajax({
                url: '{{ route("admin.students.update") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success('Class enrollments updated successfully');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Failed to update enrollments');
                },
                complete: function() {
                    setButtonLoading(updateBtn, false, 'Update Enrollments');
                }
            });
        }

        function filterEditClasses() {
            const gradeFilter = $('#filter_grade').val();
            const subjectFilter = $('#filter_subject').val();
            const searchFilter = $('#search_edit_classes').val().toLowerCase();

            $('.edit-class-row').each(function() {
                const row = $(this);
                const grade = row.data('grade').toString();
                const subject = row.data('subject').toString();
                const searchText = row.data('search');

                let showRow = true;

                if (gradeFilter && grade !== gradeFilter) {
                    showRow = false;
                }

                if (subjectFilter && subject !== subjectFilter) {
                    showRow = false;
                }

                if (searchFilter && !searchText.includes(searchFilter)) {
                    showRow = false;
                }

                row.toggle(showRow);
            });

            // Update select all checkbox
            $('#select_all_edit_classes').prop('checked', false);
        }

        function validateEmail() {
            const email = $('input[name="email"]').val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                displayFieldError('email', 'Please enter a valid email address');
                return false;
            }

            clearFieldError('email');
            return true;
        }

        function validateNIC() {
            const nic = $('input[name="nic"]').val().trim();
            const oldNicRegex = /^[0-9]{9}[vVxX]$/;
            const newNicRegex = /^[0-9]{12}$/;

            if (nic && !oldNicRegex.test(nic) && !newNicRegex.test(nic)) {
                displayFieldError('nic', 'Please enter a valid NIC number');
                return false;
            }

            clearFieldError('nic');
            return true;
        }

        function validateContactNumber(element) {
            const contact = element.val().trim();
            const contactRegex = /^[\d\s\-\+\(\)]{7,15}$/;
            const fieldName = element.attr('name');

            if (contact && !contactRegex.test(contact)) {
                displayFieldError(fieldName, 'Please enter a valid contact number');
                return false;
            }

            clearFieldError(fieldName);
            return true;
        }

        function displayFieldError(field, message) {
            const input = $(`[name="${field}"]`);
            const errorDiv = $(`#${field}Error`);

            input.addClass('is-invalid');
            errorDiv.text(message);
        }

        function clearFieldError(field) {
            const input = $(`[name="${field}"]`);
            const errorDiv = $(`#${field}Error`);

            input.removeClass('is-invalid');
            errorDiv.text('');
        }

        function clearErrors() {
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }

        function displayErrors(errors) {
            $.each(errors, function(field, messages) {
                displayFieldError(field, messages[0]);
            });
        }

        function setButtonLoading(button, isLoading, originalText = null) {
            if (isLoading) {
                button.prop('disabled', true);
                if (originalText) {
                    button.data('original-text', button.text());
                }
                button.html('<i class="fa fa-spinner fa-spin"></i> Please Wait...');
            } else {
                button.prop('disabled', false);
                if (originalText) {
                    button.html(`<i class="fa fa-save"></i> ${originalText}`);
                } else if (button.data('original-text')) {
                    button.text(button.data('original-text'));
                }
            }
        }
    </script>
@endsection
