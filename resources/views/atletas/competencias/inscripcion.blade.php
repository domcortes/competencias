@extends('adminlte::page')

@section('title', 'Inscripción competencia')

@section('content')
    <br>
    <div class="card">
        <div class="card-header bg-dark">
            <span class="card-title">Detalles de inscripcion</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <table class="table">
                        <tr>
                            <th>Nombre competencia</th>
                            <td>{{ $competencia->nombre_competencia }}</td>
                        </tr>
                        <tr>
                            <th>Inicio competencia</th>
                            <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($competencia->fecha_inicio) }}</td>
                        </tr>
                        <tr>
                            <th>Término competencia</th>
                            <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($competencia->fecha_termino) }}</td>
                        </tr>
                        <tr>
                            <th>Inicio Inscripciones</th>
                            <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($competencia->inicio_inscripciones) }}</td>
                        </tr>
                        <tr>
                            <th>Término inscripciones</th>
                            <td>{{ \App\Http\Controllers\SystemController::dateFromYmd($competencia->termino_inscripciones) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <label for="">Categoria</label>
                        <select name="categoria" id="categoria" class="form-control" nombre_competencia="{{ $competencia->nombre_competencia }}" identification="{{ \Vinkla\Hashids\Facades\Hashids::encode($competencia->id) }}">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $cat)
                                <option value="{{ \Vinkla\Hashids\Facades\Hashids::encode($cat->id) }}">{{ $cat->nombre_categoria }} - {{ $cat->cantidad_participantes }} atleta(s) por equipo</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Nombre Equipo</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" placeholder="Nombre Equipo" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group float-right">
                <div class="cho-container" id="cho-container"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('js.mercadopago');
@endsection
