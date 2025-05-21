<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Informe de Producción de Líneas Personales Proyectat">
        <meta name="keywords" content="Informes, producción Proyectat">
        <meta name="author" content="JGMC Digital">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Proyectat - @yield('title')</title>

        {{-- ========================================= --}}

        {{-- Favicon --}}
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" type="image/x-icon">

        {{-- ========================================= --}}

        <!-- DataTable 1.13.6 -->
        <link rel="stylesheet" href="{{asset('DataTable1.13.6/dataTables.bootstrap5.min.css')}}" >
        <link rel="stylesheet" href="{{asset('DataTable1.13.6/buttons.bootstrap5.min.css')}}" >

        <!-- Bootstrap CSS 5.3.2 -->
        <!-- Se puede indicar la versión al final del nombre de la carpeta pero en los archivos debe ir al ppio -->
        <link rel="stylesheet" href="{{asset('bootstrap5.3.2/5.3.2_bootstrap.min.css')}}" >

        {{-- ========================================= --}}

        <!-- SELECT2 CSS -->
        <link rel="stylesheet" href="{{asset('select2/select2.min.css')}}" >

        {{-- ========================================= --}}

        <!-- FontAwesome 6 -->
        <link rel="stylesheet" href="{{asset('font_awesome6.7.2/css/all.min.css')}}"> {{-- Necesario para el ícono del logout --}}

        <!-- Styles Locales -->
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">

        {{-- ========================================= --}}

        {{-- Sweetalert2 (No necesita jquery para funcionar) --}}
        <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert2.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert2.min.css')}}">

        {{-- ========================================= --}}

        <!--  jQuery -->
        {{-- Aquí en el head funciona para todo, ubicado en el body, no funciona el spinner de los modales --}}
        <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>

        @yield('css')
    </head>

    {{-- =========================================================================== --}}
    {{-- =========================================================================== --}}

    <body>
        <div class="container-fluid p-0 position-relative">
            @php
                $rutas_excluidas = ['/', 'login', 'logout', 'cambiar_clave', 'recuperar_clave', 'recuperar_clave_link*'];

                $ruta_actual_excluida = false;
                foreach ($rutas_excluidas as $ruta) {
                    if (Request::is($ruta)) {
                        $ruta_actual_excluida = true;
                        break;
                    }
                }

                $mostrarComponentes = Auth::check() || !$ruta_actual_excluida;
            @endphp

            <div class="wrapper">
                {{-- Topbar solo si aplica --}}
                @if ($mostrarComponentes)
                    @include('layouts.header')
                @endif
        
                <div class="content @yield('content-class')">
                    @yield('content')
                </div>
        
                {{-- Footer solo si aplica --}}
                @if ($mostrarComponentes)
                    @include('layouts.footer')
                @endif
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- ======================================================== --}}

        <!-- DataTables Core -->
        <script src="{{asset('DataTable1.13.6/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('DataTable1.13.6/dataTables.bootstrap5.min.js')}}"></script> <!-- si usas bootstrap -->

        <!-- DataTables Buttons -->
        <script src="{{asset('DataTable1.13.6/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('DataTable1.13.6/buttons.bootstrap5.min.js')}}"></script>
        <script src="{{asset('DataTable1.13.6/buttons.html5.min.js')}}"></script>

        <!-- JSZip para exportar a Excel -->
        <script src="{{asset('DataTable1.13.6/jszip.min.js')}}"></script>

        <!-- Librerías necesarias para PDF -->
        <script src="{{ asset('DataTable1.13.6/pdfmake.min.js') }}"></script>
        <script src="{{ asset('DataTable1.13.6/vfs_fonts.js') }}"></script>

        {{-- ======================================================== --}}
        {{-- ======================================================== --}}

        <!-- Bootstrap JS 5.3.2, después, ya que puede depender de jQuery en algunos casos -->
        <!-- Se puede indicar la versión en la carpeta, en los archivos debe ir al ppio -->
        <script src="{{asset('bootstrap5.3.2/5.3.2_bootstrap.bundle.min.js')}}"></script> {{-- Bundle ya tiene popper --}}

        {{-- Es complemento de Bundle para las tabs --}}
        {{-- <script src="{{asset('bootstrap5.3.2/4.6.2_bootstrap.min.js')}}"></script> --}}
        
        {{-- ========================================================================= --}}

        <!-- SELECT2 JS -->
        <script src="{{asset('select2/select2.min.js')}}"></script>

        {{-- ========================================================================= --}}

        {{-- Sweetalert (No necesita jquery para funcionar) --}}
        <script src="{{asset('js/sweetalert2.all.js')}}"></script>
        <script src="{{asset('js/sweetalert2.min.js')}}"></script>

        {{-- ========================================================================= --}}
        
        <!-- SCRIPTS -->
        @include('sweetalert::alert')

        {{-- ========================================================================= --}}

        {{-- JS GENERAL --}}
        <script src="{{ asset('js/js.js') }}"></script>

        {{-- ========================================================================= --}}

        @yield('scripts')
    </body>
</html>
