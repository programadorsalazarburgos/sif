<?php
namespace Beneficiarios\Controlador;
use General\Controlador\ControladorBase;

use General\Persistencia\DAOS\OptionsDAO;
use General\Persistencia\DAOS\GrupoDAO;
use General\Persistencia\DAOS\NidosGruposDAO;
use General\Persistencia\DAOS\NidosBeneficiariosDAO;
use General\Persistencia\DAOS\NidosAsistenciaDAO;
use General\Persistencia\DAOS\NidosDuplasDAO;
use General\Persistencia\Entidades\TbNidosGrupos;
use General\Persistencia\Entidades\TbNidosExperiencia;
use General\Persistencia\Entidades\TbNidosBeneficiarios;
use General\Persistencia\Entidades\TbNidosBeneficiarioGrupo;
use General\Persistencia\Entidades\TbNidosExperienciaArtista;
use General\Persistencia\Entidades\TbNidosAsistencia;
use General\Persistencia\Entidades\TbNidosSinInformacionContenidos;
use General\Persistencia\Entidades\TbNidosExperienciaSoporte;

class BeneficiariosFactory extends ControladorBase
{
	protected function initializeFactory()
	{
    $this->contenedor['OptionsDAO'] = function ($c) {
        return new OptionsDAO();
    };
		$this->contenedor['GrupoDAO'] = function ($c) {
				return new GrupoDAO();
		};
    $this->contenedor['NidosGruposDAO'] = function ($c) {
      return new NidosGruposDAO();
    };
		$this->contenedor['NidosBeneficiariosDAO'] = function ($c) {
			return new NidosBeneficiariosDAO();
		};
		$this->contenedor['NidosAsistenciaDAO'] = function ($c) {
			return new NidosAsistenciaDAO();
		};
		$this->contenedor['NidosDuplasDAO'] = function ($c) {
			return new NidosDuplasDAO();
		};
    $this->contenedor['TbNidosGrupos'] = function ($c) {
      return new TbNidosGrupos();
    };
    $this->contenedor['TbNidosExperiencia'] = function ($c) {
      return new TbNidosExperiencia();
    };
    $this->contenedor['TbNidosBeneficiarios'] = function ($c) {
      return new TbNidosBeneficiarios();
    };
    $this->contenedor['TbNidosBeneficiarioGrupo'] = function ($c) {
      return new TbNidosBeneficiarioGrupo();
    };
    $this->contenedor['TbNidosExperienciaArtista'] = function ($c) {
      return new TbNidosExperienciaArtista();
    };
		$this->contenedor['TbNidosAsistencia'] = function ($c) {
      return new TbNidosAsistencia();
    };
    $this->contenedor['TbNidosSinInformacionContenidos'] = function ($c) {
      return new TbNidosSinInformacionContenidos();
    };
    $this->contenedor['TbNidosExperienciaSoporte'] = function ($c) {
      return new TbNidosExperienciaSoporte();
    };    
	}
}
