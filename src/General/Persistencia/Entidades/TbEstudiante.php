<?php


namespace  General\Persistencia\Entidades;


/**

 * Object que representa la tabla 'tb_estudiante'

 *

 * @author: Camilo Calderón, gracias a http://phpdao.com

 * @date: 2017-07-05 23:05	 

 */

class TbEstudiante 

{

	

	private $id;

	private $in_identificacion;

	private $ch_tipo_identificacion;

	private $vc_primer_nombre;

	private $vc_segundo_nombre;

	private $vc_primer_apellido;

	private $vc_segundo_apellido;

	private $dd_f_nacimiento;

	private $ch_genero;

	private $vc_direccion;

	private $vc_correo;

	private $vc_telefono;

	private $vc_celular;

	private $vc_tipo_estudiante;

	private $da_fecha_registro;

	private $id_usuario_registro;

	private $fk_rh;

	private $nacionalidad;
	
	private $in_acepta_uso_imagen;

	private $in_acepta_uso_obras;

	private $in_acepta_uso_datos;


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

	 * Obtiene el valor de id

	 * @return mixed

	 */

	public function getId()

	{

			return $this->id;

	}


	/**

	 * Asigna el valor para id

	 * @param mixed $id 

	 */

	public function setId($id)

	{

			$this->id=$id;

	}


	/**

	 * Obtiene el valor de IN_Identificacion

	 * @return mixed

	 */

	public function getInIdentificacion()

	{

			return $this->in_identificacion;

	}


	/**

	 * Asigna el valor para IN_Identificacion

	 * @param mixed $in_identificacion 

	 */

	public function setInIdentificacion($in_identificacion)

	{

			$this->in_identificacion=$in_identificacion;

	}


	/**

	 * Obtiene el valor de CH_Tipo_Identificacion

	 * @return mixed

	 */

	public function getChTipoIdentificacion()

	{

			return $this->ch_tipo_identificacion;

	}


	/**

	 * Asigna el valor para CH_Tipo_Identificacion

	 * @param mixed $ch_tipo_identificacion 

	 */

	public function setChTipoIdentificacion($ch_tipo_identificacion)

	{

			$this->ch_tipo_identificacion=$ch_tipo_identificacion;

	}


	/**

	 * Obtiene el valor de VC_Primer_Nombre

	 * @return mixed

	 */

	public function getVcPrimerNombre()

	{

			return $this->vc_primer_nombre;

	}


	/**

	 * Asigna el valor para VC_Primer_Nombre

	 * @param mixed $vc_primer_nombre 

	 */

	public function setVcPrimerNombre($vc_primer_nombre)

	{

			$this->vc_primer_nombre=$vc_primer_nombre;

	}


	/**

	 * Obtiene el valor de VC_Segundo_Nombre

	 * @return mixed

	 */

	public function getVcSegundoNombre()

	{

			return $this->vc_segundo_nombre;

	}


	/**

	 * Asigna el valor para VC_Segundo_Nombre

	 * @param mixed $vc_segundo_nombre 

	 */

	public function setVcSegundoNombre($vc_segundo_nombre)

	{

			$this->vc_segundo_nombre=$vc_segundo_nombre;

	}


	/**

	 * Obtiene el valor de VC_Primer_Apellido

	 * @return mixed

	 */

	public function getVcPrimerApellido()

	{

			return $this->vc_primer_apellido;

	}


	/**

	 * Asigna el valor para VC_Primer_Apellido

	 * @param mixed $vc_primer_apellido 

	 */

	public function setVcPrimerApellido($vc_primer_apellido)

	{

			$this->vc_primer_apellido=$vc_primer_apellido;

	}


	/**

	 * Obtiene el valor de VC_Segundo_Apellido

	 * @return mixed

	 */

	public function getVcSegundoApellido()

	{

			return $this->vc_segundo_apellido;

	}


	/**

	 * Asigna el valor para VC_Segundo_Apellido

	 * @param mixed $vc_segundo_apellido 

	 */

	public function setVcSegundoApellido($vc_segundo_apellido)

	{

			$this->vc_segundo_apellido=$vc_segundo_apellido;

	}


	/**

	 * Obtiene el valor de DD_F_Nacimiento

	 * @return mixed

	 */

	public function getDdFNacimiento()

	{

			return $this->dd_f_nacimiento;

	}


	/**

	 * Asigna el valor para DD_F_Nacimiento

	 * @param mixed $dd_f_nacimiento 

	 */

	public function setDdFNacimiento($dd_f_nacimiento)

	{

			$this->dd_f_nacimiento=$dd_f_nacimiento;

	}


	/**

	 * Obtiene el valor de CH_Genero

	 * @return mixed

	 */

	public function getChGenero()

	{

			return $this->ch_genero;

	}


	/**

	 * Asigna el valor para CH_Genero

	 * @param mixed $ch_genero 

	 */

	public function setChGenero($ch_genero)

	{

			$this->ch_genero=$ch_genero;

	}


	/**

	 * Obtiene el valor de VC_Direccion

	 * @return mixed

	 */

	public function getVcDireccion()

	{

			return $this->vc_direccion;

	}


	/**

	 * Asigna el valor para VC_Direccion

	 * @param mixed $vc_direccion 

	 */

	public function setVcDireccion($vc_direccion)

	{

			$this->vc_direccion=$vc_direccion;

	}


	/**

	 * Obtiene el valor de VC_Correo

	 * @return mixed

	 */

	public function getVcCorreo()

	{

			return $this->vc_correo;

	}


	/**

	 * Asigna el valor para VC_Correo

	 * @param mixed $vc_correo 

	 */

	public function setVcCorreo($vc_correo)

	{

			$this->vc_correo=$vc_correo;

	}


	/**

	 * Obtiene el valor de VC_Telefono

	 * @return mixed

	 */

	public function getVcTelefono()

	{

			return $this->vc_telefono;

	}


	/**

	 * Asigna el valor para VC_Telefono

	 * @param mixed $vc_telefono 

	 */

	public function setVcTelefono($vc_telefono)

	{

			$this->vc_telefono=$vc_telefono;

	}


	/**

	 * Obtiene el valor de VC_Celular

	 * @return mixed

	 */

	public function getVcCelular()

	{

			return $this->vc_celular;

	}


	/**

	 * Asigna el valor para VC_Celular

	 * @param mixed $vc_celular 

	 */

	public function setVcCelular($vc_celular)

	{

			$this->vc_celular=$vc_celular;

	}


	/**

	 * Obtiene el valor de VC_Tipo_Estudiante

	 * @return mixed

	 */

	public function getVcTipoEstudiante()

	{

			return $this->vc_tipo_estudiante;

	}


	/**

	 * Asigna el valor para VC_Tipo_Estudiante

	 * @param mixed $vc_tipo_estudiante 

	 */

	public function setVcTipoEstudiante($vc_tipo_estudiante)

	{

			$this->vc_tipo_estudiante=$vc_tipo_estudiante;

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

	 * Obtiene el valor de FK_RH

	 * @return mixed

	 */

	public function getFkRh()

	{

			return $this->fk_rh;

	}


	/**

	 * Asigna el valor para FK_RH

	 * @param mixed $fk_rh 

	 */

	public function setFkRh($fk_rh)

	{
		if(!empty($fk_rh))
		{
			$this->fk_rh=$fk_rh;
		}else
		{
			$this->fk_rh=0;
		}

	}


	/**

	 * Obtiene el valor de FK_RH

	 * @return mixed

	 */

	public function getNacionalidad()

	{

			return $this->nacionalidad;

	}


	/**

	 * Asigna el valor para nacionalidad

	 * @param mixed $nacionalidad

	 */

	public function setNacionalidad($nacionalidad)

	{

			$this->nacionalidad=$nacionalidad;

	}

		/**

	 * Obtiene el valor de IN_Acepta_Uso_Imagen

	 * @return mixed

	 */

	public function getInAceptaUsoImagen()

	{

			return $this->in_acepta_uso_imagen;

	}


	/**

	 * Asigna el valor para IN_Acepta_Uso_Imagen

	 * @param mixed $in_acepta_uso_imagen

	 */

	public function setInAceptaUsoImagen($acepta_uso_imagen)

	{

			$this->in_acepta_uso_imagen=$acepta_uso_imagen;

	}

		/**

	 * Obtiene el valor de IN_Acepta_Uso_Obras

	 * @return mixed

	 */

	public function getInAceptaUsoObras()

	{

			return $this->in_acepta_uso_obras;

	}


	/**

	 * Asigna el valor para IN_Acepta_Uso_Obras

	 * @param mixed $in_acepta_uso_obras

	 */

	public function setInAceptaUsoObras($acepta_uso_obras)

	{

			$this->in_acepta_uso_obras=$acepta_uso_obras;

	}

		/**

	 * Obtiene el valor de IN_Acepta_Uso_Datos

	 * @return mixed

	 */

	public function getInAceptaUsoDatos()

	{

			return $this->in_acepta_uso_datos;

	}


	/**

	 * Asigna el valor para IN_Acepta_Uso_Datos

	 * @param mixed $in_acepta_uso_datos

	 */

	public function setInAceptaUsoDatos($acepta_uso_datos)

	{

			$this->in_acepta_uso_datos=$acepta_uso_datos;

	}


}

