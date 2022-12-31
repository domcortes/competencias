@extends('adminlte::page')

@section('title', 'Competencias')

@section('content')
    <br>
    <div class="card">
        <div class="card-header bg-gradient-dark">
            <div class="row">
                <div class="col"><span class="card-title">Listado competencia</span></div>
                <div class="col">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                        Crear competencia
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="table_id" class="display">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Inicio</th>
                    <th>Término</th>
                    <th>Estado</th>
                    <th>Publicado</th>
                    <th>Creado por </th>
                    <th>Actualizado por</th>
                    <th>Creado el</th>
                    <th>Actualizado el</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competencias as $competencia)
                    <tr>
                        <td>{{ $competencia->nombre_competencia }}</td>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($competencia->fecha_inicio) }}</td>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($competencia->fecha_termino) }}</td>
                        <td>{!! \App\Http\Controllers\SystemController::getStatusButton($competencia->estado) !!}</td>
                        <td>{!! \App\Http\Controllers\SystemController::getPublishButton($competencia->publicado) !!}</td>
                        <td>{{ \App\Http\Controllers\UserController::getUserName($competencia->created_by) }}</td>
                        <td>{{ \App\Http\Controllers\UserController::getUserName($competencia->updated_by) }}</td>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmdHis($competencia->created_at) }}</td>
                        <td>{{ \App\Http\Controllers\SystemController::dateFromYmdHis($competencia->updated_at) }}</td>
                        <td>
                            <div class="btn-group btn-block">
                                <button class="btn btn-info">Pagar</button>
                                <a href="{{ route('competencias.show', \Vinkla\Hashids\Facades\Hashids::encode($competencia->id)) }}" class="btn btn-primary">Ver Competencia</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Crear competencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('competencias.forms.create')
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
