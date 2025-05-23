@extends('layouts.app')
@section('title', 'Líneas Personales')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    <style>
        
    </style>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="p-3 d-flex flex-column">
        <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Informe Producción Líneas Personales</h5>

            <div class="row pe-3 mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{route('lineas_personales.create')}}" class="btn text-white" style="background-color:#337AB7">Crear Radicado</a>
                </div>
            </div>

            <div class="row mb-3 p-3">
                <div class="col-12 offset-md-0 col-md-3">
                    <label for="filtroMesAnio" class="form-label">Filtrar por Mes/Año:</label>
                    <select id="filtroMesAnio" class="form-select">
                        <option value="">Todos</option>
                        @php
                            $mesesUnicos = array_unique(array_map(function($item) {
                                return $item->mes_anio_radicado;
                            }, $lineasPersonalesIndex));
                            sort($mesesUnicos);
                        @endphp
                        @foreach ($mesesUnicos as $mes)
                            <option value="{{ $mes }}">{{ $mes }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12 p-3" id="">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" id="tbl_radicados" aria-describedby="radicados">
                        <thead>
                            <tr class="header-table text-center">
                                <th class="text-center align-content-center">Fecha Radicado</th>
                                <th class="text-center align-content-center">Mes/Año Radicado</th>
                                <th class="text-center align-content-center">Aseguradora</th>
                                <th class="text-center align-content-center">Póliza Asistente</th>
                                <th class="text-center align-content-center">Identificación Tomador</th>
                                <th class="text-center align-content-center">Nombres Tomador</th>
                                <th class="text-center align-content-center">Ciudad</th>
                                <th class="text-center align-content-center">Dirección Tomador</th>
                                <th class="text-center align-content-center">Celular Tomador</th>
                                <th class="text-center align-content-center">Correo Tomador</th>
                                <th class="text-center align-content-center">Fecha Nacimiento</th>
                                <th class="text-center align-content-center">Producto</th>
                                <th class="text-center align-content-center">Ramo</th>
                                <th class="text-center align-content-center">Prima Anualizada</th>
                                <th class="text-center align-content-center">Frecuencia</th>
                                <th class="text-center align-content-center">Proceso</th>
                                <th class="text-center align-content-center">Estado Inicial</th>
                                <th class="text-center align-content-center">Fecha Emisión</th>
                                <th class="text-center align-content-center">Clave Consultor Global</th>
                                <th class="text-center align-content-center">Consultor</th>
                                <th class="text-center align-content-center">Gerente</th>
                                <th class="text-center align-content-center">Estado Póliza</th>
                                <th class="text-center align-content-center">Fecha Cancelación</th>
                                <th class="text-center align-content-center">Medio Pago</th>
                                <th class="text-center align-content-center">Financiera</th>
                                <th class="text-center align-content-center bg-warning-subtle">Cédula</th>
                                <th class="text-center align-content-center bg-warning-subtle">Matrícula</th>
                                <th class="text-center align-content-center bg-warning-subtle">Asegurabilidad</th>
                                <th class="text-center align-content-center bg-warning-subtle">Sarlaft</th>
                                <th class="text-center align-content-center bg-warning-subtle">Carátula Póliza</th>
                                <th class="text-center align-content-center bg-warning-subtle">Renvación</th>
                                <th class="text-center align-content-center bg-warning-subtle">Otros</th>
                                <th class="text-center align-content-center bg-info-subtle">Creado por</th>
                                <th class="text-center align-content-center bg-success">Opciones</th>
                            </tr>
                        </thead>
                        {{-- ============================== --}}
                        <tbody>
                            @foreach ($lineasPersonalesIndex as $radicado)
                                <tr class="text-center">
                                    <td class="text-center align-content-center">{{$radicado->fecha_radicado}}</td>
                                    <td class="text-center align-content-center">{{$radicado->mes_anio_radicado}}</td>
                                    <td class="text-center align-content-center">{{$radicado->aseguradora}}</td>
                                    <td class="text-center align-content-center">{{$radicado->poliza_asistente}}</td>
                                    <td class="text-center align-content-center">{{$radicado->identificacion_tomador}}</td>
                                    <td class="text-center align-content-center">{{$radicado->tomador}}</td>
                                    <td class="text-center align-content-center">{{$radicado->ciudad}}</td>
                                    <td class="text-center align-content-center">{{$radicado->direccion_tomador}}</td>
                                    <td class="text-center align-content-center">{{$radicado->celular_tomador}}</td>
                                    <td class="text-center align-content-center">{{$radicado->correo_tomador}}</td>
                                    <td class="text-center align-content-center">{{$radicado->fecha_nacimiento}}</td>
                                    <td class="text-center align-content-center">{{$radicado->producto}}</td>
                                    <td class="text-center align-content-center">{{$radicado->ramo}}</td>
                                    <td class="text-center align-content-center">{{$radicado->prima_anualizada}}</td>
                                    <td class="text-center align-content-center">{{$radicado->frecuencia}}</td>
                                    <td class="text-center align-content-center">{{$radicado->proceso}}</td>
                                    <td class="text-center align-content-center">{{$radicado->estado_inicial}}</td>
                                    <td class="text-center align-content-center">{{$radicado->fecha_emision}}</td>
                                    <td class="text-center align-content-center">{{$radicado->clave_consultor_global}}</td>
                                    <td class="text-center align-content-center">{{$radicado->consultor}}</td>
                                    <td class="text-center align-content-center">{{$radicado->gerente_comercial}}</td>
                                    <td class="text-center align-content-center">{{$radicado->estado_poliza}}</td>
                                    <td class="text-center align-content-center">{{$radicado->fecha_cancelacion}}</td>
                                    <td class="text-center align-content-center">{{$radicado->medio_pago}}</td>
                                    <td class="text-center align-content-center">{{$radicado->financiera}}</td>

                                    @if (isset($radicado->file_cedula) && !empty($radicado->file_cedula) && !is_null($radicado->file_cedula))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_cedula}}" target="_blank" class="text-decoration-none">Cédula</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif

                                    @if (isset($radicado->file_matricula) && !empty($radicado->file_matricula) && !is_null($radicado->file_matricula))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_matricula}}" target="_blank" class="text-decoration-none">Matrícula</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif

                                    @if (isset($radicado->file_asegurabilidad) && !empty($radicado->file_asegurabilidad) && !is_null($radicado->file_asegurabilidad))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_asegurabilidad}}" target="_blank" class="text-decoration-none">Solicitud Asegurabilidad</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif

                                    @if (isset($radicado->file_sarlaft) && !empty($radicado->file_sarlaft) && !is_null($radicado->file_sarlaft))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_sarlaft}}" target="_blank" class="text-decoration-none">Sarlaft</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif


                                    @if (isset($radicado->file_caratula_poliza) && !empty($radicado->file_caratula_poliza) && !is_null($radicado->file_caratula_poliza))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_caratula_poliza}}" target="_blank" class="text-decoration-none">Carátula Póliza</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif


                                    @if (isset($radicado->file_renovacion) && !empty($radicado->file_renovacion) && !is_null($radicado->file_renovacion))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_renovacion}}" target="_blank" class="text-decoration-none">Renovacion</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif


                                    @if (isset($radicado->file_otros) && !empty($radicado->file_otros) && !is_null($radicado->file_otros))
                                        <td class="text-center align-content-center bg-warning-subtle"><a href="storage/{{$radicado->file_otros}}" target="_blank" class="text-decoration-none">Otros</a></td>
                                    @else
                                        <td class="text-center align-content-center bg-warning-subtle"></td>
                                    @endif

                                    <td class="text-center align-content-center bg-info-subtle">{{$radicado->nombres_usuario}}</td>

                                    <td class="text-center align-content-center">
                                        <a href="{{route('lineas_personales.edit', $radicado->id_lineas_personal)}}" role="button" class="btn btn-success" title="Editar Radicado">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>

                                        <button class="btn btn-danger btn-eliminar-radicado" title="Eliminar Radicado" data-id="{{$radicado->id_lineas_personal}}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> {{-- FIN table-responsive --}}
            </div> {{-- FIN col-12 p-3 --}}
        </div> {{-- FIN div p-0 --}}
    </div>{{-- FIN p-3 d-flex flex-column --}}
    
    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    {{-- INICIO Modal ELIMINAR RADICADO --}}
    <div class="modal fade" id="modalEliminarRadicado" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content border-0 p-2" id="modalEliminarRadicadoContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal ELIMINAR RADICADO --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            // INICIO DataTable Líneas Personales
            let table = $("#tbl_radicados").DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '📥 Exportar Excel',
                        className: 'waves-effect waves-light btn btn-sm btn-success rounded-pill',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 Exportar PDF',
                        className: 'waves-effect waves-light btn btn-sm btn-danger rounded-pill',
                        exportOptions: {
                            columns: ':visible'
                        },
                        orientation: 'landscape',
                        pageSize: 'letter',
                        title: 'Listado de Usuarios'
                    }
                ],
                language: {
                    url: "{{ asset('DataTable1.13.6/es-ES.json') }}"
                },
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 30, -1],
                    [10, 20, 30, "Todos"]
                ],
                scrollX: true,
                bSort: true,
                stripe: true,
                responsive: true,
                infoEmpty: "No hay registros disponibles",
                order: [[0, 'desc']]  // Indicar la columna predeterminada contando desde 0
            });

            // Filtro personalizado para el Mes/Año
            $('#filtroMesAnio').on('change', function() {
                var valor = $(this).val();
                table.column(1).search(valor).draw(); // columna 1 = Mes/Año
            });
            // CIERRE DataTable Líneas Personales

            // ===========================================================================================

            $(document).on('click', '.btn-eliminar-radicado', function () {
                const idLineasPersonal = $(this).data('id');

                $.ajax({
                    url: `eliminar_radicado/${idLineasPersonal}`,
                    type: 'GET',
                    beforeSend: function () {
                        $('#modalEliminarRadicado').modal('show');
                        $('#modalEliminarRadicadoContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                    },
                    success: function (html) {
                        $('#modalEliminarRadicadoContent').html(html);
                    },
                    error: function (xhr) {
                        if (xhr.status === 403 && xhr.responseText) {
                            // Mostrar el HTML de la vista de permiso denegado
                            $('#modalEliminarRadicadoContent').html(xhr.responseText);

                            // Cerrar el modal después de 3 segundos (3000 ms)
                            setTimeout(() => {
                                $('#modalEliminarRadicado').modal('hide');
                            }, 3000);
                        } else {
                            $('#modalEliminarRadicadoContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                        }
                    }
                });
            });

            // ===========================================================================================

            // Validaciones eliminar radicado al submit
            $(document).on("submit", "form[id^='formEliminarRadicado_']", function(e) {
                const form = $(this);
                const formId = form.attr('id');
                const id = formId.split('_')[1];

                // Capturar dinámicamente spinner y btns
                const submitButton = $(`#btn_eliminar_radicado_${id}`);
                const cancelButton = $(`#btn_cancelar_eliminar_radicado_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEliminarRadicado_${id}`);

                // Bloquear botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );
                
                loadingIndicator.show();
            }); // FIN submit.formEditarConsultor_
        }); // FIN document.ready
    </script>
@stop
