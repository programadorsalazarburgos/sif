<?php

namespace App\Http\Controllers\nidos\transicion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\transicion\AdministracionColegios;

class AdministracionColegiosController extends Controller
{
	public function getColegiosConvenioSED(Request $request){
		$colegios = new AdministracionColegios;
		$resultado = $colegios->getColegiosConvenioSED();
		return response()->json(json_decode($resultado), 200);
	}

	public function guardarInstitucion(Request $request){
        $datos = json_decode($request["form"]);

        if($request->proceso == "crear"){
            $lugar = new AdministracionColegios;
			$lugar->Fk_Id_Localidad = $datos->localidad->value;
			$lugar->Fk_Id_Upz = $datos->upz->value;
					
			$lugar->VC_Barrio = $datos->barrio;
			$lugar->Fk_Id_Entidad = '3';
			$lugar->VC_Tipo_Lugar = '2';
			$lugar->VC_Direccion = $datos->direccion;			
			$lugar->VC_Nombre_Lugar = $datos->institucion;
			$lugar->VC_Telefono = '0000000';
			$lugar->VC_Coordinador = 'SIN INFORMACION';
			$lugar->VC_Email = 'SIN INFORMACION';
			$lugar->VC_Celular = 'SIN INFORMACION';
			$lugar->IN_Estado = '1';
			$lugar->DT_Fecha_Creacion = date("Y-m-d H:i:s");
			$lugar->VC_Dane12 = $datos->dane;
			$lugar->IN_Componente = '3';
            $lugar->save();
        }else{
            $lugar = new AdministracionColegios;
            $lugar->where('Pk_Id_lugar_atencion', $request->id_institucion)->update(["Fk_Id_Localidad" => $datos->localidad->value, "Fk_Id_Upz" => $datos->upz->value, "VC_Direccion" => $datos->direccion, "VC_Barrio" => $datos->barrio, "VC_Nombre_Lugar" => $datos->institucion, "VC_Dane12" => $datos->dane]);
        }
    }

	public function getLugaresAtenciontransicion(Request $request){ 
        $options = new AdministracionColegios;
        $resultado = $options->getLugaresAtenciontransicion($request->id_localidad);
        return response()->json(json_decode($resultado), 200);
    }


}
