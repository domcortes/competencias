<form action="{{ route('fechas.store') }}" method="post">
    @csrf
    <input type="hidden" name="competition" value="{{ $hash }}">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Fecha inicio</label>
                <input type="date" name="start" id="start" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Hora</label>
                <input type="time" name="time" id="time" class="form-control" placeholder="">
            </div>
        </div>
    </div>
    <div class="row col">
        <div class="col">
            <div class="form group">
                <label for="">Descripcion</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="btn-group float-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear fecha</button>
            </div>
        </div>
    </div>
</form>
