@extends('adminlte::page')

@section('title', 'Home')

@section('content')
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(auth()->user()->role === 'atleta')
                            ¿Quieres inscribirte en una competencia? Revisa nuestro listado <a href="{{ route('main') }}">aqui</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('js.toastr')
@endsection
