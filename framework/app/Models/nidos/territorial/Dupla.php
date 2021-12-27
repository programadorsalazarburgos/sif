<?php

namespace App\Models\nidos\territorial;

use Illuminate\Database\Eloquent\Model;
use App\Models\nidos\fortalecimiento\GrupoFortalecimientoExterno;
use App\Models\nidos\territorial\DuplaArtista;
use App\Modulos\Personas\Persona;

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


    /**
    * Relaciones
    */
    public function artistas(){
        return $this->belongsToMany(Persona::class, 'tb_nidos_dupla_artista', 'Fk_Id_Dupla', 'Fk_Id_Persona');
    }
    public function gruposFortalecimientoExterno(){
        return $this->hasMany(GrupoFortalecimientoExterno::class, "fk_dupla", "Pk_Id_Dupla");
    }
}
