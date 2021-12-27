<?php 
namespace General;
class Route{
	public static $validRoutes = array();
	public static function set($route,$function)
	{
		self::$validRoutes[] = $route;
		$url = explode("/", $_GET['url']);
		if ($_GET['url'] == $route) {
			// $url[0] nombre del modulo
			$function->__invoke($url[0],$url[1],$url[2]);
		}
	}
}
?>