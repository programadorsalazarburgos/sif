<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_incidente_historial'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-05-02 09:57	 
 */
class TbIncidenteHistorial 
{
	
	private $fecha;
	private $incidente_codigo;
	private $servicio_codigo;
	private $sla_codigo;
	private $fk_Funcionario_Anterior=NULL;   // para compatibilidad con NULL de MySql
	private $fk_Funcionario_Nuevo=NULL;  // para compatibilidad con NULL de MySql
	private $fk_id_usuario;  
	private $estado_anterior=NULL;  // para compatibilidad con NULL de MySql
	private $estado_nuevo=NULL;   // para compatibilidad con NULL de MySql


	


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
	 * Obtiene el valor de ESTADO_ANTERIOR
	 * @return mixed
	 */
	public function getEstadoAnterior()
	{
			return $this->estado_anterior;
	}

	/**
	 * Asigna el valor para ESTADO_ANTERIOR
	 * @param mixed $estado_anterior 
	 */
	public function setEstadoAnterior($estado_anterior)
	{
			$this->estado_anterior=$estado_anterior;
	}

	/**
	 * Obtiene el valor de ESTADO_NUEVO
	 * @return mixed
	 */
	public function getEstadoNuevo()
	{
			return $this->estado_nuevo;
	}

	/**
	 * Asigna el valor para ESTADO_NUEVO
	 * @param mixed $estado_nuevo 
	 */
	public function setEstadoNuevo($estado_nuevo)
	{
			$this->estado_nuevo=$estado_nuevo;
	}



    /**
     * Gets the value of fecha.
     *
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Sets the value of fecha.
     *
     * @param mixed $fecha the fecha
     *
     * @return self
     */
    private function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Gets the value of fk_Funcionario_Anterior.
     *
     * @return mixed
     */
    public function getFkFuncionarioAnterior()
    {
        return $this->fk_Funcionario_Anterior;
    }

    /**
     * Sets the value of fk_Funcionario_Anterior.
     *
     * @param mixed $fk_Funcionario_Anterior the fk funcionario anterior
     *
     * @return self
     */
    private function setFkFuncionarioAnterior($fk_Funcionario_Anterior)
    {
        $this->fk_Funcionario_Anterior = $fk_Funcionario_Anterior;

        return $this;
    }

    /**
     * Gets the value of fk_Funcionario_Nuevo.
     *
     * @return mixed
     */
    public function getFkFuncionarioNuevo()
    {
        return $this->fk_Funcionario_Nuevo;
    }

    /**
     * Sets the value of fk_Funcionario_Nuevo.
     *
     * @param mixed $fk_Funcionario_Nuevo the fk funcionario nuevo
     *
     * @return self
     */
    private function setFkFuncionarioNuevo($fk_Funcionario_Nuevo)
    {
        $this->fk_Funcionario_Nuevo = $fk_Funcionario_Nuevo;

        return $this;
    }
}
