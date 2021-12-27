<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoHistoricoResponse;

class FirmaUseCaseRadicarInforme extends FirmaUseCase
{

    public function radicarInformePago(InformePago $informePago, UsuarioResponse $usuarioActual, $historicoInformePago)
    {

        #echo "<pre>".print_r(json_encode($historicoInformePago),true)."</pre>"; 
  
        $radicado = new RadicadoResponse($informePago,$usuarioActual,$historicoInformePago);
        $response = $this->request('POST','/radicado/radicar', json_encode($radicado->toArray()));
        #echo "<pre>".print_r(json_encode($response),true)."</pre>";
        #die();
        $radicado->completarRadicado(json_decode($response));
		return  $radicado; 
    }



}