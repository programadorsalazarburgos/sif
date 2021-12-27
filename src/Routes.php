<?php 
namespace General;
require_once "../Vendor/autoload.php";
use General\Route;
if (isset($_GET['url'])) {
	Route::set($_GET['url'],function($modulo,$class,$method){
		try {
			$class  = $modulo."\\Controlador\\".$class;
			$clase = new $class();
			if(isset($_POST["p1"])) $p1=$_POST["p1"]; else $p1=null;
			if(isset($_POST["p2"])) $p2=$_POST["p2"]; else $p2=null;
			if(isset($_POST["p3"])) $p3=$_POST["p3"]; else $p3=null;
			if(isset($_POST["p4"])) $p4=$_POST["p4"]; else $p4=null;
			if(isset($_POST["p5"])) $p5=$_POST["p5"]; else $p5=null;
			if(isset($_FILES) && sizeof($_FILES)>0) {
				if($p1===null) {
					$p1=$_POST;
				}
				$p2=$_FILES;
			}
			$clase->$method($p1,$p2,$p3,$p4,$p5);
		} catch (Exception $e) {
		}
	});
}

?>