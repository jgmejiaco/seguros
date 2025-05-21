@extends('layouts.app')
@section('title', 'Gerentes')

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
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Gerentes</h5>

            <div class="row pe-3 mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#337AB7" data-bs-toggle="modal" data-bs-target="#modalCrearGerente">Crear Gerente</button>
                </div>
            </div>

            {{-- INICIO Modal CREAR GERENTE --}}
            <div class="modal fade" id="modalCrearGerente" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content border-0 p-3">
                        <x-form
                            action="{{route('gerentes.store')}}"
                            method="POST"
                            class="mt-0"
                            id="formCrearGerente"
                            autocomplete="off"
                        >
                            <div class="rounded-top text-white text-center"
                                style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Crear Gerente</h5>
                            </div>

                            <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
                                <div class="row m-2">
                                    <div class="col-12 mt-3 mb-4">
                                        <x-input
                                            name="gerente"
                                            type="text"
                                            label="Gerente"
                                            id="gerente"
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
                                    <button type="button" id="btn_cancelar_gerente" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>

                                    <button type="submit" id="btn_crear_gerente" class="btn btn-success">
                                        <i class="fa-regular fa-floppy-disk"></i> Crear
                                    </button>
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
            {{-- FINAL Modal CREAR GERENTE --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="col-12 p-3" id="">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" id="tbl_gerentes"
                        aria-describedby="frecuencias">
                        <thead>
                            <tr class="header-table text-center">
                                <th>Id Gerente</th>
                                <th>Gerente</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        {{-- ============================== --}}
                        <tbody>
                            @php
                                // dd($usuariosIndex);
                            @endphp
                            @foreach ($gerentesIndex as $gerente)
                                <tr class="text-center">
                                    <td>{{$gerente->id_gerente}}</td>
                                    <td>{{$gerente->gerente}}</td>
                                    <td>{{$gerente->estado}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEditarGerente_{{$gerente->id_gerente}}">
                                            <i class="fa-solid fa-pencil"></i> Editar
                                        </button>
                                    </td>

                                    {{-- ====================================================== --}}
                                    {{-- ====================================================== --}}

                                    {{-- INICIO Modal EDITAR GERENTE --}}
                                    <div class="modal fade" id="modalEditarGerente_{{$gerente->id_gerente}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-0 p-3">
                                                <x-form
                                                    action="{{route('gerentes.update', $gerente->id_gerente)}}"
                                                    method="PUT"
                                                    class="mt-2"
                                                    id="formEditarGerente_{{$gerente->id_gerente}}"
                                                    autocomplete="off"
                                                >
                                                    <div class="rounded-top text-white text-center"
                                                        style="background-color: #337AB7; border: solid 1px #337AB7;">
                                                        <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Gerente</h5>
                                                    </div>

                                                    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
                                                        <div class="row m-2 mb-3">
                                                            <div class="col-12 col-md-8">
                                                                <x-input
                                                                    name="gerente"
                                                                    type="text"
                                                                    label="Gerente"
                                                                    value="{{$gerente->gerente}}"
                                                                    id="gerente_{{$gerente->id_gerente}}"
                                                                    class="text-lowercase text-capitalize"
                                                                    autocomplete="given-name"
                                                                    required
                                                                />
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <x-select
                                                                    name="id_estado"
                                                                    label="Estado"
                                                                    id="idEstado_{{$gerente->id_gerente}}"
                                                                    autocomplete="organization-title"
                                                                    required
                                                                >
                                                                    <option value="">Seleccionar...</option>
                                                                    @foreach($estados_gral as $key => $value)
                                                                        <option value="{{$key}}" {{(isset($gerente) && $gerente->id_estado == $key) ? 'selected' : ''}}>
                                                                            {{$value}}
                                                                        </option>
                                                                    @endforeach
                                                                </x-select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer d-block mt-0 border border-0">
                                                        <!-- Contenedor para el GIF -->
                                                        <div id="loadingIndicatorEditGerente_{{$gerente->id_gerente}}"
                                                            class="loadingIndicator">
                                                            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
                                                        </div>

                                                        <div class="d-flex justify-content-center mt-3">
                                                            <button type="button" id="btn_cancelar_gerente_{{ $gerente->id_gerente }}"
                                                                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                                                <i class="fa fa-times"></i> Cancelar
                                                            </button>

                                                            <button type="submit" id="btn_editar_gerente_{{$gerente->id_gerente}}"
                                                                class="btn btn-success" title="Editar">
                                                                <i class="fa-regular fa-floppy-disk"></i> Editar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </x-form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- FINAL Modal EDITAR GERENTE --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> {{-- FIN div_campos_usuarios --}}
        </div> {{-- FIN div_crear_usuario --}}
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('shown.bs.modal', "div[id^='modalEditarGerente_']", function () {
                $(this).find('.select2').select2({
                    dropdownParent: $(this),
                    allowClear: false,
                    width: '100%'
                });
            });

            // ===========================================================================================

            // INICIO DataTable Lista Usuarios
            $("#tbl_gerentes").DataTable({
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
                order: [[1, 'asc']]  // Indicar la columna predeterminada contando desde 0
            });
            // CIERRE DataTable Lista Usuarios

            // ===========================================================================================
        
            // formCrearUsuario para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearGerente']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                const gerente = '#gerente';
                $(gerente).prop("readonly", true).addClass("bg-secondary-subtle");
                
                // Mostrar Spinner
                loadingIndicator.show();

                // Enviar formulario manualmente
                this.submit();
            });

            // ===========================================================================================
            
            // Botón de submit de editar usuario
            $(document).on("submit", "form[id^='formEditarGerente_']", function(e) {
                const form = $(this);
                const formId = form.attr('id'); // Obtenemos el ID del formulario
                const id = formId.split('_')[1]; // Obtener el ID del formulario desde el ID del formulario

                // Capturar el indicador de carga dinámicamente
                const submitButton = $(`#btn_editar_gerente_${id}`);
                const cancelButton = $(`#btn_cancelar_gerente_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditGerente_${id}`);

                // Lógica del botón
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );

                const gerente = `#gerente_${id}`;
                $(gerente).prop("readonly", true).addClass("bg-secondary-subtle");


                const idEstado = `#idEstado_${id}`;
                $(idEstado)
                    .prop("disabled", true)  // Lo desactivamos visualmente
                    .addClass("bg-secondary-subtle")
                    .each(function() {
                        // Antes de submit, para que el select desactivado envíe su valor:
                        $('<input>').attr({
                            type: 'hidden',
                            name: $(this).attr('name'), // mismo name que el select
                            value: $(this).val()
                        }).appendTo(form);
                    });

                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop
