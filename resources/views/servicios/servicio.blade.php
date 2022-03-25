@extends('layouts.layout')
@section('title', 'Servicios')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-4 mb-3">
            <div class="card ">
                <div class="card-header"><i class="fas fa-plus-square text-primary"></i> <b>Formulario de clientes</b>
                </div>
                <div class="card-body">
                    <form action="servicios/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Nombre" name="Nombre">
                            <label for="Nombre">Nombre servicio</label>
                            @error('Nombre')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file">Imagen servicio</label>
                            <input accept="image/*" class='form-control' type='file' id='file' name='file'>
                            @error('file')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" placeholder="inicioServicio" name="inicioServicio">
                            <label for="inicioServicio">Inicio servicio</label>
                            @error('inicioServicio')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" placeholder="finalServicio" name="finalServicio">
                            <label for="finalServicio">Final servicio</label>
                            @error('finalServicio')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" placeholder="tipoServicio" name="tipoServicio">
                                <option disabled selected>Selecciona el tipo de servicio</option>
                                @foreach ($listaTipoServicio as $item)
                                    <option value="{{ $item->id }}">{{ $item->tipo }}</option>
                                @endforeach

                            </select>
                            <label for="tipoServicio">Final servicio</label>
                            @error('tipoServicio')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="observacionesServicio" name="observacionesServicio" placeholder="observacionesServicio"
                                class="form-control" style="height: 100px"></textarea>
                            <label for="observacionesServicio">Observaciones servicio</label>
                            @error('observacionesServicio')
                                <small class="text-danger">*{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-outline-primary">Ingresar servicio</button>
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
                        <table class="table table-hover table-sm" id="tableServicios" style="width: 100%">
                            <thead>
                                <th>Servicio</th>
                                <th>Inico</th>
                                <th>Fin</th>
                                <th class="text-center">Accion</th>
                            </thead>
                            <tbody>
                                @foreach ($listaServicios as $item)
                                    <tr>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->fechaInicio }}</td>
                                        <td>{{ $item->fechaFin }}</td>
                                        <td class="text-center">
                                            <button id="btn-detalle-servicio" value="{{ $item->id }}"
                                                class="btn btn-outline-primary btn-sm"><i class="fas fa-info-circle"
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
    <script src="{{ asset('js/servicios/servicios.js') }}"></script>
    <script src="{{ asset('js/datatable/serviciosTable.js') }}"></script>
@endsection
