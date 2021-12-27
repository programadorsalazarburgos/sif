<?php

namespace App\Modulos\TalentoHumano\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulos\TalentoHumano\Interfaces\TalentoHumanoInterface;

class TalentoHumanoController extends Controller{

    public function __construct(TalentoHumanoInterface $talentoHumanoRepository){
        $this->talentoHumanoRepository = $talentoHumanoRepository;
    }

    public function guardarHojadeVida(Request $request){
        return $this->talentoHumanoRepository->guardarHojadeVida($request);
    }

    public function getHojasVida(Request $request){
        return $this->talentoHumanoRepository->getHojasVida($request);
    }

    public function getEvaluacionHojasVida(Request $request){
        return $this->talentoHumanoRepository->getEvaluacionHojasVida($request);
    }

    public function guardarEvaluacionHojasVida(Request $request){
        return $this->talentoHumanoRepository->guardarEvaluacionHojasVida($request);
    }
}