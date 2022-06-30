@extends('admin.layouts.master')

@section('navbar-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> User Role </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    </li>
                    <li class="breadcrumb-item active"><span>Add New User ROle</span></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('admin-content')


<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <!-- /.card-header -->
            <div class="card-body">
                <form class="needs-validation" method="POST" action="{{ route('groups.store') }}" novalidate>
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="validationCustom01">Role Name * :
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" class="checkPermissionAll" id="checkPermissionAll">
                                    <label for="checkPermissionAll">
                                        All Check
                                    </label>
                                </div>
                            </label>
                            <input type="text" name="role_name" class="form-control" id="validationCustom01"
                                placeholder="Role Name" value="{{ old('role_name') }}">
                            @error('role_name')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">

                            @error('child_menu')
                            <span class=" error text-red text-bold">{{ $message }}</span>
                            @enderror



                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th withd="5%!important">#</th>
                                    <th width="20%!important;">Module</th>
                                    <th width="20%!important;">Menu</th>
                                    <th width="60%!important;">Permission</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($userRole as $key1 => $value)
                                <tr>
                                    <td>{{ $key1 + 2 }}</td>
                                    <td>{{ $value['label'] }}</td>
                                    <td>{{ $value['sub_menu'] }}
                                        <br>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="submenu submenu_{{ $key1 }}"
                                                serial_id="{{ $key1 }}" id="sub_{{ $value['sub_menu'] }}{{ $key1 }}">
                                            <label for="sub_{{ $value['sub_menu'] }}{{ $key1 }}">
                                                Select All
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            @foreach ($value['child_menu'] as $key => $submenu)
                                            <tr>
                                                <td>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" name="permission[]"
                                                            value="{{ $submenu['id'] }}" class="child_menu_{{ $key1 }}"
                                                            id="child_{{ $value['sub_menu'] }}{{ $key }}">
                                                        <label for="child_{{ $value['sub_menu'] }}{{ $key }}">
                                                            {{ $submenu['label'] }}
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-info" type="submit"><i class="fa fa-save"></i> &nbsp;Save</button>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

@endsection
@section('scripts')
@include('admin.roles.script')
@endsection
