<?php
namespace SeguimientoContratistas\Controlador;
use General\Controlador\ControladorBase;
use SeguimientoContratistas\Persistencia\DAOS\TbInformePagoPersonaDAO;
use SeguimientoContratistas\Persistencia\DAOS\TbInformePagoPersonaBasicoDAO;
use SeguimientoContratistas\Persistencia\DAOS\TbInformeDetalladoPersonaDAO;
use SeguimientoContratistas\Persistencia\Entidades\TbInformePagoPersona;
use SeguimientoContratistas\Persistencia\Entidades\TbInformePagoPersonaBasico;
use SeguimientoContratistas\Persistencia\Entidades\TbInformeDetalladoPersona;
use General\Controlador\OptionsController;
use General\Persistencia\DAOS\TbPersona2017DAO;
use General\Persistencia\Entidades\TbPersona2017;
use General\Persistencia\DAOS\ParametroDAO;
use SeguimientoContratistas\Persistencia\Entidades\TbInformePagoAnexosOrfeo;
use SeguimientoContratistas\Modelo\Firma\FirmaElectronicaService;
use SeguimientoContratistas\Persistencia\Entidades\TbInformePagoFirmas;

class SeguimientoContratistasFactory extends ControladorBase
{
	protected function initializeFactory()
	{		
		$this->contenedor["tbInformePagoPersonaDAO"] = function ($c) {
			return new TbInformePagoPersonaDAO();
		};
		$this->contenedor["tbInformePagoPersonaBasicoDAO"] = function ($c) {
			return new TbInformePagoPersonaBasicoDAO();
		};

		$this->contenedor["informePagoPersona"] = function ($c) {
			return new TbInformePagoPersona();
		};
		$this->contenedor["informePagoPersonaBasico"] = function ($c) {
			return new TbInformePagoPersonaBasico();
		};

		$this->contenedor['tbPersonaDAO'] = function ($c) {
			return new TbPersona2017DAO();
		};

		$this->contenedor['tbPersona2017'] = function ($c) {
			return new TbPersona2017();
		};
		$this->contenedor['tbInformeDetalladoPersonaDAO'] = function ($c) {
			return new tbInformeDetalladoPersonaDAO();
		};
		$this->contenedor['tbInformeDetalladoPersona'] = function ($c) {
			return new tbInformeDetalladoPersona();
		};
		$this->contenedor['optionsController'] = function ($c) {
			return new OptionsController();
		};
		$this->contenedor['ParametroDAO'] = function ($c) {
		    return new ParametroDAO();
		};
		$this->contenedor['TbInformePagoAnexosOrfeo'] = function ($c) {
			return new TbInformePagoAnexosOrfeo();
		};
		$this->contenedor['firmaService'] = function ($c) {
			return new FirmaElectronicaService();
		};
		$this->contenedor['TbInformePagoFirmas'] = function ($c) {
			return new TbInformePagoFirmas();
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
	protected function subirArchivos($id_usuario, $archivos, $folder, $periodo, $cleanForlder = 0, $class = null , $method = null, $namespace = null)
	{
		$backtrace = debug_backtrace()[1];
		if ($namespace == null)
			$namespace = substr($backtrace['class'],0, strpos($backtrace['class'],'\\'));
		$rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));
		$folder_create = $id_usuario.'/'.$periodo.'/';
		$carpeta = $rutaBase.'uploadedFiles/'.$namespace.'/'.$folder.'/'.$folder_create.'/';
		/*print_r($carpeta);*/
		$ubicacion = "../../uploadedFiles/".$namespace.'/'.$folder.'/'.$folder_create.'/';
		if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
			return 4;
		} 
		else{
			$rta = "";
			if ($cleanForlder == 1 && sizeof($archivos) > 0){
				$this->cleanFolder($carpeta);
				/*$this->contenedor[$class]->$method($id_usuario);				*/
			}
			foreach ($archivos as $archivo) {
				
				$ruta = $carpeta.$this->clean($archivo['name']);
				if ($rta != "4"){					
					if (move_uploaded_file($archivo['tmp_name'] , $ruta)){
						$rta .= $ubicacion.$this->clean($archivo['name'])."///";	
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