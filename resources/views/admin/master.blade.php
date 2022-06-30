<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <link rel="apple-touch-icon" href="{{asset('admin_assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{!! App\Models\Company::first()->favicon ?? ''!!}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
    <title>
        @if (isset($page_title) && $page_title)
        {{$page_title}} | {{ env('APP_NAME') }}
        @else
        {{ env('APP_NAME') }}
        @endif
    </title>
    @include('admin.include.style')

</head>


<body class="vertical-layout vertical-menu-modern navbar-floating footer-static pace-done menu-expanded"
    data-open="click" data-menu="vertical-menu-modern" data-col="">
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <!--**********************************
            Nav header end
            ***********************************-->

        <!--**********************************
                Header start
                ***********************************-->
        @include('admin.include.header')

        <!--**********************************
                    Header end ti-comment-alt
                    ***********************************-->

        <!--**********************************
                        Sidebar start
                        ***********************************-->
        <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
            <x-sidebar></x-sidebar>
        </div>



        <!--**********************************
                            Sidebar end
                            ***********************************-->

        <!--**********************************
                                Content body start
                                ***********************************-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
            ***********************************-->


        <!--**********************************
                Footer start
                ***********************************-->
        @include('admin.include.footer')
        <!--**********************************
                    Footer end
                    ***********************************-->

        <!--**********************************
                        Support ticket button start
        ***********************************-->

        <!--**********************************
            Support ticket button end
            ***********************************-->



    </div>
    <!--**********************************
        Main wrapper end
        ***********************************-->

    <!--**********************************
            Scripts
            ***********************************-->
    <!-- Required vendors -->


    @include('admin.include.script')
    @include('admin.include.alertmessage')

</body>

</html>
