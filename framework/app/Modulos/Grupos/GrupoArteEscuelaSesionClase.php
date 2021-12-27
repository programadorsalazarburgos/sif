<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Options;

class GrupoArteEscuelaSesionClase extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tb_terr_grupo_arte_escuela_sesion_clase';
    protected $primaryKey= 'PK_sesion_clase';
    protected $fillable = [
        'FK_grupo', 
        'DA_fecha_clase', 
        'DT_fecha_creacion_registro', 
        'IN_horas_clase', 
        'FK_usuario', 
        'FK_organizacion', 
        'TX_observaciones', 
        'suplencia', 
        'FK_clan', 
        'VC_Nom_Clan', 
        'FK_colegio', 
        'VC_Nom_Colegio', 
        'FK_area_artistica', 
        'IN_lugar_atencion', 
        'IN_Modalidad_Atencion', 
        'IN_Tipo_Atencion', 
        'IN_Material',
        'tipo_grupo',
        'hora_inicio',
        'hora_fin',
        'FK_salon',
        'VC_anexo'
    ];
    public $timestamps = false;

    public function areaArtistica(){
    	return $this->hasOne(Options::class, "FK_Value", "FK_area_artistica")->where("FK_Id_Parametro", 6);
    }


}
