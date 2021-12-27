<?php

namespace App\Models\nidos\transicion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BeneficiariosGrupoTransicion extends Model
{
	/**
    * The table associated with the model.
    *
    * @var string
    */
	protected $table = 'tb_nidos_beneficiario_grupo_transicion';
	public $timestamps = false;


 /*   public function getBeneficiariosGrupo(){
		$grupos = BeneficiariosGrupoTransicion::select("BE.Pk_Id_Beneficiario AS IdBeneficiario", "BE.VC_Identificacion AS Identificacion", BeneficiariosGrupoTransicion::raw("CONCAT(BE.VC_Primer_Nombre ,' ',BE.VC_Segundo_Nombre,' ', BE.VC_Primer_Apellido,' ',BE.VC_Segundo_Apellido) AS Beneficiario"), "BE.FK_Id_Genero AS Genero", "BE.DD_F_Nacimiento AS Nacimiento")
		->join("tb_nidos_beneficiarios AS BE", "Fk_Id_Beneficiario", "=", "BE.Pk_Id_Beneficiario")
		->where([
			["Fk_Id_Grupo", "=", "1"]
		])
		->get();
		return $grupos;
	} */
	
    public function getBeneficiariosGrupo($id_grupo){
		$sql = "SELECT BE.Pk_Id_Beneficiario AS IdBeneficiario, 
        BE.VC_Identificacion AS Identificacion, 
        CONCAT_WS(' ', BE.VC_Primer_Nombre, BE.VC_Segundo_Nombre, BE.VC_Primer_Apellido, BE.VC_Segundo_Apellido) AS Beneficiario,
        (CASE WHEN BE.FK_Id_Genero = '1' THEN 'Masculino' WHEN BE.FK_Id_Genero = '2' THEN 'Femenino' END)  AS Genero,
        BE.DD_F_Nacimiento  AS Nacimiento
        FROM tb_nidos_beneficiario_grupo_transicion AS GT
        JOIN tb_nidos_beneficiarios AS BE ON GT.Fk_Id_Beneficiario = BE.Pk_Id_Beneficiario
        WHERE GT.Fk_Id_Grupo = $id_grupo ORDER BY Beneficiario";
		$grupos = DB::select($sql);
		return $grupos;
	  }
}
