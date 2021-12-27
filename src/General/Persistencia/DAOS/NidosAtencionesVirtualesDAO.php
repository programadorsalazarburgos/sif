<?php 

namespace General\Persistencia\DAOS;

class NidosAtencionesVirtualesDAO extends GestionDAO {

    private $db;

    function __construct() {
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

    public function guardarSolicitud($objeto){

        $sql = "INSERT INTO tb_nidos_atenciones_virtuales (VC_Primer_Nombre_Cuidador, VC_Correo, IN_Tipo_Doc_Cuidador, IN_Identificacion_Cuidador, IN_Localidad, VC_Otro_Lugar, VC_Barrio, VC_Direccion, IN_Estrato, VC_Edad_Cuidador, IN_Dirigida_Atencion, IN_Parentesco, IN_Potestad, VC_Identificacion, FK_Tipo_Identificacion, VC_Primer_Nombre_Beneficiario, VC_Primer_Apellido_beneficiario, DD_F_Nacimiento, VC_Grupo_Poblacional, VC_Edad_Beneficiario, VC_Institucion, VC_Entidad, VC_Telefono, IN_Tipo_Atencion, IN_Horario_Llamada, VC_Comentarios, VC_Autorizacion, DD_Fecha_Solicitud, IN_Formulario) VALUES (:nombre_cuidador, :correo_cuidador, :tipo_doc_cuidador, :identificacion_cuidador, :localidad, :otra_localidad, :barrio, :direccion, :estrato, :edad_cuidador, :atencion_dirigida_a, :parentesco, :potestad, :identificacion_beneficiario, :tipo_doc_beneficiario, :nombres_beneficiario, :apellidos_beneficiario, :fecha_nacimiento_beneficiario, :enfoque_beneficiario, :edad_beneficiario, :institucion, :entidad, :telefono,  :tipo_atencion, :horario, :comnetarios, :autorizacion, :fecha_solicitud, :formulario)";

        @$sentencia=$this->dbPDO->prepare($sql);

        @$sentencia->bindParam(':nombre_cuidador',$objeto->getVcPrimerNombreCuidador());
        @$sentencia->bindParam(':correo_cuidador',$objeto->getVcCorreo());
        @$sentencia->bindParam(':tipo_doc_cuidador',$objeto->getInTipoDocCuidador());
        @$sentencia->bindParam(':identificacion_cuidador',$objeto->getInIdentificacionCuidador());
        @$sentencia->bindParam(':localidad',$objeto->getInLocalidad());
        @$sentencia->bindParam(':otra_localidad',$objeto->getVcOtroLugar());
        @$sentencia->bindParam(':barrio',$objeto->getVcBarrio());
        @$sentencia->bindParam(':direccion',$objeto->getVcDireccion());
        @$sentencia->bindParam(':estrato',$objeto->getInEstrato());
        @$sentencia->bindParam(':edad_cuidador',$objeto->getVcEdadCuidador());
        @$sentencia->bindParam(':atencion_dirigida_a',$objeto->getInDirigidaAtencion());
        @$sentencia->bindParam(':parentesco',$objeto->getInParentesco());
        @$sentencia->bindParam(':potestad',$objeto->getInPotestad());
        @$sentencia->bindParam(':identificacion_beneficiario',$objeto->getVcIdentificacion());
        @$sentencia->bindParam(':tipo_doc_beneficiario',$objeto->getFkTipoIdentificacion());
        @$sentencia->bindParam(':nombres_beneficiario',$objeto->getVCPrimerNombreBeneficiario());
        @$sentencia->bindParam(':apellidos_beneficiario',$objeto->getVCPrimerApellidobeneficiario());
        @$sentencia->bindParam(':fecha_nacimiento_beneficiario',$objeto->getDdFNacimiento());
        @$sentencia->bindParam(':enfoque_beneficiario',$objeto->getVcGrupoPoblacional());
        @$sentencia->bindParam(':edad_beneficiario',$objeto->getVcEdadBeneficiario());
        @$sentencia->bindParam(':institucion', $objeto->getVcInstitucion());
        @$sentencia->bindParam(':entidad', $objeto->getVcEntidad());
        @$sentencia->bindParam(':telefono',$objeto->getVcTelefono());
        @$sentencia->bindParam(':tipo_atencion',$objeto->getInTipoAtencion());
        @$sentencia->bindParam(':horario',$objeto->getInHorarioLlamada());
        @$sentencia->bindParam(':comnetarios',$objeto->getVcComentarios());
        @$sentencia->bindParam(':autorizacion',$objeto->getVcAutorizacion());
        @$sentencia->bindParam(':fecha_solicitud',$objeto->getDdFechaSolicitud());
        @$sentencia->bindParam(':formulario',$objeto->getInFormulario());

        try{
            $this->dbPDO->beginTransaction();
            $sentencia->execute();

            $sql2 = "UPDATE tb_nidos_horarios_atencion ha SET ha.IN_Cupos_Disponibles=(ha.IN_Cupos_Disponibles-1)
            WHERE ha.Pk_Id_Horario=:horario";

            $sentencia2=$this->dbPDO->prepare($sql2);
            @$sentencia2->bindParam(':horario',$objeto->getInHorarioLlamada());
            $sentencia2->execute();
            $this->dbPDO->commit();
            return true;
        }catch(PDOExecption $e) {
            $this->dbPDO->rollback();
            return "Error!: " . $e->getMessage() . "</br>";
        }
    }

    public function getTiposAtencionDisponible($id_formulario){
        $sql = "SELECT
        ha.IN_Id_Tipo_Atencion as 'Id'
        FROM tb_nidos_horarios_atencion ha
        WHERE ha.IN_Id_Formulario=:id_formulario AND ha.DT_Fecha_Atencion > NOW() AND ha.IN_Cupos_Disponibles > 0
        GROUP BY ha.IN_Id_Tipo_Atencion
        ORDER BY ha.IN_Id_Tipo_Atencion ASC";
        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_formulario',$id_formulario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarAtencionPrevia($id_beneficiario){

        $sql = "SELECT * FROM tb_nidos_atenciones_virtuales where VC_Identificacion=:id_beneficiario OR IN_Identificacion_Cuidador=:id_beneficiario ORDER BY Pk_Id_Registro DESC LIMIT 1";

        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_beneficiario',$id_beneficiario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getHorarios($tipo_formulario, $tipo_atencion){
        $sql="SELECT
        ha.Pk_Id_Horario as 'Id',
        CONCAT(ha.VC_Dia, ' ', DATE_FORMAT(ha.DT_Fecha_Atencion, '%d de '),
        CASE
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'January' THEN 'Enero'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'February' THEN 'Febrero'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'March' THEN 'Marzo'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'April' THEN 'Abril'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'May' THEN 'Mayo'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'June' THEN 'Junio'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'July' THEN 'Julio'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'August' THEN 'Agosto'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'September' THEN 'Septiembre'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'October' THEN 'Octubre'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'November' THEN 'Noviembre'
        WHEN DATE_FORMAT(ha.DT_Fecha_Atencion, '%M') = 'December' THEN 'Diciembre'
        END,
        DATE_FORMAT(ha.DT_Fecha_Atencion, ' de %Y'), ' - Entre las ', time_format(ha.VC_Hora_Inicio, '%h:%i %p'), ' y ', time_format(ha.VC_Hora_Fin, '%h:%i %p')) as 'Horario'
        FROM tb_nidos_horarios_atencion ha
        WHERE ha.IN_Id_Formulario=:tipo_formulario AND ha.DT_Fecha_Atencion > NOW() AND ha.IN_Cupos_Disponibles > 0 AND ha.IN_Id_Tipo_Atencion=:tipo_atencion
        ORDER BY ha.DT_Fecha_Atencion, ha.VC_Hora_Inicio ASC";

        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':tipo_formulario',$tipo_formulario);
        @$sentencia->bindParam(':tipo_atencion',$tipo_atencion);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getInfoFormulario($id_formulario){
        $sql="SELECT * FROM tb_nidos_formularios_atenciones_virtuales WHERE PK_Id_Formulario=:id_formulario";

        $sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_formulario',$id_formulario);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function guardarConfiguracionFormulario($objeto){
        $sql = "UPDATE tb_nidos_formularios_atenciones_virtuales SET IN_Estado=:estado, VC_Contenido_Cerrado=:contenido, DT_Fecha_Modificacion=:fecha WHERE PK_Id_Formulario=:id_formulario";
        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_formulario',$objeto->getPkIdFormulario());
        @$sentencia->bindParam(':estado',$objeto->getInEstado());
        @$sentencia->bindParam(':contenido',$objeto->getVcContenidoCerrado());
        @$sentencia->bindParam(':fecha',$objeto->getDtFechaModificacion());
        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function EditarInformacionLlamada($objeto){
        $sql = "UPDATE tb_nidos_atenciones_virtuales SET VC_Nombre_Cuidador = :nombre_cuidador, VC_Correo = :correo_cuidador, IN_Tipo_Doc_Cuidador = :tipo_doc_cuidador, IN_Identificacion_Cuidador = :identificacion_cuidador, IN_Localidad = :localidad_cuidador, VC_Barrio = :barrio_cuidador, VC_Direccion = :direccion_cuidador, IN_Estrato = :estrato_cuidador, VC_Edad_Cuidador = :edad_cuidador, IN_Parentesco = :parentesco, VC_Identificacion = :identificacion_beneficiario, FK_Tipo_Identificacion = :tipo_doc_beneficiario, VC_Nombres = :nombres_beneficiario, VC_Apellidos = :apellidos_beneficiario, DD_F_Nacimiento = :fecha_nacimiento_beneficiario, VC_Grupo_Poblacional = :enfoque_beneficiario, VC_Edad_Beneficiario = :edad_beneficiario WHERE Pk_Id_Registro = :id_registro";

        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_registro',$objeto->getPkIdRegistro());
        @$sentencia->bindParam(':tipo_doc_cuidador',$objeto->getInTipoDocCuidador());
        @$sentencia->bindParam(':identificacion_cuidador',$objeto->getInIdentificacionCuidador());
        @$sentencia->bindParam(':nombre_cuidador',$objeto->getVcNombreCuidador());
        @$sentencia->bindParam(':correo_cuidador',$objeto->getVcCorreo());
        @$sentencia->bindParam(':localidad_cuidador',$objeto->getInLocalidad());
        @$sentencia->bindParam(':barrio_cuidador',$objeto->getVcBarrio());
        @$sentencia->bindParam(':direccion_cuidador',$objeto->getVcDireccion());
        @$sentencia->bindParam(':estrato_cuidador',$objeto->getInEstrato());
        @$sentencia->bindParam(':edad_cuidador',$objeto->getVcEdadCuidador());
        @$sentencia->bindParam(':parentesco',$objeto->getInParentesco());
        @$sentencia->bindParam(':nombres_beneficiario',$objeto->getVcNombres());
        @$sentencia->bindParam(':apellidos_beneficiario',$objeto->getVcApellidos());
        @$sentencia->bindParam(':enfoque_beneficiario',$objeto->getVcGrupoPoblacional());
        @$sentencia->bindParam(':fecha_nacimiento_beneficiario',$objeto->getDdFNacimiento());
        @$sentencia->bindParam(':tipo_doc_beneficiario',$objeto->getFkTipoIdentificacion());
        @$sentencia->bindParam(':identificacion_beneficiario',$objeto->getVcIdentificacion());
        @$sentencia->bindParam(':edad_beneficiario',$objeto->getVcEdadBeneficiario());

        $sentencia->execute();
        return $sentencia->rowCount();
    }

    public function consultarTotalesAsignadas($mes,$usuario){
        $sql="SELECT COUNT(PK_Id_Registro) AS 'ASIGNADOS',
        (SELECT COUNT(PK_Id_Registro) 
        FROM tb_nidos_atenciones_virtuales AS AV
        JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        WHERE AV.IN_Quien_llama = '$usuario' AND  (HA.DT_Fecha_Atencion BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND AV.IN_Estado = 0) AS 'PENDIENTES',
        (SELECT COUNT(PK_Id_Registro)
        FROM tb_nidos_atenciones_virtuales AS AV
        JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        WHERE AV.IN_Quien_llama = '$usuario' AND  (HA.DT_Fecha_Atencion BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND AV.IN_Estado = 1) AS 'REALIZADAS',
        (SELECT COUNT(PK_Id_Registro)
        FROM tb_nidos_atenciones_virtuales AS AV
        JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        WHERE AV.IN_Quien_llama = '$usuario' AND  (HA.DT_Fecha_Atencion BETWEEN '2021-$mes-01' AND '2021-$mes-31') AND AV.IN_Estado = 2) AS 'NOCONTESTADAS'
        FROM tb_nidos_atenciones_virtuales AS AV
        JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        WHERE AV.IN_Quien_llama = '$usuario' AND  (HA.DT_Fecha_Atencion BETWEEN '2021-$mes-01' AND '2021-$mes-31')";
        $sentencia=$this->dbPDO->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultarAtencionesAsignadas($mes, $usuario){
        $sql="SELECT
        AV.Pk_Id_Registro AS 'ID_REGISTRO',
        LA.id AS 'ID_ASIGNACION',
        AV.IN_Tipo_Doc_Cuidador AS 'TIPO_DOC_CUIDADOR',
        AV.IN_Identificacion_Cuidador AS 'DOCUMENTO_CUIDADOR',
        IF(
        (AV.VC_Primer_Nombre_Cuidador IS NULL AND AV.VC_Primer_Apellido_Cuidador IS NULL), 'No suministrado', CONCAT_WS(' ', AV.VC_Primer_Nombre_Cuidador, ' ', AV.VC_Primer_Apellido_Cuidador)
        ) AS 'NOMBRE_CUIDADOR',
        AV.VC_Correo AS 'CORREO_CUIDADOR',
        AV.IN_Localidad AS 'LOCALIDAD_CUIDADOR',
        AV.VC_Barrio AS 'BARRIO_CUIDADOR',
        AV.VC_Direccion AS 'DIRECCION_CUIDADOR',
        AV.VC_Edad_Cuidador AS 'EDAD_CUIDADOR',
        AV.IN_Estrato AS 'ESTRATO_CUIDADOR',
        AV.IN_Dirigida_Atencion AS 'ID_DIRIGIDA',
        AV.IN_Parentesco AS 'ID_PARENTESCO',
        AV.IN_Potestad AS 'ID_POTESTAD',
        (CASE WHEN AV.IN_Dirigida_Atencion = '1' THEN 'MUJER GESTANTE' WHEN AV.IN_Dirigida_Atencion = '2' THEN 'NIÑO' WHEN AV.IN_Dirigida_Atencion = '3' THEN 'NIÑA' END) AS 'DIRIGIDA',
        (CASE WHEN AV.IN_Potestad = '1' THEN 'SI' WHEN AV.IN_Potestad = '0' THEN 'NO' END) AS 'POTESTAD',
        AV.FK_Tipo_Identificacion AS 'TIPO_DOC_BENEFICIARIO',
        AV.VC_Identificacion AS 'NUMERO_DOC_BENEFICIARIO', 
        IF(
        (AV.VC_Primer_Nombre_Beneficiario IS NULL AND AV.VC_Segundo_Nombre_Beneficiario IS NULL AND AV.VC_Primer_Apellido_beneficiario IS NULL AND AV.VC_Segundo_Apellido_Beneficiario IS NULL), 'No suministrado', CONCAT_WS(' ', AV.VC_Primer_Nombre_Beneficiario, AV.VC_Segundo_Nombre_Beneficiario, AV.VC_Primer_Apellido_beneficiario, AV.VC_Segundo_Apellido_Beneficiario)
        ) AS 'NOMBRE_BENEFICIARIO',
        COALESCE(PDE.VC_Descripcion, 'Sin enfoque') AS 'ENFOQUE_BENEFICIARIO',
        AV.DD_F_Nacimiento AS 'FECHA_NACIMIENTO_BENEFICIARIO',
        AV.VC_Edad_Beneficiario AS 'EDAD_BENEFICIARIO',
        AV.VC_Telefono AS 'TELEFONO_LLAMADA',
        (CASE WHEN AV.IN_Tipo_Atencion = '1' THEN 'CUENTO Y POESÍA' WHEN AV.IN_Tipo_Atencion = '2' THEN 'CANTO' ELSE 'No aplica' END) AS 'ATENCION',
        AV.IN_Horario_Llamada AS 'HORARIO',
        LA.fecha_llamada AS 'FECHA_CALCULO',
        COALESCE(AV.VC_Condicion_Salud, 'No aplica') AS 'CONDICION_SALUD',
        COALESCE(AV.VC_Dificultad_Movilidad_Fisica, 'No aplica') AS 'DIFICULTAD_MOVILIDAD',
        -- HA.DT_Fecha_Atencion AS 'FECHA_CALCULO',
        DATE_FORMAT(HA.DT_Fecha_Atencion, '%d/%m/%Y') AS 'FECHA_LLAMADA_MOSTRAR_CON_HORARIO', 
        HA.DT_Fecha_Atencion AS 'FECHA_LLAMADA',
        HA.VC_Hora_Inicio AS 'INICIO_LLAMADA',
        HA.VC_Hora_Fin AS 'FIN_LLAMADA',
        AV.VC_Comentarios AS 'COMENTARIOS',
        LA.quien_llama AS 'ARTISTA',
        -- AV.IN_Quien_Llama AS 'ARTISTA',
        CONCAT(PE.VC_Primer_Nombre,' ',PE.VC_Segundo_Nombre,' ',PE.VC_Primer_Apellido,' ',PE.VC_Segundo_Apellido ) AS 'NOMBREARTISTA',
        CASE WHEN (L.duracion_llamada = '' || L.duracion_llamada IS NULL) THEN 'Llamada no contestada' ELSE L.duracion_llamada END AS 'DURACION',
        CASE WHEN (L.material_narrado = '' || L.material_narrado IS NULL) THEN 'Llamada no contestada' ELSE L.material_narrado END AS 'MATERIAL',
        CASE WHEN (L.parecio_lectura ='' || L.parecio_lectura IS NULL) THEN 'Llamada no contestada' ELSE L.parecio_lectura END AS 'PARECIO',
        CASE WHEN (L.reaccion='' || L.reaccion IS NULL) THEN 'Llamada no contestada' ELSE L.reaccion END AS 'REACCION',
        CASE WHEN (L.observaciones='' || L.observaciones IS NULL) THEN 'Llamada no contestada' ELSE L.observaciones END AS 'OBSERVACIONES',
        (CASE WHEN AV.VC_Autorizacion = '0' THEN 'No' ELSE 'Si' END) AS 'AUTORIZACION',
        LA.llamada_realizada AS 'ESTADO_LLAMADA',
        DATE_FORMAT(LA.fecha_llamada, '%d/%m/%Y') AS 'FECHA_LLAMADA_MOSTRAR_SIN_HORARIO',
        LA.fecha_llamada AS 'FECHA_LLAMADA_SIN_HORARIO',
        CASE
        WHEN AV.IN_Formulario = '1' THEN 'Comunidad'
        WHEN AV.IN_Formulario = '2' THEN 'Institucional 1 y 3'
        WHEN AV.IN_Formulario = '3' THEN 'Institucional 2 y 4'
        WHEN AV.IN_Formulario = '4' THEN 'Arn'
        WHEN AV.IN_Formulario = '5' THEN 'Aulas hospitalarias'
        END AS 'FORMULARIO'   
        FROM tb_nidos_llamadas_asignacion LA
        JOIN tb_nidos_atenciones_virtuales AV ON AV.Pk_Id_Registro=LA.fk_atencion_virtual
        LEFT JOIN tb_nidos_llamadas L ON L.fk_atencion_virtual = LA.fk_atencion_virtual AND L.quien_llamo=LA.quien_llama AND L.fecha_llamada BETWEEN '2021-$mes-01' AND '2021-$mes-31'
        LEFT JOIN tb_nidos_horarios_atencion AS HA ON HA.Pk_Id_Horario = AV.IN_Horario_Llamada
        LEFT JOIN tb_parametro_detalle PDE ON PDE.FK_Value=AV.VC_Grupo_Poblacional AND PDE.FK_Id_Parametro=14 AND PDE.IN_Estado=1
        LEFT JOIN tb_persona_2017 AS PE ON AV.IN_Quien_Llama = PE.PK_Id_Persona
        WHERE LA.quien_llama=:id_usuario AND LA.fecha_llamada BETWEEN '2021-$mes-01' AND '2021-$mes-31'";

        @$sentencia=$this->dbPDO->prepare($sql);
        @$sentencia->bindParam(':id_usuario', $usuario);
        $sentencia->execute();

        return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
    }

}
