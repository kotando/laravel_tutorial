<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = [
        "user_id",
    ];
}
