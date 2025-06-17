@extends('layouts.admin')

@section('title')
    Active Users
@endsection

@section('content')
    <!-- Container-fluid starts-->
    <div class="container-fluid" style="padding-top:25px">


        {{-- add user modal --}}
        <div class="modal fade bd-example-modal-lg" id="add-user-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Add New User</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body custom-input">
                        <form id="add-user-form" class="">
                            {{-- basic-informations --}}
                            <div class="row">
                                <div class="col-3 mb-2">
                                    <label class="form-label float-end">User Level</label>
                                </div>
                                <div class="col-6">
                                    <select name="user_level" id="user_level" class="form-select" onchange="manageFields()">
                                        <option value="" selected hidden>Choose...</option>
                                        @foreach ($user_types as $item)
                                            <option value="{{ $item->id }}">{{ $item->user_type }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="user_levelError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">First name</label>
                                    <input class="form-control" name="first_name" type="text" placeholder="First name"
                                        aria-label="First name" required>
                                    <span class="text-danger" id="first_nameError"></span>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Last name</label>
                                    <input class="form-control" name="last_name" type="text" placeholder="Last name"
                                        aria-label="Last name" required>

                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Contact Number</label>
                                    <div class="d-flex">
                                        <select name="phone_code" class="form-select"
                                            style="width:30%;border-radius: 0.375rem 0rem 0rem 0.375rem;">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->phonecode }}">{{ $country->phonecode }}</option>
                                            @endforeach
                                        </select>
                                        <input class="form-control" name="contact_no" type="text"
                                            style="border-radius: 0rem 0.375rem 0.375rem 0rem;" placeholder="Contact Number"
                                            required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Email address</label>
                                    <input class="form-control" name="email" type="email"
                                        placeholder="pesamof475@saeoil.com" required>
                                    <span class="text-danger" id="emailError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" id="password" name="password"
                                            placeholder="*********">
                                        <div class="show-hide" style="display: block;">
                                            <span class="show"></span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="passwordError"></span>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="password">Confirm Password</label>
                                    <input class="form-control" name="confirm_password" type="password"
                                        id="confirm_password" placeholder="Re-enter password" onkeyup="checkPassword()">
                                    <span class="text-danger" id="confirm_passwordError"></span>
                                </div>
                            </div>

                            {{-- location data --}}
                            <div class="row" id="location-data">
                                <div class="col-6">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="single-select form-select" name="country" id="country"
                                        onchange="loadCities();">
                                        <option selected="" disabled="" value="">Choose...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="city">City</label>
                                    <select class="single-select form-select" name="city" id="city">
                                        <option selected="" disabled="" value="">Choose...</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            {{-- ticket manager data --}}
                            <div class="row mb-3 g-3" id="ticket-manager-data">
                                <div class="col-6">
                                    <label class="form-label">Company Name</label>
                                    <input class="form-control" name="company_name" type="text"
                                        placeholder="Company name">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Company Address</label>
                                    <input class="form-control" name="company_address" type="text"
                                        placeholder="Company address">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Company Contact Number</label>
                                    <input class="form-control" name="company_contact_number" type="text"
                                        placeholder="Company contact number">
                                </div>
                            </div>

                            {{-- customer data --}}
                            <div class="row mb-3" id="customer-data">
                                <div class="col-6">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" name="address" type="text" placeholder="address">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="formFile">Profile Image</label>
                                    <input class="form-control" name="profile_image" type="file">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary float-end btn-shadow"
                            id="add-btn">CREATE</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- update user modal --}}
        <div class="modal fade bd-example-modal-lg" id="edit-user-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Update User</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body custom-input">
                        <form id="edit-user-form" class="">
                            {{-- basic-informations --}}
                            <div class="row">
                                <div class="col-3 mb-2">
                                    <label class="form-label float-end">User Level</label>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="user_id" id="user_id" hidden>
                                    <select name="user_level" id="edit_user_level" class="form-select"
                                        onchange="manageFieldsForEdit()">
                                        <option value="" selected hidden>Choose...</option>
                                        @foreach ($user_types as $item)
                                            <option value="{{ $item->id }}">{{ $item->user_type }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="edit_user_levelError"></span>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">First name</label>
                                    <input class="form-control" name="first_name" id="first_name" type="text"
                                        placeholder="First name" aria-label="First name" required>
                                    <span class="text-danger" id="edit_first_nameError"></span>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Last name</label>
                                    <input class="form-control" name="last_name" id="last_name" type="text"
                                        placeholder="Last name" aria-label="Last name" required>

                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Contact Number</label>
                                    <div class="d-flex">
                                        <select name="phone_code" class="form-select" id="phone_code"
                                            style="width:30%;border-radius: 0.375rem 0rem 0rem 0.375rem;">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->phonecode }}">{{ $country->phonecode }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input class="form-control" name="contact_no" id ="contact_no" type="text"
                                            style="border-radius: 0rem 0.375rem 0.375rem 0rem;"
                                            placeholder="Contact Number" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Email address</label>
                                    <input class="form-control" name="email" type="email" id="email"
                                        placeholder="pesamof475@saeoil.com" required>
                                    <span class="text-danger" id="edit_emailError"></span>
                                </div>
                            </div>

                            {{-- location data --}}
                            <div class="row" id="edit_location_data">
                                <div class="col-6">
                                    <label class="form-label" for="country">Country</label>
                                    <select class="edit-single-select form-select" name="country" id="edit_country"
                                        onchange="loadCitiesForEdit();">
                                        <option selected="" disabled="" value="">Choose...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="city">City</label>
                                    <select class="edit-single-select form-select" name="city" id="edit_city">
                                        <option selected="" disabled="" value="">Choose...</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->city }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- ticket manager data --}}
                            <div class="row mb-3 g-3" id="edit_ticket_manager_data">
                                <div class="col-6">
                                    <label class="form-label">Company Name</label>
                                    <input class="form-control" name="company_name" id="company_name" type="text"
                                        placeholder="Company name">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Company Address</label>
                                    <input class="form-control" name="company_address" id="company_address"
                                        type="text" placeholder="Company address">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Company Contact Number</label>
                                    <input class="form-control" name="company_contact_number" id="company_contact_number"
                                        type="text" placeholder="Company contact number">
                                </div>
                            </div>

                            {{-- customer data --}}
                            <div class="row mb-3" id="edit_customer_data">
                                <div class="col-6">
                                    <label class="form-label">Address</label>
                                    <input class="form-control" name="address" id="address" type="text"
                                        placeholder="address">
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label" for="formFile">Profile Image</label>
                                    <input class="form-control" name="profile_image" type="file">
                                </div>
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <div class="profile-image" id="profile-image">
                                        <img src="{{ asset('assets/images/avtar/3.jpg') }}" alt="profile">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary float-end btn-shadow"
                            id="btn-save">UPDATE</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- reset password modal --}}
        <div class="modal fade bd-example-modal-lg" id="reset-password-modal" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5">Reset Password</h3>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body custom-input">
                        <form id="reset-password-form" class="">

                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="form-label" for="password">Password</label>

                                    <div class="form-input position-relative">
                                        <input type="text" name="user_id" id="reset_password_user_id" hidden>
                                        <input class="form-control" type="password" id="reset_password" name="password"
                                            placeholder="*********">
                                        <div class="show-hide" style="display: block;">
                                            <span class="show" id="span"></span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="reset_passwordError"></span>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="password">Confirm Password</label>
                                    <input class="form-control" name="confirm_password" type="password"
                                        id="reset_confirm_password" placeholder="Re-enter password"
                                        onkeyup="checkResetPassword()">
                                    <span class="text-danger" id="reset_confirm_passwordError"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary float-end btn-shadow" id="reset-btn">RESET</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- users list --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>All Active Users</h3>
                        </div>
                        <div class="list-product-header">
                            <div>
                                <div class="light-box"><a data-bs-toggle="collapse" href="#collapseProduct"
                                        title="Filter Users" role="button" aria-expanded="false"
                                        aria-controls="collapseProduct"><i class="filter-icon show"
                                            data-feather="filter"></i><i class="icon-close filter-close hide"></i></a>
                                </div>
                                <button class="btn btn-primary" title="Add New User" data-bs-toggle="modal"
                                    data-original-title="test" data-bs-target="#add-user-modal"><i
                                        class="fa-solid fa-plus"></i>Add
                                    User</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="collapse" id="collapseProduct">
                            <div class="list-product-body pb-3">
                                <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 g-3">
                                    <div class="col">
                                        <select class="form-select" onchange="loadActiveUsers();" id="filter_user_type"
                                            aria-label="Default select example">
                                            <option selected="" value="0">Choose User Type</option>
                                            @foreach ($user_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->user_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="display" id="user-table">
                                <thead>
                                    <tr>
                                        <th>User Level</th>
                                        <th>Name</th>
                                        <th>Contact No</th>
                                        <th>Email Address</th>
                                        <th>Registered Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
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
        }

        .single-select {
            border: 0.0625rem solid #EEEEEE;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: auto;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
@endpush

@section('scripts')
    <!-- password_show-->

    <script>
        loadActiveUsers();
        manageFields();
        showHidePassword();


        $('.single-select').select2({
            dropdownParent: $('#add-user-modal')
        });

        $('.edit-single-select').select2({
            dropdownParent: $('#edit-user-modal')
        });

        $('.show-pass').on('click', function() {
            $(this).toggleClass('active');
            if ($('#add-password').attr('type') == 'password') {
                $('#add-password').attr('type', 'text');
            } else if (jQuery('#add-password').attr('type') == 'text') {
                $('#add-password').attr('type', 'password');
            }
        });

        function showHidePassword() {
            var showHideElements = document.querySelectorAll(".show-hide");
            var passwordInput = document.querySelector('#password');
            var passwordInput2 = document.querySelector('#reset_password');
            var showHideSpan = document.querySelector(".show-hide span");
            var showHideSpan2 = document.querySelector("#span");

            showHideElements.forEach(function(element) {
                element.style.display = "block";
            });

            showHideSpan.classList.add("show");
            showHideSpan2.classList.add("show");

            showHideSpan.addEventListener("click", function() {
                if (showHideSpan.classList.contains("show")) {
                    passwordInput.setAttribute("type", "text");
                    showHideSpan.classList.remove("show");
                } else {
                    passwordInput.setAttribute("type", "password");
                    showHideSpan.classList.add("show");
                }
            });

            showHideSpan2.addEventListener("click", function() {
                if (showHideSpan.classList.contains("show")) {
                    passwordInput2.setAttribute("type", "text");
                    showHideSpan2.classList.remove("show");
                } else {
                    passwordInput2.setAttribute("type", "password");
                    showHideSpan2.classList.add("show");
                }
            });
        }

        function loadActiveUsers() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            showPreloader();

            let user_types_id = $('#filter_user_type').val();

            $.ajax({
                type: "GET",
                url: "{{ url('/load/active-users') }}",
                data: {
                    user_types_id: user_types_id,
                },
                dataType: 'json',
                success: function(response) {
                    console.log("active users ..." + response);
                    var table = $('#user-table').DataTable({
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
                        columns: [{
                                data: 'type',
                                title: 'User Level'
                            },
                            {
                                data: 'name',
                                title: 'Name'
                            },
                            {
                                data: 'contact',
                                title: 'Contact No'
                            },
                            {
                                data: 'email',
                                title: 'Email Address'
                            },
                            {
                                data: 'created_date',
                                title: 'Registered Date'
                            },
                            {
                                data: 'action',
                                title: 'Action',
                            },
                        ]
                    });

                    hidePreloader();
                }
            });
        }

        function manageFields() {
            let user_level = $('#user_level').val();
            if (user_level == 1) {
                $('#location-data').hide();
                $('#ticket-manager-data').hide();
                $('#customer-data').hide();
            } else if (user_level == 2) {
                $('#location-data').show();
                $('#ticket-manager-data').show();
                $('#customer-data').hide();
            } else if (user_level == 3) {
                $('#location-data').show();
                $('#ticket-manager-data').hide();
                $('#customer-data').show();
            } else {
                $('#location-data').hide();
                $('#ticket-manager-data').hide();
                $('#customer-data').hide();
            }
        }

        function loadCities() {
            let country = $('#country').val();
            if (country) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/load/cities') }}",
                    data: {
                        country: country,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("cities ..." + response);
                        if (response != "No-data") {
                            var cities = $('#city').html('');
                            response.forEach(function(item) {
                                cities.append('<option value="' + item.id + '">' + item.city +
                                    '</option>');
                            });
                        }
                    }
                })
            }
        }

        function checkPassword() {
            let password = $('#password').val();
            let confirm_password = $('#confirm_password').val();

            if (password != confirm_password) {
                $('#confirm_passwordError').text('Passwords do not match');
            } else {
                $('#confirm_passwordError').text('');
            }
        }

        function resetErrors() {
            $('#confirm_passwordError').text("");
            $('#passwordError').text("");
            $('#first_nameError').text("");
            $('#emailError').text("");
            $('#user_levelError').text("");
            $('#edit_first_nameError').text("");
            $('#edit_emailError').text("");
            $('#edit_user_levelError').text("");
        }

        function resetForm() {
            $('#add-user-form').trigger("reset");
            $('#country').val('').trigger('change');
            $('#city').val('').trigger('change');
        }

        //functions for editing user
        function loadCitiesForEdit(city = '') {
            let country = $('#edit_country').val();
            if (country) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/load/cities') }}",
                    data: {
                        country: country,
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("cities ..." + response);
                        if (response != "No-data") {
                            var cities = $('#edit_city').html('');
                            response.forEach(function(item) {
                                if (city != '' && item.id == city) {
                                    cities.append('<option value="' + item.id + '" selected>' + item
                                        .city +
                                        '</option>');
                                } else {
                                    cities.append('<option value="' + item.id + '">' + item.city +
                                        '</option>');
                                }
                            });
                        }
                    }
                })
            }
        }

        function manageFieldsForEdit() {
            let user_level = $('#edit_user_level').val();
            if (user_level == 1) {
                $('#edit_location_data').hide();
                $('#edit_ticket_manager_data').hide();
                $('#edit_customer_data').hide();
            } else if (user_level == 2) {
                $('#edit_location_data').show();
                $('#edit_ticket_manager_data').show();
                $('#edit_customer_data').hide();
            } else if (user_level == 3) {
                $('#edit_location_data').show();
                $('#edit_ticket_manager_data').hide();
                $('#edit_customer_data').show();
            } else {
                $('#edit_location_data').hide();
                $('#edit_ticket_manager_data').hide();
                $('#edit_customer_data').hide();
            }
        }

        function resetEditForm() {
            $('#edit-user-form').trigger("reset");
            $('#profile-image').html("");
            $('#edit_country').val('').trigger('change');
            $('#edit_city').val('').trigger('change');
        }

        function checkResetPassword() {
            let password = $('#reset_password').val();
            let confirm_password = $('#reset_confirm_password').val();

            if (password != confirm_password) {
                $('#reset_confirm_passwordError').text('Passwords do not match');
            } else {
                $('#reset_confirm_passwordError').text('');
            }
        }



        //CRUD methods
        $(document).ready(function() {

            //edit user
            $('body').on('click', '.edit', function() {
                showPreloader();

                resetEditForm();

                var id = $(this).data('id');
                console.log(id);

                $('#edit-user-modal').modal('show');
                $('#password_form').trigger("reset");
                $('#edit_office_use_only_form').trigger("reset");

                resetErrors();

                showPreloader();

                // ajax
                $.ajax({
                    type: "GET",
                    url: "{{ url('/users/edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var user = response.user;

                        $("#btn-save").html('Update');
                        $("#user_id").val(user.id);
                        $("#first_name").val(user.first_name);
                        $("#last_name").val(user.last_name);
                        $("#email").val(user.email);
                        $("#edit_user_level").val(user.user_types_id);
                        $('#phone_code').val(user.phone_code);
                        $('#contact_no').val(user.contact_no);

                        if (user.user_types_id == 2) {
                            let manager = response.manager;
                            $('#edit_country').val(manager.countries_id).trigger('change');
                            $('#edit_city').val(manager.cities_id).trigger('change');
                            $("#company_name").val(manager.company_name);
                            $('#company_address').val(manager.company_address);
                            $('#company_contact_number').val(manager.company_contact_no);
                            loadCitiesForEdit(manager.cities_id);
                            $('#edit_location_data').show();
                            $('#edit_ticket_manager_data').show();
                            $('#edit_customer_data').hide();
                        }

                        if (user.user_types_id == 3) {
                            let customer = response.customer;
                            $('#edit_country').val(customer.countries_id).trigger('change');
                            $('#edit_city').val(customer.cities_id).trigger('change');
                            $('#address').val(customer.address);
                            loadCitiesForEdit(customer.cities_id);

                            if (customer.profile_image) {
                                $('#profile-image').html('<img src="/uploads/' + customer
                                    .profile_image + '" alt="profile">');
                            }

                            $('#edit_location_data').show();
                            $('#edit_ticket_manager_data').hide();
                            $('#edit_customer_data').show();
                        }

                        $('#edit-user-modal').modal('show');
                        manageFieldsForEdit();
                        hidePreloader();
                    },
                    error: function(response) {
                        toastr.error('Something went wrong!', 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        hidePreloader();
                    }
                });
            });

            // add new user
            $('body').on('click', '#add-btn', function(event) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                showPreloader();

                let formData = new FormData($('#add-user-form')[0]);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));


                $("#add-btn").html('Please Wait...');
                $("#add-btn").attr("disabled", true);

                resetErrors();

                $.ajax({
                    type: "POST",
                    url: "{{ url('/users/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-btn").html('CREATED');
                        $('#add-user-modal').modal('hide');
                        toastr.success('Successfully Added User!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        resetForm();
                        loadActiveUsers();
                        $("#add-btn").attr("disabled", false);
                        $("#add-btn").html('CREATE');
                        hidePreloader();
                    },
                    error: function(response) {

                        toastr.error('Something went wrong!', 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });

                        $("#add-btn").html('Try Again');
                        $("#add-btn").attr("disabled", false);


                        $('#confirm_passwordError').text(response.responseJSON.errors
                            .confirm_password);
                        $('#emailError').text(response.responseJSON.errors.email);
                        $('#passwordError').text(response.responseJSON.errors.password);
                        $('#user_levelError').text(response.responseJSON.errors.user_level);
                        $('#first_nameError').text(response.responseJSON.errors.first_name);
                    }
                });
            });

            //update user
            $('body').on('click', '#btn-save', function(event) {
                let EditformData = new FormData($('#edit-user-form')[0]);

                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                showPreloader();

                resetErrors();

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/users/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#btn-save").html('UPDATE');
                        $("#btn-save").attr("disabled", false);
                        $('#edit-user-modal').modal('hide');
                        toastr.success('Successfully Updated User!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        hidePreloader();
                        resetEditForm();
                        loadActiveUsers();
                        manageFieldsForEdit();
                    },
                    error: function(response) {
                        toastr.error('Something went wrong!', 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });

                        $("#btn-save").html('Try Again');
                        $("#btn-save").attr("disabled", false);
                        hidePreloader();

                        $('#edit_emailError').text(response.responseJSON.errors.email);
                        $('#edit_user_levelError').text(response.responseJSON.errors
                            .user_level);
                        $('#edit_first_nameError').text(response.responseJSON.errors
                            .first_name);
                    }
                });
            });

            //delete user
            $('body').on('click', '.delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure to deactivate user?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Deactivate It!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        let url = '{{ route('delete.user', ':id') }}'
                        url = url.replace(':id', id)

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: url,
                            success: function() {
                                loadActiveUsers();
                                Swal.fire(
                                    'Deactivated!',
                                    'This user has been deactivated.',
                                    'success'
                                );
                            },
                            error: function(response) {
                                toastr.error('Something went wrong!', 'Error Alert', {
                                    timeOut: 4000,
                                    fadeOut: 1000
                                });
                            }
                        })
                    }
                })
            });

            // reset password
            $('body').on('click', '.reset-password', function() {
                $('#reset-password-modal').modal('show');
                var id = $(this).data('id');
                $('#reset_password_user_id').val(id);
            });

            $('body').on('click', '#reset-btn', function(event) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let formData = new FormData($('#reset-password-form')[0]);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                showPreloader();
                $("#reset-btn").html('Please Wait...');
                $("#reset-btn").attr("disabled", true);

                $('#reset_passwordError').text('');
                $('#reset_confirm_passwordError').text('');

                $.ajax({
                    type: "POST",
                    url: "{{ url('/user/reset-password') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#reset-btn").html('RESET');
                        $('#reset-password-modal').modal('hide');
                        toastr.success('Successfully Reset Password!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        hidePreloader();
                        $('#reset-password-form').trigger("reset");
                        loadActiveUsers();
                        $("#reset-btn").attr("disabled", false);
                        $("#reset-btn").html('RESET');
                        hidePreloader();
                    },
                    error: function(response) {

                        toastr.error('Something went wrong!', 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });

                        $("#reset-btn").html('Try Again');
                        $("#reset-btn").attr("disabled", false);
                        hidePreloader();

                        $('#reset_passwordError').text(response.responseJSON.errors.password);
                        $('#reset_confirm_passwordError').text(response.responseJSON.errors
                            .confirm_password);
                    }
                });
            });
        });
    </script>
@endsection
