@extends('layouts.app')

@section('title')
    Teacher Users
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">

        {{-- Add Teacher Modal --}}
        <div class="modal fade bd-example-modal-lg" id="add-teacher-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Add New Teacher</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="add-teacher-form">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label">First Name</label>
                                    <input class="form-control" name="first_name" type="text" placeholder="First name" required>
                                    <span class="text-danger" id="first_nameError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Last Name</label>
                                    <input class="form-control" name="last_name" type="text" placeholder="Last name" required>
                                    <span class="text-danger" id="last_nameError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Email Address</label>
                                    <input class="form-control" name="email" type="email" placeholder="teacher@example.com" required>
                                    <span class="text-danger" id="emailError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Subject</label>
                                    <select class="form-select" name="subjects_id" required>
                                        <option value="">Choose Subject...</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="subjects_idError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Contact Number</label>
                                    <input class="form-control" name="contact_no" type="text" placeholder="Contact Number" required>
                                    <span class="text-danger" id="contact_noError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">NIC</label>
                                    <input class="form-control" name="nic" type="text" placeholder="NIC Number" required>
                                    <span class="text-danger" id="nicError"></span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3" placeholder="Address" required></textarea>
                                    <span class="text-danger" id="addressError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                                        <div class="show-hide">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="passwordError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" name="password_confirmation" type="password" placeholder="Confirm Password" required>
                                    <span class="text-danger" id="password_confirmationError"></span>
                                </div>
                                <input type="hidden" name="user_types_id" value="2">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-teacher-btn">CREATE TEACHER</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Teacher Modal --}}
        <div class="modal fade bd-example-modal-lg" id="edit-teacher-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Edit Teacher</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="edit-teacher-form">
                            <input type="hidden" name="user_id" id="edit_user_id">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label">First Name</label>
                                    <input class="form-control" name="first_name" id="edit_first_name" type="text" placeholder="First name" required>
                                    <span class="text-danger" id="edit_first_nameError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Last Name</label>
                                    <input class="form-control" name="last_name" id="edit_last_name" type="text" placeholder="Last name" required>
                                    <span class="text-danger" id="edit_last_nameError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Email Address</label>
                                    <input class="form-control" name="email" id="edit_email" type="email" placeholder="teacher@example.com" required>
                                    <span class="text-danger" id="edit_emailError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Subject</label>
                                    <select class="form-select" name="subjects_id" id="edit_subjects_id" required>
                                        <option value="">Choose Subject...</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="edit_subjects_idError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Contact Number</label>
                                    <input class="form-control" name="contact_no" id="edit_contact_no" type="text" placeholder="Contact Number" required>
                                    <span class="text-danger" id="edit_contact_noError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">NIC</label>
                                    <input class="form-control" name="nic" id="edit_nic" type="text" placeholder="NIC Number" required>
                                    <span class="text-danger" id="edit_nicError"></span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="edit_address" rows="3" placeholder="Address" required></textarea>
                                    <span class="text-danger" id="edit_addressError"></span>
                                </div>
                                <input type="hidden" name="user_types_id" value="2">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="update-teacher-btn">UPDATE TEACHER</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reset Password Modal (Same as Admin) --}}
        <div class="modal fade" id="reset-password-modal" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Reset Password</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="reset-password-form">
                            <input type="hidden" name="user_id" id="reset_user_id">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="form-label">New Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" placeholder="New Password" required>
                                        <div class="show-hide">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="reset_passwordError"></span>
                                </div>
                                <div class="col-12 mb-2">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" name="password_confirmation" type="password" placeholder="Confirm Password" required>
                                    <span class="text-danger" id="reset_password_confirmationError"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="reset-password-btn">RESET PASSWORD</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Teacher Users List --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>All Teacher Users</h3>
                        </div>
                        <div class="list-product-header">
                            <div>
                                <button class="btn btn-primary" title="Add New Teacher" data-bs-toggle="modal"
                                    data-bs-target="#add-teacher-modal">
                                    <i class="fa-solid fa-plus"></i> Add Teacher
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="teacher-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Contact No</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Registered Date</th>
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
        .show-hide {
            position: absolute;
            right: 20px;
            top: 20px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .btn-group-sm > .btn, .btn-sm {
            margin-right: 5px;
        }
    </style>
@endpush


@section('scripts')
    <script>
        $(document).ready(function() {
            loadTeachers();

            // Password show/hide functionality
            initPasswordToggle();

            // Add Teacher
            $('#add-teacher-btn').click(function() {
                submitForm('#add-teacher-form', '{{ route("users.store") }}', 'POST', '#add-teacher-modal', '#add-teacher-btn', 'CREATE TEACHER');
            });

            // Edit Teacher
            $(document).on('click', '.edit-user', function() {
                const userId = $(this).data('id');
                editTeacher(userId);
            });

            // Update Teacher
            $('#update-teacher-btn').click(function() {
                submitForm('#edit-teacher-form', '{{ route("users.update") }}', 'POST', '#edit-teacher-modal', '#update-teacher-btn', 'UPDATE TEACHER');
            });

            // Reset Password
            $(document).on('click', '.reset-password', function() {
                const userId = $(this).data('id');
                $('#reset_user_id').val(userId);
                $('#reset-password-modal').modal('show');
            });

            $('#reset-password-btn').click(function() {
                submitForm('#reset-password-form', '{{ route("users.reset-password") }}', 'POST', '#reset-password-modal', '#reset-password-btn', 'RESET PASSWORD');
            });

            // Deactivate/Activate User
            $(document).on('click', '.deactivate-user', function() {
                const userId = $(this).data('id');
                changeUserStatus(userId, 'deactivate');
            });

            $(document).on('click', '.activate-user', function() {
                const userId = $(this).data('id');
                changeUserStatus(userId, 'activate');
            });

            // Modal reset on close
            $('#add-teacher-modal').on('hidden.bs.modal', function() {
                resetForm('#add-teacher-form');
                clearErrors();
            });

            $('#edit-teacher-modal').on('hidden.bs.modal', function() {
                resetForm('#edit-teacher-form');
                clearErrors();
            });

            $('#reset-password-modal').on('hidden.bs.modal', function() {
                resetForm('#reset-password-form');
                clearErrors();
            });
        });

        function loadTeachers() {
            showPreloader();

            console.log("Loading teachers...");

            $.ajax({
                url: '{{ route("load.users") }}',
                method: 'GET',
                data: { user_types_id: 2 },
                success: function(response) {
                    console.log("Teachers loaded successfully", response);

                    $('#teacher-table').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'pageLength', 'csv', 'excel', 'pdf', 'print'
                        ],
                        pageLength: 25,
                        lengthChange: true,
                        order: [],
                        destroy: true,
                        tooltip: true,
                        data: response,
                        columns: [
                            { data: 'name', title: 'Name' },
                            { data: 'email', title: 'Email Address' },
                            { data: 'contact', title: 'Contact No' },
                            { data: 'subject', title: 'Subject' },
                            { data: 'status', title: 'Status' },
                            { data: 'created_date', title: 'Registered Date' },
                            { data: 'action', title: 'Action', orderable: false }
                        ],
                        responsive: true,
                        language: {
                            processing: "Loading teachers...",
                            emptyTable: "No teachers found",
                            zeroRecords: "No matching teachers found"
                        }
                    });

                    hidePreloader();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading teachers:', error);
                    toastr.error('Failed to load teacher users', 'Error');
                    hidePreloader();
                }
            });
        }

        function editTeacher(userId) {
            showPreloader();
            clearErrors();

            $.ajax({
                url: '{{ route("users.edit") }}',
                method: 'GET',
                data: { id: userId },
                success: function(response) {
                    console.log("Teacher data loaded for edit", response);

                    // Fill user basic information
                    $('#edit_user_id').val(response.user.id);
                    $('#edit_first_name').val(response.user.first_name);
                    $('#edit_last_name').val(response.user.last_name);
                    $('#edit_email').val(response.user.email);

                    // Fill teacher specific information
                    if (response.teacher) {
                        $('#edit_subjects_id').val(response.teacher.subjects_id);
                        $('#edit_contact_no').val(response.teacher.contact_no);
                        $('#edit_address').val(response.teacher.address);
                        $('#edit_nic').val(response.teacher.nic);
                    } else {
                        // Clear teacher fields if no teacher data
                        $('#edit_subjects_id').val('');
                        $('#edit_contact_no').val('');
                        $('#edit_address').val('');
                        $('#edit_nic').val('');
                    }

                    $('#edit-teacher-modal').modal('show');
                    hidePreloader();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading teacher data:', error);
                    toastr.error('Failed to load teacher data', 'Error');
                    hidePreloader();
                }
            });
        }

        function submitForm(formId, url, method, modalId, buttonId, originalText) {
            const form = $(formId);
            const formData = new FormData(form[0]);
            const button = $(buttonId);

            // Add CSRF token
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            //add user type to form
            formData.append('user_types_id', 2);

            // Validate form before submission
            if (!validateTeacherForm(formId)) {
                return false;
            }

            button.prop('disabled', true).text('Please Wait...');
            clearErrors();
            showPreloader();

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Form submitted successfully", response);

                    toastr.success(response.message || 'Operation completed successfully', 'Success', {
                        timeOut: 4000,
                        fadeOut: 1000
                    });

                    $(modalId).modal('hide');
                    resetForm(formId);
                    loadTeachers();
                    hidePreloader();
                },
                error: function(xhr) {
                    console.error("Form submission error", xhr);

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON?.errors || {};
                        displayErrors(errors);
                        toastr.error('Please fix the validation errors', 'Validation Error');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong', 'Error');
                    }

                    hidePreloader();
                },
                complete: function() {
                    button.prop('disabled', false).text(originalText);
                }
            });
        }

        function validateTeacherForm(formId) {
            const form = $(formId);
            let isValid = true;

            // Clear previous errors
            clearErrors();

            // Check required fields
            form.find('input[required], select[required], textarea[required]').each(function() {
                const field = $(this);
                const value = field.val().trim();
                const fieldName = field.attr('name');

                if (!value) {
                    displayFieldError(fieldName, 'This field is required');
                    isValid = false;
                }
            });

            // Email validation
            const email = form.find('input[name="email"]').val();
            if (email && !isValidEmail(email)) {
                displayFieldError('email', 'Please enter a valid email address');
                isValid = false;
            }

            // Password validation for add form
            if (formId === '#add-teacher-form') {
                const password = form.find('input[name="password"]').val();
                const confirmPassword = form.find('input[name="password_confirmation"]').val();

                if (password && password.length < 8) {
                    displayFieldError('password', 'Password must be at least 8 characters');
                    isValid = false;
                }

                if (password !== confirmPassword) {
                    displayFieldError('password_confirmation', 'Password confirmation does not match');
                    isValid = false;
                }
            }

            // Contact number validation
            const contactNo = form.find('input[name="contact_no"]').val();
            if (contactNo && !isValidContactNumber(contactNo)) {
                displayFieldError('contact_no', 'Please enter a valid contact number');
                isValid = false;
            }

            // NIC validation
            const nic = form.find('input[name="nic"]').val();
            if (nic && !isValidNIC(nic)) {
                displayFieldError('nic', 'Please enter a valid NIC number');
                isValid = false;
            }

            return isValid;
        }

        function changeUserStatus(userId, action) {
            const actionText = action === 'activate' ? 'activate' : 'deactivate';
            const confirmText = `Are you sure you want to ${actionText} this teacher?`;

            Swal.fire({
                title: confirmText,
                text: action === 'deactivate' ? 'This teacher will not be able to access the system.' : 'This teacher will be able to access the system again.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'activate' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${actionText}!`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    showPreloader();

                    $.ajax({
                        url: `/users/${action}/${userId}`,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(`User ${action}d successfully`, response);

                            Swal.fire({
                                title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)}d!`,
                                text: response.message || `Teacher has been ${action}d successfully.`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            loadTeachers();
                            hidePreloader();
                        },
                        error: function(xhr) {
                            console.error(`Error ${action}ing user:`, xhr);

                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || `Failed to ${action} teacher`,
                                icon: 'error'
                            });

                            hidePreloader();
                        }
                    });
                }
            });
        }

        function initPasswordToggle() {
            $(document).on('click', '.show-hide span', function() {
                const input = $(this).closest('.form-input').find('input');
                const type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);
                $(this).toggleClass('show');
            });
        }

        function resetForm(formId) {
            const form = $(formId);
            form[0].reset();

            // Reset select elements
            form.find('select').each(function() {
                $(this).val('').trigger('change');
            });

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
                `#edit_${field}Error`,
                `#reset_${field}Error`
            ];

            const inputSelectors = [
                `[name="${field}"]`,
                `#${field}`,
                `#edit_${field}`,
                `#reset_${field}`
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

        // Validation helper functions
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidContactNumber(contactNo) {
            const contactRegex = /^[\d\s\-\+\(\)]{7,15}$/;
            return contactRegex.test(contactNo);
        }

        function isValidNIC(nic) {
            // Sri Lankan NIC validation (old format: 9 digits + V/X, new format: 12 digits)
            const oldNicRegex = /^[0-9]{9}[vVxX]$/;
            const newNicRegex = /^[0-9]{12}$/;
            return oldNicRegex.test(nic) || newNicRegex.test(nic);
        }

        // Real-time validation
        $(document).on('blur', 'input[name="email"]', function() {
            const email = $(this).val();
            const fieldName = $(this).attr('name');

            if (email && !isValidEmail(email)) {
                displayFieldError(fieldName, 'Please enter a valid email address');
            } else {
                clearFieldError(fieldName);
            }
        });

        $(document).on('blur', 'input[name="contact_no"]', function() {
            const contactNo = $(this).val();
            const fieldName = $(this).attr('name');

            if (contactNo && !isValidContactNumber(contactNo)) {
                displayFieldError(fieldName, 'Please enter a valid contact number');
            } else {
                clearFieldError(fieldName);
            }
        });

        $(document).on('blur', 'input[name="nic"]', function() {
            const nic = $(this).val();
            const fieldName = $(this).attr('name');

            if (nic && !isValidNIC(nic)) {
                displayFieldError(fieldName, 'Please enter a valid NIC number');
            } else {
                clearFieldError(fieldName);
            }
        });

        $(document).on('keyup', 'input[name="password_confirmation"]', function() {
            const password = $('input[name="password"]').val();
            const confirmPassword = $(this).val();

            if (confirmPassword && password !== confirmPassword) {
                displayFieldError('password_confirmation', 'Password confirmation does not match');
            } else {
                clearFieldError('password_confirmation');
            }
        });

        function clearFieldError(field) {
            const errorSelectors = [
                `#${field}Error`,
                `#edit_${field}Error`,
                `#reset_${field}Error`
            ];

            const inputSelectors = [
                `[name="${field}"]`,
                `#${field}`,
                `#edit_${field}`,
                `#reset_${field}`
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


    </script>
@endsection
