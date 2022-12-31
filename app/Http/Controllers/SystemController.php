<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    static public function getStatusButton($status)
    {
        switch ($status){
            case true:
                return '<button class="btn btn-success">Activo</button>';
                break;
            case false:
                return '<button class="btn btn-danger">Inactivo</button>';
                break;
        }
    }

    static public function getPublishButton($status)
    {
        switch ($status){
            case true:
                return '<button class="btn btn-success">Publicado</button>';
                break;
            case false:
                return '<button class="btn btn-danger">No publicado</button>';
                break;
        }
    }

    static public function dateFromYmd($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }

    static public function dateFromYmdHis($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y - H:i:s');
    }
}
