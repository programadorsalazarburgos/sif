<template>
<div>
    <div class="content-header" style="padding:5px !important">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">{{ ubicacion }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2 text-center" v-if="filtros_indicadores.includes('SL_ANIO')">
            <label style="margin-bottom:0">AÑO</label>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2" v-if="filtros_indicadores.includes('SL_ANIO')">
            <multiselect v-model="SL_ANIO" @input="selectChanged($event, 'SL_ANIO', '')" :options="options_anio" label="text" track-by="value" id="SL_ANIO" name="SL_ANIO"></multiselect>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
            <button class="btn btn-primary" v-on:click="executeSectionQueries"><span class="fa fa-search"></span></button>
        </div>
    </div>
    <div class="row">
        <div v-for="indicador of indicadores" :class="indicador.width">
            <div class="card">
                <div class="card-header">
                    <small class="m-0"><b>{{indicador.tipo_indicador}}</b></small>
                    <h5 class="m-0"><b>{{indicador.titulo}}</b><small>
                    <small class="m-0" v-if="indicador.tipo_indicador == 'SEGUIMIENTO PROYECTO'"><b>(META: {{indicador.magnitud}}) {{indicador.tipo_avance}}</b></small>
                            <div class="row" v-for="filtro of indicador.filtros">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_MES')">
                                    <multiselect v-model="SL_MES" @input="selectChanged($event, 'SL_MES', indicador.index)" :options="options_mes" label="text" track-by="value" id="SL_MES" name="SL_MES"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_LINEA_CREA')">
                                    <multiselect v-model="SL_LINEA_CREA" @input="selectChanged($event, 'SL_LINEA_CREA', indicador.index)" :options="options_linea_crea" label="text" track-by="value" id="SL_LINEA_CREA" name="SL_LINEA_CREA"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_CREA')">
                                    <multiselect v-model="SL_CREA" @input="selectChanged($event, 'SL_CREA', indicador.index)" :options="options_crea" label="text" track-by="value" id="SL_CREA" name="SL_CREA"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_COLEGIO')">
                                    <multiselect v-model="SL_COLEGIO" @input="selectChanged($event, 'SL_COLEGIO', indicador.index)" :options="options_colegio" label="text" track-by="value" id="SL_COLEGIO" name="SL_COLEGIO"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_LOCALIDAD')">
                                    <multiselect v-model="SL_LOCALIDAD" @input="selectChanged($event, 'SL_LOCALIDAD', indicador.index)" :options="options_localidad" label="text" track-by="value" id="SL_LOCALIDAD" name="SL_LOCALIDAD"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_GRUPO')">
                                    <multiselect v-model="SL_GRUPO" @input="selectChanged($event, 'SL_GRUPO', indicador.index)" :options="options_grupo" label="text" track-by="value" id="SL_GRUPO" name="SL_GRUPO"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_AREA_CREA')">
                                    <multiselect v-model="SL_AREA_CREA" @input="selectChanged($event, 'SL_AREA_CREA', indicador.index)" :options="options_area" label="text" track-by="value" id="SL_AREA_CREA" name="SL_AREA_CREA"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_LINEA_NIDOS')">
                                    <multiselect v-model="SL_LINEA_NIDOS" @input="selectChanged($event, 'SL_LINEA_NIDOS', indicador.index)" :options="options_linea_nidos" label="text" track-by="value" id="SL_LINEA_NIDOS" name="SL_LINEA_NIDOS"></multiselect>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" v-if="filtro.includes('SL_TERRITORIO')">
                                    <multiselect v-model="SL_TERRITORIO" @input="selectChanged($event, 'SL_TERRITORIO', indicador.index)" :options="options_territorio" label="text" track-by="value" id="SL_TERRITORIO" name="SL_TERRITORIO"></multiselect>
                                </div>
                            </div>
                        </small></h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{indicador.descripcion}}</h6>
                    <small class="m-0" v-if="indicador.tipo_indicador == 'SEGUIMIENTO PROYECTO'"><b>(El alcance a la meta del cuatrenio es del {{indicador.alcance}}%)</b></small>
                    <div v-bind:id="indicador.chartdiv" style="height:350px !important; overflow:visible !important"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import Axios from "axios";
import $ from "jquery";
import Multiselect from "vue-multiselect";
import AmMap from "ammap3";
export default {
    components: { Multiselect },
    data() {
        return {
            indicadores: [],
            seccion: null,
            id_tipo_indicador: null,
            SL_ANIO: null,
            SL_MES: null,
            SL_LINEA_CREA: null,
            SL_CREA: null,
            SL_COLEGIO: null,
            SL_LOCALIDAD: null,
            SL_GRUPO: null,
            SL_TERRITORIO: null,
            SL_LINEA_NIDOS: null,
            SL_AREA_CREA: null,
            options_anio: [],
            options_mes: [],
            options_linea_crea: [
                { value: "1", text: "ARTE EN LA ESCUELA" },
                { value: "2", text: "IMPULSO COLECTIVO" },
                { value: "3", text: "CONVERGE" }
            ],
            options_crea: [],
            options_colegio: [],
            options_localidad: [],
            options_grupo: [],
            options_area: [],
            options_linea_nidos: [],
            options_territorio: [],
            filtros_indicadores: [],
            filtros_aplicados: {
                SL_ANIO: "",
                SL_MES: "",
                SL_LINEA_CREA: "",
                SL_CREA: "",
                SL_COLEGIO: "",
                SL_LOCALIDAD: "",
                SL_GRUPO: "",
                SL_TERRITORIO: "",
                SL_LINEA_NIDOS: "",
                SL_AREA_CREA: ""
            },
            ubicacion: ""
        };
    },
    created() {
        var currentUrl = window.location.pathname;
        var array_url = currentUrl.split("/");
        this.seccion = array_url[5];
        this.id_tipo_indicador = array_url[6];
        this.getIndicadores(new Date().getFullYear());
        window.AmCharts.baseHref = true;
        axios
            .post("/sif/framework/options/getParametroDetalle", {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                FK_Id_Parametro: 7
            })
            .then(response => {
                this.options_anio = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    mounted() {
        this.getFiltrosIndicadores(new Date().getFullYear());
    },
    methods: {
        getIndicadores(year) {
            this.indicadores = [];
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/indicadores/getIndicadores",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_tipo_indicador: this.id_tipo_indicador,
                        seccion: this.seccion,
                        year: year
                    }
                )
                .then(response => {
                    for (let index = 0; index < response.data.length; index++) {
                        var avance = JSON.parse(response.data[index]["TX_Avance"]);
                        var tipo_avance = response.data[index]["VC_Tipo_Avance"];
                        avance != null ? avance = avance[year] : avance = null;
                        
                        if(tipo_avance == 'ACUMULADO'){
                            var mayor = 0;
                            $.each(avance, function(i, val) {
                                if(parseFloat(val) > mayor){
                                    mayor = parseFloat(val);
                                }
                            });
                            var alcance = parseFloat(mayor*100/response.data[index]["IN_magnitud"]).toFixed(2);
                        }
                        if(tipo_avance == 'SUMATORIA'){
                            var total = 0;
                            $.each(avance, function(i, val) {
                                    total = total + parseFloat(val);
                            });
                            var alcance = parseFloat(total*100/response.data[index]["IN_magnitud"]).toFixed(2);
                        }

                        this.indicadores.push({
                            index: index,
                            numeral: response.data[index]["VC_numeral"],
                            tipo_indicador:
                                response.data[index]["VC_Descripcion"],
                            titulo: response.data[index]["VC_titulo"],
                            descripcion: response.data[index]["TX_descripcion"],
                            tipo_grafico:
                                response.data[index]["VC_tipo_grafico"],
                            descripcion_filtros:
                                response.data[index]["VC_descripcion_filtros"],
                            filtros:
                                response.data[index]["VC_filtros"] != null
                                    ? response.data[index]["VC_filtros"].split(
                                          ","
                                      )
                                    : response.data[index]["VC_filtros"],
                            sql: response.data[index]["TX_sql"],
                            avance: response.data[index]["TX_Avance"],
                            tipo_avance: response.data[index]["VC_Tipo_Avance"],
                            magnitud: response.data[index]["IN_magnitud"],
                            alcance: alcance,
                            chartdiv: "chartdiv_" + index,
                            width: response.data[index]["VC_width"],
                            required: ""
                        });
                    }
                    var programa = "";
                    if (this.seccion == "1") {
                        this.ubicacion =
                            "Centro de Monitoreo / CREA / " +
                            this.indicadores[0]["tipo_indicador"];
                    }
                    if (this.seccion == "2") {
                        this.ubicacion =
                            "Centro de Monitoreo / NIDOS / " +
                            this.indicadores[0]["tipo_indicador"];
                    }
                    if (this.seccion == "3") {
                        this.ubicacion =
                            "Centro de Monitoreo / Culturas en Común / " +
                            this.indicadores[0]["tipo_indicador"];
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getFiltrosIndicadores(year) {
            var filtros = "";
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/indicadores/getFiltrosIndicadores",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        seccion: this.seccion,
                        id_tipo_indicador: this.id_tipo_indicador,
                        year: year
                    }
                )
                .then(response => {
                    filtros = response.data[0].filtros;
                    this.filtros_indicadores = filtros.split(",");
                })
                .catch(error => {
                    console.log(error);
                });
            this.llenarFiltros();
        },
        llenarFiltros() {
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    FK_Id_Parametro: 8
                })
                .then(response => {
                    this.options_mes = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    FK_Id_Parametro: 19
                })
                .then(response => {
                    this.options_localidad = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            axios
                .post("/sif/framework/options/getCentrosCrea", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
                .then(response => {
                    this.options_crea = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            axios
                .post("/sif/framework/options/getLineasNidos", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
                .then(response => {
                    this.options_linea_nidos = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    FK_Id_Parametro: 43
                })
                .then(response => {
                    this.options_territorio = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    FK_Id_Parametro: 6
                })
                .then(response => {
                    this.options_area = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        selectChanged(event, id, index_indicador) {
            if (id != "SL_ANIO") {
                //var filtros = {id:event.value};
                //this.executeSql(indicador.numeral, filtros);
                for (let index = 0; index < this.indicadores.length; index++) {
                    if (this.indicadores[index]["filtros"] != null) {
                        if (this.indicadores[index]["filtros"].includes(id)) {
                            this.executeSql(index);
                        }
                    }
                }
            }
            if (event.value != null) {
                this.filtros_aplicados[id] = event.value;
                if (id == "SL_LINEA_CREA") {
                    axios
                        .post(
                            "/sif/framework/options/getGruposAtendidosLineaAnio",
                            {
                                "X-CSRF-TOKEN": $(
                                    'meta[name="csrf-token"]'
                                ).attr("content"),
                                id_linea_atencion: event.value,
                                year: this.SL_ANIO
                            }
                        )
                        .then(response => {
                            this.options_grupo = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
                if (id == "SL_ANIO") {
                    this.getIndicadores(event.value);
                    this.getFiltrosIndicadores(event.value);
                    axios
                        .post("/sif/framework/options/getColegios", {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            year: this.SL_ANIO
                        })
                        .then(response => {
                            this.options_colegio = response.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
                //this.executeSectionQueries();
            } else {
                this.filtros_aplicados[id] = "";
            }
        },
        executeSql(index_indicador) {
            Swal.fire({
                title: "Cargando...",
                text: "Espere un poco por favor.",
                imageUrl: "/sif/framework/public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false,
                backdrop: `
                    rgba(0,0,123,0.4)
                `
            });
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/executeSQLIndicador",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        indicador: this.indicadores[index_indicador]["numeral"],
                        filtros: this.filtros_aplicados
                    }
                )
                .then(response => {
                    this.indicadores[index_indicador]["dataprovider"] =
                        response.data;
                    this.loadGraphs(index_indicador);
                    Swal.close();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        executeSectionQueries() {
            Swal.fire({
                title: "Cargando...",
                text: "Espere un poco por favor.",
                imageUrl: "/sif/framework/public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false,
                backdrop: `
                    rgba(0,0,123,0.4)
                `
            });
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/executeSectionQueries",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        filtros_aplicados: this.filtros_aplicados,
                        indicadores: this.indicadores
                    }
                )
                .then(response => {
                    Swal.close();
                    for (let index = 0; index < response.data.length; index++) {
                        if (response.data[index] == "") {
                            this.indicadores[index]["required"] =
                                " (Revisar filtros)";
                        } else {
                            this.indicadores[index]["required"] = "✔";
                        }
                        this.indicadores[index]["dataprovider"] =
                            response.data[index];
                    }
                    this.loadGraphs(null);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        loadGraphs(index_indicador) {
            if (index_indicador == null) {
                for (let index = 0; index < this.indicadores.length; index++) {
                    if (
                        this.indicadores[index]["tipo_grafico"] ==
                        "column-vertical"
                    ) {
                        this.loadColumnGraph(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"],
                            false,
                            1
                        );
                    }
                    if (
                        this.indicadores[index]["tipo_grafico"] ==
                        "column-horizontal"
                    ) {
                        this.loadColumnGraph(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"],
                            true,
                            1
                        );
                    }
                    if (
                        this.indicadores[index]["tipo_grafico"] ==
                        "multi_column"
                    ) {
                        this.loadMultiColumnGraphLineasdeAtencion(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"]
                        );
                    }
                    if (this.indicadores[index]["tipo_grafico"] == "lineal") {
                        this.loadLinealGraph(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"]
                        );
                    }
                    if (this.indicadores[index]["tipo_grafico"] == "pie") {
                        this.loadPieGraph(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"]
                        );
                    }
                    if (this.indicadores[index]["tipo_grafico"] == "gauge") {
                        this.loadGaugeGraph(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"]
                        );
                    }
                    if (
                        this.indicadores[index]["tipo_grafico"] ==
                        "multi_lineal"
                    ) {
                        this.loadMultiLinealGraph(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"]
                        );
                    }
                    if (
                        this.indicadores[index]["tipo_grafico"] ==
                        "multi_lineal_linea_atencion"
                    ) {
                        this.loadMultiLinealGraphLineaAtencion(
                            this.indicadores[index]["chartdiv"],
                            this.indicadores[index]["dataprovider"]
                        );
                    }
                }
            } else {
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] ==
                    "column-vertical"
                ) {
                    this.loadColumnGraph(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"],
                        false,
                        1
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] ==
                    "column-horizontal"
                ) {
                    this.loadColumnGraph(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"],
                        true,
                        1
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] ==
                    "multi_column"
                ) {
                    this.loadMultiColumnGraphLineasdeAtencion(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"]
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] ==
                    "lineal"
                ) {
                    this.loadLinealGraph(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"]
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] == "pie"
                ) {
                    this.loadPieGraph(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"]
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] == "gauge"
                ) {
                    this.loadGaugeGraph(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"]
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] ==
                    "multi_lineal"
                ) {
                    this.loadMultiLinealGraph(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"]
                    );
                }
                if (
                    this.indicadores[index_indicador]["tipo_grafico"] ==
                    "multi_lineal_linea_atencion"
                ) {
                    this.loadMultiLinealGraphLineaAtencion(
                        this.indicadores[index_indicador]["chartdiv"],
                        this.indicadores[index_indicador]["dataprovider"]
                    );
                }
            }
        },
        loadColumnGraph(chartdiv, dataprovider, rotate, radius) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                theme: "light",
                type: "serial",
                startDuration: 0,
                dataProvider: dataprovider,
                graphs: [
                    {
                        labelText: "[[value]]",
                        balloonText: "[[category]]: <b>[[value]]</b>",
                        fillColorsField: "color",
                        fillAlphas: 0.8,
                        lineAlpha: 0.1,
                        type: "column",
                        valueField: "Y",
                        topRadius: radius
                    }
                ],
                depth3D: 15,
                angle: 20,
                rotate: rotate,
                chartCursor: {
                    categoryBalloonEnabled: false,
                    cursorAlpha: 0,
                    zoomable: false
                },
                categoryField: "X",
                categoryAxis: {
                    gridPosition: "start",
                    labelRotation: 30
                },
                export: {
                    enabled: true
                }
            });
        },
        loadMultiColumnGraphLineasdeAtencion(chartdiv, dataprovider) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                theme: "light",
                type: "serial",
                startDuration: 0,
                dataProvider: dataprovider,
                legend: {
                    useGraphSettings: true
                },
                graphs: [
                    {
                        title: "AE",
                        balloonText: "[[category]]: <b>[[value]]</b>",
                        colorField: "color",
                        fillColors: "#238efa",
                        fillAlphas: 0.8,
                        lineAlpha: 0.1,
                        type: "column",
                        valueField: "AE"
                    },
                    {
                        title: "IC",
                        balloonText: "[[category]]: <b>[[value]]</b>",
                        colorField: "color",
                        fillColors: "#ffee42",
                        fillAlphas: 0.8,
                        lineAlpha: 0.1,
                        type: "column",
                        clustered: false,
                        columnWidth: 0.7,
                        valueField: "IC"
                    },
                    {
                        title: "CV",
                        balloonText: "[[category]]: <b>[[value]]</b>",
                        colorField: "color",
                        fillColors: "#b021fc",
                        fillAlphas: 0.8,
                        lineAlpha: 0.1,
                        type: "column",
                        clustered: false,
                        columnWidth: 0.5,
                        valueField: "CV"
                    }
                ],
                chartCursor: {
                    categoryBalloonEnabled: false,
                    cursorAlpha: 0,
                    zoomable: false
                },
                categoryField: "X",
                categoryAxis: {
                    gridPosition: "start",
                    labelRotation: 30
                },
                export: {
                    enabled: true
                }
            });
        },
        loadLinealGraph(chartdiv, dataprovider) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                theme: "light",
                type: "serial",
                marginRight: 80,
                autoMarginOffset: 20,
                marginTop: 20,
                dataProvider: dataprovider,
                valueAxes: [
                    {
                        id: "v1",
                        axisAlpha: 1
                    }
                ],
                graphs: [
                    {
                        labelText: "[[value]]",
                        useNegativeColorIfDown: true,
                        balloonText:
                            "[[category]]<br><b>Cantidad: [[value]]</b>",
                        bullet: "round",
                        bulletBorderAlpha: 1,
                        bulletBorderColor: "#FFFFFF",
                        hideBulletsCount: 50,
                        lineColor: "#d1655d",
                        lineThickness: 2,
                        negativeLineColor: "#637bb6",
                        type: "smoothedLine",
                        valueField: "Y"
                    }
                ],
                chartScrollbar: {
                    scrollbarHeight: 5,
                    backgroundAlpha: 0.1,
                    backgroundColor: "#868686",
                    selectedBackgroundColor: "#67b7dc",
                    selectedBackgroundAlpha: 1
                },
                chartCursor: {
                    valueLineEnabled: true,
                    valueLineBalloonEnabled: true
                },
                categoryField: "X",
                categoryAxis: {
                    labelRotation: 40,
                    parseDates: false,
                    axisAlpha: 0,
                    minHorizontalGap: 60
                },
                export: {
                    enabled: true
                }
            });
            chart.addListener("dataUpdated", zoomChart);

            function zoomChart() {
                if (chart.zoomToIndexes) {
                    chart.zoomToIndexes(130, dataProvider_lineal.length - 1);
                }
            }
        },
        loadMultiLinealGraphLineaAtencion(chartdiv, dataprovider) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                theme: "light",
                type: "serial",
                legend: {
                    useGraphSettings: true
                },
                marginRight: 80,
                autoMarginOffset: 20,
                marginTop: 20,
                dataProvider: dataprovider,
                valueAxes: [
                    {
                        id: "v1",
                        axisColor: "#FF6600",
                        axisThickness: 2,
                        axisAlpha: 1,
                        position: "left"
                    },
                    {
                        id: "v2",
                        axisColor: "#FF6600",
                        axisThickness: 2,
                        axisAlpha: 1,
                        position: "left"
                    },
                    {
                        id: "v3",
                        axisColor: "#FF6600",
                        axisThickness: 2,
                        axisAlpha: 1,
                        position: "left"
                    }
                ],
                graphs: [
                    {
                        title: "AE",
                        balloonText:
                            "[[category]]<br><b>Cantidad: [[value]]</b>",
                        bullet: "round",
                        bulletBorderThickness: 1,
                        bulletBorderAlpha: 1,
                        bulletBorderColor: "#FFFFFF",
                        hideBulletsCount: 50,
                        lineColor: "#67b7dc",
                        lineThickness: 2,
                        type: "smoothedLine",
                        valueField: "AE"
                    },
                    {
                        title: "IC",
                        balloonText:
                            "[[category]]<br><b>Cantidad: [[value]]</b>",
                        bullet: "square",
                        bulletBorderThickness: 1,
                        bulletBorderAlpha: 1,
                        bulletBorderColor: "#FFFFFF",
                        hideBulletsCount: 50,
                        lineThickness: 2,
                        lineColor: "#fdd400",
                        type: "smoothedLine",
                        valueField: "IC"
                    },
                    {
                        title: "CV",
                        balloonText:
                            "[[category]]<br><b>Cantidad: [[value]]</b>",
                        bullet: "triangleUp",
                        bulletBorderThickness: 1,
                        bulletBorderAlpha: 1,
                        bulletBorderColor: "#FFFFFF",
                        hideBulletsCount: 50,
                        lineThickness: 2,
                        lineColor: "#8b00e8",
                        type: "smoothedLine",
                        valueField: "CV"
                    }
                ],
                chartScrollbar: {
                    scrollbarHeight: 5,
                    backgroundAlpha: 0.1,
                    backgroundColor: "#868686",
                    selectedBackgroundColor: "#67b7dc",
                    selectedBackgroundAlpha: 1
                },
                chartCursor: {
                    valueLineEnabled: true,
                    valueLineBalloonEnabled: true
                },
                categoryField: "X",
                categoryAxis: {
                    labelRotation: 40,
                    parseDates: false,
                    axisAlpha: 0,
                    minHorizontalGap: 60
                },
                export: {
                    enabled: true
                }
            });
            chart.addListener("dataUpdated", zoomChart);

            function zoomChart() {
                if (chart.zoomToIndexes) {
                    chart.zoomToIndexes(130, dataProvider_lineal.length - 1);
                }
            }
        },
        loadPieGraph(chartdiv, dataprovider) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                type: "pie",
                theme: "light",
                dataProvider: dataprovider,
                startEffect: "elastic",
                valueField: "Y",
                titleField: "X",
                colorField: "color",
                fillAlphas: 0.7,
                outlineAlpha: 0.4,
                balloonText:
                    "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                labelRadius: 15,
                innerRadius: "50%",
                depth3D: 10,
                angle: 15,
                export: {
                    enabled: true
                }
            });
        },
        loadGaugeGraph(chartdiv, dataprovider) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                theme: "none",
                type: "serial",
                depth3D: 100,
                angle: 10,
                autoMargins: false,
                marginBottom: 100,
                marginLeft: 200,
                marginRight: 200,
                dataProvider: [
                    {
                        category:
                            dataprovider[0].X +
                            " de " +
                            dataprovider[0].Y +
                            " (" +
                            Math.round(
                                (dataprovider[0].X * 100) / dataprovider[0].Y
                            ) +
                            "%)",
                        value1: parseInt(dataprovider[0].X),
                        value2:
                            parseInt(dataprovider[0].Y) -
                            parseInt(dataprovider[0].X)
                    }
                ],
                valueAxes: [
                    {
                        stackType: "100%",
                        gridAlpha: 0
                    }
                ],
                graphs: [
                    {
                        type: "column",
                        topRadius: 1,
                        columnWidth: 1,
                        showOnAxis: true,
                        lineThickness: 2,
                        lineAlpha: 0.5,
                        lineColor: "#FFFFFF",
                        fillColors: "#8d003b",
                        fillAlphas: 0.8,
                        valueField: "value1"
                    },
                    {
                        type: "column",
                        topRadius: 1,
                        columnWidth: 1,
                        showOnAxis: true,
                        lineThickness: 2,
                        lineAlpha: 0.5,
                        lineColor: "#cdcdcd",
                        fillColors: "#cdcdcd",
                        fillAlphas: 0.5,
                        valueField: "value2"
                    }
                ],

                categoryField: "category",
                categoryAxis: {
                    axisAlpha: 0,
                    labelOffset: 0,
                    gridAlpha: 0
                },
                export: {
                    enabled: true
                }
            });
        },
        loadMultiLinealGraph(chartdiv, dataprovider) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                type: "serial",
                theme: "light",
                legend: {
                    useGraphSettings: true
                },
                dataProvider: dataprovider,
                synchronizeGrid: true,
                valueAxes: [
                    {
                        id: "v1",
                        axisColor: "#FF6600",
                        axisThickness: 2,
                        axisAlpha: 1,
                        position: "left"
                    },
                    {
                        id: "v2",
                        axisColor: "#FCD202",
                        axisThickness: 2,
                        axisAlpha: 1,
                        position: "right"
                    },
                    {
                        id: "v3",
                        axisColor: "#B0DE09",
                        axisThickness: 2,
                        gridAlpha: 0,
                        offset: 50,
                        axisAlpha: 1,
                        position: "left"
                    }
                ],
                graphs: [
                    {
                        valueAxis: "v1",
                        lineColor: "#FF6600",
                        bullet: "round",
                        bulletBorderThickness: 1,
                        hideBulletsCount: 30,
                        title: "COGNITIVO",
                        valueField: "PROMEDIO_CG",
                        fillAlphas: 0
                    },
                    {
                        valueAxis: "v2",
                        lineColor: "#FCD202",
                        bullet: "square",
                        bulletBorderThickness: 1,
                        hideBulletsCount: 30,
                        title: "ACTITUDINAL",
                        valueField: "PROMEDIO_AC",
                        fillAlphas: 0
                    },
                    {
                        valueAxis: "v3",
                        lineColor: "#B0DE09",
                        bullet: "triangleUp",
                        bulletBorderThickness: 1,
                        hideBulletsCount: 30,
                        title: "CONVIVENCIAL",
                        valueField: "PROMEDIO_CV",
                        fillAlphas: 0
                    }
                ],
                chartScrollbar: {},
                chartCursor: {
                    cursorPosition: "middle",
                    leaveCursor: true,
                    categoryBalloonEnabled: true
                },
                categoryField: "X",
                categoryAxis: {
                    parseDates: false,
                    axisColor: "#DADADA",
                    minorGridEnabled: true
                },
                export: {
                    enabled: true,
                    position: "bottom-right"
                }
            });
        }
    }
};
</script>
