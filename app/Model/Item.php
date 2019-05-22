<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['title', 'model', 'company', 'category_id', 'user_id', 'serial_no'];

    public function category(){
        return $this->belongsTo(ItemCategory::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
