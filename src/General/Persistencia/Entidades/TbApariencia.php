<?php

namespace  General\Persistencia\Entidades;

/**
 * Object que representa la tabla 'tb_apariencia'
 *
 * @author: Camilo Calderón, gracias a http://phpdao.com
 * @date: 2018-02-20 19:10	 
 */
class TbApariencia 
{
	
	private $id;
	private $fk_id_parametro;
	private $vc_banner;
	private $vc_titulo_banner;
	private $vc_tipografia_titulo;
	private $vc_tipografia_parrafo;
	private $vc_fondo_iframe;
	private $vc_fondo_marco;
	private $vc_color_fuente;
	private $vc_color_fuente_hover;
	private $vc_color_menu;
	private $vc_color_menu_hover;
	private $vc_color_info;
	private $vc_color_success;
	private $vc_color_warning;
	private $vc_color_danger;
	private $vc_color_default;
	private $vc_color_primary;
	private $vc_borde_info;
	private $vc_borde_success;
	private $vc_borde_warning;
	private $vc_borde_danger;
	private $vc_borde_default;
	private $vc_borde_primary;


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
	 * Obtiene el valor de FK_Id_Parametro
	 * @return mixed
	 */
	public function getFkIdParametro()
	{
			return $this->fk_id_parametro;
	}

	/**
	 * Asigna el valor para FK_Id_Parametro
	 * @param mixed $fk_id_parametro 
	 */
	public function setFkIdParametro($fk_id_parametro)
	{
			$this->fk_id_parametro=$fk_id_parametro;
	}

	/**
	 * Obtiene el valor de VC_Banner
	 * @return mixed
	 */
	public function getVcBanner()
	{
			return $this->vc_banner;
	}

	/**
	 * Asigna el valor para VC_Banner
	 * @param mixed $vc_banner 
	 */
	public function setVcBanner($vc_banner)
	{
			$this->vc_banner=$vc_banner;
	}

	/**
	 * Obtiene el valor de VC_Titulo_Banner
	 * @return mixed
	 */
	public function getVcTituloBanner()
	{
			return $this->vc_titulo_banner;
	}

	/**
	 * Asigna el valor para VC_Titulo_Banner
	 * @param mixed $vc_titulo_banner 
	 */
	public function setVcTituloBanner($vc_titulo_banner)
	{
			$this->vc_titulo_banner=$vc_titulo_banner;
	}

	/**
	 * Obtiene el valor de VC_Tipografia_Titulo
	 * @return mixed
	 */
	public function getVcTipografiaTitulo()
	{
			return $this->vc_tipografia_titulo;
	}

	/**
	 * Asigna el valor para VC_Tipografia_Titulo
	 * @param mixed $vc_tipografia_titulo 
	 */
	public function setVcTipografiaTitulo($vc_tipografia_titulo)
	{
			$this->vc_tipografia_titulo=$vc_tipografia_titulo;
	}

	/**
	 * Obtiene el valor de VC_Tipografia_Parrafo
	 * @return mixed
	 */
	public function getVcTipografiaParrafo()
	{
			return $this->vc_tipografia_parrafo;
	}

	/**
	 * Asigna el valor para VC_Tipografia_Parrafo
	 * @param mixed $vc_tipografia_parrafo 
	 */
	public function setVcTipografiaParrafo($vc_tipografia_parrafo)
	{
			$this->vc_tipografia_parrafo=$vc_tipografia_parrafo;
	}

	/**
	 * Obtiene el valor de VC_Fondo_Iframe
	 * @return mixed
	 */
	public function getVcFondoIframe()
	{
			return $this->vc_fondo_iframe;
	}

	/**
	 * Asigna el valor para VC_Fondo_Iframe
	 * @param mixed $vc_fondo_iframe 
	 */
	public function setVcFondoIframe($vc_fondo_iframe)
	{
			$this->vc_fondo_iframe=$vc_fondo_iframe;
	}

	/**
	 * Obtiene el valor de VC_Fondo_Marco
	 * @return mixed
	 */
	public function getVcFondoMarco()
	{
			return $this->vc_fondo_marco;
	}

	/**
	 * Asigna el valor para VC_Fondo_Marco
	 * @param mixed $vc_fondo_marco 
	 */
	public function setVcFondoMarco($vc_fondo_marco)
	{
			$this->vc_fondo_marco=$vc_fondo_marco;
	}

	/**
	 * Obtiene el valor de VC_Color_Fuente
	 * @return mixed
	 */
	public function getVcColorFuente()
	{
			return $this->vc_color_fuente;
	}

	/**
	 * Asigna el valor para VC_Color_Fuente
	 * @param mixed $vc_color_fuente 
	 */
	public function setVcColorFuente($vc_color_fuente)
	{
			$this->vc_color_fuente=$vc_color_fuente;
	}

	/**
	 * Obtiene el valor de VC_Color_Fuente_Hover
	 * @return mixed
	 */
	public function getVcColorFuenteHover()
	{
			return $this->vc_color_fuente_hover;
	}

	/**
	 * Asigna el valor para VC_Color_Fuente_Hover
	 * @param mixed $vc_color_fuente_hover 
	 */
	public function setVcColorFuenteHover($vc_color_fuente_hover)
	{
			$this->vc_color_fuente_hover=$vc_color_fuente_hover;
	}

	/**
	 * Obtiene el valor de VC_Color_Menu
	 * @return mixed
	 */
	public function getVcColorMenu()
	{
			return $this->vc_color_menu;
	}

	/**
	 * Asigna el valor para VC_Color_Menu
	 * @param mixed $vc_color_menu 
	 */
	public function setVcColorMenu($vc_color_menu)
	{
			$this->vc_color_menu=$vc_color_menu;
	}

	/**
	 * Obtiene el valor de VC_Color_Menu_Hover
	 * @return mixed
	 */
	public function getVcColorMenuHover()
	{
			return $this->vc_color_menu_hover;
	}

	/**
	 * Asigna el valor para VC_Color_Menu_Hover
	 * @param mixed $vc_color_menu_hover 
	 */
	public function setVcColorMenuHover($vc_color_menu_hover)
	{
			$this->vc_color_menu_hover=$vc_color_menu_hover;
	}

	/**
	 * Obtiene el valor de VC_Color_Info
	 * @return mixed
	 */
	public function getVcColorInfo()
	{
			return $this->vc_color_info;
	}

	/**
	 * Asigna el valor para VC_Color_Info
	 * @param mixed $vc_color_info 
	 */
	public function setVcColorInfo($vc_color_info)
	{
			$this->vc_color_info=$vc_color_info;
	}

	/**
	 * Obtiene el valor de VC_Color_Success
	 * @return mixed
	 */
	public function getVcColorSuccess()
	{
			return $this->vc_color_success;
	}

	/**
	 * Asigna el valor para VC_Color_Success
	 * @param mixed $vc_color_success 
	 */
	public function setVcColorSuccess($vc_color_success)
	{
			$this->vc_color_success=$vc_color_success;
	}

	/**
	 * Obtiene el valor de VC_Color_Warning
	 * @return mixed
	 */
	public function getVcColorWarning()
	{
			return $this->vc_color_warning;
	}

	/**
	 * Asigna el valor para VC_Color_Warning
	 * @param mixed $vc_color_warning 
	 */
	public function setVcColorWarning($vc_color_warning)
	{
			$this->vc_color_warning=$vc_color_warning;
	}

	/**
	 * Obtiene el valor de VC_Color_Danger
	 * @return mixed
	 */
	public function getVcColorDanger()
	{
			return $this->vc_color_danger;
	}

	/**
	 * Asigna el valor para VC_Color_Danger
	 * @param mixed $vc_color_danger 
	 */
	public function setVcColorDanger($vc_color_danger)
	{
			$this->vc_color_danger=$vc_color_danger;
	}

	/**
	 * Obtiene el valor de VC_Color_Default
	 * @return mixed
	 */
	public function getVcColorDefault()
	{
			return $this->vc_color_default;
	}

	/**
	 * Asigna el valor para VC_Color_Default
	 * @param mixed $vc_color_default 
	 */
	public function setVcColorDefault($vc_color_default)
	{
			$this->vc_color_default=$vc_color_default;
	}

	/**
	 * Obtiene el valor de VC_Color_Primary
	 * @return mixed
	 */
	public function getVcColorPrimary()
	{
			return $this->vc_color_primary;
	}

	/**
	 * Asigna el valor para VC_Color_Primary
	 * @param mixed $vc_color_primary 
	 */
	public function setVcColorPrimary($vc_color_primary)
	{
			$this->vc_color_primary=$vc_color_primary;
	}

	/**
	 * Obtiene el valor de VC_Borde_Info
	 * @return mixed
	 */
	public function getVcBordeInfo()
	{
			return $this->vc_borde_info;
	}

	/**
	 * Asigna el valor para VC_Borde_Info
	 * @param mixed $vc_borde_info 
	 */
	public function setVcBordeInfo($vc_borde_info)
	{
			$this->vc_borde_info=$vc_borde_info;
	}

	/**
	 * Obtiene el valor de VC_Borde_Success
	 * @return mixed
	 */
	public function getVcBordeSuccess()
	{
			return $this->vc_borde_success;
	}

	/**
	 * Asigna el valor para VC_Borde_Success
	 * @param mixed $vc_borde_success 
	 */
	public function setVcBordeSuccess($vc_borde_success)
	{
			$this->vc_borde_success=$vc_borde_success;
	}

	/**
	 * Obtiene el valor de VC_Borde_Warning
	 * @return mixed
	 */
	public function getVcBordeWarning()
	{
			return $this->vc_borde_warning;
	}

	/**
	 * Asigna el valor para VC_Borde_Warning
	 * @param mixed $vc_borde_warning 
	 */
	public function setVcBordeWarning($vc_borde_warning)
	{
			$this->vc_borde_warning=$vc_borde_warning;
	}

	/**
	 * Obtiene el valor de VC_Borde_Danger
	 * @return mixed
	 */
	public function getVcBordeDanger()
	{
			return $this->vc_borde_danger;
	}

	/**
	 * Asigna el valor para VC_Borde_Danger
	 * @param mixed $vc_borde_danger 
	 */
	public function setVcBordeDanger($vc_borde_danger)
	{
			$this->vc_borde_danger=$vc_borde_danger;
	}

	/**
	 * Obtiene el valor de VC_Borde_Default
	 * @return mixed
	 */
	public function getVcBordeDefault()
	{
			return $this->vc_borde_default;
	}

	/**
	 * Asigna el valor para VC_Borde_Default
	 * @param mixed $vc_borde_default 
	 */
	public function setVcBordeDefault($vc_borde_default)
	{
			$this->vc_borde_default=$vc_borde_default;
	}

	/**
	 * Obtiene el valor de VC_Borde_Primary
	 * @return mixed
	 */
	public function getVcBordePrimary()
	{
			return $this->vc_borde_primary;
	}

	/**
	 * Asigna el valor para VC_Borde_Primary
	 * @param mixed $vc_borde_primary 
	 */
	public function setVcBordePrimary($vc_borde_primary)
	{
			$this->vc_borde_primary=$vc_borde_primary;
	}


}
