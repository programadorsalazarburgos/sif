<?php

namespace App\Models\crea\territorial;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_estudiante';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        "IN_Identificacion",
        "CH_Tipo_Identificacion",
        "VC_Primer_Nombre",
        "VC_Segundo_Nombre",
        "VC_Primer_Apellido",
        "VC_Segundo_Apellido",
        "DD_F_Nacimiento",
        "CH_Genero",
        "VC_Direccion",
        "VC_Correo",
        "VC_Telefono",
        "VC_Celular",
        "VC_Tipo_Estudiante",
        "DA_Fecha_Registro",
        "FK_RH",
        "Id_Usuario_Registro",
        "nacionalidad",
        "attr",
        "IN_Acepta_Uso_Imagen"
    ];
}
