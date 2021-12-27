<?php
namespace SeguimientoContratistas\Modelo\Firma; 

use GuzzleHttp\Client;
use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;
use SeguimientoContratistas\Modelo\Firma\RadicadoFirmaResponse;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseObtenerUsuario;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseRadicarInforme;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseSolicitarCodigo;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseIncluirExpediente;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseConsultarExpediente;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseValidarCodigoSeguridad;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseFirmaElectronicaInforme;
use SeguimientoContratistas\Modelo\Firma\FirmaUseCaseAsociarDocumentoPrincipal;

class FirmaElectronicaService
{

    public function __construct()
    {
        
    } 

    public function obtenerUsuarioResponse($iCedula)
    {
        $obtenerUsuario = new FirmaUseCaseObtenerUsuario();
        return $obtenerUsuario->obtenerUsuarioResponse($iCedula);	   
    }

    
    public function solicitarCodigoSeguridad(UsuarioResponse $usuarioResponse)
    {        
        $solicitarFirma = new FirmaUseCaseSolicitarCodigo();
        if($solicitarFirma != false){
            return $solicitarFirma->solicitarCodigoSeguridad($usuarioResponse);        
        }else{
            return false;
        }
    }

    public function radicarInformePago(InformePago $informePago, UsuarioResponse $usuarioActual, $historicoInformePago)
    {
        $historico = $this->mapearUsuariosHistorico($historicoInformePago);
        $radicarInforme = new FirmaUseCaseRadicarInforme();
        return $radicarInforme->radicarInformePago($informePago,$usuarioActual, $historico);          
    }
    
    private function mapearUsuariosHistorico($historicoInformePago)
    {
        $historico = [];
        foreach($historicoInformePago as $observacionFirma)
        {
            $usuarioResponse = $this->obtenerUsuarioResponse($observacionFirma["VC_Identificacion"]);
            $observacion = $observacionFirma["VC_Observacion"];
            if(strlen($observacionFirma["VC_Observacion"]) == 0 ){
                if($observacionFirma["VC_Transaccion"] == "PROYECTADO"){
                    $observacion = "Contratista proyecta el informe de pago desde el modulo de informe de pago";
                }else if($observacionFirma["VC_Transaccion"] == "REVISADO"){
                    $observacion = "Apoyo a supervisión valida el informe de pago desde el modulo de informe de pago"; 
                }else if($observacionFirma["VC_Transaccion"] == "APROBADO"){
                    $observacion = "supervisión valida el informe de pago desde el modulo de informe de pago"; 
                }else if($observacionFirma["VC_Transaccion"] == "DEVUELTO"){
                    $observacion = "supervisión o apoyo devuelve el informe de pago desde el modulo de informe de pago"; 
                }
            }

            $historico[] = [
                "usuario_id"=>$usuarioResponse->getIdResponse(),
                "transaccion"=>$observacionFirma["VC_Transaccion"],
                "observacion"=> $observacion,
                "fecha"=>$observacionFirma["DT_Date"],
            ];
        }

        return $historico;
    } 

    public function asociarDocumentoPrincipal(RadicadoResponse $radicado)
    {
        $radicarInforme = new FirmaUseCaseAsociarDocumentoPrincipal();
        return $radicarInforme->asociarDocumentoPrincipal($radicado);          
    }    
    
    public function consultarExpediente($iCedula,$anio){
        $consultaExpediente = new FirmaUseCaseConsultarExpediente();
        return $consultaExpediente->consultarExpediente($iCedula,$anio);        
    }

    public function incluirExpediente(RadicadoResponse $radicado)
    {
        $radicarInforme = new FirmaUseCaseIncluirExpediente();
        return $radicarInforme->incluirExpediente($radicado);          
    }  
    
    public function asociarAnexosRadicado(RadicadoResponse $radicado)
    {
        $radicarInforme = new FirmaUseCaseAsociarAnexosRadicado();
        return $radicarInforme->asociarAnexosRadicado($radicado);          
    }   
    
    public function firmaElectronicaInforme($arreglofirmas,$informePago)
    {
        $radicarInforme = new FirmaUseCaseFirmaElectronicaInforme();
        $firmas = $this->mapearFirmas($arreglofirmas);
        $radicado = new RadicadoResponse(
            $informePago['VC_orfeo_radicado'],
            $informePago['VC_orfeo_codigo_verificacion'],
            $informePago['VC_orfeo_radicado_anexo'],
            $firmas,
            $informePago['DT_orfeo_fecha']
        );
        return $radicarInforme->firmaElectronicaInforme($radicado);          
    }       
 
    public function mapearFirmas($firmas)
    {
        $firmasResponse = [];
        foreach($firmas as $firma)
        {
            #var_dump(intval($firma['FK_usuario_orfeo']));
            #die();
            $firmasResponse[] = new RadicadoFirmaResponse(
                new UsuarioResponse(intval($firma['FK_usuario_orfeo'])),
                $firma['VC_Token'],
                $firma['VC_sistema_operativo'],
                $firma['VC_navegador'],
                $firma['VC_navegador_version'],
                $firma['VC_direccion_ip'],               
            );
        }
        return $firmasResponse;
    } 
    
    public function consultarRadicado($numeroRadicado,$codigoVerificacion)
    {
        $consultaRadicado = new FirmaUseCaseConsultarRadicado();
        return $consultaRadicado->consultarRadicado($numeroRadicado,$codigoVerificacion);	   
    }    

    public function validarCodigoSeguridad(UsuarioResponse $usuarioResponse,$codigoSeguridad)
    {        
        $validarCodigo = new FirmaUseCaseValidarCodigoSeguridad();
        return $validarCodigo->validarCodigoSeguridad($usuarioResponse,$codigoSeguridad);   
    }    

}