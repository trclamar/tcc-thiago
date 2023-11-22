<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vm extends Model
{
    protected $table = 'vms';
    protected $fillable = ['name', 'hash','description', 'servidor_id'];

    public function servidor() {
        return $this->belongsTo('App\Servidor');
    }

    public function usuarios() {
        return $this->belongsToMany("App\User", "vms_users");
    }

    public function acoes() {
        return $this->hasMany('App\Acao');
    }
}
