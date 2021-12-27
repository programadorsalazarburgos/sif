<?php
namespace Circulacion\Controlador;
use General\Controlador\ControladorBase;
use General\Vista\Vista;
use General\Persistencia\DAOS\EventoDAO;
use General\Persistencia\DAOS\BeneficiarioDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\Entidades\TbCircEvento;
use General\Persistencia\Entidades\TbTerrGrupo;

class CirculacionFactory extends ControladorBase
{
	protected function initializeFactory()
	{
		$this->contenedor['EventoDAO'] = function ($c) {
		    return new EventoDAO();
		};
		$this->contenedor['BeneficiarioDAO'] = function ($c) {
		    return new BeneficiarioDAO();
		};

		$this->contenedor['GrupoDAO'] = function ($c) {
		    return new GrupoDAO();
		};

		$this->contenedor['TbCircEvento'] = function ($c) {
		    return new TbCircEvento();
		};

		$this->contenedor['TbTerrGrupo'] = function ($c) {
		    return new TbTerrGrupo();
		};
	}
}