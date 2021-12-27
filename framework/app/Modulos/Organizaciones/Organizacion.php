<?php

namespace App\Modulos\Organizaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Modulos\Personas\Persona;

class Organizacion extends Model
{
    //use SoftDeletes;
    protected $table = 'tb_organizaciones_2017';
    protected $primaryKey= 'PK_Id_Organizacion';
    //protected $dates = ['deleted_at'];
    protected $fillable = [
        'VC_Nom_Organizacion',
        'FK_Id_Localidad',
        'VC_Telefono',
        'VC_Direccion_Organiz',
        'VC_Responsable_Organi',
        'VC_Estado_Organizacion',
        'Anio',
        'FK_Coordinador'
    ];
    public $timestamps = false;

    public function coordinador(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_Coordinador");
    }

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value)->setTimezone(config('app.timezone'));
        return $date->format('Y-m-d H:i');
    }
    
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value)->setTimezone(config('app.timezone'));
        return $date->format('Y-m-d H:i');
    }
    
}
