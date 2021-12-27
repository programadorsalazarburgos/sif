<?php
namespace GestionClan\Controlador;
use General\Controlador\ControladorBase;
use General\Vista\Vista;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\BeneficiarioDAO;
use General\Persistencia\DAOS\ColegioDAO;
use General\Persistencia\DAOS\CreaDAO;
use General\Persistencia\DAOS\NovedadSesionClaseDAO;
use General\Persistencia\DAOS\TbFormadorOrganizacion2017DAO;
use General\Persistencia\DAOS\AsignacionDAO;
use General\Persistencia\DAOS\OcupacionCreaDAO;
use General\Persistencia\DAOS\TbOrganizaciones2017DAO;
use General\Persistencia\DAOS\ZonaDAO;
use General\Persistencia\DAOS\OptionsDAO;
use General\Persistencia\DAOS\CoberturaDAO;

use General\Persistencia\Entidades\TbTerrGrupo;
use General\Persistencia\Entidades\TbEstudiante;
use General\Persistencia\Entidades\TbEstudianteDetalleAnio;
use General\Persistencia\Entidades\TbTerrGrupoHorarioClase;
use General\Persistencia\Entidades\TbTerrGrupoSesionClaseNovedad;
use General\Persistencia\Entidades\TbFormadorOrganizacion2017;
use General\Persistencia\Entidades\TbCobertura;

class GestionClanFactory extends ControladorBase
{
	protected function initializeFactory()
	{
		$this->contenedor['TbTerrGrupoSesionClaseNovedad'] = function ($c) {
			return new TbTerrGrupoSesionClaseNovedad();
		};

		$this->contenedor['NovedadSesionClaseDAO'] = function ($c) {
			return new NovedadSesionClaseDAO();
		};

		$this->contenedor['GrupoDAO'] = function ($c) {
			return new GrupoDAO();
		};

		$this->contenedor['BeneficiarioDAO'] = function ($c) {
			return new BeneficiarioDAO();
		};

		$this->contenedor['ColegioDAO'] = function ($c) {
			return new ColegioDAO();
		};

		$this->contenedor['CreaDAO'] = function ($c) {
			return new CreaDAO();
		};

		$this->contenedor['AsignacionDAO'] = function ($c) {
		    return new AsignacionDAO();
		};

		$this->contenedor['OcupacionCreaDAO'] = function ($c) {
		    return new OcupacionCreaDAO();
		};

		$this->contenedor['TbOrganizaciones2017DAO'] = function ($c){
			return new TbOrganizaciones2017DAO();
		};

		$this->contenedor['ZonaDAO'] = function ($c){
			return new ZonaDAO();
		};

		$this->contenedor['OptionsDAO'] = function ($c){
			return new OptionsDAO();
		};

		$this->contenedor['CoberturaDAO'] = function ($c){
			return new CoberturaDAO();
		};

		$this->contenedor['TbEstudiante'] = function ($c) {
			return new TbEstudiante();
		};

		$this->contenedor['TbEstudianteDetalleAnio'] = function ($c) {
			return new TbEstudianteDetalleAnio();
		};

		$this->contenedor['formadorOrganizacionDAO'] = function ($c) {
			return new TbFormadorOrganizacion2017DAO();
		};

		$this->contenedor['formadorOrganizacion'] = function ($c) {
			return new TbFormadorOrganizacion2017();
		};

		$this->contenedor['TbTerrGrupo'] = function ($c) {
			return new TbTerrGrupo();
		};

		$this->contenedor['TbTerrGrupoHorarioClase'] = function ($c) {
			return new TbTerrGrupoHorarioClase();
		};

		$this->contenedor['TbCobertura'] = function ($c) {
			return new TbCobertura();
		};
	}
}
