<x-form
    action="{{route('lineas_personales.destroy', $resLineaPersonalEdit->id_lineas_personal)}}"
    method="DELETE"
    class="mt-2"
    id="formEliminarRadicado_{{$resLineaPersonalEdit->id_lineas_personal}}"
    autocomplete="off">

    <div class="rounded-top" style="border: solid 1px #337AB7;">
        <div class="rounded-top text-white text-center"
            style="background-color: #337AB7; border: solid 1px #337AB7;">
            <h5>Eliminar Radicado de: <br>
                <span class="text-warning">{{ $resLineaPersonalEdit->tomador }}</span>
            </h5>
        </div>

        <div class="mt-4 mb-4 text-center">
            <span class="text-danger fs-5">¿Realmente desea eliminar este radicado?</span>
        </div>

        <x-input
            name="id_lineas_personal"
            type="hidden"
            value="{{$resLineaPersonalEdit->id_lineas_personal}}"
            id="id_lineas_personal_{{$resLineaPersonalEdit->id_lineas_personal}}"
            autocomplete="off"
        />
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <!-- Contenedor para el GIF -->
    <div id="loadingIndicatorEliminarRadicado_{{ $resLineaPersonalEdit->id_lineas_personal }}" class="loadingIndicator">
        <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
    </div>

    {{-- ====================================================== --}}
    {{-- ====================================================== --}}

    <div class="d-flex justify-content-center mt-3">
        <button type="button" id="btn_cancelar_eliminar_radicado_{{$resLineaPersonalEdit->id_lineas_personal}}"
            class="btn btn-secondary me-3" data-bs-dismiss="modal">
            <i class="fa fa-times"></i> Cancelar
        </button>

        <button type="submit" id="btn_eliminar_radicado_{{$resLineaPersonalEdit->id_lineas_personal}}"
            class="btn btn-success" title="Eliminar Radicado">
            <i class="fa-regular fa-floppy-disk"></i> Eliminar
        </button>
    </div>
</x-form>
