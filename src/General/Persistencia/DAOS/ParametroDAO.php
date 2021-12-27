<?php

namespace General\Persistencia\DAOS; 


class ParametroDAO extends GestionDAO {

    private $db;
    
    function __construct()
    {        
        $this->db=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {

        return;
    }

    public function modificarObjeto($objeto) {

        return;
    }

    public function eliminarObjeto($objeto) {

        return;
    }

    public function consultarObjeto($objeto){

        return;
    }

    public function actualizarEstadoParametroDetalle($estado, $programa, $id_parametro)
    {
        if($programa=='CREA'){
            $sql = "UPDATE tb_parametro_detalle SET IN_Estado = :estado WHERE PK_Id_Tabla = :id_parametro;";
        }
        if($programa=='NIDOS'){
            $sql = "UPDATE tb_parametro_detalle SET IN_Estado_Nidos = :estado WHERE PK_Id_Tabla = :id_parametro;";
        }
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':estado',$estado);
        @$sentencia->bindParam(':id_parametro',$id_parametro);
        $sentencia->execute();
        $rowCount = $sentencia->rowCount();
        return $rowCount;
    }

    public function saveNuevoParametro($parametro)
    {
        $sql = "INSERT INTO tb_parametro (VC_Nombre) VALUES (:parametro);";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        $rowCount = $sentencia->rowCount();
        return $rowCount;
    }

    public function saveNuevoParametroDetalle($id_parametro, $nombre, $valor, $estado_crea, $estado_nidos)
    {
        $sql = "INSERT INTO tb_parametro_detalle (FK_Id_Parametro,VC_Descripcion, FK_Value, IN_Estado, IN_Estado_Nidos) VALUES (:id_parametro,:nombre,:valor,:estado_crea,:estado_nidos);";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_parametro',$id_parametro);
        @$sentencia->bindParam(':nombre',$nombre);
        @$sentencia->bindParam(':valor',$valor);
        @$sentencia->bindParam(':estado_crea',$estado_crea);
        @$sentencia->bindParam(':estado_nidos',$estado_nidos);
        $sentencia->execute();
        $rowCount = $sentencia->rowCount();
        return $rowCount;
    }

    public function getParametroDetalle($parametro)
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:parametro AND PD.IN_Estado = 1 ORDER BY FK_Value ASC";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function guardarNuevosDiasSubsanacion($datos)
    {
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        @$sentencia_fecha_fin_mes=$this->db->prepare("UPDATE tb_parametro_detalle SET FK_Value = :ultimo_dia_mes WHERE FK_Id_Parametro = :id_parametro AND VC_Descripcion = 'DIAS FIN MES';");
        @$sentencia_fecha_inicio_mes=$this->db->prepare("UPDATE tb_parametro_detalle SET FK_Value = :primer_dia_mes WHERE FK_Id_Parametro = :id_parametro AND VC_Descripcion = 'DIAS INICIO MES';");
        @$sentencia_fecha_fin_mes->bindParam(':ultimo_dia_mes',$datos['primer_dia_mes']);
        @$sentencia_fecha_fin_mes->bindParam(':id_parametro',$datos['id_parametro']);
        @$sentencia_fecha_inicio_mes->bindParam(':primer_dia_mes',$datos['ultimo_dia_mes']);
        @$sentencia_fecha_inicio_mes->bindParam(':id_parametro',$datos['id_parametro']);
        try {
          $this->db->beginTransaction();
          $set_id_usuario->execute();
          $sentencia_fecha_fin_mes->execute();
          $sentencia_fecha_inicio_mes->execute();
          $this->db->commit();
          return 1;
      }catch(PDOExecption $e) {
          $this->db->rollback();
          return "Error!: " . $e->getMessage() . "</br>";
      }
    }
    public function getParametroDetalleFlag($parametro, $esPrimero, $esUltimo)
    {
        $sql='SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:parametro AND PD.IN_Estado = 1 AND PD.TX_Estado_Proyecto = "O"';
        
        if($esPrimero == 1)
            $sql .= ' OR PD.TX_Estado_Proyecto = "I"';
        
        if($esUltimo == 1)
            $sql .= ' OR PD.TX_Estado_Proyecto = "F"';

        $sql .= ' ORDER BY FK_Value ASC';
       
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
}