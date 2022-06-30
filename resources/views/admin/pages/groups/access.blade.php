@extends('admin.master')

@section('scripts')
<script>
    let checked = false;

    function check_toggle() {
        checked = !checked;
        $("input[type='checkbox']").prop("checked", checked);
    }

    function access_submit() {
        $("form.kt-form").submit();
    }
</script>
@endsection

@section('content')

<!-- begin:: Content -->
<div class="row">
    <div class="col-md-3 d-none d-md-block">
        <div class="card card-body">
            @foreach($groups as $group)
            <a href="{{ route('groups.update', [$group->id])}}"
                class="my-2 py-1 rounded d-block {{($group->id == $group_id ) ? 'bg-primary text-white' : '' }}">
                <span class="section">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <polygon fill="#000000" opacity="0.3"
                                    transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) "
                                    points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476" />
                                <path
                                    d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z"
                                    fill="#000000"
                                    transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) " />
                            </g>
                        </svg>
                    </span>
                    <span class="desc">
                        {{ $group->name }}
                    </span>
                </span>
            </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-9">

        <div class="kt-portlet kt-portlet--tabs">
            <div class="d-flex justify-content-between align-items-center">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{$group->name}}
                        <small>User Group access</small>
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            {{-- <a href="javascript:;" onclick="collapse_toggle()" class="btn btn-sm btn-label-info">
                                <i class="la la-check"></i> Collapse / Uncollapse
                            </a> --}}
                            <a href="javascript:;" onclick="check_toggle()" class="btn btn-sm btn-label-danger">
                                <i class="la la-check"></i> Check / Uncheck
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--begin::Form-->
            <form class="kt-form" action="{{route('groups.access', [$group->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="kt-portlet__body">
                    <x-alert></x-alert>

                    <!--begin::Accordion-->
                    <div class="accordion accordion-light  accordion-svg-icon">
                        @foreach($all_access as $access)
                        <div class="card">
                            <div class="card-header" id="heading{{ $loop->iteration }}">
                                <div class="card-title" data-toggle="collapse"
                                    data-target="#collapse{{$loop->iteration}}" aria-expanded="true"
                                    aria-controls="collapse{{$loop->iteration}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path
                                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                fill="#000000" fill-rule="nonzero"></path>
                                            <path
                                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                                            </path>
                                        </g>
                                    </svg>
                                    {{ $access[1] }}
                                </div>
                            </div>
                            <div id="collapse{{$loop->iteration}}" class="collapse show"
                                aria-labelledby="heading{{$loop->iteration}}">
                                <div class="card-body">
                                    <!--begin::Timeline 1-->
                                    <div class="kt-list-timeline">
                                        <div class="kt-list-timeline__items">
                                            @foreach($access["access"] as $permission_arr)
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">
                                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                                        <input type="checkbox" name="access[]"
                                                            value="{{ $permission_arr[0] }}" {{
                                                            in_array($permission_arr[0], $access_arr) ? "checked" : ""
                                                            }}>
                                                        <span></span>
                                                        {{ $permission_arr[1] }}
                                                    </label>
                                                </span>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>

                                    <!--end::Timeline 1-->
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!--end::Accordion-->
                </div>
                <div class="kt-portlet__foot kt-portlet__foot--solid">
                    <div class="kt-form__actions">
                        <div class="row justify-content-between">
                            <div class="col-4">
                                <button type="submit" class="btn btn-brand">Submit</button>
                            </div>
                            <div class="col-4 text-right">
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--end::Form-->
        </div>
    </div>
</div>
<!-- end:: Content -->

@endsection
