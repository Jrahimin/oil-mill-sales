<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemUnit extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['name'];

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }
}
