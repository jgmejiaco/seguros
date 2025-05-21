@extends('layouts.app')
@section('title', 'Recuperar Clave')

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="border border-1 rounded">
            <div class="d-flex justify-content-center p-1 bg-secondary">
                <img src="{{asset('img/proyectat_logo.png')}}" alt="logo" class="text-center" width="250" height="100">
            </div>

            {{-- =========================================================== --}}

            <form class="bg-white p-3 mt-3" method="post" action="{{route('recuperar_clave_email')}}" autocomplete="off" id="formRecuperarClave">
                @csrf
                
                <div class="mb-4">
                    <input name="correo" type="email" class="w-100 form-control" id="correo" placeholder="Correo *" required >
                </div>

                {{-- ============================ --}}

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorStore" class="loadingIndicator">
                    <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
                </div>

                {{-- ============================ --}}

                <div class="mt-4 d-flex flex-column gap-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Enviar Correo</button>

                    <a href="{{route('login')}}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="fa fa-arrow-left"></i> Login
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#correo").focus();

            // formCrearUsuario para cargar gif en el submit
            $(document).on("submit", "form[id^='formRecuperarClave']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones y Mostrar Spinner
                loadingIndicator.show();
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                const correo = form.find("#correo").prop("readonly", true);
                
                // Enviar formulario manualmente
                this.submit();
            });
        });
    </script>
@endsection
