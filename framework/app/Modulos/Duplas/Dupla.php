<?php

namespace App\Modulos\Duplas;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\FortalecimientoExterno\GrupoFortalecimientoExterno;
use App\Modulos\Personas\Persona;
use App\Modulos\Duplas\DuplaArtista;

class Dupla extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_dupla';
    public $timestamps = false;

    protected $primaryKey = 'Pk_Id_Dupla';

    protected $fillable = [
        'Fk_Id_Tipo_Dupla',
        'VC_Codigo_Dupla',
        'Fk_Id_Territorio',
        'Fk_Id_Gestor',
        'Fk_Id_Eaat',
        'IN_Estado',
        'DT_Fecha_Creacion',
        'VC_Descripcion'
    ];

    protected $appends = ['nombre_tipo_dupla'];

    public function getNombreTipoDuplaAttribute(){
        $nombre_tipo_dupla = "";
        switch($this->Fk_Id_Tipo_Dupla){

            case 1:
            $nombre_tipo_dupla = "Circulación";
            break;
            case 2:
            $nombre_tipo_dupla = "Laboratorio";
            break;
            case 3:
            $nombre_tipo_dupla = "Territorial";
            break;
            case 4:
            $nombre_tipo_dupla = "Fortalecimiento";
            break;
            case 5:
            $nombre_tipo_dupla = "Transición";
            break;
        }
        return $nombre_tipo_dupla;
    }


    /**
    * Relaciones
    */
    public function artistas(){
        return $this->belongsToMany(Persona::class, DuplaArtista::class, 'Fk_Id_Dupla', 'Fk_Id_Persona')->withPivot('IN_Estado');
    }
    public function gruposFortalecimientoExterno(){
        return $this->hasMany(GrupoFortalecimientoExterno::class, "fk_dupla", "Pk_Id_Dupla");
    }
}
