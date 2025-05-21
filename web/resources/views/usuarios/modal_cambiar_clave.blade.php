<x-form
    action="{{route('cambiar_clave', $usuario->id_usuario)}}"
    method="POST"
    class="mt-2"
    id="formCambiarClave_{{$usuario->id_usuario}}"
    autocomplete="off" >
    <div class="rounded-top" style="border: solid 1px #337AB7">
        <div class="rounded-top text-white text-center" style="background-color: #337AB7; border: solid 1px #337AB7">
            <h5>Cambiar Contraseña de: {{$usuario->nombre_usuario}}</h5>
        </div>

        <input type="hidden" name="id_usuario" value="{{$usuario->id_usuario}}" required >

        {{-- ====================================================== --}}
        {{-- ====================================================== --}}

        <div class="modal-body p-0 m-0">
            <div class="row m-0 pt-4 pb-4">
                <div class="col-12 col-md-6">
                    <div class="form-group d-flex flex-column">
                        <x-input name="nueva_clave" type="text" label="Nueva Contraseña" id="nueva_clave_{{$usuario->id_usuario}}" autocomplete="password" required />
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group d-flex flex-column">
                        <x-input name="confirmar_clave" type="text" label="Confirmar Contraseña" id="confirmar_clave_{{$usuario->id_usuario}}" autocomplete="password" required />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEditClave_{{$usuario->id_usuario}}" class="loadingIndicator">
        <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-2">
        <button type="button" class="btn btn-secondary me-3" id="btn_cancelar_clave_{{$usuario->id_usuario}}" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancelar
        </button>

        <button type="submit" title="Guardar Configuración" class="btn btn-success" id="btn_editar_clave_{{$usuario->id_usuario}}">
            <i class="fa-regular fa-floppy-disk"></i> Modificar
        </button>
    </div>
</x-form> {{-- FIN x-form --}}