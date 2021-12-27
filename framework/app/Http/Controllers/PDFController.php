<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PDFController extends Controller
{
   public  function PDF()
   {
    //    $pdf = \PDF::loadView('prueba')->setPaper('a4', 'landscape');
    //    return $pdf->download('prueba.pdf');

       
       $pdf = \PDF::loadView('prueba')->setPaper('a4', 'landscape');

       return $pdf->stream('prueba.pdf');
   }
}
