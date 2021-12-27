<?php

namespace General\Persistencia\DAOS;


class BeneficiarioDAO extends GestionDAO {

    private $db;

    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {
        $TbEstudiante = $objeto['TbEstudiante'];
        $TbEstudianteDetalleAnio = $objeto['TbEstudianteDetalleAnio'];
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$TbEstudiante->getIdUsuarioRegistro().";");
        $sentencia_tb_estudiante = $this->db->prepare("INSERT INTO tb_estudiante (IN_Identificacion,CH_Tipo_Identificacion, VC_Primer_Nombre,VC_Segundo_Nombre,VC_Primer_Apellido,VC_Segundo_Apellido,DD_F_Nacimiento,CH_Genero,VC_Direccion,VC_Correo,VC_Telefono,VC_Celular,DA_Fecha_Registro,FK_RH,Id_Usuario_Registro,VC_Tipo_Estudiante,nacionalidad, IN_Acepta_Uso_Imagen, IN_Acepta_Uso_Obras, IN_Acepta_Uso_Datos) VALUES (:IN_Identificacion,:CH_Tipo_Identificacion,:VC_Primer_Nombre,:VC_Segundo_Nombre,:VC_Primer_Apellido,:VC_Segundo_Apellido,:DD_F_Nacimiento,:CH_Genero,:VC_Direccion,:VC_Correo,:VC_Telefono,:VC_Celular,:DA_Fecha_Registro,:FK_RH,:Id_Usuario_Registro,:VC_Tipo_Estudiante,:nacionalidad,:IN_Acepta_Uso_Imagen, :IN_Acepta_Uso_Obras, :IN_Acepta_Uso_Datos)");
        @$sentencia_tb_estudiante->bindParam(':IN_Identificacion',str_replace(' ', '', $TbEstudiante->getInIdentificacion()));
        @$sentencia_tb_estudiante->bindParam(':CH_Tipo_Identificacion',$TbEstudiante->getChTipoIdentificacion());
        @$sentencia_tb_estudiante->bindParam(':VC_Primer_Nombre',str_replace(' ', '', strtoupper($TbEstudiante->getVcPrimerNombre())));
        @$sentencia_tb_estudiante->bindParam(':VC_Segundo_Nombre',str_replace(' ', '', strtoupper($TbEstudiante->getVcSegundoNombre())));
        @$sentencia_tb_estudiante->bindParam(':VC_Primer_Apellido',str_replace(' ', '', strtoupper($TbEstudiante->getVcPrimerApellido())));
        @$sentencia_tb_estudiante->bindParam(':VC_Segundo_Apellido',str_replace(' ', '', strtoupper($TbEstudiante->getVcSegundoApellido())));
        @$sentencia_tb_estudiante->bindParam(':DD_F_Nacimiento',$TbEstudiante->getDdFNacimiento());
        @$sentencia_tb_estudiante->bindParam(':CH_Genero',$TbEstudiante->getChGenero());
        @$sentencia_tb_estudiante->bindParam(':VC_Direccion',$TbEstudiante->getVcDireccion());
        @$sentencia_tb_estudiante->bindParam(':VC_Correo',str_replace(' ', '', $TbEstudiante->getVcCorreo()));
        @$sentencia_tb_estudiante->bindParam(':VC_Telefono',$TbEstudiante->getVcTelefono());
        @$sentencia_tb_estudiante->bindParam(':VC_Celular',$TbEstudiante->getVcCelular());
        @$sentencia_tb_estudiante->bindParam(':DA_Fecha_Registro',$TbEstudiante->getDaFechaRegistro());

        @$sentencia_tb_estudiante->bindParam(':FK_RH',$TbEstudiante->getFkRh());
        @$sentencia_tb_estudiante->bindParam(':Id_Usuario_Registro',$TbEstudiante->getIdUsuarioRegistro());
        @$sentencia_tb_estudiante->bindParam(':VC_Tipo_Estudiante',$TbEstudiante->getVcTipoEstudiante());
        @$sentencia_tb_estudiante->bindParam(':nacionalidad',$TbEstudiante->getNacionalidad());
        @$sentencia_tb_estudiante->bindParam(':IN_Acepta_Uso_Imagen',$TbEstudiante->getInAceptaUsoImagen());
        @$sentencia_tb_estudiante->bindParam(':IN_Acepta_Uso_Obras',$TbEstudiante->getInAceptaUsoObras());
        @$sentencia_tb_estudiante->bindParam(':IN_Acepta_Uso_Datos',$TbEstudiante->getInAceptaUsoDatos());
        try {
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $sentencia_tb_estudiante->execute();
            $id_estudiante= $this->db->lastInsertId();
            $TbEstudianteDetalleAnio->setFkEstudiante($id_estudiante);
            $this->db->commit();
            $this->crearRegistroDetalleAnio($TbEstudianteDetalleAnio);
            $documento_estudiante = $TbEstudiante->getInIdentificacion();
            if($TbEstudiante->getInIdentificacion() == ''){
                $sentencia_update_documento = $this->db->prepare("UPDATE tb_estudiante SET IN_Identificacion=:documento_provisional WHERE id=:id_estudiante");
                $documento_provisional = "SIFPROV".$id_estudiante;
                $sentencia_update_documento->bindParam(':documento_provisional',$documento_provisional);
                $sentencia_update_documento->bindParam(':id_estudiante',$id_estudiante);
                $sentencia_update_documento->execute();
                $documento_estudiante = $documento_provisional;
            }
            return $id_estudiante;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function modificarObjeto($objeto) {
    	return;
    } 

    public function modificarDetalleAnio($detalle_anio) {
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$detalle_anio->getFkUsuarioCreacion().";");
        $sql_update = "UPDATE tb_estudiante_detalle_anio SET FK_clan=:FK_clan,FK_colegio=:FK_colegio,FK_grado=:FK_grado,jornada=:jornada,NOMBRE_ACUDIENTE=:NOMBRE_ACUDIENTE,IDENTIFICACION_ACUDIENTE=:IDENTIFICACION_ACUDIENTE,TELEFONO_ACUDIENTE=:TELEFONO_ACUDIENTE,FK_Grupo_Poblacional=:FK_Grupo_Poblacional,FK_Eps=:FK_Eps,TX_Tipo_Afiliacion=:TX_Tipo_Afiliacion,TX_Enfermedades=:TX_Enfermedades,FK_Localidad=:FK_Localidad,TX_Barrio=:TX_Barrio,FK_tipo_poblacion_victima=:FK_tipo_poblacion_victima,FK_tipo_discapacidad=:FK_tipo_discapacidad,TX_etnia=:TX_etnia,IN_estrato=:IN_estrato,TX_observaciones=:TX_observaciones, sisben=:sisben, DA_fecha_creacion=CURRENT_DATE WHERE FK_estudiante=:FK_estudiante AND anio=:anio;";
        $update_detalle_anio = $this->db->prepare($sql_update);
        @$update_detalle_anio->bindParam(':FK_clan',$detalle_anio->getFkClan());
        @$update_detalle_anio->bindParam(':FK_colegio',$detalle_anio->getFkColegio());
        @$update_detalle_anio->bindParam(':FK_grado',$detalle_anio->getFkGrado());
        @$update_detalle_anio->bindParam(':jornada',$detalle_anio->getFkJornada());
        @$update_detalle_anio->bindParam(':NOMBRE_ACUDIENTE',$detalle_anio->getNombreAcudiente());
        @$update_detalle_anio->bindParam(':IDENTIFICACION_ACUDIENTE',$detalle_anio->getIdentificacionAcudiente());
        @$update_detalle_anio->bindParam(':TELEFONO_ACUDIENTE',$detalle_anio->getTelefonoAcudiente());
        @$update_detalle_anio->bindParam(':FK_Grupo_Poblacional',$detalle_anio->getFkGrupoPoblacional());
        @$update_detalle_anio->bindParam(':FK_Eps',$detalle_anio->getFkEps());
        @$update_detalle_anio->bindParam(':TX_Tipo_Afiliacion',$detalle_anio->getTxTipoAfiliacion());
        @$update_detalle_anio->bindParam(':TX_Enfermedades',$detalle_anio->getTxEnfermedades());
        @$update_detalle_anio->bindParam(':FK_Localidad',$detalle_anio->getFkLocalidad());
        @$update_detalle_anio->bindParam(':TX_Barrio',$detalle_anio->getTxBarrio());
        @$update_detalle_anio->bindParam(':FK_tipo_poblacion_victima',$detalle_anio->getFkTipoPoblacionVictima());
        @$update_detalle_anio->bindParam(':FK_tipo_discapacidad',$detalle_anio->getFkTipoDiscapacidad());
        @$update_detalle_anio->bindParam(':TX_etnia',$detalle_anio->getFkEtnia());
        @$update_detalle_anio->bindParam(':IN_estrato',$detalle_anio->getInEstrato());
        @$update_detalle_anio->bindParam(':FK_estudiante',$detalle_anio->getFkEstudiante());
        @$update_detalle_anio->bindParam(':anio',$detalle_anio->getAnio());
        @$update_detalle_anio->bindParam(':sisben',$detalle_anio->getPuntajeSisben());
        @$update_detalle_anio->bindParam(':TX_observaciones',$detalle_anio->getTxObservaciones());
        try{
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $resultado_update = $update_detalle_anio->execute();
            $this->db->commit();
            return 1;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function eliminarObjeto($objeto) {
    	return;
    }

    public function consultarObjeto($texto) {
        $sql = "SELECT P.id,IN_Identificacion,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS VC_Nombre
        FROM tb_estudiante P
        WHERE (CONCAT(P.VC_Primer_Nombre,' ', P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido)
        LIKE '%".$texto."%' OR P.IN_Identificacion LIKE '%".$texto."%')";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarUltimoGrupoActivoEstudiante($id_estudiante,$tipo_grupo){
        $sql = "SELECT G.FK_area_artistica,G.FK_clan,G.FK_organizacion,G.FK_Colegio
        FROM tb_terr_grupo_arte_escuela_estudiante E
        LEFT JOIN tb_terr_grupo_arte_escuela G ON E.FK_grupo = G.PK_Grupo
        WHERE E.FK_estudiante = :FK_estudiante
        ORDER BY E.DT_fecha_ingreso DESC
        LIMIT 1";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':FK_estudiante',$id_estudiante);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEstudianteEnTbEstudiante($objeto){
        $where="";
        $identificacion="";
        $apellido1="";
        $apellido2="";
        $nombre1="";
        $nombre2="";
        $sql = "SELECT E.id, E.IN_Identificacion AS IN_Identificacion_Estudiante,CONCAT(E.VC_Primer_Nombre,' ',E.VC_Segundo_Nombre,' ',E.VC_Primer_Apellido,' ',E.VC_Segundo_Apellido) AS NOMBRE,G.VC_Descripcion_Grado,C.VC_Nom_Colegio, 'tb_estudiante' AS ORIGEN,E.VC_Tipo_Estudiante
        FROM tb_estudiante E LEFT JOIN tb_estudiante_detalle_anio D ON E.id = D.FK_estudiante AND D.anio = YEAR(NOW()) LEFT JOIN tb_colegios C ON D.FK_colegio = C.PK_Id_Colegio LEFT JOIN tb_grado G ON D.FK_grado = G.PK_Id_Grado WHERE ";
        if($objeto->getInIdentificacion()!=null && $objeto->getInIdentificacion()!=''){

            if($where!="")
                $where.=" AND E.IN_Identificacion = :inIdentificacion";
            else
                $where.="E.IN_Identificacion = :inIdentificacion";
            $identificacion = $objeto->getInIdentificacion();
        }
        if($objeto->getVcPrimerApellido()!=null && $objeto->getVcPrimerApellido()!=''){
            if($where!="")
                $where.=" AND E.VC_Primer_Apellido LIKE :vcPrimerApellido";
            else
                $where.="E.VC_Primer_Apellido LIKE :vcPrimerApellido";
            $apellido1="%".trim($objeto->getVcPrimerApellido())."%"; 
        }
        if($objeto->getVcSegundoApellido()!=null && $objeto->getVcSegundoApellido()!=''){
            if($where!="")
                $where.=" AND E.VC_Segundo_Apellido LIKE :vcSegundoApellido";   
            else
                $where.="E.VC_Segundo_Apellido LIKE :vcSegundoApellido"; 
            $apellido2="%".trim($objeto->getVcSegundoApellido())."%";
        } 
        if($objeto->getVcPrimerNombre()!=null && $objeto->getVcPrimerNombre()!=''){
            if($where!="")
                $where.=" AND E.VC_Primer_Nombre LIKE :vcPrimerNombre";
            else
                $where.="E.VC_Primer_Nombre LIKE :vcPrimerNombre";
            $nombre1="%".trim($objeto->getVcPrimerNombre())."%";
        }
        if($objeto->getVcSegundoNombre()!=null && $objeto->getVcSegundoNombre()!=''){
            if($where!="")
                $where.=" AND E.VC_Segundo_Nombre LIKE :vcSegundoNombre"; 
            else
                $where.="E.VC_Segundo_Nombre LIKE :vcSegundoNombre"; 
            $nombre2="%".trim($objeto->getVcSegundoNombre())."%"; 
        }
        //var_dump($objeto);
        $sql.=$where;   
        //echo $sql;   

        $sentencia=$this->db->prepare($sql);
        if($objeto->getInIdentificacion()!=null && $objeto->getInIdentificacion()!='')
            @$sentencia->bindParam(':inIdentificacion',$identificacion);   
        if($objeto->getVcPrimerApellido()!=null && $objeto->getVcPrimerApellido()!='')          
            @$sentencia->bindParam(':vcPrimerApellido',$apellido1);   
        if($objeto->getVcSegundoApellido()!=null && $objeto->getVcSegundoApellido()!='')
            @$sentencia->bindParam(':vcSegundoApellido',$apellido2); 
        if($objeto->getVcPrimerNombre()!=null && $objeto->getVcPrimerNombre()!='')
            @$sentencia->bindParam(':vcPrimerNombre',$nombre1); 
        if($objeto->getVcSegundoNombre()!=null && $objeto->getVcSegundoNombre()!='')                     
            @$sentencia->bindParam(':vcSegundoNombre',$nombre2);     
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarIDEstudiantePorDocumento($documento){
        $sql = "SELECT id FROM tb_estudiante WHERE IN_Identificacion = '".$documento."';";
        $sentencia=$this->db->prepare($sql);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarGruposActivosEstudiantePorDocumento($documento,$tipo_grupo){
        @$id_estudiante = $this->consultarIDEstudiantePorDocumento($documento)[0]['id'];
        return $this->consultarGruposActivosEstudiante($id_estudiante,$tipo_grupo);
    }

    public function consultarGruposActivosEstudiante($id_estudiante,$tipo_grupo){
        $sql = "SELECT GE.FK_grupo
        FROM tb_terr_grupo_".$tipo_grupo."_estudiante GE
        WHERE GE.FK_estudiante = :FK_estudiante 
        AND GE.estado = 1";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':FK_estudiante',$id_estudiante);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarAdjuntosPorDocumento($documento){
        $sql = "SELECT count(*) as 'archivos' FROM tb_estudiante_archivo WHERE FK_Id_Estudiante = :documento  AND ANIO = YEAR(current_date())";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':documento',$documento);   
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);         
    }

    public function agregarArchivoBeneficiario($datos)
    {
        $sql = "INSERT INTO tb_estudiante_archivo(FK_Id_Estudiante,VC_Nombre_Archivo,VC_Url,DA_Fecha_Subida,FK_Usuario_Creacion,Anio) VALUES (:FK_Id_Estudiante,:VC_Nombre_Archivo,:VC_Url,:DA_Fecha_Subida,:FK_Usuario_Creacion,:Anio);";
        $sentencia=$this->db->prepare($sql);
        $sentencia->bindParam(':FK_Id_Estudiante',$datos['FK_Id_Estudiante']);
        $sentencia->bindParam(':VC_Nombre_Archivo',$datos['VC_Nombre_Archivo']);
        $sentencia->bindParam(':VC_Url',$datos['VC_Url']);
        $sentencia->bindParam(':DA_Fecha_Subida',$datos['DA_Fecha_Subida']);
        $sentencia->bindParam(':FK_Usuario_Creacion',$datos['FK_Usuario_Creacion']);
        $sentencia->bindParam(':Anio',$datos['Anio']);
        $sentencia->execute(); 
        return $sentencia->rowCount();
    }

    public function eliminarArchivoEstudiante($idArchivo)
    {
        $sql = "DELETE FROM tb_estudiante_archivo WHERE PK_estudiante_archivo = :idArchivo;";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':idArchivo',$idArchivo);
        $sentencia->execute(); 
        return $sentencia->rowCount();  
    }

    public function eliminarArchivoPorNombreBeneficiario($nombre_archivo,$id_beneficiario){
        $nombre_archivo = $nombre_archivo.'%';
        //echo $nombre_archivo;
        $sql = "DELETE FROM tb_estudiante_archivo WHERE Anio=YEAR(NOW()) AND FK_Id_Estudiante = :id_beneficiario AND VC_Nombre_Archivo LIKE :nombre_archivo;";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':id_beneficiario',$id_beneficiario);
        $sentencia->bindParam(':nombre_archivo',$nombre_archivo);
        $sentencia->execute(); 
        return $sentencia->rowCount();  
    }

    public function consultarDatosEstudiantesGrupo($id_grupo,$tipo_grupo,$id_area){
        $anio_actual = date("Y");
        $sql = "SELECT
                DA.*,
                E.*,
                G.DT_fecha_ingreso as fecha_ingreso,
                AE.VC_Nom_Area ,
                PDTI.VC_Descripcion AS tipo_identificacion_descripcion,
                PDJ.VC_Descripcion AS jornada_descripcion,
                PDGP.VC_Descripcion AS grupo_poblacional_descripcion,
                PDEPS.VC_Descripcion as eps_descripcion,
                PDPV.VC_Descripcion AS poblacion_victima_descripcion,
                PDLOC.VC_Descripcion AS localidad_descripcion,
                PDGR.VC_Descripcion AS grado_descripcion,
                PDDISC.VC_Descripcion AS tipo_discapacidad_descripcion,
                PDET.VC_Descripcion AS etnia_descripcion, ";
        if ($tipo_grupo == "arte_escuela"){
            $sql .= "COL.VC_Nom_Colegio, ";
        }
        $sql .= "CLAN.VC_Nom_Clan,
                G.FK_Grupo,G.estado 
                FROM tb_estudiante E 
                JOIN tb_terr_grupo_".$tipo_grupo."_estudiante G ON G.FK_estudiante = E.id 
                JOIN tb_terr_grupo_".$tipo_grupo." GR ON GR.PK_Grupo = G.FK_grupo AND YEAR(GR.DT_fecha_creacion) IN (2020, :anio_actual)
                JOIN tb_areas_artisticas AE ON AE.PK_Area_Artistica = GR.FK_area_artistica
                LEFT JOIN tb_estudiante_simat M ON E.IN_Identificacion=M.NRO_DOCUMENTO
                LEFT JOIN tb_estudiante_detalle_anio DA ON E.id = DA.FK_estudiante AND DA.anio = :anio_actual  
                LEFT JOIN tb_parametro_detalle PDPV ON M.POB_VICT_CONF = PDPV.FK_Value AND PDPV.Fk_Id_Parametro = 9 
                LEFT JOIN tb_parametro_detalle PDGR ON DA.FK_grado = PDGR.FK_Value AND PDGR.Fk_Id_Parametro = 12 
                LEFT JOIN tb_parametro_detalle PDTI ON E.CH_Tipo_Identificacion = PDTI.FK_Value AND PDTI.Fk_Id_Parametro = 13 
                LEFT JOIN tb_parametro_detalle PDJ ON DA.jornada = PDJ.FK_Value AND PDJ.Fk_Id_Parametro = 11 
                LEFT JOIN tb_parametro_detalle PDGP ON DA.FK_Grupo_Poblacional = PDGP.FK_Value AND PDGP.Fk_Id_Parametro = 14 
                LEFT JOIN tb_parametro_detalle PDEPS ON DA.FK_Eps = PDEPS.FK_Value AND PDEPS.Fk_Id_Parametro = 16 
                LEFT JOIN tb_clan CLAN ON CLAN.PK_Id_Clan = GR.FK_clan
                LEFT JOIN tb_parametro_detalle PDLOC ON  CLAN.FK_Id_Localidad =  PDLOC.FK_Value AND PDLOC.Fk_Id_Parametro = 19 
                LEFT JOIN tb_parametro_detalle PDDISC ON M.TIPO_DISCAPACIDAD = PDDISC.FK_Value AND PDDISC.Fk_Id_Parametro = 10 
                LEFT JOIN tb_parametro_detalle PDET ON M.ETNIA = PDET.FK_Value AND PDET.Fk_Id_Parametro = 33 ";
        if ($tipo_grupo == "arte_escuela"){
            $sql .= "LEFT JOIN tb_colegios COL ON COL.PK_Id_Colegio = GR.FK_colegio ";
        }
        $sql .= "WHERE G.FK_Grupo IN(".$id_grupo.") AND GR.FK_area_artistica IN(".$id_area.");";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':anio_actual',$anio_actual);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarEstudianteDetalleAnio($id_estudiante,$anio){
        $sql = "SELECT C.VC_Nom_Clan,COL.VC_Nom_Colegio,GR.VC_Descripcion AS 'GRADO',J.VC_Descripcion AS 'JORNADA',
                GP.VC_Descripcion AS 'GRUPO_POBLACIONAL',EPS.VC_Descripcion AS 'EPS', L.VC_Descripcion AS 'LOCALIDAD',PV.VC_Descripcion AS 'POBLACION_VICTIMA',D.VC_Descripcion AS 'TIPO_DISCAPACIDAD',
                E.VC_Descripcion AS 'ETNIA',AA.VC_Nom_Area,EDA.* 
            FROM tb_estudiante_detalle_anio EDA
                LEFT JOIN tb_clan C ON EDA.FK_clan = C.PK_Id_Clan
                LEFT JOIN tb_colegios COL ON EDA.FK_colegio = COL.PK_Id_Colegio
                LEFT JOIN tb_parametro_detalle GR ON EDA.FK_grado = GR.FK_Value AND GR.FK_Id_Parametro = 18
                LEFT JOIN tb_parametro_detalle J ON EDA.jornada = J.FK_Value AND J.FK_Id_Parametro = 11
                LEFT JOIN tb_parametro_detalle GP ON EDA.FK_Grupo_Poblacional = GP.FK_Value AND GP.FK_Id_Parametro = 14
                LEFT JOIN tb_parametro_detalle EPS ON EDA.FK_Eps = EPS.FK_Value AND EPS.FK_Id_Parametro = 16
                LEFT JOIN tb_parametro_detalle L ON EDA.FK_Localidad = L.FK_Value AND L.FK_Id_Parametro = 19
                LEFT JOIN tb_parametro_detalle PV ON EDA.FK_tipo_poblacion_victima = PV.FK_Value AND PV.FK_Id_Parametro = 9
                LEFT JOIN tb_parametro_detalle D ON EDA.FK_tipo_discapacidad = D.FK_Value AND D.FK_Id_Parametro = 10
                LEFT JOIN tb_parametro_detalle E ON EDA.TX_etnia = E.FK_Value AND E.FK_Id_Parametro = 33
                LEFT JOIN tb_areas_artisticas AA ON EDA.FK_area_artistica_interes = AA.PK_Area_Artistica 
            WHERE FK_estudiante=:FK_estudiante AND anio=:anio";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':FK_estudiante',$id_estudiante);
        $sentencia->bindParam(':anio',$anio);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function crearRegistroDetalleAnio($detalle_anio){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$detalle_anio->getFkUsuarioCreacion().";");
        $sql = "INSERT INTO tb_estudiante_detalle_anio (FK_estudiante,anio,FK_clan,FK_colegio,FK_grado,jornada,NOMBRE_ACUDIENTE,IDENTIFICACION_ACUDIENTE,TELEFONO_ACUDIENTE,FK_Grupo_Poblacional,FK_Eps,TX_Tipo_Afiliacion,TX_Enfermedades,sisben,TX_observaciones,FK_Localidad,TX_Barrio,FK_tipo_poblacion_victima,FK_tipo_discapacidad,TX_etnia,DA_fecha_creacion,FK_usuario_creacion,IN_estrato,FK_area_artistica_interes,IN_tiene_experiencia,IN_experiencia_empirica,IN_experiencia_academica,IN_anios_experiencia) VALUES (:FK_estudiante,:anio,:FK_clan,:FK_colegio,:FK_grado,:jornada,:NOMBRE_ACUDIENTE,:IDENTIFICACION_ACUDIENTE,:TELEFONO_ACUDIENTE,:FK_Grupo_Poblacional,:FK_Eps,:TX_Tipo_Afiliacion,:TX_Enfermedades,:sisben,:TX_observaciones,:FK_Localidad,:TX_Barrio,:FK_tipo_poblacion_victima,:FK_tipo_discapacidad,:TX_etnia,NOW(),:FK_usuario_creacion,:IN_estrato,:FK_area_artistica_interes,:IN_tiene_experiencia,:IN_experiencia_empirica,:IN_experiencia_academica,:IN_anios_experiencia);";
        $create_detalle_anio = $this->db->prepare($sql);
        @$create_detalle_anio->bindParam(':FK_estudiante',$detalle_anio->getFkEstudiante());
        @$create_detalle_anio->bindParam(':anio',$detalle_anio->getAnio());
        @$create_detalle_anio->bindParam(':FK_clan',$detalle_anio->getFkClan());
        @$create_detalle_anio->bindParam(':FK_colegio',$detalle_anio->getFkColegio());
        @$create_detalle_anio->bindParam(':FK_grado',$detalle_anio->getFkGrado());
        @$create_detalle_anio->bindParam(':jornada',$detalle_anio->getFkJornada());
        @$create_detalle_anio->bindParam(':NOMBRE_ACUDIENTE',$detalle_anio->getNombreAcudiente());
        @$create_detalle_anio->bindParam(':IDENTIFICACION_ACUDIENTE',$detalle_anio->getIdentificacionAcudiente());
        @$create_detalle_anio->bindParam(':TELEFONO_ACUDIENTE',$detalle_anio->getTelefonoAcudiente());
        @$create_detalle_anio->bindParam(':FK_Grupo_Poblacional',$detalle_anio->getFkGrupoPoblacional());
        @$create_detalle_anio->bindParam(':FK_Eps',$detalle_anio->getFkEps());
        @$create_detalle_anio->bindParam(':TX_Tipo_Afiliacion',$detalle_anio->getTxTipoAfiliacion());
        @$create_detalle_anio->bindParam(':TX_Enfermedades',$detalle_anio->getTxEnfermedades());
        @$create_detalle_anio->bindParam(':TX_observaciones',$detalle_anio->getTxObservaciones());
        @$create_detalle_anio->bindParam(':FK_Localidad',$detalle_anio->getFkLocalidad());
        @$create_detalle_anio->bindParam(':TX_Barrio',$detalle_anio->getTxBarrio());
        @$create_detalle_anio->bindParam(':FK_tipo_poblacion_victima',$detalle_anio->getFkTipoPoblacionVictima());
        @$create_detalle_anio->bindParam(':FK_tipo_discapacidad',$detalle_anio->getFkTipoDiscapacidad());
        @$create_detalle_anio->bindParam(':TX_etnia',$detalle_anio->getFkEtnia());
        @$create_detalle_anio->bindParam(':IN_estrato',$detalle_anio->getInEstrato());
        @$create_detalle_anio->bindParam(':FK_usuario_creacion',$detalle_anio->getFkUsuarioCreacion());
        @$create_detalle_anio->bindParam(':sisben',$detalle_anio->getPuntajeSisben());

        @$create_detalle_anio->bindParam(':FK_area_artistica_interes',$detalle_anio->getFkAreaArtisticaInteres());
        @$create_detalle_anio->bindParam(':IN_tiene_experiencia',$detalle_anio->getInExperiencia());
        @$create_detalle_anio->bindParam(':IN_experiencia_empirica',$detalle_anio->getInExperienciaEmpirica());
        @$create_detalle_anio->bindParam(':IN_experiencia_academica',$detalle_anio->getInExperienciaAcademica());
        $anios_exp = $detalle_anio->getInExperienciaAnios() == '' ? NULL: $detalle_anio->getInExperienciaAnios();
        @$create_detalle_anio->bindParam(':IN_anios_experiencia',$anios_exp);
        try{
        $this->db->beginTransaction();
        $set_id_usuario->execute();
        $resultado = $create_detalle_anio->execute();
        $this->db->commit();
        return 1;
        }catch(PDOExecption $e) {
        $this->db->rollback();
        return "Error!: " . $e->getMessage() . "</br>";
        }
        return;
    }

    public function consultarAnioDetalleEstudiante($id_estudiante){
        $sql = "SELECT anio FROM tb_estudiante_detalle_anio WHERE FK_estudiante=:FK_estudiante";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':FK_estudiante',$id_estudiante);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarAnioEstudianteArchivo($id_estudiante){
        $sql = "SELECT DISTINCT anio FROM tb_estudiante_archivo WHERE FK_Id_Estudiante=:FK_estudiante ORDER BY anio DESC";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':FK_estudiante',$id_estudiante);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarEstudianteArchivo($id_estudiante,$anio){
        $sql = "SELECT * FROM tb_estudiante_archivo WHERE FK_Id_Estudiante=:FK_estudiante AND Anio=:anio;";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':FK_estudiante',$id_estudiante);
        $sentencia->bindParam(':anio',$anio);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarDatosBasicosEstudiante($id_estudiante){
        $sql = "SELECT  E.id,E.IN_Identificacion,E.VC_Primer_Nombre,E.VC_Segundo_Nombre,E.VC_Primer_Apellido,E.VC_Segundo_Apellido, E.DD_F_Nacimiento,E.CH_Genero,E.VC_Direccion,E.VC_Correo,E.VC_Telefono,E.VC_Celular,E.VC_Tipo_Estudiante,E.DA_Fecha_Registro , PD.VC_Descripcion AS tipo_identificacion 
        FROM tb_estudiante E  
        LEFT JOIN tb_parametro_detalle PD ON E.CH_Tipo_Identificacion = PD.FK_Value AND PD.FK_ID_Parametro = 13 
        WHERE E.id=:id;";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':id',$id_estudiante);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarGruposBeneficiarioAnio($datos){
        $sql = "SELECT G.PK_Grupo,G.FK_clan,EG.DT_fecha_ingreso,EG.DT_fecha_retiro,
                CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS Artista_Formador,
                CONCAT(UI.VC_Primer_Nombre,' ',UI.VC_Segundo_Nombre,' ',UI.VC_Primer_Apellido,' ',UI.VC_Segundo_Apellido) AS Usuario_Ingreso,
                CONCAT(UR.VC_Primer_Nombre,' ',UR.VC_Segundo_Nombre,' ',UR.VC_Primer_Apellido,' ',UR.VC_Segundo_Apellido) AS Usuario_Retiro 
            FROM tb_terr_grupo_".$datos['tipo_grupo']."_estudiante EG 
                LEFT JOIN tb_terr_grupo_".$datos['tipo_grupo']." G ON EG.FK_grupo = G.PK_Grupo 
                LEFT JOIN tb_persona_2017 AF ON G.FK_artista_formador = AF.PK_Id_Persona
                LEFT JOIN tb_persona_2017 UI ON EG.FK_usuario_ingreso = UI.PK_Id_Persona
                LEFT JOIN tb_persona_2017 UR ON EG.FK_usuario_retiro = UR.PK_Id_Persona
            WHERE EG.FK_estudiante=:id_estudiante AND YEAR(EG.DT_fecha_ingreso) = :anio;";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':id_estudiante',$datos['id_estudiante']);
        $sentencia->bindParam(':anio',$datos['anio']);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarBeneficiarioNidosPorDocumento($numero_documento){
        $sql = "SELECT *,'tb_nidos_beneficiarios' AS ORIGEN FROM tb_nidos_beneficiarios WHERE VC_Identificacion=:numero_documento;";
        $sentencia=$this->db->prepare($sql); 
        $sentencia->bindParam(':numero_documento',$numero_documento);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function consultarBeneficiarioNidosPorNombres($datos){

        $where="";
        $identificacion="";
        $apellido1="";
        $apellido2="";
        $nombre1="";
        $nombre2="";
        $sql = "SELECT E.*,'tb_nidos_beneficiarios' AS ORIGEN FROM tb_nidos_beneficiarios E WHERE ";

        if($datos['vc_primer_apellido']!=null && $datos['vc_primer_apellido']!=''){
            if($where!="")
                $where.=" AND E.VC_Primer_Apellido LIKE :vcPrimerApellido";
            else
                $where.="E.VC_Primer_Apellido LIKE :vcPrimerApellido";
            $apellido1="%".trim($datos['vc_primer_apellido'])."%"; 
        }
        if($datos['vc_segundo_apellido']!=null && $datos['vc_segundo_apellido']!=''){
            if($where!="")
                $where.=" AND E.VC_Segundo_Apellido LIKE :vcSegundoApellido";   
            else
                $where.="E.VC_Segundo_Apellido LIKE :vcSegundoApellido"; 
            $apellido2="%".trim($datos['vc_segundo_apellido'])."%";
        } 
        if($datos['vc_primer_nombre']!=null && $datos['vc_primer_nombre']!=''){
            if($where!="")
                $where.=" AND E.VC_Primer_Nombre LIKE :vcPrimerNombre";
            else
                $where.="E.VC_Primer_Nombre LIKE :vcPrimerNombre";
            $nombre1="%".trim($datos['vc_primer_nombre'])."%";
        }
        if($datos['vc_segundo_nombre']!=null && $datos['vc_segundo_nombre']!=''){
            if($where!="")
                $where.=" AND E.VC_Segundo_Nombre LIKE :vcSegundoNombre"; 
            else
                $where.="E.VC_Segundo_Nombre LIKE :vcSegundoNombre"; 
            $nombre2="%".trim($datos['vc_segundo_nombre'])."%"; 
        }
        //var_dump($objeto);
        $sql.=$where;   
        //echo $sql;   

        $sentencia=$this->db->prepare($sql);
        if($datos['vc_primer_apellido']!=null && $datos['vc_primer_apellido']!='')          
            @$sentencia->bindParam(':vcPrimerApellido',$apellido1);   
        if($datos['vc_segundo_apellido']!=null && $datos['vc_segundo_apellido']!='')
            @$sentencia->bindParam(':vcSegundoApellido',$apellido2); 
        if($datos['vc_primer_nombre']!=null && $datos['vc_primer_nombre']!='')
            @$sentencia->bindParam(':vcPrimerNombre',$nombre1); 
        if($datos['vc_segundo_nombre']!=null && $datos['vc_segundo_nombre']!='')                     
            @$sentencia->bindParam(':vcSegundoNombre',$nombre2);  


        // $nombre_beneficiario_nidos = '%'.$nombre.'%';
        // $sql = "SELECT *,'tb_nidos_beneficiarios' AS ORIGEN FROM tb_nidos_beneficiarios WHERE CONCAT(VC_Primer_Apellido,VC_Segundo_Apellido,VC_Primer_Nombre,VC_Segundo_Nombre)LIKE :nombre_beneficiario_nidos;";
        // $sentencia=$this->db->prepare($sql); 
        // $sentencia->bindParam(':nombre_beneficiario_nidos',$nombre_beneficiario_nidos);
        $sentencia->execute(); 
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function actualizarFechaNacimiento($datos){
        $set_id_usuario = $this->db->prepare("SET @user_id = ".$datos['id_usuario'].";");
        $sql_update = "UPDATE tb_estudiante SET DD_F_Nacimiento=:fecha_nacimiento WHERE id=:id_estudiante;";
        $update = $this->db->prepare($sql_update);
        @$update->bindParam(':fecha_nacimiento',$datos['fecha_nacimiento']);
        @$update->bindParam(':id_estudiante',$datos['id_estudiante']);
        try{
            $this->db->beginTransaction();
            $set_id_usuario->execute();
            $resultado_update = $update->execute();
            $this->db->commit();
            return 1;
        }catch(PDOExecption $e) {
            $this->db->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }
}
