<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs=$request->input();
        $inputs["password"] = Hash::make(trim($request->password9));
        $respuesta= User::create($inputs);
        return response()->json([
            'message' => 'Registrado con exito',
            'data' => $respuesta,
        ], 201);
         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = User::find($id);

        if(isset($libro)){
            return response()->json([
                'mensaje' => 'Encontrado con exito ',
                'data' => $libro
            ], 200);
        }else{
            return response()->json([
                'error'=>true,
                'mensaje' => 'No existe',
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $libro = User::find($id);

        if ($libro) {
        $libro->name = $request->name;
        $libro->email = $request->email;
        $libro->password = Hash::make( $request->password);
        $libro->save();

        return response()->json([
            'mensaje' => 'Actualizado correctamente.',
            'data' => $libro
        ], 200);
    }

     return response()->json([
        'mensaje' => 'No existe.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = User::find($id);

        if(isset($libro)){
            $resp=User::destroy($id);
            if($resp){
                return response()->json([
                    'mensaje' => 'Eliminado con exito',
                    'data' => $libro
                ]);
            }else{
                return response()->json([
                    'data' => $libro,
                    'error'=>true,
                    'mensaje' => 'No existe',
                    ]);
            }
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje' => 'No existe ',
                ]);
        }
    }
}
