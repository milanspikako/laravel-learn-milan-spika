<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    public function scopeNotdeleted($query){
        return $query->where('deleted', 0);
    }

    public function scopeTopLevel($query){
        return $query->where('page_id', 0);
    }
    public function scopeCustomLevel($query, $id){
        return $query->where('page_id', $id);
    }
    public function scopeNotThisId($query, $id){
        return $query->where('id','!=', $id);
    }

}
