@extends('adminlte::page')
@section('title', 'Usuarios')

@section('content_header')
    <div class="card" style="height:4em;">
        <div class="card-header">
            <h2>Usuarios</h2>
        </div>

    </div>

@endsection

@section('content')

    <div class="container">
        @if ($errors->any())
            <ul style="padding: initial">
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <li>{{ $error }}</li>
                    </div>
                @endforeach
            </ul>
        @endif
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email </label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                            aria-describedby="emailHelp" placeholder="Ingresa email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre </label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                            aria-describedby="emailHelp" placeholder="Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Area de servicio </label>
                        <input type="text" class="form-control" name="cargo" value="{{ $user->cargo }}"
                            aria-describedby="emailHelp" placeholder="Proceso" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Rol </label>
                        <select class="form-control" name="rol" required>
                            @if ($user->rol === 'servicios')
                                <option value="{{ $user->rol }}">{{ $user->rol }}</option>
                                <option value="admin">Admin</option>
                            @else
                                <option value="{{ $user->rol }}">{{ $user->rol }}</option>
                                <option value="servicios">Servicios</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="float: right">Guardar</button>
                </form>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Se cambiara la contraseña actual</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('user.update', $user->id) }}">
                            @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Escriba la nueva contraseña</label>
                                <input type="password" class="form-control" name="password" value=""
                                    aria-describedby="emailHelp" placeholder="Contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Confirmar la nueva contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    value="" aria-describedby="emailHelp" placeholder="Confirmar contraseña"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- Button trigger modal Cambiar contraseña -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                Cambiar contraseña
            </button>
            </div>
        </div>

    </div>
@endsection
