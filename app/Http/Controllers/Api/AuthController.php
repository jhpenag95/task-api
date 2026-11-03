<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash; //Aqui se importa la clase Hash para poder encriptar la contraseña del usuario antes de guardarla en la base de datos.
use Illuminate\Support\Facades\Auth; //Aqui se importa la clase Auth para poder autenticar al usuario despues de registrarlo y generar un token de acceso para la API.

class AuthController extends Controller
{
    //Funcion para registrar un nuevo usuario en la base de datos y generar un token de acceso para la API.
    public function register(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar un token de acceso para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolver la respuesta con el token y los datos del usuario
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    //Funcion para autenticar a un usuario existente y generar un token de acceso para la API.
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (!Auth::attempt($request->only('email', 'password'))) {

            return response()->json([
                'mensaje' => 'Credenciales incorrectas'
            ], 401);
        }

        // Obtener el usuario autenticado
        $user = User::where(
            'email',
            $request->email
        )->first();

        // Generar un token de acceso para el usuario
        $token = $user->createToken(
            'api-token'
        )->plainTextToken;

        // Devolver la respuesta con el token y los datos del usuario
        return response()->json([
            'usuario' => $user,
            'token' => $token
        ]);
    }

    //Funcion para obtener los datos del usuario autenticado mediante el token de acceso.
    public function me(Request $request)
    {
        return response()->json(
            $request->user()
        );
    }

    //otra prueba de obtener los datos del usuario autenticado mediante el token de acceso.
    // public function me(Request $request)
    // {
    //     return response()->json([
    //         'user' => $request->user(),
    //         'auth_header' => $request->header('Authorization'),
    //     ]);
    // }
}
