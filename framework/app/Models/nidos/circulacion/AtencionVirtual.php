<?php

namespace App\Models\nidos\circulacion;

use Illuminate\Database\Eloquent\Model;

class AtencionVirtual extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_atenciones_virtuales';
    public $timestamps = false;

    protected $casts = [
        'VC_Temas_Lectura_Libro_Viento' => 'array'
    ];
}
