$(document).ready(function(){
    var convocatoria = $("#SL_CONVOCATORIA").val();
    var tabla_convocatoria = $('#tabla-convocatoria').DataTable({
        "responsive": true,
        "paging":   true,
        "ordering": true,
        "info":     false,
        "language": {
            "lengthMenu": "Ver _MENU_ registros por pagina",
            "zeroRecords": "No hay información que mostrar, Realize una consulta.",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Filtrar"
        },
        "columnDefs": [{
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
        }],
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible'
            },
            title: 'Convocatoria2016'
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: ':visible'
            },
            title: 'Convocatoria2016'
        },
        {
            text: 'Imprimir',
            extend: 'print'
        }
        ]
    });

    $("#cerrar_sesion").on('click', function(){
        $.ajax({
            url: 'controlador/C_Cerrar_Sesion.php',
            type: 'POST',
            cache: false,
            async: false,
            dataType: 'html',
            success: function(data, textStatus, jqXHR)
            {
                var location = window.location.href;
                if(location.includes("localhost") == true){
                    window.location.href = "http://localhost/sif/ConvocatoriaOrganizaciones";
                }
                else{
                    window.location.href = "https://sif.idartes.gov.co/sif/ConvocatoriaOrganizaciones";
                }
            }   
        });
    });

    $("#consultar_convocatoria").on('click', function(){
        var convocatoria = $("#SL_CONVOCATORIA").val();
        var tabla_convocatoria = $('#tabla-convocatoria').DataTable();
        tabla_convocatoria.clear().draw();
        $.ajax({
            url: 'controlador/C_ConsultarConvocatoria.php',
            type: 'POST',
            data: {convocatoria:convocatoria},
            cache: false,
            async: false,
            dataType: 'json',
            success: function(data, textStatus, jqXHR)
            {
                $.each(data, function(i) 
                {
                    tabla_convocatoria.row.add( [
                        data[i].PK_Id_Usuario,
                        data[i].VC_Nombre_Usuario,
                        "<a href='controlador/C_RepHab_Convocatoria.php?ident="+data[i].PK_Id_Usuario+"' title='Habilitantes' id='btn-habilitantes' class='btn btn-danger' style='background-color: rgba(255, 20, 10, 1); color: white' data-toggle='tooltip' ><span class='glyphicon glyphicon-folder-open' aria-hidden='true'></span></a>"+
                        "<a href='controlador/C_RepPro_Convocatoria.php?ident="+data[i].PK_Id_Usuario+"' title='Propuesta' id='btn-Propuesta' class='btn btn-primary' style='background-color: rgba(0, 120, 255, 1); color: white' data-toggle='tooltip' ><span class='glyphicon glyphicon-file' aria-hidden='true'></span></a>"+
                        "<a href='Anexos_Convocatoria.php?ident="+data[i].PK_Id_Usuario+"' title='AnexosPropuesta' id='btn-AnexosPropuesta' class='btn btn-sucess' style='background-color: #5cb85c; color: white' data-toggle='tooltip' ><span class='glyphicon glyphicon-menu-hamburger' aria-hidden='true'></span></a>"
                        ]).draw();
                    $('[data-toggle="tooltip"]').tooltip(
                    {
                        "animation": 1
                    });
                });
            }   
        });
    });
});