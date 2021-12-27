<?php

namespace General\Persistencia\DAOS;


class OptionsDAO extends GestionDAO {

    private $db;
    private $dbPDO;

    function __construct()
    {
        $this->db=$this->obtenerBD();
        $this->dbPDO=$this->obtenerPDOBD();
        //echo "<pre>".print_r($this->db,true)."</pre>";
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

    public function getClanes($estado){
		//return  $this->db->select("tb_clan",["PK_Id_Clan","VC_Nom_Clan"]);
        $sql="SELECT * FROM tb_clan AS C WHERE C.IN_Estado<>:estado";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':estado',$estado);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

    }

    function getArtistasFormadores($conGrupos){

        if($conGrupos!="false"){
            //echo "verdad";
            $sql="  SELECT
            P.PK_Id_Persona,
            P.VC_Identificacion,
            CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'NOMBRE'
            FROM tb_persona_2017 AS P
            JOIN tb_acceso_usuario_2017 AS A ON A.FK_Id_Persona=P.PK_Id_Persona
            JOIN (  SELECT G.FK_artista_formador FROM tb_terr_grupo_arte_escuela AS G WHERE G.estado=1 AND G.`FK_artista_formador`IS NOT NULL
            UNION
            SELECT G.FK_artista_formador FROM tb_terr_grupo_emprende_clan AS G WHERE G.estado=1  AND G.`FK_artista_formador`IS NOT NULL
            UNION
            SELECT G.FK_artista_formador FROM tb_terr_grupo_laboratorio_clan AS G WHERE G.estado=1 AND G.`FK_artista_formador`IS NOT NULL) AS AC
            ON AC.FK_artista_formador = P.`PK_Id_Persona`
            WHERE FIND_IN_SET(P.FK_Tipo_Persona,'1,2') AND A.`IN_Estado`=1
            ";
        }
        else{
            //echo "falso";
            $sql="  SELECT
            P.PK_Id_Persona,
            P.VC_Identificacion,
            CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'NOMBRE'
            FROM tb_persona_2017 AS P
            JOIN tb_acceso_usuario_2017 AS A ON A.FK_Id_Persona=P.PK_Id_Persona
            WHERE FIND_IN_SET(P.FK_Tipo_Persona,'1,2')  AND A.`IN_Estado`=1";
        }
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsArtistasFormadoresNidos(){
        $sql="  SELECT
            P.PK_Id_Persona,
            P.VC_Identificacion,
            CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'NOMBRE'
            FROM tb_persona_2017 AS P
            JOIN tb_acceso_usuario_2017 AS A ON A.FK_Id_Persona=P.PK_Id_Persona
            WHERE FIND_IN_SET(P.FK_Tipo_Persona,'16')  AND A.`IN_Estado`=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsArtistasFormadoresDeAreaArtistica($id_area_artistica){
        $sql = "SELECT
        P.PK_Id_Persona,
        P.VC_Identificacion,
        CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'NOMBRE'
        FROM tb_persona_2017 AS P
        JOIN tb_acceso_usuario_2017 AS A ON A.FK_Id_Persona=P.PK_Id_Persona
        JOIN (  SELECT G.FK_artista_formador FROM tb_terr_grupo_arte_escuela AS G WHERE G.estado=1 AND G.`FK_artista_formador`IS NOT NULL AND G.FK_area_artistica = $id_area_artistica
        UNION
        SELECT G.FK_artista_formador FROM tb_terr_grupo_emprende_clan AS G WHERE G.estado=1  AND G.`FK_artista_formador`IS NOT NULL AND G.FK_area_artistica = $id_area_artistica
        UNION
        SELECT G.FK_artista_formador FROM tb_terr_grupo_laboratorio_clan AS G WHERE G.estado=1 AND G.`FK_artista_formador`IS NOT NULL AND G.FK_area_artistica = $id_area_artistica) AS AC
        ON AC.FK_artista_formador = P.`PK_Id_Persona`
        WHERE FIND_IN_SET(P.FK_Tipo_Persona,'1,2') AND A.`IN_Estado`=1";
        $sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAreasArtisticas(){
        $sql="SELECT * FROM tb_parametro_detalle PD JOIN tb_parametro P ON P.PK_Id_Parametro=PD.FK_Id_Parametro WHERE P.VC_Nombre='ÁREAS ARTÍSTICAS' AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsAreasArtisticasPorColegio($listaColegios){
        $sql="SELECT DISTINCT(PD.vc_descripcion) AS VC_Descripcion , PD.FK_Value
        FROM tb_terr_grupo_arte_escuela G
        JOIN tb_parametro_detalle PD ON PD.fk_value=G.fk_area_artistica
        WHERE FIND_IN_SET(G.fk_colegio,:listaColegios) AND PD.fk_id_parametro=6 AND PD.in_estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':listaColegios',$listaColegios);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getColegios(){
        $sql="SELECT * FROM tb_colegios";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getColegiosAtendidos(){
        $sql="SELECT SC.FK_colegio, C.* FROM tb_terr_grupo_arte_escuela_sesion_clase SC JOIN tb_colegios C ON C.PK_Id_Colegio=SC.FK_colegio GROUP BY SC.FK_colegio;";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getGrados(){
        $sql="SELECT * FROM tb_grado";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getEventosActivos($id_usuario){
        $sql="SELECT PK_Id_Evento,VC_Nombre,FK_Tipo_Evento FROM tb_circ_evento ";
        if($id_usuario != 0)
            $sql .= "JOIN tb_circ_evento_artista_formador ON PK_Id_Evento = FK_Evento AND FK_Artista_Formador = :id_usuario ";
        $sql .= "WHERE estado_evento = 1";
        @$sentencia=$this->dbPDO->prepare($sql);
        if($id_usuario != 0)
            @$sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getNovedades()
    {
        $sql="SELECT * FROM tb_tipo_novedad";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTiposDeIdentificacion()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=13 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsGenero()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=17 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPerfiles($parametro)
    {
        $campo_estado = '';
        switch ($parametro) {
            case '2':
                $campo_estado = 'PD.IN_Estado = 1';
                break;
            case '3':
                $campo_estado = 'PD.IN_Estado_Nidos = 1';
                break;
            case '98':
                $campo_estado = 'PD.IN_Estado_Culturas = 1';
                break;
            default:
                $campo_estado = 'PD.IN_Estado = 1';
                break;
        }
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:parametro AND ".$campo_estado;
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getParametroDetalle($parametro)
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:parametro AND PD.IN_Estado = 1 ORDER BY FK_Value ASC";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getParametroDetalleByOrder($parametro, $ordenar_por, $orden)
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:parametro AND PD.IN_Estado = 1 ORDER BY ".$ordenar_por." ".$orden;
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getParametroDetalleActivoInactivo($parametro)
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:parametro";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getParametroDetalleProyectoEstado($id_parametro, $id_proyecto, $estado)
    {
        if($estado != null){
            $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:id_parametro AND JSON_EXTRACT(PD.TX_Estado_Proyecto, '$.$id_proyecto') = :estado ORDER BY FK_Value ASC";
        }
        else{
            $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=:id_parametro AND JSON_EXTRACT(PD.TX_Estado_Proyecto, '$.$id_proyecto') IS NOT :estado ORDER BY FK_Value ASC";
        }

        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_parametro',$id_parametro);
        @$sentencia->bindParam(':estado',$estado);
        
        //$sentencia->debugDumpParams();
        $sentencia->execute();

        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPermisosRol($parametro)
    {
        $sql = 'SELECT tm.PK_Id_Actividad,tm.VC_Nom_Actividad, COUNT(tpa.FK_Actividad) AS estado, tmm.VC_Nom_Modulo
        FROM tb_menu_actividad tm
        LEFT JOIN tb_tipo_persona_actividad tpa ON tpa.FK_Actividad = tm.PK_Id_Actividad AND tpa.FK_Tipo_Persona = :parametro
        LEFT JOIN tb_menu_modulo tmm ON tmm.PK_Id_Modulo = tm.FK_Modulo WHERE (tm.estado = 1 OR tm.estado = 2)
        GROUP BY tm.PK_Id_Actividad
        order by tmm.PK_Id_Modulo,tm.VC_Nom_Actividad';
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLocalidades($id_usuario)
    {
        $sql="SELECT L.Pk_Id_Localidad, L.VC_Nom_Localidad
        FROM tb_nidos_persona_territorio AS PT
        JOIN tb_nidos_terri_locali AS TL ON PT.Fk_Id_Territorio = TL.Fk_Id_Territorio
        JOIN tb_localidades AS L ON TL.Fk_Id_Localidad = L.Pk_Id_Localidad
        AND PT.IN_Estado = 1 AND PT.Fk_Id_Persona = :usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUpzLocalidad($parametro)
    {
        $sql="SELECT * FROM tb_upz U WHERE U.FK_Id_Localidad = :parametro";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLugarNidosUpz($parametro)
    {
        $sql="SELECT LA.Pk_Id_lugar_atencion, LA.VC_Nombre_Lugar FROM tb_nidos_lugar_atencion AS LA WHERE LA.Fk_Id_Upz = :parametro";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':parametro',$parametro);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsAnio()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=7 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsMes()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=8 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsGPoblacional()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=14 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsEPS()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=16 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsGSanguineo()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=15 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsColegiosCrea($id_crea)
    {
        //print_r($id_crea);
        $sql="SELECT DISTINCT(CC.FK_Id_Colegio),COL.VC_Nom_Colegio,COL.VC_DANE_12
        FROM tb_clan_colegio CC
        JOIN tb_colegios COL ON CC.FK_Id_Colegio=COL.PK_Id_Colegio
        WHERE FIND_IN_SET (CC.FK_Id_Clan,:FK_Id_Clan)";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':FK_Id_Clan',$id_crea);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsJornada()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=11 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsGrado()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=12 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsLocalidad()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=19 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsLugarInventario()
    {
        $sql="SELECT * FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=27 AND PD.IN_Estado=1";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getEtnias(){
        $sql="SELECT * FROM tb_etnia";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsActividades(){
        $sql="SELECT * FROM tb_menu_actividad WHERE estado=1 OR estado=2";
        @$sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarDatosBasicosUsuario($id_usuario){
        $sql="SELECT P.VC_Identificacion, P.VC_Primer_Nombre, P.VC_Segundo_Nombre, P.VC_Primer_Apellido, P.VC_Segundo_Apellido, P.VC_Correo, PD.VC_Descripcion AS rol_usuario,ED.TX_Firma_Escaneada
        FROM tb_persona_2017 P
        LEFT JOIN tb_parametro_detalle PD ON P.FK_Tipo_Persona = PD.FK_Value AND PD.FK_Id_Parametro IN (2,3,4)
        LEFT JOIN tb_persona_extra_data ED ON P.PK_Id_Persona = ED.FK_Id_Persona
        WHERE P.PK_Id_Persona=:id_usuario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_usuario',$id_usuario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsGruposDeUnColegio($datos) {
        if($datos['linea']=='arte_escuela')
            $where=" FIND_IN_SET(FK_colegio,:colegioCrea)";
        else
            $where=" FIND_IN_SET(FK_clan,:colegioCrea)";
        $sql="SELECT PK_grupo FROM tb_terr_grupo_".$datos['linea']." WHERE ".$where." AND estado=1;";
        //echo $sql;
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':colegioCrea',$datos['colegioCrea']);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOptionsUsuariosRol($id_rol,$todos){
        $where="";
        if($todos){
            $where="FIND_IN_SET(PD.FK_Id_Parametro,(
            SELECT
            (CASE WHEN PD.FK_Id_Parametro = 4 THEN '2,3,4'
            ELSE CONCAT(PD.FK_Id_Parametro,',4') END )
            FROM tb_parametro_detalle as PD WHERE PD.FK_Value=:id_rol AND PD.FK_Id_Parametro<5
            )
        )";
    }
    else{
        $where="P.FK_Tipo_Persona=:id_rol ";
    }
    $sql="SELECT P.PK_Id_Persona, P.VC_Identificacion, P.VC_Primer_Nombre, P.VC_Segundo_Nombre, P.VC_Primer_Apellido, P.VC_Segundo_Apellido, P.VC_Correo
    FROM tb_persona_2017 P
    JOIN tb_acceso_usuario_2017 AU on AU.FK_Id_Persona=P.PK_Id_Persona
    JOIN tb_parametro_detalle as PD on PD.FK_Value=P.FK_Tipo_Persona AND PD.FK_Id_Parametro<5
    WHERE ".$where." AND AU.IN_Estado=1  ORDER BY P.VC_Primer_Nombre, P.VC_Segundo_Nombre, P.VC_Primer_Apellido, P.VC_Segundo_Apellido";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_rol',$id_rol);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getParametros(){
    $sql="SELECT * FROM tb_parametro;";
    @$sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getTiposIndicadores($id_seccion){
    $sql="SELECT DISTINCT(PD.FK_Value) AS FK_Value, PD.VC_Descripcion
    FROM tb_centro_monitoreo AS CM
    JOIN tb_parametro_detalle AS PD ON PD.FK_Value=CM.FK_tipo_indicador AND PD.FK_Id_Parametro=40
    WHERE CM.IN_seccion= :in_seccion";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':in_seccion',$id_seccion);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getAllTiposIndicadores(){
    $sql="SELECT PD.FK_Value, PD.VC_Descripcion from tb_parametro_detalle AS PD WHERE PD.FK_Id_Parametro=40  ";
    @$sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getTipoDeGraficas(){
    $sql="SELECT * FROM tb_parametro_detalle PD  WHERE PD.FK_Id_Parametro=41 AND PD.IN_Estado=1";
    @$sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getTipoDeFiltrosGraficos(){
    $sql="SELECT * FROM tb_parametro_detalle PD  WHERE PD.FK_Id_Parametro=42 AND PD.IN_Estado=1";
    @$sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarLugarAtencion() {
    $sql="SELECT * FROM tb_nidos_tipo_lugar";
    $sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getAniosEstadisticas(){
    $sql="SELECT DISTINCT PK_Anio FROM tb_estadistica_anio";
    $sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);   
}

public function getProyectos(){
    $sql="SELECT id, nombre, descripcion, estado, created_at, updated_at FROM tb_proyectos";
    $sentencia=$this->dbPDO->prepare($sql);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);   
}

public function getOptionsBarriosLocalidad($id_localidad){
    @$sentencia=$this->dbPDO->prepare($sql);
    $sql="SELECT * FROM tb_barrios WHERE FK_Id_Localidad=:id_localidad";
    $sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':id_localidad',$id_localidad);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);   
}

public function getOptionsColegiosCreaNew($id_crea, $anio)
{

    $sql = "SELECT DISTINCT FK_colegio AS id_Colegio, VC_Nom_Colegio AS nombre_Colegio 
            FROM tb_terr_grupo_arte_escuela_sesion_clase
            WHERE FIND_IN_SET(FK_Clan, :FK_Id_Clan) 
            AND YEAR (DA_fecha_clase) = :anio 
            ORDER BY VC_Nom_Colegio";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':FK_Id_Clan',$id_crea);
    @$sentencia->bindParam(':anio',$anio);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getOptionsColegiosConvenio($convenio, $year){
    $sql = "SELECT COL.VC_Nom_Colegio as 'text', COL.PK_Id_Colegio AS 'value'
    FROM tb_terr_grupo_arte_escuela G
    JOIN tb_colegios COL ON COL.PK_Id_Colegio=G.FK_colegio
    WHERE G.IN_convenio=:convenio AND YEAR(G.DT_fecha_creacion)=:anio
    GROUP BY COL.PK_Id_Colegio
    ORDER BY VC_Nom_Colegio";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':convenio',$convenio);
    @$sentencia->bindParam(':anio',$year);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getOptionsConveniosByLineaAtencionYear($linea_atencion, $year){
    $sql = "SELECT PD.VC_Descripcion AS 'text', PD.FK_Value AS 'value'
    FROM tb_terr_grupo_".$linea_atencion." G
    JOIN tb_parametro_detalle PD ON PD.FK_Value=G.IN_convenio AND PD.FK_Id_Parametro=68
    WHERE YEAR(G.DT_fecha_creacion)=:anio
    GROUP BY G.IN_convenio";
    @$sentencia=$this->dbPDO->prepare($sql);
    @$sentencia->bindParam(':anio',$year);
    $sentencia->execute();
    return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

}
