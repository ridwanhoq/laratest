<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel{

    protected $guarded = ['id'];

    public function scopeLast($query){
        return $query->orderByDesc('id')->first();
    }



}