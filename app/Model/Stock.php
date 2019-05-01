<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
