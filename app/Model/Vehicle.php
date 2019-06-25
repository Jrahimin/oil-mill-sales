<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['title','serial_no'];

    public function salePacks(){
        return $this->hasMany(SalePackage::class);
    }
}
