<template>
<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header text-muted">
            <h2 class="m-0">Consolidado de Revisiones: Reporte Digital Mensual</h2>
        </div>
        <div class="card-body text-center">
            <div class="alert alert-light m-2" role="alert">
                <p>A continuación debe seleccionar el año y el mes para el cual desea hacer la consulta:</p>
                <div class="form-group row justify-content-center">
                        <div class="col-sm-4">
                        <vue-monthly-picker v-model="anio_mes"
                            :dateFormat="'YYYY-MM'"
                            :placeHolder="'Seleccione Año - Mes'" 
                            :monthLabels="['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC']"> 
                        </vue-monthly-picker>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-info" @click="generarReporte" type="button"><span class="fa fa-search" aria-hidden="true"></span> Buscar</button>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" id="search_result" v-show="infoInicial">
                <div class="col-sm-6">
                    <table id="tabla_resultados" name="tabla_resultados" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Línea de Atención</th>
                                <th>Pendientes</th>
                                <th>Aprobados</th>
                                <th>Rechazados</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i>Arte en la Escuela</i></td>
                                <td>{{PendientesArte}}</td>
                                <td>{{AprobadosArte}}</td>
                                <td>{{RechazadosArte}}</td>
                                <td>{{TotalArte}}</td>
                            </tr>
                            <tr>
                                <td><i>Impulso Colectivo</i></td>
                                <td>{{PendientesEmprende}}</td>
                                <td>{{AprobadosEmprende}}</td>
                                <td>{{RechazadosEmprende}}</td>
                                <td>{{TotalEmprende}}</td>
                            </tr>
                            <tr>
                                <td><i>Converge</i></td>
                                <td>{{PendientesLaboratorio}}</td>
                                <td>{{AprobadosLaboratorio}}</td>
                                <td>{{RechazadosLaboratorio}}</td>
                                <td>{{TotalLaboratorio}}</td>
                            </tr>
                            <tr>
                                <th>TOTAL</th>
                                <th>{{TotalPendientes}}</th>
                                <th>{{TotalAprobados}}</th>
                                <th>{{TotalRechazados}}</th>
                                <th>{{TotalGeneral}}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="alert alert-light m-2" v-show="infoInicial" role="alert">
                <h4 class="alert-heading">Filtros Adicionales
                </h4>
                
                <div class="form-group row text-left">
                    <div class="col-lg-4 col-sm-4">
                        <label>Linea de Atención</label>
                        <multiselect v-model="linea_atencion" label="text" :options="lista_linea_atencion" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <label>Estado</label>
                        <multiselect v-model="estado" label="text" :options="lista_estado" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                    </div>
                    <div class="col-lg-4 col-sm-4 pt-4 text-center">
                        <button class="btn btn-success" @click="generarReporte" type="button"><span class="fa fa-retweet" aria-hidden="true"></span> Refrescar</button>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center" id="search_result" v-show="infoInicial">
                <div class="col-sm-12">
                    <table id="tabla_detalle" name="tabla_detalle" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Artista Formador</th>
                                <th>Grupo</th>
                                <th>Línea de Atención</th>
                                <th>Estado</th>
                                <th>Fecha de Creación</th>
                                <th>Observación</th>
                                <th>Detalle</th>
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

</template>

<script>
    require( 'jszip' );
	require( 'datatables.net-dt' );
	require( 'datatables.net-buttons-dt' );
	require( 'datatables.net-buttons/js/buttons.html5.js' );
	require( 'datatables.net-responsive-dt' );

    import Multiselect from "vue-multiselect";
    import DataTables from "datatables.net";
    import Sweetalert2 from 'sweetalert2';
    import { forEach } from 'jszip';
    import VueMonthlyPicker from 'vue-monthly-picker';
    
    export default {
        components: { 
            Multiselect, 
            VueMonthlyPicker 
        },
        data () {
            return {
                anio_mes: "",
                id_usuario: "",
                infoInicial: false,
                linea_atencion: "",
                estado: "",
                PendientesArte: 0,
                AprobadosArte: 0,
                RechazadosArte: 0,
                TotalArte: 0,
                PendientesEmprende: 0,
                AprobadosEmprende: 0,
                RechazadosEmprende: 0,
                TotalEmprende: 0,
                PendientesLaboratorio: 0,
                AprobadosLaboratorio: 0,
                RechazadosLaboratorio: 0,
                TotalLaboratorio: 0,
                TotalPendientes: 0,
                TotalAprobados: 0,
                TotalRechazados: 0,
                TotalGeneral: 0,
                tabla_detalle: "",
                config_tabla: "",
                lista_linea_atencion: [{"text":"ARTE EN LA ESCUELA","value":"arte_escuela"},{"text":"IMPULSO COLECTIVO","value":"emprende_clan"},{"text":"CONVERGE","value":"laboratorio_clan"}],
                lista_estado: [{"text":"PENDIENTE","value":0}, {"text":"APROBADO","value":1}, {"text":"RECHAZADO","value":2}],
            }
        },
        mounted() {
            this.config_tabla = {
				autoWidth: false,
				responsive: true,
				pageLength: 50,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por página",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando página _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrado de un total de _MAX_ registros)",
					"search": "Filtrar",
					"paginate": {
						"first": "Primera",
						"last": "Última",
						"next": "Siguiente",
						"previous": "Anterior"
					}
                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        filename: 'Reporte_Revisiones',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
				    },
                    /*{
                        extend: 'pdf',
                        text: 'PDF',
                        filename: 'Pdf_Reporte_Revisiones',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
				    }*/
                ]
			};

            this.tabla_detalle = $("#tabla_detalle").DataTable(this.config_tabla);
            this.getIdPersona();
        },
        methods: {
            generarReporte(e){
                if(this.anio_mes === "" || this.anio_mes === null) {
                    Swal.fire("Error", "Debe seleccionar año y mes para realizar la consulta", "error");
                    return false;
                }
                Swal.fire({
                    title: "Cargando información",
                    text: "Espere un poco por favor",
                    imageUrl: "../../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                axios
                    .post("/sif/framework/crea/artistaFormador/ReporteRevisiones/getReportePrincipal", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'anio_mes': this.anio_mes,
                        'id_usuario': this.id_usuario,
                        'linea_atencion': this.linea_atencion === null ? null : this.linea_atencion.value,
                        'estado': this.estado === null ? null : this.estado.value,
                    })
                    .then(response => {
                        this.resetValues();
                        response.data.forEach((value, index) => {
                            this.TotalGeneral += parseInt(value['conteo']);
                            switch(value['linea_atencion']) {
                                case 'arte_escuela':
                                    //Arte
                                    this.TotalArte += parseInt(value['conteo']);
                                    if(value['SM_estado'] == '0') {
                                        this.PendientesArte += parseInt(value['conteo']);
                                        this.TotalPendientes += parseInt(value['conteo']);
                                    } else if(value['SM_estado'] == '1') {
                                        this.AprobadosArte += parseInt(value['conteo']);
                                        this.TotalAprobados += parseInt(value['conteo']);
                                    } else {
                                        this.RechazadosArte += parseInt(value['conteo']);
                                        this.TotalRechazados += parseInt(value['conteo']);
                                    }
                                break;
                                
                                case 'emprende_clan':
                                    //Emprende
                                    this.TotalEmprende += parseInt(value['conteo']);
                                    if(value['SM_estado'] == '0') {
                                        this.PendientesEmprende += parseInt(value['conteo']);
                                        this.TotalPendientes += parseInt(value['conteo']);
                                    } else if(value['SM_estado'] == '1') {
                                        this.AprobadosEmprende += parseInt(value['conteo']);
                                        this.TotalAprobados += parseInt(value['conteo']);
                                    } else {
                                        this.RechazadosEmprende += parseInt(value['conteo']);
                                        this.TotalRechazados += parseInt(value['conteo']);
                                    }
                                break;
                                
                                case 'laboratorio_clan':
                                    //Laboratorio
                                    this.TotalLaboratorio += parseInt(value['conteo']);
                                    if(value['SM_estado'] == '0') {
                                        this.PendientesLaboratorio += parseInt(value['conteo']);
                                        this.TotalPendientes += parseInt(value['conteo']);
                                    } else if(value['SM_estado'] == '1') {
                                        this.AprobadosLaboratorio += parseInt(value['conteo']);
                                        this.TotalAprobados += parseInt(value['conteo']);
                                    } else {
                                        this.RechazadosLaboratorio += parseInt(value['conteo']);
                                        this.TotalRechazados += parseInt(value['conteo']);
                                    }
                                break;
                            }
                        });
                        this.getInfoDetallada();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getInfoDetallada(){
                axios
                    .post("/sif/framework/crea/artistaFormador/ReporteRevisiones/getReporteDetallado", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'anio_mes': this.anio_mes,
                        'id_usuario': this.id_usuario,
                        'linea_atencion': this.linea_atencion === null ? null : this.linea_atencion.value,
                        'estado': this.estado === null ? null : this.estado.value,
                    })
                    .then(response => {
                        this.tabla_detalle.clear().draw();
                        var contador = 1;
                        var linea;
                        var nombre_grupo;
                        response.data.forEach((value, index) => {
                            switch(value.linea_atencion) {
                                case 'arte_escuela':
                                    linea = 'Arte en la Escuela';
                                    nombre_grupo = 'AE';
                                break;
                                case 'emprende_clan':
                                    linea = 'Impulso Colectivo';
                                    nombre_grupo = 'IC';
                                break;
                                case 'laboratorio_clan':
                                    linea = 'Converge';
                                    nombre_grupo = 'CV';
                                break;
                            }
                            var label_estado = '';
                            if(value.SM_estado == '0') {
                                label_estado = '<span class="badge badge-pill badge-info">PENDIENTE</span>';
                            } else if(value.SM_estado == '1') {
                                label_estado = '<span class="badge badge-pill badge-success">APROBADO</span>';
                            } else {
                                label_estado = '<span class="badge badge-pill badge-danger">RECHAZADO</span>';
                            }
                            var obs = JSON.parse(value.TX_observaciones_json);
                            this.rowNode = this.tabla_detalle.row.add([
                                contador,
                                value.artista_formador.toUpperCase(),
                                nombre_grupo+"-"+value.FK_grupo,
                                linea.toUpperCase(),
                                label_estado,
                                value.DT_fecha_creacion,
                                obs.observacion.toUpperCase(),
                                "<a href='#'>Ver Detalle</a>"//"<button type='button' class='btn btn-secondary btn-sm visualizar'><i class='fa fa-xs fa-eye'></i></button>"
                            ]).draw().node();
                            contador++;
                        });
                        Swal.close();
                        this.infoInicial = true;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            resetValues(){
                this.PendientesArte = 0;
                this.AprobadosArte = 0;
                this.RechazadosArte = 0;
                this.TotalArte = 0;
                this.PendientesEmprende = 0;
                this.AprobadosEmprende = 0;
                this.RechazadosEmprende = 0;
                this.TotalEmprende = 0;
                this.PendientesLaboratorio = 0;
                this.AprobadosLaboratorio = 0;
                this.RechazadosLaboratorio = 0;
                this.TotalLaboratorio = 0;
                this.TotalPendientes = 0;
                this.TotalAprobados = 0;
                this.TotalRechazados = 0;
                this.TotalGeneral = 0;
            },
            InformeDetallado(){
                return false;
            },
            getIdPersona(){
				axios
				.post("/sif/framework/getIdPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.id_usuario = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>