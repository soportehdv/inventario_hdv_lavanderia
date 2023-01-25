@extends('adminlte::page')
@section('title', 'Ubicaciones')

@section('content_header')
<div class="card" style="height:4em;">
    <div class="card-header">
      <h2>Ubicaciones</h2>
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
    <a href="{{route('listaubicacion.create.vista')}}" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Añadir nueva ubicación</a>
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
      @if(Session::has('alert-' . $msg))
        <div class="alert {{'alert-' . $msg}} alert-dismissable">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ Session::get('alert-' . $msg) }}
        </div>

        @endif
    @endforeach
    <br>
    <table id="ubicaciones" class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col" style="background-color:#343a40; color:white;">Nombre</th>
            <th scope="col">Acción</th>

          </tr>
        </thead>
        <tbody>
            @foreach($ubicacion as $ubi)
            <tr>
                <th scope="row">{{$ubi->id}}</th>
                <td>{{$ubi->nombre}}</td>

                <td><a href="{{route('listaubicacion.update.vista', $ubi->id)}}" class="btn btn-success mb-2"><i class="fas fa-edit"></i> Editar</a>
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
        $('#ubicaciones').DataTable({
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
