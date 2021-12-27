<?php

namespace General\Persistencia\DAOS;


class AuditoriaDAO extends GestionDAO {

    private $db;
    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {return;}
    public function modificarObjeto($objeto) {return;}
    public function eliminarObjeto($objeto) {return;}
    public function consultarObjeto($objeto){return;}

    public function guardarClickUsuario($objeto)
    {
    	$sql="INSERT INTO tb_log_login (FK_persona,DT_fecha_ingreso,VC_Url) VALUES (:FK_persona,:DT_fecha_ingreso,:VC_Url)";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':FK_persona',$objeto->getFkPersona());
        @$sentencia->bindParam(':DT_fecha_ingreso',$objeto->getDtFechaIngreso());
        @$sentencia->bindParam(':VC_Url',$objeto->getVcUrl());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function obtenerHistorialClicks($objeto)
    {
        $sql="SELECT L.VC_URL FROM tb_log_login AS L WHERE L.FK_persona = :FK_persona ORDER BY L.DT_fecha_ingreso DESC LIMIT 1";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':FK_persona',$objeto->getFkPersona());
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0]['VC_URL'];
    }

    public function agregarClickUsuario($objeto)
    { 
        $sql="UPDATE tb_log_login  SET TX_url = :url WHERE id = :id"; 
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':url',$objeto->getTxUrl());
        @$sentencia->bindParam(':id',$objeto->getId());
        $sentencia->execute();   
        return $sentencia->rowCount(); 
    }

    public function consultarUsuariosQueTienenLogLogin(){
      $sql = "SELECT DISTINCT PK_Id_Persona,VC_Primer_Apellido,VC_Segundo_Apellido,VC_Primer_Nombre,VC_Segundo_Nombre,VC_Identificacion FROM tb_log_login LEFT JOIN tb_persona_2017 ON PK_Id_Persona = FK_persona;";
      $sentencia = $this->db->prepare($sql);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarLogLoginUsuario($objeto){
      $objeto['mes_anio'] = $objeto['mes_anio']."%";
      $sql = "SELECT DT_fecha_ingreso as fecha_ingreso,TX_dispositivo as dispositivo,TX_IP as ip /*, TX_URL as url*/ FROM tb_log_login   WHERE FK_persona=:FK_persona AND DT_fecha_ingreso LIKE :DT_fecha_ingreso  ORDER BY DT_fecha_ingreso DESC"; 
      $sentencia = $this->db->prepare($sql);
      @$sentencia->bindParam(':FK_persona',$objeto['id_usuario']); 
      @$sentencia->bindParam(':DT_fecha_ingreso',$objeto['mes_anio']);  
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTablaAuditoria($objeto){
      $objeto->setFecha($objeto->getFecha()."%");
      $sql = "SELECT A.*,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre FROM tb_auditoria_".$objeto->getTipo()." A LEFT JOIN tb_persona_2017 P ON A.id_usuario_web = P.PK_Id_Persona WHERE A.fecha LIKE :fecha AND A.id_registro = :id_registro;";
      $sentencia = $this->db->prepare($sql);
      @$sentencia->bindParam(':fecha',$objeto->getFecha());
      @$sentencia->bindParam(':id_registro',$objeto->getPkRegistro());
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
}
 