<?php

namespace Tests\Feature;

use App\Models\Libros;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateBookWithoutRequiredFields()
    {
        $response = $this->postJson('/api/v1/libros', []);

        $response->assertStatus(422);

        $response->assertJson([
            'title' => 'El título es obligatorio.',
            'author' => 'El autor es obligatorio.',
            'publication_year' => 'El año de publicación debe ser un número entre 1901 y 2155.',
            'genre' => 'El género del libro es obligatorio.',
        ]);
    }

    public function testCreateBookWithValidData()
    {
        $data = [
            'title' => 'Nuevo libro',
            'author' => 'Autor Prueba',
            'publication_year' => 2024,
            'genre' => 'Ficción',
        ];

        $response = $this->postJson('/api/v1/libros', $data);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'Libro creado exitosamente',
            'data' => [
                'title' => 'Nuevo libro',
                'author' => 'Autor Prueba',
                'publication_year' => 2024,
                'genre' => 'Ficción',
            ]
        ]);
    }

    public function testShowBookById()
    {
        $book = Libros::factory()->create();

        $response = $this->getJson('/api/v1/libros/' . $book->id);

        $response->assertStatus(200);

        $response->assertJson([
            'mensaje' => 'Libro encontrado con exito ',
            'data' => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'publication_year' => $book->publication_year,
                'genre' => $book->genre,
            ]
        ]);
    }

    public function testUpdateBook()
    {
        $book = Libros::factory()->create();

        $data = [
            'title' => 'Nuevo título actualizado',
            'author' => 'Autor actualizado',
            'publication_year' => 2025,
            'genre' => 'No ficción',
        ];

        $response = $this->putJson('/api/v1/libros/' . $book->id, $data);

        $response->assertStatus(200);

        $response->assertJson([
            'mensaje' => 'Libro actualizado correctamente.',
            'data' => [
                'id' => $book->id,
                'title' => 'Nuevo título actualizado',
                'author' => 'Autor actualizado',
                'publication_year' => 2025,
                'genre' => 'No ficción',
            ]
        ]);
    }

    public function testDeleteBook()
    {
        $book = Libros::factory()->create();

        $response = $this->deleteJson('/api/v1/libros/' . $book->id);

        $response->assertStatus(200);

        $response->assertJson([
            'mensaje' => 'Libro eliminado con exito',
            'data' => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'publication_year' => $book->publication_year,
                'genre' => $book->genre,
            ]
        ]);

        $this->assertDatabaseMissing('libros', [
            'id' => $book->id,
        ]);
    }
}

