<?php

namespace  General\Persistencia\Entidades;


class TbNidosAtencionesVirtuales{

    private $pk_id_registro;
    private $vc_primer_nombre_cuidador;
    private $vc_segundo_nombre_cuidador;
    private $vc_primer_apellido_cuidador;
    private $vc_segundo_apellido_cuidador;
    private $vc_correo;
    private $in_tipo_doc_cuidador;
    private $in_identificacion_cuidador;
    private $in_localidad;
    private $in_upz;
    private $vc_otro_lugar;
    private $vc_barrio;
    private $vc_direccion;
    private $in_estrato;
    private $vc_edad_cuidador;
    private $in_dirigida_atencion;
    private $in_parentesco;
    private $vc_otro_parentesco;
    private $in_potestad;
    private $vc_identificacion;
    private $fk_tipo_identificacion;
    private $vc_primer_nombre_beneficiario;
    private $vc_segundo_nombre_beneficiario;
    private $vc_primer_apellido_beneficiario;
    private $vc_segundo_apellido_beneficiario;
    private $dd_f_nacimiento;
    private $vc_grupo_poblacional;
    private $vc_edad_beneficiario;
    private $vc_institucion;
    private $vc_entidad;
    private $vc_telefono;
    private $in_tipo_atencion;
    private $in_horario_llamada;
    private $vc_comentarios;
    private $vc_autorizacion;
    private $vc_condicion_salud;
    private $vc_dificultad_movilidad_fisica;
    private $vc_discapacidad_disminucion_sentidos;
    private $vc_hospitalizado;
    private $vc_recuperacion;
    private $vc_computador_wifi;
    private $in_edad_mental;
    private $vc_gustaria_escuchar;
    private $vc_temas_lectura_libro_viento;
    private $vc_otros_temas_lectura_libro_viento;
    private $dd_fecha_solicitud;
    private $in_formulario;
    private $in_quien_llama;
    private $vc_duracion_llamada;
    private $vc_material_narrado;
    private $vc_parecio_lectura;
    private $vc_reacciono_hijo;
    private $vc_observaciones;
    private $in_estado;
    private $vc_whatsapp;
    private $dt_fecha_llamada;


    /**
     * @return mixed
     */
    public function getPkIdRegistro()
    {
        return $this->pk_id_registro;
    }

    /**
     * @param mixed $pk_id_registro
     *
     * @return self
     */
    public function setPkIdRegistro($pk_id_registro)
    {
        $this->pk_id_registro = $pk_id_registro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPrimerNombreCuidador()
    {
        return $this->vc_primer_nombre_cuidador;
    }

    /**
     * @param mixed $vc_primer_nombre_cuidador
     *
     * @return self
     */
    public function setVcPrimerNombreCuidador($vc_primer_nombre_cuidador)
    {
        $this->vc_primer_nombre_cuidador = $vc_primer_nombre_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcSegundoNombreCuidador()
    {
        return $this->vc_segundo_nombre_cuidador;
    }

    /**
     * @param mixed $vc_segundo_nombre_cuidador
     *
     * @return self
     */
    public function setVcSegundoNombreCuidador($vc_segundo_nombre_cuidador)
    {
        $this->vc_segundo_nombre_cuidador = $vc_segundo_nombre_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPrimerApellidoCuidador()
    {
        return $this->vc_primer_apellido_cuidador;
    }

    /**
     * @param mixed $vc_primer_apellido_cuidador
     *
     * @return self
     */
    public function setVcPrimerApellidoCuidador($vc_primer_apellido_cuidador)
    {
        $this->vc_primer_apellido_cuidador = $vc_primer_apellido_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcSegundoApellidoCuidador()
    {
        return $this->vc_segundo_apellido_cuidador;
    }

    /**
     * @param mixed $vc_segundo_apellido_cuidador
     *
     * @return self
     */
    public function setVcSegundoApellidoCuidador($vc_segundo_apellido_cuidador)
    {
        $this->vc_segundo_apellido_cuidador = $vc_segundo_apellido_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcCorreo()
    {
        return $this->vc_correo;
    }

    /**
     * @param mixed $vc_correo
     *
     * @return self
     */
    public function setVcCorreo($vc_correo)
    {
        $this->vc_correo = $vc_correo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTipoDocCuidador()
    {
        return $this->in_tipo_doc_cuidador;
    }

    /**
     * @param mixed $in_tipo_doc_cuidador
     *
     * @return self
     */
    public function setInTipoDocCuidador($in_tipo_doc_cuidador)
    {
        $this->in_tipo_doc_cuidador = $in_tipo_doc_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInIdentificacionCuidador()
    {
        return $this->in_identificacion_cuidador;
    }

    /**
     * @param mixed $in_identificacion_cuidador
     *
     * @return self
     */
    public function setInIdentificacionCuidador($in_identificacion_cuidador)
    {
        $this->in_identificacion_cuidador = $in_identificacion_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInLocalidad()
    {
        return $this->in_localidad;
    }

    /**
     * @param mixed $in_localidad
     *
     * @return self
     */
    public function setInLocalidad($in_localidad)
    {
        $this->in_localidad = $in_localidad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInUpz()
    {
        return $this->in_upz;
    }

    /**
     * @param mixed $in_upz
     *
     * @return self
     */
    public function setInUpz($in_upz)
    {
        $this->in_upz = $in_upz;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcOtroLugar()
    {
        return $this->vc_otro_lugar;
    }

    /**
     * @param mixed $vc_otro_lugar
     *
     * @return self
     */
    public function setVcOtroLugar($vc_otro_lugar)
    {
        $this->vc_otro_lugar = $vc_otro_lugar;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcBarrio()
    {
        return $this->vc_barrio;
    }

    /**
     * @param mixed $vc_barrio
     *
     * @return self
     */
    public function setVcBarrio($vc_barrio)
    {
        $this->vc_barrio = $vc_barrio;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDireccion()
    {
        return $this->vc_direccion;
    }

    /**
     * @param mixed $vc_direccion
     *
     * @return self
     */
    public function setVcDireccion($vc_direccion)
    {
        $this->vc_direccion = $vc_direccion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInEstrato()
    {
        return $this->in_estrato;
    }

    /**
     * @param mixed $in_estrato
     *
     * @return self
     */
    public function setInEstrato($in_estrato)
    {
        $this->in_estrato = $in_estrato;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcEdadCuidador()
    {
        return $this->vc_edad_cuidador;
    }

    /**
     * @param mixed $vc_edad_cuidador
     *
     * @return self
     */
    public function setVcEdadCuidador($vc_edad_cuidador)
    {
        $this->vc_edad_cuidador = $vc_edad_cuidador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInDirigidaAtencion()
    {
        return $this->in_dirigida_atencion;
    }

    /**
     * @param mixed $in_dirigida_atencion
     *
     * @return self
     */
    public function setInDirigidaAtencion($in_dirigida_atencion)
    {
        $this->in_dirigida_atencion = $in_dirigida_atencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInParentesco()
    {
        return $this->in_parentesco;
    }

    /**
     * @param mixed $in_parentesco
     *
     * @return self
     */
    public function setInParentesco($in_parentesco)
    {
        $this->in_parentesco = $in_parentesco;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcOtroParentesco()
    {
        return $this->vc_otro_parentesco;
    }

    /**
     * @param mixed $vc_otro_parentesco
     *
     * @return self
     */
    public function setVcOtroParentesco($vc_otro_parentesco)
    {
        $this->vc_otro_parentesco = $vc_otro_parentesco;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInPotestad()
    {
        return $this->in_potestad;
    }

    /**
     * @param mixed $in_potestad
     *
     * @return self
     */
    public function setInPotestad($in_potestad)
    {
        $this->in_potestad = $in_potestad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcIdentificacion()
    {
        return $this->vc_identificacion;
    }

    /**
     * @param mixed $vc_identificacion
     *
     * @return self
     */
    public function setVcIdentificacion($vc_identificacion)
    {
        $this->vc_identificacion = $vc_identificacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkTipoIdentificacion()
    {
        return $this->fk_tipo_identificacion;
    }

    /**
     * @param mixed $fk_tipo_identificacion
     *
     * @return self
     */
    public function setFkTipoIdentificacion($fk_tipo_identificacion)
    {
        $this->fk_tipo_identificacion = $fk_tipo_identificacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPrimerNombreBeneficiario()
    {
        return $this->vc_primer_nombre_beneficiario;
    }

    /**
     * @param mixed $vc_primer_nombre_beneficiario
     *
     * @return self
     */
    public function setVcPrimerNombreBeneficiario($vc_primer_nombre_beneficiario)
    {
        $this->vc_primer_nombre_beneficiario = $vc_primer_nombre_beneficiario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcSegundoNombreBeneficiario()
    {
        return $this->vc_segundo_nombre_beneficiario;
    }

    /**
     * @param mixed $vc_segundo_nombre_beneficiario
     *
     * @return self
     */
    public function setVcSegundoNombreBeneficiario($vc_segundo_nombre_beneficiario)
    {
        $this->vc_segundo_nombre_beneficiario = $vc_segundo_nombre_beneficiario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcPrimerApellidoBeneficiario()
    {
        return $this->vc_primer_apellido_beneficiario;
    }

    /**
     * @param mixed $vc_primer_apellido_beneficiario
     *
     * @return self
     */
    public function setVcPrimerApellidoBeneficiario($vc_primer_apellido_beneficiario)
    {
        $this->vc_primer_apellido_beneficiario = $vc_primer_apellido_beneficiario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcSegundoApellidoBeneficiario()
    {
        return $this->vc_segundo_apellido_beneficiario;
    }

    /**
     * @param mixed $vc_segundo_apellido_beneficiario
     *
     * @return self
     */
    public function setVcSegundoApellidoBeneficiario($vc_segundo_apellido_beneficiario)
    {
        $this->vc_segundo_apellido_beneficiario = $vc_segundo_apellido_beneficiario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDdFNacimiento()
    {
        return $this->dd_f_nacimiento;
    }

    /**
     * @param mixed $dd_f_nacimiento
     *
     * @return self
     */
    public function setDdFNacimiento($dd_f_nacimiento)
    {
        $this->dd_f_nacimiento = $dd_f_nacimiento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcGrupoPoblacional()
    {
        return $this->vc_grupo_poblacional;
    }

    /**
     * @param mixed $vc_grupo_poblacional
     *
     * @return self
     */
    public function setVcGrupoPoblacional($vc_grupo_poblacional)
    {
        $this->vc_grupo_poblacional = $vc_grupo_poblacional;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcEdadBeneficiario()
    {
        return $this->vc_edad_beneficiario;
    }

    /**
     * @param mixed $vc_edad_beneficiario
     *
     * @return self
     */
    public function setVcEdadBeneficiario($vc_edad_beneficiario)
    {
        $this->vc_edad_beneficiario = $vc_edad_beneficiario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcInstitucion()
    {
        return $this->vc_institucion;
    }

    /**
     * @param mixed $vc_institucion
     *
     * @return self
     */
    public function setVcInstitucion($vc_institucion)
    {
        $this->vc_institucion = $vc_institucion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcEntidad()
    {
        return $this->vc_entidad;
    }

    /**
     * @param mixed $vc_entidad
     *
     * @return self
     */
    public function setVcEntidad($vc_entidad)
    {
        $this->vc_entidad = $vc_entidad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcTelefono()
    {
        return $this->vc_telefono;
    }

    /**
     * @param mixed $vc_telefono
     *
     * @return self
     */
    public function setVcTelefono($vc_telefono)
    {
        $this->vc_telefono = $vc_telefono;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTipoAtencion()
    {
        return $this->in_tipo_atencion;
    }

    /**
     * @param mixed $in_tipo_atencion
     *
     * @return self
     */
    public function setInTipoAtencion($in_tipo_atencion)
    {
        $this->in_tipo_atencion = $in_tipo_atencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInHorarioLlamada()
    {
        return $this->in_horario_llamada;
    }

    /**
     * @param mixed $in_horario_llamada
     *
     * @return self
     */
    public function setInHorarioLlamada($in_horario_llamada)
    {
        $this->in_horario_llamada = $in_horario_llamada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcComentarios()
    {
        return $this->vc_comentarios;
    }

    /**
     * @param mixed $vc_comentarios
     *
     * @return self
     */
    public function setVcComentarios($vc_comentarios)
    {
        $this->vc_comentarios = $vc_comentarios;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcAutorizacion()
    {
        return $this->vc_autorizacion;
    }

    /**
     * @param mixed $vc_autorizacion
     *
     * @return self
     */
    public function setVcAutorizacion($vc_autorizacion)
    {
        $this->vc_autorizacion = $vc_autorizacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcCondicionSalud()
    {
        return $this->vc_condicion_salud;
    }

    /**
     * @param mixed $vc_condicion_salud
     *
     * @return self
     */
    public function setVcCondicionSalud($vc_condicion_salud)
    {
        $this->vc_condicion_salud = $vc_condicion_salud;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDificultadMovilidadFisica()
    {
        return $this->vc_dificultad_movilidad_fisica;
    }

    /**
     * @param mixed $vc_dificultad_movilidad_fisica
     *
     * @return self
     */
    public function setVcDificultadMovilidadFisica($vc_dificultad_movilidad_fisica)
    {
        $this->vc_dificultad_movilidad_fisica = $vc_dificultad_movilidad_fisica;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDiscapacidadDisminucionSentidos()
    {
        return $this->vc_discapacidad_disminucion_sentidos;
    }

    /**
     * @param mixed $vc_discapacidad_disminucion_sentidos
     *
     * @return self
     */
    public function setVcDiscapacidadDisminucionSentidos($vc_discapacidad_disminucion_sentidos)
    {
        $this->vc_discapacidad_disminucion_sentidos = $vc_discapacidad_disminucion_sentidos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcHospitalizado()
    {
        return $this->vc_hospitalizado;
    }

    /**
     * @param mixed $vc_hospitalizado
     *
     * @return self
     */
    public function setVcHospitalizado($vc_hospitalizado)
    {
        $this->vc_hospitalizado = $vc_hospitalizado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcRecuperacion()
    {
        return $this->vc_recuperacion;
    }

    /**
     * @param mixed $vc_recuperacion
     *
     * @return self
     */
    public function setVcRecuperacion($vc_recuperacion)
    {
        $this->vc_recuperacion = $vc_recuperacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcComputadorWifi()
    {
        return $this->vc_computador_wifi;
    }

    /**
     * @param mixed $vc_computador_wifi
     *
     * @return self
     */
    public function setVcComputadorWifi($vc_computador_wifi)
    {
        $this->vc_computador_wifi = $vc_computador_wifi;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInEdadMental()
    {
        return $this->in_edad_mental;
    }

    /**
     * @param mixed $in_edad_mental
     *
     * @return self
     */
    public function setInEdadMental($in_edad_mental)
    {
        $this->in_edad_mental = $in_edad_mental;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcGustariaEscuchar()
    {
        return $this->vc_gustaria_escuchar;
    }

    /**
     * @param mixed $vc_gustaria_escuchar
     *
     * @return self
     */
    public function setVcGustariaEscuchar($vc_gustaria_escuchar)
    {
        $this->vc_gustaria_escuchar = $vc_gustaria_escuchar;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcTemasLecturaLibroViento()
    {
        return $this->vc_temas_lectura_libro_viento;
    }

    /**
     * @param mixed $vc_temas_lectura_libro_viento
     *
     * @return self
     */
    public function setVcTemasLecturaLibroViento($vc_temas_lectura_libro_viento)
    {
        $this->vc_temas_lectura_libro_viento = $vc_temas_lectura_libro_viento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcOtrosTemasLecturaLibroViento()
    {
        return $this->vc_otros_temas_lectura_libro_viento;
    }

    /**
     * @param mixed $vc_otros_temas_lectura_libro_viento
     *
     * @return self
     */
    public function setVcOtrosTemasLecturaLibroViento($vc_otros_temas_lectura_libro_viento)
    {
        $this->vc_otros_temas_lectura_libro_viento = $vc_otros_temas_lectura_libro_viento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDdFechaSolicitud()
    {
        return $this->dd_fecha_solicitud;
    }

    /**
     * @param mixed $dd_fecha_solicitud
     *
     * @return self
     */
    public function setDdFechaSolicitud($dd_fecha_solicitud)
    {
        $this->dd_fecha_solicitud = $dd_fecha_solicitud;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInFormulario()
    {
        return $this->in_formulario;
    }

    /**
     * @param mixed $in_formulario
     *
     * @return self
     */
    public function setInFormulario($in_formulario)
    {
        $this->in_formulario = $in_formulario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInQuienLlama()
    {
        return $this->in_quien_llama;
    }

    /**
     * @param mixed $in_quien_llama
     *
     * @return self
     */
    public function setInQuienLlama($in_quien_llama)
    {
        $this->in_quien_llama = $in_quien_llama;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDuracionLlamada()
    {
        return $this->vc_duracion_llamada;
    }

    /**
     * @param mixed $vc_duracion_llamada
     *
     * @return self
     */
    public function setVcDuracionLlamada($vc_duracion_llamada)
    {
        $this->vc_duracion_llamada = $vc_duracion_llamada;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcMaterialNarrado()
    {
        return $this->vc_material_narrado;
    }

    /**
     * @param mixed $vc_material_narrado
     *
     * @return self
     */
    public function setVcMaterialNarrado($vc_material_narrado)
    {
        $this->vc_material_narrado = $vc_material_narrado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcParecioLectura()
    {
        return $this->vc_parecio_lectura;
    }

    /**
     * @param mixed $vc_parecio_lectura
     *
     * @return self
     */
    public function setVcParecioLectura($vc_parecio_lectura)
    {
        $this->vc_parecio_lectura = $vc_parecio_lectura;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcReaccionoHijo()
    {
        return $this->vc_reacciono_hijo;
    }

    /**
     * @param mixed $vc_reacciono_hijo
     *
     * @return self
     */
    public function setVcReaccionoHijo($vc_reacciono_hijo)
    {
        $this->vc_reacciono_hijo = $vc_reacciono_hijo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcObservaciones()
    {
        return $this->vc_observaciones;
    }

    /**
     * @param mixed $vc_observaciones
     *
     * @return self
     */
    public function setVcObservaciones($vc_observaciones)
    {
        $this->vc_observaciones = $vc_observaciones;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInEstado()
    {
        return $this->in_estado;
    }

    /**
     * @param mixed $in_estado
     *
     * @return self
     */
    public function setInEstado($in_estado)
    {
        $this->in_estado = $in_estado;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcWhatsapp()
    {
        return $this->vc_whatsapp;
    }

    /**
     * @param mixed $vc_whatsapp
     *
     * @return self
     */
    public function setVcWhatsapp($vc_whatsapp)
    {
        $this->vc_whatsapp = $vc_whatsapp;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaLlamada()
    {
        return $this->dt_fecha_llamada;
    }

    /**
     * @param mixed $dt_fecha_llamada
     *
     * @return self
     */
    public function setDtFechaLlamada($dt_fecha_llamada)
    {
        $this->dt_fecha_llamada = $dt_fecha_llamada;

        return $this;
    }
}