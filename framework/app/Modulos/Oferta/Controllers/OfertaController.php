<?php

namespace App\Modulos\Oferta\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulos\Oferta\Interfaces\OfertaInterface;
use App\Modulos\Grupos\Interfaces\GruposInterface;

class OfertaController extends Controller{

    public function __construct(OfertaInterface $ofertaRepository, GruposInterface $gruposRepository){
        $this->ofertaRepository = $ofertaRepository;
        $this->gruposRepository = $gruposRepository;
    }


    public function getLocalidadesOfertaDisponible(Request $request){
        return $this->ofertaRepository->getLocalidadesOfertaDisponible($request);
    }

    public function getOptionsOfertaDisponible(Request $request){
        return $this->gruposRepository->getOptionsOfertaDisponible($request);
    }

    public function guardarPreinscripcion(Request $request){
        return $this->ofertaRepository->guardarPreinscripcion($request);
    }

    public function getGrupos(Request $request){
        return $this->gruposRepository->getGrupos($request);
    }

    public function getPreinscritosGrupo(Request $request){
        return $this->ofertaRepository->getPreinscritosGrupo($request);
    }

    public function getCuposGrupo(Request $request){
        return $this->gruposRepository->getCuposGrupo($request);
    }

    public function aprobarPreinscripcion(Request $request){
        return $this->ofertaRepository->aprobarPreinscripcion($request);
    }
    
    public function rechazarPreinscripcion(Request $request){
        return $this->ofertaRepository->rechazarPreinscripcion($request);
    }
}