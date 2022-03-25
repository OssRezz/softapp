@extends('layouts.layoutIndex')
@section('title', 'Inicio')
@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">

            @foreach ($listaServicios as $item)
                <div class="col-md-auto d-flex justify-content-center mb-4">
                    <div class="card  serviceCard" style="width: 18rem;">
                        <img src="{{ $item->imagen }}" loading="lazy" class="img-fluid img-thumbnail imgsize"
                            alt="Image Responsive">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nombre }}</h5>
                            <p class="card-text">{{ $item->observaciones }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Tipo Servicio:</b> {{ $item->tipo }}</li>
                            <li class="list-group-item"><b>Inicio:</b> {{ $item->fechaInicio }}</li>
                            <li class="list-group-item"><b>Fin:</b> {{ $item->fechaFin }}</li>
                        </ul>
                        <div class="card-body p-1 m-0">
                            <div class="d-grid ">
                                <button id="btn-servicio" value="{{ $item->id }}"
                                    class="btn btn-outline-dark border-0">Adquirir</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
    <script src="{{ asset('js/servicios/servicioIndex.js') }}"></script>
@endsection
