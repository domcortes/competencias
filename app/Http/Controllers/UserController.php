<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    static public function getUserName($id){
        $usuario = User::find($id);
        return (string) ucwords($usuario->name);
    }
}
