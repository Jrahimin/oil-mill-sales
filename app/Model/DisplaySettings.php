<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DisplaySettings extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['company_logo', 'company_name'];

}
