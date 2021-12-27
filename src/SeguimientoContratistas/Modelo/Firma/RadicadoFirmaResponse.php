<?php
namespace SeguimientoContratistas\Modelo\Firma;

use SeguimientoContratistas\Modelo\Firma\UsuarioResponse;

class RadicadoFirmaResponse
{
    private $usuarioResponse;
    private $codigoSeguridad;
    private $sistemaOperativo;
    private $navegador;
    private $direccionIp;
    private $navegadorVersion;
    private $urlAplicacion = "https://pandora.idartes.gov.co";
    private $ciudad = "BOGOTÁ D.C.";
    private $pais = "CO";
    private $ubicacionGeografica = "";


    public function __construct(
        UsuarioResponse $usuarioResponse,
        String $codigoSeguridad,
        String $sistemaOperativo,
        String $navegador,
        String $navegadorVersion,
        String $direccionIp
    )
    {
        $this->usuarioResponse = $usuarioResponse;
        $this->codigoSeguridad = $codigoSeguridad;
        $this->sistemaOperativo = $sistemaOperativo;
        $this->navegador = $navegador;
        $this->direccionIp = $direccionIp;
    }

    public function toArray()
    {
        return [
            "usuario_id"=> $this->usuarioResponse->getIdResponse(),
            "codigo_seguridad"=> $this->codigoSeguridad,
            "sistema_operativo"=> $this->sistemaOperativo,
            "navegador_web"=> $this->navegador,
            "direccion_ip"=> $this->direccionIp,
            "navegador_version"=> $this->navegadorVersion,
            "url_aplicacion"=> $this->urlAplicacion,
            "ciudad"=> $this->ciudad,
            "pais"=> $this->pais,
            "ubicacion_geografica"=> $this->ubicacionGeografica,

        ];
    }
        
}