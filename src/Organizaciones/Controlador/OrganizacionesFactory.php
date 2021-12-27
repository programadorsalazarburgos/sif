<?php
namespace Organizaciones\Controlador;
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\DAOS\OrganizacionesProyeccionGastoDAO;
use General\Persistencia\Entidades\TbOrganizacionesProyeccionGasto;

class OrganizacionesFactory extends ControladorBase
{
	protected function initializeFactory()
	{		 
		$this->contenedor['tbPersonaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};	
		$this->contenedor['TbPersona2017'] = function ($c) {
			return new TbPersona2017();
		};
		$this->contenedor['OrganizacionesProyeccionGastoDAO'] = function ($c) {
			return new OrganizacionesProyeccionGastoDAO();
		};
		$this->contenedor['TbOrganizacionesProyeccionGasto'] = function ($c) {
			return new TbOrganizacionesProyeccionGasto();
		};
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */