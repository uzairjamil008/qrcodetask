@extends('layout.header')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/colors.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
{{ csrf_field() }}
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{$data['page_title']}}</h4>
                    <a class="btn btn-primary" href="{{url('admin/user')}}">Add User</a>
                </div>
                <div class="card-datatable p-2">
                    <table class="table dynamic_table font-weight-bold table-responsive">
                        <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Referral Code</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@include('includes.delete')
@endsection
@section('js')
<script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}">
<script type="text/javascript">
    $(document).ready(function() {
        $('.usermgt').addClass('sidebar-group-active');
    });

    $(document).ready(function() {
        $('.users').addClass('active');
        var userInfo = JSON.parse(localStorage.getItem("userInfo"));

        $('.dynamic_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('admin/get_users')}}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'first_name'
                },
                {
                    data: 'last_name'
                },
                {
                    data: 'referral_code'
                },
                {
                    data: 'email'
                },
                {
                    data: 'role_id'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                },
            ],
            'columnDefs': [{
                'targets': [7],
                'orderable': false,
            }]
        });

        $('.dynamic_table').on('draw.dt', function() {
            feather.replace();
        });

    });


    $(document).ready(function() {
        $('select[data-option-id]').each(function() {
            $(this).val($(this).data('option-id'));
        });

        $(document).on('click', '.btnstatus', function() {
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            var formdata = {
                'id': id,
                'status': status
            };
            var token = $('input[name=_token]').val();
            var current = $(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to update the user status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm it!',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        dataType: 'json',
                        data: formdata,
                        url: "{{url('admin/userstatus')}}",
                        success: function(response) {
                            current.attr('data-status', status);
                            if (response.status == 1) {
                                if (status == 'Active') {
                                    current.attr('data-status', 'Inactive');
                                    current.removeClass('badge-light-warning');
                                    current.addClass('badge-light-primary');
                                } else {
                                    current.attr('data-status', 'Active');
                                    current.removeClass('badge-light-primary');
                                    current.addClass('badge-light-warning');
                                }
                                current.html(status);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: 'User status has been updated.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>

@endsection