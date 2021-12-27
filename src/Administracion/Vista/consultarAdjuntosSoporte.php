<?php     
    $retorno="";
    foreach ($this->getVariables()['adjuntos'] as $s){
    	$nombreArchivo=substr($s['RUTA'], strrpos($s['RUTA'], "/")+1);
	    $retorno.="
				<a href='".$s['RUTA']."' class='btn btn-success iconoAdjunto' title='".$nombreArchivo."' download='".$nombreArchivo."'><span class='fa fa-download'></span></a>";
    }
    echo $retorno;
