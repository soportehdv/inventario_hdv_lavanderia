@extends('adminlte::page')
@section('title', 'Productos')

@section('content_header')
    <div class="card">
        <div class="card-header" style="height:4em;">
            <h2>Modificar producto</h2>
        </div>

    </div>

@endsection

@section('content')



    <div class="container">

        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has('alert-' . $msg))
                <div class="alert {{ 'alert-' . $msg }} alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ Session::get('alert-' . $msg) }}
                </div>
            @endif
        @endforeach
        {{-- <button class="btn btn-primary" type="button" onclick="mifuncion()">Escanear</button> --}}
        {{-- <br> --}}
        {{-- <div class="row"> --}}
            {{-- <div class="col-sm-12" align="center">
                <video id="preview" style="display: none" class="p-1 border active"></video>
            </div> --}}
        {{-- </div> --}}
        {{-- <br> --}}
        <style>
            #preview {
                width: 100%;
                margin: 0px auto;
            }
            @media only screen and (min-width: 1000px) {
            #preview {
                width: 350px;
                margin: 0px auto;
            }
            }
        </style>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('listalavado.update', $listalavado->id) }}">
                    @csrf
                    <style>
                        .padding_center{
                            padding-left: 25%;
                        }
                        .texto_radio{
                            text-align: center;
                        }
                        @media (min-width: 400px) and (max-width: 767px){
                            .padding_center{
                                padding-left: 0px;
                            }
                            .texto_radio{
                                text-align: left
                            }
                            .two-column{
                                width: 50%;
                                float: left;
                            }
                        }
                        @media (min-width: 768px) and (max-width: 1413px){
                            .padding_center{
                                padding-left: 15%;
                            }
                            .texto_radio{
                                text-align: center;
                                height: 57px;
                            }

                        }
                    </style>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Tipo de prenda :</label>
                                <select class="form-control" name="tipo" required>
                                    @php
                                        $num = (int) "$listalavado->tipo";
                                        $num2 = (int) "$listalavado->servicio";
                                    @endphp
                                    @foreach ($compras as $compra)
                                        <option value="{{ $compra->id }}"
                                            @if ($compra->id === $num) selected='selected' @endif>
                                            {{ $compra->elemento }}, {{ $compra->caracteristicas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="">Unidades </label>
                                <input type="number" class="form-control upper" name="unidades" value="{{ $listalavado->unidades }}"
                                    placeholder="Unidades">
                            </div>
                            <div class="col-sm-4">
                                <label for="">Tipo de prenda :</label>
                                <select class="form-control" name="servicio" required>
                                    @foreach ($ubicacion as $ubi)
                                        <option value="{{ $ubi->id }}"
                                            @if ($ubi->id === $num2) selected='selected' @endif>
                                            {{ $ubi->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <br>

                    </div>
                    <input class="btn btn-success float-right" type="submit" value="Actualizar" />
                    <a class="btn btn-danger float-left" href="{{ URL::previous() }}">Atras</a>

                </form>



            </div>
        </div>

    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
    $('.selectpicker').selectpicker({
        style: 'btn-default'
    });
</script>
