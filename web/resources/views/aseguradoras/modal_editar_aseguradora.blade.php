<x-form
    action="{{route('aseguradoras.update', $resAseguradoraEdit->id_aseguradora)}}"
    method="PUT"
    class="mt-2"
    id="formEditarAseguradora_{{$resAseguradoraEdit->id_aseguradora}}"
    autocomplete="off">
    <div class="rounded-top text-white text-center"
        style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Aseguradora</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-2 mb-3">
            <div class="col-12 col-md-6">
                <x-input
                    name="aseguradora"
                    type="text"
                    label="Aseguradora"
                    value="{{$resAseguradoraEdit->aseguradora}}"
                    id="aseguradora_{{$resAseguradoraEdit->id_aseguradora}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="given-name"
                    required
                />
            </div>

            <div class="col-12 col-md-6">
                <x-input
                    name="nit_aseguradora"
                    type="text"
                    label="Nit Aseguradora"
                    value="{{$resAseguradoraEdit->nit_aseguradora}}"
                    id="nit_aseguradora_{{$resAseguradoraEdit->id_aseguradora}}"
                    pattern="\d{9,}"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    autocomplete="given-name"
                    required
                />
            </div>

            <div class="col-12 col-md-6">
                <x-select
                    name="id_estado"
                    label="Estado"
                    id="idEstado_{{$resAseguradoraEdit->id_aseguradora}}"
                    autocomplete="organization-title"
                    required
                >
                    <option value="">Seleccionar...</option>
                    @foreach($estados_gral as $key => $value)
                        <option value="{{$key}}" {{(isset($resAseguradoraEdit) && $resAseguradoraEdit->id_estado == $key) ? 'selected' : ''}}>
                            {{$value}}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEditAdministradora_{{$resAseguradoraEdit->id_aseguradora}}"
            class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_admin_{{ $resAseguradoraEdit->id_aseguradora }}"
                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_admin_{{$resAseguradoraEdit->id_aseguradora}}"
                class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
