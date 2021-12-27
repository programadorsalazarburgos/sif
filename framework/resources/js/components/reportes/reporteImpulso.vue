<template>
<div id="general">
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none; height: 10000px; padding-top:128px;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Fecha Observación</th>
                                <th scope="col">Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in arrayObservaciones" :key="data.pk_id_reporte_linea">
                                <td>{{data.created_at}}</td>
                                <td>{{data.tx_observacion}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Fin del modal-->
    <div class="content-header" style="padding: 5px !important" v-if="mostrar_reporte==1">
        <div class="card">
            <div class="card-header">
                REPORTE IMPULSO COLECTIVO
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <button type="submit" v-on:click="volverAtras()" target="_blank" class="btn-danger">
                        <i class="fas fa-hand-point-left"></i> Volver
                    </button>
                    <div class="clearfix"></div><br>
                    <div class="row mb-2">
                        <div class="container-fluid">
                            <form action="" method="post" @submit.prevent="reporte" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userinput1">Año</label>
                                                    <select class="form-control" v-model="anio" required>
                                                        <option value="0" disabled>Seleccione</option>
                                                        <option v-for="data in arrayAnios" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Tabla, VC_Descripcion: data.VC_Descripcion}">{{data.VC_Descripcion}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userinput1">Mes</label>
                                                    <select class="form-control" v-model="mes" required>
                                                        <option value="0" disabled>Seleccione</option>
                                                        <option v-for="data in arrayMeses" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Tabla, VC_Descripcion: data.VC_Descripcion, FK_Value: data.FK_Value}">{{data.VC_Descripcion}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" v-on:click="tipoReportesCarga()" target="_blank" class="btn-primary">
                                    Cargar Reporte <i class="fas fa-tasks"></i>
                                </button>
                                <button type="submit" v-on:click="tipoReportesPDF()" target="_blank" class="btn-success">
                                    Descargar Reporte PDF <i class="fas fa-file-pdf"></i>
                                </button>
                            </form>
                            <div class="clearfix"></div><br>
                            <div v-if="areas.length>0">
                                <span>Fecha Ultimo Analisis: {{fechaObservacion}}</span>
                                <textarea class="form-control" v-model="observacion" style="height:100px;"></textarea>
                                <div class="clearfix"></div><br>
                                <button type="button" v-on:click="guardarObservacion()" class="btn-success">
                                    Guardar <i class="fas fa-save"></i>
                                </button>
                                <button type="button" @click="abrirModal('data','observaciones')" v-if="observacion!=null" class="btn-danger">
                                    Ver Analisis <i class="fas fa-eye"></i>
                                </button>
                                <div class="page-content page-container" id="page-content">
                                    <div class="padding">
                                        <div class="col-lg-12 grid-margin stretch-card">
                                            <div class="card-body">
                                                <h4 class="card-title"><label class="badge badge-secondary">REPORTE ACTIVOS</label></h4>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>TOTAL</th>
                                                                <th v-for="data in areas" :key="data.id">{{data.AREA}}</th>
                                                                <th>CREADOS EN EL MES</th>
                                                                <th>CERRADOS EN EL MES</th>
                                                                <th>COBERTURA TOTAL</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{totalImpulso}}</td>
                                                                <td v-for="data in areas" :key="data.id">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>MO</th>
                                                                            <th>SE</th>
                                                                        </tr>
                                                                    </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{data.MO}}</td>
                                                                <td>{{data.SE}}</td>
                                                            </tr>
                                                        </tbody>
                                                        </td>
                                                        <td>{{totalCreadosMesImpulso}}</td>
                                                        <td>{{totalCerradosMesImpulso}}</td>
                                                        <td>{{coberturaTotalImpulso}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h4 class="card-title"><label class="badge badge-primary">HISTÓRICO DE COBERTURA/ASITENCIA</label></h4>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th v-for="data in meses" :key="data.id">{{data.nombre}}</th>
                                                                <th>ACUMULADO</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>ATENDIDOS</th>
                                                                <td v-for="data in meses" :key="data.id">{{data.atendidos}}</td>
                                                                <td>{{acumuladoBeneficiariosAtendidosAnio}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>INSCRITOS</th>
                                                                <td v-for="data in meses" :key="data.id">{{data.inscritos}}</td>
                                                                <td>{{acumuladoBeneficiariosInscritosAnio}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>PORCENTAJE</th>
                                                                <td v-for="data in meses" :key="data.id">{{data.porcentaje}}</td>
                                                                <td>{{porcentajeAcumuladoBeneficiarios}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="page-content page-container" id="page-content">
                                    <div class="padding">
                                        <div class="col-lg-12 grid-margin stretch-card">
                                            <div class="card-body">
                                                <h4 class="card-title"><label class="badge badge-success">POR AREA</label></h4>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>AREA</th>
                                                                <th>ATENDIDOS</th>
                                                                <th>REGISTRADOS</th>
                                                                <th>PORCENTAJE</th>
                                                                <th>NIVEL DE ATENCIÓN</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="data in porAreas" :key="data.id">
                                                                <th>{{data.VC_Descripcion}}</th>
                                                                <td>{{data.atendidos}}</td>
                                                                <td>{{data.registrados}}</td>
                                                                <td>{{data.porcentaje}}%</td>
                                                                <td>{{data.nivel_atencion}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>TOTAL</th>
                                                                <td>{{sumaAtendidos}}</td>
                                                                <td>{{sumaRegistrados}}</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Axios from "axios";
import AmMap from "ammap3";
import $ from "jquery";
import pruebas from '../reportes/general';
import {
    result
} from "lodash";
export default {
    data() {
        return {
            mostrar_reporte: 1,
            base: "",
            anio: "",
            mes: "",
            totalAtendidos: 0,
            totalInscritos: 0,
            areas: [],
            meses: [],
            porAreas: [],
            totalCreadosMesImpulso: "",
            totalCerradosMesImpulso: "",
            totalImpulso: 0,
            acumuladoBeneficiariosAtendidosAnio: "",
            acumuladoBeneficiariosInscritosAnio: "",
            porcentajeAcumuladoBeneficiarios: "",
            sumaAtendidos: 0,
            sumaRegistrados: 0,
            coberturaTotalImpulso: 0,
            tipoReporte: 0,
            tipoCarga: 0,
            observacion: "",
            fechaObservacion: "",
            modal: 0,
            tituloModal: '',
            arrayObservaciones: [],
            arrayAnios: [],
            arrayMeses: [],

        };
    },
    components: {
        pruebas
    },
    mounted() {
        this.obtenerAniosMeses();
    },
    methods: {
        obtenerAniosMeses() {
            let me = this;
            var url = 'cargarAniosMeses';
            axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayAnios = respuesta.anios;
                    me.arrayMeses = respuesta.meses;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case 'data': {
                    switch (accion) {
                        case 'observaciones': {
                            this.modal = 1;
                            this.tituloModal = 'Observaciones';
                            this.observacionesLinea();
                            break;
                        }
                    }
                }
            }
        },
        cerrarModal() {
            this.modal = 0;
        },

        observacionesLinea() {
            let me = this;
            var url = 'observaciones_linea?anio=' + me.anio.PK_Id_Tabla + '&mes=' + me.mes.PK_Id_Tabla + '&lineaAtencion=' + 1237;
            axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayObservaciones = respuesta.data;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },

        guardarObservacion: function () {
            let me = this;
            axios
                .post("guardarObservacion", {
                    FK_parametro_detalle_linea: 1237,
                    FK_colegio: null,
                    FK_parametro_detalle_anio: me.anio.PK_Id_Tabla,
                    FK_parametro_detalle_mes: me.mes.PK_Id_Tabla,
                    tx_observacion: me.observacion
                })
                .then(function (response) {
                    Swal.fire(
                        'Muy bien!',
                        'Observación registrada!',
                        'success'
                    )
                })
                .catch(function (error, otracosa) {});
        },
        volverAtras() {
            window.location.href = "/sif/framework/reportes/monitoreo";
        },
        tipoReportesCarga() {
            this.tipoReporte = 1
        },
        tipoReportesPDF() {
            this.tipoReporte = 2
        },
        mostrarReportes(data) {
            this.mostrar_reporte = data;
        },
        mensaje() {
            Swal.fire({
                title: "Generando reporte",
                text: "Espere un poco por favor",
                imageUrl: "../public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false,
                backdrop: `rgba(0,0,123,0.4)`
            });
        },
        async reporte() {
            this.mensaje();
            let me = this;
            var url_graficos = 'atendidos_inscritos_impulso?anio=' + me.anio.VC_Descripcion + '&mes=' + me.mes.FK_Value;
            let grafico = await axios.get(url_graficos);
            const respuesta = grafico.data;
            const arrayLabels = [];
            const arrayAtendidos = [];
            const arrayInscritos = [];
            me.totalAtendidos = 0;
            me.totalInscritos = 0;
            for (var i = 0; i < respuesta.data.length; i++) {
                arrayLabels.push(respuesta.data[i].VC_Descripcion);
                arrayAtendidos.push(respuesta.data[i].atendidos);
                arrayInscritos.push(respuesta.data[i].registrados);
                me.totalAtendidos = me.totalAtendidos + (parseInt(respuesta.data[i].atendidos))
                me.totalInscritos = me.totalInscritos + (parseInt(respuesta.data[i].registrados))
            }
            const graficoBar = {
                type: 'bar',
                data: {

                    labels: arrayLabels,
                    datasets: [{
                            label: 'ATENDIDOS',
                            data: arrayAtendidos
                        },
                        {
                            label: 'REGISTRADOS/INSCRITOS',
                            data: arrayInscritos
                        }
                    ]
                }
            }
            const graficoPie = {
                type: 'pie',
                data: {

                    labels: ["ATENDIDOS", "REGISTRADOS/INSCRITOS"],
                    datasets: [{
                        data: [me.totalAtendidos, me.totalInscritos]
                    }]
                }
            }
            if (me.tipoReporte == 2) {
                const bar = "https://quickchart.io/chart?c=" + JSON.stringify(graficoBar);
                const pie = "https://quickchart.io/chart?c=" + JSON.stringify(graficoPie);
                var url = 'reportePDFImpulso?anio=' + me.anio.VC_Descripcion + '&mes=' + me.mes.FK_Value + '&bar=' + bar + '&pie=' + pie + '&filtro=' + 2 + '&anioId=' + me.anio.PK_Id_Tabla + '&mesId=' + me.mes.PK_Id_Tabla;
                axios
                    .get(url, {
                        responseType: 'blob',
                        Accept: 'application/pdf',
                    })
                    .then((response) => {
                        Swal.close();
                        const url = window.URL.createObjectURL(new Blob([response.data], {
                            type: 'application/pdf'
                        }));
                        const link = document.createElement('a');
                        console.log(link);
                        link.href = url;
                        link.setAttribute('download', 'reporte.pdf'); //or any other extension
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => {
                        me.loading = false;
                    });
            }
            if (me.tipoReporte == 1) {
                var url = 'cargarPDFImpulso?anio=' + me.anio.VC_Descripcion + '&mes=' + me.mes.FK_Value + '&filtro=' + 1 + '&anioId=' + me.anio.PK_Id_Tabla + '&mesId=' + me.mes.PK_Id_Tabla;
                axios.get(url).then(function (response) {
                        Swal.close();
                        const respuesta = response.data;
                        me.areas = respuesta.areas;
                        me.meses = respuesta.meses;
                        me.porAreas = respuesta.porAreas;
                        me.totalCreadosMesImpulso = respuesta.totalCreadosMesImpulso;
                        me.totalCerradosMesImpulso = respuesta.totalCerradosMesImpulso;
                        me.totalImpulso = respuesta.totalImpulso;
                        me.coberturaTotalImpulso = respuesta.coberturaTotalImpulso;
                        me.acumuladoBeneficiariosAtendidosAnio = respuesta.acumuladoBeneficiariosAtendidosAnio;
                        me.acumuladoBeneficiariosInscritosAnio = respuesta.acumuladoBeneficiariosInscritosAnio;
                        me.porcentajeAcumuladoBeneficiarios = respuesta.porcentajeAcumuladoBeneficiarios;
                        me.sumaAtendidos = respuesta.sumaAtendidos;
                        me.sumaRegistrados = respuesta.sumaRegistrados;
                        me.observacion = respuesta.observaciones;
                        me.fechaObservacion = respuesta.fecha_observacion;

                    })
                    .catch(function (error) {
                        var response = error.response.data;
                    });
            }
        },
    },
};
</script>
