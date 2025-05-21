@extends('layouts.app')
@section('title', 'Ver Permisos')

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
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Permisos</h5>

            <div class="row pe-3 mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalCrearPermiso">
                        <i class="fa-solid fa-unlock-keyhole"></i> Crear Permiso
                    </button>
                </div>
            </div>

            {{-- INICIO Modal CREAR PERMISO --}}
            <div class="modal fade" id="modalCrearPermiso" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog" style="min-width: 55%">
                    <div class="modal-content border-0 p-3">
                        <x-form
                            action="{{route('permisos.store')}}"
                            method="POST"
                            class="mt-0"
                            id="formCrearPermiso"
                            autocomplete="off"
                        >
                            <div class="rounded-top text-white text-center"
                                style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Crear Permiso</h5>
                            </div>

                            <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
                                <div class="row p-2">
                                    <div class="col-12 col-md-6 mt-3 mb-4">
                                        <x-input name="nombre_permiso" type="text" label="Nombre Permiso" id="nombre_permiso" autocomplete="off" required />
                                    </div>

                                    <div class="col-12 col-md-6 mt-3 mb-4">
                                        <x-input name="ruta_permiso" type="text" label="Ruta Permiso" id="ruta_permiso" autocomplete="off" required />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer d-block mt-0 border border-0 p-0">
                                <!-- Contenedor para el GIF -->
                                <div id="loadingIndicatorCrearPermiso" class="loadingIndicator">
                                    <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="button" id="btn_cancelar_permiso" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>

                                    <button type="submit" id="btn_crear_permiso" class="btn btn-success">
                                        <i class="fa-regular fa-floppy-disk"></i> Crear
                                    </button>
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
            {{-- FINAL Modal CREAR PERMISO --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="col-12 p-3" id="">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" id="tbl_permisos" aria-describedby="permisos">
                        <thead>
                            <tr class="header-table text-center">
                                <th>ID Permiso</th>
                                <th>Nombre</th>
                                <th>Ruta</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        {{-- ============================== --}}
                        <tbody>
                            @foreach ($permisosIndex as $permiso)
                                <tr class="text-center">
                                    <td>{{$permiso->id}}</td>
                                    <td>{{$permiso->name}}</td>
                                    <td>{{$permiso->route_name}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-editar-permiso" data-id="{{ $permiso->id }}">
                                            <i class="fa-solid fa-pencil"></i> Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> {{-- FIN div_ --}}
        </div> {{-- FIN div_ --}}
    </div>
    
    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    {{-- INICIO Modal EDITAR PERMISO --}}
    <div class="modal fade" id="modalEditarPermiso" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content border-0 p-2" id="modalEditarPermisoContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal EDITAR PERMISO --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista producto
            $("#tbl_permisos").DataTable({
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
                        title: 'Listado de Permisos'
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
                order: [[1, 'asc']]  // Indicar la columna predeterminada contando desde 0
            });
            // CIERRE DataTable Lista producto

            // ===========================================================================================

            // formCrearPermiso Submit para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearPermiso']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorCrearPermiso']");

                // Dessactivar Botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                const nombrePermiso = '#nombre_permiso';
                $(nombrePermiso).prop("readonly", true).addClass("bg-secondary-subtle");

                const rutaPermiso = '#ruta_permiso';
                $(rutaPermiso).prop("readonly", true).addClass("bg-secondary-subtle");
                
                // Mostrar Spinner
                loadingIndicator.show();

                // Enviar formulario manualmente
                this.submit();
            });

            // ===========================================================================================

            $(document).on('click', '.btn-editar-permiso', function () {
                const idPermiso = $(this).data('id');

                $.ajax({
                    url: `/permisos/${idPermiso}/edit`,
                    type: 'GET',
                    beforeSend: function () {
                        $('#modalEditarPermisoContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                        $('#modalEditarPermiso').modal('show');
                    },
                    success: function (html) {
                        $('#modalEditarPermisoContent').html(html);
                    },
                    error: function (xhr) {
                        if (xhr.status === 403 && xhr.responseText) {
                            // Mostrar el HTML de la vista de permiso denegado
                            $('#modalEditarPermisoContent').html(xhr.responseText);

                            // Cerrar el modal después de 3 segundos (3000 ms)
                            setTimeout(() => {
                                $('#modalEditarPermiso').modal('hide');
                            }, 3000);
                        } else {
                            $('#modalEditarPermisoContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                        }
                    }
                });
            });

            // ===========================================================================================

            $(document).on("submit", "form[id^='formEditarPermiso_']", function(e) {
                const form = $(this);
                const formId = form.attr('id');
                const id = formId.split('_')[1];

                // Capturar dinámicamente spinner y btns
                const submitButton = $(`#btn_editar_permiso_${id}`);
                const cancelButton = $(`#btn_cancelar_permiso_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditPermiso_${id}`);

                // Bloquear botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );
                    
                // Capturo campos
                const nombrePermiso = $(`#nombre_permiso_${id}`);
                const rutaPermiso = $(`#ruta_permiso_${id}`);

                nombrePermiso.prop("readonly", true).addClass("bg-secondary-subtle");
                rutaPermiso.prop("readonly", true).addClass("bg-secondary-subtle");

                loadingIndicator.show();
            }); // FIN submit.formEditarProducto_
        }); // FIN document.ready
    </script>
@stop
