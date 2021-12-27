<?php
namespace Territorial\Controlador;
use General\Controlador\ControladorBase;

use General\Persistencia\DAOS\OptionsDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\NidosLugaresDAO;
use General\Persistencia\DAOS\NidosDuplasDAO;
use General\Persistencia\DAOS\NidosPersonaTerritorioDAO;
use General\Persistencia\DAOS\NidosConsultaGeneralDAO;
use General\Persistencia\Entidades\TbNidosLugarAtencion;
use General\Persistencia\Entidades\TbNidosDupla;
use General\Persistencia\Entidades\TbNidosPersonaTerritorio;
use General\Persistencia\Entidades\TbNidosGrupos;

class TerritorialFactory extends ControladorBase
{
	protected function initializeFactory()
	{
    $this->contenedor['GrupoDAO'] = function ($c) {
        return new GrupoDAO();
    };
    $this->contenedor['OptionsDAO'] = function ($c) {
        return new OptionsDAO();
    };
    $this->contenedor['NidosLugaresDAO'] = function ($c) {
      return new NidosLugaresDAO();
    };
    $this->contenedor['TbNidosLugarAtencion'] = function ($c) {
      return new TbNidosLugarAtencion();
    };
		$this->contenedor['NidosDuplasDAO'] = function ($c) {
			return new NidosDuplasDAO();
		};
		$this->contenedor['TbNidosDupla'] = function ($c) {
			return new TbNidosDupla();
		};
		$this->contenedor['NidosPersonaTerritorioDAO'] = function ($c) {
			return new NidosPersonaTerritorioDAO();
		};
		$this->contenedor['TbNidosPersonaTerritorio'] = function ($c) {
			return new TbNidosPersonaTerritorio();
		};
    $this->contenedor['NidosConsultaGeneralDAO'] = function ($c) {
			return new NidosConsultaGeneralDAO();
		};
		$this->contenedor['TbNidosGrupos'] = function ($c) {
			return new TbNidosGrupos();
		};
	}
}
