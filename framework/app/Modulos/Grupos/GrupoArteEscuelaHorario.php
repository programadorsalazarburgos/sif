<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;

class GrupoArteEscuelaHorario extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_terr_grupo_arte_escuela_horario_clase';
    public $timestamps = false;
    protected $fillable = [
        'TI_hora_inicio_clase',
        'TI_hora_fin_clase'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = array('IN_dia');
    
    /**
    * Accesores
    */
    public function getInDiaAttribute(){
    	switch($this->attributes['IN_dia']){
    		case 1:
    		$this->attributes['IN_dia'] = "Lunes";
    		break;
    		case 2:
    		$this->attributes['IN_dia'] = "Martes";
    		break;
    		case 3:
    		$this->attributes['IN_dia'] = "Miércoles";
    		break;
    		case 4:
    		$this->attributes['IN_dia'] = "Jueves";
    		break;
    		case 5:
    		$this->attributes['IN_dia'] = "Viernes";
    		break;
    		case 6:
    		$this->attributes['IN_dia'] = "Sábado";
    		break;
    	}
    	return $this->attributes['IN_dia'];
    }
}
