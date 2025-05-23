@extends('layouts.app')
@section('title', 'Auditorias')

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('css')
    <style>
        
    </style>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('content')
    <div class="p-3 d-flex flex-column">
        <div class="p-0" style="border: solid 1px #337AB7; border-radius: 5px;">
            <h5 class="border rounded-top text-white text-center pt-2 pb-2" style="background-color: #337AB7;">Auditorias</h5>

            {{-- =============================================================== --}}
            {{-- =============================================================== --}}
            {{-- =============================================================== --}}

            <div class="col-12 p-3" id="">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered w-100 mb-0" id="tbl_auditorias"
                        aria-describedby="users-usuarios">
                        <thead>
                            <tr class="header-table text-center">
                                <th>Id Auditoria</th>
                                <th>Usuario Responsable</th>
                                <th>Evento</th>
                                <th>Módulo</th>
                                <th>Id Auditado</th>
                                <th>Valores Anteriores</th>
                                <th>Valores Nuevos</th>
                                <th>Url</th>
                                <th>Ip Origen</th>
                                <th>Navegador/Dispositivo</th>
                                <th>Etiquetas</th>
                            </tr>
                        </thead>
                        {{-- ============================== --}}
                        <tbody>
                            @foreach ($auditsIndex as $auditoria)
                                <tr class="text-center">
                                    <td>{{$auditoria->id}}</td>
                                    <td>{{$auditoria->usuario}}</td>
                                    <td>{{$auditoria->event}}</td>
                                    <td>{{$auditoria->auditable_type}}</td>
                                    <td>{{$auditoria->auditable_id}}</td>
                                    <td>{{$auditoria->old_values}}</td>
                                    <td>{{$auditoria->new_values}}</td>
                                    <td>{{$auditoria->url}}</td>
                                    <td>{{$auditoria->ip_address}}</td>
                                    <td>{{$auditoria->user_agent}}</td>
                                    <td>{{$auditoria->tags}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> {{-- FIN div_campos_usuarios --}}
        </div> {{-- FIN div_crear_usuario --}}
    </div>
@stop

{{-- =============================================================== --}}
{{-- =============================================================== --}}
{{-- =============================================================== --}}

@section('scripts')
    <script>
        $(document).ready(function() {

            // INICIO DataTable Auditorias
            $("#tbl_auditorias").DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '📥 Exportar Excel',
                        className: 'waves-effect waves-light btn btn-sm btn-success rounded-pill',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row:first c', sheet).attr('s', '42');
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📄 Exportar PDF',
                        className: 'waves-effect waves-light btn btn-sm btn-danger rounded-pill',
                        exportOptions: {
                            columns: ':visible'
                        },
                        orientation: 'landscape',
                        pageSize: 'letter',
                        title: 'Listado de Auditorias'
                    }
                ],
                language: {
                    url: "{{ asset('DataTable1.13.6/es-ES.json') }}"
                },
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 30, -1],
                    [10, 20, 30, "Todos"]
                ],
                scrollX: true,
                bSort: true,
                stripe: true,
                responsive: true,
                infoEmpty: "No hay registros disponibles",
                order: [[0, 'desc']]  // Indicar la columna predeterminada contando desde 0
            });
            // CIERRE DataTable Auditorias
        }); // FIN document.ready
    </script>
@stop
