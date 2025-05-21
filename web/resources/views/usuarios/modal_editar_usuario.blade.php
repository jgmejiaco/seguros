<x-form
    action="{{route('usuarios.update', $usuario->id_usuario)}}"
    method="PUT"
    class="mt-2"
    id="formEditarUsuario_{{$usuario->id_usuario}}"
    autocomplete="off">
    <input type="hidden" name="id_usuario" value="{{$usuario->id_usuario}}" required>
    
    <div class="rounded-top text-white text-center"
        style="background-color: #337AB7; border: solid 1px #337AB7;">
        <h5 class="fw-bold" style="margin-top: 0.3rem; margin-bottom: 0.3rem;">Editar Usuario</h5>
    </div>

    <div class="modal-body p-0 m-0" style="border: solid 1px #337AB7;">
        <div class="row m-4">
            <div class="col-12 col-md-6">
                <x-input
                    name="nombre_usuario"
                    type="text"
                    label="Nombres"
                    value="{{$usuario->nombre_usuario}}"
                    id="nombre_usuario"
                    autocomplete="given-name"
                    required
                />
            </div>
            
            <div class="col-12 col-md-6">
                <x-input
                    name="apellido_usuario"
                    type="text"
                    label="Apellidos"
                    value="{{$usuario->apellido_usuario}}"
                    id="apellido_usuario"
                    autocomplete="family-name"
                    required
                />
            </div>
        </div>

        <div class="row m-4">
            <div class="col-12 col-md-6">
                <x-input
                    name="correo"
                    type="email"
                    label="Correo"
                    value="{{$usuario->correo}}"
                    id="correo"
                    autocomplete="email"
                    required
                />
            </div>

            <div class="col-12 col-md-6">
                <x-select
                    name="id_rol"
                    label="Rol"
                    id="id_rol"
                    autocomplete="organization-title"
                    required
                >
                    <option value="">Seleccionar...</option>
                    @foreach($roles as $key => $value)
                        <option value="{{$key}}" {{(isset($usuario) && $usuario->id_rol == $key) ? 'selected' : ''}}>
                            {{$value}}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>

    <div class="modal-footer d-block mt-0 border border-0">
        <!-- Contenedor para el GIF -->
        <div id="loadingIndicatorEditUser_{{$usuario->id_usuario}}"
            class="loadingIndicator">
            <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="btn_cancelar_user_{{ $usuario->id_usuario }}"
                class="btn btn-secondary me-3" data-bs-dismiss="modal">
                <i class="fa fa-times"></i> Cancelar
            </button>

            <button type="submit" id="btn_editar_user_{{$usuario->id_usuario}}"
                class="btn btn-success" title="Editar">
                <i class="fa-regular fa-floppy-disk"></i> Editar
            </button>
        </div>
    </div>
</x-form>
