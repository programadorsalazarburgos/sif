<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Options;
use App\Models\nidos\Barrio;
use App\Models\nidos\Upz;
use App\Models\nidos\territorial\Dupla;
use App\Models\nidos\territorial\DuplaArtista;

class OptionsController extends Controller
{
    public function getParametroDetalle(Request $request){
        
        $options = new Options;
        $FK_Id_Parametro = $request['FK_Id_Parametro'];
        $programa = $request->programa;
        if(!isset($request->programa))
            $programa = "crea";

        $resultado = $options->getParametroDetalle($FK_Id_Parametro, $programa);
        return response()->json($resultado, 200);
    }

    public function getParametroDetalleNidos(Request $request){
        
        $options = new Options;
        $FK_Id_Parametro = $request['FK_Id_Parametro'];
        $programa = $request->programa;
        if(!isset($request->programa))
            $programa = "nidos";

        $resultado = $options->getParametroDetalle($FK_Id_Parametro, $programa);
        return response()->json($resultado, 200);
    }
    
    public function getCentrosCrea(Request $request){
        $options = new Options;
        $resultado = $options->getCentrosCrea();
        return response()->json($resultado, 200);
    }

    public function getColegios(Request $request){
        $options = new Options;
        $resultado = $options->getColegios($request->year);
        return response()->json($resultado, 200);
    }

    public function getLineasNidos(Request $request){
        $options = new Options;
        $resultado = $options->getLineasNidos();
        return response()->json($resultado, 200);
    }

    public function getGruposAtendidosLineaAnio(Request $request){
        $options = new Options;
        $id_linea_atencion = $request["id_linea_atencion"];
        $year = $request["year"];
        $resultado = $options->getGruposAtendidosLineaAnio($id_linea_atencion, $year);
        return response()->json($resultado, 200);
    }

    public function getYearsEstadisticasAnio(Request $request){
        $options = new Options;
        $resultado = $options->getYearsEstadisticasAnio();
        return response()->json($resultado, 200);
    }

    public function getTerritorioPersona(){
        $options = new Options;
        $resultado = $options->getYearsEstadisticasAnio();
        return response()->json($resultado, 200);
    }

    public function getTipoDocumento(Request $request){
        $options = new Options;
        $resultado = $options->getTipoDocumento();
        return response()->json(json_decode($resultado), 200);
    }

    public function getGenero(Request $request){
        $options = new Options;
        $resultado = $options->getGenero();
        return response()->json(json_decode($resultado), 200);
    }

    public function getEnfoque(Request $request){
        $options = new Options;
        $resultado = $options->getEnfoque();
        return response()->json(json_decode($resultado), 200);
    }

    public function getEstrato(Request $request){
        $options = new Options;
        $resultado = $options->getEstrato();
        return response()->json(json_decode($resultado), 200);
    }

    public function setIdpersona(Request $request){
        
        $request->session()->put('id_usuario', $request->id_usuario);
        $request->session()->put('rol_persona', $request->rol_persona);
    }

    public function setRolPersona(Request $request){
        $rol_persona = $request->rol_persona;
        $request->session()->put('rol_persona', $request->rol_persona);
    }

    public function getIdpersona(Request $request){
        $id_usuario = $request->session()->get('id_usuario');
        return response()->json($id_usuario, 200);
    }

    public function getRolPersona(Request $request){
        $id_rol = $request->session()->get('rol_persona');
        return response()->json($id_rol, 200);
    }

    public function getMes(Request $request){
        $options = new Options;
        $resultado = $options->getMes();
        return response()->json(json_decode($resultado), 200);
    }

    public function getConveniosActivosCREA(Request $request){
        $options = new Options;
        $resultado = $options->getConveniosActivosCREA();
        return response()->json(json_decode($resultado), 200);
    }

    public function getBarriosLocalidad(Request $request){
        $resultado = Barrio::select("VC_Barrio as text", "PK_Id_Tabla as value")
        ->where("FK_Id_Localidad", $request->id_localidad)
        ->get();
        return response()->json($resultado, 200);
    }

    public function getUpzBarrio(Request $request){
        $resultado = Barrio::select("FK_Id_Upz")
        ->where("PK_Id_Tabla", $request->id_barrio)
        ->get();
        return response()->json($resultado[0], 200);
    }

    public function getDuplaPersona(Request $request){
        $id_persona = $request->id_persona;

        $resultado = Dupla::select("Pk_Id_Dupla")
        ->whereHas("artistas", function($query) use ($id_persona){
            $query->where([
                ["Fk_Id_Persona", $id_persona],
                ["IN_Estado", 1]
            ]);
        })
        ->get();
        return response()->json(json_decode($resultado[0]), 200);
    }

    public function getBarrios(Request $request){
        $options = new Options;
        $resultado = $options->getBarrios($request->localidad);
        return response()->json(json_decode($resultado), 200);
    }

    public function getGruposPoblacionalesCulturas(Request $request){
        $options = new Options;
        $resultado = $options->getGruposPoblacionalesCulturas($request->FK_Parametro);
        return response()->json(json_decode($resultado), 200);
    }

    public function getUpzLocalidad(Request $request){
        $resultado = Upz::select("VC_Nombre_Upz as text", "Pk_Id_Upz as value")
        ->where("FK_Id_Localidad", $request->id_localidad)
        ->get();
        return response()->json($resultado, 200);
    }

    public function getCodigoArtistasDupla(Request $request){
		$dupla = new DuplaArtista;
		$resultado = $dupla->getCodigoArtistasDupla($request->personaid);
		//return response()->json(json_decode($resultado), 200);
		return response()->json($resultado[0], 200);
	}
}