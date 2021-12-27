<?php

namespace App\Modulos\Personas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonaDataExtra extends Model
{

    protected $table = 'tb_persona_extra_data';
    protected $primaryKey= 'PK_Id_Tabla';

    protected $fillable = [
        'FK_Id_Persona',
        'TX_Foto_Perfil',
        'TX_Firma_Escaneada',
    ];    
}