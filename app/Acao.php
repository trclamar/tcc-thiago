<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acao extends Model
{
    protected $table = 'acoes';
    protected $fillable = [
        'servidor_id', 'vm_id', 'hash_server', 'ip_server', 'hash_vm', 'acao', 'resultado', 'status'
    ];
}
