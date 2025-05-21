<x-form
    action="{{route('permisos.update',$resPermisoEdit->id)}}"
    method="PUT"
    class="mt-2"
    id="formEditarPermiso_{{$resPermisoEdit->id}}"
    autocomplete="off">

    <div class="rounded-top text-white" style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold text-center" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Permiso: {{$resPermisoEdit->name}}</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-0">
            <div class="col-12 col-md-6 mt-3 mb-4">
                <x-input
                    name="nombre_permiso"
                    type="text"
                    label="Nombre Permiso"
                    value="{{$resPermisoEdit->name}}"
                    id="nombre_permiso_{{$resPermisoEdit->id}}"
                    class="text-lowercase text-capitalize"
                    autocomplete="off"
                    required
                />
            </div>

            <div class="col-12 col-md-6 mt-3 mb-4">
                <x-input
                    name="ruta_permiso"
                    type="text"
                    label="Ruta Permiso"
                    value="{{$resPermisoEdit->route_name}}"
                    id="ruta_permiso_{{$resPermisoEdit->id}}"
                    autocomplete="off"
                    required
                />
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <div id="loadingIndicatorEditPermiso_{{$resPermisoEdit->id}}" class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_permiso_{{ $resPermisoEdit->id }}"
                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_permiso_{{$resPermisoEdit->id}}"
                class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
