<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model{

    public $table = 'business';
    
    public $fillable = [
        'name',
        'description',
        'lat',
        'long'
    ];
}
