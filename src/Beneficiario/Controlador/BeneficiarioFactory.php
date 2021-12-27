<?php

namespace Beneficiario\Controlador;
use General\Controlador\ControladorBase;
use General\Vista\Vista;
use General\Persistencia\DAOS\BeneficiarioDAO;
use General\Persistencia\Entidades\TbEstudianteDetalleAnio;
use General\Persistencia\Entidades\TbEstudiante;

class BeneficiarioFactory extends ControladorBase
{
	protected function initializeFactory()
	{
		$this->contenedor['BeneficiarioDAO'] = function ($c) {
			return new BeneficiarioDAO();
		};

		$this->contenedor['TbEstudianteDetalleAnio'] = function ($c) {
			return new TbEstudianteDetalleAnio();
		};
		$this->contenedor['TbEstudiante'] = function ($c) {
		    return new TbEstudiante();
		};
	}
}