<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json(['status' => true, 'data' => $users]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreUsuarioRequest $request)
    {
        try {
            
            $obj = new User();

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            $user = $obj->create($input);

            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['nome'] =  $user->nome;


            return [
                "status" => true,
                'data' => $success
            ];

        } catch (Exception $e){

            return [
                "status" => false,
                "error" => $e->getMessage(),
            ];

        }
    }

    public function show(User $usuario)
    {
        try {

            return [
                "status" => true,
                "data" => $usuario
            ];

        } catch (Exception $e){

            return [
                "status" => false,
                "error" => $e->getMessage(),
            ];

        }
    }

    public function update(UpdateUsuarioRequest $request, $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $usuario->update($request->all());
    
            return [
                "status" => true,
                "data" => $usuario
            ];
    
        } catch (Exception $e){
    
            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
            
        }
    }

    public function destroy(User $usuario)
    {
        try {
            $usuario->delete();
    
            return response(null, 204);
    
        } catch (Exception $e) {
            return [
                "status" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
