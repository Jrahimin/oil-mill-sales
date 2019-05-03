<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function items(){
        return $this->hasMany(Item::class,'category_id','id');
    }
}
