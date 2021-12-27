<?php

namespace App\Modulos\Organizaciones\Repository;

use App\Modulos\Organizaciones\Interfaces\InformeGestionInterface;
use App\Modulos\Organizaciones\InformeGestion;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\Organizaciones\Organizacion;
use App\Modulos\Organizaciones\InformeGestionV1;
use App\Modulos\Organizaciones\Convenios;
use PDF;
use App\Modulos\Parametros\ParametroDetalles;

class InformeGestionRepository implements InformeGestionInterface
{

	public function __construct(){}

	public function crear($data){

		$informeGestion = new InformeGestionV1;

		if (!is_null($data['id_convenio_hidden'])) {
			$convenio = Convenios::find($data['id_convenio_hidden']);
		}else{
			$convenio = new Convenios;
		}

		return $this->procesar($informeGestion, $convenio, $data);

	}

	public function dataTable($relaciones=[]){}
	public function show($relaciones=[]){}

	public function actualizar($request, $id){
		//dd($id);
		$informeGestion = InformeGestionV1::find($id);
		//dd($informeGestion);
		$convenio = Convenios::find($informeGestion->fk_convenio);
		return $this->procesar($informeGestion, $convenio, $request);
	}

	public function obtener($id, $relaciones = []){}
	public function eliminar($id){}
	public function obtenerTodo( $relaciones = []){}

	public function procesar($informeGestion, $convenio, $data){
		
		$convenio->fk_id_tipo_contrato = $data['idTipoContrato'];
		$convenio->vc_numero_contrato = $data['txNumeroContrato'];
		$convenio->dt_acta_ini = $data['dateActaInicio'];
		$convenio->dt_term = $data['dateActaTerminacion'];
		$convenio->vc_areas = $data['idArea'];
		$convenio->vc_proyecto = $data['nombreProyecto'];
		$convenio->fk_id_organizacion = $data['idOrganizacion'];
		$convenio->vc_representante = $data['representanteLegal'];
		$convenio->fk_id_supervisor = $data['idSupervisor'];
		$convenio->fk_id_apoyo = $data['idApoyo'];
		$convenio->vc_objeto = $data['txObjeto'];
		$convenio->vc_email = $data['txEmail'];
		$convenio->in_estado = 1;
		$convenio->save();
		
		$informeGestion->fk_convenio = $convenio->pk_id_tabla;
		$informeGestion->vc_ini_info = $data['numInforme'];
		$informeGestion->vc_fin_info = $data['numInformeFin'];
		$informeGestion->dt_periodo_ini = $data['datePeriodoIni'];
		$informeGestion->dt_periodo_fin = $data['datePeriodoFin'];
		
		if(isset($data['selectTipoObligacion'])){

			foreach ($data['selectTipoObligacion'] as $key => $tipoObligacion) {
				$content[] = [
					'id' => $key,
					'tipo_Obligacion' => $tipoObligacion,
					'obligaciones_Contrato' => $data['txObligacion'][$key],
					'actividades' => $data['txActividad'][$key],
					'descripcion' => $data['txDetalle'][$key],
					'soportes' => $data['txAnexos'][$key],
				];
			}
			
			$informeGestion->tx_detalle_actividad = json_encode($content);

		}
		if (isset($data['txProducto'])) {

			foreach ($data['txProducto'] as $key => $producto) {
				$products[] = [
					'id' => $key,
					'Producto' => $producto,
					'Mecanismo' => $data['txMecanismo'][$key],
				];
			}
			
			$informeGestion->tx_detalle_producto = json_encode($products);

		}

		$informeGestion->vc_concluciones = $data['txConclusiones'];

		if(isset($data['txLink'])){

			foreach ($data['txLink'] as $key => $link) {
				$links[] = [
					'id' => $key,
					'link' => $data['txLink'][$key],
				];
			}
			$informeGestion->tx_detalle_link = json_encode($links);

		}
		
		if(isset($data['check'])){
			$informeGestion->in_estado_final = 1;
		}else{
			$informeGestion->in_estado_final = 0;
		}
		
		$informeGestion->save();

		$rta = true;

		return response()->json($rta, 200);

	}

	public function obtenerTabla($request)
	{
		
		$dataOrganizacion = Organizacion::where('FK_Coordinador', $request['id_persona'])->first();
		
		if (isset($request['tipoInforme']) && !is_null($request['filtroIni']) && !is_null($request['filtroFin']) || $dataOrganizacion == null)
		{
			
			if ($dataOrganizacion == null) 
			{
				
				if (!empty($request['id_persona'])) 
				{
					$informes = collect([]);

					if (isset($request['tipoInforme'])) {
						if ($request['tipoInforme'] == 0) {//propios
							$convenios = Convenios::where('fk_id_supervisor', $request['id_persona'])->orWhere('fk_id_apoyo', $request['id_persona'])->get();
							foreach ($convenios as $key => $convenio) {
								if ($request['estado'] == 0) { //Aprobado
									$gestion = InformeGestionV1::with('convenio.organizacion','convenio')
												->where('fk_convenio', $convenio->pk_id_tabla)
												->where('in_aprobacion', 1)
												->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
												->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
												->get();
								}
								if ($request['estado'] == 1) { //Sin Aprobar
									$gestion = InformeGestionV1::with('convenio.organizacion','convenio')
												->where('fk_convenio', $convenio->pk_id_tabla)
												->where('in_aprobacion', null)
												->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
												->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
												->get();
								}
								if ($request['estado'] == 2) { //Rechazados
									$gestion = InformeGestionV1::with('convenio.organizacion','convenio')
												->where('fk_convenio', $convenio->pk_id_tabla)
												->where('in_aprobacion', 0)
												->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
												->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
												->get();
								}

								
								
							}
							
							if($gestion->count()>0){
								$informes = $gestion;
							}else{
								$informes = collect([]);
							}
						}else{ //Supervisar
							$convenios = Convenios::where('fk_id_supervisor', $request['id_persona'])->orWhere('fk_id_apoyo', $request['id_persona'])->get();
							foreach ($convenios as $key => $convenio) {
								if ($request['estado'] == 0) { //Aprobado
									$gestion = InformeGestionV1::with('convenio.organizacion','convenio')
												->where('fk_convenio', $convenio->pk_id_tabla)
												->where('in_aprobacion', 1)
												->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
												->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
												->get();
								}
								if ($request['estado'] == 1) { //Sin Aprobar
									$gestion = InformeGestionV1::with('convenio.organizacion','convenio')
												->where('fk_convenio', $convenio->pk_id_tabla)
												->where('in_aprobacion', null)
												->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
												->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
												->get();
								}
								if ($request['estado'] == 2) { //Rechazados
									$gestion = InformeGestionV1::with('convenio.organizacion','convenio')
												->where('fk_convenio', $convenio->pk_id_tabla)
												->where('in_aprobacion', 0)
												->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
												->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
												->get();
								}
								
							}	
							//dd($gestion);
							if($gestion->count()>0){
								$informes = $gestion;
							}else{
								$informes = collect([]);
							}
						} 
					}else{
						$consulta = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($request){
							$query->where('fk_id_supervisor', $request['id_persona'])->orWhere('fk_id_apoyo', $request['id_persona']);
						}])->where('in_estado_final', 1)
							->where('in_aprobacion', null)
							->get();
						
						foreach ($consulta as $key => $value) 
						{
	
							if (!is_null($value->convenio)) 
							{
								$informes->push($value);
							}
						}
					}
					
				}
				else
				{
					$informes = collect([]);
				}
			}
			else
			{
				if ($request['tipoInforme'] == 0) {//propios

					if ($request['estado'] == 0) { //Aprobado

						$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
							$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
						}])
						->where('in_aprobacion',1)
						->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
						->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
						->get();

					}
					if ($request['estado'] == 1) { //Sin Aprobar

						$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
							$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
						}])
						->where('in_aprobacion',null)
						->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
						->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
						->get();
					}
					if ($request['estado'] == 2) { //Rechazados

						$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
							$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
						}])
						->where('in_aprobacion',0)
						->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
						->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
						->get();

					}

				}else{

					if ($request['estado'] == 0) { //Aprobado

						$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
							$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
						}])
						->where('in_aprobacion',1)
						->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
						->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
						->get();

					}
					if ($request['estado'] == 1) { //Sin Aprobar

						$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
							$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
						}])
						->where('in_aprobacion',null)
						->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
						->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
						->get();
					}
					if ($request['estado'] == 2) { //Rechazados

						$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
							$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
						}])
						->where('in_aprobacion',0)
						->whereDate('dt_periodo_ini','<=', $request['filtroIni'])
						->whereDate('dt_periodo_fin','>=',$request['filtroFin'])
						->get();

					}

				}
				
			}

		}else {
			
			if (!empty($request['id_persona'])) {
			
				$informes = InformeGestionV1::with(['convenio.organizacion','convenio'=>function($query) use($dataOrganizacion){
					$query->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion']);
				}])->get();
				
			}else{
				$informes = collect([]);
			}
								
		}
		
		return response()->json(json_decode($informes), 200);
		
	}

	public function getOrganizaciones(){

		$organizaciones = Organizacion::all();
		
		foreach ($organizaciones as $key => $organizacion) {
			
			$data[] = [
				'value' => $organizacion->PK_Id_Organizacion,
				'text' => $organizacion->VC_Nom_Organizacion,
			];
			
		}
		
		return response()->json($data);
	}

	public function getInformeGestion($request){
		
		$informe = InformeGestionV1::where('pk_id_tabla', $request['idInforme'])->with(['convenio.organizacion'])->first();
		
		$data = [
			'informeGestion' => $informe,
			'detalleActividad' => json_decode($informe->tx_detalle_actividad),
			'productos' => json_decode($informe->tx_detalle_producto),
			'links' => json_decode($informe->tx_detalle_link),
		];
		
		return response()->json($data, 200);
	}

	public function registerApproval($request){
		
		$informe = InformeGestionV1::where('pk_id_tabla', $request['id_informe'])->with(['convenio.organizacion'])->first();
		$informe->tx_observacion = $request['observacionApprove'];
		$informe->in_aprobacion = ($request['checkApprove'] === true) ? 1 : 0;
		$informe->save();

		$rta = true;
        
		return response()->json($rta, 200);
	}

	public function validateDate($request){

		$informe = InformeGestionV1::whereDate('dt_periodo_ini','>=',$request['fechaIni'])->whereDate('dt_periodo_fin','<=',$request['FechaFin'])->first();

		if (!is_null($informe)) {

			$rta = true;
			return response()->json($rta, 200);

		}
		
	}

	public function newReport($request){
		
		$dataOrganizacion = Organizacion::where('FK_Coordinador', $request['id_persona'])->first();
		
		if (!is_null($dataOrganizacion)) {

			$convenio = Convenios::with('informesGestion')->where('fk_id_organizacion', $dataOrganizacion['PK_Id_Organizacion'])->first();
			
			if (!is_null($convenio)) {

				$data = [
					'convenio' => $convenio,
					'informeGestion' => $convenio->informesGestion,
					'detalleActividad' => json_decode($convenio->informesGestion[0]->tx_detalle_actividad),
					'productos' => json_decode($convenio->informesGestion[0]->tx_detalle_producto),
					'links' => json_decode($convenio->informesGestion[0]->tx_detalle_link),
				];
				
				return response()->json($data, 200);

			}
			
		}

	}

	public function pdfInformeGestion($idInforme){
		
		$informe = InformeGestionV1::where('pk_id_tabla', $idInforme)->with(['convenio.organizacion.coordinador.dataExtra','convenio.tipoContrato','convenio.supervisor','convenio.apoyoSupervision'])->first();
		
		$cadena = explode(",", $informe->convenio->vc_areas);
		$arrayAreas = [];
		foreach ($cadena as $key => $area) {
			$arrayAreas[] = ParametroDetalles::where('PK_Id_Tabla',$area) 
                				->where('IN_Estado',1)->first();
		}
		foreach ($arrayAreas as $key => $dataAreas) {
			$areas[] = $dataAreas->VC_Descripcion;
		}
		
		$areasImp = implode(",", $areas);

		$obligaciones = json_decode($informe->tx_detalle_actividad);

		$datos = [        
			'informe' => $informe,
			'detalleActividad' => json_decode($informe->tx_detalle_actividad),
			'productos' => json_decode($informe->tx_detalle_producto),
			'links' => json_decode($informe->tx_detalle_link),
			'areas' => $areasImp,
		]; 
		
		$view = view('organizaciones.pdf_informe_gestion',$datos)->render();
		$pdf = PDF::loadHTML($view);
		//$pdf = \PDF::loadView('organizaciones.pdf_informe_gestion',  ['datos' => $informe]);
		
		//return $pdf->stream('prueba.pdf');   
		return $pdf->setPaper('folio', 'portrait')->download("Informe de Gestión Organizaciones.pdf"); 
	}

}
