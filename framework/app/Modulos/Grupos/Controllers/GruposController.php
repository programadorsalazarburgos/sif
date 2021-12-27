<?php

namespace App\Modulos\Grupos\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modulos\Grupos\Interfaces\GruposInterface;

class GruposController extends Controller{

    public function __construct(GruposInterface $gruposRepository){
        $this->gruposRepository = $gruposRepository;
    }
}