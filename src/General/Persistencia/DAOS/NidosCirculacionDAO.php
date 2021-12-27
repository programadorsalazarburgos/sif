<?php

namespace General\Persistencia\DAOS;

class NidosCirculacionDAO extends GestionDAO
{

    private $db;

    function __construct()
    {
        $this->db = $this->obtenerBD();
        $this->dbPDO = $this->obtenerPDOBD();
    }

    public function crearObjeto($objeto)
    {
        return;
    }
    public function modificarObjeto($objeto)
    {
        return;
    }
    public function eliminarObjeto($objeto)
    {
        return;
    }

    public function consultarObjeto($objeto)
    {
        return;
    }

    public function crearObjetoEvento($objeto)
    {

        $franja = explode(";", $objeto->getVcFranjaAtencion());
        for ($i = 0; $i < count($franja) - 1; $i++) {
            $sql = "INSERT INTO tb_nidos_evento_circulacion (IN_Dia, DT_Fecha_Evento, VC_Franja_Atencion, IN_Estado_Evento, IN_Aprobacion) VALUES (:dia, :fechaevento, :franja, :estado, :aprobacion)";
            @$sentencia = $this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':dia', $objeto->getInDia());
            @$sentencia->bindParam(':fechaevento', $objeto->getDtFechaEvento());
            @$sentencia->bindParam(':franja', $franja[$i]);
            @$sentencia->bindParam(':estado', $objeto->getInEstadoEvento());
            @$sentencia->bindParam(':aprobacion', $objeto->getInAprobacion());
            $sentencia->execute();
        }
        return $sentencia->rowCount();
    }

    public function consultarTipoEvento()
    {
        $sql = "SELECT FK_Value, VC_Descripcion FROM tb_parametro_detalle WHERE IN_Estado_Nidos = 1 AND FK_Id_Parametro = 47";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEquiposCirculacion()
    {
        $sql = "SELECT
        ND.Pk_Id_Dupla,
        ND.VC_Codigo_Dupla,
        (SELECT GROUP_CONCAT(CONCAT(' ',PER.VC_Primer_Nombre,' ',PER.VC_Primer_Apellido,' ') )
        FROM tb_nidos_dupla_artista DA, tb_persona_2017 PER WHERE DA.Fk_Id_Dupla = ND.Pk_Id_Dupla AND DA.Fk_Id_Persona = PER.PK_Id_Persona AND DA.IN_Estado=1)  AS 'ARTISTAS'      
        FROM tb_nidos_dupla AS ND 
        WHERE ND.Fk_Id_Territorio = 14 AND ND.IN_Estado = 1;";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarOfertaMensual($idmes)
    {
        $sql = "SELECT EC.Pk_Id_Evento AS 'ID_EVENTO',
        EC.IN_Dia AS 'DIA',
        EC.DT_Fecha_Evento AS 'FECHA',
        DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y') AS 'FECHA_TABLA',
        (CASE WHEN EC.VC_Franja_Atencion = '1' THEN 'AM' WHEN EC.VC_Franja_Atencion = '2' THEN 'PM' WHEN EC.VC_Franja_Atencion = '3' THEN 'AM Y PM' END) AS 'FRANJA',
        EC.VC_Franja_Atencion AS 'IDFRANJA',
        EC.VC_Nombre_Evento AS 'EVENTO',
        EC.VC_Lugar_Atencion AS 'IDLUGARATENCION',
        EC.Fk_Id_Localidad AS 'IDLOCALIDAD',
        PD.VC_Descripcion AS 'LOCALIDAD',
        EC.VC_Entidad_Dirigida AS 'ENTIDAD',
        CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'SOLICITA',
        EC.IN_Solicitud_Equipos AS 'SOLIEQUIPOS',
        PDA.VC_Descripcion AS 'T_ATENCION',
        EC.IN_Cantidad_Equipos AS 'EQUIPO',
        EC.IN_Solicitud_Equipos AS 'SOLICITUDEQU', 
        (SELECT GROUP_CONCAT(CONCAT(' ',DU.VC_Codigo_Dupla,' ') SEPARATOR 'Y'  )
        FROM tb_nidos_dupla DU
        WHERE FIND_IN_SET(DU.Pk_Id_Dupla, EC.IN_Cantidad_Equipos) > 0)  AS 'EQUIPOSASIG',
        EC.IN_Estado_Evento AS 'ESTADO',
        EC.IN_Solicitud_Informacion AS 'SOLICITUD',
        EC.IN_Tipo_Poblacion AS 'TIPO_POBLACION', 
        EC.VC_Tipo_Atencion AS 'VC_TIPO_ATENCION',
        (SELECT GROUP_CONCAT(CONCAT(' ',PD.VC_Descripcion,' ') SEPARATOR 'Y'  )
        FROM tb_parametro_detalle PD
        WHERE Fk_Id_Parametro = 51 AND FIND_IN_SET(PD.Fk_Value, EC.IN_Tipo_Poblacion) > 0)  AS 'MODALIDAD',
        EC.VC_Contacto_Lugar AS 'CONTACTO',
        EC.IN_Gestor_Asiste AS 'IDGESTOR',
        (CASE WHEN EC.IN_Gestor_Asiste = '2' THEN 'NO' WHEN EC.IN_Gestor_Asiste= '1' THEN 'SI' END) AS 'GESTOR', 
        EC.Fk_Id_Linea_Atencion AS 'LINEA',
        EC.VC_Propuesta_Atencion AS 'PROPUESTA',
        EC.Fk_Id_Tipo_Atencion AS 'TIPO_ATENCION',
        (CASE WHEN EC.VC_Otro_Tipo_Atencion IS NULL THEN 'N/A' ELSE EC.VC_Otro_Tipo_Atencion END) AS 'OTRO_TIPO_LUGAR',
        EC.VC_Otro_Tipo_Atencion,
        EC.IN_Ficha_Tecnica AS 'IDFICHA',      
        (CASE WHEN EC.IN_Ficha_Tecnica = '0' THEN 'NO' WHEN EC.IN_Ficha_Tecnica = '1' THEN 'SI' END) AS 'FICHA', 
        EC.VC_Transporte AS 'TRANSPORTE',
        EC.VC_Contacto_Transporte AS 'CONTAC_TRANS',
        EC.VC_Hora_Llegada_Transporte AS 'LLEGADA_TRANS', 
        EC.VC_Artistas_Locales AS 'ARTISTAS_APOYO',
        EC.VC_Particularidades_Terreno AS 'TERRENO',
        EC.VC_Lugar_Atencion AS 'LUGAR',
        EC.VC_Ubicacion AS 'UBICACION',
        EC.VC_Indicaciones_Llegada AS 'LLEGADA',
        EC.VC_Acompanamiento_Circulacion AS 'ACIRCULACION',
        EC.VC_Hora_Llegada_Artistas AS 'LLEGADAARTISTAS',
        EC.VC_Hora_Montaje_Nido AS 'MONTAJENIDO',
        EC.VC_Hora_Inicio_Atencion AS 'INICIOATENCION',
        EC.VC_Hora_Finalizacion AS 'FINALIZACION',
        EC.VC_Hora_Montaje AS 'MONTAJE',
        EC.VC_Hora_Desmontaje AS 'DESMONTAJE',
        EC.VC_Hora_Experiencia_Musical AS 'EMUSICAL',
        CONCAT(UP.IN_Codigo_Upz,'- ',UP.VC_Nombre_Upz ) AS 'UPZ',
        (SELECT
        GROUP_CONCAT(LA.VC_Nombre_Lugar SEPARATOR ', ')
        FROM tb_nidos_lugar_atencion LA
        WHERE FIND_IN_SET(LA.Pk_Id_lugar_atencion, EC.VC_Lugar_Atencion)) AS 'NOMLUGAR',
        -- LA.VC_Nombre_Lugar AS 'NOMLUGAR',
        LA.VC_Barrio AS 'BARRIO',
        LA.VC_Direccion AS 'DIRECCION',
        PDT.VC_Descripcion AS 'TIPOLUGAR',
        EC.IN_Num_Ninos AS 'NINOS',
        EC.IN_Num_Adultos AS 'ADULTOS'
        FROM tb_nidos_evento_circulacion AS EC
        LEFT JOIN tb_parametro_detalle AS PD ON EC.Fk_Id_Localidad = PD.FK_Value AND PD.FK_Id_Parametro = 19
        LEFT JOIN tb_parametro_detalle AS PDA ON EC.Fk_Id_Tipo_Atencion = PDA.FK_Value AND PDA.FK_Id_Parametro = 47
        LEFT JOIN tb_persona_2017 AS P ON EC.Fk_Id_Usuario_Solicita = P.PK_Id_Persona
        LEFT JOIN tb_nidos_lugar_atencion AS LA ON EC.VC_Lugar_Atencion = LA.Pk_Id_lugar_atencion
        LEFT JOIN tb_upz AS UP ON LA.Fk_Id_Upz = UP.Pk_Id_Upz
        LEFT JOIN tb_parametro_detalle AS PDT ON EC.Fk_Id_Tipo_Atencion = PDT.FK_Value AND PDT.FK_Id_Parametro = 50
        WHERE (EC.DT_Fecha_Evento BETWEEN '2021-$idmes-01' AND '2021-$idmes-31')";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarOfertaMensualGestor($idmes)
    {
        $sql = "SELECT
        EC.Pk_Id_Evento AS 'ID_EVENTO',
        EC.IN_Dia AS 'DIA',
        DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y') AS 'FECHA',
        (CASE
        WHEN EC.VC_Franja_Atencion = '1' THEN 'AM'
        WHEN EC.VC_Franja_Atencion = '2' THEN 'PM'
        WHEN EC.VC_Franja_Atencion = '3' THEN 'AM Y PM' END) AS 'FRANJA',
        EC.VC_Nombre_Evento AS 'EVENTO',
        PD.VC_Descripcion AS 'LOCALIDAD',
        EC.VC_Entidad_Dirigida AS 'ENTIDAD',
        CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS 'SOLICITA',
        EC.Fk_Id_Usuario_Solicita AS 'IDSOLICITA',
        EC.Fk_Id_Tipo_Atencion AS 'ID_ATENCION',
        COALESCE(EC.VC_Otro_Tipo_Atencion, '') AS 'OTRO_LUGAR',
        VC_Tipo_Atencion AS 'VC_TIPO_ATENCION',
        EC.IN_Solicitud_Equipos AS 'CANTIDADEQUIPOS',
        PDA.VC_Descripcion AS 'T_ATENCION',
        EC.IN_Cantidad_Equipos AS 'EQUIPO',
        EC.IN_Estado_Evento AS 'ESTADO',
        (SELECT COUNT(Pk_Id_Evento) 
        FROM tb_nidos_evento_circulacion AS NEC
        WHERE NEC.DT_Fecha_Evento = (SELECT EC.DT_Fecha_Evento
        FROM tb_nidos_evento_circulacion AS EC1
        WHERE EC1.Pk_Id_Evento = EC.Pk_Id_Evento) AND NEC.VC_Franja_Atencion = (SELECT EC.VC_Franja_Atencion
        FROM tb_nidos_evento_circulacion AS EC1
        WHERE EC1.Pk_Id_Evento = EC.Pk_Id_Evento) AND NEC.IN_Estado_Evento = 1) AS 'DISPONIBLE',
        (SELECT GROUP_CONCAT(CONCAT(NEC.Pk_Id_Evento) )
        FROM tb_nidos_evento_circulacion AS NEC
        WHERE NEC.DT_Fecha_Evento = (SELECT EC.DT_Fecha_Evento
        FROM tb_nidos_evento_circulacion AS EC1
        WHERE EC1.Pk_Id_Evento = EC.Pk_Id_Evento) AND NEC.VC_Franja_Atencion = (SELECT EC.VC_Franja_Atencion
        FROM tb_nidos_evento_circulacion AS EC1
        WHERE EC1.Pk_Id_Evento = EC.Pk_Id_Evento) AND NEC.IN_Estado_Evento = 1) AS 'ID_DISPONIBLE',
        EC.IN_Num_Ninos AS 'NINOS',
        EC.IN_Num_Adultos AS 'ADULTOS'
        FROM tb_nidos_evento_circulacion AS EC
        LEFT JOIN tb_parametro_detalle AS PD ON EC.Fk_Id_Localidad = PD.FK_Value AND PD.FK_Id_Parametro = 19
        LEFT JOIN tb_parametro_detalle AS PDA ON EC.Fk_Id_Tipo_Atencion = PDA.FK_Value AND PDA.FK_Id_Parametro = 50
        LEFT JOIN tb_persona_2017 AS P ON EC.Fk_Id_Usuario_Solicita = P.PK_Id_Persona
        WHERE (EC.DT_Fecha_Evento BETWEEN '2021-$idmes-01' AND '2021-$idmes-31')";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function modificarReservaGestor($objeto)
    {

        $ninos = explode(",", $objeto->getInCantidadEquipos());
        $primero = $ninos[0];

        for ($i = 0; $i < count($ninos) - 0; $i++) {

            if ($ninos[$i] == $primero) {

                $sql = "UPDATE tb_nidos_evento_circulacion SET VC_Nombre_Evento = :evento, Fk_Id_Localidad = :localidad, Fk_Id_Usuario_Solicita = :solicita, VC_Entidad_Dirigida = :entidad, Fk_Id_Tipo_Atencion = :atencion, VC_Otro_Tipo_Atencion = :otro_tipo_atencion, VC_Tipo_Atencion = :tipo_atencion, IN_Solicitud_Equipos = :solicitudEq, IN_Estado_Evento = :estado, IN_Num_Ninos = :numninos, IN_Num_Adultos = :numadultos WHERE Pk_Id_Evento = :idEvento";
                @$sentencia = $this->dbPDO->prepare($sql);
                @$sentencia->bindParam(':idEvento', $ninos[$i]);
                @$sentencia->bindParam(':evento', $objeto->getVcNombreEvento());
                @$sentencia->bindParam(':localidad', $objeto->getFkIdLocalidad());
                @$sentencia->bindParam(':solicita', $objeto->getFkIdUsuarioSolicita());
                @$sentencia->bindParam(':entidad', $objeto->getVcEntidadDirigida());
                @$sentencia->bindParam(':tipo_atencion', $objeto->getVcTipoAtencion());
                @$sentencia->bindParam(':otro_tipo_atencion', $objeto->getVcOtroTipoAtencion());
                @$sentencia->bindParam(':atencion', $objeto->getFkIdTipoAtencion());
                @$sentencia->bindParam(':solicitudEq', $objeto->getInSolicitudEquipos());
                @$sentencia->bindParam(':estado', $objeto->getInEstadoEvento());
                @$sentencia->bindParam(':numninos', $objeto->getInNumNinos());
                @$sentencia->bindParam(':numadultos', $objeto->getInNumAdultos());
                $sentencia->execute();
            } else {
                $sql1 = "UPDATE tb_nidos_evento_circulacion SET IN_Estado_Evento = '0' WHERE Pk_Id_Evento = :idEvento";
                @$sentencia = $this->dbPDO->prepare($sql1);
                @$sentencia->bindParam(':idEvento', $ninos[$i]);
                $sentencia->execute();
            }
        }
        return $sentencia->rowCount();
    }

    public function consultarMisEventoslGestor($idmes, $idusuario)
    {
        $sql = "SELECT EC.Pk_Id_Evento AS 'ID_EVENTO',
        EC.IN_Dia AS 'DIA',
        EC.DT_Fecha_Evento AS 'FECHA',
        (CASE 
        WHEN EC.VC_Franja_Atencion = '1' THEN 'AM'
        WHEN EC.VC_Franja_Atencion = '2' THEN 'PM'
        WHEN EC.VC_Franja_Atencion = '3' THEN 'AM Y PM' END) AS 'FRANJA',
        EC.VC_Nombre_Evento AS 'EVENTO',
        PD.VC_Descripcion AS 'LOCALIDAD',
        EC.VC_Entidad_Dirigida AS 'ENTIDAD',
        CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS 'SOLICITA', 
        EC.Fk_Id_Tipo_Atencion AS 'ID_ATENCION',
        PDA.VC_Descripcion AS 'T_ATENCION',
        EC.IN_Cantidad_Equipos AS 'EQUIPO', 
        EC.IN_Estado_Evento AS 'ESTADO'
        FROM tb_nidos_evento_circulacion AS EC
        LEFT JOIN tb_parametro_detalle AS PD ON EC.Fk_Id_Localidad = PD.FK_Value AND PD.FK_Id_Parametro = 19
        LEFT JOIN tb_parametro_detalle AS PDA ON EC.Fk_Id_Tipo_Atencion = PDA.FK_Value AND PDA.FK_Id_Parametro = 50
        LEFT JOIN tb_persona_2017 AS P ON EC.Fk_Id_Usuario_Solicita = P.PK_Id_Persona
        WHERE (EC.DT_Fecha_Evento BETWEEN '2021-$idmes-01' AND '2021-$idmes-31') AND EC.Fk_Id_Usuario_Solicita = $idusuario";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function confirmarEventoGestor($objeto)
    {
        $sql = "UPDATE tb_nidos_evento_circulacion SET  VC_Nombre_Evento = :evento, VC_Entidad_Dirigida = :entidad, Fk_Id_Tipo_Atencion =  :tipoAtencion, VC_Otro_Tipo_Atencion = :otro_tipo_atencion, VC_Tipo_Atencion= :tipo_atencion, IN_Solicitud_Informacion = :solicitudInformacion, IN_Tipo_Poblacion = :TipoPoblacion, VC_Lugar_Atencion = :lugar, VC_Contacto_Lugar = :contactoLugar, IN_Gestor_Asiste = :gestorAsiste, Fk_Id_Linea_Atencion = :lineaAtencion, VC_Propuesta_Atencion = :propuestaAtencion, VC_Transporte = :transporte, VC_Contacto_Transporte = :contactoTransporte, VC_Hora_Llegada_Transporte = :llegadaTransporte, VC_Artistas_Locales = :artistasLocales, VC_Particularidades_Terreno = :terreno, VC_Ubicacion = :ubicacion, VC_Indicaciones_Llegada = :indicaciones, IN_Estado_Evento = :estadoEvento, IN_Num_Ninos = :numninos, IN_Num_Adultos = :numadultos  WHERE Pk_Id_Evento = :idEvento";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idEvento', $objeto->getPkIdEvento());
        @$sentencia->bindParam(':evento', $objeto->getVcNombreEvento());
        @$sentencia->bindParam(':tipoAtencion', $objeto->getFkIdTipoAtencion());
        @$sentencia->bindParam(':otro_tipo_atencion', $objeto->getVcOtroTipoAtencion());
        @$sentencia->bindParam(':tipo_atencion', $objeto->getVcTipoAtencion());
        @$sentencia->bindParam(':entidad', $objeto->getVcEntidadDirigida());
        @$sentencia->bindParam(':contactoLugar', $objeto->getVcContactoLugar());
        @$sentencia->bindParam(':solicitudInformacion', $objeto->getInSolicitudInformacion());
        @$sentencia->bindParam(':TipoPoblacion', $objeto->getInTipoPoblacion());
        @$sentencia->bindParam(':gestorAsiste', $objeto->getInGestorAsiste());
        @$sentencia->bindParam(':lineaAtencion', $objeto->getFkIdLineaAtencion());
        @$sentencia->bindParam(':propuestaAtencion', $objeto->getVcPropuestaAtencion());
        @$sentencia->bindParam(':artistasLocales', $objeto->getvcArtistasLocales());
        @$sentencia->bindParam(':transporte', $objeto->getVcTransporte());
        @$sentencia->bindParam(':contactoTransporte', $objeto->getVcContactoTransporte());
        @$sentencia->bindParam(':llegadaTransporte', $objeto->getVcHoraLlegadaTransporte());
        @$sentencia->bindParam(':terreno', $objeto->getVcParticularidadesTerreno());
        @$sentencia->bindParam(':lugar', $objeto->getFkIdLugarAtencion());
        @$sentencia->bindParam(':ubicacion', $objeto->getVcUbicacion());
        @$sentencia->bindParam(':indicaciones', $objeto->getVcIndicacionesLlegada());
        @$sentencia->bindParam(':estadoEvento', $objeto->getInEstadoEvento());
        @$sentencia->bindParam(':numninos', $objeto->getInNumNinos());
        @$sentencia->bindParam(':numadultos', $objeto->getInNumAdultos());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function consultarEventoPreconfirmado($idmes, $idusuario)
    {
        $sql = "SELECT EC.Pk_Id_Evento AS 'IDEVENTO', EC.VC_Nombre_Evento AS 'NOM_EVENTO', EC.VC_Franja_Atencion AS 'FRANJA', PD.VC_Descripcion AS 'LOCALIDAD', 
        EC.VC_Entidad_Dirigida AS 'ENTIDAD', CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'SOLICITA', 
        EC.Fk_Id_Tipo_Atencion AS 'TIPO_ATENCION', EC.IN_Solicitud_Informacion AS 'SOLICITUD', EC.IN_Tipo_Poblacion AS 'TIPO_POBLACION', 
        EC.VC_Contacto_Lugar AS 'CONTACTO', EC.IN_Gestor_Asiste 'GESTOR', EC.Fk_Id_Linea_Atencion AS 'LINEA', EC.VC_Propuesta_Atencion AS 'PROPUESTA', 
        EC.IN_Ficha_Tecnica AS 'FICHA', EC.VC_Transporte AS 'TRANSPORTE', EC.VC_Contacto_Transporte AS 'CONTAC_TRANS', EC.VC_Hora_Llegada_Transporte AS 'LLEGADA_TRANS', 
        EC.VC_Artistas_Locales AS 'ARTISTAS_APOYO', EC.VC_Particularidades_Terreno AS 'TERRENO' 
        FROM tb_nidos_evento_circulacion AS EC
        JOIN tb_parametro_detalle AS PD ON EC.Fk_Id_Localidad = PD.FK_Value AND PD.FK_Id_Parametro = 19
        JOIN tb_persona_2017 AS P ON EC.Fk_Id_Usuario_Solicita = P.PK_Id_Persona 
        WHERE EC.Pk_Id_Evento = 17";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function AprobarEventoCirculacion($objeto)
    {
        $sql = "UPDATE tb_nidos_evento_circulacion SET IN_Solicitud_Informacion = :solicitudInformacion, IN_Tipo_Poblacion = :TipoPoblacion, VC_Lugar_Atencion = :lugar, Fk_Id_Tipo_Atencion =  :tipoAtencion, Fk_Id_Linea_Atencion = :lineaAtencion, VC_Propuesta_Atencion = :propuestaAtencion, IN_Ficha_Tecnica = :fichatecnica, VC_Transporte = :transporte, VC_Contacto_Transporte = :contactoTransporte, VC_Hora_Llegada_Transporte = :llegadaTransporte, VC_Particularidades_Terreno = :terreno, VC_Ubicacion = :ubicacion, VC_Indicaciones_Llegada = :indicaciones, IN_Cantidad_Equipos = :equipo, VC_Acompanamiento_Circulacion = :Acompanamiento, VC_Hora_Llegada_Artistas = :HoraLlegada, VC_Hora_Montaje_Nido = :HoraMontajeNido, VC_Hora_Inicio_Atencion = :HoraInicio, VC_Hora_Finalizacion = :HoraFinalizacion, VC_Hora_Montaje = :HoraMontaje, VC_Hora_Desmontaje = :HoraDesmontaje, IN_Estado_Evento = :estadoEvento WHERE Pk_Id_Evento = :idEvento";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idEvento', $objeto->getPkIdEvento());
        @$sentencia->bindParam(':solicitudInformacion', $objeto->getInSolicitudInformacion());
        @$sentencia->bindParam(':TipoPoblacion', $objeto->getInTipoPoblacion());
        @$sentencia->bindParam(':tipoAtencion', $objeto->getFkIdTipoAtencion());
        @$sentencia->bindParam(':lineaAtencion', $objeto->getFkIdLineaAtencion());
        @$sentencia->bindParam(':propuestaAtencion', $objeto->getVcPropuestaAtencion());
        @$sentencia->bindParam(':transporte', $objeto->getVcTransporte());
        @$sentencia->bindParam(':contactoTransporte', $objeto->getVcContactoTransporte());
        @$sentencia->bindParam(':llegadaTransporte', $objeto->getVcHoraLlegadaTransporte());
        @$sentencia->bindParam(':terreno', $objeto->getVcParticularidadesTerreno());
        @$sentencia->bindParam(':lugar', $objeto->getFkIdLugarAtencion());
        @$sentencia->bindParam(':ubicacion', $objeto->getVcUbicacion());
        @$sentencia->bindParam(':indicaciones', $objeto->getVcIndicacionesLlegada());
        @$sentencia->bindParam(':equipo', $objeto->getInCantidadEquipos());
        @$sentencia->bindParam(':fichatecnica', $objeto->getInFichaTecnica());
        @$sentencia->bindParam(':Acompanamiento', $objeto->getVcAcompanamientoCirculacion());
        @$sentencia->bindParam(':HoraLlegada', $objeto->getVcHoraLlegadaArtistas());
        @$sentencia->bindParam(':HoraMontajeNido', $objeto->getVcHoraMontajeNido());
        @$sentencia->bindParam(':HoraInicio', $objeto->getVcHoraInicioAtencion());
        @$sentencia->bindParam(':HoraFinalizacion', $objeto->getVcHoraFinalizacion());
        @$sentencia->bindParam(':HoraMontaje', $objeto->getVcHoraMontaje());
        @$sentencia->bindParam(':HoraDesmontaje', $objeto->getVcHoraDesmontaje());
        @$sentencia->bindParam(':estadoEvento', $objeto->getInEstadoEvento());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function EditarEventoCirculacion($objeto)
    {
        $sql = "UPDATE tb_nidos_evento_circulacion SET IN_Dia = :dia, DT_Fecha_Evento = :fechaEvento, VC_Franja_Atencion = :franja, VC_Nombre_Evento = :NombreEvento, VC_Lugar_Atencion = :lugar, Fk_Id_Localidad = :Localidad, Fk_Id_Tipo_Atencion = :tipoAtencion, 
        VC_Otro_Tipo_Atencion = :otro_tipo, VC_Entidad_Dirigida = :Entidad, Fk_Id_Linea_Atencion = :lineaAtencion, VC_Tipo_Atencion = :tipo_atencion, IN_Tipo_Poblacion = :TipoPoblacion, IN_Gestor_Asiste = :Gestor, VC_Contacto_Lugar = :Contacto, VC_Propuesta_Atencion = :propuestaAtencion, VC_Artistas_Locales = :artistas, VC_Transporte = :transporte, VC_Contacto_Transporte = :contactoTransporte, VC_Hora_Llegada_Transporte = :llegadaTransporte,  VC_Particularidades_Terreno = :terreno,  VC_Ubicacion = :ubicacion, VC_Indicaciones_Llegada = :indicaciones, IN_Cantidad_Equipos = :equipoasignado, IN_Ficha_Tecnica = :fichatecnica, VC_Acompanamiento_Circulacion = :Acompanamiento, VC_Hora_Llegada_Artistas = :HoraLlegada, VC_Hora_Montaje = :HoraMontaje, VC_Hora_Montaje_Nido = :HoraMontajeNido, VC_Hora_Inicio_Atencion = :HoraInicio, VC_Hora_Finalizacion = :HoraFinalizacion, VC_Hora_Desmontaje = :HoraDesmontaje, IN_Num_Ninos = :ninos, IN_Num_Adultos = :adultos WHERE Pk_Id_Evento = :idEvento";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idEvento', $objeto->getPkIdEvento());
        @$sentencia->bindParam(':dia', $objeto->getInDia());
        @$sentencia->bindParam(':fechaEvento', $objeto->getDtFechaEvento());
        @$sentencia->bindParam(':franja', $objeto->getVcFranjaAtencion());
        @$sentencia->bindParam(':NombreEvento', $objeto->getVcNombreEvento());
        @$sentencia->bindParam(':Localidad', $objeto->getFkIdLocalidad());
        @$sentencia->bindParam(':lugar', $objeto->getFkIdLugarAtencion());
        @$sentencia->bindParam(':Entidad', $objeto->getVcEntidadDirigida());
        @$sentencia->bindParam(':lineaAtencion', $objeto->getFkIdLineaAtencion());
        @$sentencia->bindParam(':TipoPoblacion', $objeto->getInTipoPoblacion());
        @$sentencia->bindParam(':Gestor', $objeto->getInGestorAsiste());
        @$sentencia->bindParam(':Contacto', $objeto->getVcContactoLugar());
        @$sentencia->bindParam(':tipoAtencion', $objeto->getFkIdTipoAtencion());
        @$sentencia->bindParam(':otro_tipo', $objeto->getVcOtroTipoAtencion());
        @$sentencia->bindParam(':tipo_atencion', $objeto->getVcTipoAtencion());

        @$sentencia->bindParam(':propuestaAtencion', $objeto->getVcPropuestaAtencion());
        @$sentencia->bindParam(':artistas', $objeto->getvcArtistasLocales());
        @$sentencia->bindParam(':transporte', $objeto->getVcTransporte());
        @$sentencia->bindParam(':contactoTransporte', $objeto->getVcContactoTransporte());
        @$sentencia->bindParam(':llegadaTransporte', $objeto->getVcHoraLlegadaTransporte());
        @$sentencia->bindParam(':terreno', $objeto->getVcParticularidadesTerreno());
        @$sentencia->bindParam(':ubicacion', $objeto->getVcUbicacion());
        @$sentencia->bindParam(':indicaciones', $objeto->getVcIndicacionesLlegada());

        @$sentencia->bindParam(':equipoasignado', $objeto->getInCantidadEquipos());
        @$sentencia->bindParam(':fichatecnica', $objeto->getInFichaTecnica());
        @$sentencia->bindParam(':Acompanamiento', $objeto->getVcAcompanamientoCirculacion());

        @$sentencia->bindParam(':HoraLlegada', $objeto->getVcHoraLlegadaArtistas());
        @$sentencia->bindParam(':HoraMontaje', $objeto->getVcHoraMontaje());
        @$sentencia->bindParam(':HoraMontajeNido', $objeto->getVcHoraMontajeNido());

        @$sentencia->bindParam(':HoraInicio', $objeto->getVcHoraInicioAtencion());
        @$sentencia->bindParam(':HoraFinalizacion', $objeto->getVcHoraFinalizacion());
        @$sentencia->bindParam(':HoraDesmontaje', $objeto->getVcHoraDesmontaje());

        @$sentencia->bindParam(':ninos', $objeto->getInNumNinos());
        @$sentencia->bindParam(':adultos', $objeto->getInNumAdultos());

        $sentencia->execute();
        return $sentencia->rowCount();
    }


    public function CancelarEventoCirculacion($objeto)
    {
        $sql = "UPDATE tb_nidos_evento_circulacion SET IN_Estado_Evento = :estadoEvento WHERE Pk_Id_Evento = :idEvento";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idEvento', $objeto->getPkIdEvento());
        @$sentencia->bindParam(':estadoEvento', $objeto->getInEstadoEvento());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function consultarInformacionEventoAprobado($idEvento)
    {
        $sql = "SELECT
        EC.Pk_Id_Evento AS 'ID_EVENTO',
        EC.VC_Nombre_Evento AS 'EVENTO',
        EC.IN_Dia AS 'DIA', 
        DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y') AS 'FECHA',
        LA.VC_Nombre_Lugar AS 'LUGAR',
        LA.VC_Barrio AS 'BARRIO', 
        LA.VC_Direccion AS 'DIRECCION',
        LO.VC_Nom_Localidad AS 'LOCALIDAD',
        COALESCE(EC.VC_Hora_Inicio_Atencion, '') AS 'INICIO',
        COALESCE(EC.VC_Hora_Finalizacion, '') AS 'FINALIZACION',
        PD.VC_Descripcion AS 'TIPOLUGAR',
        (CASE
        WHEN EC.VC_Otro_Tipo_Atencion IS NULL THEN 'N/A'
        WHEN EC.VC_Otro_Tipo_Atencion = '' THEN 'N/A'
        WHEN EC.VC_Otro_Tipo_Atencion != '' THEN EC.VC_Otro_Tipo_Atencion 
        END) AS 'OTRO_LUGAR',
        EC.VC_Contacto_Lugar AS 'CONTACTO',
        EC.VC_Hora_Llegada_Artistas AS 'LLEGADAARTISTAS',
        EC.VC_Hora_Montaje AS 'MONTAJE',
        EC.VC_Hora_Desmontaje AS 'DESMONTAJE',
        EC.VC_Ubicacion AS 'UBICACION',
        EC.VC_Indicaciones_Llegada AS 'INDICACION',
        EC.VC_Transporte AS 'TRANSPORTE',
        EC.VC_Contacto_Transporte AS 'CONTACTO_TRANSPORTE',
        EC.VC_Hora_Llegada_Transporte AS 'LLEGADA_TRANSPORTE',
        EC.VC_Particularidades_Terreno AS 'PARTICULARIDADES_TERRENO',
        CONCAT(UPPER(SUBSTRING(P.VC_Primer_Nombre,1,1)), LOWER(SUBSTRING(P.VC_Primer_Nombre,2)) ,' ', UPPER(SUBSTRING(P.VC_Primer_Apellido,1,1)), LOWER(SUBSTRING(P.VC_Primer_Apellido,2))) AS 'SOLICITA',
        (SELECT GROUP_CONCAT(CONCAT(' ',PD.VC_Descripcion,' ') SEPARATOR 'Y'  )
        FROM tb_parametro_detalle PD
        WHERE  Fk_Id_Parametro =  51 AND FIND_IN_SET(PD.Fk_Value, EC.IN_Tipo_Poblacion) > 0)  AS 'MODALIDAD', 
        EC.VC_Propuesta_Atencion AS 'PROPUESTA', 
        (SELECT GROUP_CONCAT(CONCAT(' ',DU.VC_Codigo_Dupla,' ') SEPARATOR 'Y'  )
        FROM tb_nidos_dupla DU
        WHERE FIND_IN_SET(DU.Pk_Id_Dupla, EC.IN_Cantidad_Equipos) > 0)  AS 'EQUIPOSASIG'
        FROM tb_nidos_evento_circulacion AS EC
        JOIN tb_nidos_lugar_atencion AS LA ON EC.VC_Lugar_Atencion = LA.Pk_Id_lugar_atencion
        JOIN tb_localidades AS LO ON LA.Fk_Id_Localidad = LO.Pk_Id_Localidad
        LEFT JOIN tb_parametro_detalle AS PD ON EC.Fk_Id_Tipo_Atencion = PD.FK_Value AND PD.FK_Id_Parametro =  50
        LEFT JOIN tb_persona_2017 AS P on P.PK_Id_Persona=EC.Fk_Id_Usuario_Solicita
        WHERE EC.Pk_Id_Evento = :IdEvento";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':IdEvento', $idEvento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function consultarEquiposAprobado($idEvento)
    {
        $sql = "SELECT DU.VC_Codigo_Dupla AS 'EQUIPO',
        (SELECT GROUP_CONCAT(CONCAT(' ',PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido,' ') SEPARATOR 'Y' ) 
        FROM tb_nidos_dupla_artista AS DA 
        JOIN tb_persona_2017 AS PE ON DA.Fk_Id_Persona = PE.PK_Id_Persona
        WHERE IN_Estado = 1 AND DA.Fk_Id_Dupla = DU.Pk_Id_Dupla) AS 'ARTISTAS', DU.VC_Descripcion AS 'DESCRIPCION'
        FROM tb_nidos_dupla AS DU
        JOIN tb_nidos_evento_circulacion AS EC 
        WHERE FIND_IN_SET(DU.Pk_Id_Dupla, EC.IN_Cantidad_Equipos) AND EC.Pk_Id_Evento = :IdEvento";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':IdEvento', $idEvento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarEventosEquipo($id_mes, $id_usuario, $tipo_persona)
    {
        if ($tipo_persona == 34) {
            $sql = "SELECT
            EC.Pk_Id_Evento,
            CONCAT(EC.VC_Nombre_Evento, ' - ', DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y')) AS 'Evento'
            FROM tb_nidos_evento_circulacion AS EC
            WHERE FIND_IN_SET(
            (SELECT
            DA.Fk_Id_Dupla
            FROM tb_nidos_dupla_artista AS DA
            WHERE DA.Fk_Id_Persona=:id_usuario AND DA.IN_Estado='1'), EC.IN_Cantidad_Equipos) AND (DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') AND EC.IN_Estado_Evento=4";

            $sentencia = $this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':id_usuario', $id_usuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT
            EC.Pk_Id_Evento,
            CONCAT(EC.VC_Nombre_Evento, ' - ', DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y')) AS 'Evento'
            FROM tb_nidos_evento_circulacion AS EC
            WHERE (DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') AND EC.IN_Estado_Evento=4";

            $sentencia = $this->dbPDO->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function getLugarAtencionEvento($id_evento)
    {
        $sql = "SELECT
        GROUP_CONCAT(ec.VC_Lugar_Atencion) AS 'id_lugar',
        (SELECT
        GROUP_CONCAT(la.VC_Nombre_Lugar)
        FROM tb_nidos_lugar_atencion la
        WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion, ec.VC_Lugar_Atencion)
        ) AS 'nombre_lugar'
        FROM tb_nidos_evento_circulacion ec
        WHERE ec.Pk_Id_Evento=:id_evento";

        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_evento', $id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarInformacionEvento($idEvento)
    {
        $sql = "SELECT
        EC.Pk_Id_Evento AS 'IDEVENTO',
        EC.IN_Dia AS 'DIA',
        DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y') AS 'FECHA',
        EC.DT_Fecha_Evento AS 'FECHA_CALCULO',
        (CASE WHEN EC.VC_Franja_Atencion = '1' THEN 'AM' WHEN EC.VC_Franja_Atencion = '2' THEN 'PM' WHEN EC.VC_Franja_Atencion = '3' THEN 'AM Y PM' END) AS 'FRANJA', 
        EC.VC_Nombre_Evento AS 'EVENTO',
        PD.VC_Descripcion AS 'LOCALIDAD',
        EC.VC_Entidad_Dirigida AS 'ENTIDAD',
        (SELECT
        GROUP_CONCAT(LA.VC_Nombre_Lugar SEPARATOR ', ')
        FROM tb_nidos_lugar_atencion LA
        WHERE FIND_IN_SET(LA.Pk_Id_lugar_atencion, EC.VC_Lugar_Atencion)) AS 'LUGAR',
        -- LA.VC_Nombre_Lugar AS 'LUGAR',
        EC.VC_Hora_Inicio_Atencion AS 'INICIO', 
        EC.VC_Hora_Finalizacion AS 'FINALIZACION',
        COALESCE(EC.IN_Num_Artistas, '') AS 'NUMERO_ARTISTAS',
        COALESCE(EC.IN_Num_Grupos, '') AS 'NUMERO_GRUPOS',
        COALESCE(EC.IN_Espacio_Publico, '') AS 'ESPACIO_PUBLICO',
        COALESCE(EC.IN_Experiencias, '') AS 'NUMERO_EXPERIENCIAS',
        COALESCE(EC.IN_Cuidadores, '') AS 'NUMERO_CUIDADORES',
        COALESCE(EC.VC_Listado_Asistencia, '') AS 'LISTADO_ASISTENCIA',
        EC.IN_Aprobacion AS 'APROBACION'
        FROM tb_nidos_evento_circulacion AS EC
        JOIN tb_parametro_detalle AS PD ON EC.Fk_Id_Localidad = PD.FK_Value AND PD.FK_Id_Parametro = '19'
        LEFT JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=EC.VC_Lugar_Atencion
        WHERE EC.Pk_Id_Evento = $idEvento";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarlugaresAencionDAO($idLugarEvento)
    {
        $sql = "SELECT LA.Pk_Id_lugar_atencion, LA.VC_Nombre_Lugar 
        FROM tb_nidos_evento_circulacion AS EC
        JOIN tb_nidos_lugar_atencion AS LA ON EC.Fk_Id_Localidad = LA.Fk_Id_Localidad
        WHERE EC.Pk_Id_Evento = :idLugarEvento";
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idLugarEvento', $idLugarEvento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarInformacionlugarerDAO($idlugarA)
    {
        $sql = "SELECT LU.Pk_Id_lugar_atencion, LU.Fk_Id_Localidad, LU.Fk_Id_Upz, LU.VC_Barrio, 
        LU.Fk_Id_Entidad, LU.VC_Tipo_Lugar, LU.VC_Nombre_Lugar, LU.VC_Direccion
        FROM tb_nidos_lugar_atencion AS LU WHERE Pk_Id_lugar_atencion = $idlugarA";
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idlugarA', $idlugarA);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function crearObjetoLugar($objeto)
    {
        $sql = "INSERT INTO tb_nidos_lugar_atencion (Fk_Id_Localidad,Fk_Id_Upz,VC_Barrio,fk_Id_Entidad,VC_Tipo_Lugar,VC_Nombre_Lugar,VC_Direccion,IN_Estado,Fk_Id_Usuario_Crea,DT_Fecha_Creacion)
        VALUES (:localidad, :upz, :barrio, :Entidad, :tipolugar, :nomlugar, :direccion, :estado, :usuario, :fecha_creacion)";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':localidad', $objeto->getFkLocalidad());
        @$sentencia->bindParam(':upz', $objeto->getFkUpz());
        @$sentencia->bindParam(':barrio', $objeto->getVcBarrio());
        @$sentencia->bindParam(':Entidad', $objeto->getFkIdEntidad());
        @$sentencia->bindParam(':tipolugar', $objeto->getVcTipoLugar());
        @$sentencia->bindParam(':nomlugar', $objeto->getVcNombreLugar());
        @$sentencia->bindParam(':direccion', $objeto->getVcDireccion());
        @$sentencia->bindParam(':estado', $objeto->getVcEstado());
        @$sentencia->bindParam(':usuario', $objeto->getUsuarioCrea());
        @$sentencia->bindParam(':fecha_creacion', $objeto->getDtFechaCreacion());
        //$this->dbPDO->beginTransaction();
        $sentencia->execute();
        $id_insertado = $this->dbPDO->lastInsertId();
        return $id_insertado;
    }

    public function modificarObjetoLugar($objeto)
    {
        $sql = "UPDATE tb_nidos_lugar_atencion SET  Fk_Id_Localidad = :localidad,  Fk_Id_Upz = :upz, VC_Barrio = :barrio, fk_Id_Entidad = :Entidad, VC_Tipo_Lugar = :tipolugar, VC_Nombre_Lugar = :nomlugar, VC_Direccion = :direccion,  IN_Estado = :estado WHERE Pk_Id_lugar_atencion = :idLugar";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idLugar', $objeto->getPkJardin());
        @$sentencia->bindParam(':localidad', $objeto->getFkLocalidad());
        @$sentencia->bindParam(':upz', $objeto->getFkUpz());
        @$sentencia->bindParam(':barrio', $objeto->getVcBarrio());
        @$sentencia->bindParam(':Entidad', $objeto->getFkIdEntidad());
        @$sentencia->bindParam(':tipolugar', $objeto->getVcTipoLugar());
        @$sentencia->bindParam(':nomlugar', $objeto->getVcNombreLugar());
        @$sentencia->bindParam(':direccion', $objeto->getVcDireccion());
        @$sentencia->bindParam(':estado', $objeto->getVcEstado());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function guardarAsistentesEvento($objeto)
    {
        $sql = "INSERT INTO tb_nidos_asistentes_evento (Fk_Id_Evento, FK_Id_Lugar_Atencion, VC_Ninos_0_3, VC_Ninos_4_6, VC_Ninos_6_10, VC_Ninas_0_3, VC_Ninas_4_6, VC_Ninas_6_10, VC_Madres, TX_Observacion, DT_Fecha_Registro, Fk_Id_Artista_Registro) VALUES (:id_evento, :id_lugar_atencion, :ninos_0_3, :ninos_4_6, :ninos_6_10, :ninas_0_3, :ninas_4_6, :ninas_6_10, :madres, :observacion, :fecha_registro, :id_usuario)";

        @$sentencia = $this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':id_evento', $objeto->getFkIdEvento());
        @$sentencia->bindParam(':id_lugar_atencion', $objeto->getFkIdLugarAtencion());
        @$sentencia->bindParam(':ninos_0_3', $objeto->getVcNinos03());
        @$sentencia->bindParam(':ninos_4_6', $objeto->getVcNinos46());
        @$sentencia->bindParam(':ninos_6_10', $objeto->getVcNinos610());
        @$sentencia->bindParam(':ninas_0_3', $objeto->getVcNinas03());
        @$sentencia->bindParam(':ninas_4_6', $objeto->getVcNinas46());
        @$sentencia->bindParam(':ninas_6_10', $objeto->getVcNinas610());
        @$sentencia->bindParam(':madres', $objeto->getVcMadres());
        @$sentencia->bindParam(':observacion', $objeto->getTxObservacion());
        @$sentencia->bindParam(':fecha_registro', $objeto->getDtFechaRegistro());
        @$sentencia->bindParam(':id_usuario', $objeto->getFkIdArtistaRegistro());

        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function guardarBeneficiariosEvento($objeto)
    {
        $sql = "INSERT INTO tb_nidos_beneficiarios(
        VC_Identificacion,
        FK_Tipo_Identificacion,
        VC_Primer_Nombre,
        VC_Segundo_Nombre,
        VC_Primer_Apellido,
        VC_Segundo_Apellido,
        DD_F_Nacimiento,
        FK_Id_Genero,
        IN_Grupo_Poblacional,
        IN_Estrato,
        Fk_Id_Usuario_Registra,
        DT_Fecha_Registro)
        VALUES (:identificacion, :tidentifi, :pnombre, :snombre, :papellido, :sapellido, :fnacimiento, :genero, :etnia, :estrato, :id_usuario, :fechacreacion)  
        ON DUPLICATE KEY UPDATE VC_Identificacion=VC_Identificacion";

        @$sentencia = $this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':identificacion', $objeto->getVcIdentificacion());
        @$sentencia->bindParam(':tidentifi', $objeto->getFkTipoIdentificacion());
        @$sentencia->bindParam(':pnombre', $objeto->getVcPrimerNombre());
        @$sentencia->bindParam(':snombre', $objeto->getVcSegundoNombre());
        @$sentencia->bindParam(':papellido', $objeto->getVcPrimerApellido());
        @$sentencia->bindParam(':sapellido', $objeto->getVcSegundoApellido());
        @$sentencia->bindParam(':fnacimiento', $objeto->getDdFNacimiento());
        @$sentencia->bindParam(':genero', $objeto->getFkIdGenero());
        @$sentencia->bindParam(':etnia', $objeto->getInGrupoPoblacional());
        @$sentencia->bindParam(':estrato', $objeto->getInIdentificacionPoblacional());;
        @$sentencia->bindParam(':fechacreacion', $objeto->getDtFechaRegistro());
        @$sentencia->bindParam(':id_usuario', $objeto->getFkIdUsuarioRegistra());

        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function guardarAsistenciaEvento($objeto)
    {
        $sql = "INSERT INTO tb_nidos_asistencia(
        Fk_Id_Evento,
        Fk_Id_Beneficiario,
        Vc_Asistencia,
        VC_Nivel,
        Fk_Id_Lugar_Atencion_Evento)
        VALUES (:id_evento, (SELECT Pk_Id_Beneficiario FROM tb_nidos_beneficiarios WHERE VC_Identificacion=:numdoc) , 1, :nivel, :id_lugar_atencion)";

        @$sentencia = $this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':id_evento', $objeto->getFkIdEvento());
        @$sentencia->bindParam(':numdoc', $objeto->getFkIdBeneficiario());
        @$sentencia->bindParam(':nivel', $objeto->getVcNivel());
        @$sentencia->bindParam(':id_lugar_atencion', $objeto->getFkIdLugarAtencionEvento());

        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function getReporteEvento($id_mes, $id_usuario)
    {

        $sql = "SELECT
        PRIMERA.Pk_Id_Evento,
        DT_Fecha_Evento,
        VC_Nombre_Evento, 
        VC_Nombre_Lugar,
        Vc_Descripcion, 
        VC_Nom_Localidad, 
        UPZ,
        VC_Barrio,
        MODALIDADATENCION,
        EQUIPOSASIGNADOS, 
        IN_Num_Artistas,
        IN_Num_Grupos,  
        IN_Experiencias,
        IN_Cuidadores,  
        IN_Aprobacion,  
        COALESCE(VC_Listado_Asistencia, '') as LISTADO_ASISTENCIA,
        COALESCE(NINOS_DE_0_3_ANIOS_N,0) as NINOS_DE_0_3_ANIOS_N,
        COALESCE(NINAS_DE_0_3_ANIOS_N,0) as NINAS_DE_0_3_ANIOS_N,
        COALESCE(TOTAL_DE_0_3_ANIOS_N,0) as TOTAL_DE_0_3_ANIOS_N,
        COALESCE(NINOS_DE_4_6_ANIOS_N,0) as NINOS_DE_4_6_ANIOS_N,
        COALESCE(NINAS_DE_4_6_ANIOS_N,0) as NINAS_DE_4_6_ANIOS_N,
        COALESCE(TOTAL_DE_4_6_ANIOS_N,0) as TOTAL_DE_4_6_ANIOS_N,
        COALESCE(NINOS_FUERA_RANGO_N,0) as NINOS_FUERA_RANGO_N,  
        COALESCE(NINAS_FUERA_RANGO_N,0) as NINAS_FUERA_RANGO_N,  
        COALESCE(TOTAL_NINOS_FUERA_RANGO_N,0) as TOTAL_NINOS_FUERA_RANGO_N,
        COALESCE(GESTANTES_N,0) AS GESTANTES_N,  
        COALESCE(TOTAL_N,0) AS TOTAL_N,
        COALESCE(CAMPESINA_N,0) AS CAMPESINA_N,  
        COALESCE(INDIGENA_N,0) AS INDIGENA_N,
        COALESCE(AFRODESCENDIENTE_N,0) AS AFRODESCENDIENTE_N, 
        COALESCE(ROM_N,0) AS ROM_N,
        COALESCE(RAIZALES_N,0) AS RAIZALES_N,
        COALESCE(PALENQUERA_N,0) AS PALENQUERA_N,
        COALESCE(COMUNIDADES_NEGRAS_N,0) AS COMUNIDADES_NEGRAS_N,
        COALESCE(POBLACION_CARCELARIA_N,0) AS POBLACION_CARCELARIA_N,
        COALESCE(DISCAPACIDAD_N,0) AS DISCAPACIDAD_N,  
        COALESCE(PERSONAS_HABITANTES_CALLE_N,0) AS PERSONAS_HABITANTES_CALLE_N,
        COALESCE(PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N,0) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N,
        COALESCE(POBLACION_VICTIMA_CONFLICTO_N,0) AS POBLACION_VICTIMA_CONFLICTO_N,  
        COALESCE(DESPLAZAMIENTO_N,0) AS DESPLAZAMIENTO_N,  
        COALESCE(MIGRANTES_N,0) AS MIGRANTES_N,  
        COALESCE(DETERIORO_URBANO_N,0) AS DETERIORO_URBANO_N, 
        COALESCE(EMERGENCIA_SOCIAL_N,0) AS EMERGENCIA_SOCIAL_N,  
        COALESCE(LGBTIQ_N,0) AS LGBTIQ_N, 
        COALESCE(TOTAL_EN_N,0) AS TOTAL_EN_N,
        COALESCE(NINOS_DE_0_3_ANIOS_R,0) + COALESCE((NINOS_DE_0_3_ANIOS_S), 0) as NINOS_DE_0_3_ANIOS_R,
        COALESCE(NINAS_DE_0_3_ANIOS_R,0) + COALESCE((NINAS_DE_0_3_ANIOS_S), 0) as NINAS_DE_0_3_ANIOS_R,
        COALESCE(TOTAL_DE_0_3_ANIOS_R,0) + COALESCE((TOTAL_DE_0_3_ANIOS_S), 0) as TOTAL_DE_0_3_ANIOS_R,
        COALESCE(NINOS_DE_4_6_ANIOS_R,0) + COALESCE((NINOS_DE_4_6_ANIOS_S), 0) as NINOS_DE_4_6_ANIOS_R,
        COALESCE(NINAS_DE_4_6_ANIOS_R,0) + COALESCE((NINAS_DE_4_6_ANIOS_S), 0) as NINAS_DE_4_6_ANIOS_R,
        COALESCE(TOTAL_DE_4_6_ANIOS_R,0) + COALESCE((TOTAL_DE_4_6_ANIOS_S), 0) as TOTAL_DE_4_6_ANIOS_R,
        COALESCE(NINOS_FUERA_RANGO_R,0) + COALESCE((NINOS_DE_6_10_ANIOS_S), 0) as NINOS_FUERA_RANGO_R,
        COALESCE(NINAS_FUERA_RANGO_R,0) + COALESCE((NINAS_DE_6_10_ANIOS_S), 0) as NINAS_FUERA_RANGO_R,
        COALESCE(TOTAL_NINOS_FUERA_RANGO_R,0) + COALESCE((TOTAL_NINOS_DE_6_10_ANIOS_S), 0) as TOTAL_NINOS_FUERA_RANGO_R,
        COALESCE(GESTANTES_R,0) + COALESCE((GESTANTES_S), 0) AS GESTANTES_R,
        COALESCE(TOTAL_R,0) + COALESCE((TOTAL_S), 0) AS TOTAL_R, 
        COALESCE(CAMPESINA_R,0) AS CAMPESINA_R,  
        COALESCE(INDIGENA_R,0) AS INDIGENA_R,
        COALESCE(AFRODESCENDIENTE_R,0) AS AFRODESCENDIENTE_R, 
        COALESCE(ROM_R,0) AS ROM_R,
        COALESCE(RAIZALES_R,0) AS RAIZALES_R,
        COALESCE(PALENQUERA_R,0) AS PALENQUERA_R,
        COALESCE(COMUNIDADES_NEGRAS_R,0) AS COMUNIDADES_NEGRAS_R,
        COALESCE(POBLACION_CARCELARIA_R,0) AS POBLACION_CARCELARIA_R,
        COALESCE(DISCAPACIDAD_R,0) AS DISCAPACIDAD_R,  
        COALESCE(PERSONAS_HABITANTES_CALLE_R,0) AS PERSONAS_HABITANTES_CALLE_R,
        COALESCE(PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R,0) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R,
        COALESCE(POBLACION_VICTIMA_CONFLICTO_R,0) AS POBLACION_VICTIMA_CONFLICTO_R,  
        COALESCE(DESPLAZAMIENTO_R,0) AS DESPLAZAMIENTO_R,  
        COALESCE(MIGRANTES_R,0) AS MIGRANTES_R,  
        COALESCE(DETERIORO_URBANO_R,0) AS DETERIORO_URBANO_R, 
        COALESCE(EMERGENCIA_SOCIAL_R,0) AS EMERGENCIA_SOCIAL_R,  
        COALESCE(LGBTIQ_R,0) AS LGBTIQ_R, 
        COALESCE(TOTAL_EN_R,0) AS TOTAL_EN_R, 
        COALESCE(NINOS_DE_0_3_ANIOS_S,0) AS NINOS_DE_0_3_ANIOS_S,
        COALESCE(NINAS_DE_0_3_ANIOS_S,0) AS NINAS_DE_0_3_ANIOS_S,
        COALESCE(TOTAL_DE_0_3_ANIOS_S,0) AS TOTAL_DE_0_3_ANIOS_S,
        COALESCE(NINOS_DE_4_6_ANIOS_S,0) AS NINOS_DE_4_6_ANIOS_S,
        COALESCE(NINAS_DE_4_6_ANIOS_S,0) AS NINAS_DE_4_6_ANIOS_S,
        COALESCE(TOTAL_DE_4_6_ANIOS_S,0) AS TOTAL_DE_4_6_ANIOS_S,
        COALESCE(NINOS_DE_6_10_ANIOS_S,0) AS NINOS_DE_6_10_ANIOS_S,  
        COALESCE(NINAS_DE_6_10_ANIOS_S,0) AS NINAS_DE_6_10_ANIOS_S,  
        COALESCE(TOTAL_NINOS_DE_6_10_ANIOS_S,0) AS TOTAL_NINOS_DE_6_10_ANIOS_S,
        COALESCE(GESTANTES_S,0) AS GESTANTES_S,  
        COALESCE(TOTAL_S,0) AS TOTAL_S,
        COALESCE(OBSERVACION_S,'') AS OBSERVACION_S
        FROM
        (   
        SELECT
        ec.Pk_Id_Evento,
        ec.DT_Fecha_Evento,
        ec.VC_Nombre_Evento,
        ec.IN_Num_Artistas,
        ec.IN_Num_Grupos,
        ec.IN_Experiencias,
        ec.IN_Cuidadores,
        ec.IN_Aprobacion,
        ec.VC_Listado_Asistencia,
        (SELECT
        GROUP_CONCAT(la.VC_Nombre_Lugar SEPARATOR ', ')
        FROM tb_nidos_lugar_atencion la  
        WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion, ec.VC_Lugar_Atencion)) AS 'VC_Nombre_Lugar',
        (SELECT
        CASE
        WHEN COUNT(la.Pk_Id_lugar_atencion) = 1 THEN tl.Vc_Descripcion  
        ELSE '77- Distrital' 
        END 
        FROM tb_nidos_lugar_atencion la
        JOIN tb_nidos_tipo_lugar AS tl ON la.VC_Tipo_Lugar=tl.Pk_Id_Lugar  
        WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion, ec.VC_Lugar_Atencion)) AS 'Vc_Descripcion',
        (SELECT
        CASE
        WHEN COUNT(la.Pk_Id_lugar_atencion) = 1 THEN l.VC_Nom_Localidad 
        ELSE '77- Distrital' 
        END 
        FROM tb_nidos_lugar_atencion la
        JOIN tb_localidades l ON l.Pk_Id_Localidad=la.Fk_Id_Localidad  
        WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion,  ec.VC_Lugar_Atencion)) AS 'VC_Nom_Localidad',
        (SELECT
        CASE
        WHEN COUNT(la.Pk_Id_lugar_atencion) = 1 THEN CONCAT(u.IN_Codigo_Upz,'. ', u.VC_Nombre_Upz)
        ELSE '77- Distrital' 
        END 
        FROM tb_nidos_lugar_atencion la
        JOIN tb_upz AS u ON la.Fk_Id_Upz=u.Pk_Id_Upz
        WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion, ec.VC_Lugar_Atencion)) AS 'UPZ', 
        (SELECT
        CASE
        WHEN COUNT(la.Pk_Id_lugar_atencion) = 1 THEN la.VC_Barrio
        ELSE '77- Distrital' 
        END 
        FROM tb_nidos_lugar_atencion la
        WHERE FIND_IN_SET(la.Pk_Id_lugar_atencion, ec.VC_Lugar_Atencion)) AS 'VC_Barrio',
        (SELECT GROUP_CONCAT(pd.VC_Descripcion SEPARATOR ', ')
        FROM tb_parametro_detalle AS pd  
        WHERE FIND_IN_SET(pd.FK_Value, ec.IN_Tipo_Poblacion) AND pd.FK_Id_Parametro=51) AS 'MODALIDADATENCION',
        (SELECT GROUP_CONCAT(CONCAT(' ',du.VC_Codigo_Dupla,' ') SEPARATOR 'Y'  )  
        FROM tb_nidos_dupla du  
        WHERE FIND_IN_SET(du.Pk_Id_Dupla, ec.IN_Cantidad_Equipos) > 0)  AS 'EQUIPOSASIGNADOS'
        FROM tb_nidos_evento_circulacion AS ec";

        if ($id_usuario != "") {
            $sql .= " WHERE (ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') AND ec.IN_ESTADO_EVENTO = 4 AND FIND_IN_SET ((SELECT
            da.Fk_Id_Dupla
            FROM tb_nidos_dupla_artista da
            WHERE da.Fk_Id_Persona=$id_usuario AND da.IN_Estado='1'), ec.IN_Cantidad_Equipos)";
        } else {
            $sql .= " WHERE (ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31') AND ec.IN_ESTADO_EVENTO = 4";
        }

        $sql .= ") AS PRIMERA LEFT JOIN
        (SELECT
        ec.Pk_Id_Evento,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINOS_DE_0_3_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINAS_DE_0_3_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_DE_0_3_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINOS_DE_4_6_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINAS_DE_4_6_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_DE_4_6_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINOS_FUERA_RANGO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINAS_FUERA_RANGO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_NINOS_FUERA_RANGO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 12 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS GESTANTES_N,
        COUNT(CASE
        WHEN (TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 OR TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >=12) AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 14 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS CAMPESINA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 3 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS INDIGENA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS AFRODESCENDIENTE_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS ROM_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 13 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS RAIZALES_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 21 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PALENQUERA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 25 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS COMUNIDADES_NEGRAS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 10 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS POBLACION_CARCELARIA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 5 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DISCAPACIDAD_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 12 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PERSONAS_HABITANTES_CALLE_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 18 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 4 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS POBLACION_VICTIMA_CONFLICTO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 26 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DESPLAZAMIENTO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 19 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS MIGRANTES_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 20 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DETERIORO_URBANO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 23 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS EMERGENCIA_SOCIAL_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 22 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS LGBTIQ_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional != 6 AND b.IN_Grupo_Poblacional != 0 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_EN_N
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistencia a ON a.Fk_Id_Evento=ec.Pk_Id_Evento
        LEFT JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=a.Fk_Id_Beneficiario
        WHERE (ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')
        GROUP BY a.Fk_Id_Evento ) AS SEGUNDA ON PRIMERA.Pk_Id_Evento = SEGUNDA.Pk_Id_Evento LEFT JOIN
        (SELECT
        ec.Pk_Id_Evento,
        SUM(ae.VC_Ninos_0_3) AS NINOS_DE_0_3_ANIOS_S,  
        SUM(ae.VC_Ninas_0_3) AS NINAS_DE_0_3_ANIOS_S,  
        SUM(ae.VC_Ninos_0_3 + ae.VC_Ninas_0_3) AS TOTAL_DE_0_3_ANIOS_S, 
        SUM(ae.VC_Ninos_4_6) AS NINOS_DE_4_6_ANIOS_S,  
        SUM(ae.VC_Ninas_4_6) AS NINAS_DE_4_6_ANIOS_S,  
        SUM(ae.VC_Ninos_4_6 + ae.VC_Ninas_4_6) AS TOTAL_DE_4_6_ANIOS_S, 
        SUM(ae.VC_Ninos_6_10) AS NINOS_DE_6_10_ANIOS_S,
        SUM(ae.VC_Ninas_6_10) AS NINAS_DE_6_10_ANIOS_S,
        SUM(ae.VC_Ninos_6_10 + ae.VC_Ninas_6_10) AS TOTAL_NINOS_DE_6_10_ANIOS_S,  
        SUM(ae.VC_Madres) AS GESTANTES_S, 
        SUM(ae.VC_Ninos_0_3 + ae.VC_Ninas_0_3 + ae.VC_Ninos_4_6 + ae.VC_Ninas_4_6 + ae.VC_Ninos_6_10 + ae.VC_Ninas_6_10 + ae.VC_Madres) AS TOTAL_S,
        GROUP_CONCAT(ae.TX_Observacion SEPARATOR ', ') AS OBSERVACION_S 
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistentes_evento ae ON ae.Fk_Id_Evento=ec.Pk_Id_Evento
        GROUP BY ec.Pk_Id_Evento) TERCERA ON PRIMERA.Pk_Id_Evento = TERCERA.Pk_Id_Evento LEFT JOIN 
        (SELECT
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 1 THEN 1 END ) AS NINOS_DE_0_3_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 2 THEN 1 END ) AS NINAS_DE_0_3_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 THEN 1 END ) AS TOTAL_DE_0_3_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 1 THEN 1 END ) AS NINOS_DE_4_6_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 2 THEN 1 END ) AS NINAS_DE_4_6_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 THEN 1 END ) AS TOTAL_DE_4_6_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 1 THEN 1 END ) AS NINOS_FUERA_RANGO_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 2 THEN 1 END ) AS NINAS_FUERA_RANGO_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 THEN 1 END ) AS TOTAL_NINOS_FUERA_RANGO_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 12 AND b.FK_Id_Genero = 2 THEN 1 END ) AS GESTANTES_R,
        COUNT( CASE WHEN (TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 OR TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >=12 ) THEN 1 END ) AS TOTAL_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 14 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS CAMPESINA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 3 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS INDIGENA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 1 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS AFRODESCENDIENTE_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 2 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS ROM_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 13 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS RAIZALES_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 21 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PALENQUERA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 25 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS COMUNIDADES_NEGRAS_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 10 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS POBLACION_CARCELARIA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 5 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS DISCAPACIDAD_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 12 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PERSONAS_HABITANTES_CALLE_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 18 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS POBLACION_VICTIMA_CONFLICTO_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 26 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS DESPLAZAMIENTO_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 19 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS MIGRANTES_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 20 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS DETERIORO_URBANO_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 23 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS EMERGENCIA_SOCIAL_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 22 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS LGBTIQ_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional != 6 AND b.IN_Grupo_Poblacional != 0 THEN 1 END ) AS TOTAL_EN_R,
        ec.Pk_Id_Evento AS IDEVENTO
        FROM tb_nidos_evento_circulacion ec  
        LEFT JOIN tb_nidos_asistencia na ON na.Fk_Id_Evento=ec.Pk_Id_Evento
        LEFT JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=na.Fk_Id_Beneficiario
        WHERE (ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31')
        GROUP BY ec.Pk_Id_Evento) AS CUARTA ON PRIMERA.Pk_Id_Evento = CUARTA.IDEVENTO";

        @$sentencia = $this->dbPDO->prepare($sql);

        //@$sentencia->bindParam(':id_usuario', $id_usuario);

        @$sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function crearOfertaAtencionesVirtuales($objeto)
    {
        $horario = explode(";", $objeto->getVcHoraInicio());
        $horariofin = explode(";", $objeto->getVcHoraFin());
        $cupos = explode(";", $objeto->getInCupos());

        for ($i = 0; $i < count($horario) - 1; $i++) {
            $sql = "INSERT INTO tb_nidos_horarios_atencion (IN_Id_Formulario, IN_Id_Tipo_Atencion, DT_Fecha_Atencion, VC_Dia, VC_Hora_Inicio, VC_Hora_Fin, IN_Cupos, IN_Cupos_Disponibles, DT_Fecha_Registro, FK_Id_Usuario_Registro) VALUES (:formulario, :tipoatencion, :fecha, :dia, :horarios, :horariofin, :cupos, :cuposdisponibles, :fecharegistro, :usuario)";

            @$sentencia = $this->dbPDO->prepare($sql);
            @$sentencia->bindParam(':formulario', $objeto->getInIdFormulario());
            @$sentencia->bindParam(':tipoatencion', $objeto->getInIdTipoAtencion());
            @$sentencia->bindParam(':fecha', $objeto->getDtFechaAtencion());
            @$sentencia->bindParam(':dia', $objeto->getVcDia());
            @$sentencia->bindParam(':horarios', $horario[$i]);
            @$sentencia->bindParam(':horariofin', $horariofin[$i]);
            @$sentencia->bindParam(':cupos', $cupos[$i]);
            @$sentencia->bindParam(':cuposdisponibles', $cupos[$i]);
            @$sentencia->bindParam(':fecharegistro', $objeto->getDtFechaRegistro());
            @$sentencia->bindParam(':usuario', $objeto->getFkIdUsuarioRegistro());
            $sentencia->execute();
        }
        return $sentencia->rowCount();
    }

    public function consultarOfertaVirtual($idmes, $formulario)
    {
        $sql = "SELECT HA.Pk_Id_Horario AS 'ID', HA.IN_Id_Formulario AS 'IDFORMULARIO',
        (CASE WHEN HA.IN_Id_Formulario = '1' THEN 'COMUNIDAD' WHEN HA.IN_Id_Formulario = '2' THEN 'INSTITUCIONAL 1 y 3'
        WHEN HA.IN_Id_Formulario = '3' THEN 'INSTITUCIONAL 2 y 4' END) AS 'FORMULARIO',
        HA.IN_Id_Tipo_Atencion AS 'IDATENCION', 
        (CASE WHEN HA.IN_Id_Formulario = '1' THEN 'CUENTO Y POESÍA' WHEN HA.IN_Id_Formulario = '2' THEN 'CANTO' END) AS 'ATENCION',
        HA.DT_Fecha_Atencion AS 'FECHA', HA.VC_Dia AS 'DIA',
        HA.VC_Hora_Inicio AS 'HORAINICIO', HA.VC_Hora_Fin AS 'HORAFIN', HA.IN_Cupos AS 'CUPOS', HA.IN_Cupos_Disponibles AS 'DISPONIBLES'
        FROM tb_nidos_horarios_atencion AS HA
        WHERE (HA.DT_Fecha_Atencion BETWEEN '2021-$idmes-01' AND '2021-$idmes-31') AND HA.IN_Id_Formulario = '$formulario'";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDemandaAtenciones($dia, $formulario)
    {
        $sql = "SELECT AV.Pk_Id_Registro AS 'IDREGISTRO',
        IF(
        (AV.VC_Primer_Nombre_Cuidador IS NULL AND AV.VC_Primer_Apellido_Cuidador IS NULL), 'No suministrado', CONCAT_WS(' ', AV.VC_Primer_Nombre_Cuidador, ' ', AV.VC_Primer_Apellido_Cuidador)
        ) AS 'CUIDADOR',
        CASE
        WHEN AV.IN_Dirigida_Atencion = '1' THEN 'MUJER GESTANTE'
        WHEN AV.IN_Dirigida_Atencion = '2' THEN 'NIÑO' 
        WHEN AV.IN_Dirigida_Atencion = '3' THEN 'NIÑA'
        END AS 'DIRIGIDA',
        CASE
        WHEN AV.IN_Potestad = '1' THEN 'SI'
        WHEN AV.IN_Potestad = '0' THEN 'NO'
        END AS 'POTESTAD',
        AV.VC_Identificacion AS 'IDENTIFICACION',
        IF(
        (AV.VC_Primer_Nombre_Beneficiario IS NULL AND AV.VC_Segundo_Nombre_Beneficiario IS NULL AND AV.VC_Primer_Apellido_beneficiario IS NULL AND AV.VC_Segundo_Apellido_Beneficiario IS NULL), 'No suministrado', CONCAT_WS(' ', AV.VC_Primer_Nombre_Beneficiario, AV.VC_Segundo_Nombre_Beneficiario, AV.VC_Primer_Apellido_beneficiario, AV.VC_Segundo_Apellido_Beneficiario)
        ) AS 'NOMBRES',
        AV.DD_F_Nacimiento AS 'FNACIMIENTO',
        PD.VC_Descripcion AS 'POBLACIONAL',  
        AV.VC_Telefono AS 'TELEFONO', 
        CASE
        WHEN AV.IN_Tipo_Atencion = '1' THEN 'CUENTO Y POESÍA'
        WHEN AV.IN_Tipo_Atencion = '2' THEN 'CANTO'
        END AS 'ATENCION',
        CASE
        WHEN AV.IN_Horario_Llamada IS NULL THEN ''
        ELSE AV.IN_Horario_Llamada
        END AS 'HORARIO',
        HA.DT_Fecha_Atencion AS 'FECHA_FORMULARIO_CON_HORARIO',
        AV.DT_Fecha_Llamada AS 'FECHA_FORMULARIO_SIN_HORARIO',
        HA.VC_Hora_Inicio AS 'INICIO',
        HA.VC_Hora_Fin AS 'FIN',
        AV.VC_Comentarios AS 'COMENTARIOS', AV.IN_Quien_Llama AS 'ARTISTA',
        COALESCE(CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido ), 'No asignado') AS 'NOMBREARTISTA',
        CASE
        WHEN AV.IN_Formulario = '1' THEN 'Comunidad'
        WHEN AV.IN_Formulario = '2' THEN 'Institucional 1 y 3'
        WHEN AV.IN_Formulario = '3' THEN 'Institucional 2 y 4'
        WHEN AV.IN_Formulario = '4' THEN 'Arn'
        WHEN AV.IN_Formulario = '5' THEN 'Aulas hospitalarias'
        END AS 'FORMULARIO',
        CASE
        WHEN AV.IN_Tipo_Atencion = '1' THEN 'CUENTO Y POESÍA'
        WHEN AV.IN_Tipo_Atencion = '2' THEN 'CANTO'
        ELSE 'No aplica'
        END AS 'ATENCION',
        AV.IN_Localidad AS 'IDLOCALIDAD',   
        CASE
        WHEN AV.IN_Localidad = '1' THEN 'USAQUÉN' WHEN AV.IN_Localidad = '2' THEN 'CHAPINERO' 
        WHEN AV.IN_Localidad = '3' THEN 'SANTA FE' WHEN AV.IN_Localidad = '4' THEN 'SAN CRISTOBAL'
        WHEN AV.IN_Localidad = '5' THEN 'USME' WHEN AV.IN_Localidad = '6' THEN 'TUNJUELITO' 
        WHEN AV.IN_Localidad = '7' THEN 'BOSA' WHEN AV.IN_Localidad = '8' THEN 'KENNEDY'
        WHEN AV.IN_Localidad = '9' THEN 'FONTIBÓN' WHEN AV.IN_Localidad = '10' THEN 'ENGATIVÁ' 
        WHEN AV.IN_Localidad = '11' THEN 'SUBA' WHEN AV.IN_Localidad = '12' THEN 'BARRIOS UNIDOS'  
        WHEN AV.IN_Localidad = '13' THEN 'TEUSAQUILLO' WHEN AV.IN_Localidad = '14' THEN 'MÁRTIRES' 
        WHEN AV.IN_Localidad = '15' THEN 'ANTONIO NARIÑO' WHEN AV.IN_Localidad = '16' THEN 'PUENTE ARANDA' 
        WHEN AV.IN_Localidad = '17' THEN 'CANDELARIA' WHEN AV.IN_Localidad = '18' THEN 'RAFAEL URIBE' 
        WHEN AV.IN_Localidad = '19' THEN 'CIUDAD BOLIVAR' WHEN AV.IN_Localidad = '20' THEN 'SUMAPAZ' 
        WHEN AV.IN_Localidad = '21' THEN 'OTRA CIUDAD O PAIS'
        END AS 'LOCALIDAD',
        AV.IN_Upz AS 'IDUPZ',
        AV.VC_Barrio AS 'BARRIO',
        AV.VC_Direccion AS 'DIRECCION'
        FROM tb_nidos_atenciones_virtuales AS AV
        LEFT JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        LEFT JOIN tb_persona_2017 AS PE ON AV.IN_Quien_Llama = PE.PK_Id_Persona
        LEFT JOIN tb_parametro_detalle PD ON PD.FK_Value=AV.VC_Grupo_Poblacional AND Fk_Id_Parametro=14";
        if ($formulario == 4 || $formulario == 5) {
            $sql .= " WHERE AV.IN_Formulario=:formulario";
            if ($formulario == 5) {
                $sql .= " AND AV.IN_Edad_Mental <= 5";
            }
        } else {
            $sql .= " WHERE HA.DT_Fecha_Atencion=:dia AND AV.IN_Formulario=:formulario";
        }
        $sentencia = $this->dbPDO->prepare($sql);
        if ($formulario == 1 || $formulario == 2 || $formulario == 3) {
            @$sentencia->bindParam(':dia', $dia);
        }
        @$sentencia->bindParam(':formulario', $formulario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function editarFranjaHoraria($objeto)
    {
        $sql = "UPDATE tb_nidos_horarios_atencion SET IN_Id_Formulario = :formulario, IN_Id_Tipo_Atencion = :tipoatencion,   DT_Fecha_Atencion = :fecha, VC_Hora_Inicio = :horarios, VC_Hora_Fin = :horariofin, IN_Cupos = :cupos, IN_Cupos_Disponibles = :cuposdisponibles, DT_Fecha_Registro = :fecharegistro, FK_Id_Usuario_Registro = :usuario WHERE Pk_Id_Horario = :idhorario";
        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':idhorario', $objeto->getPkIdHorario());
        @$sentencia->bindParam(':formulario', $objeto->getInIdFormulario());
        @$sentencia->bindParam(':tipoatencion', $objeto->getInIdTipoAtencion());
        @$sentencia->bindParam(':fecha', $objeto->getDtFechaAtencion());
        @$sentencia->bindParam(':horarios', $objeto->getVcHoraInicio());
        @$sentencia->bindParam(':horariofin', $objeto->getVcHoraFin());
        @$sentencia->bindParam(':cupos', $objeto->getInCupos());
        @$sentencia->bindParam(':cuposdisponibles', $objeto->getInCuposDisponibles());
        @$sentencia->bindParam(':usuario', $objeto->getFkIdUsuarioRegistro());
        @$sentencia->bindParam(':fecharegistro', $objeto->getDtFechaRegistro());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function consultarArtistasComunitarios()
    {
        $sql = "SELECT PE.PK_Id_Persona AS 'IDPERSONA', PE.VC_Primer_Nombre AS 'PNOMBRE', PE.VC_Segundo_Nombre AS 'SNOMBRE', PE.VC_Primer_Apellido AS 'PAPELLIDO', PE.VC_Segundo_Apellido AS 'SAPELLIDO'
        FROM tb_persona_2017 AS PE
        JOIN tb_acceso_usuario_2017 AS AU ON PE.PK_Id_Persona = AU.FK_Id_Persona
        WHERE PE.FK_Tipo_Persona = 34 AND AU.IN_Estado = 1";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function AsignarArtista($objeto, $formulario, $upz)
    {

        $sql = "SELECT
        *
        FROM tb_nidos_llamadas_asignacion la
        WHERE la.fk_atencion_virtual=:id_atencion_virtual";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());
        $sentencia->execute();

        if ($sentencia->rowCount() == 0 || ($formulario == "Arn" || $formulario == "Aulas hospitalarias")) {

            $sql2 = "INSERT INTO tb_nidos_llamadas_asignacion (fk_atencion_virtual, fecha_llamada, quien_llama, fecha_asignacion, quien_asigno) VALUES (:id_atencion_virtual, :fecha_llamada, :quien_llama, :fecha_asignacion, :quien_asigno)";

            @$sentencia2 = $this->dbPDO->prepare($sql2);
            @$sentencia2->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());
            @$sentencia2->bindParam(':fecha_llamada', $objeto->getFechaLlamada());
            @$sentencia2->bindParam(':quien_llama', $objeto->getQuienLlama());
            @$sentencia2->bindParam(':fecha_asignacion', $objeto->getFechaAsignacion());
            @$sentencia2->bindParam(':quien_asigno', $objeto->getQuienAsigno());

            try {
                $this->dbPDO->beginTransaction();
                $sentencia2->execute();

                $sql3 = "UPDATE tb_nidos_atenciones_virtuales SET IN_Upz=:upz, IN_Quien_Llama=:quien_llama, DT_Fecha_Llamada=:fecha_llamada WHERE Pk_Id_Registro=:id_atencion_virtual";
                @$sentencia3 = $this->dbPDO->prepare($sql3);
                @$sentencia3->bindParam(':fecha_llamada', $objeto->getFechaLlamada());
                @$sentencia3->bindParam(':quien_llama', $objeto->getQuienLlama());
                @$sentencia3->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());
                @$sentencia3->bindParam(':upz', $upz);

                $sentencia3->execute();
                $this->dbPDO->commit();
                return true;
            } catch (PDOExecption $e) {
                $this->dbPDO->rollback();
                return "Error!: " . $e->getMessage() . "</br>";
            }
        } else {
            $sql2 = "UPDATE tb_nidos_llamadas_asignacion SET quien_llama=:quien_llama WHERE fk_atencion_virtual=:id_atencion_virtual";
            @$sentencia2 = $this->dbPDO->prepare($sql2);
            @$sentencia2->bindParam(':quien_llama', $objeto->getQuienLlama());
            @$sentencia2->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());

            try {
                $this->dbPDO->beginTransaction();
                $sentencia2->execute();

                $sql3 = "UPDATE tb_nidos_atenciones_virtuales SET IN_Upz=:upz, IN_Quien_Llama=:quien_llama WHERE Pk_Id_Registro=:id_atencion_virtual";

                @$sentencia3 = $this->dbPDO->prepare($sql3);
                @$sentencia3->bindParam(':quien_llama', $objeto->getQuienLlama());
                @$sentencia3->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());
                @$sentencia3->bindParam(':upz', $upz);

                $sentencia3->execute();
                $this->dbPDO->commit();
                return true;
            } catch (PDOExecption $e) {
                $this->dbPDO->rollback();
                return "Error!: " . $e->getMessage() . "</br>";
            }
        }
    }

    public function RegistroLlamadasArtistas($objeto, $asistencia, $numero_documento_beneficiario, $formulario)
    {


        $sql = "INSERT INTO tb_nidos_llamadas (fk_atencion_virtual, fk_llamada_asignacion, fecha_llamada, quien_llamo, duracion_llamada, material_narrado, parecio_lectura, reaccion, observaciones) VALUES (:id_atencion_virtual, :id_llamada_asignacion, :fecha_llamada, :quien_llamo, :duracion_llamada, :material, :parecio, :reaccion, :observacion)";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());
        @$sentencia->bindParam(':id_llamada_asignacion', $objeto->getFkLlamadaAsignacion());
        @$sentencia->bindParam(':fecha_llamada', $objeto->getFechaLlamada());
        @$sentencia->bindParam(':quien_llamo', $objeto->getQuienLlamo());
        @$sentencia->bindParam(':duracion_llamada', $objeto->getDuracionLlamada());
        @$sentencia->bindParam(':material', $objeto->getMaterialNarrado());
        @$sentencia->bindParam(':parecio', $objeto->getParecioLectura());
        @$sentencia->bindParam(':reaccion', $objeto->getReaccion());
        @$sentencia->bindParam(':observacion', $objeto->getObservaciones());

        try {
            $sentencia->execute();
            $id_insertado = $this->dbPDO->lastInsertId();

            if ($formulario == 'Arn' || $formulario == 'Aulas hospitalarias') {
                $sql2 = "INSERT INTO tb_nidos_asistencia(
                Fk_Id_Llamada,
                Fk_Id_Beneficiario,
                Vc_Asistencia)
                VALUES (:id_atencion_virtual, (SELECT Pk_Id_Beneficiario FROM tb_nidos_beneficiarios WHERE VC_Identificacion=:numdoc), :asistencia)";

                @$sentencia2 = $this->dbPDO->prepare($sql2);
                @$sentencia2->bindParam(':id_atencion_virtual', $id_insertado);
                @$sentencia2->bindParam(':numdoc', $numero_documento_beneficiario);
                @$sentencia2->bindParam(':asistencia', $asistencia);
                $sentencia2->execute();
            }

            $sql3 = "UPDATE tb_nidos_llamadas_asignacion SET llamada_realizada=:asistencia WHERE fk_atencion_virtual=:id_atencion_virtual";
            @$sentencia3 = $this->dbPDO->prepare($sql3);
            @$sentencia3->bindParam(':id_atencion_virtual', $objeto->getFkAtencionVirtual());
            @$sentencia3->bindParam(':asistencia', $asistencia);
            $sentencia3->execute();
        } catch (PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function consultarTotalAtencionesMes($mes)
    {
        $sql = "SELECT
        L.id,
        AV.Pk_Id_Registro AS 'IDREGISTRO',
        CONCAT(VC_Primer_Nombre_Cuidador, ' ' , VC_Segundo_Nombre_Cuidador, ' ', VC_Primer_Apellido_Cuidador, ' ', VC_Segundo_Apellido_Cuidador) AS 'CUIDADOR',
        AV.VC_Correo AS 'CORREO', 
        AV.IN_Identificacion_Cuidador AS 'IDENCUIDADOR',
        (CASE 
        WHEN AV.IN_Localidad = '1' THEN 'USAQUÉN' WHEN AV.IN_Localidad = '2' THEN 'CHAPINERO'
        WHEN AV.IN_Localidad = '3' THEN 'SANTA FE' WHEN AV.IN_Localidad = '4' THEN 'SAN CRISTOBAL'
        WHEN AV.IN_Localidad = '5' THEN 'USME' WHEN AV.IN_Localidad = '6' THEN 'TUNJUELITO'
        WHEN AV.IN_Localidad = '7' THEN 'BOSA' WHEN AV.IN_Localidad = '8' THEN 'KENNEDY'
        WHEN AV.IN_Localidad = '9' THEN 'FONTIBÓN' WHEN AV.IN_Localidad = '10' THEN 'ENGATIVÁ'
        WHEN AV.IN_Localidad = '11' THEN 'SUBA' WHEN AV.IN_Localidad = '12' THEN 'BARRIOS UNIDOS'
        WHEN AV.IN_Localidad = '13' THEN 'TEUSAQUILLO' WHEN AV.IN_Localidad = '14' THEN 'MÁRTIRES'
        WHEN AV.IN_Localidad = '15' THEN 'ANTONIO NARIÑO' WHEN AV.IN_Localidad = '16' THEN 'PUENTE ARANDA'
        WHEN AV.IN_Localidad = '17' THEN 'CANDELARIA' WHEN AV.IN_Localidad = '18' THEN 'RAFAEL URIBE'
        WHEN AV.IN_Localidad = '19' THEN 'CIUDAD BOLIVAR' WHEN AV.IN_Localidad = '20' THEN 'SUMAPAZ'
        WHEN AV.IN_Localidad = '21' THEN 'OTRA CIUDAD O PAIS'
        END) AS 'LOCALIDAD',
        UP.VC_Nombre_Upz AS 'UPZ',
        AV.VC_Otro_Lugar AS 'OTROLUGAR',
        AV.VC_Barrio AS 'BARRIO',
        AV.VC_Direccion AS 'DIRECCION',
        AV.IN_Estrato AS 'ESTRATO', 
        AV.VC_Edad_Cuidador AS 'EDADCUIDADOR',
        (CASE
        WHEN AV.IN_Dirigida_Atencion = '1' THEN 'MUJER GESTANTE'
        WHEN AV.IN_Dirigida_Atencion = '2' THEN 'NIÑO'
        WHEN AV.IN_Dirigida_Atencion = '3' THEN 'NIÑA' END) AS 'DIRIGIDA',
        (CASE
        WHEN AV.IN_Parentesco = '1' THEN 'Madre o padre'
        WHEN AV.IN_Parentesco = '2' THEN 'Tía o tío'
        WHEN AV.IN_Parentesco = '3' THEN 'Abuela o abuelo'
        WHEN AV.IN_Parentesco = '4' THEN 'Hermano o hermana'
        WHEN AV.IN_Parentesco = '5' THEN 'Acudiente'
        WHEN AV.IN_Parentesco = '6' THEN 'Otro'
        ELSE '---'
        END) AS 'PARENTESCO',
        (CASE
        WHEN AV.IN_Potestad = '1' THEN 'SI'
        WHEN AV.IN_Potestad = '0' THEN 'NO'
        ELSE '---'
        END) AS 'POTESTAD',
        AV.VC_Identificacion AS 'IDENTIFICACION',
        CONCAT(VC_Primer_Nombre_Beneficiario, ' ', VC_Segundo_Nombre_Beneficiario) AS 'NOMBRE',
        CONCAT(VC_Primer_Apellido_beneficiario, ' ', VC_Segundo_Apellido_Beneficiario) AS 'APELLIDOS',
        AV.DD_F_Nacimiento AS 'FECHANACIMIENTO',
        AV.VC_Edad_Beneficiario AS 'EDADBENEFICIARIO',
        (SELECT GROUP_CONCAT(CONCAT(' ',PD.VC_Descripcion,' ') SEPARATOR 'Y'  )
        FROM tb_parametro_detalle PD
        WHERE  Fk_Id_Parametro =  14 AND FIND_IN_SET(PD.Fk_Value, AV.VC_Grupo_Poblacional) > 0)  AS 'ENFOQUE',
        AV.VC_Institucion AS 'INSTITUCION',
        AV.VC_Entidad AS 'ENTIDAD', 
        AV.VC_Telefono AS 'TELEFONO',
        (CASE
        WHEN AV.IN_Tipo_Atencion = '1' THEN 'CUENTO Y POESÍA'
        WHEN AV.IN_Tipo_Atencion = '2' THEN 'CANTO'
        ELSE 'No aplica'
        END) AS 'ATENCION',
        DATE_FORMAT(L.fecha_llamada, '%d/%m/%Y') AS 'FECHA',
        L.fecha_llamada AS 'FECHACALCULO',
        CONCAT(HA.VC_Hora_Inicio,' ',HA.VC_Hora_Fin) AS 'HORARIO',
        AV.VC_Comentarios AS 'COMENTARIOS',
        AV.VC_Autorizacion AS 'AUTORIZACION',
        (CASE
        WHEN AV.VC_Autorizacion = '1' THEN 'ACEPTADO'
        WHEN AV.VC_Autorizacion = '0' THEN 'NO ACEPTADO'
        END) AS 'AUTORIZACION',
        CASE
        WHEN AV.IN_Formulario = '1' THEN 'Comunidad'
        WHEN AV.IN_Formulario = '2' THEN 'Institucional 1 y 3'
        WHEN AV.IN_Formulario = '3' THEN 'Institucional 2 y 4'
        WHEN AV.IN_Formulario = '4' THEN 'Arn'
        END AS 'FORMULARIO',
        CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido ) AS 'NOMBREARTISTA',
        CASE WHEN L.duracion_llamada='' THEN 'Sin información' ELSE L.duracion_llamada END AS 'DURACION',
        CASE WHEN L.material_narrado='' THEN 'Sin información' ELSE L.material_narrado END AS 'MATERIAL',
        CASE WHEN L.parecio_lectura='' THEN 'Sin información' ELSE L.parecio_lectura END AS 'PARECIO',
        CASE WHEN L.reaccion='' THEN 'Sin información' ELSE L.reaccion END AS 'REACCIONO',
        CASE WHEN L.observaciones='' THEN 'Sin información' ELSE L.observaciones END AS 'OBSERVACIONES',
        LA.llamada_realizada AS 'ESTADO'
        FROM tb_nidos_llamadas L
        LEFT JOIN tb_nidos_atenciones_virtuales AV ON AV.Pk_Id_Registro=L.fk_atencion_virtual
        LEFT JOIN tb_nidos_llamadas_asignacion LA ON LA.fk_atencion_virtual=AV.Pk_Id_Registro 
        LEFT JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        LEFT JOIN tb_parametro_detalle PDE ON PDE.FK_Value=AV.VC_Grupo_Poblacional AND PDE.FK_Id_Parametro=14 AND PDE.IN_Estado=1
        LEFT JOIN tb_persona_2017 AS PE ON AV.IN_Quien_Llama = PE.PK_Id_Persona
        LEFT JOIN tb_upz AS UP ON AV.IN_Upz = UP.IN_Codigo_Upz 
        WHERE LA.fecha_llamada BETWEEN '2021-$mes-01' AND '2021-$mes-31' AND L.quien_llamo=LA.quien_llama AND L.fecha_llamada BETWEEN '2021-$mes-01' AND '2021-$mes-31'";

        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarUpzLocalidad($Localidad)
    {
        $sql = "SELECT Pk_Id_Upz AS 'IDUPZ', VC_Nombre_Upz AS 'NOMBREUPZ', IN_Codigo_Upz AS 'CODIGO' 
        FROM tb_upz
        WHERE FK_Id_Localidad = '$Localidad'";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProgramacionAsignada($idmes, $usuario)
    {
        $sql = "SELECT
        EC.Pk_Id_Evento AS 'ID',
        EC.IN_Dia AS 'DIA',
        DATE_FORMAT(EC.DT_Fecha_Evento, '%d/%m/%Y') AS 'FECHA',
        (CASE WHEN EC.VC_Franja_Atencion = 1 THEN 'AM' WHEN EC.VC_Franja_Atencion = 2 THEN 'PM' WHEN EC.VC_Franja_Atencion = 3 THEN 'AM Y PM' END )  AS 'FRANJA',
        EC.VC_Nombre_Evento AS 'EVENTO',
        LO.VC_Nom_Localidad AS 'LOCALIDAD',
        EC.VC_Entidad_Dirigida AS 'ENTIDAD',
        CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'SOLICITA',
        (SELECT GROUP_CONCAT(CONCAT(' ',DU.VC_Codigo_Dupla,' ') SEPARATOR 'Y'  )
        FROM tb_nidos_dupla DU
        WHERE FIND_IN_SET(DU.Pk_Id_Dupla, EC.IN_Cantidad_Equipos) > 0)  AS 'EQUIPOSASIG',
        (SELECT GROUP_CONCAT(CONCAT(' ',PD.VC_Descripcion,' ') SEPARATOR 'Y'  )
        FROM tb_parametro_detalle PD
        WHERE Fk_Id_Parametro = 51 AND FIND_IN_SET(PD.Fk_Value, EC.IN_Tipo_Poblacion) > 0)  AS 'MODALIDAD',
        (SELECT
        GROUP_CONCAT(LA.VC_Nombre_Lugar SEPARATOR ', ')
        FROM tb_nidos_lugar_atencion LA
        WHERE FIND_IN_SET(LA.Pk_Id_lugar_atencion, EC.VC_Lugar_Atencion)) AS 'LUGAR',
        CONCAT(U.IN_Codigo_Upz,'. ', U.VC_Nombre_Upz) AS 'UPZ',
        LA.VC_Barrio AS 'BARRIO',
        LA.VC_Direccion AS 'DIRECCION',
        EC.VC_Contacto_Lugar AS 'CONTACTO_LUGAR',
        EC.VC_Propuesta_Atencion AS 'PROPUESTA',
        EC.VC_Acompanamiento_Circulacion AS 'ACOMPANAMIENTO',
        EC.VC_Hora_Llegada_Artistas AS 'LLEGADA_ARTISTAS',
        EC.VC_Hora_Montaje_Nido AS 'MONTAJE_NIDO',
        EC.VC_Hora_Inicio_Atencion AS 'INICIO_ATENCION',
        EC.VC_Hora_Finalizacion AS 'FINALIZACION',
        EC.VC_Hora_Montaje AS 'MONTAJE',
        EC.VC_Hora_Desmontaje AS 'DESMONTAJE',
        EC.VC_Ubicacion  AS 'UBICACION',
        EC.VC_Indicaciones_Llegada AS 'INDICACIONES',
        EC.VC_Particularidades_Terreno AS 'PARTICULARIDADES'   
        FROM tb_nidos_evento_circulacion AS EC
        JOIN tb_localidades AS LO ON EC.Fk_Id_Localidad = LO.Pk_Id_Localidad
        LEFT JOIN tb_persona_2017 AS P ON EC.Fk_Id_Usuario_Solicita = P.PK_Id_Persona
        JOIN tb_nidos_lugar_atencion AS LA ON EC.VC_Lugar_Atencion = LA.Pk_Id_lugar_atencion
        JOIN tb_upz U ON U.Pk_Id_Upz=LA.Fk_Id_Upz 
        WHERE FIND_IN_SET(
        (SELECT
        DA.Fk_Id_Dupla
        FROM tb_nidos_dupla_artista AS DA
        WHERE DA.Fk_Id_Persona= '$usuario' AND DA.IN_Estado='1'), EC.IN_Cantidad_Equipos) AND (DT_Fecha_Evento BETWEEN '2021-$idmes-01' AND '2021-$idmes-31')";
        $sentencia = $this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function RegistroInformacionEvento($objeto)
    {
        $sql = "UPDATE tb_nidos_evento_circulacion SET IN_Num_Artistas = :artistas, IN_Num_Grupos = :grupos, IN_Espacio_Publico = :espacio, IN_Experiencias = :experiencias, IN_Cuidadores = :cuidadores, VC_Listado_Asistencia = :listado WHERE Pk_Id_Evento = :idEvento";

        @$sentencia = $this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':idEvento', $objeto->getPkIdEvento());
        @$sentencia->bindParam(':artistas', $objeto->getInNumaAtistas());
        @$sentencia->bindParam(':grupos', $objeto->getInNumGrupos());
        @$sentencia->bindParam(':espacio', $objeto->getInEspacioPublico());
        @$sentencia->bindParam(':experiencias', $objeto->getInExperiencias());
        @$sentencia->bindParam(':cuidadores', $objeto->getInCuidadores());
        @$sentencia->bindParam(':listado', $objeto->getVcListadoAsistencia());
        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function actualizarAsistentesEvento($objeto)
    {
        $sql = "UPDATE tb_nidos_asistentes_evento SET
        VC_Ninos_0_3 = :ninos_0_3, 
        VC_Ninos_4_6 = :ninos_4_6, 
        VC_Ninos_6_10 = :ninos_6_10, 
        VC_Ninas_0_3 = :ninas_0_3, 
        VC_Ninas_4_6 = :ninas_4_6, 
        VC_Ninas_6_10 = :ninas_6_10, 
        VC_Madres = :madres, 
        TX_Observacion = :observacion, 
        DT_Fecha_Registro = :fecha_registro, 
        Fk_Id_Artista_Registro= :id_usuario 
        WHERE Fk_Id_Evento = :id_evento AND FK_Id_Lugar_Atencion = :id_lugar_atencion";

        @$sentencia = $this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':id_evento', $objeto->getFkIdEvento());
        @$sentencia->bindParam(':id_lugar_atencion', $objeto->getFkIdLugarAtencion());
        @$sentencia->bindParam(':ninos_0_3', $objeto->getVcNinos03());
        @$sentencia->bindParam(':ninos_4_6', $objeto->getVcNinos46());
        @$sentencia->bindParam(':ninos_6_10', $objeto->getVcNinos610());
        @$sentencia->bindParam(':ninas_0_3', $objeto->getVcNinas03());
        @$sentencia->bindParam(':ninas_4_6', $objeto->getVcNinas46());
        @$sentencia->bindParam(':ninas_6_10', $objeto->getVcNinas610());
        @$sentencia->bindParam(':madres', $objeto->getVcMadres());
        @$sentencia->bindParam(':observacion', $objeto->getTxObservacion());
        @$sentencia->bindParam(':fecha_registro', $objeto->getDtFechaRegistro());
        @$sentencia->bindParam(':id_usuario', $objeto->getFkIdArtistaRegistro());

        $sentencia->execute();

        return $sentencia->rowCount();
    }

    public function getBeneficiariosEvento($id_evento, $id_lugar_atencion)
    {
        $sql = "SELECT
        ec.IN_Aprobacion,
        COUNT(na.Fk_Id_Beneficiario) as 'data'
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistencia na ON na.Fk_Id_Evento=ec.Pk_Id_Evento
        WHERE PK_Id_Evento=:id_evento AND na.Fk_Id_Lugar_Atencion_Evento=:id_lugar_atencion";
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_evento', $id_evento);
        @$sentencia->bindParam(':id_lugar_atencion', $id_lugar_atencion);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAsistentesEvento($id_evento, $id_lugar_atencion)
    {
        $sql = "SELECT
        PK_Id_Evento,
        COALESCE(
        (SELECT PK_Id_Asistentes_Evento
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'PK_Id_Asistentes_Evento',
        COALESCE(
        (SELECT
        VC_Ninos_0_3
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Ninos_0_3',
        COALESCE(
        (SELECT
        VC_Ninos_4_6
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Ninos_4_6',
        COALESCE(
        (SELECT
        VC_Ninos_6_10
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Ninos_6_10',
        COALESCE(
        (SELECT
        VC_Ninas_0_3
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Ninas_0_3',
        COALESCE(
        (SELECT
        VC_Ninas_4_6
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Ninas_4_6',
        COALESCE(
        (SELECT
        VC_Ninas_6_10
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Ninas_6_10',
        COALESCE(
        (SELECT
        VC_Madres
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'VC_Madres',
        COALESCE(
        (SELECT
        TX_Observacion
        FROM tb_nidos_asistentes_evento ae
        WHERE ae.Fk_Id_Evento=:id_evento AND ae.FK_Id_Lugar_Atencion=:id_lugar_atencion), '') AS 'TX_Observacion',
        ec.IN_Aprobacion
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistentes_evento ae ON ae.Fk_Id_Evento=ec.Pk_Id_Evento
        WHERE ec.Pk_Id_Evento=:id_evento";
        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_evento', $id_evento);
        @$sentencia->bindParam(':id_lugar_atencion', $id_lugar_atencion);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getReporteBeneficiariosEvento($id_evento, $id_mes)
    {
        $sql = "SELECT
        b.Pk_Id_Beneficiario,
        b.VC_Identificacion AS 'identificacion',
        ti.VC_Descripcion AS 'tipo_identificacion',
        b.VC_Primer_Nombre AS 'primer_nombre',
        b.VC_Segundo_Nombre AS 'segundo_nombre',
        b.VC_Primer_Apellido AS 'primer_apellido',
        b.VC_Segundo_Apellido AS 'segundo_apellido',
        DATE_FORMAT(b.DD_F_Nacimiento, '%d/%m/%Y') AS 'fecha_nacimiento',
        b.DD_F_Nacimiento AS 'fecha_nacimiento_calculo',
        g.VC_Descripcion AS 'genero',
        gp.VC_Descripcion AS 'enfoque',
        b.IN_Estrato AS 'estrato',
        ec.DT_Fecha_Evento AS 'fecha_evento',
        a.VC_Nivel AS 'nivel',
        (SELECT
        IF(
        (SELECT
        COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01')
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND 
        (
        SELECT
        MIN(na.Pk_Id_Asistencia)
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia , 'Nuevo', 'Antiguo')) AS 'atendido',
        la.VC_Nombre_Lugar AS 'lugar_atencion'
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistencia a ON a.Fk_Id_Evento=ec.Pk_Id_Evento
        LEFT JOIN tb_nidos_lugar_atencion la on la.Pk_Id_lugar_atencion=a.Fk_Id_Lugar_Atencion_Evento
        JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=a.Fk_Id_Beneficiario
        JOIN tb_parametro_detalle ti ON ti.FK_Value=b.FK_Tipo_Identificacion AND ti.FK_Id_Parametro=5
        JOIN tb_parametro_detalle g ON g.FK_Value=b.FK_Id_Genero AND g.FK_Id_Parametro=17
        JOIN tb_parametro_detalle gp ON gp.FK_Value=b.IN_Grupo_Poblacional AND gp.FK_Id_Parametro=14
        WHERE a.Fk_Id_Evento=:id_evento";

        $sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_evento', $id_evento);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getReportePandora($id_mes)
    {

        $id_mes_anterior = $id_mes - 1;

        $sql = "SELECT
        Pk_Id_Evento,
        VC_Nombre_Evento AS 'EVENTO',
        'Las obras y experiencias artísticas son encuentros concebidos para que niñas y niños tengan la oportunidad de vivir, conocer, contemplar, experimentar y crear a partir de los lenguajes de las artes, compartiendo con otras personas (niños, familiares, cuidadores(as), artistas y maestras), desarrollando sus capacidades mediante propuestas desde el cuerpo, el movimiento, la intervención artística del espacio, los lenguajes artísticos y transformación de las materias.<br>El Plan de lectura, escritura y oralidad ‘Leer para la vida’ 2021-2023 es la apuesta del Distrito para promover, formar, desarrollar y fortalecer las competencias lectoras de los bogotanos para que tengamos una vida enriquecida en los ámbitos íntimo y personal para transformar el entorno que nos rodea. ' AS 'DESCRIPCIÓN',
        VC_Tipo_Atencion AS 'MODALIDAD',
        'CIRCULACIÓN' AS 'DIMENSION',
        'PRESENTACION ARTÍSTICA' AS 'TIPOLOGIA',
        COALESCE(IN_Experiencias, 0) AS 'EXPERIENCIAS', 
        DT_Fecha_Evento AS 'FECHA',
        'Primera Infancia entre 0 y 5 años' AS 'ENFOQUE_POBLACIONAL',
        VC_Nombre_Lugar AS 'LUGAR',
        UPPER(IN_Espacio_Publico) AS 'ESPACIO_PUBLICO',
        'N/A' AS 'CAPACIDAD',
        VC_Nom_Localidad AS 'LOCALIDAD',
        UPZ AS 'UPZ',
        VC_Barrio AS 'BARRIO',
        'Local' AS 'IMPACTO_TERRITORIAL',
        'IDARTES' AS 'ORIGEN',
        'GRATUITO' AS 'MODALIDAD_EQUIPAMIENTO',
        'GRATUITO' AS 'EVENTO_GRATUITO_PAGO',
        COALESCE(IN_Num_Artistas, 0) AS 'ARTISTAS_REMUNERADOS',
        COALESCE(IN_Num_Artistas, 0) AS 'TOTAL_ARTISTAS',
        COALESCE(TOTAL_N,0) + (TOTAL_SIN_INFO) AS 'INSCRITOS',
        COALESCE(TOTAL_NINAS_N,0) + (TOTAL_NINAS_SIN_INFO) AS 'TOTAL_NINAS',
        COALESCE(TOTAL_NINOS_N,0) + (TOTAL_NINOS_SIN_INFO) AS 'TOTAL_NINOS',
        0 AS 'OTRO',
        COALESCE(TOTAL_N,0) + (TOTAL_SIN_INFO) AS 'TOTAL_BENEFICIARIOS',
        COALESCE(PRIMERA,0) + (PRIMERA_SIN_INFO) AS 'PRIMERA',
        COALESCE(INFANCIA,0) + (INFANCIA_SIN_INFO) AS 'INFANCIA',
        0 AS 'ADOLESCENCIA',
        0 AS 'JUVENTUD',
        0 AS 'ADULTOS',
        0 AS 'MAYORES',
        COALESCE(CAMPESINA_N, 0) AS 'CAMPESINA_N',
        COALESCE(GESTANTES_N, 0) + (GESTANTES_SIN_INFO) AS 'GESTANTES_N',
        COALESCE(PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N, 0) AS 'PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N',
        COALESCE(PERSONAS_HABITANTES_CALLE_N, 0) AS 'PERSONAS_HABITANTES_CALLE_N',
        COALESCE(DISCAPACIDAD_N, 0) AS 'DISCAPACIDAD_N',
        COALESCE(POBLACION_CARCELARIA_N, 0) AS 'POBLACION_CARCELARIA_N',
        0 AS 'PROFESIONALES',
        COALESCE(LGBTIQ_N, 0) AS 'LGBTIQ_N',
        COALESCE(POBLACION_VICTIMA_CONFLICTO_N, 0) AS 'POBLACION_VICTIMA_CONFLICTO_N',
        COALESCE(MIGRANTES_N, 0) AS 'MIGRANTES_N',
        0 AS 'VICTIMAS_TRATA',
        COALESCE(EMERGENCIA_SOCIAL_N, 0) AS 'EMERGENCIA_SOCIAL_N',
        COALESCE(DETERIORO_URBANO_N, 0) AS 'DETERIORO_URBANO_N',
        0 AS 'VULNERABILIDAD',
        COALESCE(DESPLAZAMIENTO_N, 0) AS 'DESPLAZAMIENTO_N',
        0 AS 'CONSUMIDORAS',
        COALESCE(ROM_N, 0) AS 'ROM_N',
        0 AS 'PRO_ROM',
        COALESCE(INDIGENA_N, 0) AS 'INDIGENA_N',
        COALESCE(COMUNIDADES_NEGRAS_N, 0) AS 'COMUNIDADES_NEGRAS_N',
        COALESCE(AFRODESCENDIENTE_N, 0) AS 'AFRODESCENDIENTE_N',
        COALESCE(PALENQUERA_N, 0) AS 'PALENQUERA_N',
        COALESCE(RAIZALES_N, 0) AS 'RAIZALES_N',
        COALESCE(TX_Observacion,'') AS 'OBSERVACION',
        '' AS 'ATENDIDO'
        FROM
        (SELECT
        EC.Pk_Id_Evento,
        EC.VC_Nombre_Evento,
        EC.VC_Tipo_Atencion,    
        EC.DT_Fecha_Evento,
        LA.VC_Nombre_Lugar,
        EC.IN_Espacio_Publico,
        L.VC_Nom_Localidad,
        CONCAT(U.IN_Codigo_Upz,'. ', U.VC_Nombre_Upz) AS UPZ,
        LA.VC_Barrio,
        EC.IN_Num_Artistas,
        EC.IN_Experiencias
        FROM tb_nidos_evento_circulacion AS EC
        JOIN tb_nidos_lugar_atencion AS LA ON EC.VC_Lugar_Atencion= LA.Pk_Id_lugar_atencion
        JOIN tb_localidades AS L ON LA.Fk_Id_Localidad=L.Pk_Id_Localidad
        JOIN tb_upz AS U ON LA.Fk_Id_Upz=U.Pk_Id_Upz
        WHERE (EC.DT_Fecha_Evento BETWEEN '2021-$id_mes_anterior-26' AND '2021-$id_mes-25') AND EC.IN_Estado_Evento = 4) AS PRIMERA left JOIN
        (SELECT
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 6 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_NINOS_N,
        COUNT(CASE
        WHEN (TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 6 OR TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >= 12) AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_NINAS_N,
        COUNT(CASE
        WHEN (TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 6 OR TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >= 12) AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PRIMERA,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 6 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS INFANCIA,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 14 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS CAMPESINA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 12 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS GESTANTES_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 18 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 12 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PERSONAS_HABITANTES_CALLE_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 5 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DISCAPACIDAD_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 10 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS POBLACION_CARCELARIA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 22 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS LGBTIQ_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 4 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS POBLACION_VICTIMA_CONFLICTO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 19 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS MIGRANTES_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 23 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS EMERGENCIA_SOCIAL_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 20 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DETERIORO_URBANO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 26 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DESPLAZAMIENTO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS ROM_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 3 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS INDIGENA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 25 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS COMUNIDADES_NEGRAS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS AFRODESCENDIENTE_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 21 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PALENQUERA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 13 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS RAIZALES_N,
        ec.Pk_Id_Evento AS IDEVENTO
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistencia a ON a.Fk_Id_Evento=ec.Pk_Id_Evento
        LEFT JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=a.Fk_Id_Beneficiario
        where (ec.DT_Fecha_Evento BETWEEN '2021-$id_mes_anterior-26' AND '2021-$id_mes-25') AND ec.IN_Estado_Evento = 4
        GROUP BY ec.Pk_Id_Evento) AS SEGUNDA ON PRIMERA.Pk_Id_Evento = SEGUNDA.IDEVENTO LEFT JOIN
        (SELECT
        ec.Pk_Id_Evento AS IDEVENTO,
        COALESCE(SUM(ae.VC_Ninos_0_3 + ae.VC_Ninos_4_6 + ae.VC_Ninos_6_10), 0) AS TOTAL_NINOS_SIN_INFO,
        COALESCE(SUM(ae.VC_Ninas_0_3 + ae.VC_Ninas_4_6 + ae.VC_Ninas_6_10 + ae.VC_Madres), 0) AS TOTAL_NINAS_SIN_INFO,
        COALESCE(SUM(ae.VC_Ninos_0_3 + ae.VC_Ninos_4_6 + ae.VC_Ninas_0_3 + ae.VC_Ninas_4_6 + ae.VC_Ninos_6_10 + ae.VC_Ninas_6_10 + ae.VC_Madres), 0) AS TOTAL_SIN_INFO,
        COALESCE(SUM(ae.VC_Ninos_0_3 + ae.VC_Ninos_4_6 + ae.VC_Ninas_0_3 + ae.VC_Ninas_4_6), 0) AS PRIMERA_SIN_INFO,
        COALESCE(SUM(ae.VC_Ninos_6_10 + ae.VC_Ninas_6_10), 0) AS INFANCIA_SIN_INFO,
        COALESCE(SUM(ae.VC_Madres), 0) AS GESTANTES_SIN_INFO,
        GROUP_CONCAT(ae.TX_Observacion SEPARATOR ', ') AS TX_Observacion
        FROM tb_nidos_evento_circulacion ec
        LEFT JOIN tb_nidos_asistentes_evento ae ON ae.Fk_Id_Evento=ec.Pk_Id_Evento
        where (ec.DT_Fecha_Evento BETWEEN '2021-$id_mes_anterior-26' AND '2021-$id_mes-25') AND ec.IN_Estado_Evento = 4
        GROUP BY ec.Pk_Id_Evento) AS TERCERA ON PRIMERA.Pk_Id_Evento = TERCERA.IDEVENTO

        UNION

        SELECT
        l.id,
        'ARTICULACION ARN' AS 'NOMBRE DE LA ACTIVIDAD',
        'Llamadas a telefónicas a niños y niñas de primera infancia, mediante la cual se comparte una experiencia artística que es mediada esencialmente desde la lectura.' AS 'DESCRIPCIÓN DE LA ACTIVIDAD', 
        'Telefónica' AS 'MODALIDAD DE LA ACTIVIDAD',
        'CIRCULACIÓN' AS 'DIMENSION',
        'PRESENTACION ARTÍSTICA' AS 'TIPOLOGIA',
        1 AS 'EXPERIENCIAS', DATE_FORMAT(l.fecha_llamada, '%d/%m/%Y') AS 'FECHA',
        'Primera Infancia entre 0 y 5 años' AS 'ENFOQUE_POBLACIONAL',
        'Residencia de la familia' AS 'LUGAR',
        'No' AS 'ESPACIO_PUBLICO',
        'N/A' AS 'CAPACIDAD',
        pdl.VC_Descripcion,
        (
        SELECT CONCAT(u.IN_Codigo_Upz,'. ',u.VC_Nombre_Upz)
        FROM tb_upz u
        WHERE u.IN_Codigo_Upz=av.IN_Upz
        ) AS 'UPZ',
        av.VC_Barrio,
        'Local' AS 'IMPACTO_TERRITORIAL',
        'IDARTES' AS 'ORIGEN',
        'GRATUITO' AS 'MODALIDAD_EQUIPAMIENTO',
        'GRATUITO' AS 'EVENTO_GRATUITO_PAGO',
        1 AS 'ARTISTAS_REMUNERADOS',
        1 AS 'TOTAL_ARTISTAS',
        1 AS 'INSCRITOS',
        COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) <= 6 AND b.FK_Id_Genero = 2 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND nas.Vc_Asistencia=1
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'MUJERES',
        COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) <= 6 AND b.FK_Id_Genero = 1 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND nas.Vc_Asistencia=1
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'HOMBRES',
        '' AS 'OTRO',
        1 AS 'TOTAL',
        COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) <= 5 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'PRIMERA', CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) <= 6 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END AS 'INFANCIA',
        '' AS 'ADOLESCENCIA',
        '' AS 'JUVENTUD',
        '' AS 'ADULTOS',
        '' AS 'MAYORES', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 14 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'CAMPESINA_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) >= 12 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'GESTANTES_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 18 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 12 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'PERSONAS_HABITANTES_CALLE_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 5 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'DISCAPACIDAD_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 10 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'POBLACION_CARCELARIA_N',
        '' AS 'PROFESIONALES',
        COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 22 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'LGBTIQ_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 4 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'POBLACION_VICTIMA_CONFLICTO_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 19 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'MIGRANTES_N',
        '' AS 'VICTIMAS_TRATA', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 23 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'EMERGENCIA_SOCIAL_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 20 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND

        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'DETERIORO_URBANO_N',
        '' AS 'VULNERABILIDAD', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 26 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'DESPLAZAMIENTO_N',
        '' AS 'CONSUMIDORAS', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 2 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'ROM_N',
        '' AS 'PRO_ROM', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 3 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'INDIGENA_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 25 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'COMUNIDADES_NEGRAS_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 1 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'AFRODESCENDIENTE_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 21 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'PALENQUERA_N', COALESCE((CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,l.fecha_llamada) < 7 AND b.IN_Grupo_Poblacional = 13 AND
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 1, 0) THEN 1 END), '') AS 'RAIZALES_N',
        '' AS OBSERVACIONES,
        IF(
        (
        SELECT
        ex.DT_Fecha_Encuentro
        FROM tb_nidos_asistencia AS nas
        LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND nas.Vc_Asistencia=1
        ORDER BY nas.Fk_Id_Experiencia DESC
        LIMIT 1) IS NULL AND

        (
        SELECT
        na.Pk_Id_Asistencia
        FROM tb_nidos_asistencia na
        LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-25'
        ORDER BY na.Fk_Id_Evento DESC
        LIMIT 1) IS NULL AND
        (
        SELECT
        al.Pk_Id_Asistencia
        FROM tb_nidos_asistencia al
        JOIN tb_nidos_llamadas l ON l.id=al.Fk_Id_Llamada
        WHERE al.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND l.fecha_llamada BETWEEN '2021-01-01' AND '2021-$id_mes-25' AND al.Vc_Asistencia=1
        ORDER BY al.Pk_Id_Asistencia ASC
        LIMIT 1) = a.Pk_Id_Asistencia, 'Nuevo', 'Antiguo') AS ATENDIDO
        FROM tb_nidos_llamadas l
        JOIN tb_nidos_atenciones_virtuales av ON av.Pk_Id_Registro=l.fk_atencion_virtual
        JOIN tb_nidos_asistencia a ON a.Fk_Id_Llamada=l.id
        JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=a.Fk_Id_Beneficiario
        JOIN tb_parametro_detalle pdl ON pdl.FK_Value=av.IN_Localidad AND pdl.FK_Id_Parametro=19
        WHERE l.fecha_llamada BETWEEN '2021-$id_mes_anterior-26' AND '2021-$id_mes-25' AND a.Vc_Asistencia=1
        HAVING ATENDIDO='Nuevo'";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function aprobarEvento($id_evento, $estado)
    {
        $sql = "UPDATE tb_nidos_evento_circulacion SET IN_Aprobacion=:estado WHERE Pk_Id_Evento=:id_evento";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_evento', $id_evento);
        @$sentencia->bindParam(':estado', $estado);
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function getReportePdf($id_dupla, $id_mes)
    {
        $sql = "SELECT
        IN_Num_Grupos AS TOTAL_GRUPOS,
        IN_Experiencias AS TOTAL_EXPERIENCIAS,
        ARTISTAS,
        TERRITORIO,
        GESTOR,
        EAAT,
        NINOS_DE_0_3_ANIOS_N AS NINOS_DE_0_3_ANIOS_N,
        NINAS_DE_0_3_ANIOS_N AS NINAS_DE_0_3_ANIOS_N,
        NINOS_DE_4_6_ANIOS_N AS NINOS_DE_4_6_ANIOS_N,
        NINAS_DE_4_6_ANIOS_N AS NINAS_DE_4_6_ANIOS_N,
        NINOS_FUERA_RANGO_N AS NINOS_FUERA_RANGO_N,
        NINAS_FUERA_RANGO_N AS NINAS_FUERA_RANGO_N,
        GESTANTES_N AS GESTANTES_N,
        TOTAL_N AS TOTAL_N,
        AFRODESCENDIENTE_N AS AFRODESCENDIENTE_N,
        ROM_N AS ROM_N,
        INDIGENA_N AS INDIGENA_N,
        CONFLICTO_N AS CONFLICTO_N,
        DISCAPACIDAD_N AS DISCAPACIDAD_N,
        PRIVADOS_N AS PRIVADOS_N,
        RAIZALES_N AS RAIZALES_N,
        CAMPESINA_N AS CAMPESINA_N,
        NINOS_DE_0_3_ANIOS_R + NINOS_DE_0_3_ANIOS_S AS NINOS_DE_0_3_ANIOS_R,
        NINAS_DE_0_3_ANIOS_R + NINAS_DE_0_3_ANIOS_S AS NINAS_DE_0_3_ANIOS_R,
        NINOS_DE_4_6_ANIOS_R + NINOS_DE_4_6_ANIOS_S AS NINOS_DE_4_6_ANIOS_R,
        NINAS_DE_4_6_ANIOS_R + NINAS_DE_4_6_ANIOS_S AS NINAS_DE_4_6_ANIOS_R,
        NINOS_FUERA_RANGO_R + NINOS_DE_6_10_ANIOS_S AS NINOS_FUERA_RANGO_R,
        NINAS_FUERA_RANGO_R + NINAS_DE_6_10_ANIOS_S AS NINAS_FUERA_RANGO_R,
        GESTANTES_R + GESTANTES_S AS GESTANTES_R,
        TOTAL_R + TOTAL_S AS TOTAL_R,
        CAMPESINA_R AS CAMPESINA_R,
        INDIGENA_R AS INDIGENA_R,
        AFRODESCENDIENTE_R AS AFRODESCENDIENTE_R,
        ROM_R AS ROM_R,
        RAIZALES_R AS RAIZALES_R,
        PALENQUERA_R AS PALENQUERA_R,
        COMUNIDADES_NEGRAS_R AS COMUNIDADES_NEGRAS_R,
        PRIVADOS_R AS PRIVADOS_R,
        DISCAPACIDAD_R AS DISCAPACIDAD_R,
        PERSONAS_HABITANTES_CALLE_R AS PERSONAS_HABITANTES_CALLE_R,
        PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R,
        CONFLICTO_R AS CONFLICTO_R,
        DESPLAZAMIENTO_R AS DESPLAZAMIENTO_R,
        MIGRANTES_R AS MIGRANTES_R,
        DETERIORO_URBANO_R AS DETERIORO_URBANO_R,
        EMERGENCIA_SOCIAL_R AS EMERGENCIA_SOCIAL_R,
        LGBTIQ_R AS LGBTIQ_R
        FROM
        (SELECT
        SUM(ec.IN_Num_Grupos) AS IN_Num_Grupos,
        SUM(ec.IN_Experiencias) AS IN_Experiencias , 
        (SELECT 
        GROUP_CONCAT(CONCAT(UPPER(SUBSTRING(p.VC_Primer_Nombre,1,1)), LOWER(SUBSTRING(p.VC_Primer_Nombre,2)) ,' ', UPPER(SUBSTRING(p.VC_Primer_Apellido,1,1)), LOWER(SUBSTRING(p.VC_Primer_Apellido,2))) SEPARATOR ', ')
        FROM tb_nidos_dupla_artista da
        JOIN tb_persona_2017 p ON p.PK_Id_Persona=da.Fk_Id_Persona
        WHERE Fk_Id_Dupla=$id_dupla AND IN_Estado=1
        GROUP BY Fk_Id_Dupla) AS ARTISTAS,
        (SELECT 
        t.Vc_Nom_Territorio
        FROM tb_nidos_dupla d
        JOIN tb_nidos_territorios t ON t.Pk_Id_Territorio=d.Fk_Id_Territorio
        WHERE PK_Id_Dupla=$id_dupla AND IN_Estado=1) AS TERRITORIO,
        (SELECT
        CONCAT(UPPER(SUBSTRING(p.VC_Primer_Nombre,1,1)), LOWER(SUBSTRING(p.VC_Primer_Nombre,2)) ,' ', UPPER(SUBSTRING(p.VC_Primer_Apellido,1,1)), LOWER(SUBSTRING(p.VC_Primer_Apellido,2)))
        FROM tb_nidos_dupla d
        JOIN tb_persona_2017 p ON p.PK_Id_Persona=d.Fk_Id_Gestor
        WHERE PK_Id_Dupla=$id_dupla AND IN_Estado=1) AS GESTOR,
        (SELECT
        CONCAT(UPPER(SUBSTRING(p.VC_Primer_Nombre,1,1)), LOWER(SUBSTRING(p.VC_Primer_Nombre,2)) ,' ', UPPER(SUBSTRING(p.VC_Primer_Apellido,1,1)), LOWER(SUBSTRING(p.VC_Primer_Apellido,2)))
        FROM tb_nidos_dupla d
        JOIN tb_persona_2017 p ON p.PK_Id_Persona=d.Fk_Id_Eaat
        WHERE PK_Id_Dupla=$id_dupla AND IN_Estado=1) AS EAAT

        FROM tb_nidos_evento_circulacion AS ec
        JOIN tb_nidos_lugar_atencion AS la ON ec.VC_Lugar_Atencion= la.Pk_Id_lugar_atencion
        JOIN tb_nidos_tipo_lugar AS tl ON la.VC_Tipo_Lugar=tl.Pk_Id_Lugar
        JOIN tb_localidades AS l ON la.Fk_Id_Localidad=l.Pk_Id_Localidad
        JOIN tb_upz AS u ON la.Fk_Id_Upz=u.Pk_Id_Upz
        WHERE FIND_IN_SET($id_dupla, ec.IN_Cantidad_Equipos) AND ec.IN_Estado_Evento=4 AND ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31' AND ec.IN_Aprobacion=1) AS PRIMERA,

        (SELECT
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINOS_DE_0_3_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINAS_DE_0_3_ANIOS_N,

        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINOS_DE_4_6_ANIOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINAS_DE_4_6_ANIOS_N,

        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINOS_FUERA_RANGO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS NINAS_FUERA_RANGO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 12 AND b.FK_Id_Genero = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS GESTANTES_N,
        COUNT(CASE
        WHEN (TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 OR TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) >=12) AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS TOTAL_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 14 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS CAMPESINA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 3 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS INDIGENA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 1 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS AFRODESCENDIENTE_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 2 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS ROM_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 13 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS RAIZALES_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 21 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PALENQUERA_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 25 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS COMUNIDADES_NEGRAS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 10 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PRIVADOS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 5 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DISCAPACIDAD_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 12 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PERSONAS_HABITANTES_CALLE_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 18 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 4 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS CONFLICTO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 26 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DESPLAZAMIENTO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 19 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS MIGRANTES_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 20 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS DETERIORO_URBANO_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 23 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS EMERGENCIA_SOCIAL_N,
        COUNT(CASE
        WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 AND b.IN_Grupo_Poblacional = 22 AND
        IF((SELECT COALESCE(MAX(ex.DT_Fecha_Encuentro), '2900-01-01') FROM tb_nidos_asistencia AS nas LEFT JOIN tb_nidos_experiencia AS ex ON ex.Pk_Id_Experiencia=nas.Fk_Id_Experiencia
        WHERE nas.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND nas.Vc_Asistencia=1 AND DT_Fecha_Encuentro BETWEEN '2021-01-01' AND '2021-$id_mes-31') > ec.DT_Fecha_Evento AND (
        SELECT MIN(na.Pk_Id_Asistencia) FROM tb_nidos_asistencia na LEFT JOIN tb_nidos_evento_circulacion e ON na.Fk_Id_Evento = e.Pk_Id_Evento
        WHERE na.Fk_Id_Beneficiario = a.Fk_Id_Beneficiario AND e.DT_Fecha_Evento BETWEEN '2021-01-01' AND '2021-$id_mes-31') = a.Pk_Id_Asistencia, 1, 0) THEN 1
        END) AS LGBTIQ_N
        FROM tb_nidos_evento_circulacion ec
        JOIN tb_nidos_asistencia a ON a.Fk_Id_Evento=ec.Pk_Id_Evento
        JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=a.Fk_Id_Beneficiario
        WHERE FIND_IN_SET($id_dupla, ec.IN_Cantidad_Equipos) AND ec.IN_Estado_Evento=4 AND ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31' AND ec.IN_Aprobacion=1) AS SEGUNDA,
        (SELECT
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 1 THEN 1 END ) AS NINOS_DE_0_3_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 3 AND b.FK_Id_Genero = 2 THEN 1 END ) AS NINAS_DE_0_3_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 1 THEN 1 END ) AS NINOS_DE_4_6_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) <= 5 AND b.FK_Id_Genero = 2 THEN 1 END ) AS NINAS_DE_4_6_ANIOS_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 1 THEN 1 END ) AS NINOS_FUERA_RANGO_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 6 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 AND b.FK_Id_Genero = 2 THEN 1 END ) AS NINAS_FUERA_RANGO_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 12 AND b.FK_Id_Genero = 2 THEN 1 END ) AS GESTANTES_R,
        COUNT( CASE WHEN TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) >= 0 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,ec.DT_Fecha_Evento) < 7 THEN 1 END ) AS TOTAL_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 14 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS CAMPESINA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 3 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS INDIGENA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 1 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS AFRODESCENDIENTE_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 2 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS ROM_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 13 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS RAIZALES_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 21 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PALENQUERA_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 25 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS COMUNIDADES_NEGRAS_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 10 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PRIVADOS_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 5 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS DISCAPACIDAD_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 12 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PERSONAS_HABITANTES_CALLE_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 18 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS PERSONAS_ACTIVIDADES_SEXUALES_PAGADAS_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 4 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS CONFLICTO_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 26 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS DESPLAZAMIENTO_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 19 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS MIGRANTES_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 20 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS DETERIORO_URBANO_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 23 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS EMERGENCIA_SOCIAL_R,
        COUNT( CASE WHEN b.IN_Grupo_Poblacional = 22 AND TIMESTAMPDIFF(YEAR,b.DD_F_Nacimiento,DT_Fecha_Evento) < 7 then 1 END) AS LGBTIQ_R
        FROM tb_nidos_evento_circulacion ec
        JOIN tb_nidos_asistencia a ON a.Fk_Id_Evento=ec.Pk_Id_Evento
        JOIN tb_nidos_beneficiarios b ON b.Pk_Id_Beneficiario=a.Fk_Id_Beneficiario
        WHERE FIND_IN_SET($id_dupla, ec.IN_Cantidad_Equipos) AND ec.IN_Estado_Evento=4 AND ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31' AND ec.IN_Aprobacion=1) AS TERCERA,
        (SELECT
        SUM(ae.VC_Ninos_0_3) AS NINOS_DE_0_3_ANIOS_S,  
        SUM(ae.VC_Ninas_0_3) AS NINAS_DE_0_3_ANIOS_S,  
        SUM(ae.VC_Ninos_4_6) AS NINOS_DE_4_6_ANIOS_S,  
        SUM(ae.VC_Ninas_4_6) AS NINAS_DE_4_6_ANIOS_S,  
        SUM(ae.VC_Ninos_6_10) AS NINOS_DE_6_10_ANIOS_S,
        SUM(ae.VC_Ninas_6_10) AS NINAS_DE_6_10_ANIOS_S,
        SUM(ae.VC_Madres) AS GESTANTES_S,
        SUM(ae.VC_Ninos_0_3 + ae.VC_Ninos_4_6 + ae.VC_Ninas_0_3 + ae.VC_Ninas_4_6 + ae.VC_Ninos_6_10 + ae.VC_Ninas_6_10) AS TOTAL_S
        FROM tb_nidos_evento_circulacion ec
        JOIN tb_nidos_asistentes_evento ae ON ae.Fk_Id_Evento=ec.Pk_Id_Evento
        WHERE FIND_IN_SET($id_dupla, ec.IN_Cantidad_Equipos) AND ec.IN_Estado_Evento=4 AND ec.DT_Fecha_Evento BETWEEN '2021-$id_mes-01' AND '2021-$id_mes-31' AND ec.IN_Aprobacion=1) as CUARTA";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function validarFechaAsignacion($id_atencion_virtual)
    {
        $sql = "SELECT
        DT_Fecha_Llamada
        FROM tb_nidos_atenciones_virtuales av
        WHERE av.Pk_Id_Registro=:id_atencion_virtual";

        @$sentencia = $this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_atencion_virtual', $id_atencion_virtual);
        @$sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }
}
