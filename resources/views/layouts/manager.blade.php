<!DOCTYPE html >
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Tickets Director Event Manager Dashboard" />
    <meta name="keywords" content="Tickets Director Event Manager Dashboard" />
    <meta name="author" content="ticketsdirector" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Tickets Director</title>
    <!-- Favicon icon-->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- styles --}}
    @include('libraries.styles')
    @livewireStyles
</head>

<body>
    <!-- page-wrapper Start-->

    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->

    <!-- loader-->
    {{-- <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div> --}}

    <div id="preloader" class="hidden"></div>

    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        {{-- header --}}
        @include('components.nav')

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page sidebar start-->
            @include('components.sidebar')
            <!-- Page sidebar end-->


            <div class="page-body">

                @yield('content')

            </div>

            {{-- footer --}}
            @include('components.footer')
        </div>
    </div>

    {{-- scripts --}}
    @include('libraries.scripts')
    @yield('scripts')
    @livewireScripts
</body>

</html>
