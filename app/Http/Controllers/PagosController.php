<?php

namespace App\Http\Controllers;

use App\Models\CategoriasCompetencia;
use App\Models\Competencias;
use App\Models\Teams;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    public function MercadoPagoPayment($idCompetencia, $idAtleta, $idCategoria, $result){
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

        $competencia = Competencias::where('id', $idCompetencia)->first();
        $atleta = User::where('id', $idAtleta)->first();
        $categoria = CategoriasCompetencia::where('id', $idCategoria)->first();

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

        if($inscripcion !== null){
            $message = 'Ya te encuentras registrado para la competencia <strong>'.$competencia->nombre_competencia.'</strong>';
            $alertClass = 'alert-info';

            return view('pagos.mp',
                compact(
                    'competencia',
                    'atleta',
                    'categoria',
                    'message',
                    'alertClass',
                    'dataPayment',
                    'inscripcion'
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
                    'medio_pago' => 'MercadoPago',
                    'payment_data' => json_encode($dataPayment),
                    'updated_at' => Carbon::now()->format('Y-m-d'),
                    'monto_pagado' => $categoria->valor_inscripcion,
                    'moneda_pago' => $categoria->moneda,
                ]);

                $message = $successMessage;
                $alertClass = 'alert-success';
                break;

            case 'false';
                $message = $failedMessage;
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
                ]);
                $message = $pendingMessage;
                $alertClass = 'alert-info';
                break;
        }

        return view('pagos.mp',
            compact(
                'competencia',
                'atleta',
                'categoria',
                'message',
                'alertClass',
                'dataPayment',
                'inscripcion'
            )
        );
    }
}
