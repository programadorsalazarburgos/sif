<?php

namespace App\Modulos\Personas\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Modulos\Personas\Interfaces\PersonaInterface;

class PersonaController  extends Controller {

    protected $personaRepository;

    public function __construct(
        PersonaInterface $personaRepository
    )
    {
        $this->personaRepository = $personaRepository;
    }

    public function index(){}
    public function store(Request $request){}
    public function data(Request $request){}
    public function editar($id){}
    public function actualizar(Request $request){}
    public function crear(Request $request){}
    public function show(){}

    public function getApoyoSupervision(Request $request){
        
        return $this->personaRepository->getUsuariosRol($request);

    }

    public function getSupervision(Request $request){
        
        return $this->personaRepository->getUsuariosRol($request);

    }

    public function getRolPersona(Request $request){
        return $this->personaRepository->getRolPersona($request);        
    }

    public function getArtistasPorLineaNidos(Request $request){
        return $this->personaRepository->getArtistasPorLineaNidos($request);        
    }

    public function getTerritorioPersonaNidos(Request $request){
        return $this->personaRepository->getTerritorioPersonaNidos($request);        
    }

}
