<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\FirmaUseCase;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoDocumentoResponse;

class FirmaUseCaseAsociarDocumentoPrincipal extends FirmaUseCase
{

    public function asociarDocumentoPrincipal(RadicadoResponse $radicado)
    {
        $documentosActualizados = [];
        foreach($radicado->getDocumentos() as $documento)
        {
            if($documento->getEsPrincipal())
            {
                $documentosActualizados[] = $this->subirDocumentoPrincipal($radicado, $documento);
            }else{
                $documentosActualizados[] = $documento;
            }
        }
        $radicado->setDocumentos($documentosActualizados);
        return $radicado;
    }


    private function subirDocumentoPrincipal(RadicadoResponse $radicado, RadicadoDocumentoResponse $documento )
    {
        $datos = [
            'radicado' => $radicado->getNumeroRadicado(),
            'codigo_verificacion' => $radicado->getCodigoVerificacion(),
            'radicado_file'=> new \CURLFILE($documento->getRuta()),
            'usuario_id' => $radicado->getInformePago()->getUsuarioRadicador()->getIdResponse(),
            'anexo_principal' => 'SI',
            'paginas' => $documento->getPaginas(),
            'descripcion' => $documento->getDescripcion(),
            'codigo_aplicacion' => '9',
            'solo_lectura' => $documento->getSoloLectura()
        ];
        $response = $this->requestFiles('POST','/integration/radicado/documento', $datos);
        return $documento->setAnexoId(json_decode($response)->anexo_id);       
    }

}