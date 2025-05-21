<x-form
    action="{{route('consultores.update', $resConsultorEdit->id_consultor)}}"
    method="PUT"
    class="mt-2"
    id="formEditarConsultor_{{$resConsultorEdit->id_consultor}}"
    autocomplete="off">

    <x-input name="id_consultor" type="hidden" value="{{$resConsultorEdit->id_consultor}}" id="id_consultor_{{$resConsultorEdit->id_consultor}}" autocomplete="off" />

    <div class="rounded-top text-white" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold text-center" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Consultor: {{$resConsultorEdit->consultor}}</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-0">
            <div class="col-12 col-md-3 mt-3">
                <x-input
                    name="clave_consultor_global"
                    type="text"
                    label="Clave Global"
                    value="{{$resConsultorEdit->clave_consultor_global}}"
                    id="clave_consultor_global_{{$resConsultorEdit->id_consultor}}"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="col-12 col-md-9 mt-3">
                <x-input
                    name="consultor"
                    type="text"
                    label="Consultor"
                    value="{{$resConsultorEdit->consultor}}"
                    id="consultor_{{$resConsultorEdit->id_consultor}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="col-12 mt-3">
                <x-input
                    name="gerente_comercial"
                    type="text"
                    label="Gerente Comercial"
                    value="{{$resConsultorEdit->gerente_comercial}}"
                    id="gerente_comercial_{{$resConsultorEdit->id_consultor}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="col-12 mt-3">
                <x-input
                    name="lider_comercial"
                    type="text"
                    label="Lider Comercial"
                    value="{{$resConsultorEdit->lider_comercial}}"
                    id="lider_comercial_{{$resConsultorEdit->id_consultor}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="col-12 col-md-6 mt-3 mb-3">
                <x-input
                    name="equipo_informes"
                    type="text"
                    label="Equipo Informes"
                    value="{{$resConsultorEdit->equipo_informes}}"
                    id="equipo_informes_{{$resConsultorEdit->id_consultor}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="col-12 col-md-6 mt-3 mb-3">
                <x-select
                    name="id_estado"
                    label="Estado"
                    id="idEstado_{{$resConsultorEdit->id_consultor}}"
                    autocomplete="off"
                    required
                >
                    <option value="">Seleccionar...</option>
                    @foreach($estados_gral as $key => $value)
                        <option value="{{$key}}" {{(isset($resConsultorEdit) && $resConsultorEdit->id_estado == $key) ? 'selected' : ''}}>
                            {{$value}}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <div id="loadingIndicatorEditConsultor_{{$resConsultorEdit->id_consultor}}" class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_consultor_{{ $resConsultorEdit->id_consultor }}"
                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_consultor_{{$resConsultorEdit->id_consultor}}"
                class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
