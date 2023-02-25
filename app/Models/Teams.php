<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_competencia',
        'id_usuario',
        'id_categoria',
        'status_pago',
        'fecha_inscripcion',
        'fecha_pago',
        'medio_pago',
        'payment_data',
        'updated_at',
        'monto_pagado',
        'moneda_pago',
        'team_name'
    ];
}
