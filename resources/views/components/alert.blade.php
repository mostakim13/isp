@if(session()->has('success'))
@section('scripts')
<script>
    $(function () {
        'use strict';
        var isRtl = $("html").attr('data-textdirection') === 'rtl',
            clearToastObj;
        toastr['success']('<?php echo Session::get("success");?>', 'Success!', {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl
        });
    });
</script>
@endsection
@endif


@if(session()->has('failed'))
<div class="alert alert-warning">
    {{Session::get("failed")}}
</div>
@section('scripts')
<script>
    $(function () {
        'use strict';
        var isRtl = $("html").attr('data-textdirection') === 'rtl',
            clearToastObj;
        toastr['error']('<?php echo Session::get("failed");?>', 'Error!', {
            closeButton: true,
            tapToDismiss: false,
            rtl: isRtl
        });
    });
</script>
@endsection
@endif


@if ($errors->any())
<div>
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        <div class="alert-body">
            <i data-feather='info'></i>
            <span> {{$error}}</span>
        </div>
    </div>
    @endforeach
</div>
@endif
