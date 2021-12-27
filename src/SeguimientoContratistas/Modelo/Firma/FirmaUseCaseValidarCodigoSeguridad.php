<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class FirmaUseCaseValidarCodigoSeguridad extends FirmaUseCase
{
   
    public function validarCodigoSeguridad(UsuarioResponse $usuarioResponse,$codigoSeguridad)
    {

        $datos = [
            'usuarios'=>[
                [
                    'usuario_id'=> $usuarioResponse->getIdResponse(),
                    'codigo_seguridad'=> $codigoSeguridad,
                ],
            ],                    
        ];
        #echo "<pre>".print_r( $datos,true)."</pre>";
        $response = $this->request('POST','/integration/radicado/codigo_seguridad/verificar', json_encode($datos));

        return  json_decode($response);
                
    }
}