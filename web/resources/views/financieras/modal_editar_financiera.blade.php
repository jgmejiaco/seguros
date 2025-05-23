<x-form
    action="{{route('financieras.update', $resFinancieraEdit->id_financiera)}}"
    method="PUT"
    class="mt-2"
    id="formEditarFinanciera_{{$resFinancieraEdit->id_financiera}}"
    autocomplete="off">
    
    <div class="rounded-top text-white text-center"
        style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Financiera</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-2 mb-3">
            <div class="col-12">
                <x-input
                    name="financiera"
                    type="text"
                    label="Financiera"
                    value="{{$resFinancieraEdit->financiera}}"
                    id="financiera_{{$resFinancieraEdit->id_financiera}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="given-name"
                    required
                />
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEditFinanciera_{{$resFinancieraEdit->id_financiera}}"
            class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_financiera_{{ $resFinancieraEdit->id_financiera }}"
                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_financiera_{{$resFinancieraEdit->id_financiera}}"
                class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
