<?php
namespace PedagogicoNidos\Controlador;
use General\Controlador\ControladorBase;

use General\Persistencia\DAOS\OptionsDAO;
use General\Persistencia\DAOS\NidosPedagogicoDAO;
use General\Persistencia\DAOS\NidosSistematizacionDAO;
use General\Persistencia\Entidades\TbNidosFortalecimiento;
use General\Persistencia\Entidades\TbNidosSistematizacion;
use General\Persistencia\Entidades\TbNidosSistematizacionArtista;
use General\Controlador\OptionsController;


class PedagogicoFactory extends ControladorBase
{
	protected function initializeFactory()
	{
    $this->contenedor['OptionsDAO'] = function ($c) {
      return new OptionsDAO();
    };
    $this->contenedor['NidosPedagogicoDAO'] = function ($c) {
      return new NidosPedagogicoDAO();
    };
    $this->contenedor['NidosSistematizacionDAO'] = function ($c) {
      return new NidosSistematizacionDAO();
    };
    $this->contenedor['TbNidosFortalecimiento'] = function ($c) {
      return new TbNidosFortalecimiento();
    };
    $this->contenedor['TbNidosSistematizacion'] = function ($c) {
      return new TbNidosSistematizacion();
    };
    $this->contenedor['TbNidosSistematizacionArtista'] = function ($c) {
      return new TbNidosSistematizacionArtista();
    };
  }
}
