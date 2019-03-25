<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class UsuarioModel extends Model  implements JWTSubject
{
    //use Notifiable;

    protected $table = 'USUARIOS';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'CH_ID_USUARIO';

    protected $fillable = [
        'VC_PASSWORD','VC_NOMBRE','VC_APELLIDO_PAT','VC_APELLIDO_MAT',
        'VC_DIRECCION','VC_DNI','VC_FOTO'
    ];

    public function getJWTIdentifier()
    {
        return $this->getkey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
}
