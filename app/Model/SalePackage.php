<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SalePackage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
