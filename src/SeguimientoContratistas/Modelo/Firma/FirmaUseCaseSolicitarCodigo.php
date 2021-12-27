<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class FirmaUseCaseSolicitarCodigo extends FirmaUseCase
{

    public function solicitarCodigoSeguridad(UsuarioResponse $usuarioResponse)
    {
        $datos = [
            'usuarios'=>[
                [
                    'usuario_id'=> $usuarioResponse->getIdResponse()
                ],
            ],                    
        ];
        $response = $this->request('POST','/integration/radicado/codigo_seguridad', json_encode($datos));
		return  json_decode($response)->isSuccess;        
    }
}