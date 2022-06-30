@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
            </div>

            <div class="card-body">
                <x-alert></x-alert>
                <form class="needs-validation" method="POST" action="{{ $update_url ?? '' }}" novalidate>
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
                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                placeholder="Role Name" value="{{ old('name') ?? $rollpermission->name }}">
                            @error('name')
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
                                    <th withd="10%!important">#</th>
                                    <th width="45%!important;">Menu</th>
                                    <th width="45%!important;">Sub Menu</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($userRole as $key1 => $value)
                                <tr>
                                    <td>{{ $key1 + 1 }}</td>
                                    <td>{{ $value['label'] }}
                                        <br>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" class="submenu submenu_{{ $key1 }}"
                                                {{in_array($value['menu_id'], $menuExp) ? "checked" : "" }}
                                                value="{{$value['menu_id']}}" serial_id="{{ $key1 }}"
                                                id="sub_{{ $value['sub_menu'] }}{{ $key1 }}" name="parent_id[]">
                                            <label for="sub_{{ $value['sub_menu'] }}{{ $key1 }}">
                                                Select All
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            @foreach ($value['sub_menu'] as $key => $submenu)
                                            <tr>
                                                <td>
                                                    <div class="icheck-primary d-inline">
                                                        <input type="checkbox" name="child_id[]"
                                                            {{in_array($submenu['id'], $submenuExp) ? "checked" : "" }}
                                                            value="{{ $submenu['id'] }}"
                                                            class="childmenu child_menu_{{ $key1 }}"
                                                            id="child_{{ $value['sub_menu'] }}{{ $key }}"
                                                            serial_id="{{ $key1 }}">
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
        </div>
    </div>
</div>

@endsection
@section('scripts')
@include('admin.pages.rollPermission.scripts')
@endsection
