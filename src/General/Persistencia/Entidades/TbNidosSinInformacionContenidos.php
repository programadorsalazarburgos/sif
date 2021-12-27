<?php

namespace  General\Persistencia\Entidades;


class TbNidosSinInformacionContenidos{

    private $pk_id_registro_contenido;
    private $in_total_beneficiarios;
    private $in_total_ninos;
    private $in_total_ninas;
    private $in_total_ninos_0_3;
    private $in_total_ninos_3_6;
    private $in_total_ninos_6;
    private $in_total_ninas_0_3;
    private $in_total_ninas_3_6;
    private $in_total_ninas_6;
    private $in_mujeres_gestantes;
    private $in_afrodescendiente;
    private $in_campesina;
    private $in_discapacidad;
    private $in_conflicto;
    private $in_indigena;
    private $in_privados;
    private $in_victimas;
    private $in_raizal;
    private $in_rom;
    private $in_discapacidad_7_10;
    private $fk_id_lugar_atencion;
    private $fk_id_grupo;
    private $vc_contenido;
    private $dt_fecha_entrega;
    private $vc_documento_soporte;
    private $fk_id_usuario_registro;
    private $dt_fecha_registro;

    private $fk_id_experiencia;
    private $in_componente;
    private $in_total_beneficiarios_nuevos;
    private $in_total_ninos_nuevos;
    private $in_total_ninas_nuevos;
    private $in_total_ninos_0_3_nuevos;
    private $in_total_ninos_3_6_nuevos;
    private $in_total_ninos_6_nuevos;
    private $in_Total_Ninas_0_3_nuevos;    
    private $in_Total_Ninas_3_6_nuevos;
    private $in_total_ninas_6_nuevos;
    private $in_mujeres_gestantes_nuevos;
    private $in_afrodescendiente_nuevo;
    private $in_campesina_nuevo;
    private $in_discapacidad_nuevo;
    private $in_conflicto_nuevo;
    private $in_indigena_nuevo;
    private $in_privados_nuevo;
    private $in_victimas_nuevo;
    private $in_raizal_nuevo;
    private $in_rom_nuevo;
    private $in_discapacidad_7_10_nuevo;

    /**
     * @return mixed
     */
    public function getPkIdRegistroContenido()
    {
        return $this->pk_id_registro_contenido;
    }

    /**
     * @param mixed $pk_id_registro_contenido
     *
     * @return self
     */
    public function setPkIdRegistroContenido($pk_id_registro_contenido)
    {
        $this->pk_id_registro_contenido = $pk_id_registro_contenido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalBeneficiarios()
    {
        return $this->in_total_beneficiarios;
    }

    /**
     * @param mixed $in_total_beneficiarios
     *
     * @return self
     */
    public function setInTotalBeneficiarios($in_total_beneficiarios)
    {
        $this->in_total_beneficiarios = $in_total_beneficiarios;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalNinos()
    {
        return $this->in_total_ninos;
    }

    /**
     * @param mixed $in_total_ninos
     *
     * @return self
     */
    public function setInTotalNinos($in_total_ninos)
    {
        $this->in_total_ninos = $in_total_ninos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalNinas()
    {
        return $this->in_total_ninas;
    }

    /**
     * @param mixed $in_total_ninas
     *
     * @return self
     */
    public function setInTotalNinas($in_total_ninas)
    {
        $this->in_total_ninas = $in_total_ninas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalNinos03()
    {
        return $this->in_total_ninos_0_3;
    }

    /**
     * @param mixed $in_total_ninos_0_3
     *
     * @return self
     */
    public function setInTotalNinos03($in_total_ninos_0_3)
    {
        $this->in_total_ninos_0_3 = $in_total_ninos_0_3;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalNinos36()
    {
        return $this->in_total_ninos_3_6;
    }

    /**
     * @param mixed $in_total_ninos_3_6
     *
     * @return self
     */
    public function setInTotalNinos36($in_total_ninos_3_6)
    {
        $this->in_total_ninos_3_6 = $in_total_ninos_3_6;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getInTotalNinos6()
    {
        return $this->in_total_ninos_6;
    }

    /**
     * @param mixed $in_total_ninos_6
     *
     * @return self
     */
    public function setInTotalNinos6($in_total_ninos_6)
    {
        $this->in_total_ninos_6 = $in_total_ninos_6;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalNinas03()
    {
        return $this->in_total_ninas_0_3;
    }

    /**
     * @param mixed $in_total_ninas_0_3
     *
     * @return self
     */
    public function setInTotalNinas03($in_total_ninas_0_3)
    {
        $this->in_total_ninas_0_3 = $in_total_ninas_0_3;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInTotalNinas36()
    {
        return $this->in_total_ninas_3_6;
    }

    /**
     * @param mixed $in_total_ninas_3_6
     *
     * @return self
     */
    public function setInTotalNinas36($in_total_ninas_3_6)
    {
        $this->in_total_ninas_3_6 = $in_total_ninas_3_6;

        return $this;
    }

        /**
     * @return mixed
     */
    public function getInTotalNinas6()
    {
        return $this->in_total_ninas_6;
    }

    /**
     * @param mixed $in_total_ninas_6
     *
     * @return self
     */
    public function setInTotalNinas6($in_total_ninas_6)
    {
        $this->in_total_ninas_6 = $in_total_ninas_6;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInMujeresGestantes()
    {
        return $this->in_mujeres_gestantes;
    }

    /**
     * @param mixed $in_mujeres_gestantes
     *
     * @return self
     */
    public function setInMujeresGestantes($in_mujeres_gestantes)
    {
        $this->in_mujeres_gestantes = $in_mujeres_gestantes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInAfrodescendiente()
    {
        return $this->in_afrodescendiente;
    }

    /**
     * @param mixed $in_afrodescendiente
     *
     * @return self
     */
    public function setInAfrodescendiente($in_afrodescendiente)
    {
        $this->in_afrodescendiente = $in_afrodescendiente;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInCampesina()
    {
        return $this->in_campesina;
    }

    /**
     * @param mixed $in_campesina
     *
     * @return self
     */
    public function setInCampesina($in_campesina)
    {
        $this->in_campesina = $in_campesina;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInDiscapacidad()
    {
        return $this->in_discapacidad;
    }

    /**
     * @param mixed $in_discapacidad
     *
     * @return self
     */
    public function setInDiscapacidad($in_discapacidad)
    {
        $this->in_discapacidad = $in_discapacidad;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInConflicto()
    {
        return $this->in_conflicto;
    }

    /**
     * @param mixed $in_conflicto
     *
     * @return self
     */
    public function setInConflicto($in_conflicto)
    {
        $this->in_conflicto = $in_conflicto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInIndigena()
    {
        return $this->in_indigena;
    }

    /**
     * @param mixed $in_indigena
     *
     * @return self
     */
    public function setInIndigena($in_indigena)
    {
        $this->in_indigena = $in_indigena;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInPrivados()
    {
        return $this->in_privados;
    }

    /**
     * @param mixed $in_privados
     *
     * @return self
     */
    public function setInPrivados($in_privados)
    {
        $this->in_privados = $in_privados;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInVictimas()
    {
        return $this->in_victimas;
    }

    /**
     * @param mixed $in_victimas
     *
     * @return self
     */
    public function setInVictimas($in_victimas)
    {
        $this->in_victimas = $in_victimas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInRaizal()
    {
        return $this->in_raizal;
    }

    /**
     * @param mixed $in_raizal
     *
     * @return self
     */
    public function setInRaizal($in_raizal)
    {
        $this->in_raizal = $in_raizal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInRom()
    {
        return $this->in_rom;
    }

    /**
     * @param mixed $in_rom
     *
     * @return self
     */
    public function setInRom($in_rom)
    {
        $this->in_rom = $in_rom;

        return $this;
    }

        /**
     * @return mixed
     */
    public function getInDiscapacidad710()
    {
        return $this->in_discapacidad_7_10;
    }

    /**
     * @param mixed $in_discapacidad_7_10
     *
     * @return self
     */
    public function setInDiscapacidad710($in_discapacidad_7_10)
    {
        $this->in_discapacidad_7_10 = $in_discapacidad_7_10;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdLugarAtencion()
    {
        return $this->fk_id_lugar_atencion;
    }

    /**
     * @param mixed $fk_id_lugar_atencion
     *
     * @return self
     */
    public function setFkIdLugarAtencion($fk_id_lugar_atencion)
    {
        $this->fk_id_lugar_atencion = $fk_id_lugar_atencion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdGrupo()
    {
        return $this->fk_id_grupo;
    }

    /**
     * @param mixed $fk_id_grupo
     *
     * @return self
     */
    public function setFkIdGrupo($fk_id_grupo)
    {
        $this->fk_id_grupo = $fk_id_grupo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcContenido()
    {
        return $this->vc_contenido;
    }

    /**
     * @param mixed $vc_contenido
     *
     * @return self
     */
    public function setVcContenido($vc_contenido)
    {
        $this->vc_contenido = $vc_contenido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaEntrega()
    {
        return $this->dt_fecha_entrega;
    }

    /**
     * @param mixed $dt_fecha_entrega
     *
     * @return self
     */
    public function setDtFechaEntrega($dt_fecha_entrega)
    {
        $this->dt_fecha_entrega = $dt_fecha_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVcDocumentoSoporte()
    {
        return $this->vc_documento_soporte;
    }

    /**
     * @param mixed $vc_documento_soporte
     *
     * @return self
     */
    public function setVcDocumentoSoporte($vc_documento_soporte)
    {
        $this->vc_documento_soporte = $vc_documento_soporte;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdUsuarioRegistro()
    {
        return $this->fk_id_usuario_registro;
    }

    /**
     * @param mixed $fk_id_usuario_registro
     *
     * @return self
     */
    public function setFkIdUsuarioRegistro($fk_id_usuario_registro)
    {
        $this->fk_id_usuario_registro = $fk_id_usuario_registro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFechaRegistro()
    {
        return $this->dt_fecha_registro;
    }

    /**
     * @param mixed $dt_fecha_registro
     *
     * @return self
     */
    public function setDtFechaRegistro($dt_fecha_registro)
    {
        $this->dt_fecha_registro = $dt_fecha_registro;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFkIdExperiencia()
    {
        return $this->fk_id_experiencia;
    }

    /**
     * @param mixed $fk_id_experiencia
     *
     * @return self
     */
    public function setFkIdExperiencia($fk_id_experiencia)
    {
        $this->fk_id_experiencia = $fk_id_experiencia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINComponente()
    {
        return $this->in_componente;
    }

    /**
     * @param mixed $in_componente
     *
     * @return self
     */
    public function setINComponente($in_componente)
    {
        $this->in_componente = $in_componente;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINTotalBeneficiariosNuevos()
    {
        return $this->in_total_beneficiarios_nuevos;
    }

    /**
     * @param mixed $in_total_beneficiarios_nuevos
     *
     * @return self
     */
    public function setINTotalBeneficiariosNuevos($in_total_beneficiarios_nuevos)
    {
        $this->in_total_beneficiarios_nuevos = $in_total_beneficiarios_nuevos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINTotalNinosNuevos()
    {
        return $this->in_total_ninos_nuevos;
    }

    /**
     * @param mixed $in_total_ninos_nuevos
     *
     * @return self
     */
    public function setINTotalNinosNuevos($in_total_ninos_nuevos)
    {
        $this->in_total_ninos_nuevos = $in_total_ninos_nuevos;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getINTotalNinasNuevos()
    {
        return $this->in_total_ninas_nuevos;
    }

    /**
     * @param mixed $in_total_ninas_nuevos
     *
     * @return self
     */
    public function setINTotalNinasNuevos($in_total_ninas_nuevos)
    {
        $this->in_total_ninas_nuevos = $in_total_ninas_nuevos;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getINTotalNinos03Nuevos()
    {
        return $this->in_total_ninos_0_3_nuevos;
    }

    /**
     * @param mixed $in_total_ninos_0_3_nuevos
     *
     * @return self
     */
    public function setINTotalNinos03Nuevos($in_total_ninos_0_3_nuevos)
    {
        $this->in_total_ninos_0_3_nuevos = $in_total_ninos_0_3_nuevos;

        return $this;
    }  
    
    /**
     * @return mixed
     */
    public function getINTotalNinos36Nuevos()
    {
        return $this->in_total_ninos_3_6_nuevos;
    }

    /**
     * @param mixed $in_total_ninos_3_6_nuevos
     *
     * @return self
     */
    public function setINTotalNinos36Nuevos($in_total_ninos_3_6_nuevos)
    {
        $this->in_total_ninos_3_6_nuevos = $in_total_ninos_3_6_nuevos;

        return $this;
    } 
    
    /**
     * @return mixed
     */
    public function getINTotalNinos6Nuevos()
    {
        return $this->in_total_ninos_6_nuevos;
    }

    /**
     * @param mixed $in_total_ninos_6_nuevos
     *
     * @return self
     */
    public function setINTotalNinos6Nuevos($in_total_ninos_6_nuevos)
    {
        $this->in_total_ninos_6_nuevos = $in_total_ninos_6_nuevos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINTotalNinas03Nuevos()
    {
        return $this->in_Total_Ninas_0_3_nuevos;
    }

    /**
     * @param mixed $in_Total_Ninas_0_3_nuevos
     *
     * @return self
     */
    public function setINTotalNinas03Nuevos($in_Total_Ninas_0_3_nuevos)
    {
        $this->in_Total_Ninas_0_3_nuevos = $in_Total_Ninas_0_3_nuevos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINTotalNinas36Nuevos()
    {
        return $this->in_Total_Ninas_3_6_nuevos;
    }

    /**
     * @param mixed $in_Total_Ninas_3_6_nuevos
     *
     * @return self
     */
    public function setINTotalNinas36Nuevos($in_Total_Ninas_3_6_nuevos)
    {
        $this->in_Total_Ninas_3_6_nuevos = $in_Total_Ninas_3_6_nuevos;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINTotalNinas6Nuevos()
    {
        return $this->in_total_ninas_6_nuevos;
    }

    /**
     * @param mixed $in_total_ninas_6_nuevos
     *
     * @return self
     */
    public function setINTotalNinas6Nuevos($in_total_ninas_6_nuevos)
    {
        $this->in_total_ninas_6_nuevos = $in_total_ninas_6_nuevos;

        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getINMujeresGestantesNuevos()
    {
        return $this->in_mujeres_gestantes_nuevos;
    }

    /**
     * @param mixed $in_mujeres_gestantes_nuevos
     *
     * @return self
     */
    public function setINMujeresGestantesNuevos($in_mujeres_gestantes_nuevos)
    {
        $this->in_mujeres_gestantes_nuevos = $in_mujeres_gestantes_nuevos;

        return $this;
    } 

    /**
     * @return mixed
     */
    public function getINAfrodescendienteNuevo()
    {
        return $this->in_afrodescendiente_nuevo;
    }

    /**
     * @param mixed $in_afrodescendiente_nuevo
     *
     * @return self
     */
    public function setINAfrodescendienteNuevo($in_afrodescendiente_nuevo)
    {
        $this->in_afrodescendiente_nuevo = $in_afrodescendiente_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINCampesinaNuevo()
    {
        return $this->in_campesina_nuevo;
    }

    /**
     * @param mixed $in_campesina_nuevo
     *
     * @return self
     */
    public function setINCampesinaNuevo($in_campesina_nuevo)
    {
        $this->in_campesina_nuevo = $in_campesina_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINDiscapacidadNuevo()
    {
        return $this->in_discapacidad_nuevo;
    }

    /**
     * @param mixed $in_discapacidad_nuevo
     *
     * @return self
     */
    public function setINDiscapacidadNuevo($in_discapacidad_nuevo)
    {
        $this->in_discapacidad_nuevo = $in_discapacidad_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINConflictoNuevo()
    {
        return $this->in_conflicto_nuevo;
    }

    /**
     * @param mixed $in_conflicto_nuevo
     *
     * @return self
     */
    public function setINConflictoNuevo($in_conflicto_nuevo)
    {
        $this->in_conflicto_nuevo = $in_conflicto_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINIndigenaNuevo()
    {
        return $this->in_indigena_nuevo;
    }

    /**
     * @param mixed $in_indigena_nuevo
     *
     * @return self
     */
    public function setINIndigenaNuevo($in_indigena_nuevo)
    {
        $this->in_indigena_nuevo = $in_indigena_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINPrivadosNuevo()
    {
        return $this->in_privados_nuevo;
    }

    /**
     * @param mixed $in_privados_nuevo
     *
     * @return self
     */
    public function setINPrivadosNuevo($in_privados_nuevo)
    {
        $this->in_privados_nuevo = $in_privados_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINVictimasNuevo()
    {
        return $this->in_victimas_nuevo;
    }

    /**
     * @param mixed $in_victimas_nuevo
     *
     * @return self
     */
    public function setINVictimasNuevo($in_victimas_nuevo)
    {
        $this->in_victimas_nuevo = $in_victimas_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINRaizalNuevo()
    {
        return $this->in_raizal_nuevo;
    }

    /**
     * @param mixed $in_raizal_nuevo
     *
     * @return self
     */
    public function setINRaizalNuevo($in_raizal_nuevo)
    {
        $this->in_raizal_nuevo = $in_raizal_nuevo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getINRomNuevo()
    {
        return $this->in_rom_nuevo;
    }

    /**
     * @param mixed $in_rom_nuevo
     *
     * @return self
     */
    public function setINRomNuevo($in_rom_nuevo)
    {
        $this->in_rom_nuevo = $in_rom_nuevo;

        return $this;
    }

        /**
     * @return mixed
     */
    public function getInDiscapacidad710Nuevos()
    {
        return $this->in_discapacidad_7_10_nuevo;
    }

    /**
     * @param mixed $in_discapacidad_7_10_nuevo
     *
     * @return self
     */
    public function setInDiscapacidad710Nuevos($in_discapacidad_7_10_nuevo)
    {
        $this->in_discapacidad_7_10_nuevo = $in_discapacidad_7_10_nuevo;

        return $this;
    }
        
}
