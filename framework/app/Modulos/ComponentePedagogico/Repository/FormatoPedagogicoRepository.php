<?php

namespace App\Modulos\ComponentePedagogico\Repository;

use App\Modulos\ComponentePedagogico\Interfaces\FormatoPedagogicoInterface;
use App\Modulos\ComponentePedagogico\FormatoPedagogico;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDF;

use App\Modulos\Grupos\GrupoArteEscuela;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoLaboratorioClan;
use App\Modulos\Grupos\CaracterizacionGrupo;
use App\Modulos\Grupos\PlaneacionGrupo;
use App\Modulos\Personas\Persona;
use App\Modulos\Grupos\ValoracionGrupo;

class FormatoPedagogicoRepository implements FormatoPedagogicoInterface
{
	public function __construct(){}

	public function crear($data){

        $planeacion = new PlaneacionGrupo;
        return $this->procesar($planeacion, $data);
        
    }

    public function crearIc($data){
        
        $planeacion = new PlaneacionGrupo;
        return $this->procesarIc($planeacion, $data);
        
    }

    public function crearCv($data){
        
        $planeacion = new PlaneacionGrupo;
        return $this->procesarCv($planeacion, $data);
        
    }

	public function dataTable($relaciones=[]){}
	public function show($relaciones=[]){}

	public function actualizar($request, $id){

        $planeacion = PlaneacionGrupo::find($id);
		return $this->procesar($planeacion, $request);
    }

    public function actualizarCaracterizacionGrupo($request, $id){
        $caracterizacion = CaracterizacionGrupo::find($id);
        $caracterizacion['IN_Finalizado'] = boolval($request['finalizado']);
        $caracterizacion['JSON_formulario'] = json_encode($request['formulario']);
        return response()->json($caracterizacion->save(), 200);
    }

    public function actualizarIc($data, $id){
        
        $planeacion = PlaneacionGrupo::find($id);
        return $this->procesarIc($planeacion, $data);
        
    }

    public function actualizarCv($data, $id){
        
        $planeacion = PlaneacionGrupo::find($id);
        return $this->procesarCv($planeacion, $data);
        
    }

	public function obtener($id, $relaciones = []){}
	public function eliminar($id){}
	public function obtenerTodo( $relaciones = []){}

	public function procesar($planeacion, $request){
        
        if(!is_null($request['id_caracterizacion_hidden'])){

            $caracterizado = CaracterizacionGrupo::where('PK_Id_Caracterizacion', $request['id_caracterizacion_hidden'])->first();
            $caracterizado->i_flag = 1;

            $caracterizado->save();
        }
        
        if(isset($request['selectsMoment'])){

			foreach ($request['selectsMoment'] as $key => $planea) {
                
				$content[] = [
					'id' => $key,
					'semana' => $key + 1,
                    'fechaS' => $request['fecha'][$key],
					'selector' => $planea,
					'planeacion' => $request['txWeek'][$key],
				];
			}
			
			$planeacion->json_semanas = json_encode($content);

		}

        $planeacion->FK_Grupo = $request['id_grupo']; 
        $planeacion->FK_Id_Linea_Atencion = $request['linea_atencion'];
        $planeacion->FK_Id_Usuario_Registro = $request['id_usuario'];
        $planeacion->DA_Fecha_Registro = date('Y-m-d H:i:s');
        if($request['finalizado'] == "true"){
			$planeacion->IN_Finalizado = 1;
		}else{
			$planeacion->IN_Finalizado = 0;
		}
        $planeacion->IN_Version = '3';
        $planeacion->JSON_formulario = json_encode($request['formulario']);
        $planeacion->i_fk_id_caracterizado = $request['id_caracterizacion_hidden'];

        $planeacion->save();

		$rta = true;

		return response()->json($rta, 200);
    }

    public function procesarIc($planeacion, $request){
        
        if(!is_null($request['id_caracterizacion_hidden'])){

            $caracterizado = CaracterizacionGrupo::where('PK_Id_Caracterizacion', $request['id_caracterizacion_hidden'])->first();
            $caracterizado->i_flag = 1;

            $caracterizado->save();
        }
        
        if(isset($request['selectsMomentIc'])){

			foreach ($request['selectsMomentIc'] as $key => $planea) {
                
				$content[] = [
					'id' => $key,
					'semana' => $key + 1,
                    'fechaS' => $request['fechaIC'][$key],
					'selector' => $planea,
					'planeacion' => $request['txWeekIc'][$key],
				];
			}
			
			$planeacion->json_semanas = json_encode($content);

		}

        $planeacion->FK_Grupo = $request['id_grupo']; 
        $planeacion->FK_Id_Linea_Atencion = $request['linea_atencion'];
        $planeacion->FK_Id_Usuario_Registro = $request['id_usuario'];
        $planeacion->DA_Fecha_Registro = date('Y-m-d H:i:s');
        if($request['finalizado'] == "true"){
			$planeacion->IN_Finalizado = 1;
		}else{
			$planeacion->IN_Finalizado = 0;
		}
        $planeacion->IN_Version = '3';
        $planeacion->JSON_formulario = json_encode($request['formulario']);
        $planeacion->i_fk_id_caracterizado = $request['id_caracterizacion_hidden'];

        $planeacion->save();

		$rta = true;

		return response()->json($rta, 200);
    }

    public function procesarCv($planeacion, $request){
        
        if(!is_null($request['id_caracterizacion_hidden'])){

            $caracterizado = CaracterizacionGrupo::where('PK_Id_Caracterizacion', $request['id_caracterizacion_hidden'])->first();
            $caracterizado->i_flag = 1;

            $caracterizado->save();
        }

        $planeacion->FK_Grupo = $request['id_grupo']; 
        $planeacion->FK_Id_Linea_Atencion = $request['linea_atencion'];
        $planeacion->FK_Id_Usuario_Registro = $request['id_usuario'];
        $planeacion->DA_Fecha_Registro = date('Y-m-d H:i:s');
        if($request['finalizado'] == "true"){
			$planeacion->IN_Finalizado = 1;
		}else{
			$planeacion->IN_Finalizado = 0;
		}
        $planeacion->IN_Version = '3';
        $planeacion->JSON_formulario = json_encode($request['formulario']);
        $planeacion->i_fk_id_caracterizado = $request['id_caracterizacion_hidden'];

        $planeacion->save();

		$rta = true;

		return response()->json($rta, 200);
    }

	public function obtenerTabla($request){}

	public function obtenerModelo($linea_atencion) {
        switch($linea_atencion) {
            case '1':
                $model = new GrupoArteEscuela;
            break;
            case '2':
                $model = new GrupoEmprendeClan;
            break;
            case '3':
                $model = new GrupoLaboratorioClan;
            break;
        }
        return $model;
    }

    public function getGruposXLinea(Request $request) {
        $model = $this->obtenerModelo($request['linea_atencion']);
        if($request['linea_atencion'] == '1')
            $sigla = 'AE-';
        elseif($request['linea_atencion'] == '2')
            $sigla = 'IC-';
        else
            $sigla = 'CV-';
        $result = $model::whereNull('DT_fecha_cierre')
        ->where([
            ['FK_artista_formador', '=', $request['id_usuario']],
            ['estado', '=', '1'],
        ])
        ->get();
        foreach ($result as $grupo) {

			$data[] = [
				'value' => $grupo->PK_Grupo,
				'text' => $sigla.$grupo->PK_Grupo,
			];
			
		}
		return response()->json($data);
    }
	public function getInformacionGrupo(Request $request) {
        $model = $this->obtenerModelo($request['linea_atencion']);
        if($request['linea_atencion'] == '1')
            $result = $model::with('crea', 'artistas', 'areasArtisticas', 'horarios', 'lugarAtencion', 'colegio', 'modalidadAtencion', 'tipoAtencion')->where('PK_Grupo', $request['id_grupo'])->first();
        elseif($request['linea_atencion'] == '2')
            $result = $model::with('crea', 'artistas', 'areasArtisticas', 'horarios', 'lugarAtencion', 'modalidadAtencion', 'tipoAtencion')->where('PK_Grupo', $request['id_grupo'])->first();
        else
            $result = $model::with('crea', 'artistas', 'areasArtisticas', 'horarios', 'lugarAtencion', 'lugarComplementario', 'modalidadAtencion', 'tipoAtencion')->where('PK_Grupo', $request['id_grupo'])->first();

		return response()->json($result);
    }

    public function guardarCaracterizacionGrupo(Request $request){
        $model = new CaracterizacionGrupo;
        $cambios['FK_Grupo'] = $request['id_grupo']; 
        $cambios['FK_Id_Linea_Atencion'] = $request['linea_atencion'];
        $cambios['FK_Id_Usuario_Registro'] = $request['id_usuario'];
        $cambios['DA_Fecha_Registro'] = date('Y-m-d H:i:s');
        $cambios['IN_Finalizado'] = boolval($request['finalizado']);
        $cambios['IN_Version'] = '3';
        $cambios['JSON_formulario'] = json_encode($request['formulario']);
        $result = $model->nuevoRegistro($cambios);
        return response()->json($result);
    }

    public function getInfoTable($request) {
        
        $caracterizados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio')
                                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                                ->where('IN_Finalizado', 1)
                                                ->where('IN_Estado', 1)
                                                ->where('IN_Version', 3)
                                                ->where('i_flag', null)
                                                ->get();
        
        //dd($caracterizados);
        return response()->json(json_decode($caracterizados), 200);

    }

    public function guardarPlaneacionGrupo(Request $request){
        $model = new CaracterizacionGrupo;
        $cambios['FK_Grupo'] = $request['id_grupo']; 
        $cambios['FK_Id_Linea_Atencion'] = $request['linea_atencion'];
        $cambios['FK_Id_Usuario_Registro'] = $request['id_usuario'];
        $cambios['DA_Fecha_Registro'] = date('Y-m-d H:i:s');
        $cambios['IN_Finalizado'] = boolval($request['finalizado']);
        $cambios['IN_Version'] = '3';
        $cambios['JSON_formulario'] = json_encode($request['formulario']);
        $result = $model->nuevoRegistro($cambios);
        return response()->json($result);
    }

    public function data($request){
        //dd($request);
        $user = Persona::where('PK_Id_Persona',$request['id_persona'])->first();
        
        if (isset($request['tipo']) && isset($request['estado'])) {
            if ($request['tipo'] == 0) {//propios
                
                if ($request['estado'] == 0) { //Revisados

                    $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', 1)
                                ->get();
                }
                if ($request['estado'] == 1) { //Devueltos

                    $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', 0)
                                ->get();
                }
                if ($request['estado'] == 2) { //En proceso

                    $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', NULL)
                                ->get();

                }
            }else{
                
                if ($user->FK_Tipo_Persona == 30 || $user->FK_Tipo_Persona == 35) {
                    
                    if ($request['estado'] == 0) { //Revisados

                        $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', 1)
                                    ->where('IN_Finalizado', 1)
                                    ->get();
                    }
                    if ($request['estado'] == 1) { //Devueltos
    
                        $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', 0)
                                    ->where('IN_Finalizado', 1)
                                    ->get();
                    }
                    if ($request['estado'] == 2) { //En proceso
                        
                        $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', NULL)
                                    ->where('IN_Finalizado', 1)
                                    ->get();
                        
    
                    }
                }else{
                    $planeados = null;
                }
                    
            }
            
        }else{
            $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                        ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                        ->where('IN_Version', 3)
                                        ->get();
        }
        
        return response()->json(json_decode($planeados), 200);
    }

    public function getPlaneacion($request) {
        
        $planeadoEdit = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio')
                                        ->where('PK_Id_Planeacion', $request['idPlaneacion'])
                                        ->first();
        
        return response()->json(json_decode($planeadoEdit), 200);

    }

    public function registerApproval($request){
		
		$planeacion = PlaneacionGrupo::where('PK_Id_Planeacion', $request['id_planeacion'])->first();

        if ($request['checkApprove'] == false) {
            $planeacion->IN_Estado = 0;
            $planeacion->IN_Finalizado = 0;
        }else{
            $planeacion->IN_Estado = 1;
        }
        
		$planeacion->VC_Observacion = $request['observacionApprove'];
        $planeacion->FK_Id_AFA_Cambio = $request['id_persona'];
        $planeacion->DT_AFA_Cambio = date('Y-m-d H:i:s');

		$planeacion->save();

		$rta = true;
        
		return response()->json($rta, 200);
	}

    public function getInfoTableAnalisis($request) {

        $planeados = PlaneacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio')
                                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                                ->where('IN_Finalizado', 1)
                                                ->where('IN_Estado', 1)
                                                ->where('IN_Version', 3)
                                                ->where('i_flag', null)
                                                ->get();
        
        return response()->json(json_decode($planeados), 200);

    }

    public function crearAnalisis($data) {
        
        $valoracion = new ValoracionGrupo;
        return $this->procesarAnalisis($valoracion, $data);
            
    }

    public function updateAnalisis($data, $id) {
        
        $valoracion = ValoracionGrupo::find($id);
        return $this->procesarAnalisis($valoracion, $data);
            
    }

    public function procesarAnalisis($valoracion, $data) {
        //dd($data);
        if(!is_null($data['id_planeacion_hidden'])){

            $planeado = PlaneacionGrupo::where('PK_Id_Planeacion', $data['id_planeacion_hidden'])->first();
            $planeado->i_flag = 1;

            $planeado->save();
        }

        $valoracion->FK_Grupo = $data['id_grupo'];
        $valoracion->FK_Linea_Atencion = $data['linea_atencion'];
        $valoracion->i_fk_id_usuario_registro = $data['id_usuario'];
        $valoracion->DA_Subida = date('Y-m-d H:i:s');
        if($data['finalizado'] == "true"){
			$valoracion->in_finalizado = 1;
		}else{
			$valoracion->in_finalizado = 0;
		}
        $valoracion->IN_Version = '3';
        $valoracion->JSON_formulario = json_encode($data['formulario']);
        $valoracion->i_fk_id_planeacion = $data['id_planeacion_hidden'];

        $valoracion->save();

		$rta = true;

		return response()->json($rta, 200);

    }
    
    public function dataAnalisis($request){
        //dd($request);
        $user = Persona::where('PK_Id_Persona',$request['id_persona'])->first();
        
        if (isset($request['tipo']) && isset($request['estado'])) {
            if ($request['tipo'] == 0) {//propios
                
                if ($request['estado'] == 0) { //Revisados

                    $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('i_fk_id_usuario_registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', 1)
                                ->get();
                }
                if ($request['estado'] == 1) { //Devueltos

                    $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('i_fk_id_usuario_registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', 0)
                                ->get();
                }
                if ($request['estado'] == 2) { //En proceso

                    $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('i_fk_id_usuario_registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', NULL)
                                ->get();

                }
            }else{
                
                if ($user->FK_Tipo_Persona == 30 || $user->FK_Tipo_Persona == 35) {
                    
                    if ($request['estado'] == 0) { //Revisados

                        $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', 1)
                                    ->where('in_finalizado', 1)
                                    ->get();
                    }
                    if ($request['estado'] == 1) { //Devueltos
    
                        $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', 0)
                                    ->where('in_finalizado', 1)
                                    ->get();
                    }
                    if ($request['estado'] == 2) { //En proceso
                        
                        $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', NULL)
                                    ->where('in_finalizado', 1)
                                    ->get();
                        
    
                    }
                }else{
                    $planeados = null;
                }
                    
            }
            
        }else{
            $planeados = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                        ->where('i_fk_id_usuario_registro', $request['id_persona'])
                                        ->where('IN_Version', 3)
                                        ->get();
        }
        
        return response()->json(json_decode($planeados), 200);
    }

    public function getAnalisis($request) {
        
        $planeadoEdit = ValoracionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio')
                                        ->where('PK_Id_Valoracion', $request['idValoracion'])
                                        ->first();
        
        return response()->json(json_decode($planeadoEdit), 200);

    }

    public function registerApprovalAnalisis($request){
        
        $analisis = ValoracionGrupo::where('PK_Id_Valoracion', $request['id_valoracion'])->first();
        
        if ($request['checkApprove'] == false) {
            $analisis->IN_Estado = 0;
            $analisis->IN_Finalizado = 0;
        }else{
            $analisis->IN_Estado = 1;
        }
        
		$analisis->TX_Observacion = $request['observacionApprove'];
        $analisis->FK_Id_AFA_Cambio = $request['id_persona'];
        $analisis->DT_AFA_Cambio = date('Y-m-d H:i:s');

		$analisis->save();

		$rta = true;
        
		return response()->json($rta, 200);
    }

    public function pdfPlaneacion($idInforme, $idLinea){
		
		$planeacion = PlaneacionGrupo::where('PK_Id_Planeacion', $idInforme)->first();
        $contenido = json_decode($planeacion->JSON_formulario);
        $contenido = json_decode($contenido);
        $planeador = json_decode($planeacion->json_semanas);
        
		$datos = [        
			'planeacion' => $planeacion,
			'contenido' => $contenido,
			'planeador' => $planeador,
		];

		if ($idLinea == 1) {
            $view = view('crea.componentePedagogico.pdf_planeacion_ae',$datos)->render();
        }elseif ($idLinea == 2) {
            $view = view('crea.componentePedagogico.pdf_planeacion_ic',$datos)->render();
        }elseif ($idLinea == 3) {
            $view = view('crea.componentePedagogico.pdf_planeacion_cv',$datos)->render();
        }
		
		$pdf = PDF::loadHTML($view);
		//$pdf = \PDF::loadView('organizaciones.pdf_informe_gestion',  ['datos' => $informe]);
		
		//return $pdf->stream('prueba.pdf');   
		return $pdf->setPaper('folio', 'portrait')->download("Formato Pedagógico General - Planeación.pdf");
	}

    public function pdfValoracion($idInforme, $idLinea){
		
		$valoracion = ValoracionGrupo::where('PK_Id_Valoracion', $idInforme)->first();
        $contenido = json_decode($valoracion->JSON_formulario);
        $contenido = json_decode($contenido);
        
		$datos = [        
			'valoracion' => $valoracion,
			'contenido' => $contenido,
            'linea' => $idLinea
		];

        $view = view('crea.componentePedagogico.pdf_valoracion',$datos)->render();
       
		$pdf = PDF::loadHTML($view);
		//$pdf = \PDF::loadView('organizaciones.pdf_informe_gestion',  ['datos' => $informe]);
		
		//return $pdf->stream('prueba.pdf');   
		return $pdf->setPaper('folio', 'portrait')->download("Formato Pedagógico General - ANÁLISIS Y SEGUIMIENTO DEL PROCESO FORMATIVO.pdf");
	}

    public function pdfProceso($idInforme, $idLinea){
		
		$valoracion = ValoracionGrupo::with('planeacion.caracterizacion')->where('PK_Id_Valoracion', $idInforme)->first();
        
        $contenidoCaracterizacion = json_decode($valoracion->planeacion->caracterizacion->JSON_formulario);
        $contenidoPlaneacion = json_decode($valoracion->planeacion->JSON_formulario);
        $planeador = json_decode($valoracion->planeacion->json_semanas);
        $contenidoAnalisis = json_decode($valoracion->JSON_formulario);
        
		$datos = [        
			'contenidoCaracterizacion' => json_decode($contenidoCaracterizacion),
            'caracterizacion' => $valoracion->planeacion->caracterizacion,
			'contenidoPlaneacion' => json_decode($contenidoPlaneacion),
            'planeador' => $planeador,
            'planeacion' => $valoracion->planeacion,
			'contenidoAnalisis' => json_decode($contenidoAnalisis),
            'analisis' => $valoracion,
            'lineaAten' => $idLinea
		];
        
        $view = view('crea.componentePedagogico.pdf_general',$datos)->render();
        
		$pdf = PDF::loadHTML($view);
		//$pdf = \PDF::loadView('organizaciones.pdf_informe_gestion',  ['datos' => $informe]);
		
		//return $pdf->stream('prueba.pdf');   
		return $pdf->setPaper('folio', 'portrait')->download("Formato Pedagógico General.pdf");
        
	}

    public function getCaracterizacion($request){
        //dd($request);
        $user = Persona::where('PK_Id_Persona',$request['id_persona'])->first();
        
        if (isset($request['tipo']) && isset($request['estado'])) {
            if ($request['tipo'] == 0) {//propios
                
                if ($request['estado'] == 0) { //Revisados

                    $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', 1)
                                ->get();
                }
                if ($request['estado'] == 1) { //Devueltos

                    $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', 0)
                                ->get();
                }
                if ($request['estado'] == 2) { //En proceso

                    $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                ->where('IN_Version', 3)
                                ->where('IN_Estado', NULL)
                                ->get();

                }
            }else{
                
                if ($user->FK_Tipo_Persona == 30 || $user->FK_Tipo_Persona == 35) {
                    
                    if ($request['estado'] == 0) { //Revisados

                        $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', 1)
                                    ->where('IN_Finalizado', 1)
                                    ->get();
                    }
                    if ($request['estado'] == 1) { //Devueltos
    
                        $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', 0)
                                    ->where('IN_Finalizado', 1)
                                    ->get();
                    }
                    if ($request['estado'] == 2) { //En proceso
                        
                        $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                    ->where('IN_Version', 3)
                                    ->where('IN_Estado', NULL)
                                    ->where('IN_Finalizado', 1)
                                    ->get();
                        
    
                    }
                }else{
                    $planeados = null;
                }
                    
            }
            
        }else{
            $planeados = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio','user')
                                        ->where('FK_Id_Usuario_Registro', $request['id_persona'])
                                        ->where('IN_Version', 3)
                                        ->get();
        }
        return response()->json(json_decode($planeados), 200);
    }

    public function getCaracterizacionEdit($request) {
        
        $planeadoEdit = CaracterizacionGrupo::with('grupoArte.colegio','grupoImpulso.crea','grupoConverge.colegio')
                                        ->where('PK_Id_Caracterizacion', $request['idCaracterizacion'])
                                        ->first();
        
        return response()->json(json_decode($planeadoEdit), 200);

    }

    public function registerApprovalCaracter($request){
        
        $caracterizacion = CaracterizacionGrupo::where('PK_Id_Caracterizacion', $request['id_caracterizacion'])->first();
        
        if ($request['checkApprove'] == false) {
            $caracterizacion->IN_Estado = 0;
            $caracterizacion->IN_Finalizado = 0;
        }else{
            $caracterizacion->IN_Estado = 1;
        }
        
		$caracterizacion->TX_Observaciones = $request['observacionApprove'];
        $caracterizacion->FK_Id_AFA_Cambio = $request['id_persona'];
        $caracterizacion->DT_AFA_Cambio = date('Y-m-d H:i:s');

		$caracterizacion->save();

		$rta = true;
        
		return response()->json($rta, 200);

	}

    public function pdfCaracterizacion($idInforme, $idLinea){
		
		$caracterizacion = CaracterizacionGrupo::with('grupoArte.colegio',
                                                      'grupoImpulso.crea',
                                                      'grupoConverge.colegio',
                                                      'grupoArte.lugarAtencion',
                                                      'grupoConverge.lugarAtencion',
                                                      'grupoArte.crea',
                                                      'grupoArte.artistas',
                                                      'grupoImpulso.artistas',
                                                      'grupoConverge.artistas',
                                                      'grupoArte.areasArtisticas',
                                                      'grupoImpulso.areaArtistica',
                                                      'grupoConverge.areasArtisticas',
                                                      'grupoArte.horarios',
                                                      'grupoImpulso.horarios',
                                                      'grupoConverge.horarios',
                                                      'grupoArte.modalidadAtencion',
                                                      'grupoArte.tipoAtencion',
                                                      'grupoImpulso.tipoAtencion',
                                                      'grupoImpulso.modalidadAtencion'
                                                     )
                                ->where('PK_Id_Caracterizacion', $idInforme)->first();
        $contenido = json_decode($caracterizacion->JSON_formulario);
        $contenido = json_decode($contenido);
        
		$datos = [        
			'caracterizacion' => $caracterizacion,
			'contenido' => $contenido,
			'lineaAten' => $idLinea,
		];

        $view = view('crea.componentePedagogico.pdf_caracterizacion',$datos)->render();
        
		$pdf = PDF::loadHTML($view);
		//$pdf = \PDF::loadView('organizaciones.pdf_informe_gestion',  ['datos' => $informe]);
		
		//return $pdf->stream('prueba.pdf');   
		return $pdf->setPaper('folio', 'portrait')->download("Formato Pedagógico General - Caracterizacion.pdf");
	}

}
