<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_caracterizacion_grupo'
 *
 * @author: Juan Modesto, gracias a http://phpdao.com
 * @date: 2019-04-05 16:09	 
 */
class TbCaracterizacionGrupo 
{
	
	private $pk_id_caracterizacion;
	private $fk_grupo;
	private $fk_id_linea_atencion;
	private $fk_ciclo;
	private $tx_descripcion_grupo;
	private $in_escala_convivencia;
	private $tx_convivencia;
	private $tx_array_intereses;
	private $tx_descripcion_intereses;
	private $in_escala_actitudinal;
	private $tx_actitudinal;
	private $in_escala_cognitiva;
	private $tx_cognitiva;
	private $in_escala_procedimental;
	private $tx_procedimental;
	private $vc_necesidades;
	private $vc_etnias;
	private $tx_particularidades;
	private $tx_descripcion_espacio;
	private $tx_observaciones;
	private $fk_id_usuario_registro;
	private $da_fecha_registro;
	private $in_version;
	private $vc_tipo;
	private $in_finalizado;
	private $in_estado;


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
	 * Obtiene el valor de PK_Id_Caracterizacion
	 * @return mixed
	 */
	public function getPkIdCaracterizacion()
	{
		return $this->pk_id_caracterizacion;
	}

	/**
	 * Asigna el valor para PK_Id_Caracterizacion
	 * @param mixed $pk_id_caracterizacion 
	 */
	public function setPkIdCaracterizacion($pk_id_caracterizacion)
	{
		$this->pk_id_caracterizacion=$pk_id_caracterizacion;
	}

	/**
	 * Obtiene el valor de FK_Grupo
	 * @return mixed
	 */
	public function getFkGrupo()
	{
		return $this->fk_grupo;
	}

	/**
	 * Asigna el valor para FK_Grupo
	 * @param mixed $fk_grupo 
	 */
	public function setFkGrupo($fk_grupo)
	{
		$this->fk_grupo=$fk_grupo;
	}

	/**
	 * Obtiene el valor de FK_Id_Linea_Atencion
	 * @return mixed
	 */
	public function getFkIdLineaAtencion()
	{
		return $this->fk_id_linea_atencion;
	}

	/**
	 * Asigna el valor para FK_Id_Linea_Atencion
	 * @param mixed $fk_id_linea_atencion 
	 */
	public function setFkIdLineaAtencion($fk_id_linea_atencion)
	{
		$this->fk_id_linea_atencion=$fk_id_linea_atencion;
	}

	/**
	 * Obtiene el valor de FK_Ciclo
	 * @return mixed
	 */
	public function getFkCiclo()
	{
		return $this->fk_ciclo;
	}

	/**
	 * Asigna el valor para FK_Ciclo
	 * @param mixed $fk_ciclo 
	 */
	public function setFkCiclo($fk_ciclo)
	{
		$this->fk_ciclo=$fk_ciclo;
	}

	/**
	 * Obtiene el valor de TX_Descripcion_Grupo
	 * @return mixed
	 */
	public function getTxDescripcionGrupo()
	{
		return $this->tx_descripcion_grupo;
	}

	/**
	 * Asigna el valor para TX_Descripcion_Grupo
	 * @param mixed $tx_descripcion_grupo 
	 */
	public function setTxDescripcionGrupo($tx_descripcion_grupo)
	{
		$this->tx_descripcion_grupo=$tx_descripcion_grupo;
	}

	/**
	 * Obtiene el valor de IN_Escala_Convivencia
	 * @return mixed
	 */
	public function getInEscalaConvivencia()
	{
		return $this->in_escala_convivencia;
	}

	/**
	 * Asigna el valor para IN_Escala_Convivencia
	 * @param mixed $in_escala_convivencia 
	 */
	public function setInEscalaConvivencia($in_escala_convivencia)
	{
		$this->in_escala_convivencia=$in_escala_convivencia;
	}

	/**
	 * Obtiene el valor de TX_Convivencia
	 * @return mixed
	 */
	public function getTxConvivencia()
	{
		return $this->tx_convivencia;
	}

	/**
	 * Asigna el valor para TX_Convivencia
	 * @param mixed $tx_convivencia 
	 */
	public function setTxConvivencia($tx_convivencia)
	{
		$this->tx_convivencia=$tx_convivencia;
	}

	/**
	 * Obtiene el valor de TX_Array_Intereses
	 * @return mixed
	 */
	public function getTxArrayIntereses()
	{
		return $this->tx_array_intereses;
	}

	/**
	 * Asigna el valor para TX_Array_Intereses
	 * @param mixed $tx_array_intereses 
	 */
	public function setTxArrayIntereses($tx_array_intereses)
	{
		$this->tx_array_intereses=$tx_array_intereses;
	}

	/**
	 * Obtiene el valor de TX_Descripcion_Intereses
	 * @return mixed
	 */
	public function getTxDescripcionIntereses()
	{
		return $this->tx_descripcion_intereses;
	}

	/**
	 * Asigna el valor para TX_Descripcion_Intereses
	 * @param mixed $tx_descripcion_intereses 
	 */
	public function setTxDescripcionIntereses($tx_descripcion_intereses)
	{
		$this->tx_descripcion_intereses=$tx_descripcion_intereses;
	}

	/**
	 * Obtiene el valor de IN_Escala_Actitudinal
	 * @return mixed
	 */
	public function getInEscalaActitudinal()
	{
		return $this->in_escala_actitudinal;
	}

	/**
	 * Asigna el valor para IN_Escala_Actitudinal
	 * @param mixed $in_escala_actitudinal 
	 */
	public function setInEscalaActitudinal($in_escala_actitudinal)
	{
		$this->in_escala_actitudinal=$in_escala_actitudinal;
	}

	/**
	 * Obtiene el valor de TX_Actitudinal
	 * @return mixed
	 */
	public function getTxActitudinal()
	{
		return $this->tx_actitudinal;
	}

	/**
	 * Asigna el valor para TX_Actitudinal
	 * @param mixed $tx_actitudinal 
	 */
	public function setTxActitudinal($tx_actitudinal)
	{
		$this->tx_actitudinal=$tx_actitudinal;
	}

	/**
	 * Obtiene el valor de IN_Escala_Cognitiva
	 * @return mixed
	 */
	public function getInEscalaCognitiva()
	{
		return $this->in_escala_cognitiva;
	}

	/**
	 * Asigna el valor para IN_Escala_Cognitiva
	 * @param mixed $in_escala_cognitiva 
	 */
	public function setInEscalaCognitiva($in_escala_cognitiva)
	{
		$this->in_escala_cognitiva=$in_escala_cognitiva;
	}

	/**
	 * Obtiene el valor de TX_Cognitiva
	 * @return mixed
	 */
	public function getTxCognitiva()
	{
		return $this->tx_cognitiva;
	}

	/**
	 * Asigna el valor para TX_Cognitiva
	 * @param mixed $tx_cognitiva 
	 */
	public function setTxCognitiva($tx_cognitiva)
	{
		$this->tx_cognitiva=$tx_cognitiva;
	}

	/**
	 * Obtiene el valor de IN_Escala_Procedimental
	 * @return mixed
	 */
	public function getInEscalaProcedimental()
	{
		return $this->in_escala_procedimental;
	}

	/**
	 * Asigna el valor para IN_Escala_Procedimental
	 * @param mixed $in_escala_procedimental 
	 */
	public function setInEscalaProcedimental($in_escala_procedimental)
	{
		$this->in_escala_procedimental=$in_escala_procedimental;
	}

	/**
	 * Obtiene el valor de TX_Procedimental
	 * @return mixed
	 */
	public function getTxProcedimental()
	{
		return $this->tx_procedimental;
	}

	/**
	 * Asigna el valor para TX_Procedimental
	 * @param mixed $tx_procedimental 
	 */
	public function setTxProcedimental($tx_procedimental)
	{
		$this->tx_procedimental=$tx_procedimental;
	}

	/**
	 * Obtiene el valor de VC_Necesidades
	 * @return mixed
	 */
	public function getVcNecesidades()
	{
		return $this->vc_necesidades;
	}

	/**
	 * Asigna el valor para VC_Necesidades
	 * @param mixed $vc_necesidades 
	 */
	public function setVcNecesidades($vc_necesidades)
	{
		$this->vc_necesidades=$vc_necesidades;
	}

	/**
	 * Obtiene el valor de VC_Etnias
	 * @return mixed
	 */
	public function getVcEtnias()
	{
		return $this->vc_etnias;
	}

	/**
	 * Asigna el valor para VC_Etnias
	 * @param mixed $vc_etnias 
	 */
	public function setVcEtnias($vc_etnias)
	{
		$this->vc_etnias=$vc_etnias;
	}

	/**
	 * Obtiene el valor de TX_Particularidades
	 * @return mixed
	 */
	public function getTxParticularidades()
	{
		return $this->tx_particularidades;
	}

	/**
	 * Asigna el valor para TX_Particularidades
	 * @param mixed $tx_particularidades 
	 */
	public function setTxParticularidades($tx_particularidades)
	{
		$this->tx_particularidades=$tx_particularidades;
	}

	/**
	 * Obtiene el valor de TX_Descripcion_Espacio
	 * @return mixed
	 */
	public function getTxDescripcionEspacio()
	{
		return $this->tx_descripcion_espacio;
	}

	/**
	 * Asigna el valor para TX_Descripcion_Espacio
	 * @param mixed $tx_descripcion_espacio 
	 */
	public function setTxDescripcionEspacio($tx_descripcion_espacio)
	{
		$this->tx_descripcion_espacio=$tx_descripcion_espacio;
	}

	/**
	 * Obtiene el valor de TX_Observaciones
	 * @return mixed
	 */
	public function getTxObservaciones()
	{
		return $this->tx_observaciones;
	}

	/**
	 * Asigna el valor para TX_Observaciones
	 * @param mixed $tx_observaciones 
	 */
	public function setTxObservaciones($tx_observaciones)
	{
		$this->tx_observaciones=$tx_observaciones;
	}

	/**
	 * Obtiene el valor de FK_Id_Usuario_Registro
	 * @return mixed
	 */
	public function getFkIdUsuarioRegistro()
	{
		return $this->fk_id_usuario_registro;
	}

	/**
	 * Asigna el valor para FK_Id_Usuario_Registro
	 * @param mixed $fk_id_usuario_registro 
	 */
	public function setFkIdUsuarioRegistro($fk_id_usuario_registro)
	{
		$this->fk_id_usuario_registro=$fk_id_usuario_registro;
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
	 * Obtiene el valor de IN_Version
	 * @return mixed $in_version
	 */
	public function getInVersion()
	{
		return $this->in_version;
	}

	/**
	 * Asigna el valor para IN_Version
	 * @param mixed $in_version 
	 */
	public function setInVersion($in_version)
	{
		$this->in_version=$in_version;
	}

	/**
	 * Obtiene el valor de VC_Tipo
	 * @return mixed $vc_tipo
	 */
	public function getVcTipo()
	{
		return $this->vc_tipo;
	}

	/**
	 * Asigna el valor para VC_Tipo
	 * @param mixed $vc_tipo 
	 */
	public function setVcTipo($vc_tipo)
	{
		$this->vc_tipo=$vc_tipo;
	}

	/**
	 * Obtiene el valor de IN_Finalizado
	 * @return mixed $in_finalizado
	 */
	public function getInFinalizado()
	{
		return $this->in_finalizado;
	}

	/**
	 * Asigna el valor para IN_Finalizado
	 * @param mixed $in_finalizado 
	 */
	public function setInFinalizado($in_finalizado)
	{
		$this->in_finalizado=$in_finalizado;
	}

	/**
	 * Obtiene el valor de IN_Estado
	 * @return mixed $in_estado
	 */
	public function getInEstado()
	{
		return $this->in_estado;
	}

	/**
	 * Asigna el valor para IN_Estado
	 * @param mixed $in_estado 
	 */
	public function setInEstado($in_estado)
	{
		$this->in_estado=$in_estado;
	}


}
