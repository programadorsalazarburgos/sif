<?php
$v = $this->getVariables();
$dia_mes = $fechaActual = date('d');
$dias_sesiones = $v['dias_sesiones'];
$ids_sesiones = $v['ids_sesiones'];
$anexos_sesiones = $v['anexos_sesiones'];
$detalle_dia_sesion_clase = $v['detalle_dia_sesion_clase'];
$thead = "<thead><tr><th>Nombres</th><th>Apellidos</th><th>Identificación</th>";
$tbody = "<tbody>";
$dias_sesiones_head = "";
$dias_sesiones_body = "";
$dia_inicial = $dia_mes - date("w");
$dia_inicial++;
if(date("w") == '0'){
    if($dia_mes > 7){
        $dia_inicial=$dia_mes-6;
    }else{
        $dia_inicial=1;
    }
}
$dia_inicial=1;
for ($i=$dia_inicial; $i <= $dia_mes ; $i++) {
    $cabecera_dia = $i;
    $flag = true;
    foreach ($detalle_dia_sesion_clase as $key => $value) {
        if(isset($value["dia_".$i])){
            $flag = false;
            break;
        }
    }
    if($flag){
        $cabecera_dia = "<span class='badge crear_sesion_clase' data-dia='".$i."'>".$i."</span>";
    }else{
        $cabecera_dia = $i.'<span class="label label-primary subir_anexo" data-id_sesion_clase="'.$ids_sesiones[$i].'" title="Subir Anexo">A</span>';
        //"span class='badge crear_sesion_clase' data-dia='".$i."'>".$i."</span>";
    }
    $dias_sesiones_head .= "<th>".$cabecera_dia."</th>";
}
$thead .= $dias_sesiones_head."</tr>";
$estado_asistencia = [];
for ($i=$dia_inicial; $i <= $dia_mes ; $i++) {
    foreach ($detalle_dia_sesion_clase as $key => $value) {
        if(isset($value["dia_".$i])){
            foreach ($value["dia_".$i] as $k => $val) {
                $estado_asistencia["dia_".$i]["estudiante"][$val['FK_estudiante']] = $val['IN_estado_asistencia'];
            }
            $estado_asistencia["dia_".$i]["estudiante"]["FK_sesion_clase"] = $ids_sesiones[$i];
        }
    }
}
foreach ($v['estudiante'] as $e) {
    $tbody .= "<td>".$e['VC_Primer_Nombre']." ".$e['VC_Segundo_Nombre']."</td>";
    $tbody .= "<td>".$e['VC_Primer_Apellido']." ".$e['VC_Segundo_Apellido']."</td>";
    $tbody .= "<td>".$e['IN_Identificacion']."</td>";
    for ($i=$dia_inicial; $i <= $dia_mes ; $i++) {
        if(in_array($i,$dias_sesiones)){
            $tbody .= '<td><input data-toggle="toggle" data-onstyle="success" name= "CH_asistencia_beneficiario_'.$i.'[]" data-offstyle="danger" data-on="SI" data-off="NO" ';
            $tbody .= (($estado_asistencia["dia_".$i]["estudiante"][$e['id']] == 1)?'checked=checked':'');
            $tbody .= ' data-size="mini" type="checkbox" data-id_beneficiario='.$e['id'].' data-id_sesion_clase=';
            // $tbody .= (isset($estado_asistencia["dia_".$i]["FK_sesion_clase"])?$estado_asistencia["dia_".$i]["FK_sesion_clase"]:'0');
            $tbody .= $estado_asistencia["dia_".$i]["estudiante"]["FK_sesion_clase"];
            $tbody .= ' class="asistencia_clase">';
            //$tbody .= '<span class="badge badge-warning bioseguridad" data-toggle="modal" data-target="#modal_bioseguridad" data-id_estudiante="'.$e['id'].'" data-id_sesion_clase="'.$estado_asistencia["dia_".$i]["estudiante"]["FK_sesion_clase"].'">B</span>';
            $tbody .= '</td>';
        }else{
            $tbody .= "<td>X</td>";
        }
    }
    $tbody .= "</tr>";
}
$thead .= "</thead>";
$tbody .= "</tbody>";
// var_dump($estado_asistencia);
echo "<table class='table' id='table_asistencia_masiva'>".$thead.$tbody."</table>";