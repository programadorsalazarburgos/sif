<?php
namespace Psicosocial\Controlador;
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\PsicosocialDAO;
use General\Persistencia\Entidades\TbPsicoReporteCasos;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PsicosocialFactory extends ControladorBase
{
	protected function initializeFactory()
	{		
		$this->contenedor['PsicosocialDAO'] = function ($c) {
			return new PsicosocialDAO();
		};

		$this->contenedor['reporteCaso'] = function ($c) {
			return new TbPsicoReporteCasos();
		};
	}
}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */