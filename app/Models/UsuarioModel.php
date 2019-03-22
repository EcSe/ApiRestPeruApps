<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    protected $table = 'USUARIOS';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'CH_ID_USUARIO';

    protected $fillable = [
        'VC_PASSWORD','VC_NOMBRE','VC_APELLIDO_PAT','VC_APELLIDO_MAT',
        'VC_DIRECCION','VC_DNI','VC_FOTO'
    ];
}
