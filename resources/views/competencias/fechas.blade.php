<div class="card">
    <div class="card-header bg-gradient-dark">
        <div class="row">
            <div class="col"><span class="card-title">Listado fechas competencia</span> - <small>(Fechas creadas: <strong>{{ \App\Http\Controllers\FechasCompetenciasController::contadorFechas($competenciaId)}}</strong>)</small></div>
            <div class="col">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalFecha">
                    Crear fecha
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="table_id" class="display">
            <thead>
            <tr>
                <th class="text-center">Fecha</th>
                <th class="text-center">Hora</th>
                <th class="text-center">Modalidad</th>
                <th class="text-center">Descripcion</th>
                <th class="text-center">Publicado</th>
                <th class="text-center">Creado</th>
                <th class="text-center">Actualizado</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($fechas as $date)
                <tr>
                    <td class="text-center">{{ \App\Http\Controllers\SystemController::dateFromYmd($date->fecha) }}</td>
                    <td class="text-center">{{ $date->hora }}</td>
                    <td class="text-center">{{ ucfirst($date->modalidad) }}</td>
                    <td class="text-center">{{ $date->descripcion }}</td>
                    <td class="text-center">{!! \App\Http\Controllers\SystemController::getPublishButton($date->publicado,'fechas', \Vinkla\Hashids\Facades\Hashids::encode($date->id)) !!}</td>
                    <td class="text-center">{{ \App\Http\Controllers\SystemController::dateFromYmdHis($date->created_at) }}</td>
                    <td class="text-center">{{ \App\Http\Controllers\SystemController::dateFromYmdHis($date->updated_at) }}</td>
                    <td>
                        <div class="btn-group btn-block">
                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalFecha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
