<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $fillable = [
        'hash_server', 'hash_vm', 'filedata', 'status'
    ];   
}
