@extends('adminlte::page')
@section('title', 'Productos')

@section('content_header')
    <div class="card" style="height:4em;">
        <div class="card-header">
            <h2>Crear nuevo producto</h2>
        </div>

    </div>

@endsection

@section('content')



    <div class="container">
        {{-- <br> --}}
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has('alert-' . $msg))
                <div class="alert {{ 'alert-' . $msg }} alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ Session::get('alert-' . $msg) }}
                </div>
            @endif
        @endforeach
        <button class="btn btn-primary" type="button" onclick="mifuncion()">Escanear</button>
        <br>
        {{-- <div class="row"> --}}
            <div class="col-sm-12" align="center">
                <video id="preview" style="display: none" class="p-1 border active" ></video>
            </div>
        {{-- </div> --}}
        <br>
        <style>
            #preview {
                width: 100%;
                margin: 0px auto;
            }
            @media only screen and (min-width: 1000px) {
            /* styles for browsers larger than 1440px; */
            #preview {
                width: 350px;
                margin: 0px auto;
            }
            }
        </style>
        <script type="text/javascript">
            function mifuncion() {
                $("#preview").show();
                let scanner = new Instascan.Scanner({
                    video: document.getElementById('preview'),
                    mirror: false,
                    scanPeriod: 6
                });
                scanner.addListener('scan', function(content) {
                    // alert(content);
                    document.getElementById('hola').value = content;
                    scanner.stop();
                    $("#preview").hide();

                });
                Instascan.Camera.getCameras().then(function(cameras) {
                    if (cameras.length == 1) {
                        scanner.start(cameras[0]);
                    }
                    if (cameras.length > 1) {
                        scanner.start(cameras[1]);
                    }else {
                        console.error('No cameras found.');
                    }
                }).catch(function(e) {
                    console.error(e);
                });
            }
        </script>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('compras.create') }}">
                    @csrf
                    <style>
                        .padding_center {
                            padding-left: 25%;
                        }

                        .texto_radio {
                            text-align: center;
                        }

                        .upper {
                            text-transform: uppercase;
                        }

                        @media (min-width: 360px) and (max-width: 767px) {
                            .padding_center {
                                padding-left: 0px;
                            }

                            .texto_radio {
                                text-align: left
                            }

                            .two-column {
                                width: 50%;
                                float: left;
                            }
                        }

                        @media (min-width: 768px) and (max-width: 1413px) {
                            .padding_center {
                                padding-left: 15%;
                            }

                            .texto_radio {
                                text-align: center;
                                height: 57px;
                            }

                        }
                    </style>



                    <div class="form-group">



                        <div class="row">
                            <div class="col-sm-3">
                                <label for="exampleInputEmail1">Serial </label>
                                <input type="text" autocomplete="on" class="form-control upper" name="serial"
                                    id="hola" value="" aria-describedby="emailHelp" placeholder="Serial"
                                    required>
                                <ul id="lista_id"></ul>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Elemento </label>
                                <input type="text" class="form-control upper" name="elemento" value=""
                                    placeholder="Elemento" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Caracteristicas </label>
                                <input type="text" class="form-control upper" name="caracteristicas" value=""
                                    placeholder="Caracteristicas" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Cantidad </label>
                                <input type="number" class="form-control upper" name="cantidad" value=""
                                    placeholder="Cantidad" required>
                            </div>

                        </div>

                        <br>

                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">Ancho </label>
                                <input type="text" class="form-control upper" name="ancho" value=""
                                    placeholder="Ancho" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="">largo </label>
                                <input type="text" class="form-control upper" name="largo" value=""
                                    placeholder="largo" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="">color </label>
                                <input type="text" class="form-control upper" name="color" value=""
                                    placeholder="color" required>
                            </div>
                            <div class="col-sm-3">
                                <label for="">tela </label>
                                <input type="text" class="form-control upper" name="tela" value=""
                                    placeholder="tela" required>
                            </div>
                        </div>

                    </div>
                    <input class="btn btn-success float-right" type="submit" value="Ingresar" />
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
