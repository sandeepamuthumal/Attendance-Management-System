@extends('layouts.app')



@section('title')
    Add New Student
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>Add New Student</h3>
                        </div>
                        <div class="breadcrumb-section">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                                <li class="breadcrumb-item active">Add New</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Multi-Step Progress -->
                        <div class="step-progress mb-4">
                            <div class="step-progress-bar">
                                <div class="step active" data-step="1">
                                    <div class="step-number">1</div>
                                    <div class="step-title">Personal Info</div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-number">2</div>
                                    <div class="step-title">Contact Details</div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-number">3</div>
                                    <div class="step-title">Class Assignment</div>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-number">4</div>
                                    <div class="step-title">Review & Submit</div>
                                </div>
                            </div>
                        </div>

                        <!-- Multi-Step Form -->
                        <form id="student-form" novalidate>
                            @csrf

                            <!-- Step 1: Personal Information -->
                            <div class="step-content active" id="step-1">
                                <h4 class="mb-3">Personal Information</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="first_name" required>
                                        <div class="invalid-feedback" id="first_nameError"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" required>
                                        <div class="invalid-feedback" id="last_nameError"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" required>
                                        <div class="invalid-feedback" id="emailError"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">NIC Number</label>
                                        <input type="text" class="form-control" name="nic" required>
                                        <div class="invalid-feedback" id="nicError"></div>
                                        <div class="form-text">Enter NIC number (e.g., 123456789V or 123456789012)</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Contact Details -->
                            <div class="step-content" id="step-2">
                                <h4 class="mb-3">Contact Details</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Student Contact Number</label>
                                        <input type="text" class="form-control" name="contact_no" required>
                                        <div class="invalid-feedback" id="contact_noError"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Parent Contact Number</label>
                                        <input type="text" class="form-control" name="parent_contact_no" required>
                                        <div class="invalid-feedback" id="parent_contact_noError"></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" rows="4" required></textarea>
                                        <div class="invalid-feedback" id="addressError"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Class Assignment -->
                            <div class="step-content" id="step-3">
                                <h4 class="mb-3">Class Assignment</h4>

                                <!-- Class Filters -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Filter by Grade</label>
                                        <select class="form-select" id="filter_grade" onchange="filterClasses()">
                                            <option value="">All Grades</option>
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Filter by Subject</label>
                                        <select class="form-select" id="filter_subject" onchange="filterClasses()">
                                            <option value="">All Subjects</option>
                                            @foreach($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Search Classes</label>
                                        <input type="text" class="form-control" id="search_classes"
                                               placeholder="Search classes..." onkeyup="filterClasses()">
                                    </div>
                                </div>

                                <!-- Available Classes Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="select_all_classes">
                                                        <label class="form-check-label" for="select_all_classes">
                                                            Select All
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>Class Name</th>
                                                <th>Subject</th>
                                                <th>Teacher</th>
                                                <th>Grade</th>
                                                <th>Year</th>
                                            </tr>
                                        </thead>
                                        <tbody id="classes_table_body">
                                            @foreach($classes as $class)
                                                <tr class="class-row"
                                                    data-grade="{{ $class->grades_id }}"
                                                    data-subject="{{ $class->subjects_id }}"
                                                    data-search="{{ strtolower($class->class_name . ' ' . $class->subject->subject . ' ' . $class->teacher->user->full_name) }}">
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input class-checkbox"
                                                                   type="checkbox"
                                                                   name="class_ids[]"
                                                                   value="{{ $class->id }}"
                                                                   id="class_{{ $class->id }}">
                                                            <label class="form-check-label" for="class_{{ $class->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $class->class_name }}</td>
                                                    <td>{{ $class->subject->subject }}</td>
                                                    <td>{{ $class->teacher->user->full_name }}</td>
                                                    <td>{{ $class->grade->grade_name }}</td>
                                                    <td>{{ $class->year }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="alert alert-info mt-3">
                                    <i class="bi bi-info-circle"></i>
                                    Select the classes you want to enroll this student in. You can always modify class assignments later.
                                </div>
                            </div>

                            <!-- Step 4: Review & Submit -->
                            <div class="step-content" id="step-4">
                                <h4 class="mb-3">Review Information</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Personal Information</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-5"><strong>Name:</strong></div>
                                                    <div class="col-7" id="review_name">-</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5"><strong>Email:</strong></div>
                                                    <div class="col-7" id="review_email">-</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5"><strong>NIC:</strong></div>
                                                    <div class="col-7" id="review_nic">-</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5"><strong>Contact:</strong></div>
                                                    <div class="col-7" id="review_contact">-</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-5"><strong>Parent Contact:</strong></div>
                                                    <div class="col-7" id="review_parent_contact">-</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5"><strong>Address:</strong></div>
                                                    <div class="col-7" id="review_address">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Selected Classes</h5>
                                            </div>
                                            <div class="card-body">
                                                <div id="review_classes">
                                                    <p class="text-muted">No classes selected</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-success mt-3">
                                   <i class="bi bi-info-circle"></i>
                                    Please review all information before submitting. A unique Student ID will be generated automatically.
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="step-navigation mt-4">
                                <button type="button" class="btn btn-secondary" id="prev-btn" onclick="previousStep()" style="display: none;">
                                    <i class="bi bi-arrow-left"></i> Previous
                                </button>
                                <button type="button" class="btn btn-primary" id="next-btn" onclick="nextStep()">
                                    Next <i class="bi bi-arrow-right"></i>
                                </button>
                                <button type="submit" class="btn btn-success" id="submit-btn" style="display: none;">
                                    <i class="bi bi-floppy"></i> Create Student
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .step-progress {
            width: 100%;
        }

        .step-progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 2rem;
        }

        .step-progress-bar::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 10px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: #134D80;
            color: white;
        }

        .step.completed .step-number {
            background: #28a745;
            color: white;
        }

        .step-title {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: center;
        }

        .step.active .step-title {
            color: #134D80;
            font-weight: 500;
        }

        .step.completed .step-title {
            color: #28a745;
        }

        .step-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .step-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .step-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e9ecef;
            padding-top: 1rem;
        }

        .class-row {
            transition: all 0.3s ease;
        }

        .class-row.hidden {
            display: none;
        }

        .table-hover .class-row:hover {
            background-color: #f8f9fa;
        }

        .form-check-input:checked {
            background-color: #134D80;
            border-color: #134D80;
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
        let currentStep = 1;
        const totalSteps = 4;

        $(document).ready(function() {
            updateStepDisplay();

            // Select all classes checkbox
            $('#select_all_classes').change(function() {
                const isChecked = $(this).is(':checked');
                $('.class-checkbox:visible').prop('checked', isChecked);
            });

            // Form submission
            $('#student-form').submit(function(e) {
                e.preventDefault();
                submitStudentForm();
            });

            // Real-time validation
            $('input[name="email"]').on('blur', validateEmail);
            $('input[name="nic"]').on('blur', validateNIC);
            $('input[name="contact_no"], input[name="parent_contact_no"]').on('blur', validateContactNumber);
        });

        function nextStep() {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStepDisplay();

                    if (currentStep === 4) {
                        updateReviewStep();
                    }
                }
            }
        }

        function previousStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStepDisplay();
            }
        }

        function updateStepDisplay() {
            // Update step indicators
            $('.step').each(function(index) {
                const stepNumber = index + 1;
                $(this).removeClass('active completed');

                if (stepNumber < currentStep) {
                    $(this).addClass('completed');
                } else if (stepNumber === currentStep) {
                    $(this).addClass('active');
                }
            });

            // Update step content
            $('.step-content').removeClass('active');
            $(`#step-${currentStep}`).addClass('active');

            // Update navigation buttons
            $('#prev-btn').toggle(currentStep > 1);
            $('#next-btn').toggle(currentStep < totalSteps);
            $('#submit-btn').toggle(currentStep === totalSteps);
        }

        function validateCurrentStep() {
            clearErrors();
            let isValid = true;

            if (currentStep === 1) {
                // Validate personal information
                const requiredFields = ['first_name', 'last_name', 'email', 'nic'];
                requiredFields.forEach(field => {
                    const value = $(`input[name="${field}"]`).val().trim();
                    console.log(value);
                    if (!value) {
                        displayFieldError(field, 'This field is required');
                        isValid = false;
                    }
                });

                // Email validation
                if (!validateEmail()) isValid = false;
                // NIC validation
                if (!validateNIC()) isValid = false;

            } else if (currentStep === 2) {
                // Validate contact details
                const requiredFields = ['contact_no', 'parent_contact_no', 'address'];
                requiredFields.forEach(field => {
                    const value = $(`input[name="${field}"], textarea[name="${field}"]`).val().trim();
                    if (!value) {
                        displayFieldError(field, 'This field is required');
                        isValid = false;
                    }
                });

                // Contact number validation
                if (!validateContactNumber($('input[name="contact_no"]'))) isValid = false;
                if (!validateContactNumber($('input[name="parent_contact_no"]'))) isValid = false;
            }

            return isValid;
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

        function filterClasses() {
            const gradeFilter = $('#filter_grade').val();
            const subjectFilter = $('#filter_subject').val();
            const searchFilter = $('#search_classes').val().toLowerCase();

            $('.class-row').each(function() {
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
            $('#select_all_classes').prop('checked', false);
        }

        function updateReviewStep() {
            // Update personal information
            $('#review_name').text($('input[name="first_name"]').val() + ' ' + $('input[name="last_name"]').val());
            $('#review_email').text($('input[name="email"]').val());
            $('#review_nic').text($('input[name="nic"]').val());
            $('#review_contact').text($('input[name="contact_no"]').val());
            $('#review_parent_contact').text($('input[name="parent_contact_no"]').val());
            $('#review_address').text($('textarea[name="address"]').val());

            // Update selected classes
            const selectedClasses = [];
            $('.class-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const className = row.find('td:nth-child(2)').text();
                const subject = row.find('td:nth-child(3)').text();
                const grade = row.find('td:nth-child(5)').text();
                selectedClasses.push(`${className} - ${subject} (${grade})`);
            });

            if (selectedClasses.length > 0) {
                const classesHtml = selectedClasses.map(cls => `<div class="badge bg-primary me-1 mb-1">${cls}</div>`).join('');
                $('#review_classes').html(classesHtml);
            } else {
                $('#review_classes').html('<p class="text-muted">No classes selected</p>');
            }
        }

        function submitStudentForm() {
            const formData = new FormData($('#student-form')[0]);
            const submitBtn = $('#submit-btn');

            setButtonLoading(submitBtn, true);

            $.ajax({
                url: '{{ route("admin.students.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: `Student created successfully! Student ID: ${response.student_id}`,
                        icon: 'success',
                        confirmButtonText: 'View Profile'
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        displayErrors(errors);

                        // Go back to the step with errors
                        if (errors.first_name || errors.last_name || errors.email || errors.nic) {
                            currentStep = 1;
                        } else if (errors.contact_no || errors.parent_contact_no || errors.address) {
                            currentStep = 2;
                        }
                        updateStepDisplay();

                        toastr.error('Please fix the validation errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                },
                complete: function() {
                    setButtonLoading(submitBtn, false, 'Create Student');
                }
            });
        }

        function displayFieldError(field, message) {
            const input = $(`[name="${field}"]`);
            const errorDiv = $(`#${field}Error`);

            input.addClass('is-invalid');
            console.log(message);
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
