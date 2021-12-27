<?php

namespace App\Modulos\ComponentePedagogico\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modulos\ComponentePedagogico\Interfaces\FormatoPedagogicoInterface;
use App\Modulos\Parametros\Repository\ParametrosRepository;

class formatoPedagogicoController extends Controller
{

    

    public function __construct(
        FormatoPedagogicoInterface $formatoPedagogicoRepository,
        ParametrosRepository $configuracion
    )
    {
        $this->formatoPedagogicoRepository = $formatoPedagogicoRepository;
        $this->parametrosRepository = $configuracion;
    }

	public function index(){
        return view('crea.componentePedagogico.formato_pedagogico_general');
    }

    public function store(Request $request){}

    public function data(Request $request){
        return $this->formatoPedagogicoRepository->data($request->all());
    }

    public function editar($id){}
    public function actualizar(Request $request){}

    public function crear(Request $request){
        if (is_null($request['id_planeacion_hidden'])) {
            return $this->formatoPedagogicoRepository->crear($request->all());
        }else {
            return $this->formatoPedagogicoRepository->actualizar($request->all(),$request['id_planeacion_hidden']);
        } 
    }

    public function show(){}

    public function getGruposXLinea(Request $request) {
        return $this->formatoPedagogicoRepository->getGruposXLinea($request);
    }

    public function getInformacionGrupo(Request $request) {
        return $this->formatoPedagogicoRepository->getInformacionGrupo($request);
    }
    
    public function guardarCaracterizacionGrupo(Request $request){
        if (is_null($request['hidden_caracterizacion'])) {
            return $this->formatoPedagogicoRepository->guardarCaracterizacionGrupo($request);
        }else {
            return $this->formatoPedagogicoRepository->actualizarCaracterizacionGrupo($request->all(),$request['hidden_caracterizacion']);
        } 
    }

    public function indexPlaneacion(){
        return view('crea.componentePedagogico.formatoPedagogicoPlaneacion');
    }

    public function getInfoTable(Request $request) {
        return $this->formatoPedagogicoRepository->getInfoTable($request->all());
    }

    public function guardarPlaneacionGrupo(Request $request) {
        return $this->formatoPedagogicoRepository->guardarPlaneacionGrupo($request);
    }

    public function obtenerParametro(Request $request){
        return $this->parametrosRepository->obtenerParametro($request->FK_Id_Parametro);
	}

    public function getCaracterizacion(Request $request){
        return $this->formatoPedagogicoRepository->getCaracterizacion($request->all());
    }

    public function crearIc(Request $request){
        
        if (is_null($request['id_impulso_hidden'])) {
            return $this->formatoPedagogicoRepository->crearIc($request->all());
        }else {
            return $this->formatoPedagogicoRepository->actualizarIc($request->all(),$request['id_impulso_hidden']);
        } 
    }

    public function crearCv(Request $request){
        
        if (is_null($request['id_converge_hidden'])) {
            return $this->formatoPedagogicoRepository->crearCv($request->all());
        }else {
            return $this->formatoPedagogicoRepository->actualizarCv($request->all(),$request['id_converge_hidden']);
        } 
    }

    public function getPlaneacion(Request $request) {
        return $this->formatoPedagogicoRepository->getPlaneacion($request->all());
    }

    public function getCaracterizacionEdit(Request $request) {
        return $this->formatoPedagogicoRepository->getCaracterizacionEdit($request->all());
    }

    public function registerApproval(Request $request){
        return $this->formatoPedagogicoRepository->registerApproval($request->all());
	}

    public function indexAnalisis(){
        return view('crea.componentePedagogico.formatoAnalisisFormativo');
    }

    public function getInfoTableAnalisis(Request $request) {
        return $this->formatoPedagogicoRepository->getInfoTableAnalisis($request->all());
    }

    public function crearAnalisis(Request $request) {
        
        if (is_null($request['id_valoracion_hidden'])) {
        
            return $this->formatoPedagogicoRepository->crearAnalisis($request->all());
        }else{
            return $this->formatoPedagogicoRepository->updateAnalisis($request->all(), $request['id_valoracion_hidden']);
        }
        
    }
    
    public function dataAnalisis(Request $request){
        return $this->formatoPedagogicoRepository->dataAnalisis($request->all());
    }

    public function getAnalisis(Request $request) {
        return $this->formatoPedagogicoRepository->getAnalisis($request->all());
    }

    public function registerApprovalAnalisis(Request $request){
        return $this->formatoPedagogicoRepository->registerApprovalAnalisis($request->all());
    }

    public function pdfPlaneacion($idInforme, $idLinea){
        return $this->formatoPedagogicoRepository->pdfPlaneacion($idInforme, $idLinea);
    }

    public function pdfValoracion($idInforme, $idLinea){
        return $this->formatoPedagogicoRepository->pdfValoracion($idInforme, $idLinea);
    }

    public function pdfProceso($idInforme, $idLinea){
        return $this->formatoPedagogicoRepository->pdfProceso($idInforme, $idLinea);
    }

    public function registerApprovalCaracter(Request $request){
        return $this->formatoPedagogicoRepository->registerApprovalCaracter($request->all());
	}

    public function pdfCaracterizacion($idInforme, $idLinea){
        return $this->formatoPedagogicoRepository->pdfCaracterizacion($idInforme, $idLinea);
    }
    
}
