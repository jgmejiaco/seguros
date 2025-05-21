<x-form
    action="{{route('estados.update', $resEstadoEdit->id_estado)}}"
    method="PUT"
    class="mt-2"
    id="formEditarEstado_{{$resEstadoEdit->id_estado}}"
    autocomplete="off">
    
    <div class="rounded-top text-white text-center"
        style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Estado</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-2 mb-3">
            <div class="col-12">
                <x-input
                    name="estado"
                    type="text"
                    label="Estado"
                    value="{{$resEstadoEdit->estado}}"
                    id="estado_{{$resEstadoEdit->id_estado}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="given-name"
                    required
                />
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEditEstado_{{$resEstadoEdit->id_estado}}"
            class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_estado_{{$resEstadoEdit->id_estado}}" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_estado_{{$resEstadoEdit->id_estado}}" class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
