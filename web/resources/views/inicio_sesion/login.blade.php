@extends('layouts.app')
@section('title', 'Login')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <div class="border border-1 rounded">
            <div class="d-flex justify-content-center p-1 bg-secondary">
                <img src="{{asset('img/proyectat_logo.png')}}" alt="logo" class="text-center" width="250" height="100">
            </div>

            {{-- =========================================================== --}}

            <form class="bg-white p-3 mt-3" method="post" action="{{route('login.store')}}" autocomplete="off" id="formLogin">
                @csrf
                
                {{-- ============================ --}}

                <div class="mb-4">
                    <input name="usuario" type="text" class="w-100 form-control" id="usuario" placeholder="Usuario *" required>
                </div>

                {{-- ============================ --}}

                <div class="">
                    <span class="btn-show-pass">
                        <i class="zmdi zmdi-eye"></i>
                    </span>
                    <input name="clave" type="password" class="w-100 form-control" id="clave" placeholder="Contraseña *" required>
                </div>

                {{-- ============================ --}}
                

                <!-- Contenedor para el GIF -->
                <div id="loadingIndicatorStore" class="loadingIndicator">
                    <img src="{{asset('img/loading.gif')}}" alt="Procesando...">
                </div>

                {{-- ============================ --}}

                <div class="mt-5 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                </div>

                {{-- ============================ --}}

                <div class="mt-5 d-flex justify-content-end">
                    <a class="btn btn-warning" href="{{route('recuperar_clave')}}" style="color: blue">¿Olvidó la Contraseña?</a>
                </div>
            </form>
        </div>
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $( document ).ready(function() {
            $("#usuario").focus();

            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formLogin']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']"); // Busca el GIF del form actual

                const usuario = form.find("#usuario").prop("readonly", true).addClass("campo-inactivo").attr("title", "Campo no editable");
                const clave = form.find("#clave").prop("readonly", true).addClass("campo-inactivo").attr("title", "Campo no editable");

                // Dessactivar Botones y Mostrar Spinner
                loadingIndicator.show();
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Enviar formulario manualmente
                this.submit();
            });
        }); // FIN document.ready
    </script>
@stop


