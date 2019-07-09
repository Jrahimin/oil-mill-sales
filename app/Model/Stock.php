<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['item_id', 'user_id', 'quantity', 'item_unit_id', 'no_of_jar', 'no_of_drum',
                           'price', 'sale_price', 'status', 'stock_place', 'stock_date', 'sold'];

    protected $appends = ['stock_status', 'remaining'];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item_unit(){
        return $this->belongsTo(ItemUnit::class);
    }

    public function getStockStatusAttribute(){
        $status = $this->status ? 'Active' : 'Inactive';
        return $status;
    }

    public function getRemainingAttribute(){
        $remaining = $this->quantity - $this->sold;
        return "স্টকে আছে: {$remaining} {$this->item_unit->name}";
    }
}
