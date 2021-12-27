<?php
namespace Contenidos\Controlador;
use General\Controlador\ControladorBase;

use General\Vista\Vista;
use General\Persistencia\DAOS\NidosContenidosDAO;
use General\Persistencia\Entidades\TbNidosSinInformacionContenidos;
use General\Persistencia\Entidades\TbNidosCategoriaContenido;
use General\Persistencia\Entidades\TbNidosContenido;

class ContenidosFactory extends ControladorBase
{
	protected function initializeFactory()
	{
		$this->contenedor['NidosContenidosDAO'] = function ($c) {
			return new NidosContenidosDAO();
		};
		$this->contenedor['TbNidosSinInformacionContenidos'] = function ($c) {
			return new TbNidosSinInformacionContenidos();
		};
		$this->contenedor['TbNidosCategoriaContenido'] = function ($c) {
			return new TbNidosCategoriaContenido();
		};
		$this->contenedor['TbNidosContenido'] = function ($c) {
			return new TbNidosContenido();
		};
	}
}