<?php

namespace App\Modulos\Personas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccesoUsuario extends Model
{

    protected $table = 'tb_acceso_usuario_2017';
    protected $primaryKey= 'PK_Id_Acceso';

    protected $fillable = [
        'FK_Id_Persona',
        'VC_Usuario',
        'VC_Password',
        'IN_Estado',
        'IN_Acepta_Terminos',
        'DT_Acepta_Terminos',
        'VC_Token'
    ];    
}