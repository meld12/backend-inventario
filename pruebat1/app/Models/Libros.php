<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libros extends Model
{
    use HasFactory;
    public $table = "libros"; 

   
    protected $fillable = [
        'title',
        'author',
        'publication_year',
        'genre',
        'id'

    ];
  
}
