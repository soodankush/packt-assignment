<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'author',
        'genre',
        'description',
        'isbn',
        'image',
        'published_at',
        'publisher',
        'created_by',
        'updated_by'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
