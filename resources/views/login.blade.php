@extends('layouts.layoutLogin')
@section('title', 'Login')
@section('content')
    <div class="container">
        <div class="row align-items-center vh-100">
            <div class="col-12 col-md-8 col-lg-4 mx-auto">
                <div class="card bg-white">
                    <div class="card-body">
                        <div class="card-header text-center bg-white  border-0 my-2 pb-0">
                            <img src="{{ asset('img/monitor.png') }}" class="mb-2" width="120" height="120"
                                class="d-inline-block" />
                            <br />
                        </div>
                        <div class="card-body text-muted">
                            <form action="login/singin" method="POST">
                                @csrf
                                <div class="form-row mb-4">
                                    <div class="form-group col-12 mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-dark"><i
                                                    class="fas fa-at"></i></span>
                                            <input type="email" class="form-control" name="email" placeholder="Email" />
                                        </div>
                                        @error('email')
                                            <small class="text-danger">*{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white text-dark"><i
                                                    class="fas fa-key"></i></span>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Password" />
                                        </div>
                                        @error('password')
                                            <small class="text-danger">*{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" d-grid">
                                    <button type="submit" class="btn btn-block btn-outline-dark inicio"
                                        id="btn-ingresar">Iniciar sesion</button>
                                </div>
                            </form>
                        </div>
                        @if (session()->has('message'))
                            <div class="card-footer p-0">
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    {{ session()->get('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
