 <?php
	session_start();
	unset($_SESSION["session_username"]);
	session_destroy();

	$_SESSION = array();
	session_regenerate_id(); 
	
	//header("Location: index.php");
	//exit;
?>
<script type="text/javascript">
	window.location.href = "index.php";
</script>