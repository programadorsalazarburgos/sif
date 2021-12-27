<?php

namespace General\Persistencia\DAOS;


class TbMenuActividadUsuarioDAO extends GestionDAO {

    private $db;

    function __construct()
    {
        $this->db=$this->obtenerBD();
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

    public function consultarObjeto($objeto = null)
    {
        $modulos = $this->db->query(
            "SELECT DISTINCT(tmm.PK_Id_Modulo), tmm.VC_Nom_Modulo, tmm.VC_Icono
   			FROM tb_menu_modulo tmm
   			LEFT JOIN tb_menu_actividad tma ON tma.FK_Modulo = tmm.PK_Id_Modulo
   			LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
   			LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
   			JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tmau.FK_Persona = tp2.PK_Id_Persona) AND tp2.PK_Id_Persona = ".$objeto->getFkPersona().";"
        )->fetchAll(\PDO::FETCH_ASSOC);

        foreach($modulos as $clave=>$modulo)
        {
            $modulo['actividades']= $this->db->query(
                "SELECT tma.*
    			FROM tb_menu_actividad tma
    			LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
    			LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
    			JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tp2.PK_Id_Persona = tmau.FK_Persona) AND tp2.PK_Id_Persona = ".$objeto->getFkPersona()."
    			WHERE tma.FK_Modulo = ".$modulo['PK_Id_Modulo']."
    			GROUP BY tma.PK_Id_Actividad;"
            )->fetchAll(\PDO::FETCH_ASSOC);
            $m[]=$modulo;
        }
        return $m;
    }
}
