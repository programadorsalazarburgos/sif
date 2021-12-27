<?php

namespace App\Models\nidos\territorial;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_beneficiarios';
    public $timestamps = false;

    public function validarBeneficiarioRegistrado($id_beneficiario){
    	$beneficiario = Beneficiario::select(Beneficiario::raw("CONCAT('{\"value\":\"', FK_Tipo_Identificacion, '\",\"text\":\"', td.VC_Descripcion, '\"}') AS tdoc"), "VC_Primer_Nombre AS pnombre", "VC_Segundo_Nombre AS snombre", "VC_Primer_Apellido AS papellido", "VC_Segundo_Apellido AS sapellido", "DD_F_Nacimiento AS fnacimiento", Beneficiario::raw("CONCAT('{\"value\":\"', FK_Id_Genero, '\",\"text\":\"', g.VC_Descripcion, '\"}') AS genero"), Beneficiario::raw("CONCAT('{\"value\":\"', IN_Grupo_Poblacional, '\",\"text\":\"', en.VC_Descripcion, '\"}') AS enfoque"), Beneficiario::raw("CONCAT('{\"value\":\"', IN_Estrato, '\",\"text\":\"', e.VC_Descripcion, '\"}') AS estrato"))
        ->join("tb_parametro_detalle as td", "td.FK_Value", "=", "FK_Tipo_Identificacion")
        ->join("tb_parametro_detalle as g", "g.FK_Value", "=", "FK_Id_Genero")
        ->join("tb_parametro_detalle as en", "en.FK_Value", "=", "IN_Grupo_Poblacional")
        ->join("tb_parametro_detalle as e", "e.FK_Value", "=", "IN_Estrato")
        ->where([
          ["VC_Identificacion", "=", $id_beneficiario],
          ["td.FK_Id_Parametro", "=", 5],
          ["td.IN_Estado_Nidos", "=", 1],
          ["g.FK_Id_Parametro", "=", 17],
          ["g.IN_Estado_Nidos", "=", 1],
          ["en.FK_Id_Parametro", "=", 14],
          ["en.IN_Estado_Nidos", "=", 1],
          ["e.FK_Id_Parametro", "=", 53],
          ["e.IN_Estado_Nidos", "=", 1]
      ])
        ->get();

        return $beneficiario;
    }
}


