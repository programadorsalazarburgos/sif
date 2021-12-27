<?php

namespace App\Modulos\Parametros;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Parametros\ParametroDetalles;


class Parametro extends Model
{
    protected $table = 'tb_parametro';
    protected $primaryKey= 'PK_Id_Parametro';
    protected $fillable = [
        'VC_Nombre',
    ];
    //public $timestamps = true;
    
    public function __construct(){}

    public function detalles()
    {
    	return $this->hasMany(ParametroDetalles::class, 'FK_Id_Parametro','PK_Id_Parametro');
    }
}