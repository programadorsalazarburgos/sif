<?php

namespace App\Models\crea\territorial;

use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_preinscripcion';
    public $timestamps = false;

    /**
    * Accesores
    */
    public function getFechaSolicitudAttribute($value){
    	return date("d/m/Y", strtotime($value));
    }
}
