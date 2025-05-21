@extends('layouts.app')
@section('title', 'Editar Radicado')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="p-3 d-flex flex-column">
        <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Editar Radicado Líneas Personales</h5>

            <div class="p-3">
                <div class="d-flex justify-content-end pe-3 mt-10">
                    <div class="">
                        <a href="{{route('lineas_personales.index')}}" class="btn text-white" style="background-color:#337AB7">Radicados</a>
                    </div>
                </div>

                {{-- =============================================================== --}}
                {{-- =============================================================== --}}

                <x-form action="{{route('lineas_personales.update', $resLineaPersonalEdit->id_lineas_personal)}}" method="PUT" class="mt-2" id="formEditarRadicado_{{$resLineaPersonalEdit->id_lineas_personal}}" autocomplete="off" has-files >
                
                    @include('lineas_personales.fields_radicado')

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorRadicadoUpdate_{{$resLineaPersonalEdit->id_lineas_personal}}" class="loadingIndicator">
                        <img src="{{asset('img/loading.gif')}}" alt="Procesando...">
                    </div>

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <div class="mt-5 mb-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-2" id="btnEditarRadicado_{{$resLineaPersonalEdit->id_lineas_personal}}">
                            <i class="fa-regular fa-floppy-disk"></i> Editar Radicado
                        </button>
                    </div>
                </x-form> {{-- FIN x-form --}}
            </div>
        </div> {{-- FIN div p-0 --}}
    </div> {{-- p-3 d-flex flex-column --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $( document ).ready(function() {
            $('#fecha_radicado').focus();

            // ===================================================================================
            // ===================================================================================

            $('#id_consultor').change(function() {
                let idConsultor = $(this).val();
                let consultor = $('#consultor').val('');
                let gerenteComercial = $('#gerente_comercial').val('');
                let liderComercial = $('#lider_comercial').val('');
                let equipoInformes = $('#equipo_informes').val('');
                
                console.log(idConsultor);
                console.log(gerenteComercial);
                console.log(liderComercial);
                console.log(equipoInformes);

                $.ajax({
                    async: true,
                    url: "{{route('query_consultor')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id_consultor': idConsultor
                    },
                    success: function (respuesta) {
                        console.log(respuesta);
                        console.log(respuesta.consultor);

                        consultor.val(respuesta.consultor);
                        gerenteComercial.val(respuesta.gerente_comercial);
                        liderComercial.val(respuesta.lider_comercial);
                        equipoInformes.val(respuesta.equipo_informes);

                        if(respuesta == "error_exception") {
                            Swal.fire('Error!', 'No fue posible consultar el Consultor!', 'error');
                            return;
                        }
                    }
                });
            });

            // ===================================================================================
            // ===================================================================================

            $('#id_producto').change(function() {
                let idProducto = $(this).val();
                let ramo = $('#ramo').val('');
                console.log(idProducto);

                $.ajax({
                    async: true,
                    url: "{{route('query_producto')}}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id_producto': idProducto
                    },
                    success: function (respuesta) {
                        console.log(respuesta);
                        console.log(respuesta.ramo);

                        ramo.val(respuesta.ramo);

                        if(respuesta == "error_exception") {
                            Swal.fire('Error!', 'No fue posible consultar el Ramo del Producto!', 'error');
                            return;
                        }
                    }
                });
            });

            // ===================================================================================
            // ===================================================================================

            // formCrearRadicado para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearRadicado']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']"); // Busca el GIF del form actual

                // Mostrar Spinner, Dessactivar Botones
                loadingIndicator.show();
                submitButton.prop("disabled", true).html("Creando... <i class='fa fa-spinner fa-spin'></i>");

                // Enviar formulario manualmente
                this.submit();
            });

            // ===================================================================================
            // ===================================================================================

            // Botón de submit de editar Radicado
            $(document).on("submit", "form[id^='formEditarRadicado_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el indicador de carga dinámicamente
                const submitButton = $(`#btnEditarRadicado_${id}`);
                const loadingIndicator = $(`#loadingIndicatorRadicadoUpdate_${id}`);

                // Lógica del botón
                submitButton.prop("disabled", true).html(
                    "Editando... <i class='fa fa-spinner fa-spin'></i>"
                );

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.readey
    </script>
@stop


