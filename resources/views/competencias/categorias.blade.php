<div class="card">
    <div class="card-header bg-gradient-dark">
        <div class="row">
            <div class="col"><span class="card-title">Listado categorias</span></div>
            <div class="col">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalCategoria">
                    Crear categoría
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="table_categoria" class="display">
            <thead>
            <tr class="text-center">
                <th class="text-center">Nombre Categoria</th>
                <th class="text-center">Publicado</th>
                <th class="text-center">Creado</th>
                <th class="text-center">Actualizado</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categorias as $cat)
                <tr>
                    <td class="text-center">{{ $cat->nombre_categoria }}</td>
                    <td class="text-center">{!! \App\Http\Controllers\SystemController::getPublishButton($cat->publicado,'categorias',\Vinkla\Hashids\Facades\Hashids::encode($cat->id)) !!}</td>
                    <td class="text-center">{{ \App\Http\Controllers\SystemController::dateFromYmdHis($cat->created_at) }}</td>
                    <td class="text-center">{{ \App\Http\Controllers\SystemController::dateFromYmdHis($cat->updated_at) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title" id="exampleModalLabel">Crear categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('competencias.forms.crearCategoria')
            </div>
        </div>
    </div>
</div>
