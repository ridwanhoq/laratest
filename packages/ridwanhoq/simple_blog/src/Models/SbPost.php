<?php

namespace Ridwanhoq\SimpleBlog\Models;

use Illuminate\Database\Eloquent\Model;

class SbPost extends Model{
    protected $guarded = ['id'];

    public function category(){
        return $this->belongsTo(SbCategory::class);
    }
}