<form action="{{ route('competencias.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Nombre de competencia</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Fecha inicio</label>
                <input type="date" name="start" id="start" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Fecha Término</label>
                <input type="date" name="end" id="end" class="form-control" placeholder="">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="btn-group float-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear competencia</button>
            </div>
        </div>
    </div>
</form>
