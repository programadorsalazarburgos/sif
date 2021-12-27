<?php  
$return = "";
$options = "";
$controles = '';
$visualizacion = $this->getVariables()['visualizacion'];
$obligatorios = $this->getVariables()['options'];
$anexos = $this->getVariables()['anexos'];
if($visualizacion == 'C'){
    $return .=obtenerTablaSinAnexos($obligatorios);
}else if($visualizacion == 'E'){

    foreach ($obligatorios as $key2=>$obligatorio){
        $anexoCargado = false;
        foreach ($anexos as  $key=>$anexo)
        {        
            if($obligatorio['PK_Id_Tabla'] == $anexo['FK_Parametro_Detalle']){
                $anexoCargado = true;
                $controles = '	
                <a href="'.str_replace('/var/www/html','',$anexo['Tx_Anexo']).'" target="_blank" class="btn btn-success descargar" title="Descargar Anexo: '.$anexo['VC_nombre'].'">
                    <span class="fa fa-download" aria-hidden="true"></span>
                </a>
                ';
                
                $controles .= '	         						
                <button type=button class="btn btn-danger limpiar_upload" title="Eliminar Anexo" data-id_anexo="'.$anexo['PK_Id_Tabla'].'" data-nombre_anexo="'.$anexo['VC_nombre'].'" data-campo_obligatorio="'.$esObligatorio.'">
                    <span class="fa fa-times" aria-hidden="true"></span>
                </button>         
                ';  
                $input = '
                <div class="col-md-6 col-lg-6">
                    <input type="file" data-descarga="1" name="anexo-'.$anexo['PK_Id_Tabla'].'" class="filestyle form-control archivo anexo_planilla" data-nombre_campo="'.$anexo['VC_nombre'].'" data-btn_class="btn-primary" data-buttonBefore="true" runat="server"></input>
                </div> ';              
                
                $options= '<option selected value="'.$anexo['FK_Parametro_Detalle'].'">'.$anexo['VC_nombre'].'</option>';
                $return.='
                    <div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
                        <div class="col-md-4 col-lg-4">
                            <select name="tipo_documento" class="form-control tipo_documento" disabled>
                                <option value="">- Seleccione -</option>'.$options.'
                            </select>
                        </div>
                        '.$input.'
                        <div class="col-md-2 col-lg-2">
                            '.$controles.'
                        </div>
                    </div>    
                ';  
                unset($anexos[$key]);
            }            
        }
        if(!$anexoCargado){

            $options= '<option selected value="'.$obligatorio['PK_Id_Tabla'].'">'.$obligatorio['VC_nombre'].'</option>';
            $return.='
                <div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
                    <div class="col-md-4 col-lg-4">
                        <select name="tipo_documento" class="form-control tipo_documento" disabled>
                            <option value="">- Seleccione -</option>'.$options.'
                        </select>
                    </div>
                    
                    <div class="col-md-6 col-lg-6">
                        <input type="file" name="anexo-'.$key2.'" data-descarga="0" class="filestyle form-control archivo anexo_planilla" required="required" data-btnClass="btn-primary" data-buttonBefore="true" runat="server"></input>
                    </div> 
                    <div class="col-md-2 col-lg-2">
                    </div>
                </div>    
            ';  
        }

    } 
    #Muestra Anexos Opcionales
    foreach ($anexos as  $key=>$anexo)
    {  
        $controles = '	
        <a href="'.str_replace('/var/www/html','',$anexo['Tx_Anexo']).'" target="_blank" class="btn btn-success descargar" title="Descargar Anexo: '.$anexo['VC_nombre'].'">
            <span class="fa fa-download" aria-hidden="true"></span>
        </a>
        ';
        
        $controles .= '	         						
        <button type=button class="btn btn-danger limpiar_upload" title="Eliminar Anexo" data-id_anexo="'.$anexo['PK_Id_Tabla'].'" data-nombre_anexo="'.$anexo['VC_nombre'].'" data-campo_obligatorio="'.$esObligatorio.'">
            <span class="fa fa-times" aria-hidden="true"></span>
        </button>         
        ';  
        $input = '
        <div class="col-md-6 col-lg-6">
            <input type="file" data-descarga="1" name="anexo-'.$anexo['PK_Id_Tabla'].'" class="filestyle form-control archivo anexo_planilla" data-nombre_campo="'.$anexo['VC_nombre'].'" data-btn_class="btn-primary" data-buttonBefore="true" runat="server"></input>
        </div> ';              
        
        $options= '<option selected value="'.$anexo['FK_Parametro_Detalle'].'">'.$anexo['VC_nombre'].'</option>';
        $return.='
            <div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
                <div class="col-md-4 col-lg-4">
                    <select name="tipo_documento" class="form-control tipo_documento" disabled>
                        <option value="">- Seleccione -</option>'.$options.'
                    </select>
                </div>
                '.$input.'
                <div class="col-md-2 col-lg-2">
                    '.$controles.'
                </div>
            </div>    
        '; 
    }
}
else{

    if(count($anexos)>0){
        foreach ($anexos as  $key=>$anexo)
        {
            $esObligatorio = 0;
            foreach ($obligatorios as $obligatorio){
                if($obligatorio['PK_Id_Tabla'] == $anexo['FK_Parametro_Detalle']){
                    $esObligatorio = 1;
                    break;
                }
            }
            $controles = '	
                <a href="'.str_replace('/var/www/html','',$anexo['Tx_Anexo']).'" target="_blank" class="btn btn-success descargar" title="Descargar Anexo: '.$anexo['VC_nombre'].'">
                    <span class="fa fa-download" aria-hidden="true"></span>
                </a>
            ';
            $input = '';
            if($visualizacion == 'E'){

                $controles .= '	         						
                <button type=button class="btn btn-danger limpiar_upload" title="Eliminar Anexo" data-id_anexo="'.$anexo['PK_Id_Tabla'].'" data-nombre_anexo="'.$anexo['VC_nombre'].'" data-campo_obligatorio="'.$esObligatorio.'">
                    <span class="fa fa-times" aria-hidden="true"></span>
                </button>         
                ';  
                $input = '
                <div class="col-md-6 col-lg-6">
                    <input type="file" name="anexo-'.$anexo['PK_Id_Tabla'].'" class="filestyle form-control archivo anexo_planilla" data-nombre_campo="'.$anexo['VC_nombre'].'" data-btn_class="btn-primary" data-buttonBefore="true" runat="server"></input>
                </div> ';              
            }
            $options= '<option selected value="'.$anexo['FK_Parametro_Detalle'].'">'.$anexo['VC_nombre'].'</option>';
            $return.='
                <div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
                    <div class="col-md-4 col-lg-4">
                        <select name="tipo_documento" class="form-control tipo_documento" disabled>
                            <option value="">- Seleccione -</option>'.$options.'
                        </select>
                    </div>
                    '.$input.'
                    <div class="col-md-2 col-lg-2">
                        '.$controles.'
                    </div>
                </div>    
            ';                  
        }
    }else{
        $return .=obtenerTablaSinAnexos($obligatorios);
    }

}

function obtenerTablaSinAnexos($obligatorios){
    foreach ($obligatorios as $key=>$option){
        $options= '<option selected value="'.$option['PK_Id_Tabla'].'">'.$option['VC_nombre'].'</option>';
        $return.='
            <div class="col-md-12 col-lg-12 item-grid" style="margin-top: 6px;">
                <div class="col-md-4 col-lg-4">
                    <select name="tipo_documento" class="form-control tipo_documento" disabled>
                        <option value="">- Seleccione -</option>'.$options.'
                    </select>
                </div>
                
                <div class="col-md-6 col-lg-6">
                    <input type="file" name="anexo-'.$key.'" data-descarga="0" class="filestyle form-control archivo anexo_planilla"  data-btnClass="btn-primary" data-buttonBefore="true" runat="server"></input>
                </div> 
                <div class="col-md-2 col-lg-2">
                </div>
            </div>    
        ';  
    } 
    return $return;   
}

$html =$return;
