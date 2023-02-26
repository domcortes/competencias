<?php

namespace App\Http\Controllers;

use App\Models\CategoriasCompetencia;
use App\Models\Competencias;
use App\Models\Teams;
use App\Models\TeamsDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Vinkla\Hashids\Facades\Hashids;

class PagosController extends Controller
{
    public function MercadoPagoPayment($idCompetencia, $idAtleta, $idCategoria, $result){
        $paymentType = 'MercadoPago';
        $collection_id = $_GET['collection_id'];
        $collection_status = $_GET['collection_status'];
        $payment_id = $_GET['payment_id'];
        $status = $_GET['status'];
        $external_reference = $_GET['external_reference'];
        $payment_type = $_GET['payment_type'];
        $merchant_order_id = $_GET['merchant_order_id'];
        $preference_id = $_GET['preference_id'];
        $site_id = $_GET['site_id'];
        $processing_mode = $_GET['processing_mode'];
        $merchant_account_id = $_GET['merchant_account_id'];

        $competencia = Competencias::where('id', Hashids::decode($idCompetencia)[0])->first();
        $atleta = User::where('id', Hashids::decode($idAtleta)[0])->first();
        $categoria = CategoriasCompetencia::where('id', Hashids::decode($idCategoria)[0])->first();
        $organizador = User::find($competencia->created_by);

        ($categoria->cantidad_participantes > 1) ? $successMessage = 'Equipo registrado exitosamente': $successMessage = 'Atleta registrado exitosamente';
        ($categoria->cantidad_participantes > 1) ? $failedMessage = 'El equipo no pudo ser registrado en esta competencia': $failedMessage = 'El atleta no pudo ser registrado en esta competencia';
        ($categoria->cantidad_participantes > 1) ? $pendingMessage = 'Se registro el equipo en la competencia, pero tiene pago pendiente': $pendingMessage = 'Se registró correctamente al atleta, pero tiene pago pendiente';

        $dataPayment = [
            'collection_id' => $collection_id,
            'collection_status' => $collection_status,
            'payment_id' => $payment_id,
            'status'=> $status,
            'external_reference '=> $external_reference,
            'payment_type' => $payment_type,
            'merchant_order_id' => $merchant_order_id,
            'preference_id' => $preference_id,
            'site_id' => $site_id,
            'processing_mode' => $processing_mode,
            'merchant_account_id' => $merchant_account_id,
        ];

        $inscripcion = Teams::where('payment_data', json_encode($dataPayment))->first();

        $inscriptionNumber = $dataPayment['collection_id'];

        if($inscripcion !== null){
            $message = 'Ya te encuentras registrado para la competencia <strong>'.$competencia->nombre_competencia.'</strong>';
            $statusPago = (boolean) $inscripcion->status_pago;
            $alertClass = 'alert-info';

            return view('pagos.mp',
                compact(
                    'competencia',
                    'atleta',
                    'categoria',
                    'message',
                    'alertClass',
                    'dataPayment',
                    'inscripcion',
                    'organizador',
                    'statusPago',
                    'inscriptionNumber',
                    'paymentType'
                )
            );
            return redirect()->back()->with('info', 'Este equipo ya se encuentra registrado');
        }

        switch ($result){
            case 'true';
                $inscripcion = Teams::create([
                    'id_competencia' => $competencia->id,
                    'id_usuario' => $atleta->id,
                    'id_categoria' => $categoria->id,
                    'status_pago' => true,
                    'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
                    'fecha_pago' => Carbon::now()->format('Y-m-d'),
                    'medio_pago' => $paymentType,
                    'payment_data' => json_encode($dataPayment),
                    'updated_at' => Carbon::now()->format('Y-m-d'),
                    'monto_pagado' => $categoria->valor_inscripcion,
                    'moneda_pago' => $categoria->moneda,
                    'team_name' => session('team_name')
                ]);

                TeamsDetail::create([
                    'id_usuario' => $atleta->id,
                    'id_equipo' => $inscripcion->id,
                    'id_competencia' => $competencia->id,
                    'id_categoria' => $categoria->id
                ]);

                $message = $successMessage;
                $statusPago = true;
                $alertClass = 'alert-success';
                break;

            case 'false';
                $message = $failedMessage;
                $statusPago = false;
                $alertClass = 'alert-danger';
                break;

            case 'pending';
                $inscripcion = Teams::create([
                    'id_competencia' => $competencia->id,
                    'id_usuario' => $atleta->id,
                    'id_categoria' => $categoria->id,
                    'status_pago' => false,
                    'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
                    'updated_at' => Carbon::now()->format('Y-m-d'),
                    'team_name' => session('team_name')
                ]);
                $message = $pendingMessage;
                $statusPago = false;
                $alertClass = 'alert-info';
                break;
        }

        session()->forget('team_name');

        return view('pagos.mp',
            compact(
                'competencia',
                'atleta',
                'categoria',
                'message',
                'alertClass',
                'dataPayment',
                'inscripcion',
                'organizador',
                'statusPago',
                'inscriptionNumber',
                'paymentType'
            )
        );
    }

    public function PaypalPayment(Request $request, $idCompetencia, $idAtleta, $idCategoria){
        $paymentType = 'Paypal';
        $competencia = Competencias::where('id', Hashids::decode($idCompetencia)[0])->first();
        $atleta = User::where('id', Hashids::decode($idAtleta)[0])->first();
        $categoria = CategoriasCompetencia::where('id', Hashids::decode($idCategoria)[0])->first();
        $organizador = User::find($competencia->created_by);

        ($categoria->cantidad_participantes > 1) ? $successMessage = 'Equipo registrado exitosamente': $successMessage = 'Atleta registrado exitosamente';
        ($categoria->cantidad_participantes > 1) ? $failedMessage = 'El equipo no pudo ser registrado en esta competencia': $failedMessage = 'El atleta no pudo ser registrado en esta competencia';
        ($categoria->cantidad_participantes > 1) ? $pendingMessage = 'Se registro el equipo en la competencia, pero tiene pago pendiente': $pendingMessage = 'Se registró correctamente al atleta, pero tiene pago pendiente';

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_KEY'),
                env('PAYPAL_TOKEN')
            )
        );

        $paymentId = $request->input('paymentId');
        $payerID = $request->input('PayerID');
        $token = $request->input('token');

        if(!$paymentId || !$payerID || !$token){
            return 'error';
        }

        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);

        $dataPayment = $payment->execute($execution, $apiContext);

        $inscriptionNumber = $dataPayment->id;

        $inscripcion = Teams::where('payment_data', $dataPayment->toJSON())->first();

        if($inscripcion !== null){
            $message = 'Ya te encuentras registrado para la competencia <strong>'.$competencia->nombre_competencia.'</strong>';
            $statusPago = (boolean) $inscripcion->status_pago;
            $alertClass = 'alert-info';

            return view('pagos.mp',
                compact(
                    'competencia',
                    'atleta',
                    'categoria',
                    'message',
                    'alertClass',
                    'dataPayment',
                    'inscripcion',
                    'organizador',
                    'statusPago',
                    'inscriptionNumber',
                    'paymentType'
                )
            );
            return redirect()->back()->with('info', 'Este equipo ya se encuentra registrado');
        }

        switch ($dataPayment->getState()){
            case 'approved';
                $inscripcion = Teams::create([
                    'id_competencia' => $competencia->id,
                    'id_usuario' => $atleta->id,
                    'id_categoria' => $categoria->id,
                    'status_pago' => true,
                    'fecha_inscripcion' => Carbon::now()->format('Y-m-d'),
                    'fecha_pago' => Carbon::now()->format('Y-m-d'),
                    'medio_pago' => $paymentType,
                    'payment_data' => $dataPayment->toJSON(),
                    'updated_at' => Carbon::now()->format('Y-m-d'),
                    'monto_pagado' => $categoria->valor_inscripcion,
                    'moneda_pago' => $categoria->moneda,
                    'team_name' => session('team_name')
                ]);

                TeamsDetail::create([
                    'id_usuario' => $atleta->id,
                    'id_equipo' => $inscripcion->id,
                    'id_competencia' => $competencia->id,
                    'id_categoria' => $categoria->id
                ]);

                $message = $successMessage;
                $statusPago = true;
                $alertClass = 'alert-success';
                break;

        }

        session()->forget('team_name');

        return view('pagos.mp',
            compact(
                'competencia',
                'atleta',
                'categoria',
                'message',
                'alertClass',
                'dataPayment',
                'inscripcion',
                'organizador',
                'statusPago',
                'inscriptionNumber',
                'paymentType'
            )
        );
    }
}
