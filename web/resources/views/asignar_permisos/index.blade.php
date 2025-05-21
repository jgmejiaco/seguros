@extends('layouts.app')
@section('title', 'Asignar Permisos')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="p-3 d-flex flex-column">
        <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
            <h4 class="border rounded-top text-white text-center pt-2 pb-2 text-uppercase" style="background-color: #337AB7;">Asignar Permiso</h4>

            {{-- ====================================================== --}}
            {{-- ====================================================== --}}
            {{-- ====================================================== --}}

            <x-form action="{{route('asignar_permisos.store')}}" method="POST" class="mt-0" id="formAsignarPermisos" autocomplete="off" >
                <div class="m-0 p-3">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <x-select name="id_rol" label="Rol" id="id_rol" autocomplete="organization-title" required >
                                <option value="">Seleccionar...</option>
                                @foreach($roles as $id_rol => $rol)
                                    <option value="{{$id_rol}}">{{$rol}}</option>
                                @endforeach
                            </x-select>
                        </div>
                
                        <div class="col-12 col-md-6 text-center">
                            <div id="loadingPermissions" class="aligned-middle d-none">
                                <img src="{{ asset('img/loading.gif') }}" alt="Procesando..." height="50" width="50">
                                <p class="mb-0"><strong>Procesando...</strong></p>
                            </div>
                        </div>
                    </div>
            
                    <div class="mt-5">
                        <h3 class="border rounded text-center pt-2 pb-2 m-0" style="background-color: #EEEEEE;">Permisos Asignados</h3>
                    </div>
        
                    <div class="mt-4 mb-4">
                        <h5 class="text-start">Seleccione los permisos que deseas asignar</h5>
                    </div>
        
                    <div class="col-12 pt-2">
                        {{-- Checkbox para seleccionar todos --}}
                        <div class="permiso-item" style="padding-bottom: 20px;">
                            <input type="checkbox" id="seleccionar_todos">
                            <label for="seleccionar_todos" class="pointer"><strong>Seleccionar todos</strong></label>
                        </div>
        
                        <div class="permiso-grid" id="permisos-grid">
                            @foreach ($permisosAsignados as $permiso)
                                <div class="permiso-item">
                                    <input
                                        type="checkbox"
                                        class="permiso-checkbox"
                                        name="permisos[]"
                                        value="{{ $permiso->id }}"
                                        id="permiso_{{ $permiso->id }}"
                                    >
                                    <label for="permiso_{{ $permiso->id }}" class="pointer">{{ $permiso->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
            
                    <!-- Contenedor para el GIF -->
                    <div id="loadingIndicatorAsignarPermiso" class="loadingIndicator">
                        <img src="{{ asset('img/loading.gif') }}" alt="Procesando...">
                    </div>
            
                    {{-- ====================================================== --}}
            
                    <div class="mt-5 mb-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success rounded-2 me-3" id="btnAsignarPermisos">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Asignar
                        </button>
                    </div>
                </div>
            </x-form>
        </div> {{-- FIN div_p-0 --}}
    </div> {{-- FIN div_p-3 d-flex flex-column --}}
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {

            // Si Select2 ya está inicializado
            if ($('#id_rol').hasClass('select2-hidden-accessible')) {
                $('#id_rol').select2('destroy').removeClass('select2');
            }
            
            // Prevenir futuras inicializaciones
            $(document).on('select2:init', '#id_rol', function(e) {
                $(this).removeClass('select2');
            });

            // ====================================================

            // Función para desactivar el select y crear input hidden
            function disableRoleSelect() {
                const form = $("#formAsignarPermisos");
                const idRol = $("#id_rol");
                
                if (!idRol.prop('disabled')) {
                    idRol.prop("disabled", true)
                        .addClass("bg-secondary-subtle");
                    
                    // Crear input hidden para mantener el valor
                    $('<input>').attr({
                        type: 'hidden',
                        name: idRol.attr('name'),
                        value: idRol.val(),
                        id: 'hidden_id_rol'
                    }).appendTo(form);
                }
            }

            // Función para reactivar el select
            function enableRoleSelect() {
                const idRol = $("#id_rol");
                const hiddenInput = $("#hidden_id_rol");
                
                idRol.prop("disabled", false)
                    .removeClass("bg-secondary-subtle");
                
                // Eliminar el input hidden si existe
                if (hiddenInput.length) {
                    hiddenInput.remove();
                }
            }

            $("#id_rol").change(function() {
                let form = $(this).closest('form');
                let idRol = $("#id_rol").val();
                $('.permiso-checkbox').prop('checked', false);
                const submitButton = $("#btnAsignarPermisos");

                // Desactivar el select al iniciar la consulta
                disableRoleSelect();

                $.ajax({
                    url: "{{route('consultar_permisos_rol')}}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id_rol': idRol
                    },
                    beforeSend: function()
                    {
                        $("#loadingPermissions").show('slow');
                        $("#loadingPermissions").removeClass('d-none');
                    
                        submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");
                    },
                    success: function(response)
                    {
                        // Reactivar el select al recibir respuesta
                        enableRoleSelect();

                        $("#loadingPermissions").hide('slow').addClass('d-none');
                        submitButton.prop("disabled", false).html("<i class='fa-regular fa-floppy-disk'></i> Asignar");

                        if (response == "error_exception") {
                            Swal.fire('Error!', 'Ha ocurrido un error consultando los permisos', 'error');
                            return;
                        }

                        // Si tiene permisos asignados, marcarlos
                        if (response.permisos && response.permisos.length > 0) {
                            response.permisos.forEach(id => {
                                $('#permiso_' + id).prop('checked', true);
                            });
                        }
                    }, // FIN success:
                    error: function() {
                        // Asegurarse de reactivar el select incluso en caso de error
                        enableRoleSelect();
                        $("#loadingPermissions").hide('slow').addClass('d-none');
                        submitButton.prop("disabled", false).html("<i class='fa-regular fa-floppy-disk'></i> Asignar");
                        Swal.fire('Error!', 'Error en la comunicación con el servidor', 'error');
                    }
                }); // FIN $.ajax
            }); // FIN $("#id_rol").change(function()

            // ===============================================================

            document.getElementById('seleccionar_todos').addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.permiso-checkbox');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            // ===============================================================

            $("#formAsignarPermisos").on("submit", function (e) {
                const form = $(this);
                const submitButton = form.find('button[type="submit"]');
                const loadingIndicator = form.find("div[id^='loadingIndicatorAsignarPermiso']"); // Busca el GIF del form actual
        
                // Dessactivar Botones
                submitButton.prop("disabled", true).html("Procesando... <i class='fa fa-spinner fa-spin'></i>");

                // Desactivar el select al enviar el formulario
                disableRoleSelect();
                
                // Mostrar Spinner
                loadingIndicator.show();
            });
        }); // FIN document.ready
    </script>
@stop


