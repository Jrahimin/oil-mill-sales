<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function salePackage(){
        return $this->belongsTo(SalePackage::class);
    }
}
