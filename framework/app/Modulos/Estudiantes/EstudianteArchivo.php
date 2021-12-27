<?php

namespace App\Modulos\Estudiantes;

use Illuminate\Database\Eloquent\Model;

class EstudianteArchivo extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_estudiante_archivo';
	public $timestamps = false;
}
