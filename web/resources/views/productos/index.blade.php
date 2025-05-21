@extends('layouts.app')
@section('title', 'Productos')

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
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Productos</h5>

            <div class="row pe-3 mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn text-white" style="background-color:#337AB7" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">Crear Producto</button>
                </div>
            </div>

            {{-- INICIO Modal CREAR PRODUCTO --}}
            <div class="modal fade" id="modalCrearProducto" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog" style="min-width: 55%">
                    <div class="modal-content border-0 p-3">
                        <x-form
                            action="{{route('productos.store')}}"
                            method="POST"
                            class="mt-0"
                            id="formCrearProducto"
                            autocomplete="off"
                        >
                            <div class="rounded-top text-white text-center"
                                style="background-color: #337AB7; border: solid 1px #337AB7;">
                                <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Crear Producto</h5>
                            </div>

                            <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
                                <div class="row p-2">
                                    <div class="col-12 col-md-4 mt-3 mb-4">
                                        <x-input
                                            name="codigo_producto"
                                            type="text"
                                            label="Código Producto"
                                            id="codigo_producto"
                                            autocomplete="given-name"
                                            required
                                        />
                                    </div>

                                    <div class="col-12 col-md-8 mt-3">
                                        <x-input
                                            name="producto"
                                            type="text"
                                            label="Producto"
                                            id="producto"
                                            class="text-lowercase text-capitalize"
                                            autocomplete="given-name"
                                            required
                                        />
                                    </div>

                                    <div class="col-12 col-md-6 mt-3 mb-4">
                                        <x-select
                                            name="id_ramo"
                                            label="Ramo"
                                            id="idRamo"
                                            autocomplete="organization-title"
                                            required
                                        >
                                            <option value="">Seleccionar...</option>
                                            @foreach($ramos as $key => $value)
                                                <option value="{{$key}}" {{(isset($producto) && $producto->id_ramo == $key) ? 'selected' : ''}}>
                                                    {{$value}}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer d-block mt-0 border border-0 p-0">
                                <!-- Contenedor para el GIF -->
                                <div id="loadingIndicatorStore" class="loadingIndicator">
                                    <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    <button type="button" id="btn_cancelar_producto" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>

                                    <button type="submit" id="btn_crear_producto" class="btn btn-success">
                                        <i class="fa-regular fa-floppy-disk"></i> Crear
                                    </button>
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
            {{-- FINAL Modal CREAR PRODUCTO --}}

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="col-12 p-3" id="">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" id="tbl_productos"
                        aria-describedby="consultores">
                        <thead>
                            <tr class="header-table text-center">
                                <th>Código Producto</th>
                                <th>Producto</th>
                                <th>Ramo</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        {{-- ============================== --}}
                        <tbody>
                            @foreach ($productosIndex as $producto)
                                <tr class="text-center">
                                    <td>{{$producto->codigo_producto}}</td>
                                    <td>{{$producto->producto}}</td>
                                    <td>{{$producto->ramo}}</td>
                                    <td>{{$producto->estado}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-editar-producto" data-id="{{$producto->id_producto}}">
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

    {{-- INICIO Modal EDITAR PRODUCTO --}}
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" style="min-width: 55%">
            <div class="modal-content border-0 p-3" id="modalEditarProductoContent">
                {{-- El contenido AJAX se cargará aquí --}}
            </div>
        </div>
    </div>
    {{-- FINAL Modal EDITAR PRODUCTO --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            // INICIO DataTable Lista producto
            $("#tbl_productos").DataTable({
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
                        title: 'Listado de Producto'
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

            // formCrearProducto Submit para cargar gif en el submit
            $(document).on("submit", "form[id^='formCrearProducto']", function(e) {
                e.preventDefault(); // Evita el envío si hay errores

                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const cancelButton = form.find('button[type="button"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorStore']");

                // Dessactivar Botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                const codigoProducto = '#codigo_producto';
                $(codigoProducto).prop("readonly", true).addClass("bg-secondary-subtle");

                const producto = '#producto';
                $(producto).prop("readonly", true).addClass("bg-secondary-subtle");

                const idRamo = '#idRamo';
                $(idRamo)
                    .prop("disabled", true)
                    .addClass("bg-secondary-subtle")
                    .each(function() {
                        // Agregamos un input hidden para enviar el valor
                        $('<input>').attr({
                            type: 'hidden',
                            name: $(this).attr('name'),
                            value: $(this).val()
                        }).appendTo(form);
                    });
                
                // Mostrar Spinner
                loadingIndicator.show();

                // Enviar formulario manualmente
                this.submit();
            });

            // ===========================================================================================

            $(document).on('click', '.btn-editar-producto', function () {
                const idProducto = $(this).data('id');

                $.ajax({
                    url: `/productos/${idProducto}/edit`,
                    type: 'GET',
                    beforeSend: function () {
                        $('#modalEditarProductoContent').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin fa-2x"></i> Cargando...</div>');
                        $('#modalEditarProducto').modal('show');
                    },
                    success: function (html) {
                        $('#modalEditarProductoContent').html(html);

                        // Reinicializar select2 si lo usas en el modal
                        $('#modalEditarProducto .select2').select2({
                            dropdownParent: $('#modalEditarProducto'),
                            width: '100%'
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 403 && xhr.responseText) {
                            // Mostrar el HTML de la vista de permiso denegado
                            $('#modalEditarProductoContent').html(xhr.responseText);

                            // Cerrar el modal después de 3 segundos (3000 ms)
                            setTimeout(() => {
                                $('#modalEditarProducto').modal('hide');
                            }, 3000);
                        } else {
                            $('#modalEditarProductoContent').html('<div class="alert alert-danger">Error al cargar el formulario.</div>');
                        }
                    }
                });
            });

            // ===========================================================================================

            $(document).on("submit", "form[id^='formEditarProducto_']", function(e) {
                const form = $(this);
                const formId = form.attr('id');
                const id = formId.split('_')[1];

                // Capturar dinámicamente spinner y btns
                const submitButton = $(`#btn_editar_producto_${id}`);
                const cancelButton = $(`#btn_cancelar_producto_${id}`);
                const loadingIndicator = $(`#loadingIndicatorEditProducto_${id}`);

                // Bloquear botones
                cancelButton.prop("disabled", true);
                submitButton.prop("disabled", true).html(
                    "Procesando... <i class='fa fa-spinner fa-spin'></i>"
                );

                // Capturo campos
                const codigoProducto = $(`#codigo_producto_${id}`);
                const producto = $(`#producto_${id}`);
                const idRamo = $(`#idRamo_${id}`);
                const idEstado = $(`#idEstado_${id}`);

                producto.prop("readonly", true).addClass("bg-secondary-subtle");
                codigoProducto.prop("readonly", true).addClass("bg-secondary-subtle");

                $(idRamo)
                    .prop("disabled", true)
                    .addClass("bg-secondary-subtle")
                    .each(function() {
                        // Agregamos un input hidden para enviar el valor
                        $('<input>').attr({
                            type: 'hidden',
                            name: $(this).attr('name'),
                            value: $(this).val()
                        }).appendTo(form);
                    });

                $(idEstado)
                    .prop("disabled", true)
                    .addClass("bg-secondary-subtle")
                    .each(function() {
                        // Agregamos un input hidden para enviar el valor
                        $('<input>').attr({
                            type: 'hidden',
                            name: $(this).attr('name'),
                            value: $(this).val()
                        }).appendTo(form);
                    });

                loadingIndicator.show();
            }); // FIN submit.formEditarProducto_
        }); // FIN document.ready
    </script>
@stop
