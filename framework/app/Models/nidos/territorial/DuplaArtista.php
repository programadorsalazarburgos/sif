<?php

namespace App\Models\nidos\territorial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;

class DuplaArtista extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_dupla_artista';
    public $timestamps = false;

    /**
    * Relaciones
    */
    public function persona(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "Fk_Id_Persona");
    }
    public function dupla(){
        return $this->hasOne(Dupla::class, "Pk_Id_Dupla", "Fk_Id_Dupla")->where("IN_Estado", 1);
    }

    public function getCodigoArtistasDupla($personaid){
		$sql = "SELECT DU.Pk_Id_Dupla AS IdDupla , DU.VC_Codigo_Dupla AS Codigo,
        (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ') )
         FROM tb_nidos_dupla_artista DA, 
         tb_persona_2017 PER
        WHERE DA.Fk_Id_Dupla = DU.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona AND DA.IN_Estado = 1)  AS 'ARTISTAS'
        FROM tb_nidos_dupla_artista AS DA
        JOIN tb_nidos_dupla AS DU ON DA.Fk_Id_Dupla = DU.Pk_Id_Dupla
        WHERE DA.Fk_Id_Persona = $personaid AND DA.IN_Estado = 1";
		$dupla = DB::select($sql);
		return $dupla;

	  }

    


}