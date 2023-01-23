@extends('adminlte::page')
@section('title', 'Productos')

@section('content_header')
    <div class="card" style="height:4em;">
        <div class="card-header">
            <h2>Lavanderia</h2>
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
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('listalavado.create.vista') }}" class="btn btn-primary mb-2"><i
                        class="fas fa-plus-circle"></i>
                    Añadir
                    nuevo</a>
            </div>
            <div class="col-sm-6" style="">
                <button type="button" class="btn btn-primary ajustarSize" data-toggle="modal" data-target="#exampleModal"
                    style="float: right"><i class="fas fa-filter"></i>
                    Filtrar por fecha
                </button>
            </div>
        </div>

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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Seleccione fechas para filtrar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="GET" action="{{ route('listalavado.fecha', ['filtro' => 4]) }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fecha Inicial</label>
                                <input type="date" class="form-control" name="fecha_inicial" placeholder="Fecha inicial" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fecha Final</label>
                                <input type="date" class="form-control" name="fecha_final" placeholder="Fecha final" required>
                            </div>
                            <div class="form-group">
                                <label for="">Ubicación </label>
                                <select id="departamento" name="departamento" class="form-control">
                                    <option value="">Seleccioné una ubicación</option>
                                    @foreach ($ubicacion as $ubi)
                                        <option value="{{ $ubi->id }}">
                                            {{ $ubi->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <table id="lavado" class="table table-striped table-res">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="background-color:#343a40; color:white;">Tipo de prenda</th>
                    <th>Unidades</th>
                    <th>Servicio</th>
                    <th>Creacion</th>
                    <th>Actualización</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listalavado as $lavado)
                    <tr>
                        <th>{{ $lavado->id }}</th>
                        <td style="text-transform: uppercase">{{ $lavado->elemento }} </td>
                        <td>{{ $lavado->unidades }}</td>
                        <td>{{ $lavado->nombre }}</td>
                        <td>{{ $lavado->created_at }}</td>
                        <td>{{ $lavado->updated_at }}</td>
                        <td><a href="{{ route('listalavado.update.vista', $lavado->id) }}" class="btn btn-success mb-2"><i
                                    class="fas fa-edit"></i> Editar</a>
                        </td>
                    </tr>
                    @endforeach
                    @if ($start != null && $end != null)

                    <tr>
                        @php
                            $suma2=0;
                            @endphp
                        <th>FIN</th>
                        <td style="font-weight: 700">TOTAL</td>
                        @foreach ($listalavado as $lavado2)
                        @php
                                $suma2 += $lavado2->unidades;
                                @endphp
                        @endforeach
                        <th>{{ $suma2 }}</th>
                        <td style="font-weight: 700">FILTRO </td>
                        <td style="font-weight: 700">DESDE: {{ $start }}</td>
                        <td style="font-weight: 700">HASTA: {{ $end }}</td>
                    </tr>
                    @endif
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
            $('#lavado').DataTable({
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
@endsection
