@extends('adminlte::page')

@section('title', 'Fechas')

@section('content')
    <br>
    @if($competencia->pagado === 0)
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            Esta competencia no se encuentra pagada aun en nuestro sistema, por lo que <strong>no se encuentra publicada para la inscripción de atletas y equipos</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Fechas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Categorías</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    @include('competencias.fechas')
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    @include('competencias.categorias')
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    @include('js.datatable')
    @include('js.datatableCategoria')
    @include('js.publishSwitcher')
    @if(session('success') || session('error'))
        @include('js.toastr')
    @endif

    <script>
        $(document).ready(function(){
            $('#description').summernote({
                placeholder: 'Ingresa la descripción de la fecha',
                height:200
            });
        })
    </script>
@endsection
