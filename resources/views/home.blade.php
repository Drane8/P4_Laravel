@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card my-4">
                <div class="card-header">Inicio</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="text-center">
                    <a href="{{url('/insertar')}}" class="btn btn-outline-info botonAncho" role="button">Insertar</a>
                    <a href="{{url('/consultar')}}" class="btn btn-outline-info botonAncho" role="button">Consultar</a>
                    </div>

                 </div>
            </div>
        </div>
    </div>
</div>
@endsection