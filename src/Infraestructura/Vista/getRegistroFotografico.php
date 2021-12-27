<?php
$return = "<div id='myCarousel' name='myCarousel' class='carousel slide' data-ride='carousel'>";
$urls_fotografias = $this->getVariables()['datos'];
$urls_fotografias = explode("///", $urls_fotografias);
if($urls_fotografias[0] != null){
	$contador = 0;
	$return .= "<ol class='carousel-indicators'>";
		foreach ($urls_fotografias as $url){
			$return .= "<li data-target='#myCarousel' data-slide-to='".$contador."' class='active'></li>";
			$contador++;
		}
	$return .= "</ol>";
	
	$contador = 0;
	$return .= "<div class='carousel-inner'>";
		foreach ($urls_fotografias as $url){
				if ($contador == 0) {
					$return .= "<div class='item active'>";
				}else{
					$return .= "<div class='item'>";
				}			
				$return .= "<img src='".$url."'>";
				$return .= "</div>";
				$contador++;
		}
	$return .= "</div>";
	
	$return .= "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>";
	$return .= "<span class='glyphicon glyphicon-chevron-left'></span>";
	$return .= "<span class='sr-only'>Previous</span>";
	$return .= "</a>";
	$return .= "<a class='right carousel-control' href='#myCarousel' data-slide='next'>";
	$return .= "<span class='glyphicon glyphicon-chevron-right'></span>";
	$return .= "<span class='sr-only'>Next</span>";		
	$return .= "</a>";
	$return .= "</div>";
}
else{
	$return .= "<ol class='carousel-indicators'>";
	$return .= "<li data-target='#myCarousel' data-slide-to='0' class='active'></li>";
	$return .= "</ol>";

	$return .= "<div class='carousel-inner'>";
	$return .= "<div class='item active'>";
		$return .= "<img src='../../uploadedFiles/Infraestructura/Inventarios/RegistroFotografico/default.png'>";		
	$return .= "</div>";
	$return .= "</div>";

	$return .= "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>";
	$return .= "<span class='glyphicon glyphicon-chevron-left'></span>";
	$return .= "<span class='sr-only'>Previous</span>";
	$return .= "</a>";
	$return .= "<a class='right carousel-control' href='#myCarousel' data-slide='next'>";
	$return .= "<span class='glyphicon glyphicon-chevron-right'></span>";
	$return .= "<span class='sr-only'>Next</span>";		
	$return .= "</a>";
	$return .= "</div>";
}
echo $return;