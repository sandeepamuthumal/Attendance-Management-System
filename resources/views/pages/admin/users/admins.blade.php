@extends('layouts.admin')

@section('title')
    Admin Users
@endsection

@section('content')
    <div class="container-fluid" style="padding-top:25px">

        {{-- Add Admin Modal --}}
        <div class="modal fade bd-example-modal-lg" id="add-admin-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Add New Admin</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="add-admin-form">
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
                                <div class="col-12 mb-2">
                                    <label class="form-label">Email Address</label>
                                    <input class="form-control" name="email" type="email" placeholder="admin@example.com" required>
                                    <span class="text-danger" id="emailError"></span>
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
                                <input type="hidden" name="user_types_id" value="1">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-admin-btn">CREATE ADMIN</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Admin Modal --}}
        <div class="modal fade bd-example-modal-lg" id="edit-admin-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Edit Admin</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-input">
                        <form id="edit-admin-form">
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
                                <div class="col-12 mb-2">
                                    <label class="form-label">Email Address</label>
                                    <input class="form-control" name="email" id="edit_email" type="email" placeholder="admin@example.com" required>
                                    <span class="text-danger" id="edit_emailError"></span>
                                </div>
                                <input type="hidden" name="user_types_id" value="1">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="update-admin-btn">UPDATE ADMIN</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reset Password Modal --}}
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

        {{-- Admin Users List --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>All Admin Users</h3>
                        </div>
                        <div class="list-product-header">
                            <div>
                                <button class="btn btn-primary" title="Add New Admin" data-bs-toggle="modal"
                                    data-bs-target="#add-admin-modal">
                                    <i class="fa-solid fa-plus"></i> Add Admin
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="admin-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email Address</th>
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
            loadAdmins();

            // Password show/hide functionality
            initPasswordToggle();

            // Add Admin
            $('#add-admin-btn').click(function() {
                submitForm('#add-admin-form', '{{ route("users.store") }}', 'POST', '#add-admin-modal', '#add-admin-btn', 'CREATE ADMIN');
            });

            // Edit Admin
            $(document).on('click', '.edit-user', function() {
                const userId = $(this).data('id');
                editUser(userId);
            });

            // Update Admin
            $('#update-admin-btn').click(function() {
                submitForm('#edit-admin-form', '{{ route("users.update") }}', 'POST', '#edit-admin-modal', '#update-admin-btn', 'UPDATE ADMIN');
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
        });

        function loadAdmins() {
            $.ajax({
                url: '{{ route("load.users") }}',
                method: 'GET',
                data: { user_types_id: 1 },
                success: function(response) {
                    $('#admin-table').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['pageLength', 'csv', 'excel', 'pdf', 'print'],
                        pageLength: 25,
                        order: [],
                        destroy: true,
                        data: response,
                        columns: [
                            { data: 'name', title: 'Name' },
                            { data: 'email', title: 'Email Address' },
                            { data: 'status', title: 'Status' },
                            { data: 'created_date', title: 'Registered Date' },
                            { data: 'action', title: 'Action', orderable: false }
                        ]
                    });
                },
                error: function(xhr) {
                    toastr.error('Failed to load admin users', 'Error');
                }
            });
        }

        function editUser(userId) {
            $.ajax({
                url: '{{ route("users.edit") }}',
                method: 'GET',
                data: { id: userId },
                success: function(response) {
                    $('#edit_user_id').val(response.user.id);
                    $('#edit_first_name').val(response.user.first_name);
                    $('#edit_last_name').val(response.user.last_name);
                    $('#edit_email').val(response.user.email);
                    $('#edit-admin-modal').modal('show');
                },
                error: function(xhr) {
                    toastr.error('Failed to load user data', 'Error');
                }
            });
        }

        function submitForm(formId, url, method, modalId, buttonId, originalText) {
            const formData = new FormData($(formId)[0]);
            const button = $(buttonId);

            // Add CSRF token
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            button.prop('disabled', true).text('Please Wait...');
            clearErrors();

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message || 'Operation completed successfully', 'Success');
                    $(modalId).modal('hide');
                    $(formId)[0].reset();
                    loadAdmins();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON?.errors || {};
                    displayErrors(errors);
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong', 'Error');
                },
                complete: function() {
                    button.prop('disabled', false).text(originalText);
                }
            });
        }

        function changeUserStatus(userId, action) {
            const actionText = action === 'activate' ? 'activate' : 'deactivate';
            const confirmText = `Are you sure you want to ${actionText} this user?`;

            Swal.fire({
                title: confirmText,
                text: action === 'deactivate' ? 'This admin will not be able to access the system.' : 'This admin will be able to access the system again.',
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
                                text: response.message || `Admin has been ${action}d successfully.`,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            loadAdmins();
                            hidePreloader();
                        },
                        error: function(xhr) {
                            console.error(`Error ${action}ing user:`, xhr);

                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || `Failed to ${action} admin`,
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

        function clearErrors() {
            $('.text-danger').text('');
        }

        function displayErrors(errors) {
            $.each(errors, function(field, messages) {
                const errorElement = field.includes('edit_') ?
                    $(`#${field}Error`) :
                    $(`#${field}Error, #edit_${field}Error, #reset_${field}Error`);
                errorElement.text(messages[0]);
            });
        }
    </script>
@endsection
