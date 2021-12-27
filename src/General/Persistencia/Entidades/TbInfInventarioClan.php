<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_inf_inventario_clan'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-06-25 17:53	 
 */
class TbInfInventarioClan 
{
	
	private $pk_id_inventario;
	private $fk_id_clan;
	private $in_cantidad;
	private $fk_id_tipo_bien;
	private $vc_placa;
	private $fk_id_elemento;
	private $vc_descripcion;
	private $fk_id_estado;
	private $fl_valor_unitario_inicial;
	private $vc_donante;
	private $fl_valor_total;
	private $in_estado_baja;
	private $vc_numero_traslado;
	private $da_fecha_registro;
	private $fk_usuario;
	private $fk_proyecto;


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
    			if($where==='')
    				$where.=$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
    			else
    				$where.=' AND '.$tabla.'.'.$clave.$valor['signo'].$valor['valor'];
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
	 * Obtiene el valor de PK_Id_Inventario
	 * @return mixed
	 */
	public function getPkIdInventario()
	{
			return $this->pk_id_inventario;
	}

	/**
	 * Asigna el valor para PK_Id_Inventario
	 * @param mixed $pk_id_inventario 
	 */
	public function setPkIdInventario($pk_id_inventario)
	{
			$this->pk_id_inventario=$pk_id_inventario;
	}

	/**
	 * Obtiene el valor de FK_Id_Clan
	 * @return mixed
	 */
	public function getFkIdClan()
	{
			return $this->fk_id_clan;
	}

	/**
	 * Asigna el valor para FK_Id_Clan
	 * @param mixed $fk_id_clan 
	 */
	public function setFkIdClan($fk_id_clan)
	{
			$this->fk_id_clan=$fk_id_clan;
	}

	/**
	 * Obtiene el valor de IN_Cantidad
	 * @return mixed
	 */
	public function getInCantidad()
	{
			return $this->in_cantidad;
	}

	/**
	 * Asigna el valor para IN_Cantidad
	 * @param mixed $in_cantidad 
	 */
	public function setInCantidad($in_cantidad)
	{
			$this->in_cantidad=$in_cantidad;
	}

	/**
	 * Obtiene el valor de FK_Id_Tipo_Bien
	 * @return mixed
	 */
	public function getFkIdTipoBien()
	{
			return $this->fk_id_tipo_bien;
	}

	/**
	 * Asigna el valor para FK_Id_Tipo_Bien
	 * @param mixed $fk_id_tipo_bien 
	 */
	public function setFkIdTipoBien($fk_id_tipo_bien)
	{
			$this->fk_id_tipo_bien=$fk_id_tipo_bien;
	}

	/**
	 * Obtiene el valor de VC_Placa
	 * @return mixed
	 */
	public function getVcPlaca()
	{
			return $this->vc_placa;
	}

	/**
	 * Asigna el valor para VC_Placa
	 * @param mixed $vc_placa 
	 */
	public function setVcPlaca($vc_placa)
	{
			$this->vc_placa=$vc_placa;
	}

	/**
	 * Obtiene el valor de FK_Id_Elemento
	 * @return mixed
	 */
	public function getFkIdElemento()
	{
			return $this->fk_id_elemento;
	}

	/**
	 * Asigna el valor para FK_Id_Elemento
	 * @param mixed $fk_id_elemento 
	 */
	public function setFkIdElemento($fk_id_elemento)
	{
			$this->fk_id_elemento=$fk_id_elemento;
	}

	/**
	 * Obtiene el valor de VC_Descripcion
	 * @return mixed
	 */
	public function getVcDescripcion()
	{
			return $this->vc_descripcion;
	}

	/**
	 * Asigna el valor para VC_Descripcion
	 * @param mixed $vc_descripcion 
	 */
	public function setVcDescripcion($vc_descripcion)
	{
			$this->vc_descripcion=$vc_descripcion;
	}

	/**
	 * Obtiene el valor de FK_Id_Estado
	 * @return mixed
	 */
	public function getFkIdEstado()
	{
			return $this->fk_id_estado;
	}

	/**
	 * Asigna el valor para FK_Id_Estado
	 * @param mixed $fk_id_estado 
	 */
	public function setFkIdEstado($fk_id_estado)
	{
			$this->fk_id_estado=$fk_id_estado;
	}

	/**
	 * Obtiene el valor de FL_Valor_Unitario_Inicial
	 * @return mixed
	 */
	public function getFlValorUnitarioInicial()
	{
			return $this->fl_valor_unitario_inicial;
	}

	/**
	 * Asigna el valor para FL_Valor_Unitario_Inicial
	 * @param mixed $fl_valor_unitario_inicial 
	 */
	public function setFlValorUnitarioInicial($fl_valor_unitario_inicial)
	{
			$this->fl_valor_unitario_inicial=$fl_valor_unitario_inicial;
	}

	/**
	 * Obtiene el valor de VC_Donante
	 * @return mixed
	 */
	public function getVcDonante()
	{
			return $this->vc_donante;
	}

	/**
	 * Asigna el valor para VC_Donante
	 * @param mixed $vc_donante 
	 */
	public function setVcDonante($vc_donante)
	{
			$this->vc_donante=$vc_donante;
	}

	/**
	 * Obtiene el valor de FL_Valor_Total
	 * @return mixed
	 */
	public function getFlValorTotal()
	{
			return $this->fl_valor_total;
	}

	/**
	 * Asigna el valor para FL_Valor_Total
	 * @param mixed $fl_valor_total 
	 */
	public function setFlValorTotal($fl_valor_total)
	{
			$this->fl_valor_total=$fl_valor_total;
	}

	/**
	 * Obtiene el valor de IN_Estado_Baja
	 * @return mixed
	 */
	public function getInEstadoBaja()
	{
			return $this->in_estado_baja;
	}

	/**
	 * Asigna el valor para IN_Estado_Baja
	 * @param mixed $in_estado_baja 
	 */
	public function setInEstadoBaja($in_estado_baja)
	{
			$this->in_estado_baja=$in_estado_baja;
	}

	/**
	 * Obtiene el valor de VC_Numero_Traslado
	 * @return mixed
	 */
	public function getVcNumeroTraslado()
	{
			return $this->vc_numero_traslado;
	}

	/**
	 * Asigna el valor para VC_Numero_Traslado
	 * @param mixed $vc_numero_traslado 
	 */
	public function setVcNumeroTraslado($vc_numero_traslado)
	{
			$this->vc_numero_traslado=$vc_numero_traslado;
	}

	/**
	 * Obtiene el valor de DA_Fecha_Registro
	 * @return mixed
	 */
	public function getDaFechaRegistro()
	{
			return $this->da_fecha_registro;
	}

	/**
	 * Asigna el valor para DA_Fecha_Registro
	 * @param mixed $da_fecha_registro 
	 */
	public function setDaFechaRegistro($da_fecha_registro)
	{
			$this->da_fecha_registro=$da_fecha_registro;
	}

	/**
	 * Obtiene el valor de FK_Usuario
	 * @return mixed
	 */
	public function getFkUsuario()
	{
			return $this->fk_usuario;
	}

	/**
	 * Asigna el valor para FK_Usuario
	 * @param mixed $fk_usuario 
	 */
	public function setFkUsuario($fk_usuario)
	{
			$this->fk_usuario=$fk_usuario;
	}

	/**
	 * Obtiene el valor de FK_Proyecto
	 * @return mixed
	 */
	public function getFkProyecto()
	{
			return $this->fk_proyecto;
	}

	/**
	 * Asigna el valor para FK_Proyecto
	 * @param mixed $fk_usuario 
	 */
	public function setFkProyecto($fk_proyecto)
	{
			$this->fk_proyecto=$fk_proyecto;
	}


}
