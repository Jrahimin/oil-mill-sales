<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['item_id', 'user_id', 'no_of_items', 'price', 'status', 'stock_date'];
    protected $appends = ['stock_status'];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getStockStatusAttribute(){
        $status = $this->status ? 'Active' : 'Inactive';
        return $status;
    }
}