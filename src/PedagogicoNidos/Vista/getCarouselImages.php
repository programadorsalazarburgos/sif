<?php
$return = "";
if ($this->getVariables()['array_images'] == null){
	$return .= "<div>Lo sentimos, no hay imágenes disponibles</div>";
}else{

	/*<!-- Wrapper for slides -->*/
	$return .= "<div id='carousel-images' class='carousel slide' data-ride='carousel'>";
	/*<!-- Indicators -->*/
	$return .= "<ol class='carousel-indicators'>";
	foreach ($this->getVariables()['array_images'] as $key => $value){
		if($key == 0){
			$return .= "<li data-target='#carousel-images' data-slide-to='".$key."' class='active'></li>";
		}else{
			$return .= "<li data-target='#carousel-images' data-slide-to='".$key."'></li>";
		}
	}
	$return .= "</ol>";
	$return .= "<div class='carousel-inner'>";
	foreach ($this->getVariables()['array_images'] as $key => $value){
		$image = explode("/", $value);
		$image_name = substr($image[7], 0, (strlen($image[7])-4));
		if($key == 0){
			$return .= "<div class='item active'>";
			$return .= "<img src='".$value."' style='max-height: 100%; max-width: 100%;'>";
			$return .= "<div class='carousel-caption'><h2>".$image_name."</h2></div>";
			$return .= "</div>";
		}else{
			$return .= "<div class='item'>";
			$return .= "<img src='".$value."' style='max-height: 100%; max-width: 100%;'>";
			$return .= "<div class='carousel-caption'><h2>".$image_name."</h2></div>";
			$return .= "</div>";
		}
	}
	$return .= "</div>";
	/*<!-- Left and right controls -->*/
	$return .= "<a class='left carousel-control' href='#carousel-images' data-slide='prev'>";
	$return .= "<span class='glyphicon glyphicon-chevron-left'></span>";
	$return .= "<span class='sr-only'>Previous</span>";
	$return .= "</a>";
	$return .= "<a class='right carousel-control' href='#carousel-images' data-slide='next'>";
	$return .= "<span class='glyphicon glyphicon-chevron-right'></span>";
	$return .= "<span class='sr-only'>Next</span>";
	$return .= "</a>";
	$return .= "</div>";
}

echo $return;