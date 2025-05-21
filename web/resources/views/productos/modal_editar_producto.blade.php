<x-form
    action="{{route('productos.update', $resProductoEdit->id_producto)}}"
    method="PUT"
    class="mt-2"
    id="formEditarProducto_{{$resProductoEdit->id_producto}}"
    autocomplete="off">

    {{-- <x-input name="id_producto" type="hidden" value="{{$resProductoEdit->id_producto}}" id="id_producto_{{$resProductoEdit->id_producto}}" autocomplete="given-name" /> --}}

    <div class="rounded-top text-white text-center"
        style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Producto</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-2 mb-3">
            <div class="col-12 col-md-4">
                <x-input
                    name="codigo_producto"
                    type="text"
                    label="Código Producto"
                    value="{{$resProductoEdit->codigo_producto}}"
                    id="codigo_producto_{{$resProductoEdit->id_producto}}"
                    autocomplete="given-name"
                    required
                />
            </div>

            <div class="col-12 col-md-8">
                <x-input
                    name="producto"
                    type="text"
                    label="Producto"
                    value="{{$resProductoEdit->producto}}"
                    id="producto_{{$resProductoEdit->id_producto}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="given-name"
                    required
                />
            </div>

            <div class="col-12 col-md-6 mt-3">
                <x-select
                    name="id_ramo"
                    label="Ramo"
                    id="idRamo_{{$resProductoEdit->id_producto}}"
                    autocomplete="organization-title"
                    required
                >
                    <option value="">Seleccionar...</option>
                    @foreach($ramos as $key => $value)
                        <option value="{{$key}}" {{(isset($resProductoEdit) && $resProductoEdit->id_ramo == $key) ? 'selected' : ''}}>
                            {{$value}}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="col-12 col-md-6 mt-3">
                <x-select
                    name="id_estado"
                    label="Estado"
                    id="idEstado_{{$resProductoEdit->id_producto}}"
                    autocomplete="organization-title"
                    required>
                    
                    <option value="">Seleccionar...</option>
                    @foreach($estados_gral as $key => $value)
                        <option value="{{$key}}" {{(isset($resProductoEdit) && $resProductoEdit->id_estado == $key) ? 'selected' : ''}}>
                            {{$value}}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEditProducto_{{$resProductoEdit->id_producto}}"
            class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_producto_{{ $resProductoEdit->id_producto }}"
                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_producto_{{$resProductoEdit->id_producto}}"
                class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
