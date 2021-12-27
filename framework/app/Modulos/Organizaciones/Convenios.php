<?php

namespace App\Modulos\Organizaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modulos\Organizaciones\InformeGestionV1;
use App\Modulos\Organizaciones\Organizacion;
use Carbon\Carbon;
use App\Modulos\Parametros\ParametroDetalles;
use App\Modulos\Personas\Persona;
class Convenios extends Model
{
    use SoftDeletes;
    protected $table = 'tb_convenios_organizaciones';
    protected $primaryKey= 'pk_id_tabla';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'fk_id_tipo_contrato',
        'vc_numero_contrato',
        'dt_acta_ini',
        'dt_term',
        'vc_areas',
        'vc_proyecto',
        'fk_id_organizacion',
        'vc_representante',
        'fk_id_supervisor',
        'fk_id_apoyo',
        'vc_objeto',
        'vc_email',
        'in_estado'

    ];
    public $timestamps = true;

    public function informesGestion()
    {
         return $this->hasMany(InformeGestionV1::class, 'fk_convenio', 'pk_id_tabla');
    }

    public function organizacion()
    {
         return $this->hasOne(Organizacion::class, 'PK_Id_Organizacion', 'fk_id_organizacion');
    }

    public function tipoContrato(){
        return $this->hasOne(ParametroDetalles::class, "PK_Id_Tabla", "fk_id_tipo_contrato");
    }

    public function supervisor(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "fk_id_supervisor");
    }

    public function apoyoSupervision(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "fk_id_supervisor");
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