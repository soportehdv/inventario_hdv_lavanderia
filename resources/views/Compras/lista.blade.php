@extends('adminlte::page')
@section('title', 'Productos')

@section('content_header')
    <div class="card" style="height:4em;">
        <div class="card-header">
            <h2>Productos</h2>
        </div>
    </div>
    @if ($search)
        <div class="alert alert-primary" role="alert">
            Los resultados para su busqueda '{{ $search }}' son:
            <button type="button" class="close" data-dismiss="alert" style="color:white">&times;</button>
        </div>
    @endif
@section('cssDataTable')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
@endsection
@endsection

@section('content')



<div class="container">
    <a href="{{ route('compras.create.vista') }}" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Añadir
        nuevo</a>
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if (Session::has('alert-' . $msg))
            <br>
            <div class="alert {{ 'alert-' . $msg }} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('alert-' . $msg) }}
            </div>
        @endif
    @endforeach
    <br>
    <table id="productos" class="table table-striped table-res">
        <thead>
            <tr>
                <th>#</th>
                <th style="background-color:#343a40; color:white;">Serial</th>
                <th>Elemento</th>
                <th>Caracteristica</th>
                <th>Ancho</th>
                <th>Largo</th>
                <th>color</th>
                <th>tela</th>
                <th>Unidades</th>
                <th>Acción</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <th>{{ $compra->id }}</th>
                    <td style="text-transform: uppercase">{{ $compra->serial }}</td>
                    <td>{{ $compra->elemento }}</td>
                    <td>{{ $compra->caracteristicas }}</td>
                    <td style="text-transform: uppercase">{{ $compra->ancho }}</td>
                    <td>{{ $compra->largo }}</td>
                    <td style="text-transform: uppercase">{{ $compra->color }}</td>
                    <td>{{ $compra->tela }}</td>
                    <td>{{ $compra->unidades }}</td>
                    <td><a href="{{ route('compras.update.vista', $compra->id) }}" class="btn btn-success mb-2"><i
                                class="fas fa-edit"></i> Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('jsDataTable')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productos').DataTable({
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
@endsection
