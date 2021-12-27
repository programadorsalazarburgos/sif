<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_incidente'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-05-02 09:57	 
 */
class TbIncidente 
{
	
	private $codigo;
	private $servicio_codigo=array('valor'=>1,
								   'signo'=>'=',
								   'llave'=>true);
	private $sla_codigo=array('valor'=>1,
							  'signo'=>'=',
							  'llave'=>true);
	private $fk_id_usuario;
	private $fk_id_usuario_funcionario;
	private $urgencia;
	private $impacto;
	private $prioridad;
	private $fecha_creacion;
	private $metodo_notificacion;
	private $metodo_retroalimentacion;
	private $estado;
	private $titulo;
	private $descripcion_sintomas;
	private $descripcion_solucion;
	private $error_conocido;
	private $fk_tipo_soporte;
	private $fk_actividad_apertura;
	private $fk_actividad_cierre;
	private $fecha_cierre; 
	private $fk_observadores; 


	/**
	 * Asigna el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
	public function setVariables($objeto)
	{
		foreach ($objeto as $clave => $valor) {
			if($valor==null)
				$this->{$clave} = NULL; 
			else
				$this->{$clave} = $valor;  
		}
	}	

	/**
	 * Crea la sintaxis de SQL para el WHERE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
    public function setWhere($tabla)
    {
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor['valor']!=null && $valor['valor']!='')
    		{
    			if(is_array($valor['valor'])){
    				foreach ($valor['valor'] as $subKey => $subValor) {
    					if($subValor['valor']!=null && $subValor['valor']!=''){
		 	     			if($where==='')
				    				$where.=$tabla.'.'.$clave.$subValor['signo'].$subValor['valor'];
				    			else
				    				$where.=' AND '.$tabla.'.'.$clave.$subValor['signo'].$subValor['valor'];   						
    					}
    				}
    			}
    			else{
	     			if($where==='')
		    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
		    			else
		    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			}
   			
    		}

    	} 
    	return $where;
    }	

	/**
	 * Crea la sintaxis de SQL para el UPDATE con el valor de las variables encapsuladas en $objeto
	 * @return mixed
	 */
    public function setUpdate($tabla)
    {
    	$update='';
    	$where='';
    	foreach($this as $clave=>$valor)
    	{
    		if($valor['valor']!=null && $valor['valor']!='') {
    			if($valor['llave']) {
	    			if($where==='')
	    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
	    			else
	    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			}
    			else {
	    			if($update==='')
	    				$update.=$tabla.'.'.$clave.'='.$valor['valor'];
	    			else
	    				$update.=','. $tabla.'.'.$clave.'='.$valor['valor'];    				
    			}

    		}
    		

    	} 
    	return $update.' WHERE '.$where;
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
	 * Obtiene el valor de FK_Id_Usuario
	 * @return mixed
	 */
	public function getFkIdUsuario()
	{
			return $this->fk_id_usuario;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario
	 * @param mixed $fk_id_usuario 
	 */
	public function setFkIdUsuario($fk_id_usuario)
	{
			$this->fk_id_usuario=$fk_id_usuario;
	}

	/**
	 * Obtiene el valor de FK_Id_Usuario_Funcionario
	 * @return mixed
	 */
	public function getFkIdUsuarioFuncionario()
	{
			return $this->fk_id_usuario_funcionario;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario_Funcionario
	 * @param mixed $fk_id_usuario_funcionario 
	 */
	public function setFkIdUsuarioFuncionario($fk_id_usuario_funcionario)
	{
			$this->fk_id_usuario_funcionario=$fk_id_usuario_funcionario;
	}

	/**
	 * Obtiene el valor de URGENCIA
	 * @return mixed
	 */
	public function getUrgencia()
	{
			return $this->urgencia;
	}

	/**
	 * Asigna el valor para URGENCIA
	 * @param mixed $urgencia 
	 */
	public function setUrgencia($urgencia)
	{
			$this->urgencia=$urgencia;
	}

	/**
	 * Obtiene el valor de IMPACTO
	 * @return mixed
	 */
	public function getImpacto()
	{
			return $this->impacto;
	}

	/**
	 * Asigna el valor para IMPACTO
	 * @param mixed $impacto 
	 */
	public function setImpacto($impacto)
	{
			$this->impacto=$impacto;
	}

	/**
	 * Obtiene el valor de PRIORIDAD
	 * @return mixed
	 */
	public function getPrioridad()
	{
			return $this->prioridad;
	}

	/**
	 * Asigna el valor para PRIORIDAD
	 * @param mixed $prioridad 
	 */
	public function setPrioridad($prioridad=null)
	{
		if($prioridad==null) {	
			$this->prioridad= array(
				'valor'=>$this->validarPrioridad($this->urgencia['valor'], $this->impacto['valor'])['numero'],
				'nombre'=>$this->validarPrioridad($this->urgencia['valor'], $this->impacto['valor'])['nombre'],
				'signo'=>'=',
				'llave'=>false);		
		}
		else {
			$this->prioridad=$prioridad;
		}

	}


    public function validarPrioridad($urgencia, $impacto) {
        //  Tabla de Generación de prioridades
        //Urgencia Alta [u][i]   u:urgencia  i:impacto
        //echo "<pre>** - ".$urgencia." - ". $impacto." </pre>";
        $urgenciaImpacto[1][1] = array("numero"=>1,"nombre"=>"CRITICA");
        $urgenciaImpacto[1][2] = array("numero"=>2,"nombre"=>"ALTA");
        $urgenciaImpacto[1][3] = array("numero"=>3,"nombre"=>"MEDIA");
        //Urgencia Media
        $urgenciaImpacto[2][1] = array("numero"=>2,"nombre"=>"ALTA");
        $urgenciaImpacto[2][2] = array("numero"=>3,"nombre"=>"MEDIA");
        $urgenciaImpacto[2][3] = array("numero"=>4,"nombre"=>"BAJA");
        //Urgencia Baja
        $urgenciaImpacto[3][1] = array("numero"=>3,"nombre"=>"MEDIA");
        $urgenciaImpacto[3][2] = array("numero"=>4,"nombre"=>"BAJA");
        $urgenciaImpacto[3][3] = array("numero"=>5,"nombre"=>"PLANEADA"); 

        return $urgenciaImpacto[$urgencia][$impacto];        
    }	

	
	/**
	 * Obtiene el valor de METODO_NOTIFICACION
	 * @return mixed
	 */
	public function getMetodoNotificacion()
	{
			return $this->metodo_notificacion;
	}

	/**
	 * Asigna el valor para METODO_NOTIFICACION
	 * @param mixed $metodo_notificacion 
	 */
	public function setMetodoNotificacion($metodo_notificacion)
	{
			$this->metodo_notificacion=$metodo_notificacion;
	}

	/**
	 * Obtiene el valor de METODO_RETROALIMENTACION
	 * @return mixed
	 */
	public function getMetodoRetroalimentacion()
	{
			return $this->metodo_retroalimentacion;
	}

	/**
	 * Asigna el valor para METODO_RETROALIMENTACION
	 * @param mixed $metodo_retroalimentacion 
	 */
	public function setMetodoRetroalimentacion($metodo_retroalimentacion)
	{
			$this->metodo_retroalimentacion=$metodo_retroalimentacion;
	}

	/**
	 * Obtiene el valor de ESTADO
	 * @return mixed
	 */
	public function getEstado()
	{
			return $this->estado;
	}

	/**
	 * Asigna el valor para ESTADO
	 * @param mixed $estado 
	 */
	public function setEstado($estado)
	{
			$this->estado=$estado;
	}

	/**
	 * Obtiene el valor de TITULO
	 * @return mixed
	 */
	public function getTitulo()
	{
			return $this->titulo;
	}

	/**
	 * Asigna el valor para TITULO
	 * @param mixed $titulo 
	 */
	public function setTitulo($titulo)
	{
			$this->titulo=$titulo;
	}

	/**
	 * Obtiene el valor de DESCRIPCION_SINTOMAS
	 * @return mixed
	 */
	public function getDescripcionSintomas()
	{
			return $this->descripcion_sintomas;
	}

	/**
	 * Asigna el valor para DESCRIPCION_SINTOMAS
	 * @param mixed $descripcion_sintomas 
	 */
	public function setDescripcionSintomas($descripcion_sintomas)
	{
			$this->descripcion_sintomas=$descripcion_sintomas;
	}

	/**
	 * Obtiene el valor de DESCRIPCION_SOLUCION
	 * @return mixed
	 */
	public function getDescripcionSolucion()
	{
			return $this->descripcion_solucion;
	}

	/**
	 * Asigna el valor para DESCRIPCION_SOLUCION
	 * @param mixed $descripcion_solucion 
	 */
	public function setDescripcionSolucion($descripcion_solucion)
	{
			$this->descripcion_solucion=$descripcion_solucion;
	}

	/**
	 * Obtiene el valor de ERROR_CONOCIDO
	 * @return mixed
	 */
	public function getErrorConocido()
	{
			return $this->error_conocido;
	}

	/**
	 * Asigna el valor para ERROR_CONOCIDO
	 * @param mixed $error_conocido 
	 */
	public function setErrorConocido($error_conocido)
	{
			$this->error_conocido=$error_conocido;
	}

	/**
	 * Obtiene el valor de FK_tipo_soporte
	 * @return mixed
	 */
	public function getFkTipoSoporte()
	{
			return $this->fk_tipo_soporte;
	}

	/**
	 * Asigna el valor para FK_tipo_soporte
	 * @param mixed $fk_tipo_soporte 
	 */
	public function setFkTipoSoporte($fk_tipo_soporte)
	{
			$this->fk_tipo_soporte=$fk_tipo_soporte;
	}

	/**
	 * Obtiene el valor de FK_Actividad_Apertura
	 * @return mixed
	 */
	public function getFkActividadApertura()
	{
			return $this->fk_actividad_apertura;
	}

	/**
	 * Asigna el valor para FK_Actividad_Apertura
	 * @param mixed $fk_actividad_apertura 
	 */
	public function setFkActividadApertura($fk_actividad_apertura)
	{
			$this->fk_actividad_apertura=$fk_actividad_apertura;
	}

	/**
	 * Obtiene el valor de FK_Actividad_Cierre
	 * @return mixed
	 */
	public function getFkActividadCierre()
	{
			return $this->fk_actividad_cierre;
	}

	/**
	 * Asigna el valor para FK_Actividad_Cierre
	 * @param mixed $fk_actividad_cierre 
	 */
	public function setFkActividadCierre($fk_actividad_cierre)
	{
			$this->fk_actividad_cierre=$fk_actividad_cierre;
	}



    /**
     * Gets the value of fecha_creacion.
     *
     * @return mixed
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Sets the value of fecha_creacion.
     *
     * @param mixed $fecha_creacion the fecha creacion
     *
     * @return self
     */
    public function setFechaCreacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    /**
     * Gets the value of fecha_cierre.
     *
     * @return mixed
     */
    public function getFechaCierre()
    {
        return $this->fecha_cierre;
    }

    /**
     * Sets the value of fecha_cierre.
     *
     * @param mixed $fecha_cierre the fecha cierre
     *
     * @return self
     */
    public function setFechaCierre($fecha_cierre)
    {
        $this->fecha_cierre = $fecha_cierre;

        return $this;
    }


    /**
     * Gets the value of fk_observadores.
     *
     * @return mixed
     */
    public function getFKObservadores()
    {
        return $this->fk_observadores;
    }

    /**
     * Sets the value of fk_observadores.
     *
     * @param mixed $fecha_cierre the fecha cierre
     *
     * @return self
     */
    public function setFKObservadores($fk_observadores)
    {
        $this->fk_observadores = $fk_observadores;

        return $this;
    }    
}
