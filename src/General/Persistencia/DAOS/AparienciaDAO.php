<?php

namespace General\Persistencia\DAOS;


class AparienciaDAO extends GestionDAO {

    private $db;
    function __construct()
    {
        $this->db=$this->obtenerPDOBD();
    }

    public function crearObjeto($objeto) {return;}
    public function modificarObjeto($objeto) {return;}
    public function eliminarObjeto($objeto) {return;}
    public function consultarObjeto($objeto){

        $sql="SELECT A.* FROM tb_apariencia AS A
        JOIN tb_parametro AS P ON P.PK_Id_Parametro=A.FK_Id_Parametro
        JOIN tb_parametro_detalle AS PD ON PD.FK_Id_Parametro=P.PK_Id_Parametro
        WHERE PD.FK_Value=:rol  LIMIT 1";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':rol',$objeto->getFkIdParametro());
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
    }

    public function getModulosRol($objeto)
    {
        $sql="SELECT DISTINCT(tmm.PK_Id_Modulo) AS id_modulo, tmm.VC_Nom_Modulo, tmm.VC_Icono, tmm.VC_Imagen
        FROM tb_menu_modulo tmm
        LEFT JOIN tb_menu_actividad tma ON tma.FK_Modulo = tmm.PK_Id_Modulo
        LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
        LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
        JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tmau.FK_Persona = tp2.PK_Id_Persona) AND tp2.PK_Id_Persona = :id_usuario";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$objeto->getFkIdParametro());
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getActividadesModuloUsuario($objeto)
    {
        $sql="SELECT tma.*
        FROM tb_menu_actividad tma
        LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
        LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
        JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tp2.PK_Id_Persona = tmau.FK_Persona) AND tp2.PK_Id_Persona = :id_usuario
        WHERE tma.FK_Modulo = :id_modulo AND (tma.estado = 1 OR tma.estado = 2)
        GROUP BY tma.PK_Id_Actividad";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$objeto->getFkIdParametro());
        @$sentencia->bindParam(':id_modulo',$objeto->getId());
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMenu($objeto)
    { 
        $sql="SELECT tmm.VC_Nom_Modulo as 'modulo', tmm.VC_Icono,tmm.VC_Imagen,tma.*
        FROM tb_menu_actividad tma
        LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
        LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
        JOIN tb_menu_modulo tmm ON tma.FK_Modulo = tmm.PK_Id_Modulo
        JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tp2.PK_Id_Persona = tmau.FK_Persona) AND tp2.PK_Id_Persona = :id_usuario
        WHERE (tma.estado=1 OR tma.estado=2) GROUP BY  tma.FK_Modulo, tma.VC_Nom_Actividad";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$objeto->getFkIdParametro());
        $sentencia->execute();
        $datos=$sentencia->fetchAll(\PDO::FETCH_ASSOC);
        $modulo=null;
        $opciones= array();
        $nombreModulo="";
        foreach ($datos as $menu) {
            if($nombreModulo!=$menu['modulo']){                  
                if(sizeof($opciones)>0) 
                    $modulo[$nombreModulo]['opciones']=$opciones;  
                $opciones= array();
                $nombreModulo=$menu['modulo'];
            } 
            if(!isset($modulo[$menu['modulo']])){
                $modulo[$menu['modulo']] = array('nombre' =>$menu['modulo'] , 'icono'=>$menu['VC_Icono'],'imagen'=>$menu['VC_Imagen'] );
                $nombreModulo=$menu['modulo'];
            }
            $opciones[]=array('nombre' => $menu['VC_Nom_Actividad'],'url'=>$menu['VC_Page'],'estado'=>$menu['estado'] ); 

        }
        if(sizeof($opciones)>0) 
            $modulo[$nombreModulo]['opciones']=$opciones;  
        return $modulo;

    }

    public function getDatosPorNombre($username)
    {
        $sql="SELECT P.VC_Correo AS 'email', AU.FK_Id_Persona as 'id', AU.VC_Token as 'token' FROM
        tb_acceso_usuario_2017 AS AU 
        JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=AU.FK_Id_Persona
        WHERE AU.VC_Usuario=:username";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':username',$username);
        $sentencia->execute();  
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);      
    }    

    public function guardarToken($id,$token)
    {
        $sql="UPDATE tb_acceso_usuario_2017 SET VC_Token = :token WHERE FK_Id_Persona = :id";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':token',$token);
        @$sentencia->bindParam(':id',$id);
        $sentencia->execute();  
        return $sentencia->rowCount(); 
    }

    public function cambiarPassword($password,$id)
    {
        $pass = sha1(md5($password)); 

        $sql="UPDATE tb_acceso_usuario_2017 SET VC_Password=:pass WHERE FK_Id_Persona = :id";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':pass',$pass); 
        @$sentencia->bindParam(':id',$id);
        $sentencia->execute();  
        return $sentencia->rowCount();         
    }

    public function getEstadisticas($anio)
    {
        $sql="SELECT * FROM tb_estadistica_anio WHERE PK_Anio = :anio";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':anio',$anio);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);        
    } 
    public function getEstadisticasCREAAreasArtisticas($anio,$crea)
    {
        $sql="SELECT T.* FROM 
        (SELECT 
        SC.FK_grupo,
        SC.FK_clan,
        YEAR(SC.DA_fecha_clase) AS 'AÑO',
        'AE' AS 'LINEA',
        PD.VC_Descripcion AS 'TIPO',
        COUNT(SC.PK_sesion_clase) AS 'TALLERES'
        FROM tb_terr_grupo_arte_escuela_sesion_clase SC
        JOIN tb_terr_grupo_arte_escuela GAE ON SC.FK_grupo=GAE.PK_Grupo
        LEFT JOIN tb_parametro_detalle PD ON SC.FK_area_artistica=PD.FK_Value AND PD.FK_Id_Parametro=6
        WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_clan=:crea
        GROUP BY PD.FK_Value) T WHERE T.TALLERES >3
        UNION
        SELECT 
        SC.FK_grupo,
        SC.FK_clan,
        YEAR(SC.DA_fecha_clase) AS 'AÑO',
        'EC' AS 'LINEA',
        PD.VC_Descripcion AS 'TIPO',
        COUNT(SC.PK_sesion_clase) AS 'TALLERES'
        FROM tb_terr_grupo_emprende_clan_sesion_clase SC
        JOIN tb_terr_grupo_emprende_clan GEC ON SC.FK_grupo=GEC.PK_Grupo
        LEFT JOIN tb_parametro_detalle PD ON SC.FK_area_artistica=PD.FK_Value AND PD.FK_Id_Parametro=6
        WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_clan=:crea
        GROUP BY PD.FK_Value
        UNION
        SELECT 
        SC.FK_grupo,
        SC.FK_clan,
        YEAR(SC.DA_fecha_clase) AS 'AÑO',
        'LC' AS 'LINEA',
        PD.VC_Descripcion AS 'TIPO',
        COUNT(SC.PK_sesion_clase) AS 'TALLERES'
        FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC
        JOIN tb_terr_grupo_laboratorio_clan GLC ON SC.FK_grupo=GLC.PK_Grupo
        LEFT JOIN tb_parametro_detalle PD ON SC.FK_area_artistica=PD.FK_Value AND PD.FK_Id_Parametro=6
        WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_clan=:crea
        GROUP BY PD.FK_Value";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':anio',$anio);
        @$sentencia->bindParam(':crea',$crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
    }
    public function getEstadisticasEmprendeCreaTipoGrupo($anio,$crea)
    {
        $sql="SELECT 
        SC.FK_clan,
        YEAR(SC.DA_fecha_clase) AS 'AÑO',
        SC.tipo_grupo AS 'TIPO',
        COUNT(SC.PK_sesion_clase) AS 'TALLERES'
        FROM tb_terr_grupo_emprende_clan_sesion_clase SC
        WHERE YEAR(SC.DA_fecha_clase)=:anio AND SC.FK_clan=:crea GROUP BY SC.tipo_grupo";
        @$sentencia=$this->db->prepare($sql);
        @$sentencia->bindParam(':anio',$anio);
        @$sentencia->bindParam(':crea',$crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
    } 
    public function getEstadisticasMesActual($anio)
    {
        $sql="
        SELECT   
        MES,
        VALORMES,
        SUM(estudiantes_ae) AS 'ATENCION_MES_AE',
        SUM(estudiantes_ae_idartes) AS 'ATENCION_MES_AE_IDARTES',
        SUM(estudiantes_ae_sed) AS 'ATENCION_MES_AE_SED',
        SUM(estudiantes_ec) AS 'ATENCION_MES_EC',
        SUM(estudiantes_lc) AS 'ATENCION_MES_LC',
        SUM(estudiantes) AS 'ACUMULADO_LINEAS_MES',
        (SELECT
        COUNT(DISTINCT(SCAGAE.`FK_estudiante`))
        FROM `tb_terr_grupo_arte_escuela_sesion_clase_asistencia` SCAGAE
        JOIN `tb_terr_grupo_arte_escuela_sesion_clase` SCGAE ON SCAGAE.`FK_sesion_clase`=SCGAE.`PK_sesion_clase`
        WHERE MONTH(SCGAE.`DA_fecha_clase`)<=VALORMES AND SCAGAE.`IN_estado_asistencia`=1 AND MONTH(SCGAE.`DA_fecha_clase`)>0 AND YEAR(SCGAE.`DA_fecha_clase`)=:anio
        ) AS 'ACUMULADO_AE',
        (SELECT
        COUNT(DISTINCT(SCAGAE.`FK_estudiante`))
        FROM `tb_terr_grupo_arte_escuela_sesion_clase_asistencia` SCAGAE
        JOIN `tb_terr_grupo_arte_escuela_sesion_clase` SCGAE ON SCAGAE.`FK_sesion_clase`=SCGAE.`PK_sesion_clase`
        WHERE MONTH(SCGAE.`DA_fecha_clase`)<=VALORMES AND SCAGAE.`IN_estado_asistencia`=1 AND MONTH(SCGAE.`DA_fecha_clase`)>0 AND YEAR(SCGAE.`DA_fecha_clase`)=:anio AND SCGAE.tipo_grupo NOT LIKE '%SED%'
        ) AS 'ACUMULADO_IDARTES',
        (SELECT
        COUNT(DISTINCT(SCAGAE.`FK_estudiante`))
        FROM `tb_terr_grupo_arte_escuela_sesion_clase_asistencia` SCAGAE
        JOIN `tb_terr_grupo_arte_escuela_sesion_clase` SCGAE ON SCAGAE.`FK_sesion_clase`=SCGAE.`PK_sesion_clase`
        WHERE MONTH(SCGAE.`DA_fecha_clase`)<=VALORMES AND SCAGAE.`IN_estado_asistencia`=1 AND MONTH(SCGAE.`DA_fecha_clase`)>0 AND YEAR(SCGAE.`DA_fecha_clase`)=:anio AND SCGAE.tipo_grupo LIKE '%SED%'
        ) AS 'ACUMULADO_SED',
        (SELECT
        COUNT(DISTINCT(SCAGEC.`FK_estudiante`))
        FROM `tb_terr_grupo_emprende_clan_sesion_clase_asistencia` SCAGEC
        JOIN `tb_terr_grupo_emprende_clan_sesion_clase` SCGEC ON SCAGEC.`FK_sesion_clase`=SCGEC.`PK_sesion_clase`
        WHERE MONTH(SCGEC.`DA_fecha_clase`)<=VALORMES AND SCAGEC.`IN_estado_asistencia`=1 AND MONTH(SCGEC.`DA_fecha_clase`)>0 AND YEAR(SCGEC.`DA_fecha_clase`)=:anio
        )  AS 'ACUMULADO_EC',
        (SELECT
        COUNT(DISTINCT(SCAGLC.`FK_estudiante`))
        FROM `tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia` SCAGLC
        JOIN `tb_terr_grupo_laboratorio_clan_sesion_clase` SCGLC ON SCAGLC.`FK_sesion_clase`=SCGLC.`PK_sesion_clase`
        WHERE MONTH(SCGLC.`DA_fecha_clase`)<=VALORMES AND SCAGLC.`IN_estado_asistencia`=1 AND MONTH(SCGLC.`DA_fecha_clase`)>0 AND YEAR(SCGLC.`DA_fecha_clase`)=:anio
        ) AS 'ACUMULADO_LC',
        (SELECT
        COUNT(DISTINCT(SCAGAE.`FK_estudiante`))
        FROM `tb_terr_grupo_arte_escuela_sesion_clase_asistencia` SCAGAE
        JOIN `tb_terr_grupo_arte_escuela_sesion_clase` SCGAE ON SCAGAE.`FK_sesion_clase`=SCGAE.`PK_sesion_clase`
        WHERE MONTH(SCGAE.`DA_fecha_clase`)<=VALORMES AND SCAGAE.`IN_estado_asistencia`=1 AND MONTH(SCGAE.`DA_fecha_clase`)>0 AND YEAR(SCGAE.`DA_fecha_clase`)=:anio
        )+
        (SELECT
        COUNT(DISTINCT(SCAGEC.`FK_estudiante`))
        FROM `tb_terr_grupo_emprende_clan_sesion_clase_asistencia` SCAGEC
        JOIN `tb_terr_grupo_emprende_clan_sesion_clase` SCGEC ON SCAGEC.`FK_sesion_clase`=SCGEC.`PK_sesion_clase`
        WHERE MONTH(SCGEC.`DA_fecha_clase`)<=VALORMES AND SCAGEC.`IN_estado_asistencia`=1 AND MONTH(SCGEC.`DA_fecha_clase`)>0 AND YEAR(SCGEC.`DA_fecha_clase`)=:anio
        ) +
        (SELECT
        COUNT(DISTINCT(SCAGLC.`FK_estudiante`))
        FROM `tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia` SCAGLC
        JOIN `tb_terr_grupo_laboratorio_clan_sesion_clase` SCGLC ON SCAGLC.`FK_sesion_clase`=SCGLC.`PK_sesion_clase`
        WHERE MONTH(SCGLC.`DA_fecha_clase`)<=VALORMES AND SCAGLC.`IN_estado_asistencia`=1 AND MONTH(SCGLC.`DA_fecha_clase`)>0 AND YEAR(SCGLC.`DA_fecha_clase`)=:anio
        )
        AS 'CONSOLIDADO',
        CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)),6,0)),-6)) AS 'color'
        FROM
        (
        SELECT 
        CASE MONTH(GAESC.`DA_fecha_clase`)
        WHEN '01' THEN 'ENERO'
        WHEN '02' THEN 'FEBRERO'
        WHEN '03' THEN 'MARZO'
        WHEN '04' THEN 'ABRIL'
        WHEN '05' THEN 'MAYO'
        WHEN '06' THEN 'JUNIO'
        WHEN '07' THEN 'JULIO'
        WHEN '08' THEN 'AGOSTO'
        WHEN '09' THEN 'SEPTIEMBRE'
        WHEN '10' THEN 'OCTUBRE'
        WHEN '11' THEN 'NOVIEMBRE'
        WHEN '12' THEN 'DICIEMBRE'
        END AS 'MES',
        MONTH(GAESC.`DA_fecha_clase`) AS 'VALORMES',
        COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes',
        COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes_ae',
        0 AS 'estudiantes_ae_idartes',
        0 AS 'estudiantes_ae_sed',
        0 AS 'estudiantes_ec',
        0 AS 'estudiantes_lc',
        'AE'
        FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE 
        JOIN tb_terr_grupo_arte_escuela_sesion_clase GAESC ON GAESC.`PK_sesion_clase`=SCAAE.`FK_sesion_clase`
        WHERE SCAAE.`IN_estado_asistencia`=1 AND MONTH(GAESC.`DA_fecha_clase`)>0 AND YEAR(GAESC.`DA_fecha_clase`)=:anio GROUP BY MONTH(GAESC.`DA_fecha_clase`)
        UNION   
        SELECT 
        CASE MONTH(GAESC.`DA_fecha_clase`)
        WHEN '01' THEN 'ENERO'
        WHEN '02' THEN 'FEBRERO'
        WHEN '03' THEN 'MARZO'
        WHEN '04' THEN 'ABRIL'
        WHEN '05' THEN 'MAYO'
        WHEN '06' THEN 'JUNIO'
        WHEN '07' THEN 'JULIO'
        WHEN '08' THEN 'AGOSTO'
        WHEN '09' THEN 'SEPTIEMBRE'
        WHEN '10' THEN 'OCTUBRE'
        WHEN '11' THEN 'NOVIEMBRE'
        WHEN '12' THEN 'DICIEMBRE'
        END AS 'MES',
        MONTH(GAESC.`DA_fecha_clase`) AS 'VALORMES',
        0 AS 'estudiantes',
        0 AS 'estudiantes_ae',
        COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes_ae_idartes',
        0 AS 'estudiantes_ae_sed',
        0 AS 'estudiantes_ec',
        0 AS 'estudiantes_lc',
        'AE'
        FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE 
        JOIN tb_terr_grupo_arte_escuela_sesion_clase GAESC ON GAESC.`PK_sesion_clase`=SCAAE.`FK_sesion_clase`
        WHERE SCAAE.`IN_estado_asistencia`=1 AND MONTH(GAESC.`DA_fecha_clase`)>0 AND YEAR(GAESC.`DA_fecha_clase`)=:anio AND GAESC.tipo_grupo NOT LIKE '%SED%' GROUP BY MONTH(GAESC.`DA_fecha_clase`)
        UNION   
        SELECT 
        CASE MONTH(GAESC.`DA_fecha_clase`)
        WHEN '01' THEN 'ENERO'
        WHEN '02' THEN 'FEBRERO'
        WHEN '03' THEN 'MARZO'
        WHEN '04' THEN 'ABRIL'
        WHEN '05' THEN 'MAYO'
        WHEN '06' THEN 'JUNIO'
        WHEN '07' THEN 'JULIO'
        WHEN '08' THEN 'AGOSTO'
        WHEN '09' THEN 'SEPTIEMBRE'
        WHEN '10' THEN 'OCTUBRE'
        WHEN '11' THEN 'NOVIEMBRE'
        WHEN '12' THEN 'DICIEMBRE'
        END AS 'MES',
        MONTH(GAESC.`DA_fecha_clase`) AS 'VALORMES',
        0 AS 'estudiantes',
        0 AS 'estudiantes_ae',
        0 AS 'estudiantes_ae_idartes',
        COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes_ae_sed',
        0 AS 'estudiantes_ec',
        0 AS 'estudiantes_lc',
        'AE'
        FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE 
        JOIN tb_terr_grupo_arte_escuela_sesion_clase GAESC ON GAESC.`PK_sesion_clase`=SCAAE.`FK_sesion_clase`
        WHERE SCAAE.`IN_estado_asistencia`=1 AND MONTH(GAESC.`DA_fecha_clase`)>0 AND YEAR(GAESC.`DA_fecha_clase`)=:anio AND GAESC.tipo_grupo LIKE '%SED%' GROUP BY MONTH(GAESC.`DA_fecha_clase`)
        UNION
        SELECT
        CASE MONTH(GECSC.`DA_fecha_clase`)
        WHEN '01' THEN 'ENERO'
        WHEN '02' THEN 'FEBRERO'
        WHEN '03' THEN 'MARZO'
        WHEN '04' THEN 'ABRIL'
        WHEN '05' THEN 'MAYO'
        WHEN '06' THEN 'JUNIO'
        WHEN '07' THEN 'JULIO'
        WHEN '08' THEN 'AGOSTO'
        WHEN '09' THEN 'SEPTIEMBRE'
        WHEN '10' THEN 'OCTUBRE'
        WHEN '11' THEN 'NOVIEMBRE'
        WHEN '12' THEN 'DICIEMBRE'
        END AS 'MES',
        MONTH(GECSC.`DA_fecha_clase`) AS 'VALORMES',
        COUNT(DISTINCT(SCAEC.`FK_estudiante`)) AS 'estudiantes',
        0 AS 'estudiantes_ae',
        0 AS 'estudiantes_ae_idartes',
        0 AS 'estudiantes_ae_sed',
        COUNT(DISTINCT(SCAEC.`FK_estudiante`)) AS 'estudiantes_ec',
        0 AS 'estudiantes_lc',
        'EC'
        FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAEC 
        JOIN tb_terr_grupo_emprende_clan_sesion_clase GECSC ON GECSC.`PK_sesion_clase`=SCAEC.`FK_sesion_clase`
        WHERE SCAEC.`IN_estado_asistencia`=1 AND MONTH(GECSC.`DA_fecha_clase`)>0 AND YEAR(GECSC.`DA_fecha_clase`)=:anio GROUP BY MONTH(GECSC.`DA_fecha_clase`)
        UNION
        SELECT
        CASE MONTH(GLCSC.`DA_fecha_clase`)
        WHEN '01' THEN 'ENERO'
        WHEN '02' THEN 'FEBRERO'
        WHEN '03' THEN 'MARZO'
        WHEN '04' THEN 'ABRIL'
        WHEN '05' THEN 'MAYO'
        WHEN '06' THEN 'JUNIO'
        WHEN '07' THEN 'JULIO'
        WHEN '08' THEN 'AGOSTO'
        WHEN '09' THEN 'SEPTIEMBRE'
        WHEN '10' THEN 'OCTUBRE'
        WHEN '11' THEN 'NOVIEMBRE'
        WHEN '12' THEN 'DICIEMBRE'
        END AS 'MES',
        MONTH(GLCSC.`DA_fecha_clase`) AS 'VALORMES',
        COUNT(DISTINCT(SCALC.`FK_estudiante`)) AS 'estudiantes',
        0 AS 'estudiantes_ae',
        0 AS 'estudiantes_ae_idartes',
        0 AS 'estudiantes_ae_sed',
        0 AS 'estudiantes_ec',
        COUNT(DISTINCT(SCALC.`FK_estudiante`)) AS 'estudiantes_lc',
        'LC'
        FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCALC 
        JOIN tb_terr_grupo_laboratorio_clan_sesion_clase GLCSC ON GLCSC.`PK_sesion_clase`=SCALC.`FK_sesion_clase`
        WHERE SCALC.`IN_estado_asistencia`=1 AND MONTH(GLCSC.`DA_fecha_clase`)>0 AND YEAR(GLCSC.`DA_fecha_clase`)=:anio GROUP BY MONTH(GLCSC.`DA_fecha_clase`)
    ) AS tunion GROUP BY MES ORDER BY VALORMES;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':anio',$anio);
    $sentencia->execute(); 
    $r = $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    $array[0]['PK_Anio']=$anio;
    $array[0]['TX_Cobertura_Linea']=json_encode($r); 
    $array[0]['TX_Cobertura_Crea']=json_encode($this->getEstadisticasCreaActual($anio)); 
    return $array;    
} 

public function getEstadisticasCreaActual($anio)
{
    $sql="SELECT 
    T.`VC_Nom_Clan` AS 'CREA',
    SUM(T.estudiantes_ae) AS 'ATENCION_AE',
    SUM(T.estudiantes_ec) AS 'ATENCION_EC',
    SUM(T.estudiantes_lc) AS 'ATENCION_LC',
    T.color
    FROM
    (SELECT 
    C.`VC_Nom_Clan`,
    COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes',
    COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes_ae',
    0 AS 'estudiantes_ec',
    0 AS 'estudiantes_lc',
    CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)), 6, 0)),- 6)) AS 'color' 
    FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE 
    JOIN tb_terr_grupo_arte_escuela_sesion_clase GAESC ON GAESC.`PK_sesion_clase` = SCAAE.`FK_sesion_clase` 
    JOIN tb_clan C ON GAESC.`FK_clan` = C.`PK_Id_Clan`
    WHERE SCAAE.`IN_estado_asistencia` = 1 AND YEAR(GAESC.DA_fecha_clase)=:anio GROUP BY GAESC.`FK_clan`  
    UNION
    SELECT 
    C.`VC_Nom_Clan`,
    COUNT(DISTINCT(SCAEC.`FK_estudiante`)) AS 'estudiantes',
    0 AS 'estudiantes_ae',
    COUNT(DISTINCT(SCAEC.`FK_estudiante`)) AS 'estudiantes_ec',
    0 AS 'estudiantes_lc',
    CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)), 6, 0)),- 6)) AS 'color' 
    FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAEC 
    JOIN tb_terr_grupo_emprende_clan_sesion_clase GECSC ON GECSC.`PK_sesion_clase` = SCAEC.`FK_sesion_clase` 
    JOIN tb_clan C ON GECSC.`FK_clan` = C.`PK_Id_Clan`
    WHERE SCAEC.`IN_estado_asistencia` = 1 AND YEAR(GECSC.DA_fecha_clase)=:anio  GROUP BY GECSC.`FK_clan` 
    UNION
    SELECT 
    C.`VC_Nom_Clan`,
    COUNT(DISTINCT(SCALC.`FK_estudiante`)) AS 'estudiantes',
    0 AS 'estudiantes_ae',
    0 AS 'estudiantes_ec',
    COUNT(DISTINCT(SCALC.`FK_estudiante`)) AS 'estudiantes_lc',
    CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)), 6, 0)),- 6)) AS 'color' 
    FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCALC 
    JOIN tb_terr_grupo_laboratorio_clan_sesion_clase GLCSC ON GLCSC.`PK_sesion_clase` = SCALC.`FK_sesion_clase` 
    JOIN tb_clan C ON GLCSC.`FK_clan` = C.`PK_Id_Clan`
    WHERE SCALC.`IN_estado_asistencia` = 1 AND YEAR(GLCSC.DA_fecha_clase)=:anio  GROUP BY GLCSC.`FK_clan`) AS T
    GROUP BY T.VC_Nom_Clan";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':anio',$anio);
    $sentencia->execute();  
        /*$r =  $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
        $array[0]['PK_Anio']=$anio;
        $array[0]['TX_Cobertura_Crea']=json_encode($r); 
        return  $array;     */
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function validarEntrada($usuario,$password)  
    {           
        $sql="SELECT * FROM tb_acceso_usuario_2017 AS AU  
        JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=AU.FK_Id_Persona  
        WHERE AU.VC_Usuario = :usuario AND AU.VC_Password = :password AND AU.IN_Estado = 1";  
        @$sentencia=$this->db->prepare($sql);  
        @$sentencia->bindParam(':usuario',$usuario);  
        @$sentencia->bindParam(':password',$password);  
        $sentencia->execute();     
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
    }

    public  function saveLogInicioSesion($id_persona,$dispositivo,$ip,$mac){
        $sql="INSERT INTO tb_log_login (FK_persona, DT_fecha_ingreso, TX_dispositivo, TX_IP, TX_MAC) VALUES (:FK_persona, :DT_fecha_ingreso, :TX_dispositivo, :TX_IP , :TX_MAC);";  
        @$sentencia=$this->db->prepare($sql);  
        @$sentencia->bindParam(":FK_persona",$id_persona);
        @$sentencia->bindParam(":DT_fecha_ingreso",date('Y-m-d H:i:s'));
        @$sentencia->bindParam(":TX_dispositivo",$dispositivo);
        @$sentencia->bindParam(":TX_IP",$ip);
        @$sentencia->bindParam(":TX_MAC",$ma);
        $sentencia->execute();
        return $this->db->lastInsertId();
    }

    public function getEstadisticasLocalidades($anio)
    {
        // $sql="SELECT PD.VC_Descripcion AS 'LOCALIDAD',
        // COUNT(DISTINCT SCA.FK_estudiante) AS 'BENEFICIARIOS',
        // 'AE' AS 'LINEA'
        // FROM tb_terr_grupo_arte_escuela_sesion_clase SC
        // JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
        // JOIN tb_colegios C ON SC.FK_colegio=C.PK_Id_Colegio
        // JOIN tb_parametro_detalle PD ON C.FK_Id_Localidad=PD.FK_Value AND PD.FK_Id_Parametro=19
        // WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio GROUP BY PD.FK_Value
        // UNION
        // SELECT PD.VC_Descripcion AS 'LOCALIDAD',
        // COUNT(DISTINCT SCA.FK_estudiante) AS 'BENEFICIARIOS',
        // 'EC' AS 'LINEA'
        // FROM tb_terr_grupo_emprende_clan_sesion_clase SC
        // JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
        // JOIN tb_clan C ON SC.FK_clan=C.PK_Id_Clan
        // JOIN tb_parametro_detalle PD ON C.FK_Id_Localidad=PD.FK_Value AND PD.FK_Id_Parametro=19
        // WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio GROUP BY PD.FK_Value
        // UNION
        // SELECT PD.VC_Descripcion AS 'LOCALIDAD',
        // COUNT(DISTINCT SCA.FK_estudiante) AS 'BENEFICIARIOS',
        // 'LC' AS 'LINEA'
        // FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC
        // JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
        // JOIN tb_clan C ON SC.FK_clan=C.PK_Id_Clan
        // JOIN tb_parametro_detalle PD ON C.FK_Id_Localidad=PD.FK_Value AND PD.FK_Id_Parametro=19
        // WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio GROUP BY PD.FK_Value
        // UNION
        // SELECT 
        // PD.VC_Descripcion AS 'Localidad',
        // COUNT(DISTINCT(A.Fk_Id_Beneficiario)) AS 'BENEFICIARIOS',
        // 'NIDOS' AS 'LINEA'
        // FROM tb_nidos_asistencia AS A
        // JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia=A.Fk_Id_Experiencia
        // JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=E.Fk_Id_Lugar_Atencion
        // JOIN tb_parametro_detalle AS PD ON PD.FK_Value=LA.Fk_Id_Localidad AND PD.FK_Id_Parametro='19'
        // WHERE A.Vc_Asistencia='1' AND YEAR(E.DT_Fecha_Encuentro)=:anio GROUP BY PD.FK_Value";

        $sql = "SELECT 
        T.LOCALIDAD_LUGAR_ATENCION AS 'LOCALIDAD',
        COUNT(DISTINCT T.BENEFICIARIOS) AS 'BENEFICIARIOS',
        T.LINEA AS 'LINEA'
        FROM
        (
        SELECT 
        SCA.FK_estudiante AS 'BENEFICIARIOS',
        'AE' AS 'LINEA',
        'CREA' AS 'PROGRAMA',
        CASE
        WHEN SC.IN_lugar_atencion=1 THEN PDCOL.VC_Descripcion
        WHEN SC.IN_lugar_atencion=2 THEN PDCREA.VC_Descripcion
        WHEN SC.IN_lugar_atencion=3 THEN PDCREA.VC_Descripcion
        END AS 'LOCALIDAD_LUGAR_ATENCION'
        FROM tb_terr_grupo_arte_escuela_sesion_clase SC
        JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
        JOIN tb_colegios C ON SC.FK_colegio=C.PK_Id_Colegio
        JOIN tb_parametro_detalle PDCOL ON C.FK_Id_Localidad=PDCOL.FK_Value AND PDCOL.FK_Id_Parametro=19
        JOIN tb_clan CREA ON SC.FK_clan=CREA.PK_Id_Clan
        JOIN tb_parametro_detalle PDCREA ON CREA.FK_Id_Localidad=PDCREA.FK_Value AND PDCREA.FK_Id_Parametro=19
        WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio GROUP BY SCA.FK_estudiante
        UNION
        SELECT 
        SCA.FK_estudiante AS 'BENEFICIARIOS',
        'EC' AS 'LINEA',
        'CREA' AS 'PROGRAMA',
        PD.VC_Descripcion AS 'LOCALIDAD_LUGAR_ATENCION'
        FROM tb_terr_grupo_emprende_clan_sesion_clase SC
        JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
        JOIN tb_clan C ON SC.FK_clan=C.PK_Id_Clan
        JOIN tb_parametro_detalle PD ON C.FK_Id_Localidad=PD.FK_Value AND PD.FK_Id_Parametro=19
        WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio GROUP BY SCA.FK_estudiante
        UNION
        SELECT
        SCA.FK_estudiante AS 'BENEFICIARIOS',
        'LC' AS 'LINEA',
        'CREA' AS 'PROGRAMA',
        CASE
        WHEN SC.IN_lugar_atencion=1 THEN PDCREA.VC_Descripcion
        WHEN SC.IN_lugar_atencion=2 THEN PDALIADO.VC_Descripcion
        WHEN SC.IN_lugar_atencion=3 THEN PDCREA.VC_Descripcion
        END AS 'LOCALIDAD_LUGAR_ATENCION'
        FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC
        JOIN tb_terr_grupo_laboratorio_clan GLC ON SC.FK_grupo=GLC.PK_Grupo
        JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
        JOIN tb_clan C ON SC.FK_clan=C.PK_Id_Clan
        JOIN tb_parametro_detalle PDCREA ON C.FK_Id_Localidad=PDCREA.FK_Value AND PDCREA.FK_Id_Parametro=19
        LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON GLC.FK_Aliado=ALIADO.PK_Id_Aliado
        LEFT JOIN tb_parametro_detalle PDALIADO ON ALIADO.FK_Localidad=PDALIADO.FK_Value AND PDALIADO.FK_Id_Parametro=19
        WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio GROUP BY SCA.FK_estudiante
        UNION
        SELECT 
        A.Fk_Id_Beneficiario AS 'BENEFICIARIOS',
        'NIDOS' AS 'LINEA',
        'NIDOS' AS 'PROGRAMA',
        PD.VC_Descripcion AS 'LOCALIDAD_LUGAR_ATENCION'
        FROM tb_nidos_asistencia AS A
        JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia=A.Fk_Id_Experiencia
        JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=E.Fk_Id_Lugar_Atencion
        JOIN tb_parametro_detalle AS PD ON PD.FK_Value=LA.Fk_Id_Localidad AND PD.FK_Id_Parametro='19'
        WHERE A.Vc_Asistencia='1' AND YEAR(E.DT_Fecha_Encuentro)=:anio GROUP BY A.Fk_Id_Beneficiario
    ) AS T GROUP BY T.LOCALIDAD_LUGAR_ATENCION, T.LINEA;";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':anio',$anio);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);          
}

public function getProgramaDeUsuario($id_usuario){
    $sql="SELECT PP.VC_Nombre AS programa 
    FROM tb_persona_2017 P 
    LEFT JOIN tb_parametro_detalle PD ON P.FK_Tipo_Persona = PD.FK_Value AND PD.FK_Id_Parametro IN (2,3,4) 
    LEFT JOIN tb_parametro PP ON PD.FK_Id_Parametro = PP.PK_Id_Parametro  
    WHERE P.PK_Id_Persona = :id_usuario";
    @$sentencia=$this->db->prepare($sql);
    @$sentencia->bindParam(':id_usuario',$id_usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC)[0];
}

}
