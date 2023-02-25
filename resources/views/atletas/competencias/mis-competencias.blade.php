@extends('adminlte::page')

@section('title', 'Mis competencias')

@section('content')
    <br>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Buscador de competencias</label>
                <select id="buscadorCompetencia" class="form-control">
                    <option>Selecciona una competencia para registrarte en ella....</option>
                    @foreach($competenciasDisponibles as $cd)
                        <option value="{{ \Vinkla\Hashids\Facades\Hashids::encode($cd->id) }}">{{ $cd->nombre_competencia }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <hr>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Competencia</th>
                <th>Categoria</th>
                <th>Equipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($competenciasRegistradas as $cr)
                <tr>
                    <td>{{ $cr->competencia->nombre_competencia }}</td>
                    <td>{{ $cr->categoriaCompetencia->nombre_categoria }}</td>
                    <td>{{ \App\Http\Controllers\TeamsDetailController::getTeamName($cr->id_equipo) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('js')
    @include('js.datatable')
    <script>
        $('#buscadorCompetencia').select2();
        $('#buscadorCompetencia').on('change', function () {
            let value = $(this).val();
            window.location.href = '{{secure_url('/')}}/atletas/inscribir/'+value;
        })
    </script>
@endsection
