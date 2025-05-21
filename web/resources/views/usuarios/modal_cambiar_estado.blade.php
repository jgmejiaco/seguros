<x-form
    action="{{route('usuarios.destroy', $usuario->id_usuario)}}"
    method="DELETE"
    class="mt-0"
    id="formCambiarEstado_{{$usuario->id_usuario}}"
    autocomplete="off">
    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Cambiar estado de: <br>
                <span class="text-warning">{{$usuario->nombre_usuario}}</span>
            </h5>
        </div>

        <div class="mt-4 mb-4 text-center">
            <span class="text-danger fs-5">¿Realmente desea cambiar el estado de esta usuario?</span>
        </div>

        <input type="hidden" name="id_usuario" value="{{$usuario->id_usuario}}" required >
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEstado_{{$usuario->id_usuario}}"
        class="loadingIndicator">
        <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button type="button" id="btn_cancelar_estado_{{$usuario->id_usuario}}"
            class="btn btn-secondary me-3" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancelar
        </button>

        <button type="submit" id="btn_cambiar_estado_{{$usuario->id_usuario}}"
            class="btn btn-success">
            <i class="fa-regular fa-floppy-disk"></i> Cambiar
        </button>
    </div>
</x-form> {{-- FIN x-form --}}
