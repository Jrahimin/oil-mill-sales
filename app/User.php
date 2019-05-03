<?php

namespace App;

use App\Model\Item;
use App\Model\ItemCategory;
use App\Model\SalePackage;
use App\Model\Stock;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['created_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'mobile_no', 'address', 'type'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public function salePackages(){
        return $this->hasMany(SalePackage::class);
    }

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function itemCategory(){
        return $this->hasMany(ItemCategory::class);
    }

    protected function getcreatedDateAttribute(){
        return $this->created_at->format('Y-m-d');
    }
}
