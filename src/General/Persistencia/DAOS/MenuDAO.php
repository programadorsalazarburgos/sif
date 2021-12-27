<?php

namespace General\Persistencia\DAOS;


class MenuDAO extends GestionDAO {

    private $db;

    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {}

    public function modificarObjeto($objeto) {}

    public function eliminarObjeto($objeto) {}

    public function consultarObjeto($objeto){

    }

    public function crearModulo($datos){

    }

    public function actualizarModulo($datos){

    }

    public function crearActividad($datos,$id_usuario_web){
        $set_id_usuario = $this->db->prepare("SET @user_id = '".$id_usuario_web."';");
        $id_actividad = $this->consultarUltimoIdActividad();
        $sentencia=$this->db->prepare("INSERT INTO tb_menu_actividad(PK_Id_Actividad,VC_Nom_Actividad,VC_Page,FK_Modulo) VALUES (:id_actividad,:nombre_actividad,:pagina,:id_modulo)");
        @$sentencia->bindParam(':id_actividad',$id_actividad);
        @$sentencia->bindParam(':nombre_actividad',$datos['nombre']);
        @$sentencia->bindParam(':pagina',$datos['pagina']);
        @$sentencia->bindParam(':id_modulo',$datos['id_modulo']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return 1;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function actualizarActividad($datos,$id_usuario_web){
        $set_id_usuario = $this->db->prepare("SET @user_id = '".$id_usuario_web."';");
        $sentencia = $this->db->prepare("UPDATE tb_menu_actividad SET VC_Nom_Actividad=:nombre, VC_Page=:pagina, FK_Modulo=:id_modulo, estado=:estado WHERE PK_Id_Actividad=:id_actividad;");
        @$sentencia->bindParam(':nombre',$datos['nombre']);
        @$sentencia->bindParam(':pagina',$datos['pagina']);
        @$sentencia->bindParam(':id_modulo',$datos['id_modulo']);
        @$sentencia->bindParam(':id_actividad',$datos['id_actividad']);
        @$sentencia->bindParam(':estado',$datos['estado']);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
          $this->db->rollback();
          return "Error!: " . $e->getMessage() . "</br>";
      }
  }

    public function desactivarActividad($id_actividad,$id_usuario_web){
        $set_id_usuario = $this->db->prepare("SET @user_id = '".$id_usuario_web."';");
        $sentencia = $this->db->prepare("UPDATE tb_menu_actividad SET estado=0 WHERE PK_Id_Actividad=:id_actividad");
        @$sentencia->bindParam(':id_actividad',$id_actividad);
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia->execute();
            $this->db->commit();
            return "1";
        }catch(PDOExecption $e) {
          $this->db->rollback();
          return "Error!: " . $e->getMessage() . "</br>";
      }
    }

    public function getOptionActividadesPorEstado($estado){
        $sentencia=$this->db->prepare("SELECT * FROM tb_menu_actividad WHERE FIND_IN_SET(estado,:estado);");
        @$sentencia->bindParam(':estado',$estado);
        $sentencia->execute();
        $actividad = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $actividad;
    }

    public function getOptionModulosPorEstado($estado){
        $sentencia=$this->db->prepare("SELECT * FROM tb_menu_modulo;");
        $sentencia->execute();
        $modulo = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $modulo;
    }

    public function getOptionActividadesDeModulo($id_modulo){
        $sentencia=$this->db->prepare("SELECT A.* FROM tb_menu_actividad A 
            LEFT JOIN tb_menu_modulo M ON A.FK_Modulo = M.PK_Id_Modulo
            WHERE M.PK_Id_Modulo=:id_modulo AND (A.estado=1 OR A.estado=2);");
        @$sentencia->bindParam(':id_modulo',$id_modulo);
        $sentencia->execute();
        $actividad = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $actividad;
    }

    public function consultarDatosActividad($id_actividad){
        $sentencia=$this->db->prepare("SELECT * FROM tb_menu_actividad WHERE PK_Id_Actividad=:id_actividad;");
        @$sentencia->bindParam(':id_actividad',$id_actividad);
        $sentencia->execute();
        $actividad = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $actividad[0];
    }

    public function consultarUsuariosAsociadosIndividualActividad($id_actividad){
        $sentencia=$this->db->prepare("SELECT P.VC_Identificacion , concat(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre FROM tb_menu_actividad_usuario AU 
            LEFT JOIN tb_persona_2017 P ON AU.FK_Persona = P.PK_Id_Persona 
            WHERE FK_Actividad=:id_actividad;");
        @$sentencia->bindParam(':id_actividad',$id_actividad);
        $sentencia->execute();
        $usuario = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        return $usuario;
    }

    private function consultarUltimoIdActividad(){
        $sentencia=$this->db->prepare("SELECT MAX(PK_Id_Actividad) AS ultimo FROM tb_menu_actividad;");
        $sentencia->execute();
        $id_actividad = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        $id_actividad = $id_actividad[0]['ultimo'];
        return ++$id_actividad;
    }
}