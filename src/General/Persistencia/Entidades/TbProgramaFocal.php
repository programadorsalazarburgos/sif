<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_programa_focal'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2017-07-05 23:05	 
 */
class TbProgramaFocal 
{
	
	private $pk_programa_focal;
	private $fk_id_clan;
	private $vc_artista_formador;
	private $fk_organizacion;
	private $fk_colegio;
	private $fk_grupo;
	private $vc_horariogrupo;
	private $vc_mes;
	private $vc_introduccion;
	private $vc_tema;
	private $vc_resenia_autor;
	private $vc_resenia_obra;
	private $vc_titulosem1;
	private $vc_autorsem1;
	private $vc_insumossem1;
	private $vc_metodologiasem1;
	private $vc_dcreativossem1;
	private $vc_aprendizajesem1;
	private $vc_titulosem2;
	private $vc_autorsem2;
	private $vc_insumossem2;
	private $vc_metodologiasem2;
	private $vc_dcreativossem2;
	private $vc_aprendizajesem2;
	private $vc_titulosem3;
	private $vc_autorsem3;
	private $vc_insumossem3;
	private $vc_metodologiasem3;
	private $vc_dcreativossem3;
	private $vc_aprendizajesem3;
	private $vc_titulosem4;
	private $vc_autorsem4;
	private $vc_insumossem4;
	private $vc_metodologiasem4;
	private $vc_dcreativossem4;
	private $vc_aprendizajesem4;
	private $vc_ciclo_i;
	private $vc_ciclo_ii;
	private $vc_ciclo_iii;
	private $vc_ciclo_iv;
	private $dd_fecha_registro;


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
	 * Obtiene el valor de PK_Programa_Focal
	 * @return mixed
	 */
	public function getPkProgramaFocal()
	{
			return $this->pk_programa_focal;
	}

	/**
	 * Asigna el valor para PK_Programa_Focal
	 * @param mixed $pk_programa_focal 
	 */
	public function setPkProgramaFocal($pk_programa_focal)
	{
			$this->pk_programa_focal=$pk_programa_focal;
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
	 * Obtiene el valor de VC_Artista_Formador
	 * @return mixed
	 */
	public function getVcArtistaFormador()
	{
			return $this->vc_artista_formador;
	}

	/**
	 * Asigna el valor para VC_Artista_Formador
	 * @param mixed $vc_artista_formador 
	 */
	public function setVcArtistaFormador($vc_artista_formador)
	{
			$this->vc_artista_formador=$vc_artista_formador;
	}

	/**
	 * Obtiene el valor de FK_Organizacion
	 * @return mixed
	 */
	public function getFkOrganizacion()
	{
			return $this->fk_organizacion;
	}

	/**
	 * Asigna el valor para FK_Organizacion
	 * @param mixed $fk_organizacion 
	 */
	public function setFkOrganizacion($fk_organizacion)
	{
			$this->fk_organizacion=$fk_organizacion;
	}

	/**
	 * Obtiene el valor de FK_Colegio
	 * @return mixed
	 */
	public function getFkColegio()
	{
			return $this->fk_colegio;
	}

	/**
	 * Asigna el valor para FK_Colegio
	 * @param mixed $fk_colegio 
	 */
	public function setFkColegio($fk_colegio)
	{
			$this->fk_colegio=$fk_colegio;
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
	 * Obtiene el valor de VC_HorarioGrupo
	 * @return mixed
	 */
	public function getVcHorariogrupo()
	{
			return $this->vc_horariogrupo;
	}

	/**
	 * Asigna el valor para VC_HorarioGrupo
	 * @param mixed $vc_horariogrupo 
	 */
	public function setVcHorariogrupo($vc_horariogrupo)
	{
			$this->vc_horariogrupo=$vc_horariogrupo;
	}

	/**
	 * Obtiene el valor de VC_Mes
	 * @return mixed
	 */
	public function getVcMes()
	{
			return $this->vc_mes;
	}

	/**
	 * Asigna el valor para VC_Mes
	 * @param mixed $vc_mes 
	 */
	public function setVcMes($vc_mes)
	{
			$this->vc_mes=$vc_mes;
	}

	/**
	 * Obtiene el valor de VC_Introduccion
	 * @return mixed
	 */
	public function getVcIntroduccion()
	{
			return $this->vc_introduccion;
	}

	/**
	 * Asigna el valor para VC_Introduccion
	 * @param mixed $vc_introduccion 
	 */
	public function setVcIntroduccion($vc_introduccion)
	{
			$this->vc_introduccion=$vc_introduccion;
	}

	/**
	 * Obtiene el valor de VC_Tema
	 * @return mixed
	 */
	public function getVcTema()
	{
			return $this->vc_tema;
	}

	/**
	 * Asigna el valor para VC_Tema
	 * @param mixed $vc_tema 
	 */
	public function setVcTema($vc_tema)
	{
			$this->vc_tema=$vc_tema;
	}

	/**
	 * Obtiene el valor de VC_Resenia_Autor
	 * @return mixed
	 */
	public function getVcReseniaAutor()
	{
			return $this->vc_resenia_autor;
	}

	/**
	 * Asigna el valor para VC_Resenia_Autor
	 * @param mixed $vc_resenia_autor 
	 */
	public function setVcReseniaAutor($vc_resenia_autor)
	{
			$this->vc_resenia_autor=$vc_resenia_autor;
	}

	/**
	 * Obtiene el valor de VC_Resenia_Obra
	 * @return mixed
	 */
	public function getVcReseniaObra()
	{
			return $this->vc_resenia_obra;
	}

	/**
	 * Asigna el valor para VC_Resenia_Obra
	 * @param mixed $vc_resenia_obra 
	 */
	public function setVcReseniaObra($vc_resenia_obra)
	{
			$this->vc_resenia_obra=$vc_resenia_obra;
	}

	/**
	 * Obtiene el valor de VC_TituloSem1
	 * @return mixed
	 */
	public function getVcTitulosem1()
	{
			return $this->vc_titulosem1;
	}

	/**
	 * Asigna el valor para VC_TituloSem1
	 * @param mixed $vc_titulosem1 
	 */
	public function setVcTitulosem1($vc_titulosem1)
	{
			$this->vc_titulosem1=$vc_titulosem1;
	}

	/**
	 * Obtiene el valor de VC_AutorSem1
	 * @return mixed
	 */
	public function getVcAutorsem1()
	{
			return $this->vc_autorsem1;
	}

	/**
	 * Asigna el valor para VC_AutorSem1
	 * @param mixed $vc_autorsem1 
	 */
	public function setVcAutorsem1($vc_autorsem1)
	{
			$this->vc_autorsem1=$vc_autorsem1;
	}

	/**
	 * Obtiene el valor de VC_InsumosSem1
	 * @return mixed
	 */
	public function getVcInsumossem1()
	{
			return $this->vc_insumossem1;
	}

	/**
	 * Asigna el valor para VC_InsumosSem1
	 * @param mixed $vc_insumossem1 
	 */
	public function setVcInsumossem1($vc_insumossem1)
	{
			$this->vc_insumossem1=$vc_insumossem1;
	}

	/**
	 * Obtiene el valor de VC_MetodologiaSem1
	 * @return mixed
	 */
	public function getVcMetodologiasem1()
	{
			return $this->vc_metodologiasem1;
	}

	/**
	 * Asigna el valor para VC_MetodologiaSem1
	 * @param mixed $vc_metodologiasem1 
	 */
	public function setVcMetodologiasem1($vc_metodologiasem1)
	{
			$this->vc_metodologiasem1=$vc_metodologiasem1;
	}

	/**
	 * Obtiene el valor de VC_DCreativosSem1
	 * @return mixed
	 */
	public function getVcDcreativossem1()
	{
			return $this->vc_dcreativossem1;
	}

	/**
	 * Asigna el valor para VC_DCreativosSem1
	 * @param mixed $vc_dcreativossem1 
	 */
	public function setVcDcreativossem1($vc_dcreativossem1)
	{
			$this->vc_dcreativossem1=$vc_dcreativossem1;
	}

	/**
	 * Obtiene el valor de VC_AprendizajeSem1
	 * @return mixed
	 */
	public function getVcAprendizajesem1()
	{
			return $this->vc_aprendizajesem1;
	}

	/**
	 * Asigna el valor para VC_AprendizajeSem1
	 * @param mixed $vc_aprendizajesem1 
	 */
	public function setVcAprendizajesem1($vc_aprendizajesem1)
	{
			$this->vc_aprendizajesem1=$vc_aprendizajesem1;
	}

	/**
	 * Obtiene el valor de VC_TituloSem2
	 * @return mixed
	 */
	public function getVcTitulosem2()
	{
			return $this->vc_titulosem2;
	}

	/**
	 * Asigna el valor para VC_TituloSem2
	 * @param mixed $vc_titulosem2 
	 */
	public function setVcTitulosem2($vc_titulosem2)
	{
			$this->vc_titulosem2=$vc_titulosem2;
	}

	/**
	 * Obtiene el valor de VC_AutorSem2
	 * @return mixed
	 */
	public function getVcAutorsem2()
	{
			return $this->vc_autorsem2;
	}

	/**
	 * Asigna el valor para VC_AutorSem2
	 * @param mixed $vc_autorsem2 
	 */
	public function setVcAutorsem2($vc_autorsem2)
	{
			$this->vc_autorsem2=$vc_autorsem2;
	}

	/**
	 * Obtiene el valor de VC_InsumosSem2
	 * @return mixed
	 */
	public function getVcInsumossem2()
	{
			return $this->vc_insumossem2;
	}

	/**
	 * Asigna el valor para VC_InsumosSem2
	 * @param mixed $vc_insumossem2 
	 */
	public function setVcInsumossem2($vc_insumossem2)
	{
			$this->vc_insumossem2=$vc_insumossem2;
	}

	/**
	 * Obtiene el valor de VC_MetodologiaSem2
	 * @return mixed
	 */
	public function getVcMetodologiasem2()
	{
			return $this->vc_metodologiasem2;
	}

	/**
	 * Asigna el valor para VC_MetodologiaSem2
	 * @param mixed $vc_metodologiasem2 
	 */
	public function setVcMetodologiasem2($vc_metodologiasem2)
	{
			$this->vc_metodologiasem2=$vc_metodologiasem2;
	}

	/**
	 * Obtiene el valor de VC_DCreativosSem2
	 * @return mixed
	 */
	public function getVcDcreativossem2()
	{
			return $this->vc_dcreativossem2;
	}

	/**
	 * Asigna el valor para VC_DCreativosSem2
	 * @param mixed $vc_dcreativossem2 
	 */
	public function setVcDcreativossem2($vc_dcreativossem2)
	{
			$this->vc_dcreativossem2=$vc_dcreativossem2;
	}

	/**
	 * Obtiene el valor de VC_AprendizajeSem2
	 * @return mixed
	 */
	public function getVcAprendizajesem2()
	{
			return $this->vc_aprendizajesem2;
	}

	/**
	 * Asigna el valor para VC_AprendizajeSem2
	 * @param mixed $vc_aprendizajesem2 
	 */
	public function setVcAprendizajesem2($vc_aprendizajesem2)
	{
			$this->vc_aprendizajesem2=$vc_aprendizajesem2;
	}

	/**
	 * Obtiene el valor de VC_TituloSem3
	 * @return mixed
	 */
	public function getVcTitulosem3()
	{
			return $this->vc_titulosem3;
	}

	/**
	 * Asigna el valor para VC_TituloSem3
	 * @param mixed $vc_titulosem3 
	 */
	public function setVcTitulosem3($vc_titulosem3)
	{
			$this->vc_titulosem3=$vc_titulosem3;
	}

	/**
	 * Obtiene el valor de VC_AutorSem3
	 * @return mixed
	 */
	public function getVcAutorsem3()
	{
			return $this->vc_autorsem3;
	}

	/**
	 * Asigna el valor para VC_AutorSem3
	 * @param mixed $vc_autorsem3 
	 */
	public function setVcAutorsem3($vc_autorsem3)
	{
			$this->vc_autorsem3=$vc_autorsem3;
	}

	/**
	 * Obtiene el valor de VC_InsumosSem3
	 * @return mixed
	 */
	public function getVcInsumossem3()
	{
			return $this->vc_insumossem3;
	}

	/**
	 * Asigna el valor para VC_InsumosSem3
	 * @param mixed $vc_insumossem3 
	 */
	public function setVcInsumossem3($vc_insumossem3)
	{
			$this->vc_insumossem3=$vc_insumossem3;
	}

	/**
	 * Obtiene el valor de VC_MetodologiaSem3
	 * @return mixed
	 */
	public function getVcMetodologiasem3()
	{
			return $this->vc_metodologiasem3;
	}

	/**
	 * Asigna el valor para VC_MetodologiaSem3
	 * @param mixed $vc_metodologiasem3 
	 */
	public function setVcMetodologiasem3($vc_metodologiasem3)
	{
			$this->vc_metodologiasem3=$vc_metodologiasem3;
	}

	/**
	 * Obtiene el valor de VC_DCreativosSem3
	 * @return mixed
	 */
	public function getVcDcreativossem3()
	{
			return $this->vc_dcreativossem3;
	}

	/**
	 * Asigna el valor para VC_DCreativosSem3
	 * @param mixed $vc_dcreativossem3 
	 */
	public function setVcDcreativossem3($vc_dcreativossem3)
	{
			$this->vc_dcreativossem3=$vc_dcreativossem3;
	}

	/**
	 * Obtiene el valor de VC_AprendizajeSem3
	 * @return mixed
	 */
	public function getVcAprendizajesem3()
	{
			return $this->vc_aprendizajesem3;
	}

	/**
	 * Asigna el valor para VC_AprendizajeSem3
	 * @param mixed $vc_aprendizajesem3 
	 */
	public function setVcAprendizajesem3($vc_aprendizajesem3)
	{
			$this->vc_aprendizajesem3=$vc_aprendizajesem3;
	}

	/**
	 * Obtiene el valor de VC_TituloSem4
	 * @return mixed
	 */
	public function getVcTitulosem4()
	{
			return $this->vc_titulosem4;
	}

	/**
	 * Asigna el valor para VC_TituloSem4
	 * @param mixed $vc_titulosem4 
	 */
	public function setVcTitulosem4($vc_titulosem4)
	{
			$this->vc_titulosem4=$vc_titulosem4;
	}

	/**
	 * Obtiene el valor de VC_AutorSem4
	 * @return mixed
	 */
	public function getVcAutorsem4()
	{
			return $this->vc_autorsem4;
	}

	/**
	 * Asigna el valor para VC_AutorSem4
	 * @param mixed $vc_autorsem4 
	 */
	public function setVcAutorsem4($vc_autorsem4)
	{
			$this->vc_autorsem4=$vc_autorsem4;
	}

	/**
	 * Obtiene el valor de VC_InsumosSem4
	 * @return mixed
	 */
	public function getVcInsumossem4()
	{
			return $this->vc_insumossem4;
	}

	/**
	 * Asigna el valor para VC_InsumosSem4
	 * @param mixed $vc_insumossem4 
	 */
	public function setVcInsumossem4($vc_insumossem4)
	{
			$this->vc_insumossem4=$vc_insumossem4;
	}

	/**
	 * Obtiene el valor de VC_MetodologiaSem4
	 * @return mixed
	 */
	public function getVcMetodologiasem4()
	{
			return $this->vc_metodologiasem4;
	}

	/**
	 * Asigna el valor para VC_MetodologiaSem4
	 * @param mixed $vc_metodologiasem4 
	 */
	public function setVcMetodologiasem4($vc_metodologiasem4)
	{
			$this->vc_metodologiasem4=$vc_metodologiasem4;
	}

	/**
	 * Obtiene el valor de VC_DCreativosSem4
	 * @return mixed
	 */
	public function getVcDcreativossem4()
	{
			return $this->vc_dcreativossem4;
	}

	/**
	 * Asigna el valor para VC_DCreativosSem4
	 * @param mixed $vc_dcreativossem4 
	 */
	public function setVcDcreativossem4($vc_dcreativossem4)
	{
			$this->vc_dcreativossem4=$vc_dcreativossem4;
	}

	/**
	 * Obtiene el valor de VC_AprendizajeSem4
	 * @return mixed
	 */
	public function getVcAprendizajesem4()
	{
			return $this->vc_aprendizajesem4;
	}

	/**
	 * Asigna el valor para VC_AprendizajeSem4
	 * @param mixed $vc_aprendizajesem4 
	 */
	public function setVcAprendizajesem4($vc_aprendizajesem4)
	{
			$this->vc_aprendizajesem4=$vc_aprendizajesem4;
	}

	/**
	 * Obtiene el valor de VC_Ciclo_I
	 * @return mixed
	 */
	public function getVcCicloI()
	{
			return $this->vc_ciclo_i;
	}

	/**
	 * Asigna el valor para VC_Ciclo_I
	 * @param mixed $vc_ciclo_i 
	 */
	public function setVcCicloI($vc_ciclo_i)
	{
			$this->vc_ciclo_i=$vc_ciclo_i;
	}

	/**
	 * Obtiene el valor de VC_Ciclo_II
	 * @return mixed
	 */
	public function getVcCicloIi()
	{
			return $this->vc_ciclo_ii;
	}

	/**
	 * Asigna el valor para VC_Ciclo_II
	 * @param mixed $vc_ciclo_ii 
	 */
	public function setVcCicloIi($vc_ciclo_ii)
	{
			$this->vc_ciclo_ii=$vc_ciclo_ii;
	}

	/**
	 * Obtiene el valor de VC_Ciclo_III
	 * @return mixed
	 */
	public function getVcCicloIii()
	{
			return $this->vc_ciclo_iii;
	}

	/**
	 * Asigna el valor para VC_Ciclo_III
	 * @param mixed $vc_ciclo_iii 
	 */
	public function setVcCicloIii($vc_ciclo_iii)
	{
			$this->vc_ciclo_iii=$vc_ciclo_iii;
	}

	/**
	 * Obtiene el valor de VC_Ciclo_IV
	 * @return mixed
	 */
	public function getVcCicloIv()
	{
			return $this->vc_ciclo_iv;
	}

	/**
	 * Asigna el valor para VC_Ciclo_IV
	 * @param mixed $vc_ciclo_iv 
	 */
	public function setVcCicloIv($vc_ciclo_iv)
	{
			$this->vc_ciclo_iv=$vc_ciclo_iv;
	}

	/**
	 * Obtiene el valor de DD_Fecha_Registro
	 * @return mixed
	 */
	public function getDdFechaRegistro()
	{
			return $this->dd_fecha_registro;
	}

	/**
	 * Asigna el valor para DD_Fecha_Registro
	 * @param mixed $dd_fecha_registro 
	 */
	public function setDdFechaRegistro($dd_fecha_registro)
	{
			$this->dd_fecha_registro=$dd_fecha_registro;
	}


}
