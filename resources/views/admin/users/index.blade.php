<?php

use Request as Input;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
?>
@extends('layouts.master')
@section('title', 'Users')
@section('css')
@endsection
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Users</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Users
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                    <div class="form-group breadcrumb-right">
                        <div class="dropdown">
                            <a href="{{ route('admin.users.create') }} "> <button type="button" class="btn btn-primary"><i
                                        data-feather="plus"></i> Add User</button></a>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="content-body">
                <!-- Basic table -->
                <section id="ajax-datatable">
                    <div class="row">
                        <div class="col-12">
                            @include('admin.errors.error')
                            <div class="card">
                                <div class="card-datatable">
                                    <table class="datatables-ajax table" id="user-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
    @include('admin.confirmalert')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#status').select2({
                selectOnClose: true,
            });

            $('#role_id').select2({
                selectOnClose: true,
            });
            var initTable1 = function() {
                var table = $('#user-table');
                // begin first table
                table.DataTable({
                    lengthMenu: getPageLengthDatatable(),
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: {
                        url: "{{ route('admin.getusers') }}",
                        type: 'post',
                        data: function(data) {
                            data.fromValues = $("#filterData").serialize();
                        }
                    },
                    columns: [{
                            data: 'name',
                            name: 'name',
                            defaultContent: ''
                        },

                        {
                            data: 'email',
                            name: 'email'
                        },

                        {
                            data: 'role.name',
                            name: 'role.name'
                        },

                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            sortable: false,
                            responsivePriority: -1
                        },
                    ],
                });
            };
            initTable1();
            $("#status,#role_id").bind("change", function() {
                $('#user-table').DataTable().draw();
            });
            $("#delete-record").on("click", function() {
                var id = $("#id").val();
                var deleteUrl = baseUrl + '/admin/users/' + id;
                $('#delete-modal').modal('hide');
                $.ajax({
                    url: deleteUrl,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(data) {
                        toastr.success("@lang('admin.recordDelete')", "@lang('admin.success')");
                        $('#user-table').DataTable().draw();
                    },
                    error: function(data) {
                        toastr.error("@lang('admin.oopserror')", "@lang('admin.error')");
                    }
                });
            });
        });
    </script>
@endsection
