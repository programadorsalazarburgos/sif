<?php   

namespace General\Persistencia\DAOS;
class NidosPedagogicoDAO extends GestionDAO {

    private $db;

    function __construct()
  	{
  		$this->db=$this->obtenerBD();
  		$this->dbPDO=$this->obtenerPDOBD();
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


    public function crearObjetoEvento($objeto) {
        $sql="INSERT INTO tb_nidos_fortalecimiento (Fk_Id_Localidad, Fk_Id_lugar_pedagogico, Vc_Nom_Evento, Dt_Fecha_Evento, Fk_Id_Eaat, Dt_Fecha_Registro)
            VALUES (:localidad, :lugar, :nomevento, :fechaevento, :eaat, :fecharegistro)";
        @$sentencia=$this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':eaat',$objeto->getfkideaat());
        @$sentencia->bindParam(':localidad',$objeto->getfkidterritorio());
        @$sentencia->bindParam(':lugar',$objeto->getvclugar());
        @$sentencia->bindParam(':nomevento',$objeto->getvcnomevento());
        @$sentencia->bindParam(':fechaevento',$objeto->getDtFechaEvento());
        @$sentencia->bindParam(':fecharegistro',$objeto->getdtfecharegistro());

        $sentencia->execute();

        return $sentencia->rowCount();
    }



    public function crearObjeto($objeto) {

   /*   $sql1="INSERT INTO tb_nidos_fortalecimiento_eaat(Fk_Id_Fortalecimiento, Fk_Id_Eaat, Fk_Id_Territorio)
      VALUES (:Id_Fortalecimiento, :Artista, :eaatterritorio)";
      @$sentencia1=$this->dbPDO->prepare($sql1);

      @$sentencia1->bindParam(':Id_Fortalecimiento',$objeto->getvcnomevento());
      @$sentencia1->bindParam(':eaatresponsable',$objeto->getEaatResponsable());
      @$sentencia1->bindParam(':eaatterritorio',$objeto->getEaatTerritorio()); */


        $sql="INSERT INTO tb_nidos_artista_fortalecimiento (Fk_Id_Fortalecimiento,Fk_Id_Artista,In_Asistencia) VALUES(:Id_Fortalecimiento, :Artista, :In_Asistencia)";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':Id_Fortalecimiento', $objeto->getvcnomevento());
            $sentencia->bindParam(':Artista', $id_artista);
            $sentencia->bindParam(':In_Asistencia', $asistencia);
            foreach ($objeto->getArtistaArray() as $artista) {
                $id_artista=$artista[0];
                $asistencia=$artista[1];
                $sentencia->execute();
            }
          return $sentencia->rowCount();
    }

/******* Función Consulta Nombre EAAT Y Territorio *******/
      public function getEaatTerritorio($id_usuario){
          $sql="SELECT PT.Fk_Id_Persona AS 'IDPERSONA', CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'NOMBRE',
          PT.Fk_Id_Territorio AS 'IDTERRITORIO',
          TE.Vc_Nom_Territorio AS 'TERRITORIO',
          PT.Fk_Id_Laboratorio AS 'ID_LABORATORIO',          
          (CASE WHEN PT.Fk_Id_Laboratorio  = '1' THEN 'ERRANDO Y CREANDO - JUEGOS GRÁFICOS' 
             WHEN PT.Fk_Id_Laboratorio  = '2' THEN 'CREACIÓN SONORA: EL CUERPO COMO INSTRUMENTO' 
             WHEN PT.Fk_Id_Laboratorio  = '3' THEN 'CUERPO SUSPENDIDO' 
             WHEN PT.Fk_Id_Laboratorio  = '4' THEN 'ANIMATRÓN'
             WHEN PT.Fk_Id_Laboratorio  = '5' THEN 'AUTÓMATAS DE PAPEL' 
             WHEN PT.Fk_Id_Laboratorio  = '6' THEN 'YO, TÍTERE'
             WHEN PT.Fk_Id_Laboratorio  = '7' THEN 'IM-PULSOS VITALES (Sonido y Movimiento)' 
           END) AS 'LABORATORIO'
          FROM tb_nidos_persona_territorio AS PT
          JOIN tb_persona_2017 AS PE ON PE.Pk_Id_Persona  = PT.Fk_Id_Persona
          JOIN tb_nidos_territorios AS TE ON TE.Pk_Id_Territorio = PT.Fk_Id_Territorio
          WHERE PT.IN_Estado = 1 AND Fk_Id_Persona = :usuario";
          @$sentencia=$this->dbPDO->prepare($sql);
          @$sentencia->bindParam(':usuario',$id_usuario);
          $sentencia->execute();
          return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

      public function consultarTerritoriosNidos() {
              $sql="SELECT Pk_Id_Territorio, Vc_Nom_Territorio FROM tb_nidos_territorios";
              $sentencia=$this->dbPDO->prepare($sql);
              $sentencia->execute();
              return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
     }
     public function consultarLocalidadesNidos() {
              $sql="SELECT FK_Value, VC_Descripcion FROM tb_parametro_detalle WHERE FK_Id_Parametro =  19 AND IN_Estado_Nidos =  1;";
              $sentencia=$this->dbPDO->prepare($sql);
              $sentencia->execute();
              return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
     }
/******* Función Consulta Lugares x Localidad *******/
      public function ConsultarLugaresLocalidad($id_localidad){
            $sql="SELECT Pk_Id_lugar_pedagogico, VC_Nombre_Lugar FROM tb_nidos_lugar_pedagogico WHERE IN_Estado = '1' AND Fk_Id_Localidad = :localidad";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':localidad',$id_localidad);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

      public function ConsultarEventosLugar($id_lugar){
            $sql="SELECT Pk_Id_Fortalecimiento, Vc_Nom_Evento FROM tb_nidos_fortalecimiento WHERE Fk_Id_lugar_pedagogico = :lugar";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':lugar',$id_lugar);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

      public function ConsultarHoraEventos($id_evento){
            $sql="SELECT Dt_Fecha_Evento  AS 'FECHA' FROM tb_nidos_fortalecimiento where Pk_Id_Fortalecimiento = :evento";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':evento',$id_evento);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }


/******* Función Consulta Artistas Territorio *******/
      public function getArtistasLaboratorioDAO($territorio){
            $sql="SELECT PT.Fk_Id_Persona AS 'IDPERSONA',
                  PE.VC_Identificacion AS 'IDENTIFICACION',
                  CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'NOMBRE',    
                  (SELECT D.VC_Codigo_Dupla FROM tb_nidos_dupla_artista AS DA JOIN tb_nidos_dupla AS D ON DA.Fk_Id_Dupla = D.Pk_Id_Dupla
                  WHERE PE.Pk_Id_Persona = DA.Fk_Id_Persona AND DA.IN_Estado = 1) AS 'DUPLA',
                  TE.Vc_Nom_Territorio AS 'TERRITORIO',
                  PT.IN_Estado AS 'ESTADO'
                  FROM tb_nidos_persona_territorio AS PT
                  JOIN tb_persona_2017 AS PE ON PE.Pk_Id_Persona  = PT.Fk_Id_Persona
                  JOIN tb_nidos_territorios AS TE ON PT.Fk_Id_Territorio = TE.Pk_Id_Territorio        
                  WHERE PT.Fk_Id_Laboratorio = :territorio AND PE.FK_Tipo_Persona = 16 ORDER BY NOMBRE";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':territorio',$territorio);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }


/******* Función Consulta Artistas Territorio *******/
      public function getArtistasTerritorioDAO($territorio){
            $sql="SELECT PT.Fk_Id_Persona AS 'IDPERSONA',
                  PE.VC_Identificacion AS 'IDENTIFICACION',
                  CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'NOMBRE',
                  (SELECT D.VC_Codigo_Dupla FROM tb_nidos_dupla_artista AS DA JOIN tb_nidos_dupla AS D ON DA.Fk_Id_Dupla = D.Pk_Id_Dupla
                  WHERE PE.Pk_Id_Persona = DA.Fk_Id_Persona AND DA.IN_Estado = 1) AS 'DUPLA',
                  PT.IN_Estado
                  FROM tb_nidos_persona_territorio AS PT
                  JOIN tb_persona_2017 AS PE ON PE.Pk_Id_Persona  = PT.Fk_Id_Persona
                  WHERE PT.Fk_Id_Territorio = :territorio AND PE.FK_Tipo_Persona = 16 ORDER BY NOMBRE";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':territorio',$territorio);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }


    /******* Función Consulta fortalecimientos Territorio *******/

      public function consultarFortalecimientosTerritorio($id_usuario, $Mes){
            $sql="SELECT NF.Pk_Id_Fortalecimiento AS 'ID', PDL.VC_Descripcion AS 'Localidad', UP.VC_Nombre_Upz AS 'Upz',
            LP.VC_Nombre_Lugar AS 'Lugar', NF.Vc_Nom_Evento AS 'Evento', NF.Dt_Fecha_Evento AS 'Fecha',
            (SELECT COUNT(AF.Pk_Id_Artista_Fortalecimiento) FROM tb_nidos_artista_fortalecimiento AF
            WHERE NF.Pk_Id_Fortalecimiento = AF.Fk_Id_Fortalecimiento AND In_Asistencia =  1) AS 'Artistas'
            FROM tb_nidos_fortalecimiento AS NF
            JOIN tb_parametro_detalle AS PDL ON NF.Fk_Id_Localidad = PDL.FK_Value AND PDL.FK_Id_Parametro = 19
            JOIN tb_nidos_lugar_pedagogico LP ON NF.Fk_Id_lugar_pedagogico = LP.Pk_Id_lugar_pedagogico
            JOIN tb_upz AS UP ON LP.Fk_Id_Upz = UP.Pk_Id_Upz
            WHERE NF.Fk_Id_Eaat = :usuario AND (NF.Dt_Fecha_Evento between '2020-$Mes-01' and '2020-$Mes-31')";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':usuario',$id_usuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
      }

      public function consultarConsolidadoReporteFAP($MesC){
            $sql="SELECT NF.Pk_Id_Fortalecimiento AS 'IDFortalecimiento',
            CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'EAAT',
            NT.Vc_Nom_Territorio AS 'Territorio',
            PDL.VC_Descripcion AS 'Localidad',
            CONCAT(UP.IN_Codigo_Upz,'. ',UP.VC_Nombre_Upz) AS 'Upz',
            LP.VC_Barrio AS 'Barrio',
            LP.VC_Nombre_Lugar AS 'Lugar', NF.Vc_Nom_Evento AS 'NomEvento', NF.Dt_Fecha_Evento AS 'Fecha',
            (SELECT COUNT(AF.Pk_Id_Artista_Fortalecimiento) FROM tb_nidos_artista_fortalecimiento AF
            WHERE NF.Pk_Id_Fortalecimiento = AF.Fk_Id_Fortalecimiento AND In_Asistencia =  1) AS 'Artistas'
            FROM tb_nidos_fortalecimiento AS NF
            JOIN tb_persona_2017 AS PE ON PE.Pk_Id_Persona  = NF.Fk_Id_Eaat
            JOIN tb_nidos_lugar_pedagogico AS LP ON NF.Fk_Id_lugar_pedagogico = LP.Pk_Id_lugar_pedagogico
            JOIN tb_parametro_detalle AS PDL ON LP.Fk_Id_Localidad = PDL.FK_Value AND PDL.FK_Id_Parametro = 19
            JOIN tb_upz AS UP ON LP.Fk_Id_Upz = UP.Pk_Id_Upz
            JOIN tb_nidos_persona_territorio AS PTE ON NF.Fk_Id_Eaat= PTE.Fk_Id_Persona
            JOIN tb_nidos_territorios AS NT ON PTE.Fk_Id_Territorio = NT.Pk_Id_Territorio
            WHERE (NF.Dt_Fecha_Evento BETWEEN '2020-$MesC-01' AND '2020-$MesC-31')";
            @$sentencia=$this->dbPDO->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
       }

       public function consultarReporteFAPLocalidad($MesD, $Localidad) {
           $sql="SELECT PE.VC_Identificacion AS 'Identificacion',
           CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'Artista',
           UP.VC_Nombre_Upz AS 'Upz',
           LP.VC_Nombre_Lugar AS 'Lugar',
           NF.Vc_Nom_Evento AS 'NomEvento',
           NF.Dt_Fecha_Evento AS 'Fecha'
           FROM tb_nidos_artista_fortalecimiento AS AF
           JOIN tb_nidos_fortalecimiento AS NF ON AF.Fk_Id_Fortalecimiento = NF.Pk_Id_Fortalecimiento
           JOIN tb_nidos_lugar_pedagogico AS LP ON NF.Fk_Id_lugar_pedagogico = LP.Pk_Id_lugar_pedagogico
           JOIN tb_persona_2017 AS PE ON PE.Pk_Id_Persona  = AF.Fk_Id_Artista
           JOIN tb_upz AS UP ON LP.Fk_Id_Upz = UP.Pk_Id_Upz
           WHERE AF.In_Asistencia =  1 AND NF.Fk_Id_Localidad = :localidad AND (NF.Dt_Fecha_Evento BETWEEN '2020-$MesD-01' AND '2020-$MesD-31')";
           @$sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':localidad',$Localidad);
            $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
       }

        public function consultarDetalladoReporteFAP($MesD, $Territorio) {
             $sql="SELECT PE.VC_Identificacion AS 'Identificacion', CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'Artista',
                   PDL.VC_Descripcion AS 'Localidad',  UP.VC_Nombre_Upz AS 'Upz', LP.VC_Nombre_Lugar AS 'Lugar', NF.Vc_Nom_Evento AS 'NomEvento', NF.Dt_Fecha_Evento AS 'Fecha'
                   FROM tb_nidos_artista_fortalecimiento AS AF
                   JOIN tb_nidos_fortalecimiento AS NF ON AF.Fk_Id_Fortalecimiento = NF.Pk_Id_Fortalecimiento
                   JOIN tb_nidos_lugar_pedagogico AS LP ON NF.Fk_Id_lugar_pedagogico = LP.Pk_Id_lugar_pedagogico
                   JOIN tb_parametro_detalle AS PDL ON LP.Fk_Id_Localidad = PDL.FK_Value AND PDL.FK_Id_Parametro = 19
                   JOIN tb_upz AS UP ON LP.Fk_Id_Upz = UP.Pk_Id_Upz
                   JOIN tb_nidos_terri_locali AS TL ON NF.Fk_Id_Localidad = TL.Fk_Id_Localidad
                   JOIN tb_persona_2017 AS PE ON PE.Pk_Id_Persona  = AF.Fk_Id_Artista
                   WHERE AF.In_Asistencia =  1 AND TL.Fk_Id_Territorio = :territorio  AND (NF.Dt_Fecha_Evento BETWEEN '2020-$MesD-01' AND '2020-$MesD-31')";
                   @$sentencia=$this->dbPDO->prepare($sql);
                   @$sentencia->bindParam(':territorio',$Territorio);
                    $sentencia->execute();
             return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
           }

         public function reporteFortalecimientoEncabezado($idFortalecimiento){
            $sql="SELECT PD.VC_Descripcion AS 'LOCALIDAD',
                  CONCAT(UP.IN_Codigo_Upz,'.  ',UP.VC_Nombre_upz) AS 'UPZ',
                  LP.VC_Barrio AS 'BARRIO',
                  LP.VC_Nombre_lugar AS 'LUGAR',
                  FO.Vc_Nom_Evento AS 'NOMBRE',
                  FO.Dt_Fecha_Evento AS 'FECHA',
                  CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'EAAT',
                  TE.Vc_Nom_Territorio AS 'TERRITORIO'
                  FROM tb_nidos_fortalecimiento AS FO
                  JOIN tb_nidos_lugar_pedagogico AS LP ON FO.Fk_Id_lugar_pedagogico = LP.Pk_Id_lugar_pedagogico
                  JOIN tb_parametro_detalle AS PD ON FO.Fk_Id_Localidad = PD.FK_Value AND PD.FK_Id_Parametro = 19
                  JOIN tb_upz AS UP ON LP.Fk_Id_Upz = UP.Pk_Id_Upz
                  JOIN tb_persona_2017 AS PE ON FO.Fk_Id_Eaat = PE.PK_Id_Persona
                  JOIN tb_nidos_persona_territorio AS PT ON PT.Fk_Id_Persona = FO.Fk_Id_Eaat
                  JOIN tb_nidos_territorios AS TE ON TE.Pk_Id_Territorio = PT.Fk_Id_Territorio
                  WHERE FO.Pk_Id_Fortalecimiento = :idFortalecimiento";
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':idFortalecimiento',$idFortalecimiento);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

         public function reporteAsistenciaFortalecimientoArtista($idFortalecimiento){
           $sql="SELECT  PE.VC_Identificacion AS 'IDENTIFICACION',
                 CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido) AS 'NOMBRE',
                 D.VC_Codigo_Dupla  AS 'DUPLA',
                 CASE WHEN AF.In_Asistencia  = '0' THEN 'No Asistió' WHEN AF.In_Asistencia  = '1' THEN 'Asistió' END AS 'ASISTENCIA'
                 FROM tb_nidos_artista_fortalecimiento AS AF
                 JOIN tb_persona_2017 AS PE ON AF.Fk_Id_Artista = PE.PK_Id_Persona
                 JOIN tb_nidos_dupla_artista DA ON PE.Pk_Id_Persona = DA.Fk_Id_Persona
                 JOIN tb_nidos_dupla AS D ON DA.Fk_Id_Dupla = D.Pk_Id_Dupla
                 WHERE AF.Fk_Id_Fortalecimiento = :idFortalecimiento AND DA.IN_Estado = 1 ORDER BY NOMBRE";
           @$sentencia=$this->dbPDO->prepare($sql);
           @$sentencia->bindParam(':idFortalecimiento',$idFortalecimiento);
           $sentencia->execute();
           return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }

         public function getEquipoCentralDAO($idTipoPersona){
            $sql="SELECT PE.PK_Id_Persona AS 'IDPERSONA', PE.VC_Identificacion AS 'IDENTIFICACION', 
                  CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido) AS 'NOMBRE', 
                  TE.Vc_Nom_Territorio AS 'TERRITORIO' 
                  FROM tb_persona_2017 AS PE
                  JOIN tb_nidos_persona_territorio AS PT ON PE.PK_Id_Persona = PT.Fk_Id_Persona
                  JOIN tb_nidos_territorios AS TE ON PT.Fk_Id_Territorio = TE.Pk_Id_Territorio
                  WHERE PE.FK_Tipo_Persona = 22";  
            @$sentencia=$this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':idTipoPersona',$idTipoPersona);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
         }
}