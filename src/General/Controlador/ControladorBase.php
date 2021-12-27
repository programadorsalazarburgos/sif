<?php
namespace General\Controlador;
use Pimple\Container;
use General\Vista\Vista;


abstract class ControladorBase 
{
	/**
	  *
	  * @var Mixed parametro enviado por Ajax con nombre p1
	  * Usado para la colección de parametros enviados junto a $_FILES
	  */
	protected $p1;

	/**
	  *
	  * @var Mixed parametro enviado por Ajax con nombre p2
	  */
	protected $p2;

	/**
	  *
	  * @var Mixed parametro enviado por Ajax con nombre p3
	  */
	protected $p3;
	/**
	  *
	  * @var Mixed parametro enviado por Ajax con nombre p4
	  */
	protected $p4;
	/**
	  *
	  * @var Mixed parametro enviado por Ajax con nombre p5
	  */
	protected $p5;	

	/**
	 * @var Container
	 *
	 */
	protected /*static*/ $contenedor;


	function __construct()
	{
		date_default_timezone_set('America/Bogota');

		$this->contenedor=$this->getContenedor();		
		$variables=array();
		$this->contenedor["vista"] = function ($c) use ($variables) {
			return new Vista($variables);
		};

	}

    // Método común
	public /*static*/ function getContenedor()
	{ 
		return new Container();
	}

	public function prepareParameters($post,$files)
	{
		if(isset($post["p1"])) $this->p1=$post["p1"]; else $this->p1=null;
		if(isset($post["p2"])) $this->p2=$post["p2"]; else $this->p2=null;
		if(isset($post["p3"])) $this->p3=$post["p3"]; else $this->p3=null;
		if(isset($post["p4"])) $this->p4=$post["p4"]; else $this->p4=null;
		if(isset($post["p5"])) $this->p5=$post["p5"]; else $this->p5=null;
		if(isset($files) && sizeof($files)>0) {
			if($this->p1===null) {
				$this->p1=$post;
				unset($this->p1["funcion"]);
			}
			$this->p2=$files;
		}
		$this->{$post["funcion"]}($this->p1,$this->p2,$this->p3,$this->p4,$this->p5);
	}
}