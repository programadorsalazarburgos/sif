<?php
namespace PedagogicoCREA\Controlador;
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\PedagogicoDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\Entidades\TbCaracterizacionGrupo;
use General\Persistencia\Entidades\TbPlaneacionGrupo;
use General\Persistencia\Entidades\TbGrupoPropuestaProyecto;
use General\Vista\Vista;

class PedagogicoCREAFactory extends ControladorBase
{
	protected function initializeFactory()
	{
		$this->contenedor['PedagogicoDAO'] = function ($c) {
			return new PedagogicoDAO();
		};

		$this->contenedor['GrupoDAO'] = function ($c) {
			return new GrupoDAO();
		};
		$this->contenedor['personaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};

		$this->contenedor['persona'] = function ($c) {
			return new TbPersona2017();
		};

		$this->contenedor['caracterizacion'] = function ($c) {
			return new TbCaracterizacionGrupo();
		};
		$this->contenedor['planeacion'] = function ($c) {
			return new TbPlaneacionGrupo();
		};
		$this->contenedor['grupoPropuestaProyecto'] = function ($c) {
			return new TbGrupoPropuestaProyecto();
		};
	}
}