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
                    <small class="float-right">Date: 2/10/2014</small>
                </h4>
            </div>

        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                @if($categoria->cantidad_participantes > 1)
                    Equipo
                @else
                    Atleta
                @endif
                Inscrito:
                <address>
                    <strong>{{ $atleta->name }}</strong><br>
                    Email: {{ $atleta->email }}<br>
                    @if($inscripcion->status_pago === 1)
                        <span class="badge badge-success">Inscripcion pagada</span>
                    @else
                        <span class="badge badge-danger">Inscripción pendiente de pago</span>
                    @endif
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> 4F3S8J<br>
                <b>Payment Due:</b> 2/22/2014<br>
                <b>Account:</b> 968-34567
            </div>

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
                            <td>{{ $categoria->nombre_categoria }} - <small>Hasta {{ $categoria->cantidad_participantes }} atleta(s) por inscripción</small></td>
                            <td>${{ number_format($inscripcion->monto_pagado,2,',','.') }} {{ $inscripcion->moneda_pago }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <div class="row">

            <div class="col-6">
                <p class="lead">Método de pago: <strong>{{ $inscripcion->medio_pago }}</strong></p>
            </div>

            <div class="col-6">
                <p class="lead text-center">Fecha de Pago <strong>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $inscripcion->fecha_pago)->format('d-m-Y') }}</strong></p>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Total:</th>
                                <td>${{ number_format($inscripcion->monto_pagado,2,',','.') }} {{ $inscripcion->moneda_pago }}</td>
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
