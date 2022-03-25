@extends('layouts.layout')
@section('title', 'Clientes')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header"><i class="fas fa-plus-square text-primary"></i> <b>Formulario de clientes</b>
                </div>
                <div class="card-body">
                    <form action="clientes/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Nombre" name="Nombre">
                            <label for="Nombre">Nombre cliente</label>
                            @error('Nombre')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="Cedula" name="Cedula">
                            <label for="Cedula">Cedula cliente</label>
                            @error('Cedula')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="Email">
                            <label for="Email">Email cliente</label>
                            @error('Email')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" placeholder="Telefono" name="Telefono">
                            <label for="Telefono">Telefono cliente</label>
                            @error('Telefono')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="file">Imagen cliente</label>
                            <input accept="image/*" class='form-control' type='file' name='file'>
                            @error('file')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="Observaciones" id="Observaciones" placeholder="Observaciones" class="form-control"
                                style="height: 100px"></textarea>
                            <label for="Observaciones">Observaciones cliente</label>
                            @error('Observaciones')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="d-grid">
                            <button id="btn-ingresar-cliente" type="submit" class="btn btn-outline-primary">Ingresar
                                cliente</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col mb-5">
            <div class="card">
                <div class="card-header"><i class="fas fa-list text-primary"></i> <b>Lista de clientes</b></div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-hover table-sm" id="tableClientes" style="width: 100%">
                            <thead>
                                <th>Nombre</th>
                                <th>Cedula</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                @foreach ($listaClientes as $item)
                                    <tr>
                                        <td class="mouse-pointer cliente" id="{{ $item->id }}">
                                            {{ $item->nombre }}
                                        </td>
                                        <td>{{ $item->cedula }}</td>
                                        <td>{{ $item->correo }}</td>
                                        <td>{{ $item->telefono }}</td>
                                        <td class="text-center">
                                            <button id="btn-detalle-cliente" value="{{ $item->id }}"
                                                class="btn btn-outline-primary btn-sm"><i class="fas fa-info-circle "
                                                    style="pointer-events: none;"></i></button>
                                            <button id="btn-edit-cliente" value="{{ $item->id }}"
                                                class="btn btn-outline-primary btn-sm"><i class="fas fa-edit "
                                                    style="pointer-events: none;"></i></button>
                                            <button id="btn-delete-cliente" value="{{ $item->id }}"
                                                class="btn btn-outline-danger btn-sm"><i class="fas fa-trash "
                                                    style="pointer-events: none;"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if (session()->has('message'))
                            <div class="alert alert-primary alert-dismissible fade show my-3" role="alert">
                                {{ session()->get('message') }}
                                <button type="submit" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/clientes/cliente.js') }}"></script>
    <script src="{{ asset('js/datatable/clientesTable.js') }}"></script>

@endsection
