@extends('layouts.admin')

@section('title')
    Deactive Users
@endsection

@section('content')
    <!-- Container-fluid starts-->
    <div class="container-fluid" style="padding-top:25px">


        {{-- users list --}}
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="title">
                            <h3>All Deactive Users</h3>
                        </div>
                        <div class="list-product-header">
                            <div>
                                <div class="light-box"><a data-bs-toggle="collapse" href="#collapseProduct"
                                        title="Filter Users" role="button" aria-expanded="false"
                                        aria-controls="collapseProduct"><i class="filter-icon show"
                                            data-feather="filter"></i><i class="icon-close filter-close hide"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="collapse" id="collapseProduct">
                            <div class="list-product-body pb-3">
                                <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 g-3">
                                    <div class="col">
                                        <select class="form-select" onchange="loadDeactiveUsers();" id="filter_user_type"
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

@section('scripts')

    <script>
        loadDeactiveUsers();


        function loadDeactiveUsers() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            showPreloader();

            let user_types_id = $('#filter_user_type').val();

            $.ajax({
                type: "GET",
                url: "{{ url('/load/deactive-users') }}",
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

        //CRUD methods
        $(document).ready(function() {

            //activate user
            $('body').on('click', '.activate', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure to activate user?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Activate It!'
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
                                loadDeactiveUsers();
                                Swal.fire(
                                    'Activated!',
                                    'This user has been Activated.',
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
        });
    </script>
@endsection
