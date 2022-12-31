@extends('adminlte::page')

@section('title', 'Fechas')

@section('content')
    <br>
    <div class="card">
        <div class="card-header bg-gradient-dark">
            <div class="row">
                <div class="col"><span class="card-title">Listado fechas competencia</span></div>
                <div class="col">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                        Crear fecha
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="table_id" class="display">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Publicado</th>
                    <th>Creado</th>
                    <th>Actualizado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($fechas as $date)
                    <tr>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($date->fecha) }}</td>
                        <td>{{ $date->hora }}</td>
                        <td>{!! \App\Http\Controllers\SystemController::getPublishButton($date->publicado) !!}</td>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmdHis($date->created_at) }}</td>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmdHis($date->updated_at) }}</td>
                        <td>
                            <div class="btn-group btn-block">
                                <button class="btn btn-info">xx</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Crear fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('competencias.forms.crearFecha')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('js.datatable')
    @if(session('success') || session('error'))
        @include('js.toastr')
    @endif
@endsection
