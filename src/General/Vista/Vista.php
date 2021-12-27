<?php
namespace General\Vista;
class Vista
{

    /**
     * Class de la etiqueta donde se imprime en el layot
     *
     * @var string
     */
    private $elementoImprime = 'contenido';

    /**
     * Nombre del metodo del controlador que ejecuta la Vista
     * @var String
     */
    private $nombreMetodo;

    /**
     * Nombre del namespace principal del controlador que ejecuta la Vista
     * @var String
     */
    private $namespace;

	/**
	  * ruta layout (plantilla maestra para la vista)
      * @var String
      */
	private $layout;

	/**
	  * ruta archivo donde se imprimirán lo retornado del Modelo,
	  * si se especifica Layout, se imprimira en la etiqueta con clase $elementoImprime
      * @var String
      */
	private $plantilla;

    /**
     * Variables enviadas a la vista
     * @var array
     */
    protected $variables = array();

    /**
     * Constructor
     *
     * @param  null|array $variables
     * @param  array $options
     */
    public function __construct($variables = null)
    {
        // Inicializar contenedor de variables
        $this->setVariables($variables);
        //$this->setNombreMetodo($nombreMetodo);
        $this->getRuta();

    }

    /**
     * Gets the Class de la etiqueta donde se imprime en el layot.
     *
     * @return string
     */
    public function getElementoImprime()
    {
        return $this->elementoImprime;
    }

    /**
     * Sets the Class de la etiqueta donde se imprime en el layot.
     *
     * @param string $elementoImprime the elemento imprime
     *
     * @return self
     */
    private function setElementoImprime($elementoImprime)
    {
        $this->elementoImprime = $elementoImprime;

        return $this;
    }

    /**
     * Gets the ruta layout (plantilla maestra para la vista).
     *
     * @return String
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Sets the ruta layout (plantilla maestra para la vista).
     *
     * @param String $layout the layout
     *
     * @return self
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Gets the ruta archivo donde se imprimirán lo retornado del Modelo,
si se especifica Layout, se imprimira en la etiqueta con clase $elementoImprime.
     *
     * @return String
     */
    public function getPlantilla()
    {
        return $this->plantilla;
    }

    /**
     * Sets the ruta archivo donde se imprimirán lo retornado del Modelo,
si se especifica Layout, se imprimira en la etiqueta con clase $elementoImprime.
     *
     * @param String $plantilla the plantilla
     *
     * @return self
     */
    public function setPlantilla($plantilla)
    {
        $this->plantilla = $plantilla;

        return $this;
    }

    /**
     * Gets the Variables enviadas a la vista.
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Sets the Variables enviadas a la vista.
     *
     * @param array $variables the variables
     *
     * @return self
     */
    public function setVariables(array $variables)
    {
        $this->variables = $variables;

        return $this;
    }


    public function renderHtml($namespace = null)
    {
      if ($namespace == null )
        $namespace = $this->getNamespace();

      $ruta = $namespace.'/Vista/'.$this->getPlantilla().'.php';
      $path='../../'.$ruta;
      if (file_exists($path)) {
        include($path);
      }else
      {
        $path='./'.$ruta;
        if(file_exists($path)) {
          include($path);
        }
      }
      //$var = ob_get_clean();
      //$var=ob_get_contents();
      //ob_end_clean();
      //echo $var;
      //$retorno= file_get_contents($path);
      //echo $retorno;
    }

    public function returnHtml($namespace = null)
    {
        $html = "";
        if ($namespace == null )
            $namespace = $this->getNamespace();

        $ruta = $namespace.'/Vista/'.$this->getPlantilla().'.php';
        $path='../../'.$ruta;
        if (file_exists($path)) {
            include($path);
        }else
        {
            $path='./'.$ruta;
            if(file_exists($path)) {
                include($path);
            }
        }
        return $html;
    }    

    /**
     * Gets the Nombre del namespace principal del controlador que ejecuta la Vista.
     *
     * @return String
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Sets the Nombre del namespace principal del controlador que ejecuta la Vista.
     *
     * @param String $namespace the namespace
     *
     * @return self
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

	/**
	 * Gets the caller of the function where this function is called from
	 * @param string what to return? (Leave empty to get all, or specify: "class", "function", "line", "class", etc.) - options see: http://php.net/manual/en/function.debug-backtrace.php
	 */
	public function getRuta($what = NULL)
	{
	    $trace = debug_backtrace();
        //echo '<pre>'.print_r($trace).'</pre>';
        $datos = $trace[4];
        //echo '<pre>**'.print_r($datos,true).'</pre>';
        $this->setPlantilla($datos['function']);
        $namespace = substr($datos['class'],0, strpos($datos['class'],'\\'));
        $this->setNamespace($namespace);

	    //echo '<strong>'.$this->getNamespace().' - '.$this->getPlantilla().'</strong>';
	}
}
