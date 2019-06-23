<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['journey_from', 'journey_to'];

    public function salePacks(){
        return $this->hasMany(SalePackage::class);
    }
}
