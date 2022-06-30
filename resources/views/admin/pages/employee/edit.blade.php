@extends('admin.master')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <form action="{{ $update_url ?? '#' }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-alert></x-alert>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$page_heading ?? 'Edit'}}</h4>
                    <a href="{{$back_url ?? 'javascript:;'}}" class="btn btn-dark">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <label for="">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control input-rounded"
                                value="{{old('name') ?? $editinfo->name}}" name="name">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Email</label>
                            <input type="email" class="form-control input-rounded"
                                value="{{old('email') ?? $editinfo->email}}" name="email">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Personal Number <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-rounded"
                                value="{{old('personal_phone') ?? $editinfo->personal_phone}}" name="personal_phone">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Office Number</label>
                            <input type="number" class="form-control input-rounded"
                                value="{{old('office_phone') ?? $editinfo->office_phone}}" name="office_phone">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Marital Status</label>
                            <select name="marital_status" class="form-control">
                                <option {{$editinfo->marital_status == 'married' ? 'selected':""}}
                                    value="married">Married
                                </option>
                                <option {{$editinfo->marital_status == 'unmarried' ? 'selected':""}}
                                    value="unmarried">Unmarried</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Nid</label>
                            <input type="text" class="form-control input-rounded"
                                value="{{old('nid') ?? $editinfo->nid}}" name="nid">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Date Of Birth</label>
                            <input type="date" class="form-control input-rounded"
                                value="{{old('dob') ?? $editinfo->dob}}" name="dob">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control">
                                <option {{$editinfo->gender == 'male' ? 'selected':""}} value="male">Male</option>
                                <option {{$editinfo->gender == 'female' ? 'selected':""}} value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Reference</label>
                            <input type="text" class="form-control input-rounded"
                                value="{{old('reference') ?? $editinfo->reference}}" name="reference">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Experience</label>
                            <textarea name="experience" class="form-control input-rounded">
                                {{old('experience') ?? $editinfo->experience}}
                            </textarea>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Present Address</label>
                            <textarea name="present_address" class="form-control input-rounded">
                                {{old('present_address') ?? $editinfo->present_address}}
                            </textarea>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Permanent Address</label>
                            <textarea name="permanent_address" class="form-control input-rounded">
                                {{old('permanent_address') ?? $editinfo->permanent_address}}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Qualification Info</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <label for="">Achieved Degree</label>
                            <input type="text" class="form-control input-rounded"
                                value="{{old('achieved_degree') ?? $editinfo->achieved_degree}}" name="achieved_degree">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Institution</label>
                            <input type="text" class="form-control input-rounded"
                                value="{{old('institution') ?? $editinfo->institution}}" name="institution">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Passing Year</label>
                            <input type="number" class="form-control input-rounded"
                                value="{{old('passing_year') ?? $editinfo->passing_year}}" name="passing_year">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Office Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-1">
                            <label for="">Joining Date</label>
                            <input type="date" class="form-control input-rounded"
                                value="{{old('join_date') ?? $editinfo->join_date}}" name="join_date">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Department <span class="text-danger">*</span></label>
                            <select name="department_id" class="form-control">
                                <option selected disabled>Select Department</option>
                                @foreach($departments as $department)
                                <option {{$editinfo->department_id == $department->id ? 'selected':""}}
                                    value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Designation <span class="text-danger">*</span></label>
                            <select name="designation_id" class="form-control">
                                <option selected disabled>Select Designation</option>
                                @foreach($designations as $designation)
                                <option {{$editinfo->designation_id == $designation->id ? 'selected':""}}
                                    value="{{$designation->id}}">{{$designation->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Salary <span class="text-danger">*</span></label>
                            <input type="number" class="form-control input-rounded"
                                value="{{old('salary') ?? $editinfo->salary}}" name="salary">
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Status</label>
                            <select name="status" class="form-control">
                                <option {{$editinfo->status == "active" ? 'selected':""}} value="active">Crrently Active
                                </option>
                                <option {{$editinfo->status == "left" ? 'selected':""}} value="left">Left</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-1">
                            <label for="">Is Login</label>
                            <select name="is_login" id="_isLogin" onchange="isLogin()" class="form-control">
                                <option {{$editinfo->is_login == "true" ? 'selected':""}} value="true">Yes
                                </option>
                                <option {{$editinfo->is_login == "false" ? 'selected':""}} value="false">No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="_logindiv">
                <div class="card-header">
                    <h4 class="card-title">Login Info</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-1">
                            <label for="">User Name</label>
                            <input type="text" class="form-control input-rounded" readonly
                                value="{{old('username') ?? $editinfo->employelist->username ?? ''}}" name="username">
                        </div>
                        <div class="col-md-3 mb-1">
                            <label for="">Access Roll</label>
                            <select name="roll_id" class="form-control">
                                <option value="married">Select Roll</option>
                                @foreach($userrolls as $userroll)
                                <option {{$editinfo->employelist->roll_id ?? 1 == $userroll->id ? 'selected':""}}
                                    value="{{$userroll->id}}">{{$userroll->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-1">
                            <label for="">Password</label>
                            <input type="password" class="form-control input-rounded"
                                value="{{old('password') ?? $editinfo->password}}" name="password">
                        </div>

                        <div class="col-md-3 mb-1">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control input-rounded"
                                value="{{old('password_confirmation') ?? $editinfo->password_confirmation}}"
                                name="password_confirmation">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-1 form-group" style="text-align:right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>

    </div>
</div>

@endsection

@section('scripts')
<script>
    function isLogin() {
        let getValue = $('#_isLogin option:selected').val();
        if (getValue == 'true') {
            $('#_logindiv').removeClass('d-none')
        } else {
            $('#_logindiv').addClass('d-none')
        }

    }
    isLogin();
</script>
@endsection
