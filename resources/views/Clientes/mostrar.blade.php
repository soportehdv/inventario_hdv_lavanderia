@extends('adminlte::page')
@section('title', 'Responsables')

@section('content_header')
    <div class="card" style="height:4em;">
        <div class="card-header">
            <h2>Lista de responsables</h2>
        </div>

    </div>
@section('cssDataTable')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
@endsection

@endsection

@section('content')

<div class="container">

    <div class="row">
        <div class="col-sm-8">
            <a href="{{ route('clientes.create.vista') }}" class="btn btn-primary mt-4"><i class="fas fa-plus-circle"></i>
                Añadir nuevo</a>

        </div>
    </div>

</div>
@if (Auth::user()->rol == 'admin')
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if (Session::has('alert-' . $msg))
            <div class="alert {{ 'alert-' . $msg }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('alert-' . $msg) }}
            </div>
        @endif
    @endforeach
    <br>
    <div class="container">

        <table id="pedidos1" class="table table-striped table-res">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Responsable</th>
                    <th style="background-color:#343a40; color:white;">Ubicación</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Cant.</th>
                    <th>Pend.</th>
                    <th>Comentario</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->responsable }}</td>
                        <td>{{ $cliente->ubicacion }}</td>
                        <td>{{ $cliente->registro }}</td>
                        @if ($cliente->entregado != 0)
                            <td>
                                <span class="badge badge-pill badge-danger">Pendiente</span>
                            </td>
                        @else()
                            <td>
                                <span class="badge badge-pill badge-success">Entregado</span>
                            </td>
                        @endif

                        <td>{{ $cliente->elemento }}, {{ $cliente->caracteristicas }}</td>
                        <td>{{ $cliente->cantidad }}</td>
                        <td>{{ $cliente->entregado }}</td>
                        <td
                            style="max-width: 100px;
                            font-size: 16px;
                            overflow: hidden;
                            white-space: nowrap;
                            text-overflow: ellipsis;">
                            {{ $cliente->direccion }}
                        </td>
                        <td>
                            <a href="{{ route('clientes.update.vista', $cliente->id) }}"
                                class="btn btn-success mb-2"><i class="fas fa-eye"></i></a>

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@else
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if (Session::has('alert-' . $msg))
            <div class="alert {{ 'alert-' . $msg }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('alert-' . $msg) }}
            </div>
        @endif
    @endforeach
    <br>
    <div class="container">

        <table id="pedidos2" class="table table-striped table-res">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Responsable</th>
                    <th>Cargo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Tipo</th>
                    <th>Cant.</th>
                    <th>pend.</th>
                    <th>ubicación</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    @if (Auth::user()->id == $cliente->responsable_id)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->responsable }}</td>
                            <td>{{ $cliente->cargo }}</td>
                            <td>{{ $cliente->registro }}</td>
                            @if ($cliente->entregado != 0)
                                <td>
                                    <span class="badge badge-pill badge-danger">Pendiente</span>
                                </td>
                            @else()
                                <td>
                                    <span class="badge badge-pill badge-success">Entregado</span>
                                </td>
                            @endif
                            <td>{{ $cliente->elemento }}, {{ $cliente->caracteristicas }}</td>
                            <td>{{ $cliente->cantidad }}</td>
                            <td>{{ $cliente->entregado }}</td>
                            <td>{{ $cliente->ubicacion }}</td>
                            <td
                                style="max-width: 100px;
                            font-size: 16px;
                            overflow: hidden;
                            white-space: nowrap;
                            text-overflow: ellipsis;">
                                {{ $cliente->direccion }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>


    </div>
@endif
</div>
@endsection
@section('jsDataTable')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pedidos1').DataTable({
            "language": {
                searchPanes: {
                    title: {
                        _: 'Total de filtros selecionados - %d',
                        0: 'Selecione un opción para filtrar tu busqueda',
                        1: 'Se ha selecionado un filtro'
                    },
                    "clearMessage": "Borrar seleccionados",
                    "showMessage": "Mostrar Todo",
                    "collapseMessage": "Contraer Todo",
                    count: '{total}',
                    countFiltered: '{shown} ({total})',
                },
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se ha encontrado nada relacionado - Disculpa",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "buttons": {
                    "copy": "Copiar",
                    "print": "Imprimir",
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#pedidos2').DataTable({});
    });
</script>
@endsection
