<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    protected $table = 'servidores';
    protected $fillable = ['name', 'hash', 'ip', 'description', 'local_id'];

    public function local() {
        return $this->belongsTo('App\Local');
    }

    public function vms() {
        return $this->hasMany('App\Vm');
    }
}
