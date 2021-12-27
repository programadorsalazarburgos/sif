<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoResponse;

class FirmaUseCaseFirmaElectronicaInforme extends FirmaUseCase
{

    public function firmaElectronicaInforme($radicado)
    {

        #echo '<pre>'.print_r($radicado->firmasToArray(),true).'</pre>'; 
        $response = $this->request('POST','/integration/radicado/validar', json_encode($radicado->firmasToArray()));
        #echo '<pre>'.print_r(json_decode($response),true).'</pre>'; 
        #echo '<pre>'.print_r(intval(json_decode($response)->isSucess),true).'</pre>';   
        #die();
        $responseFirma = json_decode($response);
        if(isset($responseFirma->isSucess)){
            return  intval($responseFirma->isSucess); 
        }else{
            return  intval($responseFirma->isSuccess); 
        }
    }

}