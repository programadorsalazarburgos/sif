<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class FirmaUseCaseIncluirExpediente extends FirmaUseCase
{
   
    public function incluirExpediente(RadicadoResponse $radicado)
    {
       
        $parametros = 'radicado='.
                        $radicado->getNumeroRadicado().'&codigo_verificacion='.
                        $radicado->getCodigoVerificacion().'&numero_expediente='.
                        $radicado->getInformePago()->getExpediente().'&usuario_id='.
                        $radicado->getInformePago()->getUsuarioRadicador()->getIdResponse();
        $response = $this->request('POST','/integration/expedientes/incluir?'.$parametros, null, false);  	            
        return !json_decode($response)->error;
                
    }
}