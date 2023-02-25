@extends('adminlte::page')

@section('title','MercadoPago')

@section('content')
    <br>
    <div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col">
                <div class="text-center alert {{ $alertClass }}">{!! $message !!}</div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> Inscripción a {{ strtoupper($competencia->nombre_competencia) }}
                    <small class="float-right">Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</small>
                </h4>
            </div>

        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                Contacto Competencia:
                <address>
                    <strong>Nombre: </strong>{{ ucwords($organizador->name) }}<br>
                    <strong>Email: </strong><a href="mailto:{{ $organizador->email }}?subject=Inscripción%20{{$dataPayment['collection_id']}}%20">{{ $organizador->email }}</a>
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                @if($categoria->cantidad_participantes > 1)
                    Equipo
                @else
                    Atleta
                @endif
                @if(isset($inscripcion))
                    inscrito:
                @else
                    <strong>no </strong>inscrito:
                @endif
                <address>
                    <strong>{{ $atleta->name }}</strong><br>
                    Email: {{ $atleta->email }}<br>
                    @if($statusPago)
                        <span class="badge badge-success">Inscripcion pagada</span>
                    @else
                        <span class="badge badge-danger">Inscripción pendiente de pago</span>
                    @endif
                </address>
            </div>

            @isset($inscripcion)
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{ $dataPayment['collection_id'] }}</b><br>
                    <b>Tipo Pago: </b>{{ $dataPayment['payment_type'] }}<br>
                    <br>
                </div>
            @endisset
        </div>


        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Competencia</th>
                            <th>Modalidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $competencia->nombre_competencia }}</td>
                            <td>
                                {{ $categoria->nombre_categoria }} -
                                <small>Hasta {{ $categoria->cantidad_participantes }} atleta(s) por inscripción
                                    @if($dataPayment['status'] === 1)
                                        <a href="">Ver detalle de inscripción</a>
                                    @endif
                                </small>
                            </td>
                            <td>
                                @isset($inscripcion)
                                    ${{ number_format($inscripcion->monto_pagado,2,',','.') }} {{ $inscripcion->moneda_pago }}
                                @endisset
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">

            <div class="col-6">
                @isset($inscripcion)
                    <p class="lead">Método de pago: <strong>{{ $inscripcion->medio_pago }}</strong></p>
                @endisset
            </div>

            <div class="col-6">
                @isset($inscripcion)
                    <p class="lead text-center">Fecha de Pago <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $inscripcion->fecha_pago)->format('d-m-Y') }}</strong></p>
                @endisset
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Total:</th>
                                <td>
                                    @if(isset($inscripcion))
                                        $ {{ number_format($inscripcion->monto_pagado,2,',','.') }} {{ $inscripcion->moneda_pago }}
                                    @else
                                        $ 0.00
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <div class="row no-print">
            {{--<div class="col-12">
                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            </div>--}}
        </div>
    </div>
@endsection
