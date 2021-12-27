<?php
//header('charset=utf-8');
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location:index.php");

} else { 
$Id_Persona = $_SESSION["session_username"]; //
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../LibreriasExternas/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <script src="../LibreriasExternas/JQuery/jquery-3.1.1.min.js"></script>
    <script src="../LibreriasExternas/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="../js/bootbox.js"></script>
    <script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="Js/Notificaciones.js?v=5.0"></script>

</head>
<style type="text/css">
    .row-margin-none{
        margin-right: 0;
        margin-left: 0;
    }
</style>
<body>
    <div class="container-fluid" style="padding-top: 30px">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="">
                    <h2>Notificaciones
                    </h2>
                    <input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
                </div>
            </div>
            <div class="panel-body">
                <div class="row row-margin-none" >
                    <div class="col-xs-12 col-md-12">
                        <div class="">
                            <table id="table-notification" class="table table-hover">
                                <thead>
                                    <tr hidden>
                                        <th class="text-center"><strong>Icono</strong></th>
                                        <th class="text-center"><strong>Contenido</strong></th>
                                        <th class="text-center"><strong>Url</strong></th>
                                        <th class="text-center"><strong>Id</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php }  ?>