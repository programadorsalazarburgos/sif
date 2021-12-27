<?php 

namespace General\Persistencia\DAOS;


class NidosConsultaGeneralDAO extends GestionDAO {

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
        return;
    }


    public function consultarObjeto($objeto) {
          return;
    }

    public function consultarTerritorios() {
     $sql="SELECT * FROM tb_nidos_territorios";
     $sentencia=$this->dbPDO->prepare($sql);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function contarLugaresAtencionTerritorio($id_territorio){
     $sql="SELECT COUNT(Pk_Id_lugar_atencion) AS total_lugares from tb_nidos_lugar_atencion L left join tb_nidos_terri_locali T ON T.Fk_Id_Localidad = L.Fk_Id_Localidad where L.IN_Estado = '1' AND T.Fk_Id_Territorio = :id_territorio";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function contarDuplasTerritorio($id_territorio){
     $sql="SELECT COUNT(Pk_Id_Dupla) AS total_duplas from tb_nidos_dupla as D where D.IN_Estado = '1' AND D.Fk_Id_Territorio = :id_territorio";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function contarGruposTerritorio($id_territorio){
     $sql="SELECT COUNT(Pk_Id_Grupo) AS total_grupos from tb_nidos_grupos G left join tb_nidos_dupla D ON G.Fk_Id_Dupla = D.Pk_Id_Dupla where G.IN_Estado = '1' AND D.Fk_Id_Territorio = :id_territorio";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function contarBeneficiariosTerritorio($id_territorio){
     $sql="SELECT
     COUNT(*) AS total_beneficiarios
     FROM tb_nidos_beneficiario_grupo AS BG
     JOIN tb_nidos_beneficiarios AS B ON B.Pk_Id_Beneficiario=BG.Fk_Id_Beneficiario
     JOIN tb_nidos_grupos AS G ON G.Pk_Id_Grupo=BG.Fk_Id_Grupo
     JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
     JOIN tb_nidos_terri_locali AS TL ON TL.Fk_Id_Localidad=LA.Fk_Id_Localidad
     WHERE TL.Fk_Id_Territorio=:id_territorio";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function infoLugaresTerritorio($id_territorio){
     $sql="SELECT
     U.VC_Nombre_Upz AS 'Upz',
     LA.VC_Barrio AS 'Barrio',
     LA.VC_Nombre_Lugar AS 'Lugar',
     E.Vc_Nom_Entidad AS 'Entidad',
     TLU.Vc_Descripcion AS 'Tipo',
     LA.VC_Direccion AS 'Dirección',
     LA.VC_Telefono AS 'Teléfono',
     LA.VC_Coordinador AS 'Coordinador',
     LA.VC_Email AS 'Email'
     FROM tb_nidos_lugar_atencion AS LA
     JOIN tb_upz AS U ON U.Pk_Id_Upz=LA.Fk_Id_Upz
     JOIN tb_nidos_entidades AS E ON E.Pk_Id_Entidad=LA.Fk_Id_Entidad
     JOIN tb_nidos_tipo_lugar AS TLU ON TLU.Pk_Id_Lugar=LA.VC_Tipo_Lugar
     JOIN tb_nidos_terri_locali AS TL ON TL.Fk_Id_Localidad=LA.Fk_Id_Localidad
     WHERE TL.Fk_Id_Territorio=:id_territorio";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

    public function ConsultarNomTerritorio($id_usuario) {
      $sql="SELECT NT.Pk_Id_Territorio, NT.Vc_Nom_Territorio
      FROM tb_nidos_persona_territorio PT, tb_nidos_territorios NT
      WHERE NT.Pk_Id_Territorio = PT.Fk_Id_Territorio AND PT.IN_Estado = 1 AND  PT.Fk_Id_Persona = :usuario";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':usuario',$id_usuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
     }

   public function infoDuplasTerritorio($id_territorio){
     $sql="SELECT
     D.VC_Codigo_Dupla 'Código de la dupla',
     GROUP_CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ', P.VC_Segundo_Apellido SEPARATOR ' Y ') AS 'Artistas'
     FROM tb_nidos_dupla_artista AS DA
     JOIN tb_nidos_dupla AS D ON D.Pk_Id_Dupla=DA.Fk_Id_Dupla
     JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
     WHERE D.Fk_Id_Territorio=:id_territorio
     GROUP BY DA.Fk_Id_Dupla";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }
   public function infoGruposTerritorio($id_territorio){
     $sql="SELECT
     E.Vc_Estrategia  AS 'Tipo de estrategia',
     LA.VC_Nombre_Lugar  AS 'Lugar',
     G.VC_Nombre_grupo  AS 'Grupo',
     GROUP_CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido SEPARATOR ' Y ') AS 'Dupla de artistas',
     G.VC_Profesional_Responsable  AS 'Responsable del grupo',
     CASE
     WHEN G.IN_Estado = '0' THEN 'Inactivo'
     WHEN G.IN_Estado = '1' THEN 'Activo'
     END AS 'Estado',
     (SELECT
     CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido)
     FROM tb_persona_2017 AS P
     WHERE P.PK_Id_Persona=G.Fk_Id_Usuario_Creacion) AS 'Artista creador del grupo'
     FROM tb_nidos_grupos AS G
     JOIN tb_nidos_estrategia AS E ON E.Pk_Id_Estrategia=G.FK_Id_Estrategia_Atencion
     JOIN tb_nidos_dupla_artista AS DA ON DA.Fk_Id_Dupla=G.Fk_Id_Dupla
     JOIN tb_persona_2017 AS P ON P.PK_Id_Persona=DA.Fk_Id_Persona
     JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
     JOIN tb_nidos_terri_locali AS TL ON TL.Fk_Id_Localidad=LA.Fk_Id_Localidad
     WHERE TL.Fk_Id_Territorio=:id_territori
     GROUP BY G.Pk_Id_Grupo";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
   }

   public function infoBeneficiariosTerritorio($id_territorio){
     $sql="SELECT
     TD.VC_Descripcion AS 'Tipo de documento',
     B.VC_Identificacion AS 'Número de identificación',
     CONCAT(B.VC_Primer_Nombre,' ',B.VC_Segundo_Nombre,' ',B.VC_Primer_Apellido,' ',B.VC_Segundo_Apellido) AS 'Nombre',
     DATE_FORMAT(B.DD_F_Nacimiento, '%Y/%m/%d') AS 'Fecha de nacimiento',
     GE.VC_Descripcion AS 'Sexo',
     ET.VC_Descripcion AS 'Grupo poblacional',
     B.IN_Estrato AS 'Estrato'
     FROM tb_nidos_beneficiario_grupo AS BG
     JOIN tb_nidos_beneficiarios AS B ON B.Pk_Id_Beneficiario=BG.Fk_Id_Beneficiario
     JOIN tb_parametro_detalle AS TD ON TD.FK_Value=B.FK_Tipo_Identificacion AND TD.FK_Id_Parametro='5'
     JOIN tb_parametro_detalle AS GE ON GE.FK_Value=B.FK_Id_Genero AND GE.FK_Id_Parametro='17'
     JOIN tb_parametro_detalle AS ET ON ET.FK_Value=B.IN_Grupo_Poblacional AND ET.FK_Id_Parametro='14'
     JOIN tb_nidos_grupos AS G ON G.Pk_Id_Grupo=BG.Fk_Id_Grupo
     JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=G.Fk_Id_Lugar_Atencion
     JOIN tb_nidos_terri_locali AS TL ON TL.Fk_Id_Localidad=LA.Fk_Id_Localidad
     WHERE TL.Fk_Id_Territorio=:id_territorio";
     $sentencia=$this->dbPDO->prepare($sql);
     @$sentencia->bindParam(':id_territorio',$id_territorio);
     $sentencia->execute();
     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

   }

   /* ---------------------- CONSULTAS información por dupla */
    public function consultarDuplasTerritorios($id_usuario) {
      $sql="SELECT ND.Pk_Id_Dupla, ND.VC_Codigo_Dupla,
      (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido,' ') )
      FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
      WHERE DA.Fk_Id_Dupla = ND.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona)  AS 'ARTISTAS',
      TD.Vc_Descripcion
      FROM tb_nidos_dupla  AS ND
      JOIN tb_nidos_tipo_dupla AS TD ON ND.Fk_Id_Tipo_Dupla = TD.Pk_Id_Tipo_dupla
      LEFT JOIN tb_nidos_territorios AS T ON ND.Fk_Id_Territorio = T.Pk_Id_Territorio
      WHERE ND.IN_Estado = 1 AND ND.Fk_Id_Gestor = :usuario";
      @$sentencia=$this->dbPDO->prepare($sql);
      @$sentencia->bindParam(':usuario',$id_usuario);
      $sentencia->execute();
      return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

         public function contarGruposDupla($id_dupla){
           $sql="select COUNT(Pk_Id_Grupo) AS total_grupos1 from tb_nidos_grupos where IN_Estado = '1' AND Fk_Id_Dupla = :id_dupla";
           $sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':id_dupla',$id_dupla);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

         public function contarExperienciasDupla($id_dupla){
           $sql="select COUNT(Pk_Id_Experiencia) AS total_experiencia from tb_nidos_experiencia where Fk_Id_Dupla = :id_dupla";
           $sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':id_dupla',$id_dupla);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

         public function contarBeneficiariosDupla($id_dupla){
           $sql="SELECT COUNT(Pk_Id_Benefi_Grupo) AS total_beneficiarios from tb_nidos_beneficiario_grupo AS BG JOIN tb_nidos_grupos G ON BG.Fk_Id_Grupo = G.Pk_Id_Grupo WHERE BG.IN_Estado = 1 AND G.Fk_Id_Dupla = :id_dupla";
           $sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':id_dupla',$id_dupla);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

         public function consultarArtistasDuplas($id_dupla){
           $sql="SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Segundo_Nombre,' ',PER.VC_Primer_Apellido,' ',PER.VC_Segundo_Apellido,' ') SEPARATOR 'Y' ) AS 'ARTISTAS'
           FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER
           WHERE DA.Fk_Id_Persona = PER.PK_Id_Persona AND IN_Estado = '1' AND DA.Fk_Id_Dupla = :id_dupla";
           $sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':id_dupla',$id_dupla);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

          public function contultaTablaGruposDupla($id_dupla){
            $sql="SELECT
            G.Pk_Id_Grupo,
            E.Vc_Nom_Entidad,
            TP.Vc_Descripcion,
            LA.VC_Nombre_Lugar,
            G.VC_Nombre_Grupo,
            (select COUNT(E.Pk_Id_Experiencia) from tb_nidos_experiencia E where G.Pk_Id_Grupo = E.Fk_Id_Grupo) AS 'EXPERIENCIA',
            (select COUNT(BG.Pk_Id_Benefi_Grupo) from tb_nidos_beneficiario_grupo BG where G.Pk_Id_Grupo = BG.Fk_Id_Grupo) AS 'BENEFICIARIOS',
            (select COUNT(Pk_Id_Asistencia) FROM tb_nidos_asistencia NA, tb_nidos_experiencia EX where EX.Pk_Id_Experiencia = NA.Fk_Id_Experiencia AND Vc_Asistencia = '1' AND G.Pk_Id_Grupo = EX.Fk_Id_Grupo) AS 'ASISTENCIA'
            FROM tb_nidos_grupos AS G
            JOIN tb_nidos_lugar_atencion AS LA ON G.Fk_Id_Lugar_Atencion = LA.Pk_Id_Lugar_atencion
            JOIN tb_nidos_entidades AS E ON E.Pk_Id_Entidad = LA.Fk_Id_Entidad
            JOIN tb_nidos_tipo_lugar AS TP ON TP.Pk_Id_Lugar = LA.VC_Tipo_Lugar
            WHERE G.IN_Estado = '1' AND G.Fk_Id_Dupla = :id_dupla";
            $sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':id_dupla',$id_dupla);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
          }

  /******************** CONSULTAS DE LA ACTIVIDAD ENCUENTROS GRUPLAES **************/

            public function consultarMesParametro() {
              $sql="SELECT Fk_Value, VC_Descripcion FROM tb_parametro_detalle WHERE FK_Id_Parametro = '8'";
              $sentencia=$this->dbPDO->prepare($sql);
              $sentencia->execute();
              return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            }

            /* ---------------------- CONSULTAS información por dupla */
             public function consultarDuplasTerritoriales($id_usuario) {
               $sql="SELECT ND.Pk_Id_Dupla, ND.VC_Codigo_Dupla, TD.Vc_Descripcion
                     FROM tb_nidos_dupla  AS ND
                     JOIN tb_nidos_tipo_dupla AS TD ON ND.Fk_Id_Tipo_Dupla = TD.Pk_Id_Tipo_dupla
                     LEFT JOIN tb_nidos_territorios AS T ON ND.Fk_Id_Territorio = T.Pk_Id_Territorio
                     WHERE ND.IN_Estado = 1 AND ND.Fk_Id_Gestor = :usuario  ORDER BY ND.VC_Codigo_Dupla";
               @$sentencia=$this->dbPDO->prepare($sql);
               @$sentencia->bindParam(':usuario',$id_usuario);
               $sentencia->execute();
               return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
             }

             public function contarGruposAtendidosMes($id_dupla, $mes){
               $sql="SELECT COUNT(DISTINCT Fk_Id_Grupo) AS GRUPOS FROM tb_nidos_experiencia where Fk_Id_Dupla = :id_dupla AND (DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND IN_Aprobacion = '1'";
               $sentencia=$this->dbPDO->prepare($sql);
               @$sentencia->bindParam(':id_dupla',$id_dupla);
                $sentencia->execute();
               return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
             }

             public function contarAtencionesMes($id_dupla, $mes){
               $sql="SELECT COUNT(Pk_Id_Experiencia) AS ATENCIONES FROM tb_nidos_experiencia where Fk_Id_Dupla = :id_dupla AND (DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND IN_Aprobacion = '1'";
               $sentencia=$this->dbPDO->prepare($sql);
               @$sentencia->bindParam(':id_dupla',$id_dupla);
                $sentencia->execute();
               return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
             }

             public function contarBeneficiariosMes($id_dupla, $mes){
               $sql="SELECT COUNT(Pk_Id_Asistencia) AS BENEFICIARIOS
               FROM tb_nidos_asistencia AS NA
               JOIN tb_nidos_experiencia AS NE ON NA.Fk_Id_Experiencia = NE.Pk_Id_Experiencia
               WHERE NA.Vc_Asistencia = '1' AND NE.Fk_Id_Dupla = :id_dupla AND (NE.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND NE.IN_Aprobacion = '1'";
               $sentencia=$this->dbPDO->prepare($sql);
               @$sentencia->bindParam(':id_dupla',$id_dupla);
                $sentencia->execute();
               return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
             }

             public function contultaTablaGruposLinea($id_dupla, $mes){
               $sql="SELECT 'GRUPOS', SUM(A) AS 'SDIS_FAMILIAR' ,SUM(B) AS 'ICBF_FAMILIAR',SUM(C)  AS 'SDIS_INSTITUCIONAL',SUM(D)  AS 'ICBF_INSTITUCIONAL',SUM(E)  AS 'LABORATORIOS',SUM(F) AS 'TOTAL' FROM (
                 SELECT COUNT(DISTINCT EX.Fk_Id_Grupo) AS 'A', 0 AS 'B', 0 AS 'C', 0 AS 'D', 0 AS 'E', 0 AS 'F'
                 FROM tb_nidos_experiencia AS EX
                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                 WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '4' AND LA.VC_Tipo_Lugar = '1' AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                 UNION ALL
                 SELECT 0, COUNT(DISTINCT EX.Fk_Id_Grupo),0,0,0,0
                 FROM tb_nidos_experiencia AS EX
                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                 WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '1' AND LA.VC_Tipo_Lugar = '1'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                 UNION ALL
                 SELECT 0,0,COUNT(DISTINCT EX.Fk_Id_Grupo),0,0,0
                 FROM tb_nidos_experiencia AS EX
                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                 WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '4' AND LA.VC_Tipo_Lugar = '2'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                 UNION ALL
                 SELECT 0,0,0,COUNT(DISTINCT EX.Fk_Id_Grupo),0,0
                 FROM tb_nidos_experiencia AS EX
                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                 WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '1' AND LA.VC_Tipo_Lugar = '2'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                 UNION ALL
                 SELECT 0,0,0,0,COUNT(DISTINCT EX.Fk_Id_Grupo),0
                 FROM tb_nidos_experiencia AS EX
                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                 WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.VC_Tipo_Lugar IN ('4','6') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                 UNION ALL
                 SELECT 0,0,0,0,0,COUNT(DISTINCT EX.Fk_Id_Grupo)
                 FROM tb_nidos_experiencia AS EX
                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                 WHERE EX.Fk_Id_Dupla = :id_dupla AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1') AS dt
                 UNION ALL
                 SELECT 'ATENCIONES', SUM(A) AS 'SDIS_FAMILIAR' ,SUM(B) AS 'ICBF_FAMILIAR',SUM(C)  AS 'SDIS_INSTITUCIONAL',SUM(D)  AS 'ICBF_INSTITUCIONAL',SUM(E)  AS 'LABORATORIOS',SUM(F) AS 'TOTAL' FROM (
                   SELECT COUNT(EX.Fk_Id_Grupo) AS 'A',0 AS 'B',0 AS 'C',0 AS 'D',0 AS 'E',0 AS 'F'
                   FROM tb_nidos_experiencia AS EX
                   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                   WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '4' AND LA.VC_Tipo_Lugar = '1'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                   UNION ALL
                   SELECT 0,COUNT(EX.Fk_Id_Grupo),0,0,0,0
                   FROM tb_nidos_experiencia AS EX
                   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                   WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '1' AND LA.VC_Tipo_Lugar = '1'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                   UNION ALL
                   SELECT 0,0,COUNT(EX.Fk_Id_Grupo),0,0,0
                   FROM tb_nidos_experiencia AS EX
                   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                   WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '4' AND LA.VC_Tipo_Lugar = '2'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                   UNION ALL
                   SELECT 0,0,0,COUNT(EX.Fk_Id_Grupo),0,0
                   FROM tb_nidos_experiencia AS EX
                   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                   WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '1' AND LA.VC_Tipo_Lugar = '2'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                   UNION ALL
                   SELECT 0,0,0,0,COUNT(EX.Fk_Id_Grupo),0
                   FROM tb_nidos_experiencia AS EX
                   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                   WHERE EX.Fk_Id_Dupla = :id_dupla AND LA.VC_Tipo_Lugar IN ('4','6') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                   UNION ALL
                   SELECT 0,0,0,0,0,COUNT(EX.Fk_Id_Grupo)
                   FROM tb_nidos_experiencia AS EX
                   JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                   WHERE EX.Fk_Id_Dupla = :id_dupla AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1') AS dt
                   UNION ALL
                   SELECT 'BENEFICIARIOS', SUM(A) AS 'SDIS_FAMILIAR' ,SUM(B) AS 'ICBF_FAMILIAR',SUM(C)  AS 'SDIS_INSTITUCIONAL',SUM(D)  AS 'ICBF_INSTITUCIONAL',SUM(E)  AS 'LABORATORIOS',SUM(F) AS 'TOTAL' FROM (
                     SELECT COUNT(Pk_Id_Asistencia) AS 'A',0 as 'B',0 as 'C',0 as 'D',0 as 'E',0 as 'F'
                     FROM tb_nidos_asistencia AS NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     WHERE NA.Vc_Asistencia = '1' AND EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '4' AND LA.VC_Tipo_Lugar = '1'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                     UNION ALL
                     SELECT 0,COUNT(Pk_Id_Asistencia),0,0,0,0
                     FROM tb_nidos_asistencia AS NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     WHERE NA.Vc_Asistencia = '1' AND EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '1' AND LA.VC_Tipo_Lugar = '1'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                     UNION ALL
                     SELECT 0,0,COUNT(Pk_Id_Asistencia),0,0,0
                     FROM tb_nidos_asistencia AS NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     WHERE NA.Vc_Asistencia = '1' AND EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '4' AND LA.VC_Tipo_Lugar = '2'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                     UNION ALL
                     SELECT 0,0,0,COUNT(Pk_Id_Asistencia),0,0
                     FROM tb_nidos_asistencia AS NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     WHERE NA.Vc_Asistencia = '1' AND EX.Fk_Id_Dupla = :id_dupla AND LA.Fk_Id_Entidad = '1' AND LA.VC_Tipo_Lugar = '2'AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                     UNION ALL
                     SELECT 0,0,0,0,COUNT(Pk_Id_Asistencia),0
                     FROM tb_nidos_asistencia AS NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     WHERE NA.Vc_Asistencia = '1' AND EX.Fk_Id_Dupla = :id_dupla AND LA.VC_Tipo_Lugar IN ('4','6') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                     UNION ALL
                     SELECT 0,0,0,0,0,COUNT(Pk_Id_Asistencia)
                     FROM tb_nidos_asistencia AS NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     WHERE NA.Vc_Asistencia = '1' AND EX.Fk_Id_Dupla = :id_dupla AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1') AS dt";
                     $sentencia=$this->dbPDO->prepare($sql);
                     @$sentencia->bindParam(':id_dupla',$id_dupla);
                     $sentencia->execute();
                     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                   }


                   public function detalleGruposAtendidos($id_dupla, $mes){
                     $sql="SELECT  LA.Pk_Id_lugar_atencion, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar
                     FROM tb_nidos_grupos AS GR
                     JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                     JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                     JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                     JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                     where GR.Fk_Id_Dupla = $id_dupla";
                     $sentencia=$this->dbPDO->prepare($sql);
                     @$sentencia->bindParam(':id_dupla',$id_dupla);
                     $sentencia->execute();
                     return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                   }

                   public function InfoAtencionesXlugarDupla($id_dupla, $mes){
                     $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), TIPO, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                     COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                     COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                       SELECT DISTINCT(Pk_Id_lugar_atencion), CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                       (SELECT COUNT(E.Pk_Id_Experiencia) FROM tb_nidos_experiencia E WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                       (SELECT COUNT(NA.Fk_Id_Beneficiario)
                       FROM tb_nidos_asistencia AS NA
                       JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                       WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                       AND NA.Vc_Asistencia = '1' AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EXP.IN_Aprobacion = '1')AS 'ASISTENTES'
                       FROM tb_nidos_grupos AS GR
                       JOIN tb_nidos_experiencia AS EX ON GR.Pk_Id_Grupo =  EX.Fk_Id_Grupo
                       JOIN tb_nidos_lugar_atencion AS LA ON GR.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                       JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                       JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                       JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                       JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                       where GR.Fk_Id_Dupla = $id_dupla AND GR.IN_Estado = 1 AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1') AS PRIMERA left JOIN
                       ( SELECT
                         COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                         COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,BE.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
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
                         EX.Fk_Id_Lugar_Atencion
                         FROM tb_nidos_asistencia NA
                         JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                         JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                         where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                         GROUP BY EX.Fk_Id_Lugar_Atencion) AS SEGUNDA ON 	PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                         $sentencia=$this->dbPDO->prepare($sql);
                         @$sentencia->bindParam(':id_dupla',$id_dupla);
                         $sentencia->execute();
                         return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                       }


                 public function ConsolidadoEntornoFamiliarTerritorio($id_usuario, $mes){
                         $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                         COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                         COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                           SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                           (SELECT COUNT(E.Pk_Id_Experiencia) FROM tb_nidos_experiencia E WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA',
                           (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                           FROM tb_nidos_asistencia AS NA
                           JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                           WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                           AND NA.Vc_Asistencia = '1'
                           AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EXP.IN_Aprobacion = '1')AS 'ASISTENTES'
                           FROM tb_nidos_experiencia AS EX
                           JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                           JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                           JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                           JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                           JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                           JOIN tb_nidos_terri_locali AS TEL ON LA.Fk_Id_Localidad = TEL.Fk_Id_Localidad
                           JOIN tb_nidos_persona_territorio AS PTE ON. TEL.Fk_Id_Territorio = PTE.Fk_Id_Territorio
                           where PTE.Fk_Id_Persona = :id_usuario  AND LA.VC_Tipo_Lugar = 1 AND NE.Pk_Id_Entidad IN ('1','4') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31')  AND EX.IN_Aprobacion = '1' ORDER BY NE.Pk_Id_Entidad) AS PRIMERA left JOIN
                           (SELECT
                             COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                             COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                             COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                             COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                             COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                             DT.Fk_Id_Lugar_Atencion
                             from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                               FROM tb_nidos_asistencia NA
                               JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                               JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                               where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND EX.IN_Aprobacion = '1'
                               GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                               ON 	PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                               $sentencia=$this->dbPDO->prepare($sql);
                               @$sentencia->bindParam(':id_usuario',$id_usuario);
                               $sentencia->execute();
                               return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                    }


                    public function ConsolidadoEntornoInstitucionalTerritorio($id_usuario, $mes){
                      $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                      COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                      COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                        SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                        (SELECT COUNT(E.Pk_Id_Experiencia) FROM tb_nidos_experiencia E WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA',
                        (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                        FROM tb_nidos_asistencia AS NA
                        JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                        WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                        AND NA.Vc_Asistencia = '1'
                        AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EXP.IN_Aprobacion = '1') AS 'ASISTENTES'
                        FROM tb_nidos_experiencia AS EX
                        JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                        JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                        JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                        JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                        JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                        JOIN tb_nidos_terri_locali AS TEL ON LA.Fk_Id_Localidad = TEL.Fk_Id_Localidad
                        JOIN tb_nidos_persona_territorio AS PTE ON. TEL.Fk_Id_Territorio = PTE.Fk_Id_Territorio
                        where PTE.Fk_Id_Persona = :id_usuario  AND LA.VC_Tipo_Lugar = 2 AND NE.Pk_Id_Entidad IN ('1','4') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31')  AND EX.IN_Aprobacion ='1' ORDER BY NE.Pk_Id_Entidad ) AS PRIMERA left JOIN
                        (SELECT
                          COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                          COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                          COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                          COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                          COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                          DT.Fk_Id_Lugar_Atencion
                          from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                            FROM tb_nidos_asistencia NA
                            JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                            JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                            where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                            GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                            ON 	PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                            $sentencia=$this->dbPDO->prepare($sql);
                            @$sentencia->bindParam(':id_usuario',$id_usuario);
                            $sentencia->execute();
                            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                          }


  /******************** CONSULTAS DE LA ACTIVIDAD ENCUENTROS GRUPLAES COORDINAADOR COMPONENTE TERRITORIAL **************/

            public function ConsolidadoEncuentrosGTotalFamiliar($mes){
               $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, IDLocalidad, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                  SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                  (SELECT COUNT(E.Pk_Id_Experiencia)
                  FROM tb_nidos_experiencia E
                  WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                  (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                  FROM tb_nidos_asistencia AS NA
                  JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                  WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                  AND NA.Vc_Asistencia = '1'
                  AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EXP.IN_Aprobacion = '1')AS 'ASISTENTES'
                  FROM tb_nidos_experiencia AS EX
                  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                  JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                  JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                  JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                  JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                  where LA.VC_Tipo_Lugar = '1' AND LA.Fk_Id_Entidad IN ('1','4')
                  AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY NE.Pk_Id_Entidad, IDLocalidad) AS PRIMERA left JOIN
                  (SELECT
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                  DT.Fk_Id_Lugar_Atencion
                  from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                  FROM tb_nidos_asistencia NA
                  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                  JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                  where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                  GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                  ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                }

            public function ConsolidadoEncuentrosGTotalInstitucional($mes){
               $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, IDLocalidad, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                  SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                  (SELECT COUNT(E.Pk_Id_Experiencia)
                  FROM tb_nidos_experiencia E
                  WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                  AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                  (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                  FROM tb_nidos_asistencia AS NA
                  JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                  WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                  AND NA.Vc_Asistencia = '1'
                  AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND EXP.IN_Aprobacion = '1')AS 'ASISTENTES'
                  FROM tb_nidos_experiencia AS EX
                  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                  JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                  JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                  JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                  JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                  where LA.VC_Tipo_Lugar = '2' AND LA.Fk_Id_Entidad IN ('1','4')
                  AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31')  AND EX.IN_Aprobacion = '1' ORDER BY NE.Pk_Id_Entidad, IDLocalidad) AS PRIMERA left JOIN
                  (SELECT
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                  DT.Fk_Id_Lugar_Atencion
                  from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                  FROM tb_nidos_asistencia NA
                  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                  JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                  where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                  GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                  ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
               }




                /******************** CONSULTAS ENTORNO FAMILIAR E INSTITUCIONAL POR TERRITORIO ROL DE COORDINADOR TERRITORIAL  **************/

                            public function EntornoFamiliarTerritorioRolCoordinadorT($Territorio, $mes){
                               $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                               COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                               COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                               SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                               (SELECT COUNT(E.Pk_Id_Experiencia) FROM tb_nidos_experiencia E WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA',
                               (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                               FROM tb_nidos_asistencia AS NA
                               JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                               WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                               AND NA.Vc_Asistencia = '1'
                               AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31'))AS 'ASISTENTES'
                               FROM tb_nidos_experiencia AS EX
                               JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                               JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                               JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                               JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                               JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                               JOIN tb_nidos_terri_locali AS TER ON TER.Fk_Id_Localidad = LO.Pk_Id_Localidad AND TER.Fk_Id_Localidad = LA.Fk_Id_Localidad
                               where TER.Fk_Id_Territorio = :territorio  AND LA.VC_Tipo_Lugar = 1 AND NE.Pk_Id_Entidad IN ('1','4') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY NE.Pk_Id_Entidad) AS PRIMERA left JOIN
                               (SELECT
                              COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                              COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                              COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                              COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                              COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                              DT.Fk_Id_Lugar_Atencion
                              from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                              FROM tb_nidos_asistencia NA
                              JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                              JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                              where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                              GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                              ON 	PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                              $sentencia=$this->dbPDO->prepare($sql);
                              @$sentencia->bindParam(':territorio',$Territorio);
                              $sentencia->execute();
                              return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                           }


                           public function EntornoInstitucionalTerritorioRolCoordinadorT($Territorio, $mes){
                              $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
                              COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                              COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                                 SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(NE.Vc_Abreviatura,' / ',TL.Vc_Descripcion) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                                 (SELECT COUNT(E.Pk_Id_Experiencia) FROM tb_nidos_experiencia E WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA',
                                 (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                                 FROM tb_nidos_asistencia AS NA
                                 JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                                 WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                                 AND NA.Vc_Asistencia = '1'
                                 AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31'))AS 'ASISTENTES'
                                 FROM tb_nidos_experiencia AS EX
                                 JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                                 JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                                 JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                                 JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                                 JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                                 JOIN tb_nidos_terri_locali AS TER ON TER.Fk_Id_Localidad = LO.Pk_Id_Localidad AND TER.Fk_Id_Localidad = LA.Fk_Id_Localidad
                                 where TER.Fk_Id_Territorio = :territorio  AND LA.VC_Tipo_Lugar = 2 AND NE.Pk_Id_Entidad IN ('1','4') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY NE.Pk_Id_Entidad ) AS PRIMERA left JOIN
                                 (SELECT
                                    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                                    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                                    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                                    COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                                    COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                                    DT.Fk_Id_Lugar_Atencion
                                    from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                                       FROM tb_nidos_asistencia NA
                                       JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                                       JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                                       where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                                       GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                                       ON 	PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                                       $sentencia=$this->dbPDO->prepare($sql);
                                       @$sentencia->bindParam(':territorio',$Territorio);
                                       $sentencia->execute();
                                       return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                                    }

  /******************** CONSULTAS LABORATORIOS E INTERVENCIONES ROL GESTOR Y COORDINADOR TERRITORIAL  **************/


            public function ConsolidadoLaboratoriosEIntervencionesTerritorio($id_usuario, $mes){
              $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), ENTIDAD, TIPO, Localidad, UPZ, Barrio, Lugar, EXPERIENCIA, ASISTENTES,
              COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
              COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
              COALESCE(NINOS_DE_0_A_3_R,0) as NINOS_DE_0_A_3_R,
              COALESCE(NINAS_DE_0_A_3_R,0) as NINAS_DE_0_A_3_R,
              COALESCE(NINOS_DE_4_A_6_R,0) as NINOS_DE_4_A_6_R,
              COALESCE(NINAS_DE_4_A_6_R,0) as NINAS_DE_4_A_6_R,
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
                SELECT DISTINCT(Pk_Id_lugar_atencion), NE.Pk_Id_Entidad AS ENTIDAD, CONCAT(TL.Vc_Descripcion,' / ',NE.Vc_Abreviatura) AS TIPO, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, LA.VC_Barrio AS Barrio, LA.VC_Nombre_Lugar AS Lugar,
                (SELECT COUNT(E.Pk_Id_Experiencia) FROM tb_nidos_experiencia E WHERE E.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'EXPERIENCIA',
                (SELECT COUNT(DISTINCT NA.Fk_Id_Beneficiario)
                FROM tb_nidos_asistencia AS NA
                JOIN tb_nidos_experiencia AS EXP ON NA.Fk_Id_Experiencia = EXP.Pk_Id_Experiencia
                WHERE EXP.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion
                AND NA.Vc_Asistencia = '1'
                AND (EXP.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31'))AS 'ASISTENTES'
                FROM tb_nidos_experiencia AS EX
                JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                JOIN tb_nidos_entidades AS NE ON LA.Fk_Id_Entidad = NE.Pk_Id_Entidad
                JOIN tb_nidos_tipo_lugar AS TL ON  LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar
                JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                where LA.Fk_Id_Usuario_Crea = :id_usuario  AND LA.VC_Tipo_Lugar IN ('4','6') AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') ORDER BY NE.Pk_Id_Entidad ) AS PRIMERA left JOIN
                (SELECT
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 1 then 1 END) AS NINOS_DE_0_A_3_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND DT.Fk_Id_Genero = 2 then 1 END) AS NINAS_DE_0_A_3_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 1 then 1 END) AS NINOS_DE_4_A_6_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND DT.Fk_Id_Genero = 2 then 1 END) AS NINAS_DE_4_A_6_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                  DT.Fk_Id_Lugar_Atencion
                  from (SELECT BE.DD_F_Nacimiento,BE.Fk_Id_Genero,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion
                    FROM tb_nidos_asistencia NA
                    JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                    JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                    where NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
                    GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_Lugar_Atencion) AS SEGUNDA
                    ON 	PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_Lugar_Atencion";
                    $sentencia=$this->dbPDO->prepare($sql);
                    @$sentencia->bindParam(':id_usuario',$id_usuario);
                    $sentencia->execute();
                    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                  }


  /******************** CONSULTAS FINALEZ UPZ LABORATORIOS TOTAL FINAL **************/
        public function ConsolidadoTotalEncuentrosGrupalesUPZDao($mes){
          $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES, 
           COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
            FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                  WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                  WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                  WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                  WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                  FROM tb_nidos_grupos AS GR
                  JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'TIPOGRUPO',
                  (SELECT COUNT(E.Pk_Id_Experiencia)
                  FROM tb_nidos_experiencia AS E
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                  (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                  FROM tb_nidos_experiencia_artista AS EA
                  JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'ARTISTAS',
                  (SELECT SUM(IN_Cuidadores)
                  FROM tb_nidos_experiencia AS E
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'CUIDADORES'
                  FROM  tb_nidos_experiencia AS EX
                  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                  JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                  JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                  where LA.VC_Tipo_Lugar IN (1,2,3,5,6) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN  
  
            (SELECT 
                   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS GESTANTES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS AFRODESCENDIENTE_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS ROM_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS INDIGENA_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CONFLICTO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS DISCAPACIDAD_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS NINGUNO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS PRIVADOS_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS RAIZALES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CAMPESINA_R, 
              COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND
              (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
              where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_R,
            COUNT(CASE WHEN (DT.Fk_Id_Beneficiario) AND DT.VC_Tipo_Lugar IN (1,2,3,5,6) AND
              (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
            where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS 'NOCONVENIONALES',
            DT.Fk_Id_lugar_atencion    
       from (SELECT BE.DD_F_Nacimiento, BE.IN_Grupo_Poblacional, EX.Fk_Id_Lugar_Atencion, LAN.VC_Tipo_Lugar,  EX.DT_Fecha_Encuentro, NA.Fk_Id_Beneficiario
         FROM tb_nidos_asistencia NA
         JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
         JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
       JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario  
         where NA.Vc_Asistencia = '1' 
        AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
        AND EX.IN_Aprobacion = '1'
        GROUP BY NA.Fk_Id_Beneficiario)  DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
        ON PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion GROUP BY Pk_Id_lugar_atencion HAVING TOTAL_R > 0 ORDER BY IDLocalidad";
              $sentencia=$this->dbPDO->prepare($sql);
              $sentencia->execute();
              return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
          }

          public function ConsolidadoLaboratoriosEIntervencionesMes($mes){
                     $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES, 
           COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
            FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                  WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                  WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                  WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                  WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                  FROM tb_nidos_grupos AS GR
                  JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'TIPOGRUPO',
                  (SELECT COUNT(E.Pk_Id_Experiencia)
                  FROM tb_nidos_experiencia AS E
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                  (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                  FROM tb_nidos_experiencia_artista AS EA
                  JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'ARTISTAS',
                  (SELECT SUM(IN_Cuidadores)
                  FROM tb_nidos_experiencia AS E
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'CUIDADORES'
                  FROM  tb_nidos_experiencia AS EX
                  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                  JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                  JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                  where LA.VC_Tipo_Lugar IN (4) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN  
  
             (SELECT 
                   COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS GESTANTES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS AFRODESCENDIENTE_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS ROM_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS INDIGENA_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CONFLICTO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS DISCAPACIDAD_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS NINGUNO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS PRIVADOS_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS RAIZALES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CAMPESINA_R, 
              COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND
              (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
              where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_R,
            COUNT(CASE WHEN (DT.Fk_Id_Beneficiario) AND DT.VC_Tipo_Lugar IN (4) AND
              (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
            where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS 'NOCONVENIONALES',
            DT.Fk_Id_lugar_atencion    
       from (SELECT BE.DD_F_Nacimiento, BE.IN_Grupo_Poblacional, EX.Fk_Id_Lugar_Atencion, LAN.VC_Tipo_Lugar,  EX.DT_Fecha_Encuentro, NA.Fk_Id_Beneficiario
         FROM tb_nidos_asistencia NA
         JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
         JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
       JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario  
         where NA.Vc_Asistencia = '1' 
        AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
        AND EX.IN_Aprobacion = '1'
        GROUP BY NA.Fk_Id_Beneficiario)  DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
        ON PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion GROUP BY Pk_Id_lugar_atencion HAVING TOTAL_R > 0 ORDER BY IDLocalidad";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
               }        


               public function Meta1EncuentrosGrupales($mes){
                  $sql="SELECT DISTINCT(FK_Value), LOCALIDAD, NOCONVENIONALES, ADECUADOS, TOTAL
                        FROM (
                        SELECT DISTINCT(FK_Value), VC_Descripcion AS 'LOCALIDAD'
                        FROM tb_parametro_detalle WHERE FK_Id_Parametro = '19' AND IN_Estado_Nidos = 1) AS PRIMERA left JOIN
                        (SELECT
                        COUNT(CASE WHEN (DT.Fk_Id_Beneficiario) AND DT.VC_Tipo_Lugar IN (1,2,3,5,6) AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS 'NOCONVENIONALES',
                        COUNT(CASE WHEN (DT.Fk_Id_Beneficiario) AND DT.VC_Tipo_Lugar IN (4) AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS 'ADECUADOS',
                        COUNT(CASE WHEN (DT.Fk_Id_Beneficiario) AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS 'TOTAL',
                        DT.Fk_Id_Localidad
                        FROM (SELECT LA.Fk_Id_Localidad, LA.VC_Tipo_Lugar,  EX.DT_Fecha_Encuentro, NA.Fk_Id_Beneficiario
                        FROM tb_nidos_asistencia AS NA
                        JOIN tb_nidos_experiencia  AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                        JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                        WHERE NA.Vc_Asistencia = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1'
                        GROUP BY NA.Fk_Id_Beneficiario)  DT GROUP BY DT.Fk_Id_Localidad) AS SEGUNDA
                        ON PRIMERA.FK_Value = SEGUNDA.Fk_Id_Localidad ORDER BY FK_Value";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
               }


          /******************** CONSULTAS CONSOLIDADO GESTOR UPZ LABORATORIOS  **************/

            public function ConsolidadoGestorTerritorioUPZDao($mes, $id_territorio){
              $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES,
                COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                  WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                  WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                  WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                  WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                  FROM tb_nidos_grupos AS GR
                  JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'TIPOGRUPO',
                  (SELECT COUNT(E.Pk_Id_Experiencia)
                  FROM tb_nidos_experiencia AS E
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                  (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                  FROM tb_nidos_experiencia_artista AS EA
                  JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'ARTISTAS',
                  (SELECT SUM(IN_Cuidadores)
                  FROM tb_nidos_experiencia AS E
                  JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  WHERE LAN.VC_Tipo_Lugar IN (1,2,3,5,6) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'CUIDADORES'
                  FROM  tb_nidos_experiencia AS EX
                  JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                  JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                  JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                  JOIN tb_nidos_terri_locali AS TL ON LO.Pk_Id_Localidad = TL.Fk_Id_Localidad
                  where TL.Fk_Id_Territorio = :id_territorio AND LA.VC_Tipo_Lugar IN (1,2,3,5,6) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN
                  (SELECT
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS GESTANTES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS AFRODESCENDIENTE_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS ROM_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS INDIGENA_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CONFLICTO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS DISCAPACIDAD_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS NINGUNO_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS PRIVADOS_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS RAIZALES_R,
                  COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CAMPESINA_R,
                  COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND
                  (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                  where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_R,
                  DT.Fk_Id_lugar_atencion
                  from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion, LAN.Fk_Id_Upz,NA.Fk_Id_Beneficiario
                  FROM tb_nidos_asistencia NA
                  JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                  JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                  JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                  where NA.Vc_Asistencia = '1' AND LAN.VC_Tipo_Lugar IN (1,2,3,5,6)
                  AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
                  AND EX.IN_Aprobacion = '1'
                  GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
                  ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion";
                  $sentencia=$this->dbPDO->prepare($sql);
                  @$sentencia->bindParam(':id_territorio',$id_territorio);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                }


                public function ConsolidadoGestorTerritorioLaboratoriosDao($mes, $id_territorio){
                   $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES,
                           COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                           COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                           FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                           (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                             WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                             WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                             WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                             WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                     FROM tb_nidos_grupos AS GR
                     JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'TIPOGRUPO',
                     (SELECT COUNT(E.Pk_Id_Experiencia)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                     (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                     FROM tb_nidos_experiencia_artista AS EA
                     JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'ARTISTAS',
                     (SELECT SUM(IN_Cuidadores)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'CUIDADORES'
                     FROM  tb_nidos_experiencia AS EX
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                     JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                     JOIN tb_nidos_terri_locali AS TEL ON LO.Pk_Id_Localidad = TEL.Fk_Id_Localidad
                     where TEL.Fk_Id_Territorio = :id_territorio AND LA.VC_Tipo_Lugar IN (4) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN
                     (SELECT
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS GESTANTES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS AFRODESCENDIENTE_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS ROM_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS INDIGENA_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CONFLICTO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS DISCAPACIDAD_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS NINGUNO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS PRIVADOS_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS RAIZALES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CAMPESINA_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_R,
                     DT.Fk_Id_lugar_atencion
                     from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion, LAN.Fk_Id_Upz,NA.Fk_Id_Beneficiario
                     FROM tb_nidos_asistencia NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                     where NA.Vc_Asistencia = '1' AND LAN.VC_Tipo_Lugar IN (4)
                     AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
                     AND EX.IN_Aprobacion = '1'
                     GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
                     ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion";
                            $sentencia=$this->dbPDO->prepare($sql);
                            @$sentencia->bindParam(':id_territorio',$id_territorio);
                            $sentencia->execute();
                            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
                         }

            public function ConsolidadoGestorAtencionRealDao($mes, $id_territorio){
             $sql="SELECT IDDUPLA, DUPLA, ENCUENTROS, CUIDADORES,
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
                SELECT DU.Pk_Id_Dupla AS 'IDDUPLA', DU.VC_Codigo_Dupla AS 'DUPLA',
                (SELECT COUNT(EX.Pk_Id_Experiencia) FROM tb_nidos_experiencia EX
                WHERE EX.Fk_Id_Dupla = DU.Pk_Id_Dupla AND IN_Aprobacion = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'ENCUENTROS',
                (SELECT SUM(IN_Cuidadores) FROM tb_nidos_experiencia EX
                WHERE EX.Fk_Id_Dupla = DU.Pk_Id_Dupla AND IN_Aprobacion = '1' AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')) AS 'CUIDADORES'
                FROM tb_nidos_dupla DU
                WHERE DU.IN_Estado = 1 AND DU.Fk_Id_Territorio = :id_territorio) AS PRIMERA left JOIN
                (SELECT
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
                EX.Fk_Id_Dupla
                FROM tb_nidos_asistencia NA
                JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                where NA.Vc_Asistencia = '1' AND EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31' AND EX.IN_Aprobacion = '1'
                GROUP BY EX.Fk_Id_Dupla) AS SEGUNDA ON   PRIMERA.IDDUPLA = SEGUNDA.Fk_Id_Dupla";
            $sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':id_territorio',$id_territorio);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
          }


        public function ConsolidadoBeneficiariosAtendidosMesDao($mes, $id_territorio){
          $sql="SELECT DU.VC_Codigo_Dupla AS 'DUPLA', LA.VC_Nombre_Lugar AS 'LUGAR', GR.VC_Nombre_Grupo AS 'GRUPO', EX.VC_Nombre_Experiencia AS 'EXPERIENCIA', EX.DT_Fecha_Encuentro AS 'FECHA', BE.VC_Identificacion AS 'IDENTIFICACION' ,
            CONCAT(BE.VC_Primer_Nombre, ' ' ,BE.VC_Segundo_Nombre, ' ' ,BE.VC_Primer_Apellido, ' ' ,BE.VC_Segundo_Apellido) AS 'BENEFICIARIO'
            FROM tb_nidos_asistencia AS NA
            JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
            JOIN tb_nidos_dupla AS DU ON EX.Fk_Id_Dupla = DU.Pk_Id_Dupla
            JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_Lugar_Atencion
            JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
            JOIN tb_nidos_beneficiarios AS BE ON NA.Fk_Id_Beneficiario = BE.Pk_Id_Beneficiario
            WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
            AND NA.Vc_Asistencia = '1' AND EX.IN_Aprobacion = '1' AND DU.IN_Estado = 1 AND DU.Fk_Id_Territorio = :id_territorio  ORDER BY DUPLA, IDENTIFICACION";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_territorio',$id_territorio);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }


/**************  CONSULTA REPORTE DE LABORATORIOS ATENCIÓN REAL *********************************/
           public function ConsolidadoLaboratoriosAtencionRealMes($mes){
                     $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES,
                           COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                           COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                           FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                           (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                             WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                             WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                             WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                             WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                     FROM tb_nidos_grupos AS GR
                     JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'TIPOGRUPO',
                     (SELECT COUNT(E.Pk_Id_Experiencia)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'EXPERIENCIA',
                     (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                     FROM tb_nidos_experiencia_artista AS EA
                     JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'ARTISTAS',
                     (SELECT SUM(IN_Cuidadores)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1') AS 'CUIDADORES'
                     FROM  tb_nidos_experiencia AS EX
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                     JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                     where LA.VC_Tipo_Lugar IN (4) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN
                     (SELECT
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3  then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                     DT.Fk_Id_lugar_atencion
                     from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion, LAN.Fk_Id_Upz,NA.Fk_Id_Beneficiario
                     FROM tb_nidos_asistencia NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                     where NA.Vc_Asistencia = '1' AND LAN.VC_Tipo_Lugar IN (4)
                     AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
                     AND EX.IN_Aprobacion = '1'
                     GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
                     ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
               }


              /**************  CONSULTA REPORTE DE LABORATORIOS ATENCIÓN REAL *********************************/
           public function ConsolidadoGruposComunidadAtencionRealMes($mes){
                     $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES,
                           COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                           COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                           FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                           (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                             WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                             WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                             WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                             WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                     FROM tb_nidos_grupos AS GR
                     JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'TIPOGRUPO',                   
                     (SELECT COUNT(E.Pk_Id_Experiencia)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_grupos AS GR ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion  
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'EXPERIENCIA',                    
                     (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                     FROM tb_nidos_experiencia_artista AS EA
                     JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                     JOIN tb_nidos_grupos AS GR ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'ARTISTAS',                     
                     (SELECT SUM(IN_Cuidadores)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_grupos AS GR ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'CUIDADORES'                     
                     FROM  tb_nidos_experiencia AS EX
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                     JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                     JOIN tb_nidos_grupos AS GRU ON EX.Fk_Id_Grupo =  GRU.Pk_Id_Grupo
                     where GRU.Fk_Id_Tipo_Grupo = '1' AND LA.VC_Tipo_Lugar IN (4) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN
                     (SELECT
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3  then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 then 1 END) AS GESTANTES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 then 1 END) AS AFRODESCENDIENTE_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 then 1 END) AS ROM_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 then 1 END) AS INDIGENA_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 then 1 END) AS CONFLICTO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 then 1 END) AS DISCAPACIDAD_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 then 1 END) AS NINGUNO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 then 1 END) AS PRIVADOS_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 then 1 END) AS RAIZALES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 then 1 END) AS CAMPESINA_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 then 1 END) AS TOTAL_R,
                     DT.Fk_Id_lugar_atencion
                     from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion, LAN.Fk_Id_Upz,NA.Fk_Id_Beneficiario
                     FROM tb_nidos_asistencia NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                      JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                     where NA.Vc_Asistencia = '1' AND LAN.VC_Tipo_Lugar IN (4)
                     AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
                     AND EX.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1'
                     GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
                     ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
               }

          public function ConsolidadoGruposComunidadNuevosMes($mes){
                     $sql="SELECT DISTINCT(Pk_Id_lugar_atencion), IDLocalidad, Localidad, UPZ, BARRIO, LUGAR_ATENCION, TIPOGRUPO, EXPERIENCIA, ARTISTAS, CUIDADORES,
                           COALESCE(TOTAL_DE_0_3_ANIOS_R,0) as TOTAL_DE_0_3_ANIOS_R,
                           COALESCE(TOTAL_DE_4_6_ANIOS_R,0) as TOTAL_DE_4_6_ANIOS_R,
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
                           FROM (SELECT  DISTINCT(LA.Pk_Id_lugar_atencion), LO.Pk_Id_Localidad AS IDLocalidad, LO.VC_Nom_Localidad AS Localidad, CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz) AS UPZ, VC_Barrio AS BARRIO, VC_Nombre_Lugar AS LUGAR_ATENCION,
                           (SELECT GROUP_CONCAT(DISTINCT(CONCAT(' ' ,CASE
                             WHEN GR.Fk_Id_Tipo_Grupo = '1' THEN 'COMUNIDAD'
                             WHEN GR.Fk_Id_Tipo_Grupo = '2' THEN 'AF'
                             WHEN GR.Fk_Id_Tipo_Grupo = '3' THEN 'AI'
                             WHEN GR.Fk_Id_Tipo_Grupo IS NULL THEN 'SIN REGISTRO' END , ' ') ))
                     FROM tb_nidos_grupos AS GR
                     JOIN tb_nidos_experiencia AS E ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'TIPOGRUPO',                   
                     (SELECT COUNT(E.Pk_Id_Experiencia)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_grupos AS GR ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion  
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'EXPERIENCIA',                    
                     (SELECT COUNT(DISTINCT EA.Fk_Id_Artista)
                     FROM tb_nidos_experiencia_artista AS EA
                     JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia = EA.Fk_Id_Experiencia
                     JOIN tb_nidos_grupos AS GR ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'ARTISTAS',                     
                     (SELECT SUM(IN_Cuidadores)
                     FROM tb_nidos_experiencia AS E
                     JOIN tb_nidos_grupos AS GR ON E.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON E.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     WHERE LAN.VC_Tipo_Lugar IN (4) AND LAN.Pk_Id_lugar_atencion =  LA.Pk_Id_lugar_atencion AND (E.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')  AND E.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1' ) AS 'CUIDADORES'                     
                     FROM  tb_nidos_experiencia AS EX
                     JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                     JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                     JOIN tb_localidades AS LO ON LO.Pk_Id_Localidad = LA.Fk_Id_Localidad
                     JOIN tb_nidos_grupos AS GRU ON EX.Fk_Id_Grupo =  GRU.Pk_Id_Grupo
                     where GRU.Fk_Id_Tipo_Grupo = '1' AND LA.VC_Tipo_Lugar IN (4) AND (EX.DT_Fecha_Encuentro BETWEEN  '2021-$mes-01' AND '2021-$mes-31') AND EX.IN_Aprobacion = '1' ORDER BY IDLocalidad, UPZ) AS PRIMERA left JOIN
                     (SELECT
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 3 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1) then 1 END) AS TOTAL_DE_0_3_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 4 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 5 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_DE_4_6_ANIOS_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 6 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS GESTANTES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 1 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS AFRODESCENDIENTE_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 2 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS ROM_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 3 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS INDIGENA_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 4 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CONFLICTO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 5 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS DISCAPACIDAD_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 6 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS NINGUNO_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 10 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS PRIVADOS_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 13 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS RAIZALES_R,
                     COUNT(CASE WHEN DT.IN_Grupo_Poblacional = 14 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS CAMPESINA_R,
                     COUNT(CASE WHEN TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) >= 0 AND TIMESTAMPDIFF(YEAR,DT.DD_F_Nacimiento,DT_Fecha_Encuentro) <= 99 AND
                        (SELECT E.DT_Fecha_Encuentro >= '2021-$mes-01' AND  E.DT_Fecha_Encuentro <= '2021-$mes-31' FROM tb_nidos_asistencia N left join tb_nidos_experiencia E ON N.Fk_id_Experiencia = E.Pk_Id_Experiencia
                        where N.Fk_Id_Beneficiario = DT.Fk_Id_Beneficiario AND N.Vc_Asistencia = '1' AND YEAR(E.DT_Fecha_Encuentro) = 2021 ORDER BY E.DT_Fecha_Encuentro ASC LIMIT 1)then 1 END) AS TOTAL_R,
                     DT.Fk_Id_lugar_atencion
                     from (SELECT BE.DD_F_Nacimiento,EX.DT_Fecha_Encuentro,BE.IN_Grupo_Poblacional,EX.Fk_Id_Lugar_Atencion, LAN.Fk_Id_Upz,NA.Fk_Id_Beneficiario
                     FROM tb_nidos_asistencia NA
                     JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia
                     JOIN tb_nidos_grupos AS GR ON EX.Fk_Id_Grupo = GR.Pk_Id_Grupo
                     JOIN tb_nidos_lugar_atencion AS LAN ON EX.Fk_Id_Lugar_Atencion = LAN.Pk_Id_lugar_atencion
                     JOIN tb_nidos_beneficiarios AS BE ON  BE.Pk_Id_Beneficiario = NA.Fk_Id_Beneficiario
                     where NA.Vc_Asistencia = '1' AND LAN.VC_Tipo_Lugar IN (4)
                     AND (EX.DT_Fecha_Encuentro BETWEEN '2021-$mes-01' AND '2021-$mes-31')
                     AND EX.IN_Aprobacion = '1' AND GR.Fk_Id_Tipo_Grupo = '1'
                     GROUP BY BE.Pk_Id_Beneficiario,EX.Fk_Id_Lugar_Atencion) DT GROUP BY DT.Fk_Id_lugar_atencion) AS SEGUNDA
                     ON  PRIMERA.Pk_Id_lugar_atencion = SEGUNDA.Fk_Id_lugar_atencion";
                  $sentencia=$this->dbPDO->prepare($sql);
                  $sentencia->execute();
                  return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
               }

               public function getReportePandoraTerritorial($id_mes){ 
                $sql = "SELECT 
                DISTINCT(EX.Fk_Id_Lugar_Atencion) AS 'IDLUGAR',
                (SELECT COUNT(EXP1.Pk_Id_Experiencia)
                FROM tb_nidos_experiencia AS EXP1
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro BETWEEN '2021-11-26' AND '2021-12-25'
                AND EXP1.IN_Aprobacion = 1 AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'ACTIVIDADES',
                EX.DT_Fecha_Encuentro AS 'FECHA',
                LA.VC_Nombre_Lugar AS 'LUGAR',
                '20' AS 'AFORO',
                LO.VC_Nom_Localidad AS 'LOCALIDAD',
                CONCAT(UP.IN_Codigo_Upz,' ', UP.VC_Nombre_Upz) AS 'UPZ',
                LA.VC_Barrio AS 'BARRIO',
                (SELECT COUNT(DISTINCT(DU.Fk_Id_Persona))
                FROM tb_nidos_experiencia AS EXP1
                JOIN tb_nidos_dupla_artista AS DU ON  EXP1.Fk_Id_Dupla = DU.Fk_Id_Dupla
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro BETWEEN '2021-11-26' AND '2021-12-25'
                AND EXP1.IN_Aprobacion = 1 AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'ARTISTAS',
                (SELECT SUM(IN_Total_Beneficiarios_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'INSCRITOS',
                (SELECT SUM(BI.IN_Total_Ninas_Nuevos  + BI.IN_Mujeres_Gestantes_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'TOTAL_NINAS',
                (SELECT SUM(IN_Total_Ninos_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'TOTAL_NINOS',
                (SELECT SUM(IN_Total_Beneficiarios_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'TOTAL_BENEFICIARIOS',                
                (SELECT SUM(BI.IN_Total_Ninos_0_3_Nuevos + BI.IN_Total_Ninos_3_6_Nuevos + BI.IN_Total_Ninas_0_3_Nuevos + BI.IN_Total_Ninas_3_6_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'PRIMERA',                
                (SELECT SUM(BI.IN_Total_Ninos_6_Nuevos + BI.IN_Total_Ninas_6_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'INFANCIA',
                '---' AS 'ADOLENCENTES',
                '---' AS 'JUVENTUD',
                '---' AS 'ADULTAS',
                '---' AS 'MAYORES',
                (SELECT SUM(BI.IN_Campesina_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'CAMPESINOS',
                (SELECT SUM(BI.IN_Mujeres_Gestantes_Nuevos)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'GESTANTES',
                (SELECT SUM(BI.IN_Discapacidad_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'DISCAPACIDAD',
                (SELECT SUM(BI.IN_Privados_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'PRIVADOS',
                (SELECT SUM(BI.IN_Conflicto_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'CONFLICTO',
                '---' AS 'MIGRANTE',
                '---' AS 'VICTIMAS_TRATA',
                (SELECT SUM(BI.IN_Rom_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'ROM_GITANO',
                (SELECT SUM(BI.IN_Indigena_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'INDIGENA',
                '---' AS 'COMUNIDADES_NEGRAS',
                (SELECT SUM(BI.IN_Afrodescendiente_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'AFRODESCENDIENTES',
                '---' AS 'PALENQUERAS',
                (SELECT SUM(BI.IN_Raizal_Nuevo)
                FROM tb_nidos_beneficiario_sin_informacion AS BI
                JOIN tb_nidos_experiencia AS EXP1 ON BI.Fk_Id_Experiencia = EXP1.Pk_Id_Experiencia
                WHERE EXP1.Fk_Id_Lugar_Atencion = EX.Fk_Id_Lugar_Atencion AND EXP1.DT_Fecha_Encuentro = EX.DT_Fecha_Encuentro) AS 'RAIZAL'
                FROM tb_nidos_experiencia AS EX
                JOIN tb_nidos_beneficiario_sin_informacion AS BI ON EX.Pk_Id_Experiencia = BI.Fk_Id_Experiencia
                JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion
                JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
                LEFT JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
                WHERE (EX.DT_Fecha_Encuentro BETWEEN '2021-11-26' AND '2021-12-25') AND IN_Aprobacion = 1
                ORDER BY LO.Pk_Id_Localidad, LUGAR, FECHA";  
                @$sentencia=$this->dbPDO->prepare($sql); 
                @$sentencia->execute();
                return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
              
              }








}
