<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoDocumentoResponse;

class FirmaUseCaseAsociarAnexosRadicado extends FirmaUseCase
{

    public function asociarAnexosRadicado(RadicadoResponse $radicado)
    {
        $documentosSubidos = 0;
		#echo '<pre>'.print_r($radicado->getAnexos(),true).'</pre>';
		#die();         
        foreach($radicado->getAnexos() as $documento)
        {
            $documentosSubidos += $this->subirAnexoRadicado($radicado, $documento) ? 1 : 0;
        }
        #die();  
        return $documentosSubidos;
    }


    private function subirAnexoRadicado(RadicadoResponse $radicado, RadicadoDocumentoResponse $documento )
    {

        $datos = [
            'radicado' => $radicado->getNumeroRadicado(),
            'anexo_file'=> new \CURLFILE($documento->getRuta()),
            'usuario_id' => $radicado->getInformePago()->getUsuarioRadicador()->getIdResponse(),
            'tipo_radicado' => '4',
            'descripcion' => $documento->getDescripcion(),
            'codigo_aplicacion' => '9',
            'solo_lectura' => 'S',
            'codigo_verificacion' => $radicado->getCodigoVerificacion(),
        ];
        #echo '<pre>'.print_r($datos,true).'</pre>';  
        $response = $this->request('POST','/integration/anexos/add',$datos, false);      
        #echo '<pre>'.print_r(json_decode($response),true).'</pre>';    
        return json_decode($response)->isSuccess;       
    }
    

}