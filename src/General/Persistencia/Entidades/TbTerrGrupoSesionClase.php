<?php


namespace  General\Persistencia\Entidades;


/**

 * Object que representa las tablas 'tb_terr_grupo_arte_escuela_sesion_clase', 'tb_terr_grupo_emprende_clan_sesion_clase' y 'tb_terr_grupo_laboratorio_clan_sesion_clase'

 *

 * @author: Diego Forero, gracias a http://phpdao.com

 * @date: 2018-05-29 16:50	 

 */

class TbTerrGrupoSesionClase 

{

	

	private $pk_sesion_clase;

	private $fk_grupo;

	private $da_fecha_clase;

	private $dt_fecha_creacion_registro;

	private $in_horas_clase;

	private $fk_usuario;

	private $tx_observaciones;

	private $suplencia;

    private $fk_salon;

    private $fk_organizacion;

    private $fk_clan;

    private $vc_nom_clan;

    private $fk_area_artistica;

    private $tipo_poblacion;

    private $fk_lugar_atencion;

    private $in_modalidad_atencion;

    private $in_tipo_atencion;

    private $in_material;

    private $fk_colegio;

    private $vc_nom_colegio;

    private $fk_modalidad;

    private $in_lugar_atencion;


    private $fk_institucion;

    private $fk_aliado;

    private $in_tipo_ubicacion;

    private $tx_sitio;


	private $tipo_grupo;

    private $estudiante_array;

    private $atencion_array;

    private $tipo_grupo_atencion;


    private $hora_inicio;

    private $hora_fin;


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

     * @return mixed

     */

    public function getPkSesionClase()

    {

        return $this->pk_sesion_clase;

    }


    /**

     * @param mixed $pk_sesion_clase

     *

     * @return self

     */

    public function setPkSesionClase($pk_sesion_clase)

    {

        $this->pk_sesion_clase = $pk_sesion_clase;

    }


    /**

     * @return mixed

     */

    public function getFkGrupo()

    {

        return $this->fk_grupo;

    }


    /**

     * @param mixed $fk_grupo

     *

     * @return self

     */

    public function setFkGrupo($fk_grupo)

    {

        $this->fk_grupo = $fk_grupo;

    }


    /**

     * @return mixed

     */

    public function getDaFechaClase()

    {

        return $this->da_fecha_clase;

    }


    /**

     * @param mixed $da_fecha_clase

     *

     * @return self

     */

    public function setDaFechaClase($da_fecha_clase)

    {

        $this->da_fecha_clase = $da_fecha_clase;

    }


    /**

     * @return mixed

     */

    public function getDtFechaCreacionRegistro()

    {

        return $this->dt_fecha_creacion_registro;

    }


    /**

     * @param mixed $dt_fecha_creacion_registro

     *

     * @return self

     */

    public function setDtFechaCreacionRegistro($dt_fecha_creacion_registro)

    {

        $this->dt_fecha_creacion_registro = $dt_fecha_creacion_registro;

    }


    /**

     * @return mixed

     */

    public function getInHorasClase()

    {

        return $this->in_horas_clase;

    }


    /**

     * @param mixed $in_horas_clase

     *

     * @return self

     */

    public function setInHorasClase($in_horas_clase)

    {

        $this->in_horas_clase = $in_horas_clase;

    }


    /**

     * @return mixed

     */

    public function getFkUsuario()

    {

        return $this->fk_usuario;

    }


    /**

     * @param mixed $fk_usuario

     *

     * @return self

     */

    public function setFkUsuario($fk_usuario)

    {

        $this->fk_usuario = $fk_usuario;

    }


    /**

     * @return mixed

     */

    public function getTxObservaciones()

    {

        return $this->tx_observaciones;

    }


    /**

     * @param mixed $tx_observaciones

     *

     * @return self

     */

    public function setTxObservaciones($tx_observaciones)

    {

        $this->tx_observaciones = $tx_observaciones;

    }


    /**

     * @return mixed

     */

    public function getSuplencia()

    {

        return $this->suplencia;

    }


    /**

     * @param mixed $suplencia

     *

     * @return self

     */

    public function setSuplencia($suplencia)

    {

        $this->suplencia = $suplencia;

    }


    /**

     * @return mixed

     */

    public function getFkOrganizacion()

    {

        return $this->fk_organizacion;

    }


    /**

     * @param mixed $fk_organizacion

     *

     * @return self

     */

    public function setFkOrganizacion($fk_organizacion)

    {

        $this->fk_organizacion = $fk_organizacion;

    }


    /**

     * @return mixed

     */

    public function getFkClan()

    {

        return $this->fk_clan;

    }


    /**

     * @param mixed $fk_clan

     *

     * @return self

     */

    public function setFkClan($fk_clan)

    {

        $this->fk_clan = $fk_clan;

    }


    /**

     * @return mixed

     */

    public function getVcNomClan()

    {

        return $this->vc_nom_clan;

    }


    /**

     * @param mixed $vc_nom_clan

     *

     * @return self

     */

    public function setVcNomClan($vc_nom_clan)

    {

        $this->vc_nom_clan = $vc_nom_clan;

    }


    /**

     * @return mixed

     */

    public function getFkAreaArtistica()

    {

        return $this->fk_area_artistica;

    }


    /**

     * @param mixed $fk_area_artistica

     *

     * @return self

     */

    public function setFkAreaArtistica($fk_area_artistica)

    {

        $this->fk_area_artistica = $fk_area_artistica;

    }


    /**

     * @return mixed

     */

    public function getTipoPoblacion()

    {

        return $this->tipo_poblacion;

    }


    /**

     * @param mixed $tipo_poblacion

     *

     * @return self

     */

    public function setTipoPoblacion($tipo_poblacion)

    {

        $this->tipo_poblacion = $tipo_poblacion;

    }


    /**

     * @return mixed

     */

    public function getFkLugarAtencion()

    {

        return $this->fk_lugar_atencion;

    }


    /**

     * @param mixed $fk_lugar_atencion

     *

     * @return self

     */

    public function setFkLugarAtencion($fk_lugar_atencion)

    {

        $this->fk_lugar_atencion = $fk_lugar_atencion;

    }

    /**

     * @return mixed

     */

    public function getInModalidadAtencion()

    {

        return $this->in_modalidad_atencion;

    }


    /**

     * @param mixed $in_modalidad_atencion

     *

     * @return self

     */

    public function setinModalidadAtencion($in_modalidad_atencion)

    {

        $this->in_modalidad_atencion = $in_modalidad_atencion;

    }

    /**

     * @return mixed

     */

    public function getInTipoAtencion()

    {

        return $this->in_tipo_atencion;

    }

    /**

     * @param mixed $in_tipo_atencion

     *

     * @return self

     */

    public function setInTipoAtencion($in_tipo_atencion)

    {

        $this->in_tipo_atencion = $in_tipo_atencion;

    }

    /**

     * @return mixed

     */

    public function getInMaterial()

    {

        return $this->in_material;

    }

    /**

     * @param mixed $in_material

     *

     * @return self

     */

    public function setInMaterial($in_material)

    {

        $this->in_material = $in_material;

    }


    /**

     * @return mixed

     */

    public function getFkColegio()

    {

        return $this->fk_colegio;

    }


    /**

     * @param mixed $fk_colegio

     *

     * @return self

     */

    public function setFkColegio($fk_colegio)

    {

        $this->fk_colegio = $fk_colegio;

    }


    /**

     * @return mixed

     */

    public function getVcNomColegio()

    {

        return $this->vc_nom_colegio;

    }


    /**

     * @param mixed $vc_nom_colegio

     *

     * @return self

     */

    public function setVcNomColegio($vc_nom_colegio)

    {

        $this->vc_nom_colegio = $vc_nom_colegio;

    }


    /**

     * @return mixed

     */

    public function getFkModalidad()

    {

        return $this->fk_modalidad;

    }


    /**

     * @param mixed $fk_modalidad

     *

     * @return self

     */

    public function setFkModalidad($fk_modalidad)

    {

        $this->fk_modalidad = $fk_modalidad;

    }


    /**

     * @return mixed

     */

    public function getInLugarAtencion()

    {

        return $this->in_lugar_atencion;

    }


    /**

     * @param mixed $in_lugar_atencion

     *

     * @return self

     */

    public function setInLugarAtencion($in_lugar_atencion)

    {

        $this->in_lugar_atencion = $in_lugar_atencion;

    }


    /**

     * @return mixed fk_institucion

     */

    public function getFkInstitucion()

    {

        return $this->fk_institucion;

    }


    /**

     * @param mixed $fk_institucion

     *

     * @return fk_institucion

     */

    public function setFkInstitucion($fk_institucion)

    {

        $this->fk_institucion = $fk_institucion;

    }


    /**

     * @return mixed fk_aliado

     */

    public function getFkAliado()

    {

        return $this->fk_aliado;

    }


    /**

     * @param mixed $fk_aliado

     *

     * @return fk_aliado

     */

    public function setFkAliado($fk_aliado)

    {

        $this->fk_aliado = $fk_aliado;

    }


    /**

     * @return mixed in_tipo_ubicacion

     */

    public function getInTipoUbicacion()

    {

        return $this->in_tipo_ubicacion;

    }


    /**

     * @param mixed $in_tipo_ubicacion

     *

     * @return in_tipo_ubicacion

     */

    public function setInTipoUbicacion($in_tipo_ubicacion)

    {

        $this->in_tipo_ubicacion = $in_tipo_ubicacion;

    }


    /**

     * @return mixed tx_sitio

     */

    public function getTxSitio()

    {

        return $this->tx_sitio;

    }


    /**

     * @param mixed $tx_sitio

     *

     * @return tx_sitio

     */

    public function setTxSitio($tx_sitio)

    {

        $this->tx_sitio = $tx_sitio;

    }


    /**

     * @return mixed

     */

    public function getTipoGrupo()

    {

        return $this->tipo_grupo;

    }


    /**

     * @param mixed $tipo_grupo

     *

     * @return self

     */

    public function setTipoGrupo($tipo_grupo)

    {

        $this->tipo_grupo = $tipo_grupo;

    }


    /**

     * @return mixed

     */

    public function getEstudianteArray()

    {

        return $this->estudiante_array;

    }


    /**

     * @param mixed $estudiante_array

     *

     * @return self

     */

    public function setEstudianteArray($estudiante_array)

    {

        $this->estudiante_array = $estudiante_array;

    }

    /**

     * @return mixed

     */

    public function getAtencionArray()

    {

        return $this->atencion_array;

    }


    /**

     * @param mixed $atencion_array

     *

     * @return self

     */

    public function setAtencionArray($atencion_array)

    {

        $this->atencion_array = $atencion_array;

    }


    /**

     * @return mixed

     */

    public function getTipoGrupoAtencion()

    {

        return $this->tipo_grupo_atencion;

    }


    /**

     * @param mixed $tipo_grupo_atencion

     *

     * @return self

     */

    public function setTipoGrupoAtencion($tipo_grupo_atencion)

    {

        $this->tipo_grupo_atencion = $tipo_grupo_atencion;

    }


    /**

     * @return mixed

     */

    public function getHoraInicio()

    {

        return $this->hora_inicio;

    }


    /**

     * @param mixed $hora_inicio

     *

     * @return self

     */

    public function setHoraInicio($hora_inicio)

    {

        $this->hora_inicio = $hora_inicio;

    }


    /**

     * @return mixed

     */

    public function getHoraFin()

    {

        return $this->hora_fin;

    }


    /**

     * @param mixed $hora_fin

     *

     * @return self

     */

    public function setHoraFin($hora_fin)

    {

        $this->hora_fin = $hora_fin;

    }


    /**

     * @return mixed

     */

    public function getFkSalon()

    {

        return $this->fk_salon;

    }


    /**

     * @param mixed $fk_salon

     *

     * @return self

     */

    public function setFkSalon($fk_salon)

    {

        $this->fk_salon = $fk_salon;

    }

}