<?php
namespace CirculacionNidos\Controlador;
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\OptionsDAO;

use General\Persistencia\DAOS\NidosCirculacionDAO;
use General\Persistencia\DAOS\NidosAtencionesVirtualesDAO;
use General\Persistencia\Entidades\TbNidosEventoCirculacion;
use General\Persistencia\Entidades\TbNidosLugarAtencion;
use General\Persistencia\Entidades\TbNidosAsistentesEvento;
use General\Persistencia\Entidades\TbNidosBeneficiarios;
use General\Persistencia\Entidades\TbNidosHorariosAtencion;
use General\Persistencia\Entidades\TbNidosAtencionesVirtuales;
use General\Persistencia\Entidades\TbNidosFormulariosAtencionesVirtuales;
use General\Persistencia\Entidades\TbNidosAsistencia;
use General\Persistencia\Entidades\TbNidosLlamadas;
use General\Persistencia\Entidades\TbNidosLlamadasAsignacion;

class CirculacionFactory extends ControladorBase
{
	protected function initializeFactory()
	{
    $this->contenedor['OptionsDAO'] = function ($c) {
      return new OptionsDAO();
    };

    $this->contenedor['NidosCirculacionDAO'] = function ($c) {
      return new NidosCirculacionDAO();
    };

    $this->contenedor['NidosAtencionesVirtualesDAO'] = function ($c) {
      return new NidosAtencionesVirtualesDAO();
    };

    $this->contenedor['TbNidosEventoCirculacion'] = function ($c) {
      return new TbNidosEventoCirculacion();
    };

    $this->contenedor['TbNidosLugarAtencion'] = function ($c) {
      return new TbNidosLugarAtencion();
    };

    $this->contenedor['TbNidosAsistentesEvento'] = function ($c) {
      return new TbNidosAsistentesEvento();
    };

    $this->contenedor['TbNidosBeneficiarios'] = function ($c) {
      return new TbNidosBeneficiarios();
    };

    $this->contenedor['TbNidosAsistencia'] = function ($c) {
      return new TbNidosAsistencia();
    };

    $this->contenedor['TbNidosHorariosAtencion'] = function ($c) {
      return new TbNidosHorariosAtencion();
    };

    $this->contenedor['TbNidosAtencionesVirtuales'] = function ($c) {
      return new TbNidosAtencionesVirtuales();
    };

    $this->contenedor['TbNidosFormulariosAtencionesVirtuales'] = function ($c) {
      return new TbNidosFormulariosAtencionesVirtuales();
    };

    $this->contenedor['TbNidosLlamadas'] = function ($c) {
      return new TbNidosLlamadas();
    };

    $this->contenedor['TbNidosLlamadasAsignacion'] = function ($c) {
      return new TbNidosLlamadasAsignacion();
    };
  }
}
