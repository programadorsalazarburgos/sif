<?php

namespace General\Persistencia\DAOS; 


class ConsultasAdministrativoDAO extends GestionDAO {

    private $dbPDO;
    
    function __construct()
    {        
        $this->dbPDO=$this->obtenerPDOBD();
    }
    
    public function crearObjeto($objeto) {
    	//Nothing to do.
    }

    public function modificarObjeto($update) {
    	//Nothing to do.
    }

    public function eliminarObjeto($objeto) {
    	//Nothing to do.
    }

    public function consultarObjeto($localidad) {            
    	//Nothing to do.
    }

    public function consultarTotalAsignacionEstudiantes($datos){
        $sql="SELECT count(GE.FK_estudiante) AS count,GE.FK_usuario_ingreso,
        P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido
        FROM tb_terr_grupo_".$datos['linea_atencion']."_estudiante GE
        LEFT JOIN tb_persona_2017 P ON GE.FK_usuario_ingreso = P.PK_Id_Persona
        WHERE YEAR(GE.DT_Fecha_Ingreso) = :anio AND MONTH(GE.DT_Fecha_Ingreso) = :mes
        GROUP BY GE.FK_usuario_ingreso";  
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalRemocionEstudiantes($datos){
        $sql="SELECT count(GE.FK_estudiante) AS count,GE.FK_usuario_retiro,
        P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido
        FROM tb_terr_grupo_".$datos['linea_atencion']."_estudiante GE
        LEFT JOIN tb_persona_2017 P ON GE.FK_usuario_retiro = P.PK_Id_Persona
        WHERE YEAR(GE.DT_Fecha_retiro) = :anio AND MONTH(GE.DT_Fecha_retiro) = :mes
        GROUP BY GE.FK_usuario_retiro";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalCreacionEstudiantes($datos){
        $sql="SELECT count(E.id) AS count,E.Id_Usuario_Registro,
        P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido
        FROM tb_estudiante E
        LEFT JOIN tb_persona_2017 P ON E.Id_Usuario_Registro = P.PK_Id_Persona
        WHERE YEAR(E.DA_Fecha_Registro) = :anio AND MONTH(E.DA_Fecha_Registro) = :mes AND VC_Tipo_Estudiante = :tipo_estudiante
        GROUP BY E.Id_Usuario_Registro";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':tipo_estudiante',$datos['tipo_estudiante']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalAsignacionEstudiantesPorUsuario($datos,$linea_atencion){
        $sql="SELECT count(GE.FK_estudiante) AS count 
        FROM tb_terr_grupo_".$linea_atencion."_estudiante GE 
        WHERE YEAR(GE.DT_Fecha_ingreso) = :anio AND MONTH(GE.DT_Fecha_ingreso) = :mes 
        AND GE.FK_usuario_ingreso = :id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalRemocionEstudiantesPorUsuario($datos,$linea_atencion){
        $sql="SELECT count(GE.FK_estudiante) AS count 
        FROM tb_terr_grupo_".$linea_atencion."_estudiante GE 
        WHERE YEAR(GE.DT_Fecha_retiro) = :anio AND MONTH(GE.DT_Fecha_retiro) = :mes 
        AND GE.FK_usuario_retiro = :id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarListadoAsignacionEstudiantes($datos){
        $sql="SELECT GE.DT_fecha_ingreso,GE.estado,GE.TX_observaciones,GE.FK_grupo,G.tipo_grupo,
        E.IN_Identificacion,E.VC_Primer_Nombre,E.VC_Segundo_Nombre,E.VC_Primer_Apellido,E.VC_Segundo_Apellido
        FROM tb_terr_grupo_".$datos['linea_atencion']."_estudiante GE
        LEFT JOIN tb_estudiante E ON GE.FK_estudiante = E.id 
        LEFT JOIN tb_terr_grupo_".$datos['linea_atencion']." G ON GE.FK_grupo = G.PK_Grupo 
        WHERE YEAR(GE.DT_Fecha_Ingreso) = :anio AND MONTH(GE.DT_Fecha_Ingreso) = :mes AND GE.FK_usuario_ingreso = :id_persona ORDER BY DT_Fecha_Ingreso";  
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_persona',$datos['id_persona']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarListadoRemocionEstudiantes($datos){
        $sql="SELECT GE.DT_fecha_retiro,GE.estado,GE.TX_observaciones,GE.FK_grupo,G.tipo_grupo,
        E.IN_Identificacion,E.VC_Primer_Nombre,E.VC_Segundo_Nombre,E.VC_Primer_Apellido,E.VC_Segundo_Apellido
        FROM tb_terr_grupo_".$datos['linea_atencion']."_estudiante GE
        LEFT JOIN tb_estudiante E ON GE.FK_estudiante = E.id 
        LEFT JOIN tb_terr_grupo_".$datos['linea_atencion']." G ON GE.FK_grupo = G.PK_Grupo 
        WHERE YEAR(GE.DT_Fecha_retiro) = :anio AND MONTH(GE.DT_Fecha_retiro) = :mes AND GE.FK_usuario_retiro = :id_persona ORDER BY DT_Fecha_retiro";  
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_persona',$datos['id_persona']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarListadoCreacionEstudiantes($datos){
        $sql="SELECT E.DA_Fecha_Registro,E.VC_Direccion,E.VC_Telefono,
        E.IN_Identificacion,E.VC_Primer_Nombre,E.VC_Segundo_Nombre,E.VC_Primer_Apellido,E.VC_Segundo_Apellido
        FROM tb_estudiante E
        WHERE YEAR(E.DA_Fecha_Registro) = :anio AND MONTH(E.DA_Fecha_Registro) = :mes AND E.Id_Usuario_Registro = :id_persona AND VC_Tipo_Estudiante = :tipo_estudiante ORDER BY DA_Fecha_Registro";  
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_persona',$datos['id_persona']);
        @$sentencia->bindParam(':tipo_estudiante',$datos['tipo_estudiante']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalEstudiantesCreadosPorUsuario($datos){
        $sql="SELECT count(E.id) AS count, VC_Tipo_Estudiante 
        FROM tb_estudiante E 
        WHERE YEAR(E.DA_Fecha_Registro) = :anio AND MONTH(E.DA_Fecha_Registro) = :mes AND E.Id_Usuario_Registro = :id_usuario 
        GROUP BY E.VC_Tipo_Estudiante;";  
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarCreaDeAsistenteAdministrativo($id_usuario){
        $sql="SELECT C.VC_Nom_Clan, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Nombre) AS nombre_coordinador, ED.TX_Firma_Escaneada AS firma_coordinador
        FROM tb_clan C 
        JOIN tb_persona_2017 P ON C.FK_Persona_Administrador = P.PK_Id_Persona 
        LEFT JOIN tb_persona_extra_data ED ON P.PK_Id_Persona = ED.FK_Id_Persona
        WHERE FIND_IN_SET(:id_usuario,FK_Asistentes) > 0 OR FK_Persona_Administrador = :id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarCreaDeCoordinador($id_usuario){
        $sql="SELECT VC_Nom_Clan FROM tb_clan WHERE FK_Persona_Administrador = :id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalGruposCreadosPorUsuario($datos,$linea_atencion){
        $sql="SELECT count(G.PK_Grupo) AS count 
        FROM tb_terr_grupo_".$linea_atencion." G 
        WHERE YEAR(G.DT_fecha_creacion) = :anio AND MONTH(G.DT_fecha_creacion) = :mes 
        AND G.FK_creador = :id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarTotalGruposCerradosPorUsuario($datos,$linea_atencion){
        $sql="SELECT count(G.PK_Grupo) AS count 
        FROM tb_terr_grupo_".$linea_atencion." G 
        WHERE YEAR(G.DT_fecha_cierre) = :anio AND MONTH(G.DT_fecha_cierre) = :mes 
        AND G.FK_quien_cerro = :id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':anio',$datos['anio']);
        @$sentencia->bindParam(':mes',$datos['mes']);
        @$sentencia->bindParam(':id_usuario',$datos['id_usuario']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDatosReporteDigitalMensual($datos){
        $sql="SELECT COUNT(1) AS conteo, linea_atencion, SM_estado FROM tb_terr_informe_mensual_grupo WHERE FK_persona_aprueba = :id_usuario AND VC_fecha_reporte = :periodo GROUP BY FK_persona_reporte, FK_grupo, linea_atencion, SM_estado";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':periodo', $datos['periodo']);
        @$sentencia->bindParam(':id_usuario', $datos['id_usuario']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
}