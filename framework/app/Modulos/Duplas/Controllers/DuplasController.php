<?php

namespace App\Modulos\Duplas\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulos\Duplas\Interfaces\DuplasInterface;

class DuplasController extends Controller{

    public function __construct(DuplasInterface $duplasRepository){
        $this->duplasRepository = $duplasRepository;
    }

    public function getDuplas(Request $request){
        return $this->duplasRepository->getDuplas($request->tipo_dupla);
    }

    public function getDuplaAsignada(Request $request){
        return $this->duplasRepository->getDuplaAsignada($request->id_grupo);
    }

    public function getDuplaPersona(Request $request){
        return $this->duplasRepository->getDuplaPersona($request);
    }

    public function getDuplasGestor(Request $request){
        return $this->duplasRepository->getDuplasGestor($request);
    }

    public function crearDupla(Request $request){
        return $this->duplasRepository->crearDupla($request);
    }

    public function actualizarDupla(Request $request){
        return $this->duplasRepository->actualizarDupla($request);
    }

    public function inactivarDupla(Request $request){
        return $this->duplasRepository->inactivarDupla($request);
    }
}