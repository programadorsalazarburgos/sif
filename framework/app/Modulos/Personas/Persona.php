<?php

namespace App\Modulos\Personas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modulos\Personas\AccesoUsuario;
use App\Modulos\Personas\TerritorioNidos;
use App\Modulos\Personas\PersonaTerritorioNidos;
use App\Modulos\Personas\PersonaDataExtra;

class Persona extends Model
{
    //use SoftDeletes;
    protected $table = 'tb_persona_2017';
    protected $primaryKey= 'PK_Id_Persona';
    //protected $dates = ['deleted_at'];
    protected $fillable = [
        'VC_Identificacion',
        'FK_Tipo_Identificacion',
        'VC_Primer_Nombre',
        'VC_Segundo_Nombre',
        'VC_Primer_Apellido',
        'VC_Segundo_Apellido',
        'VC_Cargo',
        'DD_F_Nacimiento',
        'FK_Id_Genero',
        'VC_Grupo_Poblacional',
        'VC_NEE',
        'VC_Tipo_Afiliacion',
        'FK_Id_Eps',
        'FK_Grupo_Sanguineo',
        'VC_Enfermedades',
        'FK_Id_Localidad',
        'VC_Barrio',
        'VC_Direccion',
        'VC_Correo',
        'VC_Telefono',
        'VC_Celular',
        'FK_Tipo_Persona',
        'DA_Fecha_Registro',
        'Id_Usuario_Registro'
    ];
    public $timestamps = false;
    protected $appends = ['full_name'];

    public function tipoPersonaDetalles()
    {
        //return $this->hasMany(ConceptosFacturas::class, 'i_fk_id_concepto', 'i_pk_id');
    }

    public function getFullNameAttribute()
    {
        return trim($this->VC_Primer_Nombre) . ' ' . trim($this->VC_Segundo_Nombre) . ' ' . trim($this->VC_Primer_Apellido). ' ' . trim($this->VC_Segundo_Apellido);
    }

    public function acceso(){
        return $this->hasOne(AccesoUsuario::class, 'FK_Id_Persona', 'PK_Id_Persona');
    }
    
    public function territorioNidos(){
        return $this->belongsToMany(TerritorioNidos::class, 'tb_nidos_persona_territorio', 'Fk_Id_Persona', 'Fk_Id_Territorio');
    }

    public function dataExtra(){
        return $this->hasOne(PersonaDataExtra::class, 'FK_Id_Persona','PK_Id_Persona');
    }
}