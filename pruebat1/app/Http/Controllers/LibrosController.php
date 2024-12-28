<?php

namespace App\Http\Controllers;

use App\Models\Libros;
use Illuminate\Http\Request;

class LibrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Libros::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
    
        // Validaciones personalizadas para cada campo
        $errors = [];
    
        if (!isset($data['title']) || empty($data['title'])) {
            $errors['title'] = 'El título es obligatorio.';
        }
    
        if (!isset($data['author']) || empty($data['author'])) {
            $errors['author'] = 'El autor es obligatorio.';
        }
    
        if (!isset($data['publication_year']) || !is_numeric($data['publication_year']) || $data['publication_year'] < 999 || $data['publication_year'] > 5155) {
            $errors['publication_year'] = 'El año de publicación debe ser un número entre 1901 y 2155.';
        }
    
        if (!isset($data['genre']) || empty($data['genre'])) {
            $errors['genre'] = 'El género del libro es obligatorio.';
        }
    
        // Si hay errores, devolverlos en el formato correcto
        if (count($errors) > 0) {
            return response()->json($errors, 422); // Devolver los errores con código 422
        }
    
        // Crear el libro si no hay errores
        $book = Libros::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'publication_year' => $data['publication_year'],
            'genre' => $data['genre'],
        ]);
    
        return response()->json([
            'message' => 'Libro creado exitosamente',
            'data' => $book,
        ], 201);
    }
    
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = Libros::find($id);

        if(isset($libro)){
            return response()->json([
                'mensaje' => 'Libro encontrado con exito ',
                'data' => $libro
            ], 200);
        }else{
            return response()->json([
                'error'=>true,
                'mensaje' => 'No existe el libro',
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     $libro = Libros::find($id);

        if ($libro) {
        $libro->title = $request->title;
        $libro->author = $request->author;
        $libro->publication_year = $request->publication_year;
        $libro->genre = $request->genre;
        $libro->save();

        return response()->json([
            'mensaje' => 'Libro actualizado correctamente.',
            'data' => $libro
        ], 200);
    }

     return response()->json([
        'mensaje' => 'No existe el libro con el ID proporcionado.',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = Libros::find($id);

        if(isset($libro)){
            $resp=Libros::destroy($id);
            if($resp){
                return response()->json([
                    'mensaje' => 'Libro eliminado con exito',
                    'data' => $libro
                ]);
            }else{
                return response()->json([
                    'data' => $libro,
                    'error'=>true,
                    'mensaje' => 'Libro no existe',
                    ]);
            }
           
        }else{
            return response()->json([
                'error'=>true,
                'mensaje' => 'No existe el libro',
                ]);
        }
    }
}