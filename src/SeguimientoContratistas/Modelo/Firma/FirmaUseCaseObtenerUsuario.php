<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class FirmaUseCaseObtenerUsuario extends FirmaUseCase
{
   
    public function obtenerUsuarioResponse($iCedula)
    {
        $response = $this->request('GET','/integration/usuarios?usuario_cc='.$iCedula, null);
        if(count((array) json_decode($response)->Usuarios)>0){
            return new UsuarioResponse(json_decode($response)->Usuarios[0]);        
        }else{
            return false;
        }
    }
}