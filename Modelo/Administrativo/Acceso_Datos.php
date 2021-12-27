<?php
/**
* Clase que realiza las operaciones de acceso a la base de datos.
* Área de Sistemas
* @author: Juan Modesto
* @version: 1.0.1
*/

header ('Content-type: text/html; charset=utf-8');
include_once('Conexion.php');

Class Convocatoria{
  /**
  * Retorna un vector con el listado de los proyectos presentados con ese NIT
  * @return vector con el listado de Proyectos
  */
  public static function consultarPropuestas($nit)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT PK_Id_Organizacion FROM TB_PROPUESTA_Organizacion_Precontractual WHERE VC_NIT="'.$nit.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    $id_organizaciones="";
    foreach ($info as $array) {
        $id_organizaciones=$id_organizaciones.",".$array['PK_Id_Organizacion'];
    } 

    $proyectos = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto WHERE FIND_IN_SET(FK_Id_Organizacion_Precontractual,"'.$id_organizaciones.'");');

    $info = array();
    while ($fila = mysqli_fetch_array($proyectos))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    //var_dump($info);
    return $info;
  }

  /**
  * Retorna un vector con el listado de los proyectos presentados con ese NIT
  * @return vector con el listado de Proyectos
  */
  public static function consultarInfoProyecto($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto WHERE PK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
       return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarInfoOrganizacion($id_organizacion)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Organizacion_Precontractual WHERE PK_Id_Organizacion="'.$id_organizacion.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarInfoHistorialOrg($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Historial_Organizacion WHERE FK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarObjetivosEspecificos($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto_Obj_Especificos WHERE FK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarIndicadores($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto_Indicadores WHERE FK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarEquipo($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto_Equipo WHERE FK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarArchivos($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto_Archivos WHERE FK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }

  /**
  * Retorna un vector con la informacion del Proyecto.
  * @return vector la informacion del Proyecto
  */
  public static function consultarMetas($id_proyecto)
  {
  // Conectar con la base de datos y seleccionarla
  // Ejecutar la consulta SQL
    $resultado = mysqli_query(ConexionDatos::conexion(), 'SELECT * FROM TB_PROPUESTA_Proyecto_Metas WHERE FK_Id_Proyecto="'.$id_proyecto.'";');
 
    // Crear el array de elementos para la capa de la vista
    $info = array();
    while ($fila = mysqli_fetch_array($resultado))
    {
      $info[]=array_map('utf8_encode', $fila);
    }
    mysqli_close(ConexionDatos::conexion());
    
    return $info;
  }
}

?>