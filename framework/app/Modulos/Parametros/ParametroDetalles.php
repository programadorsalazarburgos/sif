<?php

namespace App\Modulos\Parametros;

use Illuminate\Database\Eloquent\Model;

class ParametroDetalles extends Model
{
    protected $table = 'tb_parametro_detalle';
    protected $primaryKey= 'PK_Id_Tabla';
    protected $fillable = [
        'FK_Id_Parametro',
        'VC_Descripcion',
        'FK_Value',
        'IN_Estado', 
        'IN_Estado_Nidos', 
        'IN_Estado_Culturas',
        'IN_Ordenacion',
        'TX_Estado_Proyecto'
    ];
    //public $timestamps = true;

    public function __construct(){} 
       
}  