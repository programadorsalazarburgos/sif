<?php

namespace App\Modulos\Crea\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Modulos\Parametros\Repository\ParametrosRepository;

class FichaCreaController  extends Controller {

    protected $parametrosRepository;

    public function __construct(
        ParametrosRepository $configuracion
    )
    {
        $this->parametrosRepository = $configuracion;
    }

	public function index(){
        return view('crea.infraestructura.index_ficha_crea');
    }

    public function store(Request $request){}

    public function data(Request $request){}

    public function editar($id){}

    public function actualizar(Request $request){}

    public function crear(Request $request){}

    public function show(){}
    

}
