<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['sale_package_id', 'item_id', 'stock_id', 'quantity', 'no_of_jar', 'no_of_drum', 'unit_price', 'total_price'];

    public function salePackage(){
        return $this->belongsTo(SalePackage::class);
    }
}
