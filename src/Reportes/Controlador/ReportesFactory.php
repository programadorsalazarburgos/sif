<?php
namespace Reportes\Controlador;
use General\Controlador\ControladorBase;

use General\Persistencia\DAOS\OptionsDAO;
use General\Persistencia\DAOS\NidosDuplasDAO;
use General\Persistencia\DAOS\NidosReporteAsistenciaDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\NidosConsultaGeneralDAO;
use General\Persistencia\DAOS\NidosAsistenciaDAO;
use General\Persistencia\Entidades\TbNidosAsistencia;
use General\Persistencia\Entidades\TbNidosLugarAtencion;
use General\Persistencia\Entidades\TbNidosExperiencia;


class ReportesFactory extends ControladorBase
{
	protected function initializeFactory()
	{
    $this->contenedor['OptionsDAO'] = function ($c) {
        return new OptionsDAO();
    };
    $this->contenedor['NidosDuplasDAO'] = function ($c) {
      return new NidosDuplasDAO();
    };
    $this->contenedor['NidosReporteAsistenciaDAO'] = function ($c) {
      return new NidosReporteAsistenciaDAO();
    };
    $this->contenedor['TbNidosAsistencia'] = function ($c) {
      return new TbNidosAsistencia();
    };
    $this->contenedor['GrupoDAO'] = function ($c) {
        return new GrupoDAO();
    };
    $this->contenedor['NidosConsultaGeneralDAO'] = function ($c) {
      return new NidosConsultaGeneralDAO();
    };
    $this->contenedor['TbNidosLugarAtencion'] = function ($c) {
      return new TbNidosLugarAtencion();
    };
    $this->contenedor['TbNidosExperiencia'] = function ($c) {
      return new TbNidosExperiencia();
    };
    $this->contenedor['NidosAsistenciaDAO'] = function ($c) {
      return new NidosAsistenciaDAO();
    };
	}
}
