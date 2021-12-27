<?php

namespace App\Modulos\Parametros\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulos\Parametros\Interfaces\ParametrosInterface;

class ParametrosController extends Controller{

    public function __construct(ParametrosInterface $parametrosRepository){
        $this->parametrosRepository = $parametrosRepository;
    }

    public function getParametroDetalle(Request $request){
        return $this->parametrosRepository->getParametroDetalle($request);
    }
}