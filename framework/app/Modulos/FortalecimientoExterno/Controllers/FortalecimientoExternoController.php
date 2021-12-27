<?php

namespace App\Modulos\FortalecimientoExterno\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulos\FortalecimientoExterno\Interfaces\FortalecimientoExternoInterface;

class FortalecimientoExternoController extends Controller{

    public function __construct(FortalecimientoExternoInterface $fortalecimientoExternoRepository){
        $this->fortalecimientoExternoRepository = $fortalecimientoExternoRepository;
    }

    public function getOfertaFortalecimientoExterno(){
        return $this->fortalecimientoExternoRepository->getOfertaFortalecimientoExterno();
    }

    public function cambiarEstadoOferta(Request $request){
        return $this->fortalecimientoExternoRepository->cambiarEstadoOferta($request);
    }

    public function procesarOferta(Request $request){
        return $this->fortalecimientoExternoRepository->procesarOferta($request);
    }

    public function getGruposOferta(Request $request){
        return $this->fortalecimientoExternoRepository->getGruposOferta($request);
    }

    public function asignarDuplaGrupo(Request $request){
        return $this->fortalecimientoExternoRepository->asignarDuplaGrupo($request);
    }

    public function getSesionesGrupo(Request $request){
        return $this->fortalecimientoExternoRepository->getSesionesGrupo($request);
    }

    public function validarFechaSesion(Request $request){
        return $this->fortalecimientoExternoRepository->validarFechaSesion($request);
    }

    public function getParticipantesGrupo(Request $request){
        return $this->fortalecimientoExternoRepository->getParticipantesGrupo($request);
    }

    public function consultaEdicionAsistencia(Request $request){
        return $this->fortalecimientoExternoRepository->consultaEdicionAsistencia($request);
    }

    public function guardarAsistencia(Request $request){
        return $this->fortalecimientoExternoRepository->guardarAsistencia($request);
    }

    public function getOfertaActivaFortalecimientoExterno(){
        return $this->fortalecimientoExternoRepository->getOfertaActivaFortalecimientoExterno();
    }

    public function guardarSolicitud(Request $request){
        return $this->fortalecimientoExternoRepository->guardarSolicitud($request);
    }

    public function getInformacionParticipantes(Request $request){
        return $this->fortalecimientoExternoRepository->getInformacionParticipantes($request);
    }

    public function getCuposGruposOferta(Request $request){
        return $this->fortalecimientoExternoRepository->getCuposGruposOferta($request);
    }

    public function getReportePandora(Request $request){
        return $this->fortalecimientoExternoRepository->getReportePandora($request);
    }
}