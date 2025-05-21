@extends('layouts.app')
@section('title', 'Inicio')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content-class', 'content-centered')

@section('content')
    <div class="text-center">
        @php
            $hora = now()->hour;
            $saludo = 'Hola 👋';

            if ($hora >= 5 && $hora < 12) {
                $saludo = 'Buenos días ☀️';
            } elseif ($hora >= 12 && $hora < 18) {
                $saludo = 'Buenas tardes 🌤️';
            } else {
                $saludo = 'Buenas noches 🌙';
            }
        @endphp

        <h2>{{ $saludo }}</h2>
        <h2>{{ $datosUsuario->nombre_completo ?? 'Visitante' }}</h2>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        
        }); // FIN DOMContentLoaded
    </script>
@stop


