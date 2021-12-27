<?php    
namespace General\Persistencia\DAOS;
class NidosReporteAsistenciaDAO extends GestionDAO {

  private $db;

  function __construct()
  {
    $this->db=$this->obtenerBD();
    $this->dbPDO=$this->obtenerPDOBD();
  }

  public function crearObjeto($objeto) {
    return;
  }

  public function modificarObjeto($objeto) {
    return;
  }

  public function eliminarObjeto($objeto) {

    $sql="UPDATE tb_nidos_lugar_atencion SET IN_Estado = :estado WHERE Pk_Id_lugar_atencion = :idLugar";
    return;
  }

  public function consultarObjeto($objeto) {
    return;
  }

  public function obtenerGruposGuardados($idUsuario){
    $sql="SELECT G.Pk_Id_Grupo, G.VC_Nombre_Grupo
    FROM tb_nidos_grupos AS G
    JOIN tb_nidos_estrategia AS E ON E.Pk_Id_Estrategia=G.FK_Id_Estrategia_Atencion
    JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
    JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
    WHERE DA.Fk_Id_Persona=$idUsuario";
    $sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarBeneficiario($Usuario){
    $sql="SELECT FK_Tipo_Identificacion, VC_Primer_Nombre, VC_Segundo_Nombre, VC_Primer_Apellido, VC_Segundo_Apellido, DD_F_Nacimiento, FK_Id_Genero,
    IN_Grupo_Poblacional, IN_Identificacion_Poblacional FROM tb_nidos_beneficiarios WHERE VC_Identificacion = :Identificacion";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':Identificacion',$Usuario);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function consultarBeneficiarioGrupo($idGrupo){
    $sql="SELECT BG.Fk_Id_Beneficiario AS 'IDENTIFICACION',
    CONCAT(B.VC_Primer_Nombre,' ',B.VC_Segundo_Nombre,' ',B.VC_Primer_Apellido,' ',B.VC_Segundo_Apellido) AS 'BENEFICIARIO',
    TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,CURDATE()) AS EDAD
    FROM tb_nidos_beneficiario_grupo BG
    JOIN tb_nidos_beneficiarios AS B ON BG.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario
    WHERE BG.IN_Estado = '1' AND BG.Fk_Id_Grupo = :IdGrupo";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdGrupo',$idGrupo);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getExperienciaGrupo($parametro){
   $sql="SELECT Pk_Id_Experiencia, VC_Nombre_Experiencia, DT_Fecha_Encuentro FROM .tb_nidos_experiencia where Fk_ID_grupo = :parametro";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':parametro',$parametro);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function ConsultaConsolidadoGestor($id_dupla, $mes){
   $sql="SELECT VC_Nombre_Upz, FK_Id_Dupla, VC_Codigo_Dupla, VC_Barrio, VC_Nombre_Lugar, VC_Profesional_Responsable, Pk_Id_Grupo, VC_Nombre_Grupo, Vc_Abreviatura, Vc_Descripcion, COBERTURA, EXPERIENCIA, IDEXPERIENCIA, CUIDADORES, APROBACION,
   COALESCE(TOTAL_DE_0_3_ANIOS_N,0) as TOTAL_DE_0_3_ANIOS_N,
   COALESCE(TOTAL_DE_4_6_ANIOS_N,0) as TOTAL_DE_4_6_ANIOS_N,
   COALESCE(GESTANTES_N,0) AS GESTANTES_N,
   COALESCE(TOTAL_N,0) AS TOTAL_N,
   TOTAL_N_IDENTIFICACION,
   COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
   COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
   COALESCE(NINOS_DE_0_A_3_R,0) as NINOS_DE_0_A_3_R,
   COALESCE(NINAS_DE_0_A_3_R,0) AS NINAS_DE_0_A_3_R,
   COALESCE(NINOS_DE_4_A_6_R,0) AS NINOS_DE_4_A_6_R,
   COALESCE(NINAS_DE_4_A_6_R,0) AS NINAS_DE_4_A_6_R,
   COALESCE(GESTANTES_R,0) AS GESTANTES_R,
   COALESCE(AFRODESCENDIENTE_R,0) AS AFRODESCENDIENTE_R,
   COALESCE(ROM_R,0) AS ROM_R,
   COALESCE(INDIGENA_R,0) AS INDIGENA_R,
   COALESCE(CONFLICTO_R,0) AS CONFLICTO_R,
   COALESCE(DISCAPACIDAD_R,0) AS DISCAPACIDAD_R,
   COALESCE(NINGUNO_R,0) AS NINGUNO_R,
   COALESCE(PRIVADOS_R,0) AS PRIVADOS_R,
   COALESCE(RAIZALES_R,0) AS RAIZALES_R,
   COALESCE(CAMPESINA_R,0) AS CAMPESINA_R,
   COALESCE(TOTAL_R,0) AS TOTAL_R
   FROM (
   SELECT U.VC_Nombre_Upz, G.FK_Id_Dupla, VC_Codigo_Dupla, L.VC_Barrio, L.VC_Nombre_Lugar, G.VC_Profesional_Responsable,G.Pk_Id_Grupo, G.VC_Nombre_Grupo, E.Vc_Abreviatura, T.Vc_Descripcion,
   (SELECT COUNT(BG.Fk_Id_Beneficiario) FROM tb_nidos_beneficiario_grupo BG WHERE BG.Fk_Id_Grupo = G.Pk_Id_Grupo AND BG.IN_Estado = '1') AS 'COBERTURA',
   (SELECT COUNT(EX.Pk_Id_Experiencia) FROM tb_nidos_experiencia EX
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA',
   (SELECT GROUP_CONCAT(CONCAT(' ',EX.Pk_Id_Experiencia,', ') ) FROM tb_nidos_experiencia EX
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'IDEXPERIENCIA',
   (SELECT SUM(IN_Cuidadores) FROM tb_nidos_experiencia EX
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'CUIDADORES',
   (SELECT GROUP_CONCAT(CONCAT(' ',EX.IN_Aprobacion,' ') ) FROM tb_nidos_experiencia EX
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'APROBACION'
   FROM tb_nidos_grupos G
   JOIN tb_nidos_lugar_atencion AS L ON G.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion
   JOIN tb_upz AS U ON L.Fk_Id_Upz = U.Pk_Id_Upz
   JOIN tb_nidos_dupla AS D ON D.Pk_Id_Dupla = G.FK_Id_Dupla
   JOIN tb_nidos_entidades AS E ON L.Fk_Id_Entidad = E.Pk_Id_Entidad
   JOIN tb_nidos_tipo_lugar AS T ON L.VC_Tipo_Lugar = T.Pk_Id_Lugar
   WHERE G.FK_Id_Dupla = $id_dupla AND G.IN_Estado = '1' AND (SELECT COUNT(EX.Pk_Id_Experiencia) FROM tb_nidos_experiencia EX
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) > 0) AS PRIMERA left JOIN
   (SELECT
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_4_6_ANIOS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 AND
   (SELECT E.DT_Fecha_Encuentro > '2021-$mes-01' AND  E.DT_Fecha_Encuentro < '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS GESTANTES_N,


   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND         
   (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_N,

   (SELECT GROUP_CONCAT(CONCAT(' ',NAC.Fk_Id_Beneficiario) ) 
   FROM tb_nidos_asistencia NAC 
   JOIN tb_nidos_experiencia AS EXA ON NAC.Fk_Id_Experiencia = EXA.Pk_Id_Experiencia          
   WHERE EXA.Pk_Id_Experiencia = EX.Pk_Id_Experiencia AND NAC.Vc_Asistencia = '1'  AND (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NAC.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) ) AS 'TOTAL_N_IDENTIFICACION',


   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND BE.Fk_Id_Genero = 1 then 1 END) AS NINOS_DE_0_A_3_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND BE.Fk_Id_Genero = 2 then 1 END) AS NINAS_DE_0_A_3_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND BE.Fk_Id_Genero = 1 then 1 END) AS NINOS_DE_4_A_6_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND BE.Fk_Id_Genero = 2 then 1 END) AS NINAS_DE_4_A_6_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
   COUNT(CASE WHEN BE.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
   EX.Fk_Id_Grupo
   FROM tb_nidos_asistencia NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
   where NA.Vc_Asistencia = '1' AND EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31'
   GROUP BY EX.Fk_Id_Grupo) AS SEGUNDA ON 	PRIMERA.Pk_Id_Grupo = SEGUNDA.Fk_Id_Grupo";
   $sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':id_dupla',$id_dupla);
   @$sentencia->bindParam(':mes',$mes);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }


     //  CONSULTAS REPORTE DE ASISTENCIA PDF
 public function consultarAsistencia_Experiencia($idGrupo){
   $sql="SELECT EXP.Pk_Id_Experiencia AS 'Id_Experiencia', EXP.VC_Nombre_Experiencia AS 'Nom_Experiencia', EXP.DT_Fecha_Encuentro AS 'Fecha', CONCAT('DE ', EXP.HR_Hora_Inicio,' A ',EXP.HR_Hora_Finalizacion) AS 'Hora',
   (select COUNT(NA.Pk_Id_Asistencia)from tb_nidos_asistencia  AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiario_grupo AS BG ON EX.Fk_Id_Grupo = BG.Fk_Id_Grupo AND NA.Fk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   where EXP.Pk_Id_Experiencia = NA.Fk_Id_Experiencia AND Vc_Asistencia = '1') AS 'Total',
   (select COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS 'TOTAL_DE_0_3_ANIOS_N'from tb_nidos_asistencia  AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiario_grupo AS BG ON EX.Fk_Id_Grupo = BG.Fk_Id_Grupo AND NA.Fk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   where EXP.Pk_Id_Experiencia = NA.Fk_Id_Experiencia AND Vc_Asistencia = '1') AS 'Total_0_a_3',
   (select COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS 'TOTAL_DE_0_3_ANIOS_N'from tb_nidos_asistencia  AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiario_grupo AS BG ON EX.Fk_Id_Grupo = BG.Fk_Id_Grupo AND NA.Fk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   where EXP.Pk_Id_Experiencia = NA.Fk_Id_Experiencia AND Vc_Asistencia = '1') AS 'Total_4_a_5',
   (select COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS 'TOTAL_DE_0_3_ANIOS_N'from tb_nidos_asistencia  AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiario_grupo AS BG ON EX.Fk_Id_Grupo = BG.Fk_Id_Grupo AND NA.Fk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   where EXP.Pk_Id_Experiencia = NA.Fk_Id_Experiencia AND Vc_Asistencia = '1') AS 'Total_Gestantes'
   FROM tb_nidos_experiencia EXP where Fk_Id_Grupo = :IdGrupo";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':IdGrupo',$idGrupo);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function reporteAsistenciaExperienciaEncabezado($idExperiencia){
   $sql="SELECT EX.Pk_Id_Experiencia AS 'ID',
   EX.VC_Nombre_Experiencia  AS 'EXPERIENCIA',
   EX.DT_Fecha_Encuentro AS 'FECHA',
   CONCAT('DE ',EX.HR_Hora_Inicio,' A ',EX.HR_Hora_Finalizacion) AS 'HORA',
   LO.VC_Nom_Localidad AS 'LOCALIDAD',
   UP.VC_Nombre_Upz AS 'UPZ',
   LA.VC_Barrio AS 'BARRIO',
   LA.VC_Nombre_Lugar AS 'LUGAR',
   TL.Vc_Descripcion AS 'TIPO_LUGAR',
   DU.VC_Codigo_Dupla,
   CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'GESTOR',
   (SELECT GROUP_CONCAT(CONCAT(PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido) SEPARATOR ' Y ' )
   FROM tb_persona_2017 AS PER JOIN tb_nidos_persona_territorio AS PT ON PER.PK_Id_Persona = PT.Fk_Id_Persona
   where PER.FK_Tipo_Persona = 22 AND PT.Fk_Id_Territorio = DU.Fk_Id_Territorio  ) AS 'EAAT',
   ES.Vc_Estrategia AS 'ESTRATEGIA',
   G.VC_Nombre_Grupo AS 'GRUPO',
   G.VC_Profesional_Responsable AS 'RESPONSABLE',
   (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido,' ') )
   FROM tb_nidos_experiencia_artista DA, tb_persona_2017 PER
   WHERE DA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia AND DA.Fk_Id_Artista = PER.PK_Id_Persona)  AS 'ARTISTAS'
   FROM tb_nidos_experiencia EX
   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
   JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
   JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
   JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
   JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
   JOIN tb_persona_2017 AS P ON DU.Fk_Id_Gestor = P.PK_Id_Persona
   JOIN tb_nidos_grupos AS G ON EX.Fk_Id_Grupo = G.Pk_Id_Grupo
   JOIN tb_nidos_estrategia AS ES ON G.Fk_Id_Estrategia_Atencion = ES.Pk_Id_Estrategia
   WHERE EX.Pk_Id_Experiencia = :idExperiencia";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':idExperiencia',$idExperiencia);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function reporteAsistenciaExperienciaBeneficiarios($idExperiencia){
   $sql="SELECT B.Pk_Id_Beneficiario,
   B.VC_Identificacion AS 'IDENTIFICACION',
   PT.VC_Descripcion AS 'TIPO',
   CONCAT(B.VC_Primer_Apellido,' ',B.VC_Segundo_Apellido,' ',B.VC_Primer_Nombre,' ',B.VC_Segundo_Nombre) AS 'BENEFICIARIO',
   B.DD_F_Nacimiento AS 'FECHANACIMIENTO',
   TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) AS 'EDAD_EXP',
   PG.VC_Descripcion AS 'GENERO',
   PE.VC_Descripcion AS 'ROM',
   (CASE WHEN NA.Vc_Asistencia = '0' THEN 'No Asistió' WHEN NA.Vc_Asistencia = '1' THEN 'Asistió' END) AS 'ASISTENCIA'
   FROM tb_nidos_asistencia AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiarios  AS B ON NA.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario
   JOIN tb_parametro_detalle AS PT ON B.Fk_Tipo_Identificacion = PT.FK_Value AND PT.FK_Id_Parametro = 5
   JOIN tb_parametro_detalle AS PG ON B.FK_Id_Genero = PG.FK_Value AND PG.FK_Id_Parametro = 17
   JOIN tb_parametro_detalle AS PE ON B.IN_Grupo_Poblacional = PE.FK_Value AND PE.FK_Id_Parametro = 14
   WHERE Fk_Id_Experiencia = :idExperiencia ORDER BY B.VC_Primer_Apellido";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':idExperiencia',$idExperiencia);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function reporteAsistenciaExperienciaTotales($idExperiencia){
   $sql="SELECT
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND B.Fk_Id_Genero = 1 then 1 END) AS 'NINOS_DE_0_A_3',
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND B.Fk_Id_Genero = 2 then 1 END) AS 'NINAS_DE_0_A_3',
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND B.Fk_Id_Genero = 1 then 1 END) AS 'NINOS_DE_4_A_6',
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND B.Fk_Id_Genero = 2 then 1 END) AS 'NINAS_DE_4_A_6',
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS 'TOTAL_DE_0_3_ANIOS',
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS 'TOTAL_DE_4_6_ANIOS',
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,B.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS 'GESTANTES'
   FROM tb_nidos_asistencia AS NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiarios  AS B ON NA.Fk_Id_Beneficiario = B.Pk_Id_Beneficiario
   WHERE Fk_Id_Experiencia = :idExperiencia AND NA.Vc_Asistencia = '1'";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':idExperiencia',$idExperiencia);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function obtenerIdDuplaArtista($idUsuario){
   $sql="SELECT Fk_Id_Dupla
   FROM tb_nidos_dupla_artista AS DA
   JOIN tb_nidos_dupla  AS DU ON DA.Fk_Id_Dupla = DU.Pk_Id_Dupla
   WHERE DU.IN_Estado = 1 AND Fk_Id_Persona = $idUsuario";
   $sentencia=$this->dbPDO->prepare($sql);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }


 public function ConsolidadoMensualDupla($mes, $IdDupla) {
   $sql="SELECT LUGAR, IDGRUPO, NOMGRUPO, ENTIDAD, TLUGAR, EXPERIENCIA,
   COALESCE(TOTAL_N,0) AS 'TOTAL_N',
   COALESCE(TOTAL_DE_0_3_ANIOS_R,0) AS 'TOTAL_DE_0_3_ANIOS_R',
   COALESCE(TOTAL_DE_4_6_ANIOS_R,0) AS 'TOTAL_DE_4_6_ANIOS_R',
   COALESCE(GESTANTES_R,0) AS 'GESTANTES_R',
   COALESCE(TOTAL_R,0) AS 'TOTAL_R'
   FROM (SELECT DISTINCT(G.Pk_Id_Grupo) AS 'IDGRUPO', L.VC_Nombre_Lugar AS 'LUGAR',  
   G.VC_Nombre_Grupo AS 'NOMGRUPO', 
   E.Vc_Abreviatura AS 'ENTIDAD', 
   T.Vc_Descripcion AS 'TLUGAR',
   (SELECT COUNT(EX.Pk_Id_Experiencia) FROM tb_nidos_experiencia EX
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA'
   FROM tb_nidos_experiencia AS EXPE
   JOIN tb_nidos_grupos AS G ON EXPE.Fk_Id_Grupo = G.Pk_Id_Grupo
   JOIN tb_nidos_lugar_atencion AS L ON EXPE.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion 
   JOIN tb_nidos_entidades AS E ON L.Fk_Id_Entidad = E.Pk_Id_Entidad
   JOIN tb_nidos_tipo_lugar AS T ON L.VC_Tipo_Lugar = T.Pk_Id_Lugar
   WHERE G.FK_Id_Dupla = $IdDupla AND G.IN_Estado = '1') AS PRIMERA left JOIN
   (SELECT
    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND         
   (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
   EX.Fk_Id_Grupo
   FROM tb_nidos_asistencia NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
   where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
   GROUP BY EX.Fk_Id_Grupo) AS SEGUNDA ON 	PRIMERA.IDGRUPO = SEGUNDA.Fk_Id_Grupo";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':mes',$mes);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function EncabezadoConsolidadoMensualDupla($IdDupla) {
   $sql="SELECT D.Pk_Id_Dupla AS 'IdDupla', TD.Vc_Descripcion AS 'TIPODUPLA', D.VC_Codigo_Dupla AS 'CODIGODUPLA', T.Vc_Nom_Territorio AS 'TERRITORIO',
   (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido,' ') )
   FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
   WHERE DA.Fk_Id_Dupla = D.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona AND IN_Estado = '1')  AS 'ARTISTAS',
   CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'GESTOR',
   CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'EAAT'
   FROM tb_nidos_dupla AS D
   JOIN tb_nidos_tipo_dupla AS TD ON D.Fk_Id_Tipo_Dupla = TD.Pk_Id_Tipo_dupla
   LEFT JOIN tb_nidos_territorios AS T ON D.Fk_Id_Territorio = T.Pk_Id_Territorio
   LEFT JOIN tb_persona_2017 AS P ON D.Fk_Id_Gestor = P.PK_Id_Persona
   LEFT JOIN tb_persona_2017 AS PE ON D.Fk_Id_Eaat = PE.PK_Id_Persona
   where D.Pk_Id_Dupla = :IdDupla";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':IdDupla',$IdDupla);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function TotalesConsolidadoMensualDupla($mes, $IdDupla) {
   $sql="SELECT
   (SELECT COUNT(EX.Pk_Id_Experiencia) FROM tb_nidos_experiencia EX, tb_nidos_grupos G
   WHERE EX.Fk_Id_Grupo = G.Pk_Id_Grupo  AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND G.FK_Id_Dupla = :IdDupla AND G.IN_Estado = '1') AS 'EXPERIENCIA',
    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND         
   (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R
   FROM tb_nidos_asistencia NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_grupos AS G ON EX.FK_Id_Grupo = G.Pk_Id_Grupo
   JOIN tb_nidos_beneficiario_grupo AS BG ON EX.Fk_Id_Grupo = BG.Fk_Id_Grupo AND NA.Fk_Id_Beneficiario = BG.Fk_Id_Beneficiario
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
   WHERE NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND G.FK_Id_Dupla = :IdDupla AND G.IN_Estado = '1' ";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':mes',$mes);
   @$sentencia->bindParam(':IdDupla',$IdDupla);
   $sentencia->execute();
   return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
 }

 public function aprobarExperienciaDAO($objeto) {

   $sql="UPDATE tb_nidos_experiencia SET IN_Aprobacion = :aprobacion, DT_Fecha_Aprobacion = :fecha WHERE Pk_Id_Experiencia = :idExperiencia";
   @$sentencia=$this->dbPDO->prepare($sql);
   @$sentencia->bindParam(':aprobacion',$objeto->getInAprobacion());
   @$sentencia->bindParam(':fecha',$objeto->getFechaAprobacion());
   @$sentencia->bindParam(':idExperiencia',$objeto->getPkIdExperiencia());
   $sentencia->execute();
 
 $sentencia->execute();
 return $sentencia->rowCount();
}


public function TotalesMensualDuplaPdf($IdDupla, $mes) {
 $sql="SELECT  COUNT(DISTINCT EX.Fk_Id_Grupo) AS GRUPOS, COUNT(EX.Pk_Id_Experiencia) AS EXPERIENCIAS, PD.VC_Descripcion AS MES
 FROM tb_nidos_experiencia EX , tb_parametro_detalle PD 
 WHERE EX.Fk_Id_Dupla = :IdDupla AND PD.FK_Id_Parametro = 8 AND PD.FK_Value = :mes AND EX.IN_Aprobacion = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31');";
 @$sentencia=$this->dbPDO->prepare($sql);
 @$sentencia->bindParam(':IdDupla',$IdDupla);
 @$sentencia->bindParam(':mes',$mes);
 $sentencia->execute();
 return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function ConsolidadoMensualDuplaPdf($IdDupla, $id_mes, $mes_anterior) {
  $sql="SELECT
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _0_3_NINOS_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _0_3_NINAS_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_0_3_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _4_5_NINOS_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _4_5_NINAS_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_4_5_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _6_NINOS_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _6_NINAS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6  AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_6_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 10  AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS GESTANTES_N,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 60 AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (1) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS AFRO_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (2) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS ROM_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (3) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS INDIGENA_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (4) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS CONFLICTO_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (5) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS DISCAPACIDAD_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (10) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS CARCELARIA_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (12) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS CALLE_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (13) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS RAIZAL_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (14) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS CAMPESINA_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (18) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS SEXUALES_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (19) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS MIGRANTE_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (20) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS DETERIORO_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (21) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS PALENQUERA_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (22) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS LGBTIQ_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (23) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS CATASTROFICA_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (24) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS PSICOACTIVAS_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (25) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS NEGRAS_N,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (26) AND
  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes_anterior-26' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-25' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS DESPLAZAMIENTO_N,
 
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 1 then 1 END) AS _0_3_NINOS_R,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 2 then 1 END) AS _0_3_NINAS_R, 
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_0_3_R,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 1 then 1 END) AS _4_5_NINOS_R,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 2 then 1 END) AS _4_5_NINAS_R, 
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_4_5_R,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND DT.Fk_Id_Genero = 1 then 1 END) AS _6_NINOS_R,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND DT.Fk_Id_Genero = 2 then 1 END) AS _6_NINAS_R, 
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 then 1 END) AS TOTAL_6_R,
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 10 then 1 END) AS GESTANTES_R, 
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 60 then 1 END) AS TOTAL_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (1) then 1 END) AS AFRO_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (2) then 1 END) AS ROM_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (3) then 1 END) AS INDIGENA_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (4) then 1 END) AS CONFLICTO_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (5) then 1 END) AS DISCAPACIDAD_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (10) then 1 END) AS CARCELARIA_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (12) then 1 END) AS CALLE_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (13) then 1 END) AS RAIZAL_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (14) then 1 END) AS CAMPESINA_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (18) then 1 END) AS SEXUALES_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (19) then 1 END) AS MIGRANTE_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (20) then 1 END) AS DETERIORO_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (21) then 1 END) AS PALENQUERA_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (22) then 1 END) AS LGBTIQ_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (23) then 1 END) AS CATASTROFICA_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (24) then 1 END) AS PSICOACTIVAS_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (25) then 1 END) AS NEGRAS_R,
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (26) then 1 END) AS DESPLAZAMIENTO_R,
  DT.Fk_Id_Dupla AS IDEXPEREINCIA
  FROM (SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero, EX.Fk_Id_Dupla,
  ( SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS DT_Fecha_Encuentro,	
  (SELECT E.Fk_Id_Lugar_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE   EX.Fk_Id_Dupla =  :IdDupla AND NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1  AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$id_mes-25')) DT GROUP BY Fk_Id_Dupla";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':IdDupla',$IdDupla);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function ConsolidadoMensualDuplaCifrasPdf($IdDupla, $id_mes, $mes_anterior) {
    $sql="SELECT  
    SUM(SI.IN_Total_Ninos_0_3) AS '_0_3_NINOS_R',
    SUM(SI.IN_Total_Ninas_0_3) AS '_0_3_NINAS_R',
    SUM(SI.IN_Total_Ninos_0_3 + SI.IN_Total_Ninas_0_3) AS '_0_3_TOTAL_R',
    SUM(SI.IN_Total_Ninos_3_6) AS '_3_5_NINOS_R',
    SUM(SI.IN_Total_Ninas_3_6) AS '_3_5_NINAS_R',
    SUM(SI.IN_Total_Ninos_3_6 + SI.IN_Total_Ninas_3_6) AS '_3_6_TOTAL_R',
    SUM(SI.IN_Total_Ninos_6) AS '_6_NINOS_R',
    SUM(SI.IN_Total_Ninas_6) AS '_6_NINAS_R',
    SUM(SI.IN_Total_Ninos_6 + SI.IN_Total_Ninas_6) AS '_6_TOTAL_R',
    SUM(SI.IN_Mujeres_Gestantes) AS '_GESTANTES_R',
    SUM(SI.IN_Total_Beneficiarios) AS '_TOTAL_R',
    SUM(SI.IN_Total_Ninos_0_3_Nuevos) AS '_0_3_NINOS_N',
    SUM(SI.IN_Total_Ninas_0_3_Nuevos) AS '_0_3_NINAS_N',
    SUM(SI.IN_Total_Ninos_0_3_Nuevos + SI.IN_Total_Ninas_0_3_Nuevos) AS '_0_3_TOTAL_N',
    SUM(SI.IN_Total_Ninos_3_6_Nuevos) AS '_4_5_NINOS_N',
    SUM(SI.IN_Total_Ninas_3_6_Nuevos) AS '_4_5_NINAS_N',
    SUM(SI.IN_Total_Ninos_3_6_Nuevos + SI.IN_Total_Ninas_3_6_Nuevos) AS '_4_5_TOTAL_N',
    SUM(SI.IN_Total_Ninos_6_Nuevos) AS '_6_NINOS_N',
    SUM(SI.IN_Total_Ninas_6_Nuevos) AS '_6_NINAS_N',
    SUM(SI.IN_Total_Ninos_6_Nuevos + SI.IN_Total_Ninas_6_Nuevos) AS '_6_TOTAL_N',
    SUM(SI.IN_Mujeres_Gestantes_Nuevos) AS '_GESTANTES_N',
    SUM(SI.IN_Total_Beneficiarios_Nuevos) AS '_TOTAL_N'
    FROM tb_nidos_beneficiario_sin_informacion AS SI
    JOIN tb_nidos_experiencia AS EX ON SI.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
    WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$id_mes-25') AND EX.IN_Aprobacion = 1 AND EX.Fk_Id_Dupla = :IdDupla";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':IdDupla',$IdDupla);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }


public function consultarBeneficiariosNuevosGrupo($beneficiarios) {
  if($beneficiarios != ""){
    $sql="SELECT BE.VC_Identificacion AS 'IDENTIFICACION', CONCAT(BE.VC_Primer_Nombre,' ',BE.VC_Segundo_Nombre,' ',BE.VC_Primer_Apellido) AS 'NOMBRE',  
    DD_F_Nacimiento AS 'NACIMIENTO',
    (SELECT E.DT_Fecha_Encuentro FROM tb_nidos_asistencia N 
    left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
    where N.Fk_Id_Beneficiario = BE.Pk_Id_Beneficiario AND N.Vc_Asistencia = '1' 
    AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'P_ATENCION'
    FROM tb_nidos_beneficiarios AS BE               
    WHERE Pk_Id_Beneficiario IN ($beneficiarios)";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':beneficiarios',$beneficiarios);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
  }else{
    return "";
  }
} 

/* public function getExperienciasDupla($id_mes, $id_usuario){
  $sql = "SELECT EX.Pk_Id_Experiencia AS 'IDEXPERIENCIA', 
  LA.VC_Nombre_Lugar AS 'LUGAR',
  DU.VC_Codigo_Dupla AS 'DUPLA',
  GR.VC_Nombre_Grupo AS 'GRUPO',
  EX.VC_Nombre_Experiencia AS 'EXPERIENCIA',
  EX.IN_Aprobacion AS 'APROBACION',
  EX.DT_Fecha_Encuentro AS 'FECHA',
  CONCAT(EX.HR_Hora_Inicio,' a ',EX.HR_Hora_Finalizacion) AS 'HORARIO',
  (SELECT COUNT(NA.Fk_Id_Beneficiario)
	  FROM tb_nidos_asistencia AS NA
	  WHERE NA.Vc_Asistencia = 1 AND NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia) AS 'BENEFICIARIOS',
    EX.IN_Cuidadores AS 'CUIDADORES',
    BI.Fk_Id_Experiencia AS 'FKEXPERIENCIA',
    BI.IN_Total_Ninos_0_3 AS 'NINOS03REAL',
    BI.IN_Total_Ninas_0_3 AS 'NINAS03REAL', 
    BI.IN_Total_Ninos_3_6 AS 'NINOS46REAL',
    BI.IN_Total_Ninas_3_6 AS 'NINAS46REAL',
    BI.IN_Total_Ninos_6 AS 'NINOS6REAL',
    BI.IN_Total_Ninas_6 AS 'NINAS6REAL',	 
	 BI.IN_Total_Ninos AS 'TOTALNINOSREAL',    
    BI.IN_Total_Ninas AS 'TOTALNINASREAL',
    BI.IN_Mujeres_Gestantes AS 'GESTANTESREAL',
    BI.IN_Total_Beneficiarios AS 'TOTALBENEFICIARIOSREAL',
    BI.IN_Afrodescendiente AS 'AFROREAL',
    BI.IN_Campesina AS 'CAMPESINOSREAL',
    BI.IN_Discapacidad AS 'DISCAPACIDADREAL',
    BI.IN_Conflicto AS 'CONFLICTOREAL',
    BI.IN_Indigena AS 'INDIGENAREAL',
    BI.IN_Privados AS 'PRIVADOSREAL',
    BI.IN_Victimas AS 'VICTIMASREAL',
    BI.IN_Raizal AS 'RAIZALREAL',
    BI.IN_Rom AS 'ROMREAL',
    BI.IN_Total_Ninos_0_3_Nuevos AS 'NINOS03NUEVOS',
    BI.IN_Total_Ninas_0_3_Nuevos AS 'NINAS03NUEVOS', 
	 BI.IN_Total_Ninos_3_6_Nuevos AS 'NINOS46NUEVOS',
    BI.IN_Total_Ninas_3_6_Nuevos AS 'NINAS46NUEVOS',
    BI.IN_Total_Ninos_6_Nuevos AS 'NINOS6NUEVOS',
    BI.IN_Total_Ninas_6_Nuevos AS 'NINAS6NUEVOS',
    BI.IN_Total_Ninos_Nuevos AS 'TOTALNINOSNUEVOS',   
    BI.IN_Total_Ninas_Nuevos AS 'TOTALNINASNUEVOS',
    BI.IN_Mujeres_Gestantes_Nuevos AS 'GESTANTESNUEVOS',
    BI.IN_Total_Beneficiarios_Nuevos AS 'TOTALBENEFICIARIOSNUEVOS',
    BI.IN_Afrodescendiente_Nuevo AS 'AFRONUEVOS',
    BI.IN_Campesina_Nuevo AS 'CAMPESINOSNUEVOS',
    BI.IN_Discapacidad_Nuevo AS 'DISCAPACIDADNUEVOS',
    BI.IN_Conflicto_Nuevo AS 'CONFLICTONUEVOS',
    BI.IN_Indigena_Nuevo AS 'INDIGENANUEVOS',
    BI.IN_Privados_Nuevo AS 'PRIVADOSNUEVOS',
    BI.IN_Victimas_Nuevo AS 'VICTIMASNUEVOS',
    BI.IN_Raizal_Nuevo AS 'RAIZALNUEVOS',
    BI.IN_Rom_Nuevo AS 'ROMNUEVOS',
    BI.VC_Documento_Soporte AS 'soporte'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
  JOIN tb_nidos_beneficiario_sin_informacion AS BI ON EX.Pk_Id_Experiencia = BI.Fk_Id_Experiencia
  WHERE BI.Fk_Id_Usuario_Registro = :id_usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_usuario', $id_usuario);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
} */ 

public function consultarTotalExperienciasMes($id_mes, $id_usuario){
  $sql="SELECT COUNT(EX.Pk_Id_Experiencia) AS TOTAL 
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_dupla AS DA ON EX.Fk_Id_Dupla = DA.Pk_Id_Dupla
  WHERE DA.Pk_Id_Dupla = :IdUsuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':IdUsuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function consultarExperienciaLugarDupla($id_mes, $id_usuario){
  $sql="SELECT LA.Pk_Id_lugar_atencion AS 'IDLUGAR', LA.VC_Nombre_Lugar AS 'LUGAR', EX.Fk_Id_Dupla AS 'IDDUPLA',
  COUNT(EX.Pk_Id_Experiencia) AS 'CANTIDAD',
  (SELECT Pk_Id_Soporte
  FROM tb_nidos_experiencia_soporte AS  ES
  WHERE EX.Fk_Id_Lugar_Atencion = ES.Fk_Id_Lugar_Atencion
  AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY Pk_Id_Soporte DESC LIMIT 1) AS 'IDSOPORTE',
  (SELECT VC_Documento_Soporte 
  FROM tb_nidos_experiencia_soporte AS  ES
  WHERE EX.Fk_Id_Lugar_Atencion = ES.Fk_Id_Lugar_Atencion
  AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY Pk_Id_Soporte DESC LIMIT 1) AS 'SOPORTE'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_nidos_dupla AS DA ON EX.Fk_Id_Dupla = DA.Pk_Id_Dupla
  WHERE DA.Pk_Id_Dupla = :IdUsuario 
  AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') AND LA.Fk_Id_Entidad != 5
  GROUP BY EX.Fk_Id_Lugar_Atencion
  HAVING COUNT(EX.Pk_Id_Experiencia) ORDER BY LA.VC_Nombre_Lugar";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':IdUsuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarExperienciaLaboratorioDupla($id_mes, $id_usuario){
  $sql="SELECT LA.Pk_Id_lugar_atencion AS 'IDLUGAR', LA.VC_Nombre_Lugar AS 'LUGAR', EX.Fk_Id_Dupla AS 'IDDUPLA',
  COUNT(EX.Pk_Id_Experiencia) AS 'CANTIDAD',   
 (SELECT ES.Pk_Id_Soporte
  FROM tb_nidos_experiencia_soporte AS  ES
  JOIN tb_nidos_grupos AS GR ON ES.Fk_Id_Lugar_Atencion = GR.Fk_Id_Lugar_Grupo_Laboratorio
  WHERE GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
  AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY ES.Pk_Id_Soporte DESC LIMIT 1) AS 'IDSOPORTE',    
  (SELECT VC_Documento_Soporte 
  FROM tb_nidos_experiencia_soporte AS  ES
  JOIN tb_nidos_grupos AS GR ON ES.Fk_Id_Lugar_Atencion = GR.Fk_Id_Lugar_Grupo_Laboratorio
  WHERE GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
  AND EX.Fk_Id_Dupla = ES.Fk_Id_Dupla AND ES.IN_Mes = $id_mes ORDER BY Pk_Id_Soporte DESC LIMIT 1) AS 'SOPORTE'    
 FROM tb_nidos_experiencia AS EX
 JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
 JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
 JOIN tb_nidos_dupla AS DA ON EX.Fk_Id_Dupla = DA.Pk_Id_Dupla
 WHERE DA.Pk_Id_Dupla = :IdUsuario 
 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') -- AND LA.Fk_Id_Entidad = 5
 GROUP BY GR.Fk_Id_Lugar_Grupo_Laboratorio
 HAVING COUNT(EX.Pk_Id_Experiencia) ORDER BY LA.VC_Nombre_Lugar";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':IdUsuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function getExperienciasDupla($id_mes, $id_usuario){
  $sql = "SELECT ID, LUGAR, GRUPO, GRADO, MODALIDAD, EXPERIENCIAS, FECHA, CUIDADORES, IDEXPEREINCIA, APROBACION, SOPORTE,
  COALESCE(_0_3_NINOS_N,0) AS _0_3_NINOS_N,
  COALESCE(_0_3_NINAS_N,0) AS _0_3_NINAS_N,
  COALESCE(TOTAL_0_3_N,0) AS TOTAL_0_3_N,
  COALESCE(_4_5_NINOS_N,0) AS _4_5_NINOS_N,
  COALESCE(_4_5_NINAS_N,0) AS _4_5_NINAS_N,
  COALESCE(TOTAL_4_5_N,0) AS TOTAL_4_5_N,
  COALESCE(_6_NINOS_N,0) AS _6_NINOS_N,
  COALESCE(_6_NINAS_N,0) AS _6_NINAS_N,
  COALESCE(TOTAL_6_N,0) AS TOTAL_6_N,
  COALESCE(GESTANTES_N,0) AS GESTANTES_N,
  COALESCE(TOTAL_N,0) AS TOTAL_N,
  COALESCE(ENFOQUE_N,0) AS ENFOQUE_N,
  COALESCE(_0_3_NINOS_R,0) AS _0_3_NINOS_R,
  COALESCE(_0_3_NINAS_R,0) AS _0_3_NINAS_R,
  COALESCE(TOTAL_0_3_R,0) AS TOTAL_0_3_R,
  COALESCE(_4_5_NINOS_R,0) AS _4_5_NINOS_R,
  COALESCE(_4_5_NINAS_R,0) AS _4_5_NINAS_R,
  COALESCE(TOTAL_4_5_R,0) AS TOTAL_4_5_R,
  COALESCE(_6_NINOS_R,0) AS _6_NINOS_R,
  COALESCE(_6_NINAS_R,0) AS _6_NINAS_R,
  COALESCE(TOTAL_6_R,0) AS TOTAL_6_R,
  COALESCE(GESTANTES_R,0) AS GESTANTES_R,
  COALESCE(TOTAL_R,0) AS TOTAL_R,
  COALESCE(ENFOQUE_R,0) AS ENFOQUE_R
  FROM 
  (SELECT EX.Pk_Id_Experiencia AS 'ID',
  LA.VC_Nombre_Lugar AS 'LUGAR',
  GR.VC_Nombre_Grupo AS 'GRUPO',
  PD.VC_Descripcion AS 'GRADO',
  (CASE WHEN EX.IN_Modalidad = '1' THEN 'Presencial' WHEN EX.IN_Modalidad = '2' THEN 'Virtual' END) AS 'MODALIDAD',
  EX.VC_Nombre_Experiencia AS 'EXPERIENCIAS',
  EX.DT_Fecha_Encuentro AS 'FECHA',
  EX.IN_Aprobacion AS 'APROBACION',
  EX.IN_Cuidadores AS 'CUIDADORES',
  EX.VC_Documento_Soporte AS 'SOPORTE'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
  LEFT JOIN tb_parametro_detalle AS PD ON GR.Fk_Id_Nivel_Escolaridad = PD.FK_Value AND PD.FK_Id_Parametro = 58
  WHERE  EX.Fk_Id_Dupla = :id_usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') ORDER BY ID ASC) AS PRIMERA LEFT JOIN
  (SELECT
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _0_3_NINOS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _0_3_NINAS_N,
    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_0_3_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _4_5_NINOS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _4_5_NINAS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_4_5_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 1 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _6_NINOS_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 AND DT.Fk_Id_Genero = 2 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS _6_NINAS_N,
    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6  AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_6_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 10  AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS GESTANTES_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 60 AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_N,
   COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (1, 2, 3, 4, 5, 10, 12, 13, 14, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26) AND
   (SELECT E.DT_Fecha_Encuentro >= '2021-$id_mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$id_mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS ENFOQUE_N,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 1 then 1 END) AS _0_3_NINOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 2 then 1 END) AS _0_3_NINAS_R, 
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_0_3_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 1 then 1 END) AS _4_5_NINOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 2 then 1 END) AS _4_5_NINAS_R, 
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_4_5_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND DT.Fk_Id_Genero = 1 then 1 END) AS _6_NINOS_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 AND DT.Fk_Id_Genero = 2 then 1 END) AS _6_NINAS_R, 
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) = 6 then 1 END) AS TOTAL_6_R,
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 10 then 1 END) AS GESTANTES_R, 
   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 60 then 1 END) AS TOTAL_R,
   COUNT(CASE WHEN DT.IN_Grupo_Poblacional IN (1, 2, 3, 4, 5, 10, 12, 13, 14, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26) then 1 END) AS ENFOQUE_R,
   DT.Fk_Id_Experiencia AS IDEXPEREINCIA
   FROM (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,NA.Fk_Id_Experiencia, NA.Fk_Id_Beneficiario, BE.FK_Id_Genero
  FROM tb_nidos_asistencia NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
   where NA.Vc_Asistencia = '1'  AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')) DT GROUP BY Fk_Id_Experiencia
   UNION
   SELECT 
   BI.IN_Total_Ninos_0_3_Nuevos AS _0_3_NINOS_N,
   BI.IN_Total_Ninas_0_3_Nuevos AS _0_3_NINAS_N,
   SUM(BI.IN_Total_Ninos_0_3_Nuevos  + BI.IN_Total_Ninas_0_3_Nuevos) AS TOTAL_0_3_N,
   BI.IN_Total_Ninos_3_6_Nuevos AS _4_5_NINOS_N,
   BI.IN_Total_Ninas_0_3_Nuevos AS _4_5_NINAS_N,
   SUM(BI.IN_Total_Ninos_3_6_Nuevos  + BI.IN_Total_Ninas_0_3_Nuevos) AS TOTAL_4_5_N,
   BI.IN_Total_Ninos_6_Nuevos AS _6_NINOS_N,
   BI.IN_Total_Ninas_6_Nuevos AS _6_NINAS_N,
   SUM(BI.IN_Total_Ninos_6_Nuevos  + BI.IN_Total_Ninas_6_Nuevos) AS TOTAL_6_N,
   BI.IN_Mujeres_Gestantes_Nuevos AS GESTANTES_N,
   SUM(BI.IN_Total_Ninos_Nuevos  + BI.IN_Total_Ninas_Nuevos) AS TOTAL_N,
   SUM(BI.IN_Afrodescendiente_Nuevo + BI.IN_Campesina_Nuevo + BI.IN_Discapacidad_Nuevo + BI.IN_Conflicto_Nuevo + BI.IN_Indigena_Nuevo + BI.IN_Privados_Nuevo + BI.IN_Victimas_Nuevo + BI.IN_Raizal_Nuevo + BI.IN_Rom_Nuevo) AS ENFOQUE_N,
   BI.IN_Total_Ninos_0_3 AS _0_3_NINOS_R,
   BI.IN_Total_Ninas_0_3 AS _0_3_NINAS_R,
   SUM(BI.IN_Total_Ninos_0_3 + BI.IN_Total_Ninas_0_3) AS TOTAL_0_3_R,
   BI.IN_Total_Ninos_3_6 AS _4_5_NINOS_R,
   BI.IN_Total_Ninas_3_6 AS _4_5_NINAS_R,
   SUM(BI.IN_Total_Ninos_3_6 + BI.IN_Total_Ninas_3_6) AS TOTAL_4_5_R,
   BI.IN_Total_Ninos_6 AS _6_NINOS_R,
   BI.IN_Total_Ninas_6 AS _6_NINAS_R,
   SUM(BI.IN_Total_Ninos_6 + BI.IN_Total_Ninas_6),
   BI.IN_Mujeres_Gestantes AS TOTAL_6_R,
   SUM(BI.IN_Total_Ninos + BI.IN_Total_Ninas) AS TOTAL_R,
   SUM(BI.IN_Afrodescendiente + BI.IN_Campesina + BI.IN_Discapacidad + BI.IN_Conflicto + BI.IN_Indigena + BI.IN_Privados + BI.IN_Victimas + BI.IN_Raizal + BI.IN_Rom) AS ENFOQUE_R,
   BI.Fk_Id_Experiencia AS IDEXPEREINCIA
   FROM tb_nidos_beneficiario_sin_informacion AS BI
   GROUP BY IDEXPEREINCIA) AS SEGUNDA
   ON PRIMERA.ID = SEGUNDA.IDEXPEREINCIA";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_usuario', $id_usuario);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}
/**************** CONSULTAS CONSOLIDADO TERRITORIO **********/

public function ConsultarTotalesTerritorio($id_usuario) {
  $sql="SELECT COUNT(NA.Fk_Id_Beneficiario) AS 'ATENDIDOS',
  (SELECT COUNT(DISTINCT(NA.Fk_Id_Beneficiario))
  FROM tb_nidos_asistencia AS NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-02-25' AND '2021-12-25') AND EX.IN_Aprobacion = 1 AND NA.Vc_Asistencia = 1 AND DU.Fk_Id_Gestor = :usuario) AS 'UNICOS',
  (SELECT
  COUNT(CASE WHEN DT.Cantidad > 1 then 1 END)
  FROM (SELECT NA.Fk_Id_Beneficiario, COUNT(NA.Fk_Id_Beneficiario) AS Cantidad
  FROM tb_nidos_asistencia AS NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-02-25' AND '2021-12-25') AND EX.IN_Aprobacion = 1 AND NA.Vc_Asistencia = 1 AND DU.Fk_Id_Gestor = :usuario
  GROUP BY NA.Fk_Id_Beneficiario) DT) AS 'REPETIDOS',
  (SELECT COUNT(DISTINCT(NA.Fk_Id_Beneficiario))
FROM tb_nidos_asistencia AS NA
JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
JOIN tb_nidos_beneficiarios AS BE ON NA.Fk_Id_Beneficiario = BE.Pk_Id_Beneficiario
JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-02-25' AND '2021-12-25') AND EX.IN_Aprobacion = 1 AND NA.Vc_Asistencia = 1 AND DU.Fk_Id_Gestor = :usuario
 AND BE.VC_Uso_Imagen != 3 ) AS 'USODATOS',
  TE.Vc_Nom_Territorio AS 'TERRITORIO',
  TE.In_Meta AS 'META'
  FROM tb_nidos_asistencia AS NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  JOIN tb_nidos_persona_territorio AS PT ON DU.Fk_Id_Gestor = PT.Fk_Id_Persona
  JOIN tb_nidos_territorios AS TE ON PT.Fk_Id_Territorio = TE.Pk_Id_Territorio
  WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-02-25' AND '2021-12-25') AND EX.IN_Aprobacion = 1 AND NA.Vc_Asistencia = 1 AND DU.Fk_Id_Gestor = :usuario;";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultarTotalesMensualesTerritorio($id_usuario) {
  $sql="SELECT IDLOCALIDAD, LOCALIDAD, TOTAL_LUGAR, TOTAL_MAR, TOTAL_ABR, TOTAL_MAY, TOTAL_JUN, TOTAL_JUL, TOTAL_AGO, TOTAL_SEP, 
  TOTAL_OCT, TOTAL_NOV, TOTAL_DIC
  FROM 
   (
  (SELECT DISTINCT(LO.Pk_Id_Localidad) AS 'IDLOCALIDAD',
  LO.VC_Nom_Localidad AS 'LOCALIDAD'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
  WHERE DU.Fk_Id_Gestor = :usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 
  ORDER BY IDLOCALIDAD)
  UNION
  (SELECT DISTINCT(LO.Pk_Id_Localidad) AS 'IDLOCALIDAD',
  LO.VC_Nom_Localidad AS 'LOCALIDAD'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
  JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
  JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
  JOIN tb_nidos_entidades AS EN ON LA.Fk_Id_Entidad = EN.Pk_Id_Entidad
  WHERE DU.Fk_Id_Gestor = :usuario AND  (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente  != 3 
  ORDER BY IDLOCALIDAD)
  ) AS PRIMERA
  LEFT JOIN
   (SELECT 
  
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-03-25' THEN 1 END) AS 'TOTAL_MAR',
  COUNT(CASE WHEN DT.Fecha >= '2021-03-26' AND DT.Fecha <= '2021-04-25' THEN 1 END) AS 'TOTAL_ABR',
  COUNT(CASE WHEN DT.Fecha >= '2021-04-26' AND DT.Fecha <= '2021-05-25' THEN 1 END) AS 'TOTAL_MAY',
  COUNT(CASE WHEN DT.Fecha >= '2021-05-26' AND DT.Fecha <= '2021-06-25' THEN 1 END) AS 'TOTAL_JUN',
  COUNT(CASE WHEN DT.Fecha >= '2021-06-26' AND DT.Fecha <= '2021-07-25' THEN 1 END) AS 'TOTAL_JUL',
  COUNT(CASE WHEN DT.Fecha >= '2021-07-26' AND DT.Fecha <= '2021-08-25' THEN 1 END) AS 'TOTAL_AGO',
  COUNT(CASE WHEN DT.Fecha >= '2021-08-26' AND DT.Fecha <= '2021-09-25' THEN 1 END) AS 'TOTAL_SEP',
  COUNT(CASE WHEN DT.Fecha >= '2021-09-26' AND DT.Fecha <= '2021-10-25' THEN 1 END) AS 'TOTAL_OCT',
  COUNT(CASE WHEN DT.Fecha >= '2021-10-26' AND DT.Fecha <= '2021-11-25' THEN 1 END) AS 'TOTAL_NOV',
  COUNT(CASE WHEN DT.Fecha >= '2021-11-26' AND DT.Fecha <= '2021-12-25' THEN 1 END) AS 'TOTAL_DIC',
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-12-25' THEN 1 END) AS 'TOTAL_LUGAR',
  DT.Lugar AS 'LUGARDATOS'
  FROM (
  (SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Fecha',
  (SELECT L.Fk_Id_Localidad
  FROM tb_nidos_asistencia AS N
  LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_lugar_atencion AS L ON E.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar',
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Estrategia'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1  AND EX.IN_Componente != 3 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) = 1  ) 
    UNION
   (
  SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Fecha',
  (SELECT L.Fk_Id_Localidad
  FROM tb_nidos_asistencia AS N
  LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos AS G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  LEFT JOIN tb_nidos_lugar_atencion AS L ON G.Fk_Id_Lugar_Grupo_Laboratorio = L.Pk_Id_lugar_atencion
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar',
  (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) 'Estrategia'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND EX.IN_Componente  != 3 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) = 2) 
  ) DT GROUP BY Lugar
  ) AS SEGUNDA ON PRIMERA.IDLOCALIDAD = SEGUNDA.LUGARDATOS;";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

/**********************************   CONSULTA POR ENTIDAD  */
public function ConsultarTotalesMensualesEntidades($id_usuario) {
  $sql="SELECT IDENTIDAD, ENTIDAD, TOTAL_LUGAR, TOTAL_MAR, TOTAL_ABR, TOTAL_MAY, TOTAL_JUN, TOTAL_JUL, TOTAL_AGO, TOTAL_SEP, 
  TOTAL_OCT, TOTAL_NOV, TOTAL_DIC
  FROM 
   (
  (SELECT DISTINCT(EN.Pk_Id_Entidad) AS 'IDENTIDAD',
  EN.Vc_Abreviatura AS 'ENTIDAD'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_nidos_entidades AS EN ON LA.Fk_Id_Entidad = EN.Pk_Id_Entidad
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
  WHERE DU.Fk_Id_Gestor = :usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 
  ORDER BY ENTIDAD)
  UNION
  (SELECT DISTINCT(EN.Pk_Id_Entidad) AS 'IDENTIDAD',
  EN.Vc_Abreviatura AS 'ENTIDAD'
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
  JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
  JOIN tb_nidos_entidades AS EN ON LA.Fk_Id_Entidad = EN.Pk_Id_Entidad
  WHERE DU.Fk_Id_Gestor = :usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 
  ORDER BY ENTIDAD)
  ) AS PRIMERA
  LEFT JOIN
   (SELECT 
  
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-03-25' THEN 1 END) AS 'TOTAL_MAR',
  COUNT(CASE WHEN DT.Fecha >= '2021-03-26' AND DT.Fecha <= '2021-04-25' THEN 1 END) AS 'TOTAL_ABR',
  COUNT(CASE WHEN DT.Fecha >= '2021-04-26' AND DT.Fecha <= '2021-05-25' THEN 1 END) AS 'TOTAL_MAY',
  COUNT(CASE WHEN DT.Fecha >= '2021-05-26' AND DT.Fecha <= '2021-06-25' THEN 1 END) AS 'TOTAL_JUN',
  COUNT(CASE WHEN DT.Fecha >= '2021-06-26' AND DT.Fecha <= '2021-07-25' THEN 1 END) AS 'TOTAL_JUL',
  COUNT(CASE WHEN DT.Fecha >= '2021-07-26' AND DT.Fecha <= '2021-08-25' THEN 1 END) AS 'TOTAL_AGO',
  COUNT(CASE WHEN DT.Fecha >= '2021-08-26' AND DT.Fecha <= '2021-09-25' THEN 1 END) AS 'TOTAL_SEP',
  COUNT(CASE WHEN DT.Fecha >= '2021-09-26' AND DT.Fecha <= '2021-10-25' THEN 1 END) AS 'TOTAL_OCT',
  COUNT(CASE WHEN DT.Fecha >= '2021-10-26' AND DT.Fecha <= '2021-11-25' THEN 1 END) AS 'TOTAL_NOV',
  COUNT(CASE WHEN DT.Fecha >= '2021-11-26' AND DT.Fecha <= '2021-12-25' THEN 1 END) AS 'TOTAL_DIC',
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-12-25' THEN 1 END) AS 'TOTAL_LUGAR',
  DT.Lugar AS 'LUGARDATOS'
  FROM (
  (SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Fecha',
  (SELECT L.Fk_Id_Entidad
  FROM tb_nidos_asistencia AS N
  LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_lugar_atencion AS L ON E.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar',
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Estrategia'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1  AND EX.IN_Componente != 3 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) = 1  ) 
    UNION
   (
  SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Fecha',
  (SELECT L.Fk_Id_Entidad
  FROM tb_nidos_asistencia AS N
  LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos AS G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  LEFT JOIN tb_nidos_lugar_atencion AS L ON G.Fk_Id_Lugar_Grupo_Laboratorio = L.Pk_Id_lugar_atencion
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar',
  (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) 'Estrategia'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND EX.IN_Componente != 3 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) = 2) 
  ) DT GROUP BY Lugar
  ) AS SEGUNDA ON PRIMERA.IDENTIDAD = SEGUNDA.LUGARDATOS;";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

/************************   */
public function ConsultarTotalesDuplaTerritorio($id_usuario){
  $sql = "SELECT IDDUPLA, CODIGO, FEBRERO, MARZO, ABRIL, MAYO, JUNIO, JULIO, AGOSTO, SEPTIEMBRE, OCTUBRE, NOVIEMBRE, DICIEMBRE, TOTAL 
  FROM 
  (SELECT 
DU.Pk_Id_Dupla AS 'IDDUPLA',
DU.VC_Codigo_Dupla AS 'CODIGO'
FROM tb_nidos_dupla AS DU
WHERE DU.Fk_Id_Gestor = :id_usuario AND DU.IN_Estado = 1) AS PRIMERA LEFT JOIN
  (SELECT
   COUNT(CASE WHEN DT.Fecha >= '2021-01-26' AND DT.Fecha <= '2021-02-25' then 1 END) AS 'FEBRERO',
   COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-03-25' then 1 END) AS 'MARZO',
   COUNT(CASE WHEN DT.Fecha >= '2021-03-26' AND DT.Fecha <= '2021-04-25' then 1 END) AS 'ABRIL',
   COUNT(CASE WHEN DT.Fecha >= '2021-04-26' AND DT.Fecha <= '2021-05-25' then 1 END) AS 'MAYO',
   COUNT(CASE WHEN DT.Fecha >= '2021-05-26' AND DT.Fecha <= '2021-06-25' then 1 END) AS 'JUNIO',
   COUNT(CASE WHEN DT.Fecha >= '2021-06-26' AND DT.Fecha <= '2021-07-25' then 1 END) AS 'JULIO',
   COUNT(CASE WHEN DT.Fecha >= '2021-07-26' AND DT.Fecha <= '2021-08-25' then 1 END) AS 'AGOSTO',
   COUNT(CASE WHEN DT.Fecha >= '2021-08-26' AND DT.Fecha <= '2021-09-25' then 1 END) AS 'SEPTIEMBRE',
   COUNT(CASE WHEN DT.Fecha >= '2021-09-26' AND DT.Fecha <= '2021-10-25' then 1 END) AS 'OCTUBRE',
   COUNT(CASE WHEN DT.Fecha >= '2021-10-26' AND DT.Fecha <= '2021-11-25' then 1 END) AS 'NOVIEMBRE',
   COUNT(CASE WHEN DT.Fecha >= '2021-11-26' AND DT.Fecha <= '2021-12-25' then 1 END) AS 'DICIEMBRE',
	COUNT(CASE WHEN DT.Fecha >= '2021-01-26' AND DT.Fecha <= '2021-12-25' then 1 END) AS 'TOTAL',    
  DT.Dupla AS DUPLA
   FROM (SELECT  DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
	FROM tb_nidos_asistencia N 
	left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
	ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'Fecha',	
	(SELECT E.Fk_Id_Dupla
	FROM tb_nidos_asistencia N 
	left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
   where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
	ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'Dupla'
  FROM tb_nidos_asistencia NA
   JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
   JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
   JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
   WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND  (EX.DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-12-31')) DT GROUP BY Dupla) AS SEGUNDA
   ON PRIMERA.IDDUPLA = SEGUNDA.DUPLA";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_usuario', $id_usuario);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function ConsultarTotalesLugarTerritorio($id_usuario){
  $sql = "SELECT IDLUGAR, LOCALIDAD, LUGAR, ENTIDAD, TOTAL_LUGAR,  GRUPALES_MAR, LABORATORIO_MAR, TOTAL_MAR, GRUPALES_ABR, LABORATORIO_ABR, TOTAL_ABR, GRUPALES_MAY, LABORATORIO_MAY,
  TOTAL_MAY, GRUPALES_JUN, LABORATORIO_JUN, TOTAL_JUN, GRUPALES_JUL, LABORATORIO_JUL, TOTAL_JUL, GRUPALES_AGO, LABORATORIO_AGO, TOTAL_AGO, GRUPALES_SEP,
  LABORATORIO_SEP, TOTAL_SEP, GRUPALES_OCT, LABORATORIO_OCT, TOTAL_OCT, GRUPALES_NOV, LABORATORIO_NOV, TOTAL_NOV, GRUPALES_DIC, LABORATORIO_DIC, TOTAL_DIC
  FROM 
   (
    (SELECT DISTINCT(LA.Pk_Id_lugar_atencion) AS 'IDLUGAR',
LO.VC_Nom_Localidad AS 'LOCALIDAD',
EN.Vc_Abreviatura AS 'ENTIDAD',
LA.VC_Nombre_Lugar AS 'LUGAR' /* ,
(SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ',D.VC_Codigo_Dupla,' ')) SEPARATOR ',')
FROM tb_nidos_dupla AS D
JOIN tb_nidos_experiencia AS E ON D.Pk_Id_Dupla = E.Fk_Id_Dupla
WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion 
AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 ) AS 'DUPLA' */
FROM tb_nidos_experiencia AS EX
JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
JOIN tb_nidos_entidades AS EN ON LA.Fk_Id_Entidad = EN.Pk_Id_Entidad
WHERE DU.Fk_Id_Gestor = :id_usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 
ORDER BY LOCALIDAD, LUGAR)
UNION
(SELECT DISTINCT(GR.Fk_Id_Lugar_Grupo_Laboratorio) AS 'IDLUGAR',
LO.VC_Nom_Localidad AS 'LOCALIDAD',
EN.Vc_Abreviatura AS 'ENTIDAD',
LA.VC_Nombre_Lugar AS 'LUGAR' /* ,
(SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ',D.VC_Codigo_Dupla,' ')) SEPARATOR ',')
FROM tb_nidos_dupla AS D
JOIN tb_nidos_experiencia AS E ON D.Pk_Id_Dupla = E.Fk_Id_Dupla
WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion 
AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 ) AS 'DUPLA' */
FROM tb_nidos_experiencia AS EX
JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Grupo_Laboratorio = LA.Pk_Id_lugar_atencion
JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
JOIN tb_nidos_entidades AS EN ON LA.Fk_Id_Entidad = EN.Pk_Id_Entidad
WHERE DU.Fk_Id_Gestor = :id_usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25') AND IN_Aprobacion = 1 AND DU.IN_Estado = 1  AND EX.IN_Componente != 3 
ORDER BY LOCALIDAD, LUGAR)
) AS PRIMERA
  LEFT JOIN
   (SELECT 
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-03-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_MAR',
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-03-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_MAR', 
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-03-25' THEN 1 END) AS 'TOTAL_MAR',
  COUNT(CASE WHEN DT.Fecha >= '2021-03-26' AND DT.Fecha <= '2021-04-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_ABR',
  COUNT(CASE WHEN DT.Fecha >= '2021-03-26' AND DT.Fecha <= '2021-04-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_ABR', 
  COUNT(CASE WHEN DT.Fecha >= '2021-03-26' AND DT.Fecha <= '2021-04-25' THEN 1 END) AS 'TOTAL_ABR',
  COUNT(CASE WHEN DT.Fecha >= '2021-04-26' AND DT.Fecha <= '2021-05-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_MAY',
  COUNT(CASE WHEN DT.Fecha >= '2021-04-26' AND DT.Fecha <= '2021-05-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_MAY', 
  COUNT(CASE WHEN DT.Fecha >= '2021-04-26' AND DT.Fecha <= '2021-05-25' THEN 1 END) AS 'TOTAL_MAY',
  COUNT(CASE WHEN DT.Fecha >= '2021-05-26' AND DT.Fecha <= '2021-06-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_JUN',
  COUNT(CASE WHEN DT.Fecha >= '2021-05-26' AND DT.Fecha <= '2021-06-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_JUN', 
  COUNT(CASE WHEN DT.Fecha >= '2021-05-26' AND DT.Fecha <= '2021-06-25' THEN 1 END) AS 'TOTAL_JUN',
  COUNT(CASE WHEN DT.Fecha >= '2021-06-26' AND DT.Fecha <= '2021-07-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_JUL',
  COUNT(CASE WHEN DT.Fecha >= '2021-06-26' AND DT.Fecha <= '2021-07-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_JUL', 
  COUNT(CASE WHEN DT.Fecha >= '2021-06-26' AND DT.Fecha <= '2021-07-25' THEN 1 END) AS 'TOTAL_JUL',
  COUNT(CASE WHEN DT.Fecha >= '2021-07-26' AND DT.Fecha <= '2021-08-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_AGO',
  COUNT(CASE WHEN DT.Fecha >= '2021-07-26' AND DT.Fecha <= '2021-08-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_AGO', 
  COUNT(CASE WHEN DT.Fecha >= '2021-07-26' AND DT.Fecha <= '2021-08-25' THEN 1 END) AS 'TOTAL_AGO',
  COUNT(CASE WHEN DT.Fecha >= '2021-08-26' AND DT.Fecha <= '2021-09-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_SEP',
  COUNT(CASE WHEN DT.Fecha >= '2021-08-26' AND DT.Fecha <= '2021-09-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_SEP', 
  COUNT(CASE WHEN DT.Fecha >= '2021-08-26' AND DT.Fecha <= '2021-09-25' THEN 1 END) AS 'TOTAL_SEP',
  COUNT(CASE WHEN DT.Fecha >= '2021-09-26' AND DT.Fecha <= '2021-10-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_OCT',
  COUNT(CASE WHEN DT.Fecha >= '2021-09-26' AND DT.Fecha <= '2021-10-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_OCT', 
  COUNT(CASE WHEN DT.Fecha >= '2021-09-26' AND DT.Fecha <= '2021-10-25' THEN 1 END) AS 'TOTAL_OCT',
  COUNT(CASE WHEN DT.Fecha >= '2021-10-26' AND DT.Fecha <= '2021-11-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_NOV',
  COUNT(CASE WHEN DT.Fecha >= '2021-10-26' AND DT.Fecha <= '2021-11-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_NOV', 
  COUNT(CASE WHEN DT.Fecha >= '2021-10-26' AND DT.Fecha <= '2021-11-25' THEN 1 END) AS 'TOTAL_NOV',
  COUNT(CASE WHEN DT.Fecha >= '2021-11-26' AND DT.Fecha <= '2021-12-25' AND DT.Estrategia = 1 THEN 1 END) AS 'GRUPALES_DIC',
  COUNT(CASE WHEN DT.Fecha >= '2021-11-26' AND DT.Fecha <= '2021-12-25' AND DT.Estrategia = 2 THEN 1 END) AS 'LABORATORIO_DIC', 
  COUNT(CASE WHEN DT.Fecha >= '2021-11-26' AND DT.Fecha <= '2021-12-25' THEN 1 END) AS 'TOTAL_DIC',
  COUNT(CASE WHEN DT.Fecha >= '2021-02-26' AND DT.Fecha <= '2021-12-25' THEN 1 END) AS 'TOTAL_LUGAR',
  DT.Lugar AS 'LUGARDATOS'
  FROM (
  SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Fecha',	
  (SELECT E.Fk_Id_Lugar_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar',
   (SELECT G.FK_Id_Estrategia_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  LEFT JOIN tb_nidos_grupos G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Estrategia'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE DU.Fk_Id_Gestor = :id_usuario AND NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1  AND EX.IN_Componente != 3 AND (EX.DT_Fecha_Encuentro BETWEEN '2021-03-01' AND '2021-12-25')) DT GROUP BY Lugar
  ) AS SEGUNDA ON PRIMERA.IDLUGAR = SEGUNDA.LUGARDATOS;";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_usuario', $id_usuario);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultarPandoraTerritorio($id_usuario,$mes_consulta,$mes_anterior){
  $sql = "SELECT IDLUGAR, FECHA, MODALIDAD, ACTIVIDADES, LUGAR, AFORO, LOCALIDAD, UPZ, BARRIO, ARTISTAS, INSCRITOS, HOMBRES, MUJERES, TOTAL, PRIMERA, INFANCIA, ADOLESCENCIA, JUVENTUD, ADULTOS,
  MAYORES, CAMPESINOS, GESTANTES, ACTIVIDADES_SEXUALES, HABITANTES_CALLE, DISCAPACIDAD, PRIVADOS_LIBERTAD, PROFESIONALES_SECTOR, LGBTIQ, CONFLICTO_ARMADO, MIGRANTE,
  VICTIMAS_TRATA, SOCIAL_CATASTROFICA, DETERIORO_URBANO, VULNERABILIDAD, DESPLAZAMIENTO, SUSTANCIAS_PSICOACTIVAS, ROM_GITANO, PRORROM, INDIGENA, COMUNIDADES_NEGRAS,
  AFRODESCENDIENTE, PALENQUERAS, RAIZAL
  FROM 
   (SELECT DISTINCT(EX.DT_Fecha_Encuentro) AS 'FECHA',
  (SELECT GROUP_CONCAT(CONCAT(' ',EXP1.IN_Modalidad,' ') SEPARATOR ',')
  FROM tb_nidos_experiencia AS EXP1
  WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$mes_consulta-25' AND EXP1.IN_Aprobacion = 1 AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'MODALIDAD',
  (SELECT COUNT(EXP1.Pk_Id_Experiencia)
  FROM tb_nidos_experiencia AS EXP1
  WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$mes_consulta-25' AND EXP1.IN_Aprobacion = 1 AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'ACTIVIDADES',
  LA.Pk_Id_lugar_atencion AS 'IDLUGAR',
  LA.VC_Nombre_Lugar AS 'LUGAR',
  '20' AS 'AFORO',
  LO.VC_Nom_Localidad AS 'LOCALIDAD', CONCAT(UP.IN_Codigo_Upz,' ', UP.VC_Nombre_Upz) AS 'UPZ',
  LA.VC_Barrio AS 'BARRIO',
  (SELECT COUNT(DISTINCT(DU.Fk_Id_Persona))
  FROM tb_nidos_experiencia AS EXP1
  JOIN tb_nidos_dupla_artista AS DU ON EXP1.Fk_Id_Dupla = DU.Fk_Id_Dupla
  WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$mes_consulta-25' AND EXP1.IN_Aprobacion = 1 AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'ARTISTAS',
  (SELECT COUNT(DISTINCT(NA.Fk_Id_Beneficiario))
  FROM tb_nidos_asistencia AS NA
  JOIN tb_nidos_experiencia AS EXP1 ON NA.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
  WHERE NA.Vc_Asistencia = 1 AND EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'INSCRITOS'
  
  FROM tb_nidos_experiencia AS EX
  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
  JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
  LEFT JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
  JOIN tb_nidos_dupla AS DU ON DU.Pk_Id_Dupla = EX.Fk_Id_Dupla
  WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$mes_consulta-25') AND IN_Aprobacion = 1 AND DU.Fk_Id_Gestor = :id_usuario AND DU.IN_Estado = 1
  ORDER BY LUGAR, FECHA) AS PRIMERA
  LEFT JOIN
   (SELECT 
  COUNT(CASE WHEN DT.Fecha >= '2021-$mes_anterior-26' AND DT.Fecha <= '2021-$mes_consulta-25' AND DT.FK_Id_Genero = 1 THEN 1 END) AS 'HOMBRES',
  COUNT(CASE WHEN DT.Fecha >= '2021-$mes_anterior-26' AND DT.Fecha <= '2021-$mes_consulta-25' AND DT.FK_Id_Genero = 2 THEN 1 END) AS 'MUJERES', 
  COUNT(CASE WHEN DT.Fecha >= '2021-$mes_anterior-26' AND DT.Fecha <= '2021-$mes_consulta-25' THEN 1 END) AS 'TOTAL',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) <= 5 then 1 END) AS 'PRIMERA',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 6 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) <= 12 then 1 END) AS 'INFANCIA',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 13 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) <= 17 then 1 END) AS 'ADOLESCENCIA',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 18 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) <= 28 then 1 END) AS 'JUVENTUD',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 29 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) <= 59 then 1 END) AS 'ADULTOS',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 60 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) <= 100 then 1 END) AS 'MAYORES',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS 'CAMPESINOS',
  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,Fecha) >= 10 AND DT.FK_Id_Genero = 2 then 1 END) AS 'GESTANTES',    
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 18 then 1 END) AS 'ACTIVIDADES_SEXUALES',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 12 then 1 END) AS 'HABITANTES_CALLE',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS 'DISCAPACIDAD',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS 'PRIVADOS_LIBERTAD',
  '0' AS 'PROFESIONALES_SECTOR',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 22 then 1 END) AS 'LGBTIQ',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS 'CONFLICTO_ARMADO',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 19 then 1 END) AS 'MIGRANTE',
  '0' AS 'VICTIMAS_TRATA',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 23  then 1 END) AS 'SOCIAL_CATASTROFICA',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 20  then 1 END) AS 'DETERIORO_URBANO',
  '0' AS 'VULNERABILIDAD',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 26 then 1 END) AS 'DESPLAZAMIENTO',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 24  then 1 END) AS 'SUSTANCIAS_PSICOACTIVAS',
  
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2  then 1 END) AS 'ROM_GITANO',
  '0' AS 'PRORROM',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS 'INDIGENA',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 25 then 1 END) AS 'COMUNIDADES_NEGRAS',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS 'AFRODESCENDIENTE',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 21 then 1 END) AS 'PALENQUERAS',
  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13  then 1 END) AS 'RAIZAL',
   DT.Fecha AS 'FECHADATOS',
   DT.Lugar AS 'LUGARDATOS'
  FROM (SELECT DISTINCT(NA.Fk_Id_Beneficiario), BE.DD_F_Nacimiento,BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
   (SELECT E.DT_Fecha_Encuentro
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Fecha',	
    (SELECT E.Fk_Id_Lugar_Atencion
  FROM tb_nidos_asistencia N
  LEFT JOIN tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
  WHERE N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021
  ORDER BY E.DT_Fecha_Encuentro ASC
  LIMIT 1) AS 'Lugar'
  FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND DU.Fk_Id_Gestor = :id_usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes_anterior-26' AND '2021-$mes_consulta-25')) DT GROUP BY Fecha, Lugar) AS SEGUNDA ON PRIMERA.FECHA = SEGUNDA.FECHADATOS AND PRIMERA.IDLUGAR = SEGUNDA.LUGARDATOS";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_usuario', $id_usuario);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getBeneficiariosEnfoque($idExpeEnfoque){
  $sql = "SELECT BE.VC_Identificacion AS 'IDENTIFICACION', 
  CONCAT(BE.VC_Primer_Nombre,' ',BE.VC_Segundo_Nombre,' ',BE.VC_Primer_Apellido,' ',BE.VC_Segundo_Apellido) AS 'BENEFICIARIO',
  (CASE WHEN BE.FK_Id_Genero = '1' THEN 'Masculino' WHEN BE.FK_Id_Genero = 2 THEN 'Femenino' END) AS 'GENERO',
  BE.DD_F_Nacimiento AS 'NACIMIENTO',
  PD.VC_Descripcion AS 'ENFOQUE'
  FROM tb_nidos_asistencia AS NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON NA.Fk_Id_Beneficiario = BE.Pk_Id_Beneficiario
  JOIN tb_parametro_detalle AS PD ON BE.IN_Grupo_Poblacional = PD.FK_Value AND PD.FK_Id_Parametro = 14
  WHERE EX.Pk_Id_Experiencia = :id_experiencia AND NA.Vc_Asistencia = 1 AND BE.IN_Grupo_Poblacional != 6 AND BE.IN_Grupo_Poblacional > 0";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_experiencia', $idExpeEnfoque);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

}


public function ConsultarTotalesEntidadTerritorio($id_usuario) {
  $sql="SELECT
  COUNT(CASE WHEN DT.Lugar = 1 then 1 END) AS 'ICBF',
  COUNT(CASE WHEN DT.Lugar = 2 then 1 END) AS 'PRIVADA',
  COUNT(CASE WHEN DT.Lugar = 3 then 1 END) AS 'SED',
  COUNT(CASE WHEN DT.Lugar = 4 then 1 END) AS 'SDIS',
  COUNT(CASE WHEN DT.Lugar = 5 then 1 END) AS 'IDARTES',
  COUNT(CASE WHEN DT.Lugar = 6 then 1 END) AS 'GRC',
  COUNT(CASE WHEN DT.Lugar = 7 then 1 END) AS 'SM',   
  DT.Territorio AS TERRITORIO
  FROM (SELECT  DISTINCT(NA.Fk_Id_Beneficiario),BE.IN_Grupo_Poblacional,BE.FK_Id_Genero,
  (SELECT L.Fk_Id_Entidad
 FROM tb_nidos_asistencia AS N 
 LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
 LEFT JOIN tb_nidos_lugar_atencion AS L ON E.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion
  where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'Lugar',
 DU.Fk_Id_Territorio AS 'Territorio'
 FROM tb_nidos_asistencia NA
  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
  JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
  JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
  WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND DU.Fk_Id_Gestor = :usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-01-26' AND '2021-12-25')) DT GROUP BY Territorio";
  @$sentencia=$this->dbPDO->prepare($sql);
  @$sentencia->bindParam(':usuario',$id_usuario);
  $sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function ConsultarListadoBeneficiariosTerritorio($id_usuario){
  $sql = "SELECT DISTINCT(NA.Fk_Id_Beneficiario) AS 'IDBENEFICIARIO', 
  BE.VC_Identificacion AS 'IDENTIFICACION',
  PDI.VC_Descripcion AS 'TIPO_IDENTIFI',
  CONCAT(BE.VC_Primer_Nombre,' ',BE.VC_Segundo_Nombre,' ',BE.VC_Primer_Apellido,' ',BE.VC_Segundo_Apellido) AS 'BENEFICIARIO',
  (CASE WHEN BE.FK_Id_Genero = '1' THEN 'Masculino' WHEN BE.FK_Id_Genero = '2' THEN 'Femenino' END) AS 'GENERO', 
  PD.VC_Descripcion AS 'ENFOQUE',
  (CASE WHEN BE.VC_Uso_Imagen != 3 THEN 'NO TIENE ' WHEN BE.VC_Uso_Imagen IS NOT NULL THEN 'SI TIENE' END) AS 'USO_IMAGEN',
  (SELECT D.VC_Codigo_Dupla
    FROM tb_nidos_asistencia AS N 
    LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia 
    JOIN tb_nidos_dupla AS D ON E.Fk_Id_Dupla = D.Pk_Id_Dupla
     where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
    ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'DUPLA',	
  (SELECT L.VC_Nombre_Lugar
    FROM tb_nidos_asistencia AS N 
    LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
    LEFT JOIN tb_nidos_lugar_atencion AS L ON E.Fk_Id_Lugar_Atencion = L.Pk_Id_lugar_atencion
     where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
    ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'LUGAR',	
    (SELECT G.VC_Nombre_Grupo
    FROM tb_nidos_asistencia AS N 
    LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
    LEFT JOIN tb_nidos_grupos AS G ON E.Fk_Id_Grupo = G.Pk_Id_Grupo
     where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
    ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'GRUPO',	
    (SELECT E.DT_Fecha_Encuentro
    FROM tb_nidos_asistencia AS N 
    LEFT JOIN tb_nidos_experiencia AS E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
     where N.Fk_Id_Beneficiario = NA.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 
    ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) AS 'FECHA'
    FROM tb_nidos_asistencia NA
     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
     JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
     JOIN tb_parametro_detalle AS PD ON BE.IN_Grupo_Poblacional = PD.FK_Value AND PD.FK_Id_Parametro = 14
     JOIN tb_parametro_detalle AS PDI ON BE.FK_Tipo_Identificacion = PDI.FK_Value AND PDI.FK_Id_Parametro = 5
     JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
     WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND DU.Fk_Id_Gestor = :id_usuario AND (EX.DT_Fecha_Encuentro BETWEEN '2021-01-26' AND '2021-12-25')";  
  @$sentencia=$this->dbPDO->prepare($sql);  
  @$sentencia->bindParam(':id_usuario', $id_usuario);  
  @$sentencia->execute();
  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

}

