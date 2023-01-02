<form action="{{ route('categorias.store') }}" method="post">
    @csrf
    <input type="hidden" name="competition" value="{{ $hash }}">
    <div class="row">
        <div class="col-7">
            <div class="form-group">
                <label for="">Nombre categoría</label>
                <input type="text" name="category" id="category" class="form-control" placeholder="Nombre de categoría">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label for="">Cant. Participantes</label>
                <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="btn-group float-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Crear categoria</button>
            </div>
        </div>
    </div>
</form>
