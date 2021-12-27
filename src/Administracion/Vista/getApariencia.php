<?php     
    $css="";
    $cssIframe="";
    $js="";
    $a=$this->getVariables()['apariencia'];
    if($a['VC_socket_io']!=''){    	
    	$js.="$('#socket_io').val('".$a['VC_socket_io']."');";
    }  


    if($a['VC_Banner']!='')   
		$css.=".bannerInicio{ background: ".$a['VC_Banner']." !important; }"; 
	if($a['VC_Logo']!='')
		$css.=".logo-header{ background-image: url('".$a['VC_Logo']."') !important; }";
	if($a['VC_Titulo_Banner']!='') 
		$js.="$('#tituloPerfil').html('".$a['VC_Titulo_Banner']."');";
	if($a['VC_Fondo_Hamburguesa']!='') 
		$css.="#boton_menu{ border: 3px solid ".$a['VC_Fondo_Hamburguesa'].";} .linea{background: ".$a['VC_Fondo_Hamburguesa'].";}";
	/*if($a['VC_Tipografia_Titulo']!=''){
		$css.="h1, h2, h3, h4, h5, h6, .head, .subhead, ul{font-family: ".$a['VC_Tipografia_Titulo']." !important;}";
    	$cssIframe.="h1, h2, h3, h4, h5, h6, .head, .subhead, ul{font-family: ".$a['VC_Tipografia_Titulo']." !important;}";
	}
	if($a['VC_Tipografia_Parrafo']!=''){
	 	$css.="body, div, p, strong, b, a{ font-family: ".$a['VC_Tipografia_Parrafo']." !important;}";
	 	$cssIframe.="body, div, p, strong, b, a{ font-family: ".$a['VC_Tipografia_Parrafo']." !important;}"; 
	}*/ 
	if($a['VC_Fondo_Iframe']!='') 
		$cssIframe.="body#dashboard{ ".$a['VC_Fondo_Iframe']."}";
	if($a['VC_Fondo_Marco']!='') 
		$css.="body{background-color:".$a['VC_Fondo_Marco']." !important;}";
	if($a['VC_Color_Fuente']!=''){
		$css.="body, p, strong, b{color:".$a['VC_Color_Fuente']." !important;}";
		$cssIframe.="body, p, strong, b{color:".$a['VC_Color_Fuente']." !important;}"; 
	}
	if($a['VC_Color_Fuente_Hover']!='') $css.="";
	if($a['VC_Color_Titulo_Menu']!='')
		$css.=".moduloMenu {color: ".$a['VC_Color_Titulo_Menu'].";}.moduloMenu span{color: ".$a['VC_Color_Titulo_Menu'].";}";	
	if($a['VC_Color_Titulo_Menu_Hover']!='')
		$css.=".moduloMenu:hover {color: ".$a['VC_Color_Titulo_Menu_Hover'].";}.moduloMenu:hover span{color: ".$a['VC_Color_Titulo_Menu_Hover'].";}";
	if($a['VC_Color_Menu']!='')
		$css.=".actividadMenu {color:".$a['VC_Color_Menu'].";}";	
	
	if($a['VC_Color_Menu_Hover']!='')
		$css.=".actividadMenu:hover {color:".$a['VC_Color_Menu_Hover'].";}";

	if($a['VC_Color_Info']!=''){ 
		$css.=".btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover, .btn-info:active.focus, .btn-info:active:focus, .btn-info:active:hover, .open>.dropdown-toggle.btn-info.focus, .open>.dropdown-toggle.btn-info:focus, .open>.dropdown-toggle.btn-info:hover,.panel-info .panel-heading, .panel-info .panel-heading small,.bg-info{ background-color:".$a['VC_Color_Info']." !important;}";
		$cssIframe.=".btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover, .btn-info:active.focus, .btn-info:active:focus, .btn-info:active:hover, .open>.dropdown-toggle.btn-info.focus, .open>.dropdown-toggle.btn-info:focus, .open>.dropdown-toggle.btn-info:hover,.panel-info .panel-heading, .panel-info .panel-heading small,.bg-info{ background-color:".$a['VC_Color_Info']." !important;}";		
	}
	if($a['VC_Color_Success']!=''){
		$css.=".btn-success,.btn-success:hover,.btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover,.panel-success .panel-heading, .panel-success .panel-heading small,.bg-success,table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before{ background-color:".$a['VC_Color_Success']." !important; color: #ffffff;}";
		$cssIframe.=".btn-success,.btn-success:hover,.btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover,.panel-success .panel-heading small, .panel-success .panel-heading,.bg-success,table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before{ background-color:".$a['VC_Color_Success']." !important; color: #ffffff;}";						
	}
	if($a['VC_Color_Warning']!=''){ 
		$css.=".btn-warning,.btn-warning:hover,.btn-warning.active.focus, .btn-warning.active:focus, .btn-warning.active:hover, .btn-warning:active.focus, .btn-warning:active:focus, .btn-warning:active:hover, .open>.dropdown-toggle.btn-warning.focus, .open>.dropdown-toggle.btn-warning:focus, .open>.dropdown-toggle.btn-warning:hover,.panel-warning .panel-heading, .panel-warning .panel-heading small,.bg-warning{ background-color:".$a['VC_Color_Warning']." !important;}";	
		$cssIframe.=".btn-warning,.btn-warning:hover,.btn-warning.active.focus, .btn-warning.active:focus, .btn-warning.active:hover, .btn-warning:active.focus, .btn-warning:active:focus, .btn-warning:active:hover, .open>.dropdown-toggle.btn-warning.focus, .open>.dropdown-toggle.btn-warning:focus, .open>.dropdown-toggle.btn-warning:hover,.panel-warning .panel-heading, .panel-warning .panel-heading small,.bg-warning{ background-color:".$a['VC_Color_Warning']." !important;}";		
	}		
	if($a['VC_Color_Danger']!=''){
		$css.=".btn-danger,.btn-danger:hover,.btn-danger.active.focus, .btn-danger.active:focus, .btn-danger.active:hover, .btn-danger:active.focus, .btn-danger:active:focus, .btn-danger:active:hover, .open>.dropdown-toggle.btn-danger.focus, .open>.dropdown-toggle.btn-danger:focus, .open>.dropdown-toggle.btn-danger:hover,.panel-danger .panel-heading, .panel-danger .panel-heading small,.bg-danger{ background-color:".$a['VC_Color_Danger']." !important;}";
		$cssIframe.=".btn-danger,.btn-danger:hover,.btn-danger.active.focus, .btn-danger.active:focus, .btn-danger.active:hover, .btn-danger:active.focus, .btn-danger:active:focus, .btn-danger:active:hover, .open>.dropdown-toggle.btn-danger.focus, .open>.dropdown-toggle.btn-danger:focus, .open>.dropdown-toggle.btn-danger:hover,.panel-danger .panel-heading, .panel-danger .panel-heading small,.bg-danger{ background-color:".$a['VC_Color_Danger']." !important;}";					
	}
	if($a['VC_Color_Default']!=''){
		$css.=".btn-default,.btn-default:hover,.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open>.dropdown-toggle.btn-default.focus, .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover,.panel-default .panel-heading, .panel-default .panel-heading small,.bg-default{ background-color:".$a['VC_Color_Default']." !important;}";
		$cssIframe.=".btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open>.dropdown-toggle.btn-default.focus, .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover,.panel-default .panel-heading, .panel-default .panel-heading small,.bg-default{ background-color:".$a['VC_Color_Default']." !important;}";						
	}
	if($a['VC_Color_Primary']!=''){
		$css.=".btn-primary,.btn-primary:hover,.btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .open>.dropdown-toggle.btn-primary.focus, .open>.dropdown-toggle.btn-primary:focus, .open>.dropdown-toggle.btn-primary:hover,.panel-primary .panel-heading,.panel-primary .panel-heading small,.bg-primary,.pagination>.active>a,.pagination>.active>a:focus,.pagination>.active>a:hover,.pagination>.active>span,.pagination>.active>span:focus,.pagination>.active>span:hover{ background-color:".$a['VC_Color_Primary']." !important;}";
		$cssIframe.=".btn-primary,.btn-primary:hover,.btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover,.open>.dropdown-toggle.btn-primary.focus,.open>.dropdown-toggle.btn-primary:focus,.open>.dropdown-toggle.btn-primary:hover,.panel-primary .panel-heading,.panel-primary .panel-heading small,.bg-primary,.pagination>.active>a,.pagination>.active>a:focus,.pagination>.active>a:hover,.pagination>.active>span,.pagination>.active>span:focus,.pagination>.active>span:hover{ background-color:".$a['VC_Color_Primary']." !important;}";	
	}
	if($a['VC_Borde_Info']!=''){ 
		$css.=".btn-info,.btn-info:hover,.btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover, .btn-info:active.focus, .btn-info:active:focus, .btn-info:active:hover, .open>.dropdown-toggle.btn-info.focus,.open>.dropdown-toggle.btn-info:focus,.open>.dropdown-toggle.btn-info:hover,.panel-info .panel-heading, .panel-info .panel-heading small,.bg-info{ border-color:".$a['VC_Borde_Info']." !important;}";
		$cssIframe.=".btn-info,.btn-info:hover,.btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover,.btn-info:active.focus,.btn-info:active:focus,.btn-info:active:hover,.open>.dropdown-toggle.btn-info.focus,.open>.dropdown-toggle.btn-info:focus,.open>.dropdown-toggle.btn-info:hover,.panel-info .panel-heading, .panel-info .panel-heading small,.bg-info{ border-color:".$a['VC_Borde_Info']." !important;}";
	}
	if($a['VC_Borde_Success']!=''){
		$css.=".btn-success,.btn-success:hover,.btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover,.panel-success .panel-heading, .panel-success .panel-heading small,.bg-success{ border-color:".$a['VC_Borde_Success']." !important;}";
		$cssIframe.=".btn-success.active.focus, .btn-success.active:focus, .btn-success.active:hover, .btn-success:active.focus, .btn-success:active:focus, .btn-success:active:hover, .open>.dropdown-toggle.btn-success.focus, .open>.dropdown-toggle.btn-success:focus, .open>.dropdown-toggle.btn-success:hover,.panel-success .panel-heading, .panel-success .panel-heading small,.bg-success{ border-color:".$a['VC_Borde_Success']." !important;}";
	}
	if($a['VC_Borde_Warning']!=''){
		$css.=".btn-warning,.btn-warning:hover,.btn-warning.active.focus, .btn-warning.active:focus, .btn-warning.active:hover, .btn-warning:active.focus, .btn-warning:active:focus, .btn-warning:active:hover, .open>.dropdown-toggle.btn-warning.focus, .open>.dropdown-toggle.btn-warning:focus, .open>.dropdown-toggle.btn-warning:hover,.panel-warning .panel-heading, .panel-warning .panel-heading small,.bg-warning{ border-color:".$a['VC_Borde_Warning']." !important;}";	
		$cssIframe.=".btn-warning,.btn-warning:hover,.btn-warning.active.focus, .btn-warning.active:focus, .btn-warning.active:hover, .btn-warning:active.focus, .btn-warning:active:focus, .btn-warning:active:hover, .open>.dropdown-toggle.btn-warning.focus, .open>.dropdown-toggle.btn-warning:focus, .open>.dropdown-toggle.btn-warning:hover,.panel-warning .panel-heading, .panel-warning .panel-heading small,.bg-warning{ border-color:".$a['VC_Borde_Warning']." !important;}";	
	}
	if($a['VC_Borde_Danger']!=''){
		$css.=".btn-danger,.btn-danger:hover,.btn-danger.active.focus, .btn-danger.active:focus, .btn-danger.active:hover, .btn-danger:active.focus, .btn-danger:active:focus, .btn-danger:active:hover, .open>.dropdown-toggle.btn-danger.focus, .open>.dropdown-toggle.btn-danger:focus, .open>.dropdown-toggle.btn-danger:hover,.panel-danger .panel-heading, .panel-danger .panel-heading small,.bg-danger{ border-color:".$a['VC_Borde_Danger']." !important;}";
		$cssIframe.=".btn-danger,.btn-danger:hover,.btn-danger.active.focus, .btn-danger.active:focus, .btn-danger.active:hover, .btn-danger:active.focus, .btn-danger:active:focus, .btn-danger:active:hover, .open>.dropdown-toggle.btn-danger.focus, .open>.dropdown-toggle.btn-danger:focus, .open>.dropdown-toggle.btn-danger:hover,.panel-danger .panel-heading, .panel-danger .panel-heading small,.bg-danger{ border-color:".$a['VC_Borde_Danger']." !important;}";
	}
	if($a['VC_Borde_Default']!=''){
		$css.=".btn-default,.btn-default:hover,.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open>.dropdown-toggle.btn-default.focus, .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover,.panel-default .panel-heading, .panel-default .panel-heading small,.bg-default{ border-color:".$a['VC_Borde_Default']." !important;}";
		$cssIframe.=".btn-default,.btn-default:hover,.btn-default.active.focus, .btn-default.active:focus, .btn-default.active:hover, .btn-default:active.focus, .btn-default:active:focus, .btn-default:active:hover, .open>.dropdown-toggle.btn-default.focus, .open>.dropdown-toggle.btn-default:focus, .open>.dropdown-toggle.btn-default:hover,.panel-default .panel-heading, .panel-default .panel-heading small,.bg-default{ border-color:".$a['VC_Borde_Default']." !important;}";
	}
	if($a['VC_Borde_Primary']!=''){
		$css.=".btn-primary,.btn-primary:hover,.btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .open>.dropdown-toggle.btn-primary.focus, .open>.dropdown-toggle.btn-primary:focus, .open>.dropdown-toggle.btn-primary:hover,.panel-primary .panel-heading,.panel-primary .panel-heading small,.bg-primary,
			.pagination>.active>a, .pagination>.active>a:focus,   
			.pagination>.active>a:hover, .pagination>.active>span, 
			.pagination>.active>span:focus, .pagination>.active>span:hover{ border-color:".$a['VC_Borde_Primary']." !important;}";
		$cssIframe.=".btn-primary,.btn-primary:hover,.btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .open>.dropdown-toggle.btn-primary.focus, .open>.dropdown-toggle.btn-primary:focus, .open>.dropdown-toggle.btn-primary:hover,.panel-primary .panel-heading,.panel-primary .panel-heading small,.bg-primary,.pagination>.active>a, .pagination>.active>a:focus,.pagination>.active>a:hover, .pagination>.active>span,.pagination>.active>span:focus, .pagination>.active>span:hover{ border-color:".$a['VC_Borde_Primary']." !important;}";	
	}
  
	if($a['VC_Fondo_Titulo_Modal_Menu']!=''){
		$cssIframe.="#headerActividades{background: ".$a['VC_Fondo_Titulo_Modal_Menu']." !important;}";
	}
	if($a['VC_Color_Titulo_Modal_Menu']!=''){
		$cssIframe.="#tituloModulo{color: ".$a['VC_Color_Titulo_Modal_Menu']." !important;}"; 
	}	

$retorno="<script type='text/javascript'> $('iframe#ventana_iframe').load( function() { 
    $('iframe#ventana_iframe').contents().find('head').append(\"<style type='text/css'>".$cssIframe."</style>\"); 
	}); 
	".$js."</script>";
$retorno.="<style type='text/css'> ".$css."</style>";
echo $retorno; 
