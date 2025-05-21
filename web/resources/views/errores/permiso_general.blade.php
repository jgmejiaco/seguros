@extends('layouts.app')

@section('content')
    {{-- INICIO Modal PERMISO DENEGADO GENERAL --}}
    <div class="modal fade show" id="modalPermisoDenegado" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content border-0 p-3">
                <div class="text-center p-4">
                    <h5 class="text-danger">Acceso Denegado</h5>
                    <p>{{ $mensaje }}</p>
                    <a href="{{ route('inicio.index') }}" class="btn btn-secondary mt-3">Ir al inicio</a>
                </div>
            </div>
        </div>
    </div>
    {{-- Backdrop semi-transparente para simular modal --}}
    <div class="modal-backdrop fade show"></div>
    {{-- FINAL Modal PERMISO DENEGADO GENERAL --}}
@endsection

