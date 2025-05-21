@extends('layouts.app')
@section('title', 'Roles')

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
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Roles</h5>

            <div class="row pe-3 mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#337AB7" data-bs-toggle="modal" data-bs-target="#modalCrearRol">Crear Rol</button>
                </div>
            </div>

            {{-- INICIO Modal CREAR ROL --}}
            <div class="modal fade" id="modalCrearRol" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content border-0 p-3">
                        <x-form
                            action="{{route('roles.store')}}"
                            method="POST"
                            class="mt-0"
                            id="formCrearRol"
                            autocomplete="off"
                        >
                            <div class="rounded-top text-white text-center"
                                style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Crear Rol</h5>
                            </div>

                            <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
                                <div class="row m-2">
                                    <div class="col-12 mt-3 mb-4">
                                        <x-input
                                            name="rol"
                                            type="text"
                                            label="Rol"
                                            id="rol"
                                            class="text-lowercase text-capitalize"
                                            autocomplete="given-name"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer d-block mt-0 border border-0 p-0">
                                <!-- Contenedor para el GIF -->
                                <div id="loadingIndicatorStore" class="loadingIndicator">
                                    <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="button" id="btn_cancelar_rol" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>

                                    <button type="submit" id="btn_crear_rol" class="btn btn-success">
                                        <i class="fa-regular fa-floppy-disk"></i> Crear
                                    </button>
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
            {{-- FINAL Modal CREAR ROL --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="col-12 p-3" id="">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" id="tbl_roles"
                        aria-describedby="roles">
                        <thead>
                            <tr class="header-table text-center">
                                <th>Id Rol</th>
                                <th>Rol</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        {{-- ============================== --}}
                        <tbody>
                            @foreach ($rolesIndex as $rol)
                                <tr class="text-center">
                                    <td>{{$rol->id_rol}}</td>
                                    <td>{{$rol->rol}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-editar-rol" data-id="{{$rol->id_rol}}">
                                            <i class="fa-solid fa-pencil"></i> Editar
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> {{-- FIN div_campos_usuarios --}}
        </div> {{-- FIN div_crear_usuario --}}
    </div>
    
    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    {{-- INICIO Modal EDITAR ROL --}}
    <div class="modal fade" id="modalEditarRol" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content border-0 p-3" id="modalEditarRolContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal EDITAR ROL --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {

            // INICIO DataTable Lista Roles
            $("#tbl_roles").DataTable({
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
                        title: 'Listado de Roles'
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
            // CIERRE DataTable Lista Roles

            // ===========================================================================================
        
            // formCrearUsuario para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearRol']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                const rol = '#rol';
                $(rol).prop("readonly", true).addClass("bg-secondary-subtle");
                
                // Mostrar Spinner
                loadingIndicator.show();

                // Enviar formulario manualmente
                this.submit();
            });

            // ===========================================================================================

            $(document).on('click', '.btn-editar-rol', function () {
                const idRol = $(this).data('id');

                $.ajax({
                    url: `/roles/${idRol}/edit`,
                    type: 'GET',
                    beforeSend: function () {
                        $('#modalEditarRolContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                        $('#modalEditarRol').modal('show');
                    },
                    success: function (html) {
                        $('#modalEditarRolContent').html(html);
                    },
                    error: function (xhr) {
                        if (xhr.status === 403 && xhr.responseText) {
                            // Mostrar el HTML de la vista de permiso denegado
                            $('#modalEditarRolContent').html(xhr.responseText);

                            // Cerrar el modal después de 3 segundos (3000 ms)
                            setTimeout(() => {
                                $('#modalEditarRol').modal('hide');
                            }, 3000);
                        } else {
                            $('#modalEditarRolContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                        }
                    }
                });
            });

            // ===========================================================================================
            
            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formEditarRol_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el indicador de carga dinámicamente
                const submitButton = $(`#btn_editar_rol_${id}`);
                const cancelButton = $(`#btn_cancelar_rol_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditRol_${id}`);

                // Lógica del botón
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );

                const rol = `#rol_${id}`;
                $(rol).prop("readonly", true).addClass("bg-secondary-subtle");

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop
