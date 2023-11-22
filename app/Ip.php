<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $table = 'ips_allowed';
    protected $fillable = ['ip'];
}
