<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['sale_package_id', 'item_id', 'stock_id', 'quantity', 'item_unit_id', 'no_of_jar', 'no_of_drum',
        'no_of_jar_return', 'no_of_drum_return', 'unit_price', 'total_price'];

    public function salePackage(){
        return $this->belongsTo(SalePackage::class);
    }

    public function item_unit(){
        return $this->belongsTo(ItemUnit::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
