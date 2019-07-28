<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLimits extends Model
{
    protected $fillable = ['count', 'limit'];
}
