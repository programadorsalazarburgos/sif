<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class FirmaUseCaseConsultarRadicado extends FirmaUseCase
{
   
    public function consultarRadicado($numeroRadicado,$codigoVerificacion)
    {

        $datos = [
            'radicados'=>[
                [
                    'numero_radicado'=> $numeroRadicado,
                    'codigo_verificacion'=> $codigoVerificacion,
                ],
            ],                    
        ];
        $response = $this->request('POST','/integration/radicado/consultar', json_encode($datos));

        if(json_decode($response)->isSuccess){
            return json_decode($response)->informacion[0];
        }else{
            return false;
        }
                
    }
}