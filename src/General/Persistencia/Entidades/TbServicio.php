<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_servicio'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbServicio 
{
	
	private $codigo;
	private $sla_codigo;
	private $fk_id_usuario;
	private $tipo_servicio_codigo;
	private $fecha_creacion;
	private $telefono;
	private $contacto_principal;
	private $telefono_contacto;
	private $correo_contacto;
	private $titulo;
	private $descripcion;
	private $alcance;
	private $critica;
	private $alta;
	private $media;
	private $baja;
	private $planeada;
	private $disponibilidad;
	private $maximo_interrupciones;
	private $soporte_clientes;
	private $desempeno;
	private $reportes;
	private $glosario;
	private $tiempo_lotes;
	private $funcionalidad;
	private $maximo_errores;
	private $gestion_cambios;
	private $autoriza_cambios;
	private $continuidad_servicio;
	private $seguridad;
	private $responsabilidades;
	private $valor_limite;
	private $valor_adicional;


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
	 * Obtiene el valor de TIPO_SERVICIO_CODIGO
	 * @return mixed
	 */
	public function getTipoServicioCodigo()
	{
			return $this->tipo_servicio_codigo;
	}

	/**
	 * Asigna el valor para TIPO_SERVICIO_CODIGO
	 * @param mixed $tipo_servicio_codigo 
	 */
	public function setTipoServicioCodigo($tipo_servicio_codigo)
	{
			$this->tipo_servicio_codigo=$tipo_servicio_codigo;
	}

	/**
	 * Obtiene el valor de FECHA_CREACION
	 * @return mixed
	 */
	public function getFechaCreacion()
	{
			return $this->fecha_creacion;
	}

	/**
	 * Asigna el valor para FECHA_CREACION
	 * @param mixed $fecha_creacion 
	 */
	public function setFechaCreacion($fecha_creacion)
	{
			$this->fecha_creacion=$fecha_creacion;
	}

	/**
	 * Obtiene el valor de TELEFONO
	 * @return mixed
	 */
	public function getTelefono()
	{
			return $this->telefono;
	}

	/**
	 * Asigna el valor para TELEFONO
	 * @param mixed $telefono 
	 */
	public function setTelefono($telefono)
	{
			$this->telefono=$telefono;
	}

	/**
	 * Obtiene el valor de CONTACTO_PRINCIPAL
	 * @return mixed
	 */
	public function getContactoPrincipal()
	{
			return $this->contacto_principal;
	}

	/**
	 * Asigna el valor para CONTACTO_PRINCIPAL
	 * @param mixed $contacto_principal 
	 */
	public function setContactoPrincipal($contacto_principal)
	{
			$this->contacto_principal=$contacto_principal;
	}

	/**
	 * Obtiene el valor de TELEFONO_CONTACTO
	 * @return mixed
	 */
	public function getTelefonoContacto()
	{
			return $this->telefono_contacto;
	}

	/**
	 * Asigna el valor para TELEFONO_CONTACTO
	 * @param mixed $telefono_contacto 
	 */
	public function setTelefonoContacto($telefono_contacto)
	{
			$this->telefono_contacto=$telefono_contacto;
	}

	/**
	 * Obtiene el valor de CORREO_CONTACTO
	 * @return mixed
	 */
	public function getCorreoContacto()
	{
			return $this->correo_contacto;
	}

	/**
	 * Asigna el valor para CORREO_CONTACTO
	 * @param mixed $correo_contacto 
	 */
	public function setCorreoContacto($correo_contacto)
	{
			$this->correo_contacto=$correo_contacto;
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
	 * Obtiene el valor de DESCRIPCION
	 * @return mixed
	 */
	public function getDescripcion()
	{
			return $this->descripcion;
	}

	/**
	 * Asigna el valor para DESCRIPCION
	 * @param mixed $descripcion 
	 */
	public function setDescripcion($descripcion)
	{
			$this->descripcion=$descripcion;
	}

	/**
	 * Obtiene el valor de ALCANCE
	 * @return mixed
	 */
	public function getAlcance()
	{
			return $this->alcance;
	}

	/**
	 * Asigna el valor para ALCANCE
	 * @param mixed $alcance 
	 */
	public function setAlcance($alcance)
	{
			$this->alcance=$alcance;
	}

	/**
	 * Obtiene el valor de CRITICA
	 * @return mixed
	 */
	public function getCritica()
	{
			return $this->critica;
	}

	/**
	 * Asigna el valor para CRITICA
	 * @param mixed $critica 
	 */
	public function setCritica($critica)
	{
			$this->critica=$critica;
	}

	/**
	 * Obtiene el valor de ALTA
	 * @return mixed
	 */
	public function getAlta()
	{
			return $this->alta;
	}

	/**
	 * Asigna el valor para ALTA
	 * @param mixed $alta 
	 */
	public function setAlta($alta)
	{
			$this->alta=$alta;
	}

	/**
	 * Obtiene el valor de MEDIA
	 * @return mixed
	 */
	public function getMedia()
	{
			return $this->media;
	}

	/**
	 * Asigna el valor para MEDIA
	 * @param mixed $media 
	 */
	public function setMedia($media)
	{
			$this->media=$media;
	}

	/**
	 * Obtiene el valor de BAJA
	 * @return mixed
	 */
	public function getBaja()
	{
			return $this->baja;
	}

	/**
	 * Asigna el valor para BAJA
	 * @param mixed $baja 
	 */
	public function setBaja($baja)
	{
			$this->baja=$baja;
	}

	/**
	 * Obtiene el valor de PLANEADA
	 * @return mixed
	 */
	public function getPlaneada()
	{
			return $this->planeada;
	}

	/**
	 * Asigna el valor para PLANEADA
	 * @param mixed $planeada 
	 */
	public function setPlaneada($planeada)
	{
			$this->planeada=$planeada;
	}

	/**
	 * Obtiene el valor de DISPONIBILIDAD
	 * @return mixed
	 */
	public function getDisponibilidad()
	{
			return $this->disponibilidad;
	}

	/**
	 * Asigna el valor para DISPONIBILIDAD
	 * @param mixed $disponibilidad 
	 */
	public function setDisponibilidad($disponibilidad)
	{
			$this->disponibilidad=$disponibilidad;
	}

	/**
	 * Obtiene el valor de MAXIMO_INTERRUPCIONES
	 * @return mixed
	 */
	public function getMaximoInterrupciones()
	{
			return $this->maximo_interrupciones;
	}

	/**
	 * Asigna el valor para MAXIMO_INTERRUPCIONES
	 * @param mixed $maximo_interrupciones 
	 */
	public function setMaximoInterrupciones($maximo_interrupciones)
	{
			$this->maximo_interrupciones=$maximo_interrupciones;
	}

	/**
	 * Obtiene el valor de SOPORTE_CLIENTES
	 * @return mixed
	 */
	public function getSoporteClientes()
	{
			return $this->soporte_clientes;
	}

	/**
	 * Asigna el valor para SOPORTE_CLIENTES
	 * @param mixed $soporte_clientes 
	 */
	public function setSoporteClientes($soporte_clientes)
	{
			$this->soporte_clientes=$soporte_clientes;
	}

	/**
	 * Obtiene el valor de DESEMPENO
	 * @return mixed
	 */
	public function getDesempeno()
	{
			return $this->desempeno;
	}

	/**
	 * Asigna el valor para DESEMPENO
	 * @param mixed $desempeno 
	 */
	public function setDesempeno($desempeno)
	{
			$this->desempeno=$desempeno;
	}

	/**
	 * Obtiene el valor de REPORTES
	 * @return mixed
	 */
	public function getReportes()
	{
			return $this->reportes;
	}

	/**
	 * Asigna el valor para REPORTES
	 * @param mixed $reportes 
	 */
	public function setReportes($reportes)
	{
			$this->reportes=$reportes;
	}

	/**
	 * Obtiene el valor de GLOSARIO
	 * @return mixed
	 */
	public function getGlosario()
	{
			return $this->glosario;
	}

	/**
	 * Asigna el valor para GLOSARIO
	 * @param mixed $glosario 
	 */
	public function setGlosario($glosario)
	{
			$this->glosario=$glosario;
	}

	/**
	 * Obtiene el valor de TIEMPO_LOTES
	 * @return mixed
	 */
	public function getTiempoLotes()
	{
			return $this->tiempo_lotes;
	}

	/**
	 * Asigna el valor para TIEMPO_LOTES
	 * @param mixed $tiempo_lotes 
	 */
	public function setTiempoLotes($tiempo_lotes)
	{
			$this->tiempo_lotes=$tiempo_lotes;
	}

	/**
	 * Obtiene el valor de FUNCIONALIDAD
	 * @return mixed
	 */
	public function getFuncionalidad()
	{
			return $this->funcionalidad;
	}

	/**
	 * Asigna el valor para FUNCIONALIDAD
	 * @param mixed $funcionalidad 
	 */
	public function setFuncionalidad($funcionalidad)
	{
			$this->funcionalidad=$funcionalidad;
	}

	/**
	 * Obtiene el valor de MAXIMO_ERRORES
	 * @return mixed
	 */
	public function getMaximoErrores()
	{
			return $this->maximo_errores;
	}

	/**
	 * Asigna el valor para MAXIMO_ERRORES
	 * @param mixed $maximo_errores 
	 */
	public function setMaximoErrores($maximo_errores)
	{
			$this->maximo_errores=$maximo_errores;
	}

	/**
	 * Obtiene el valor de GESTION_CAMBIOS
	 * @return mixed
	 */
	public function getGestionCambios()
	{
			return $this->gestion_cambios;
	}

	/**
	 * Asigna el valor para GESTION_CAMBIOS
	 * @param mixed $gestion_cambios 
	 */
	public function setGestionCambios($gestion_cambios)
	{
			$this->gestion_cambios=$gestion_cambios;
	}

	/**
	 * Obtiene el valor de AUTORIZA_CAMBIOS
	 * @return mixed
	 */
	public function getAutorizaCambios()
	{
			return $this->autoriza_cambios;
	}

	/**
	 * Asigna el valor para AUTORIZA_CAMBIOS
	 * @param mixed $autoriza_cambios 
	 */
	public function setAutorizaCambios($autoriza_cambios)
	{
			$this->autoriza_cambios=$autoriza_cambios;
	}

	/**
	 * Obtiene el valor de CONTINUIDAD_SERVICIO
	 * @return mixed
	 */
	public function getContinuidadServicio()
	{
			return $this->continuidad_servicio;
	}

	/**
	 * Asigna el valor para CONTINUIDAD_SERVICIO
	 * @param mixed $continuidad_servicio 
	 */
	public function setContinuidadServicio($continuidad_servicio)
	{
			$this->continuidad_servicio=$continuidad_servicio;
	}

	/**
	 * Obtiene el valor de SEGURIDAD
	 * @return mixed
	 */
	public function getSeguridad()
	{
			return $this->seguridad;
	}

	/**
	 * Asigna el valor para SEGURIDAD
	 * @param mixed $seguridad 
	 */
	public function setSeguridad($seguridad)
	{
			$this->seguridad=$seguridad;
	}

	/**
	 * Obtiene el valor de RESPONSABILIDADES
	 * @return mixed
	 */
	public function getResponsabilidades()
	{
			return $this->responsabilidades;
	}

	/**
	 * Asigna el valor para RESPONSABILIDADES
	 * @param mixed $responsabilidades 
	 */
	public function setResponsabilidades($responsabilidades)
	{
			$this->responsabilidades=$responsabilidades;
	}

	/**
	 * Obtiene el valor de VALOR_LIMITE
	 * @return mixed
	 */
	public function getValorLimite()
	{
			return $this->valor_limite;
	}

	/**
	 * Asigna el valor para VALOR_LIMITE
	 * @param mixed $valor_limite 
	 */
	public function setValorLimite($valor_limite)
	{
			$this->valor_limite=$valor_limite;
	}

	/**
	 * Obtiene el valor de VALOR_ADICIONAL
	 * @return mixed
	 */
	public function getValorAdicional()
	{
			return $this->valor_adicional;
	}

	/**
	 * Asigna el valor para VALOR_ADICIONAL
	 * @param mixed $valor_adicional 
	 */
	public function setValorAdicional($valor_adicional)
	{
			$this->valor_adicional=$valor_adicional;
	}


}
