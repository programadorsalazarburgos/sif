<?php

namespace App\Modulos\Duplas;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\FortalecimientoExterno\GrupoFortalecimientoExterno;
use App\Modulos\Personas\Persona;

class DuplaArtista extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_dupla_artista';
    public $timestamps = false;

    protected $primaryKey = 'Pk_Id_Dupla_Artista';

    protected $fillable = [
        'Fk_Id_Dupla',
        'Fk_Id_Persona',
        'IN_Estado',
        'DT_Fecha_Ingreso',
        'DT_Fecha_Retiro',
    ];
}
