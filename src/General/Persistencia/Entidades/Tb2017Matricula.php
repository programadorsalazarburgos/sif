<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_2017_matricula'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class Tb2017Matricula 
{
	
	private $numero_localidad;
	private $nombre_localidad;
	private $no_upz;
	private $nombre_upz;
	private $clase;
	private $dane11_establecimiento_educativo;
	private $nombre_establecimiento_educativo;
	private $ano_inf;
	private $mun_codigo;
	private $codigo_dane;
	private $dane_anterior;
	private $cons_sede;
	private $expr1012;
	private $tipo_documento;
	private $nro_documento;
	private $exp_depto;
	private $exp_mun;
	private $apellido1;
	private $apellido2;
	private $nombre1;
	private $nombre2;
	private $direccion_residencia;
	private $tel;
	private $res_depto;
	private $res_mun;
	private $estrato;
	private $sisben;
	private $fecha_nacimiento;
	private $nac_depto;
	private $nac_mun;
	private $genero;
	private $pob_vict_conf;
	private $pob_vict_conf.descripcion campo;
	private $dpto_exp;
	private $mun_exp;
	private $proviene_sector_priv;
	private $proviene_otr_mun;
	private $tipo_discapacidad;
	private $tipo_discapacidad_descripcion_campo;
	private $cap_exc;
	private $cap_exc_descripcion_campo;
	private $etnia;
	private $res;
	private $ins_familiar;
	private $tipo_jornada;
	private $tipo_jornada_descripcion_campo;
	private $caracter;
	private $caracter_descripcion_campo;
	private $especialidad;
	private $especialidad_descripcion_campo;
	private $grado;
	private $nom_grado;
	private $nivel_escolaridad;
	private $grupo;
	private $metodologia;
	private $matricula_contratada;
	private $repitente;
	private $nuevo;
	private $sit_acad_ano_ant;
	private $con_alum_ano_ant;
	private $fue_recu;
	private $zon_alu;
	private $cab_familia;
	private $ben_mad_flia;
	private $ben_vet_fp;
	private $ben_her_nac;
	private $codigo_internado;
	private $codigo_valoracion_1;
	private $codigo_valoracion_2;
	private $num_convenio;
	private $per_id;
	private $tipo_documento_dos;


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
	 * Obtiene el valor de NUMERO_LOCALIDAD
	 * @return mixed
	 */
	public function getNumeroLocalidad()
	{
			return $this->numero_localidad;
	}

	/**
	 * Asigna el valor para NUMERO_LOCALIDAD
	 * @param mixed $numero_localidad 
	 */
	public function setNumeroLocalidad($numero_localidad)
	{
			$this->numero_localidad=$numero_localidad;
	}

	/**
	 * Obtiene el valor de NOMBRE_LOCALIDAD
	 * @return mixed
	 */
	public function getNombreLocalidad()
	{
			return $this->nombre_localidad;
	}

	/**
	 * Asigna el valor para NOMBRE_LOCALIDAD
	 * @param mixed $nombre_localidad 
	 */
	public function setNombreLocalidad($nombre_localidad)
	{
			$this->nombre_localidad=$nombre_localidad;
	}

	/**
	 * Obtiene el valor de No_UPZ
	 * @return mixed
	 */
	public function getNoUpz()
	{
			return $this->no_upz;
	}

	/**
	 * Asigna el valor para No_UPZ
	 * @param mixed $no_upz 
	 */
	public function setNoUpz($no_upz)
	{
			$this->no_upz=$no_upz;
	}

	/**
	 * Obtiene el valor de NOMBRE_UPZ
	 * @return mixed
	 */
	public function getNombreUpz()
	{
			return $this->nombre_upz;
	}

	/**
	 * Asigna el valor para NOMBRE_UPZ
	 * @param mixed $nombre_upz 
	 */
	public function setNombreUpz($nombre_upz)
	{
			$this->nombre_upz=$nombre_upz;
	}

	/**
	 * Obtiene el valor de CLASE
	 * @return mixed
	 */
	public function getClase()
	{
			return $this->clase;
	}

	/**
	 * Asigna el valor para CLASE
	 * @param mixed $clase 
	 */
	public function setClase($clase)
	{
			$this->clase=$clase;
	}

	/**
	 * Obtiene el valor de DANE11_ESTABLECIMIENTO_EDUCATIVO
	 * @return mixed
	 */
	public function getDane11EstablecimientoEducativo()
	{
			return $this->dane11_establecimiento_educativo;
	}

	/**
	 * Asigna el valor para DANE11_ESTABLECIMIENTO_EDUCATIVO
	 * @param mixed $dane11_establecimiento_educativo 
	 */
	public function setDane11EstablecimientoEducativo($dane11_establecimiento_educativo)
	{
			$this->dane11_establecimiento_educativo=$dane11_establecimiento_educativo;
	}

	/**
	 * Obtiene el valor de NOMBRE_ESTABLECIMIENTO_EDUCATIVO
	 * @return mixed
	 */
	public function getNombreEstablecimientoEducativo()
	{
			return $this->nombre_establecimiento_educativo;
	}

	/**
	 * Asigna el valor para NOMBRE_ESTABLECIMIENTO_EDUCATIVO
	 * @param mixed $nombre_establecimiento_educativo 
	 */
	public function setNombreEstablecimientoEducativo($nombre_establecimiento_educativo)
	{
			$this->nombre_establecimiento_educativo=$nombre_establecimiento_educativo;
	}

	/**
	 * Obtiene el valor de ANO_INF
	 * @return mixed
	 */
	public function getAnoInf()
	{
			return $this->ano_inf;
	}

	/**
	 * Asigna el valor para ANO_INF
	 * @param mixed $ano_inf 
	 */
	public function setAnoInf($ano_inf)
	{
			$this->ano_inf=$ano_inf;
	}

	/**
	 * Obtiene el valor de MUN_CODIGO
	 * @return mixed
	 */
	public function getMunCodigo()
	{
			return $this->mun_codigo;
	}

	/**
	 * Asigna el valor para MUN_CODIGO
	 * @param mixed $mun_codigo 
	 */
	public function setMunCodigo($mun_codigo)
	{
			$this->mun_codigo=$mun_codigo;
	}

	/**
	 * Obtiene el valor de CODIGO_DANE
	 * @return mixed
	 */
	public function getCodigoDane()
	{
			return $this->codigo_dane;
	}

	/**
	 * Asigna el valor para CODIGO_DANE
	 * @param mixed $codigo_dane 
	 */
	public function setCodigoDane($codigo_dane)
	{
			$this->codigo_dane=$codigo_dane;
	}

	/**
	 * Obtiene el valor de DANE_ANTERIOR
	 * @return mixed
	 */
	public function getDaneAnterior()
	{
			return $this->dane_anterior;
	}

	/**
	 * Asigna el valor para DANE_ANTERIOR
	 * @param mixed $dane_anterior 
	 */
	public function setDaneAnterior($dane_anterior)
	{
			$this->dane_anterior=$dane_anterior;
	}

	/**
	 * Obtiene el valor de CONS_SEDE
	 * @return mixed
	 */
	public function getConsSede()
	{
			return $this->cons_sede;
	}

	/**
	 * Asigna el valor para CONS_SEDE
	 * @param mixed $cons_sede 
	 */
	public function setConsSede($cons_sede)
	{
			$this->cons_sede=$cons_sede;
	}

	/**
	 * Obtiene el valor de Expr1012
	 * @return mixed
	 */
	public function getExpr1012()
	{
			return $this->expr1012;
	}

	/**
	 * Asigna el valor para Expr1012
	 * @param mixed $expr1012 
	 */
	public function setExpr1012($expr1012)
	{
			$this->expr1012=$expr1012;
	}

	/**
	 * Obtiene el valor de TIPO_DOCUMENTO
	 * @return mixed
	 */
	public function getTipoDocumento()
	{
			return $this->tipo_documento;
	}

	/**
	 * Asigna el valor para TIPO_DOCUMENTO
	 * @param mixed $tipo_documento 
	 */
	public function setTipoDocumento($tipo_documento)
	{
			$this->tipo_documento=$tipo_documento;
	}

	/**
	 * Obtiene el valor de NRO_DOCUMENTO
	 * @return mixed
	 */
	public function getNroDocumento()
	{
			return $this->nro_documento;
	}

	/**
	 * Asigna el valor para NRO_DOCUMENTO
	 * @param mixed $nro_documento 
	 */
	public function setNroDocumento($nro_documento)
	{
			$this->nro_documento=$nro_documento;
	}

	/**
	 * Obtiene el valor de EXP_DEPTO
	 * @return mixed
	 */
	public function getExpDepto()
	{
			return $this->exp_depto;
	}

	/**
	 * Asigna el valor para EXP_DEPTO
	 * @param mixed $exp_depto 
	 */
	public function setExpDepto($exp_depto)
	{
			$this->exp_depto=$exp_depto;
	}

	/**
	 * Obtiene el valor de EXP_MUN
	 * @return mixed
	 */
	public function getExpMun()
	{
			return $this->exp_mun;
	}

	/**
	 * Asigna el valor para EXP_MUN
	 * @param mixed $exp_mun 
	 */
	public function setExpMun($exp_mun)
	{
			$this->exp_mun=$exp_mun;
	}

	/**
	 * Obtiene el valor de APELLIDO1
	 * @return mixed
	 */
	public function getApellido1()
	{
			return $this->apellido1;
	}

	/**
	 * Asigna el valor para APELLIDO1
	 * @param mixed $apellido1 
	 */
	public function setApellido1($apellido1)
	{
			$this->apellido1=$apellido1;
	}

	/**
	 * Obtiene el valor de APELLIDO2
	 * @return mixed
	 */
	public function getApellido2()
	{
			return $this->apellido2;
	}

	/**
	 * Asigna el valor para APELLIDO2
	 * @param mixed $apellido2 
	 */
	public function setApellido2($apellido2)
	{
			$this->apellido2=$apellido2;
	}

	/**
	 * Obtiene el valor de NOMBRE1
	 * @return mixed
	 */
	public function getNombre1()
	{
			return $this->nombre1;
	}

	/**
	 * Asigna el valor para NOMBRE1
	 * @param mixed $nombre1 
	 */
	public function setNombre1($nombre1)
	{
			$this->nombre1=$nombre1;
	}

	/**
	 * Obtiene el valor de NOMBRE2
	 * @return mixed
	 */
	public function getNombre2()
	{
			return $this->nombre2;
	}

	/**
	 * Asigna el valor para NOMBRE2
	 * @param mixed $nombre2 
	 */
	public function setNombre2($nombre2)
	{
			$this->nombre2=$nombre2;
	}

	/**
	 * Obtiene el valor de DIRECCION_RESIDENCIA
	 * @return mixed
	 */
	public function getDireccionResidencia()
	{
			return $this->direccion_residencia;
	}

	/**
	 * Asigna el valor para DIRECCION_RESIDENCIA
	 * @param mixed $direccion_residencia 
	 */
	public function setDireccionResidencia($direccion_residencia)
	{
			$this->direccion_residencia=$direccion_residencia;
	}

	/**
	 * Obtiene el valor de TEL
	 * @return mixed
	 */
	public function getTel()
	{
			return $this->tel;
	}

	/**
	 * Asigna el valor para TEL
	 * @param mixed $tel 
	 */
	public function setTel($tel)
	{
			$this->tel=$tel;
	}

	/**
	 * Obtiene el valor de RES_DEPTO
	 * @return mixed
	 */
	public function getResDepto()
	{
			return $this->res_depto;
	}

	/**
	 * Asigna el valor para RES_DEPTO
	 * @param mixed $res_depto 
	 */
	public function setResDepto($res_depto)
	{
			$this->res_depto=$res_depto;
	}

	/**
	 * Obtiene el valor de RES_MUN
	 * @return mixed
	 */
	public function getResMun()
	{
			return $this->res_mun;
	}

	/**
	 * Asigna el valor para RES_MUN
	 * @param mixed $res_mun 
	 */
	public function setResMun($res_mun)
	{
			$this->res_mun=$res_mun;
	}

	/**
	 * Obtiene el valor de ESTRATO
	 * @return mixed
	 */
	public function getEstrato()
	{
			return $this->estrato;
	}

	/**
	 * Asigna el valor para ESTRATO
	 * @param mixed $estrato 
	 */
	public function setEstrato($estrato)
	{
			$this->estrato=$estrato;
	}

	/**
	 * Obtiene el valor de SISBEN
	 * @return mixed
	 */
	public function getSisben()
	{
			return $this->sisben;
	}

	/**
	 * Asigna el valor para SISBEN
	 * @param mixed $sisben 
	 */
	public function setSisben($sisben)
	{
			$this->sisben=$sisben;
	}

	/**
	 * Obtiene el valor de FECHA_NACIMIENTO
	 * @return mixed
	 */
	public function getFechaNacimiento()
	{
			return $this->fecha_nacimiento;
	}

	/**
	 * Asigna el valor para FECHA_NACIMIENTO
	 * @param mixed $fecha_nacimiento 
	 */
	public function setFechaNacimiento($fecha_nacimiento)
	{
			$this->fecha_nacimiento=$fecha_nacimiento;
	}

	/**
	 * Obtiene el valor de NAC_DEPTO
	 * @return mixed
	 */
	public function getNacDepto()
	{
			return $this->nac_depto;
	}

	/**
	 * Asigna el valor para NAC_DEPTO
	 * @param mixed $nac_depto 
	 */
	public function setNacDepto($nac_depto)
	{
			$this->nac_depto=$nac_depto;
	}

	/**
	 * Obtiene el valor de NAC_MUN
	 * @return mixed
	 */
	public function getNacMun()
	{
			return $this->nac_mun;
	}

	/**
	 * Asigna el valor para NAC_MUN
	 * @param mixed $nac_mun 
	 */
	public function setNacMun($nac_mun)
	{
			$this->nac_mun=$nac_mun;
	}

	/**
	 * Obtiene el valor de GENERO
	 * @return mixed
	 */
	public function getGenero()
	{
			return $this->genero;
	}

	/**
	 * Asigna el valor para GENERO
	 * @param mixed $genero 
	 */
	public function setGenero($genero)
	{
			$this->genero=$genero;
	}

	/**
	 * Obtiene el valor de POB_VICT_CONF
	 * @return mixed
	 */
	public function getPobVictConf()
	{
			return $this->pob_vict_conf;
	}

	/**
	 * Asigna el valor para POB_VICT_CONF
	 * @param mixed $pob_vict_conf 
	 */
	public function setPobVictConf($pob_vict_conf)
	{
			$this->pob_vict_conf=$pob_vict_conf;
	}

	/**
	 * Obtiene el valor de POB_VICT_CONF.DESCRIPCION CAMPO
	 * @return mixed
	 */
	public function getPobVictConf.descripcion campo()
	{
			return $this->pob_vict_conf.descripcion campo;
	}

	/**
	 * Asigna el valor para POB_VICT_CONF.DESCRIPCION CAMPO
	 * @param mixed $pob_vict_conf.descripcion campo 
	 */
	public function setPobVictConf.descripcion campo($pob_vict_conf.descripcion campo)
	{
			$this->pob_vict_conf.descripcion campo=$pob_vict_conf.descripcion campo;
	}

	/**
	 * Obtiene el valor de DPTO_EXP
	 * @return mixed
	 */
	public function getDptoExp()
	{
			return $this->dpto_exp;
	}

	/**
	 * Asigna el valor para DPTO_EXP
	 * @param mixed $dpto_exp 
	 */
	public function setDptoExp($dpto_exp)
	{
			$this->dpto_exp=$dpto_exp;
	}

	/**
	 * Obtiene el valor de MUN_EXP
	 * @return mixed
	 */
	public function getMunExp()
	{
			return $this->mun_exp;
	}

	/**
	 * Asigna el valor para MUN_EXP
	 * @param mixed $mun_exp 
	 */
	public function setMunExp($mun_exp)
	{
			$this->mun_exp=$mun_exp;
	}

	/**
	 * Obtiene el valor de PROVIENE_SECTOR_PRIV
	 * @return mixed
	 */
	public function getProvieneSectorPriv()
	{
			return $this->proviene_sector_priv;
	}

	/**
	 * Asigna el valor para PROVIENE_SECTOR_PRIV
	 * @param mixed $proviene_sector_priv 
	 */
	public function setProvieneSectorPriv($proviene_sector_priv)
	{
			$this->proviene_sector_priv=$proviene_sector_priv;
	}

	/**
	 * Obtiene el valor de PROVIENE_OTR_MUN
	 * @return mixed
	 */
	public function getProvieneOtrMun()
	{
			return $this->proviene_otr_mun;
	}

	/**
	 * Asigna el valor para PROVIENE_OTR_MUN
	 * @param mixed $proviene_otr_mun 
	 */
	public function setProvieneOtrMun($proviene_otr_mun)
	{
			$this->proviene_otr_mun=$proviene_otr_mun;
	}

	/**
	 * Obtiene el valor de TIPO_DISCAPACIDAD
	 * @return mixed
	 */
	public function getTipoDiscapacidad()
	{
			return $this->tipo_discapacidad;
	}

	/**
	 * Asigna el valor para TIPO_DISCAPACIDAD
	 * @param mixed $tipo_discapacidad 
	 */
	public function setTipoDiscapacidad($tipo_discapacidad)
	{
			$this->tipo_discapacidad=$tipo_discapacidad;
	}

	/**
	 * Obtiene el valor de TIPO_DISCAPACIDAD_DESCRIPCION_CAMPO
	 * @return mixed
	 */
	public function getTipoDiscapacidadDescripcionCampo()
	{
			return $this->tipo_discapacidad_descripcion_campo;
	}

	/**
	 * Asigna el valor para TIPO_DISCAPACIDAD_DESCRIPCION_CAMPO
	 * @param mixed $tipo_discapacidad_descripcion_campo 
	 */
	public function setTipoDiscapacidadDescripcionCampo($tipo_discapacidad_descripcion_campo)
	{
			$this->tipo_discapacidad_descripcion_campo=$tipo_discapacidad_descripcion_campo;
	}

	/**
	 * Obtiene el valor de CAP_EXC
	 * @return mixed
	 */
	public function getCapExc()
	{
			return $this->cap_exc;
	}

	/**
	 * Asigna el valor para CAP_EXC
	 * @param mixed $cap_exc 
	 */
	public function setCapExc($cap_exc)
	{
			$this->cap_exc=$cap_exc;
	}

	/**
	 * Obtiene el valor de CAP_EXC_DESCRIPCION_CAMPO
	 * @return mixed
	 */
	public function getCapExcDescripcionCampo()
	{
			return $this->cap_exc_descripcion_campo;
	}

	/**
	 * Asigna el valor para CAP_EXC_DESCRIPCION_CAMPO
	 * @param mixed $cap_exc_descripcion_campo 
	 */
	public function setCapExcDescripcionCampo($cap_exc_descripcion_campo)
	{
			$this->cap_exc_descripcion_campo=$cap_exc_descripcion_campo;
	}

	/**
	 * Obtiene el valor de ETNIA
	 * @return mixed
	 */
	public function getEtnia()
	{
			return $this->etnia;
	}

	/**
	 * Asigna el valor para ETNIA
	 * @param mixed $etnia 
	 */
	public function setEtnia($etnia)
	{
			$this->etnia=$etnia;
	}

	/**
	 * Obtiene el valor de RES
	 * @return mixed
	 */
	public function getRes()
	{
			return $this->res;
	}

	/**
	 * Asigna el valor para RES
	 * @param mixed $res 
	 */
	public function setRes($res)
	{
			$this->res=$res;
	}

	/**
	 * Obtiene el valor de INS_FAMILIAR
	 * @return mixed
	 */
	public function getInsFamiliar()
	{
			return $this->ins_familiar;
	}

	/**
	 * Asigna el valor para INS_FAMILIAR
	 * @param mixed $ins_familiar 
	 */
	public function setInsFamiliar($ins_familiar)
	{
			$this->ins_familiar=$ins_familiar;
	}

	/**
	 * Obtiene el valor de TIPO_JORNADA
	 * @return mixed
	 */
	public function getTipoJornada()
	{
			return $this->tipo_jornada;
	}

	/**
	 * Asigna el valor para TIPO_JORNADA
	 * @param mixed $tipo_jornada 
	 */
	public function setTipoJornada($tipo_jornada)
	{
			$this->tipo_jornada=$tipo_jornada;
	}

	/**
	 * Obtiene el valor de TIPO_JORNADA_DESCRIPCION_CAMPO
	 * @return mixed
	 */
	public function getTipoJornadaDescripcionCampo()
	{
			return $this->tipo_jornada_descripcion_campo;
	}

	/**
	 * Asigna el valor para TIPO_JORNADA_DESCRIPCION_CAMPO
	 * @param mixed $tipo_jornada_descripcion_campo 
	 */
	public function setTipoJornadaDescripcionCampo($tipo_jornada_descripcion_campo)
	{
			$this->tipo_jornada_descripcion_campo=$tipo_jornada_descripcion_campo;
	}

	/**
	 * Obtiene el valor de CARACTER
	 * @return mixed
	 */
	public function getCaracter()
	{
			return $this->caracter;
	}

	/**
	 * Asigna el valor para CARACTER
	 * @param mixed $caracter 
	 */
	public function setCaracter($caracter)
	{
			$this->caracter=$caracter;
	}

	/**
	 * Obtiene el valor de CARACTER_DESCRIPCION_CAMPO
	 * @return mixed
	 */
	public function getCaracterDescripcionCampo()
	{
			return $this->caracter_descripcion_campo;
	}

	/**
	 * Asigna el valor para CARACTER_DESCRIPCION_CAMPO
	 * @param mixed $caracter_descripcion_campo 
	 */
	public function setCaracterDescripcionCampo($caracter_descripcion_campo)
	{
			$this->caracter_descripcion_campo=$caracter_descripcion_campo;
	}

	/**
	 * Obtiene el valor de ESPECIALIDAD
	 * @return mixed
	 */
	public function getEspecialidad()
	{
			return $this->especialidad;
	}

	/**
	 * Asigna el valor para ESPECIALIDAD
	 * @param mixed $especialidad 
	 */
	public function setEspecialidad($especialidad)
	{
			$this->especialidad=$especialidad;
	}

	/**
	 * Obtiene el valor de ESPECIALIDAD_DESCRIPCION_CAMPO
	 * @return mixed
	 */
	public function getEspecialidadDescripcionCampo()
	{
			return $this->especialidad_descripcion_campo;
	}

	/**
	 * Asigna el valor para ESPECIALIDAD_DESCRIPCION_CAMPO
	 * @param mixed $especialidad_descripcion_campo 
	 */
	public function setEspecialidadDescripcionCampo($especialidad_descripcion_campo)
	{
			$this->especialidad_descripcion_campo=$especialidad_descripcion_campo;
	}

	/**
	 * Obtiene el valor de GRADO
	 * @return mixed
	 */
	public function getGrado()
	{
			return $this->grado;
	}

	/**
	 * Asigna el valor para GRADO
	 * @param mixed $grado 
	 */
	public function setGrado($grado)
	{
			$this->grado=$grado;
	}

	/**
	 * Obtiene el valor de NOM_GRADO
	 * @return mixed
	 */
	public function getNomGrado()
	{
			return $this->nom_grado;
	}

	/**
	 * Asigna el valor para NOM_GRADO
	 * @param mixed $nom_grado 
	 */
	public function setNomGrado($nom_grado)
	{
			$this->nom_grado=$nom_grado;
	}

	/**
	 * Obtiene el valor de NIVEL_ESCOLARIDAD
	 * @return mixed
	 */
	public function getNivelEscolaridad()
	{
			return $this->nivel_escolaridad;
	}

	/**
	 * Asigna el valor para NIVEL_ESCOLARIDAD
	 * @param mixed $nivel_escolaridad 
	 */
	public function setNivelEscolaridad($nivel_escolaridad)
	{
			$this->nivel_escolaridad=$nivel_escolaridad;
	}

	/**
	 * Obtiene el valor de GRUPO
	 * @return mixed
	 */
	public function getGrupo()
	{
			return $this->grupo;
	}

	/**
	 * Asigna el valor para GRUPO
	 * @param mixed $grupo 
	 */
	public function setGrupo($grupo)
	{
			$this->grupo=$grupo;
	}

	/**
	 * Obtiene el valor de METODOLOGIA
	 * @return mixed
	 */
	public function getMetodologia()
	{
			return $this->metodologia;
	}

	/**
	 * Asigna el valor para METODOLOGIA
	 * @param mixed $metodologia 
	 */
	public function setMetodologia($metodologia)
	{
			$this->metodologia=$metodologia;
	}

	/**
	 * Obtiene el valor de MATRICULA_CONTRATADA
	 * @return mixed
	 */
	public function getMatriculaContratada()
	{
			return $this->matricula_contratada;
	}

	/**
	 * Asigna el valor para MATRICULA_CONTRATADA
	 * @param mixed $matricula_contratada 
	 */
	public function setMatriculaContratada($matricula_contratada)
	{
			$this->matricula_contratada=$matricula_contratada;
	}

	/**
	 * Obtiene el valor de REPITENTE
	 * @return mixed
	 */
	public function getRepitente()
	{
			return $this->repitente;
	}

	/**
	 * Asigna el valor para REPITENTE
	 * @param mixed $repitente 
	 */
	public function setRepitente($repitente)
	{
			$this->repitente=$repitente;
	}

	/**
	 * Obtiene el valor de NUEVO
	 * @return mixed
	 */
	public function getNuevo()
	{
			return $this->nuevo;
	}

	/**
	 * Asigna el valor para NUEVO
	 * @param mixed $nuevo 
	 */
	public function setNuevo($nuevo)
	{
			$this->nuevo=$nuevo;
	}

	/**
	 * Obtiene el valor de SIT_ACAD_ANO_ANT
	 * @return mixed
	 */
	public function getSitAcadAnoAnt()
	{
			return $this->sit_acad_ano_ant;
	}

	/**
	 * Asigna el valor para SIT_ACAD_ANO_ANT
	 * @param mixed $sit_acad_ano_ant 
	 */
	public function setSitAcadAnoAnt($sit_acad_ano_ant)
	{
			$this->sit_acad_ano_ant=$sit_acad_ano_ant;
	}

	/**
	 * Obtiene el valor de CON_ALUM_ANO_ANT
	 * @return mixed
	 */
	public function getConAlumAnoAnt()
	{
			return $this->con_alum_ano_ant;
	}

	/**
	 * Asigna el valor para CON_ALUM_ANO_ANT
	 * @param mixed $con_alum_ano_ant 
	 */
	public function setConAlumAnoAnt($con_alum_ano_ant)
	{
			$this->con_alum_ano_ant=$con_alum_ano_ant;
	}

	/**
	 * Obtiene el valor de FUE_RECU
	 * @return mixed
	 */
	public function getFueRecu()
	{
			return $this->fue_recu;
	}

	/**
	 * Asigna el valor para FUE_RECU
	 * @param mixed $fue_recu 
	 */
	public function setFueRecu($fue_recu)
	{
			$this->fue_recu=$fue_recu;
	}

	/**
	 * Obtiene el valor de ZON_ALU
	 * @return mixed
	 */
	public function getZonAlu()
	{
			return $this->zon_alu;
	}

	/**
	 * Asigna el valor para ZON_ALU
	 * @param mixed $zon_alu 
	 */
	public function setZonAlu($zon_alu)
	{
			$this->zon_alu=$zon_alu;
	}

	/**
	 * Obtiene el valor de CAB_FAMILIA
	 * @return mixed
	 */
	public function getCabFamilia()
	{
			return $this->cab_familia;
	}

	/**
	 * Asigna el valor para CAB_FAMILIA
	 * @param mixed $cab_familia 
	 */
	public function setCabFamilia($cab_familia)
	{
			$this->cab_familia=$cab_familia;
	}

	/**
	 * Obtiene el valor de BEN_MAD_FLIA
	 * @return mixed
	 */
	public function getBenMadFlia()
	{
			return $this->ben_mad_flia;
	}

	/**
	 * Asigna el valor para BEN_MAD_FLIA
	 * @param mixed $ben_mad_flia 
	 */
	public function setBenMadFlia($ben_mad_flia)
	{
			$this->ben_mad_flia=$ben_mad_flia;
	}

	/**
	 * Obtiene el valor de BEN_VET_FP
	 * @return mixed
	 */
	public function getBenVetFp()
	{
			return $this->ben_vet_fp;
	}

	/**
	 * Asigna el valor para BEN_VET_FP
	 * @param mixed $ben_vet_fp 
	 */
	public function setBenVetFp($ben_vet_fp)
	{
			$this->ben_vet_fp=$ben_vet_fp;
	}

	/**
	 * Obtiene el valor de BEN_HER_NAC
	 * @return mixed
	 */
	public function getBenHerNac()
	{
			return $this->ben_her_nac;
	}

	/**
	 * Asigna el valor para BEN_HER_NAC
	 * @param mixed $ben_her_nac 
	 */
	public function setBenHerNac($ben_her_nac)
	{
			$this->ben_her_nac=$ben_her_nac;
	}

	/**
	 * Obtiene el valor de CODIGO_INTERNADO
	 * @return mixed
	 */
	public function getCodigoInternado()
	{
			return $this->codigo_internado;
	}

	/**
	 * Asigna el valor para CODIGO_INTERNADO
	 * @param mixed $codigo_internado 
	 */
	public function setCodigoInternado($codigo_internado)
	{
			$this->codigo_internado=$codigo_internado;
	}

	/**
	 * Obtiene el valor de CODIGO_VALORACION_1
	 * @return mixed
	 */
	public function getCodigoValoracion1()
	{
			return $this->codigo_valoracion_1;
	}

	/**
	 * Asigna el valor para CODIGO_VALORACION_1
	 * @param mixed $codigo_valoracion_1 
	 */
	public function setCodigoValoracion1($codigo_valoracion_1)
	{
			$this->codigo_valoracion_1=$codigo_valoracion_1;
	}

	/**
	 * Obtiene el valor de CODIGO_VALORACION_2
	 * @return mixed
	 */
	public function getCodigoValoracion2()
	{
			return $this->codigo_valoracion_2;
	}

	/**
	 * Asigna el valor para CODIGO_VALORACION_2
	 * @param mixed $codigo_valoracion_2 
	 */
	public function setCodigoValoracion2($codigo_valoracion_2)
	{
			$this->codigo_valoracion_2=$codigo_valoracion_2;
	}

	/**
	 * Obtiene el valor de NUM_CONVENIO
	 * @return mixed
	 */
	public function getNumConvenio()
	{
			return $this->num_convenio;
	}

	/**
	 * Asigna el valor para NUM_CONVENIO
	 * @param mixed $num_convenio 
	 */
	public function setNumConvenio($num_convenio)
	{
			$this->num_convenio=$num_convenio;
	}

	/**
	 * Obtiene el valor de PER_ID
	 * @return mixed
	 */
	public function getPerId()
	{
			return $this->per_id;
	}

	/**
	 * Asigna el valor para PER_ID
	 * @param mixed $per_id 
	 */
	public function setPerId($per_id)
	{
			$this->per_id=$per_id;
	}

	/**
	 * Obtiene el valor de TIPO_DOCUMENTO_DOS
	 * @return mixed
	 */
	public function getTipoDocumentoDos()
	{
			return $this->tipo_documento_dos;
	}

	/**
	 * Asigna el valor para TIPO_DOCUMENTO_DOS
	 * @param mixed $tipo_documento_dos 
	 */
	public function setTipoDocumentoDos($tipo_documento_dos)
	{
			$this->tipo_documento_dos=$tipo_documento_dos;
	}


}
