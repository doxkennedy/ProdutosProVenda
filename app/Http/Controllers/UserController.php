<?php

namespace App\Http\Controllers;

use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public static function CreateUser(){

            return view('usuario.cadastrousuario');

    }

    public static function VerificarEmail($valor){

        $query = User::where('email',$valor)->first();
        return response()->json($query);

    }


    public static function NewUser(Request $request){

        $user  = new User();
        $user->name  = $request->nome;
        $user->email  = $request->email;
        $user->password = Hash::make($request->senha);
        $user->cep  = $request->cep;
        $user->numero  = $request->numero;
        $user->created_at = date('Y-m-d H:m:i' );
        $user->updated_at = date('Y-m-d H:m:i' );
        $user->save();


        return redirect('/home');

    }


}
