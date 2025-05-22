@extends('layouts.app')
@section('title', 'Crear Radicado')

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
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Crear Radicado Líneas Personales</h5>

            <div class="p-3">
                <div class="d-flex justify-content-end pe-3 mt-10">
                    <div class="">
                        <a href="{{route('lineas_personales.index')}}" class="btn text-white" style="background-color:#337AB7">Radicados</a>
                    </div>
                </div>

                {{-- =============================================================== --}}
                {{-- =============================================================== --}}

                <x-form action="{{route('lineas_personales.store')}}" method="POST" class="mt-2" id="formCrearRadicado" autocomplete="off" has-files >
                
                    @include('lineas_personales.fields_radicado')

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorStore" class="loadingIndicator">
                        <img src="{{asset('img/loading.gif')}}" alt="Procesando...">
                    </div>

                    {{-- ========================================================= --}}
                    {{-- ========================================================= --}}

                    <div class="mt-5 mb-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-2">
                            <i class="fa-regular fa-floppy-disk"></i> Crear Radicado
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
            // Destruye Select2 solo en estos campos específicos
            if ($('#id_medio_pago').hasClass('select2-hidden-accessible')) {
                $('#id_medio_pago').select2('destroy');
                $('#id_medio_pago').removeClass('select2');
            }

            if ($('#id_financiera').hasClass('select2-hidden-accessible')) {
                $('#id_financiera').select2('destroy');
                $('#id_financiera').removeClass('select2');
            }

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

            $('#div_id_financiera').hide();
            $('#id_financiera').removeAttr('required');

            // ===================================================================================

            $('#id_medio_pago').change(function() {
                let idMedioPago = $(this).val();

                if (idMedioPago == 1) {
                    $('#div_id_financiera').show();
                    $('#id_financiera').attr('required',true);
                    $('#id_financiera').focus();
                } else {
                    $('#div_id_financiera').hide();
                    $('#id_financiera').removeAttr('required');
                    $('#id_financiera').val('');
                }
            });

            // ===================================================================================
            // ===================================================================================

            // formCrearUsuario para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearRadicado']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']"); // Busca el GIF del form actual

                // Mostrar Spinner, Dessactivar Botones
                loadingIndicator.show();
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Enviar formulario manualmente
                this.submit();
            });
        }); // FIN document.readey
    </script>
@stop


