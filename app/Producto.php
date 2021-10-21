<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Conner\Tagging\Taggable;

class Producto extends Model
{
    use Taggable;
    protected $table = 'productos';
    protected $primaryKey = 'id';
}
