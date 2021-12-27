<?php

namespace App\Modulos\Organizaciones\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Modulos\Organizaciones\Interfaces\InformeGestionInterface;
use App\Modulos\Parametros\Repository\ParametrosRepository;

class InformeGestionController  extends Controller {

    protected $parametrosRepository;

    public function __construct(
        InformeGestionInterface $informeGestionRepository,
        ParametrosRepository $configuracion
    )
    {
        $this->informeGestionRepository = $informeGestionRepository;
        $this->parametrosRepository = $configuracion;
    }

	public function index(){

        return view('organizaciones.index_informeGestion');

    }

    public function store(Request $request){}

    public function data(Request $request){
        return $this->informeGestionRepository->obtenerTabla($request->all());
    }

    public function editar($id){}

    public function actualizar(Request $request){}

    public function crear(Request $request){
        if (is_null($request['id_informe_hiden'])) {
            return $this->informeGestionRepository->crear($request->all());
        }else {
            return $this->informeGestionRepository->actualizar($request->all(),$request['id_informe_hiden']);
        } 
    }

    public function show(){}

    public function getOrganizaciones(){
        return $this->informeGestionRepository->getOrganizaciones();
    }

    public function getInformeGestion(Request $request){
        return $this->informeGestionRepository->getInformeGestion($request->all());
    }

    public function obtenerParametro(Request $request){
        return $this->parametrosRepository->obtenerParametro($request->FK_Id_Parametro);
	}

    public function registerApproval(Request $request){
        return $this->informeGestionRepository->registerApproval($request->all());
	}

    public function validateDate(Request $request){
        return $this->informeGestionRepository->validateDate($request->all());
	}

    public function newReport(Request $request){
		return $this->informeGestionRepository->newReport($request->all());
	}

    public function pdfInformeGestion($idInforme){
        return $this->informeGestionRepository->pdfInformeGestion($idInforme);
    }

}
