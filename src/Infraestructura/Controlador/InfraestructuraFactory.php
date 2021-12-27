<?php
namespace Infraestructura\Controlador;
use General\Controlador\ControladorBase;
use General\Persistencia\DAOS\ConsultasReportesDAO;
use General\Persistencia\DAOS\TbOrganizaciones2017DAO;
use General\Persistencia\DAOS\InfraestructuraDAO;
use General\Persistencia\Entidades\TbOrganizaciones2017;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\Entidades\TbInfInventarioClan;
use General\Persistencia\Entidades\TbInfTraslado;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InfraestructuraFactory extends ControladorBase
{
	protected function initializeFactory()
	{		
		$this->contenedor['InfraestructuraDAO'] = function ($c) {
			return new InfraestructuraDAO();
		};

		$this->contenedor['inventario'] = function ($c) {
			return new TbInfInventarioClan();
		};

		$this->contenedor['traslado'] = function ($c) {
			return new TbInfTraslado();
		};
	}

	/**
	 * Sube Archivos de acuerdo al Fk de la persona y una carpeta destino
	 * @param  Array $datos 		Todos los campos del formulario asi como adicionales como el id del  informe de pago, se utiliza unicamente FK_Persona dentro de esta funcion
	 * @param  Array $archivos      Archivo Anexo del informe de pago Detallado, no es requiered (posiblemente funciona para mas de 1 archivo pero inicialmente es solo para uno)
	 * @param  Array $folder        Nombre de la carpeta bajo el nombre del modulo donde se guardará el archivo
	 * @return Integer              Retorna el estado de la peticion, si todo esta correcto devuelve la url, 3 para error - sin archivos en la variable, 4 en el caso de que no pueda crear la carpeta 
	 *                              o no pueda mover el archivo, 4 tamaño maximo excedido
	*/
	protected function subirArchivos($id_elemento, $archivos, $folder, $cleanForlder = 0)
	{
		$backtrace = debug_backtrace()[1];
		$namespace = substr($backtrace['class'],0, strpos($backtrace['class'],'\\'));
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		$folder_create = $id_elemento;
		$carpeta = $rutaBase.'uploadedFiles/'.$namespace.'/'.$folder.'/RegistroFotografico/'.$folder_create.'/';
		/*print_r($carpeta);*/
		$ubicacion = "../../uploadedFiles/".$namespace.'/'.$folder.'/RegistroFotografico/'.$folder_create.'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		}
		else{
			$rta = "";
			if ($cleanForlder == 1 && sizeof($archivos) > 0){
				$this->cleanFolder($carpeta);
			}
			foreach ($archivos as $archivo) {
				
				$ruta = $carpeta.$this->clean($archivo['name']);
				if ($rta != "4"){					
					if (move_uploaded_file($archivo['tmp_name'] , $ruta)){
						$rta .= $ubicacion.$this->clean($archivo['name'])."///";	
						chmod($ruta, 0777);
					}
					else
						$rta = "4";
				}
			}
			$rta = rtrim($rta,"///");
			return $rta;           
		}
	}
	/**
	 * Limpia de tildes y caracteres extraños un string
	 * @param  string $string		  string que se quiere limpiar
	 * @return string         string limpio
	 */
	protected function clean($string) {
		$utf8 = array(
			'/[áàâãªä]/u'   =>   'a',
			'/[ÁÀÂÃÄ]/u'    =>   'A',
			'/[ÍÌÎÏ]/u'     =>   'I',
			'/[íìîï]/u'     =>   'i',
			'/[éèêë]/u'     =>   'e',
			'/[ÉÈÊË]/u'     =>   'E',
			'/[óòôõºö]/u'   =>   'o',
			'/[ÓÒÔÕÖ]/u'    =>   'O',
			'/[úùûü]/u'     =>   'u',
			'/[ÚÙÛÜ]/u'     =>   'U',
			'/ç/'           =>   'c',
			'/Ç/'           =>   'C',
			'/ñ/'           =>   'n',
			'/Ñ/'           =>   'N',
			'/–/'           =>   '-',
			'/[#$!!#]/u'    =>   '',
			'/[’‘‹›‚]/u'    =>   ' ',
			'/[“”«»„]/u'    =>   ' ',
			'/ /'           =>   ' ',
			'/·/'           =>   ' ',
		);
		return str_replace("?", "",utf8_decode(preg_replace(array_keys($utf8), array_values($utf8), $string)));      
	}
    /**
	 * borra todos los ficheros dentro de un folder
	 * @param  string $dir 		  nombre del forlder que se desea limpiar
	 * @return int 				  estado del proceso        	
	 */
    protected function cleanFolder($dir){
    	$rta = true; 
    	$files = scandir($dir); 
    	$ficherosEliminados = 0;
    	foreach($files as $file){
    		if (is_file($dir.$file)) {
    			if (unlink($dir.$file))
    				$ficherosEliminados++;
    			else
    				$rta = false;
    		}
    	}
    	return $rta;
    }
}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */