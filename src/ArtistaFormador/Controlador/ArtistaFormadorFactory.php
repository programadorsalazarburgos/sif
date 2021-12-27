<?php
namespace ArtistaFormador\Controlador;
use General\Controlador\ControladorBase;
use General\Vista\Vista;
use General\Persistencia\DAOS\ReporteDAO;
use General\Persistencia\Entidades\TbAdminPdfCodigoVerificacion;
use General\Persistencia\DAOS\SesionClaseDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\ParametroDAO;
use General\Persistencia\DAOS\EventoDAO;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\DAOS\NovedadSesionClaseDAO;
use General\Persistencia\Entidades\TbTerrGrupo;
use General\Persistencia\Entidades\TbTerrGrupoSesionClase;
use General\Persistencia\Entidades\TbTerrGrupoSesionClaseNovedad;

class ArtistaFormadorFactory extends ControladorBase
{
	protected function initializeFactory()
	{
		$this->contenedor['ReporteDAO'] = function ($c) {
		    return new ReporteDAO();
		};

		$this->contenedor['TbAdminPdfCodigoVerificacion'] = function ($c) {
		    return new TbAdminPdfCodigoVerificacion();
		};

		$this->contenedor['SesionClaseDAO'] = function ($c) {
		    return new SesionClaseDAO();
		};

		$this->contenedor['GrupoDAO'] = function ($c) {
		    return new GrupoDAO();
		};

		$this->contenedor['EventoDAO'] = function ($c) {
		    return new EventoDAO();
		};

		$this->contenedor['ParametroDAO'] = function ($c) {
		    return new ParametroDAO();
		};

		$this->contenedor['PersonaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};

		$this->contenedor['NovedadSesionClaseDAO'] = function ($c) {
			return new NovedadSesionClaseDAO();
		};

		$this->contenedor['TbTerrGrupo'] = function ($c) {
		    return new TbTerrGrupo();
		};

		$this->contenedor['TbTerrGrupoSesionClase'] = function ($c) {
		    return new TbTerrGrupoSesionClase();
		};

		$this->contenedor['TbTerrGrupoSesionClaseNovedad'] = function ($c) {
			return new TbTerrGrupoSesionClaseNovedad();
		};
	}
}