<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class FirmaUseCaseConsultarExpediente extends FirmaUseCase
{
   
    public function consultarExpediente($iCedula,$anio)
    {
        $response = $this->request('GET','/integration/expedientes/consultar?titulo='.$iCedula.'&anio='.$anio, null);
        if(json_decode($response)->isSuccess){
            return json_decode($response)->Expedientes[0]->numero_expediente;
        }else{
            return false;
        }
                
    }
}