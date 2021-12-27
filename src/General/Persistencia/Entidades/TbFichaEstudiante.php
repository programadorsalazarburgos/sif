<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_ficha_estudiante'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbFichaEstudiante 
{
	
	private $pk_id_ficha_estudiante;
	private $fk_id_persona;
	private $fk_id_clan;
	private $fk_id_colegio;
	private $fk_id_grado;
	private $vc_jornada;
	private $vc_nom_acudiente;
	private $vc_identificacion_acudiente;
	private $vc_telefono_acudiente;
	private $da_fecha_registro;
	private $id_usuario_registro;
	private $vc_nombre_archivo_identificacion;
	private $vc_url_identificacion;
	private $vc_nombre_archivo_recibo;
	private $vc_url_recibo_publico;


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
	 * Obtiene el valor de PK_Id_Ficha_Estudiante
	 * @return mixed
	 */
	public function getPkIdFichaEstudiante()
	{
			return $this->pk_id_ficha_estudiante;
	}

	/**
	 * Asigna el valor para PK_Id_Ficha_Estudiante
	 * @param mixed $pk_id_ficha_estudiante 
	 */
	public function setPkIdFichaEstudiante($pk_id_ficha_estudiante)
	{
			$this->pk_id_ficha_estudiante=$pk_id_ficha_estudiante;
	}

	/**
	 * Obtiene el valor de FK_Id_Persona
	 * @return mixed
	 */
	public function getFkIdPersona()
	{
			return $this->fk_id_persona;
	}

	/**
	 * Asigna el valor para FK_Id_Persona
	 * @param mixed $fk_id_persona 
	 */
	public function setFkIdPersona($fk_id_persona)
	{
			$this->fk_id_persona=$fk_id_persona;
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
	 * Obtiene el valor de FK_Id_Colegio
	 * @return mixed
	 */
	public function getFkIdColegio()
	{
			return $this->fk_id_colegio;
	}

	/**
	 * Asigna el valor para FK_Id_Colegio
	 * @param mixed $fk_id_colegio 
	 */
	public function setFkIdColegio($fk_id_colegio)
	{
			$this->fk_id_colegio=$fk_id_colegio;
	}

	/**
	 * Obtiene el valor de FK_Id_Grado
	 * @return mixed
	 */
	public function getFkIdGrado()
	{
			return $this->fk_id_grado;
	}

	/**
	 * Asigna el valor para FK_Id_Grado
	 * @param mixed $fk_id_grado 
	 */
	public function setFkIdGrado($fk_id_grado)
	{
			$this->fk_id_grado=$fk_id_grado;
	}

	/**
	 * Obtiene el valor de VC_Jornada
	 * @return mixed
	 */
	public function getVcJornada()
	{
			return $this->vc_jornada;
	}

	/**
	 * Asigna el valor para VC_Jornada
	 * @param mixed $vc_jornada 
	 */
	public function setVcJornada($vc_jornada)
	{
			$this->vc_jornada=$vc_jornada;
	}

	/**
	 * Obtiene el valor de VC_Nom_Acudiente
	 * @return mixed
	 */
	public function getVcNomAcudiente()
	{
			return $this->vc_nom_acudiente;
	}

	/**
	 * Asigna el valor para VC_Nom_Acudiente
	 * @param mixed $vc_nom_acudiente 
	 */
	public function setVcNomAcudiente($vc_nom_acudiente)
	{
			$this->vc_nom_acudiente=$vc_nom_acudiente;
	}

	/**
	 * Obtiene el valor de VC_Identificacion_Acudiente
	 * @return mixed
	 */
	public function getVcIdentificacionAcudiente()
	{
			return $this->vc_identificacion_acudiente;
	}

	/**
	 * Asigna el valor para VC_Identificacion_Acudiente
	 * @param mixed $vc_identificacion_acudiente 
	 */
	public function setVcIdentificacionAcudiente($vc_identificacion_acudiente)
	{
			$this->vc_identificacion_acudiente=$vc_identificacion_acudiente;
	}

	/**
	 * Obtiene el valor de VC_Telefono_Acudiente
	 * @return mixed
	 */
	public function getVcTelefonoAcudiente()
	{
			return $this->vc_telefono_acudiente;
	}

	/**
	 * Asigna el valor para VC_Telefono_Acudiente
	 * @param mixed $vc_telefono_acudiente 
	 */
	public function setVcTelefonoAcudiente($vc_telefono_acudiente)
	{
			$this->vc_telefono_acudiente=$vc_telefono_acudiente;
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
	 * Obtiene el valor de Id_Usuario_Registro
	 * @return mixed
	 */
	public function getIdUsuarioRegistro()
	{
			return $this->id_usuario_registro;
	}

	/**
	 * Asigna el valor para Id_Usuario_Registro
	 * @param mixed $id_usuario_registro 
	 */
	public function setIdUsuarioRegistro($id_usuario_registro)
	{
			$this->id_usuario_registro=$id_usuario_registro;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Archivo_Identificacion
	 * @return mixed
	 */
	public function getVcNombreArchivoIdentificacion()
	{
			return $this->vc_nombre_archivo_identificacion;
	}

	/**
	 * Asigna el valor para VC_Nombre_Archivo_Identificacion
	 * @param mixed $vc_nombre_archivo_identificacion 
	 */
	public function setVcNombreArchivoIdentificacion($vc_nombre_archivo_identificacion)
	{
			$this->vc_nombre_archivo_identificacion=$vc_nombre_archivo_identificacion;
	}

	/**
	 * Obtiene el valor de VC_URL_Identificacion
	 * @return mixed
	 */
	public function getVcUrlIdentificacion()
	{
			return $this->vc_url_identificacion;
	}

	/**
	 * Asigna el valor para VC_URL_Identificacion
	 * @param mixed $vc_url_identificacion 
	 */
	public function setVcUrlIdentificacion($vc_url_identificacion)
	{
			$this->vc_url_identificacion=$vc_url_identificacion;
	}

	/**
	 * Obtiene el valor de VC_Nombre_Archivo_Recibo
	 * @return mixed
	 */
	public function getVcNombreArchivoRecibo()
	{
			return $this->vc_nombre_archivo_recibo;
	}

	/**
	 * Asigna el valor para VC_Nombre_Archivo_Recibo
	 * @param mixed $vc_nombre_archivo_recibo 
	 */
	public function setVcNombreArchivoRecibo($vc_nombre_archivo_recibo)
	{
			$this->vc_nombre_archivo_recibo=$vc_nombre_archivo_recibo;
	}

	/**
	 * Obtiene el valor de VC_URL_Recibo_Publico
	 * @return mixed
	 */
	public function getVcUrlReciboPublico()
	{
			return $this->vc_url_recibo_publico;
	}

	/**
	 * Asigna el valor para VC_URL_Recibo_Publico
	 * @param mixed $vc_url_recibo_publico 
	 */
	public function setVcUrlReciboPublico($vc_url_recibo_publico)
	{
			$this->vc_url_recibo_publico=$vc_url_recibo_publico;
	}


}
