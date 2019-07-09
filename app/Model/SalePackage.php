<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SalePackage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['serial_no', 'user_id', 'customer_id', 'vehicle_id', 'route_id', 'journey_from', 'journey_to', 'total_price', 'paid', 'unpaid', 'status'];

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

    public function route(){
        return $this->belongsTo(Route::class);
    }
}
