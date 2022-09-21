<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/LogoPro.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/LogoPro.png') }}">
    <title>
        Beyond Limits
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/libraryJavierSpinoza/iconos/fuentesGoogle/fuente.css') }}" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="{{ asset('assets/libraryJavierSpinoza/iconos/iconfontawesome/fontawesomePlantilla.js') }}"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <!-- Material Icons -->
    <link href="{{ asset('assets/libraryJavierSpinoza/iconos/materialiconGoogle/iconsGoogle.css') }}" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

    @livewireStyles
    @stack('micss')
</head>

<body class="g-sidenav-show  bg-gray-300">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
        id="sidenav-main">
        {{-- menu --}}
        @include('items.menu')
        {{-- End menu --}}
    </aside>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <!-- Navbar -->
        {{-- @include('items.navbarNotifications') --}}
        {{-- este slot es para que funcione liveriwe --}}
        {{ $slot }}
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            {{-- contenido --}}
            @include('items.content')
            {{-- End contenido --}}
            <footer class="footer py-4  ">
                {{-- footer --}}
                @include('items.footer')
                {{-- End footer --}}
            </footer>
        </div>
    </main>
    <div class="fixed-plugin">
        {{-- setting --}}
        @include('items.setting')
        {{-- End setting --}}
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/endCharbJs/michart-bar.js') }}"></script>
    <script src="{{ asset('assets/js/endCharbJs/scrolBar.js') }}"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>

    @livewireScripts
    @stack('mijs')
</body>

</html>





















{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html> --}}
