<?php

namespace Ridwanhoq\SimpleBlog\Models;

use Illuminate\Database\Eloquent\Model;

class SbCategory extends Model{

    protected $guarded = ['id'];

public function posts(){
    return $this->hasMany(SbPost::class);
}

public function scopeActive($query){
    return $query->where('is_active', true);
}

public function scopeInactive($query){
    return $query->where('is_active', false);
}


}