<?php

namespace  General\Persistencia\Entidades;
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * Object que representa la tabla 'tb_incidente_adjunto'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-05-02 09:57	 
 */
class TbIncidenteAdjunto 
{
	
	private $codigo;
	private $incidente_codigo;
	private $servicio_codigo=1;
	private $sla_codigo=1;
	private $ruta;
	private $carpeta='';
	private $ubicacion='';

	/**
	 * Sube Archivos al directorio $carpeta\incidente_codigo y 
	 * retorna array para creación de registros en BD
	 * @return mixed
	 */
	public function subirArchivos($archivos)        
	{

	    $trace = debug_backtrace();
        //echo '<pre>'.print_r($trace).'</pre>';
 		$backtrace = $trace[1];     
	    $namespace = substr($backtrace['class'],0, strpos($backtrace['class'],'\\'));
	    $rutaBase =   substr($backtrace['file'],0, strpos($backtrace['file'],'src'));  
	    //echo "namespace: ".$namespace. " - rutaBase:".$rutaBase;
        $this->setCarpeta($rutaBase.'uploadedFiles/'.$namespace.'/soportes/'.$this->getIncidenteCodigo().'/');   
        $this->setUbicacion("../../uploadedFiles/".$namespace.'/soportes/'.$this->getIncidenteCodigo().'/');         
        //echo $this->getCarpeta();   
        // los dos últimos parametros de mkdir son para forzar a crear arbol de directorios        
		if (!is_dir($this->getCarpeta()) && !mkdir($this->getCarpeta(), 0777, true)){
		  die("** Error creando directorio [".$this->getCarpeta()."]");        
		} 
		else{
	        $inserta= array();
	        foreach ($archivos as $archivo) {
	        	$ruta=$this->getCarpeta().$this->clean($archivo['name']);
	        	if (move_uploaded_file($archivo['tmp_name'] , $ruta)) {
		        	$fila['ruta']=$this->getUbicacion().$this->clean($archivo['name']);
		        	$fila['incidente_codigo']=$this->getIncidenteCodigo();
		        	$fila['servicio_codigo']=$this->getServicioCodigo();
		        	$fila['sla_codigo']=$this->getSlaCodigo();
		        	$inserta[]=$fila;        		
	        	}
	        }
	        return $inserta; 			
		} 

	}

	public function clean($string) {
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
	        '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
	        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
	        '/[“”«»„]/u'    =>   ' ', // Double quote
	        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
	    );
	    return preg_replace(array_keys($utf8), array_values($utf8), $string);	   
	}

	/**
	 * Asigna el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */

	public function setVariables($objeto)
	{        
		//echo '<pre>'.print_r($objeto,true).'</pre>';     
		foreach ($objeto as $clave => $valor) {			
			if($valor==null)
				$this->{$clave} = NULL; 
			else
				$this->{$clave} = $valor;  		
		}   
	}			

	/**
	 * Obtiene el valor de CODIGO
	 * @return mixed
	 */

	public function getCodigo()
	{
			return $this->codigo;
	}

	/**
	 * Asigna el valor para CODIGO
	 * @param mixed $codigo 
	 */
	public function setCodigo($codigo)
	{
			$this->codigo=$codigo;
	}

	/**
	 * Obtiene el valor de INCIDENTE_CODIGO
	 * @return mixed
	 */
	public function getIncidenteCodigo()
	{
			return $this->incidente_codigo;
	}

	/**
	 * Asigna el valor para INCIDENTE_CODIGO
	 * @param mixed $incidente_codigo 
	 */
	public function setIncidenteCodigo($incidente_codigo)
	{
			$this->incidente_codigo=$incidente_codigo;
	}

	/**
	 * Obtiene el valor de SERVICIO_CODIGO
	 * @return mixed
	 */
	public function getServicioCodigo()
	{
			return $this->servicio_codigo;
	}

	/**
	 * Asigna el valor para SERVICIO_CODIGO
	 * @param mixed $servicio_codigo 
	 */
	public function setServicioCodigo($servicio_codigo)
	{
			$this->servicio_codigo=$servicio_codigo;
	}

	/**
	 * Obtiene el valor de SLA_CODIGO
	 * @return mixed
	 */
	public function getSlaCodigo()
	{
			return $this->sla_codigo;
	}

	/**
	 * Asigna el valor para SLA_CODIGO
	 * @param mixed $sla_codigo 
	 */
	public function setSlaCodigo($sla_codigo)
	{
			$this->sla_codigo=$sla_codigo;
	}

	/**
	 * Obtiene el valor de RUTA
	 * @return mixed
	 */
	public function getRuta()
	{
			return $this->ruta;
	}

	/**
	 * Asigna el valor para RUTA
	 * @param mixed $ruta 
	 */
	public function setRuta($ruta)
	{
			$this->ruta=$ruta;
	}



    /**
     * Gets the value of carpeta.
     *
     * @return mixed
     */
    public function getCarpeta()
    {
        return $this->carpeta;
    }

    /**
     * Sets the value of carpeta.
     *
     * @param mixed $carpeta the carpeta
     *
     * @return self
     */
    private function setCarpeta($carpeta)
    {
        $this->carpeta = $carpeta;

        return $this;
    }

    /**
     * Sets the value of ubicacion.
     *
     * @param mixed $ubicacion the ubicacion
     *
     * @return self
     */
    private function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Gets the value of ubicacion.
     *
     * @return mixed
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }
}
