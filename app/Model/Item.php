<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function category(){
        return $this->belongsTo(ItemCategory::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
