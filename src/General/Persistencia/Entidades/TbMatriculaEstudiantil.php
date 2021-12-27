<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_matricula_estudiantil'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbMatriculaEstudiantil 
{
	
	private $pk_id_matricula;
	private $identificacion;
	private $tipo_identificacion;
	private $al_prim_apel;
	private $al_segu_apel;
	private $al_prim_nomb;
	private $al_segu_nomb;
	private $grado;
	private $tipo_institucion;
	private $institucion;
	private $dane_11;
	private $dane_12;
	private $jornada;
	private $loc_inst;
	private $grupo;
	private $dane_sede;
	private $sede;
	private $estado;
	private $estrato_calc;
	private $genero;
	private $fecha_nacimiento;
	private $deficiencia;
	private $sisben_calc;
	private $tel_alumno;
	private $direccion;
	private $barrio;
	private $otro_barrio;
	private $loc_alumno;
	private $tipo_comunidad;
	private $rh;
	private $grupo_sang;
	private $al_nomb_acud;
	private $id_acud;
	private $tel_acud;
	private $movil;
	private $mail_acud;
	private $al_padr_nomb;
	private $id_padre;
	private $tel_padre;
	private $cel_padre;
	private $mail_padre;
	private $al_madr_nomb;
	private $id_madre;
	private $al_madr_tel;
	private $cel_madre;
	private $mail_madre;
	private $marca_talento;
	private $puntaje_te;
	private $nomb_talento;
	private $desc_talento;
	private $etnias;
	private $upz_alumno;
	private $edad_calc;
	private $ao_estado;
	private $fecha_estado;
	private $cod_alumno;
	private $fecha_actualizacion;


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
	 * Obtiene el valor de Pk_Id_Matricula
	 * @return mixed
	 */
	public function getPkIdMatricula()
	{
			return $this->pk_id_matricula;
	}

	/**
	 * Asigna el valor para Pk_Id_Matricula
	 * @param mixed $pk_id_matricula 
	 */
	public function setPkIdMatricula($pk_id_matricula)
	{
			$this->pk_id_matricula=$pk_id_matricula;
	}

	/**
	 * Obtiene el valor de IDENTIFICACION
	 * @return mixed
	 */
	public function getIdentificacion()
	{
			return $this->identificacion;
	}

	/**
	 * Asigna el valor para IDENTIFICACION
	 * @param mixed $identificacion 
	 */
	public function setIdentificacion($identificacion)
	{
			$this->identificacion=$identificacion;
	}

	/**
	 * Obtiene el valor de TIPO_IDENTIFICACION
	 * @return mixed
	 */
	public function getTipoIdentificacion()
	{
			return $this->tipo_identificacion;
	}

	/**
	 * Asigna el valor para TIPO_IDENTIFICACION
	 * @param mixed $tipo_identificacion 
	 */
	public function setTipoIdentificacion($tipo_identificacion)
	{
			$this->tipo_identificacion=$tipo_identificacion;
	}

	/**
	 * Obtiene el valor de AL_PRIM_APEL
	 * @return mixed
	 */
	public function getAlPrimApel()
	{
			return $this->al_prim_apel;
	}

	/**
	 * Asigna el valor para AL_PRIM_APEL
	 * @param mixed $al_prim_apel 
	 */
	public function setAlPrimApel($al_prim_apel)
	{
			$this->al_prim_apel=$al_prim_apel;
	}

	/**
	 * Obtiene el valor de AL_SEGU_APEL
	 * @return mixed
	 */
	public function getAlSeguApel()
	{
			return $this->al_segu_apel;
	}

	/**
	 * Asigna el valor para AL_SEGU_APEL
	 * @param mixed $al_segu_apel 
	 */
	public function setAlSeguApel($al_segu_apel)
	{
			$this->al_segu_apel=$al_segu_apel;
	}

	/**
	 * Obtiene el valor de AL_PRIM_NOMB
	 * @return mixed
	 */
	public function getAlPrimNomb()
	{
			return $this->al_prim_nomb;
	}

	/**
	 * Asigna el valor para AL_PRIM_NOMB
	 * @param mixed $al_prim_nomb 
	 */
	public function setAlPrimNomb($al_prim_nomb)
	{
			$this->al_prim_nomb=$al_prim_nomb;
	}

	/**
	 * Obtiene el valor de AL_SEGU_NOMB
	 * @return mixed
	 */
	public function getAlSeguNomb()
	{
			return $this->al_segu_nomb;
	}

	/**
	 * Asigna el valor para AL_SEGU_NOMB
	 * @param mixed $al_segu_nomb 
	 */
	public function setAlSeguNomb($al_segu_nomb)
	{
			$this->al_segu_nomb=$al_segu_nomb;
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
	 * Obtiene el valor de TIPO_INSTITUCION
	 * @return mixed
	 */
	public function getTipoInstitucion()
	{
			return $this->tipo_institucion;
	}

	/**
	 * Asigna el valor para TIPO_INSTITUCION
	 * @param mixed $tipo_institucion 
	 */
	public function setTipoInstitucion($tipo_institucion)
	{
			$this->tipo_institucion=$tipo_institucion;
	}

	/**
	 * Obtiene el valor de INSTITUCION
	 * @return mixed
	 */
	public function getInstitucion()
	{
			return $this->institucion;
	}

	/**
	 * Asigna el valor para INSTITUCION
	 * @param mixed $institucion 
	 */
	public function setInstitucion($institucion)
	{
			$this->institucion=$institucion;
	}

	/**
	 * Obtiene el valor de DANE_11
	 * @return mixed
	 */
	public function getDane11()
	{
			return $this->dane_11;
	}

	/**
	 * Asigna el valor para DANE_11
	 * @param mixed $dane_11 
	 */
	public function setDane11($dane_11)
	{
			$this->dane_11=$dane_11;
	}

	/**
	 * Obtiene el valor de DANE_12
	 * @return mixed
	 */
	public function getDane12()
	{
			return $this->dane_12;
	}

	/**
	 * Asigna el valor para DANE_12
	 * @param mixed $dane_12 
	 */
	public function setDane12($dane_12)
	{
			$this->dane_12=$dane_12;
	}

	/**
	 * Obtiene el valor de JORNADA
	 * @return mixed
	 */
	public function getJornada()
	{
			return $this->jornada;
	}

	/**
	 * Asigna el valor para JORNADA
	 * @param mixed $jornada 
	 */
	public function setJornada($jornada)
	{
			$this->jornada=$jornada;
	}

	/**
	 * Obtiene el valor de LOC_INST
	 * @return mixed
	 */
	public function getLocInst()
	{
			return $this->loc_inst;
	}

	/**
	 * Asigna el valor para LOC_INST
	 * @param mixed $loc_inst 
	 */
	public function setLocInst($loc_inst)
	{
			$this->loc_inst=$loc_inst;
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
	 * Obtiene el valor de DANE_SEDE
	 * @return mixed
	 */
	public function getDaneSede()
	{
			return $this->dane_sede;
	}

	/**
	 * Asigna el valor para DANE_SEDE
	 * @param mixed $dane_sede 
	 */
	public function setDaneSede($dane_sede)
	{
			$this->dane_sede=$dane_sede;
	}

	/**
	 * Obtiene el valor de SEDE
	 * @return mixed
	 */
	public function getSede()
	{
			return $this->sede;
	}

	/**
	 * Asigna el valor para SEDE
	 * @param mixed $sede 
	 */
	public function setSede($sede)
	{
			$this->sede=$sede;
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
	 * Obtiene el valor de ESTRATO_CALC
	 * @return mixed
	 */
	public function getEstratoCalc()
	{
			return $this->estrato_calc;
	}

	/**
	 * Asigna el valor para ESTRATO_CALC
	 * @param mixed $estrato_calc 
	 */
	public function setEstratoCalc($estrato_calc)
	{
			$this->estrato_calc=$estrato_calc;
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
	 * Obtiene el valor de DEFICIENCIA
	 * @return mixed
	 */
	public function getDeficiencia()
	{
			return $this->deficiencia;
	}

	/**
	 * Asigna el valor para DEFICIENCIA
	 * @param mixed $deficiencia 
	 */
	public function setDeficiencia($deficiencia)
	{
			$this->deficiencia=$deficiencia;
	}

	/**
	 * Obtiene el valor de SISBEN_CALC
	 * @return mixed
	 */
	public function getSisbenCalc()
	{
			return $this->sisben_calc;
	}

	/**
	 * Asigna el valor para SISBEN_CALC
	 * @param mixed $sisben_calc 
	 */
	public function setSisbenCalc($sisben_calc)
	{
			$this->sisben_calc=$sisben_calc;
	}

	/**
	 * Obtiene el valor de TEL_ALUMNO
	 * @return mixed
	 */
	public function getTelAlumno()
	{
			return $this->tel_alumno;
	}

	/**
	 * Asigna el valor para TEL_ALUMNO
	 * @param mixed $tel_alumno 
	 */
	public function setTelAlumno($tel_alumno)
	{
			$this->tel_alumno=$tel_alumno;
	}

	/**
	 * Obtiene el valor de DIRECCION
	 * @return mixed
	 */
	public function getDireccion()
	{
			return $this->direccion;
	}

	/**
	 * Asigna el valor para DIRECCION
	 * @param mixed $direccion 
	 */
	public function setDireccion($direccion)
	{
			$this->direccion=$direccion;
	}

	/**
	 * Obtiene el valor de BARRIO
	 * @return mixed
	 */
	public function getBarrio()
	{
			return $this->barrio;
	}

	/**
	 * Asigna el valor para BARRIO
	 * @param mixed $barrio 
	 */
	public function setBarrio($barrio)
	{
			$this->barrio=$barrio;
	}

	/**
	 * Obtiene el valor de OTRO_BARRIO
	 * @return mixed
	 */
	public function getOtroBarrio()
	{
			return $this->otro_barrio;
	}

	/**
	 * Asigna el valor para OTRO_BARRIO
	 * @param mixed $otro_barrio 
	 */
	public function setOtroBarrio($otro_barrio)
	{
			$this->otro_barrio=$otro_barrio;
	}

	/**
	 * Obtiene el valor de LOC_ALUMNO
	 * @return mixed
	 */
	public function getLocAlumno()
	{
			return $this->loc_alumno;
	}

	/**
	 * Asigna el valor para LOC_ALUMNO
	 * @param mixed $loc_alumno 
	 */
	public function setLocAlumno($loc_alumno)
	{
			$this->loc_alumno=$loc_alumno;
	}

	/**
	 * Obtiene el valor de TIPO_COMUNIDAD
	 * @return mixed
	 */
	public function getTipoComunidad()
	{
			return $this->tipo_comunidad;
	}

	/**
	 * Asigna el valor para TIPO_COMUNIDAD
	 * @param mixed $tipo_comunidad 
	 */
	public function setTipoComunidad($tipo_comunidad)
	{
			$this->tipo_comunidad=$tipo_comunidad;
	}

	/**
	 * Obtiene el valor de RH
	 * @return mixed
	 */
	public function getRh()
	{
			return $this->rh;
	}

	/**
	 * Asigna el valor para RH
	 * @param mixed $rh 
	 */
	public function setRh($rh)
	{
			$this->rh=$rh;
	}

	/**
	 * Obtiene el valor de GRUPO_SANG
	 * @return mixed
	 */
	public function getGrupoSang()
	{
			return $this->grupo_sang;
	}

	/**
	 * Asigna el valor para GRUPO_SANG
	 * @param mixed $grupo_sang 
	 */
	public function setGrupoSang($grupo_sang)
	{
			$this->grupo_sang=$grupo_sang;
	}

	/**
	 * Obtiene el valor de AL_NOMB_ACUD
	 * @return mixed
	 */
	public function getAlNombAcud()
	{
			return $this->al_nomb_acud;
	}

	/**
	 * Asigna el valor para AL_NOMB_ACUD
	 * @param mixed $al_nomb_acud 
	 */
	public function setAlNombAcud($al_nomb_acud)
	{
			$this->al_nomb_acud=$al_nomb_acud;
	}

	/**
	 * Obtiene el valor de ID_ACUD
	 * @return mixed
	 */
	public function getIdAcud()
	{
			return $this->id_acud;
	}

	/**
	 * Asigna el valor para ID_ACUD
	 * @param mixed $id_acud 
	 */
	public function setIdAcud($id_acud)
	{
			$this->id_acud=$id_acud;
	}

	/**
	 * Obtiene el valor de TEL_ACUD
	 * @return mixed
	 */
	public function getTelAcud()
	{
			return $this->tel_acud;
	}

	/**
	 * Asigna el valor para TEL_ACUD
	 * @param mixed $tel_acud 
	 */
	public function setTelAcud($tel_acud)
	{
			$this->tel_acud=$tel_acud;
	}

	/**
	 * Obtiene el valor de MOVIL
	 * @return mixed
	 */
	public function getMovil()
	{
			return $this->movil;
	}

	/**
	 * Asigna el valor para MOVIL
	 * @param mixed $movil 
	 */
	public function setMovil($movil)
	{
			$this->movil=$movil;
	}

	/**
	 * Obtiene el valor de MAIL_ACUD
	 * @return mixed
	 */
	public function getMailAcud()
	{
			return $this->mail_acud;
	}

	/**
	 * Asigna el valor para MAIL_ACUD
	 * @param mixed $mail_acud 
	 */
	public function setMailAcud($mail_acud)
	{
			$this->mail_acud=$mail_acud;
	}

	/**
	 * Obtiene el valor de AL_PADR_NOMB
	 * @return mixed
	 */
	public function getAlPadrNomb()
	{
			return $this->al_padr_nomb;
	}

	/**
	 * Asigna el valor para AL_PADR_NOMB
	 * @param mixed $al_padr_nomb 
	 */
	public function setAlPadrNomb($al_padr_nomb)
	{
			$this->al_padr_nomb=$al_padr_nomb;
	}

	/**
	 * Obtiene el valor de ID_PADRE
	 * @return mixed
	 */
	public function getIdPadre()
	{
			return $this->id_padre;
	}

	/**
	 * Asigna el valor para ID_PADRE
	 * @param mixed $id_padre 
	 */
	public function setIdPadre($id_padre)
	{
			$this->id_padre=$id_padre;
	}

	/**
	 * Obtiene el valor de TEL_PADRE
	 * @return mixed
	 */
	public function getTelPadre()
	{
			return $this->tel_padre;
	}

	/**
	 * Asigna el valor para TEL_PADRE
	 * @param mixed $tel_padre 
	 */
	public function setTelPadre($tel_padre)
	{
			$this->tel_padre=$tel_padre;
	}

	/**
	 * Obtiene el valor de CEL_PADRE
	 * @return mixed
	 */
	public function getCelPadre()
	{
			return $this->cel_padre;
	}

	/**
	 * Asigna el valor para CEL_PADRE
	 * @param mixed $cel_padre 
	 */
	public function setCelPadre($cel_padre)
	{
			$this->cel_padre=$cel_padre;
	}

	/**
	 * Obtiene el valor de MAIL_PADRE
	 * @return mixed
	 */
	public function getMailPadre()
	{
			return $this->mail_padre;
	}

	/**
	 * Asigna el valor para MAIL_PADRE
	 * @param mixed $mail_padre 
	 */
	public function setMailPadre($mail_padre)
	{
			$this->mail_padre=$mail_padre;
	}

	/**
	 * Obtiene el valor de AL_MADR_NOMB
	 * @return mixed
	 */
	public function getAlMadrNomb()
	{
			return $this->al_madr_nomb;
	}

	/**
	 * Asigna el valor para AL_MADR_NOMB
	 * @param mixed $al_madr_nomb 
	 */
	public function setAlMadrNomb($al_madr_nomb)
	{
			$this->al_madr_nomb=$al_madr_nomb;
	}

	/**
	 * Obtiene el valor de ID_MADRE
	 * @return mixed
	 */
	public function getIdMadre()
	{
			return $this->id_madre;
	}

	/**
	 * Asigna el valor para ID_MADRE
	 * @param mixed $id_madre 
	 */
	public function setIdMadre($id_madre)
	{
			$this->id_madre=$id_madre;
	}

	/**
	 * Obtiene el valor de AL_MADR_TEL
	 * @return mixed
	 */
	public function getAlMadrTel()
	{
			return $this->al_madr_tel;
	}

	/**
	 * Asigna el valor para AL_MADR_TEL
	 * @param mixed $al_madr_tel 
	 */
	public function setAlMadrTel($al_madr_tel)
	{
			$this->al_madr_tel=$al_madr_tel;
	}

	/**
	 * Obtiene el valor de CEL_MADRE
	 * @return mixed
	 */
	public function getCelMadre()
	{
			return $this->cel_madre;
	}

	/**
	 * Asigna el valor para CEL_MADRE
	 * @param mixed $cel_madre 
	 */
	public function setCelMadre($cel_madre)
	{
			$this->cel_madre=$cel_madre;
	}

	/**
	 * Obtiene el valor de MAIL_MADRE
	 * @return mixed
	 */
	public function getMailMadre()
	{
			return $this->mail_madre;
	}

	/**
	 * Asigna el valor para MAIL_MADRE
	 * @param mixed $mail_madre 
	 */
	public function setMailMadre($mail_madre)
	{
			$this->mail_madre=$mail_madre;
	}

	/**
	 * Obtiene el valor de MARCA_TALENTO
	 * @return mixed
	 */
	public function getMarcaTalento()
	{
			return $this->marca_talento;
	}

	/**
	 * Asigna el valor para MARCA_TALENTO
	 * @param mixed $marca_talento 
	 */
	public function setMarcaTalento($marca_talento)
	{
			$this->marca_talento=$marca_talento;
	}

	/**
	 * Obtiene el valor de PUNTAJE_TE
	 * @return mixed
	 */
	public function getPuntajeTe()
	{
			return $this->puntaje_te;
	}

	/**
	 * Asigna el valor para PUNTAJE_TE
	 * @param mixed $puntaje_te 
	 */
	public function setPuntajeTe($puntaje_te)
	{
			$this->puntaje_te=$puntaje_te;
	}

	/**
	 * Obtiene el valor de NOMB_TALENTO
	 * @return mixed
	 */
	public function getNombTalento()
	{
			return $this->nomb_talento;
	}

	/**
	 * Asigna el valor para NOMB_TALENTO
	 * @param mixed $nomb_talento 
	 */
	public function setNombTalento($nomb_talento)
	{
			$this->nomb_talento=$nomb_talento;
	}

	/**
	 * Obtiene el valor de DESC_TALENTO
	 * @return mixed
	 */
	public function getDescTalento()
	{
			return $this->desc_talento;
	}

	/**
	 * Asigna el valor para DESC_TALENTO
	 * @param mixed $desc_talento 
	 */
	public function setDescTalento($desc_talento)
	{
			$this->desc_talento=$desc_talento;
	}

	/**
	 * Obtiene el valor de ETNIAS
	 * @return mixed
	 */
	public function getEtnias()
	{
			return $this->etnias;
	}

	/**
	 * Asigna el valor para ETNIAS
	 * @param mixed $etnias 
	 */
	public function setEtnias($etnias)
	{
			$this->etnias=$etnias;
	}

	/**
	 * Obtiene el valor de UPZ_ALUMNO
	 * @return mixed
	 */
	public function getUpzAlumno()
	{
			return $this->upz_alumno;
	}

	/**
	 * Asigna el valor para UPZ_ALUMNO
	 * @param mixed $upz_alumno 
	 */
	public function setUpzAlumno($upz_alumno)
	{
			$this->upz_alumno=$upz_alumno;
	}

	/**
	 * Obtiene el valor de EDAD_CALC
	 * @return mixed
	 */
	public function getEdadCalc()
	{
			return $this->edad_calc;
	}

	/**
	 * Asigna el valor para EDAD_CALC
	 * @param mixed $edad_calc 
	 */
	public function setEdadCalc($edad_calc)
	{
			$this->edad_calc=$edad_calc;
	}

	/**
	 * Obtiene el valor de AO_ESTADO
	 * @return mixed
	 */
	public function getAoEstado()
	{
			return $this->ao_estado;
	}

	/**
	 * Asigna el valor para AO_ESTADO
	 * @param mixed $ao_estado 
	 */
	public function setAoEstado($ao_estado)
	{
			$this->ao_estado=$ao_estado;
	}

	/**
	 * Obtiene el valor de FECHA_ESTADO
	 * @return mixed
	 */
	public function getFechaEstado()
	{
			return $this->fecha_estado;
	}

	/**
	 * Asigna el valor para FECHA_ESTADO
	 * @param mixed $fecha_estado 
	 */
	public function setFechaEstado($fecha_estado)
	{
			$this->fecha_estado=$fecha_estado;
	}

	/**
	 * Obtiene el valor de COD_ALUMNO
	 * @return mixed
	 */
	public function getCodAlumno()
	{
			return $this->cod_alumno;
	}

	/**
	 * Asigna el valor para COD_ALUMNO
	 * @param mixed $cod_alumno 
	 */
	public function setCodAlumno($cod_alumno)
	{
			$this->cod_alumno=$cod_alumno;
	}

	/**
	 * Obtiene el valor de FECHA_ACTUALIZACION
	 * @return mixed
	 */
	public function getFechaActualizacion()
	{
			return $this->fecha_actualizacion;
	}

	/**
	 * Asigna el valor para FECHA_ACTUALIZACION
	 * @param mixed $fecha_actualizacion 
	 */
	public function setFechaActualizacion($fecha_actualizacion)
	{
			$this->fecha_actualizacion=$fecha_actualizacion;
	}


}
