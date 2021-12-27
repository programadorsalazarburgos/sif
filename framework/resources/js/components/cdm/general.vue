<template>
<div id="general">
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
        <div class="col-lg-12 text-center">
            <button class="btn btn-outline-primary btn-lg mr-3" @click="getEstadisticasAnio(year)" v-for="year of years">{{ year }}</button>
        </div>
    </div>
    <div class="progress" style="background-color: #b3b3b5; margin-top: 1px">
        <div id="progressbar_alcance_cobertura_2016" class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <b><p style="margin-top: 15px; text-align:left;">{{ alcance_cobertura_cuatrenio_2016 }}</p></b></div>
    </div>
    <div class="progress" style="background-color: #b3b3b5; margin-top: 1px">
        <div id="progressbar_alcance_cobertura_2020" class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
        <b><p style="margin-top: 15px; text-align:left;">{{ alcance_cobertura_cuatrenio_2020 }}</p></b></div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0"><b>SUBDIRECCIÓN DE FORMACIÓN ARTÍSTICA | {{ year }}</b></h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{ totalsubdireccion}} BENEFICIARIOS ATENDIDOS</h6>
                    <p class="card-text">Esta cifra incluye los beneficiarios del programa CREA, NIDOS y CULTURAS EN COMÚN.</p>
                    <img src="/sif/framework/public/images/logo_crea.png" width="20%">&nbsp &nbsp &nbsp
                    <img src="/sif/framework/public/images/logo_nidos.png" width="25%">
                    <img src="/sif/framework/public/images/logo_culturas_color.png" width="25%">
                </div>
            </div>
        </div>
        <div class="col-lg-6">

            <div id="chartdiv"></div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body" style="height:300px">
                    <h5 class="card-title"><b>PROGRAMA CREA | {{ year }}</b></h5>
                    <p class="card-text">
                        {{ totalcrea }} BENEFICIARIOS ATENDIDOS.
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 border-right" style="height: 200px !important;">
                            <span v-for="cifra of cifrascrea">
                                <b><i>{{ cifra.linea }}</i></b> : {{ cifra.cantidad }}.<br>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <b><i>Porcentaje Alcance a Meta Anual</i></b>
                            <div id="chartdiv_alcance_crea"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body" style="height:300px">
                    <h5 class="card-title"><b>PROGRAMA NIDOS | {{ year }}</b></h5>
                    <p class="card-text">
                        {{ totalnidos }} BENEFICIARIOS ATENDIDOS.
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 border-right" style="height: 200px !important;">
                            <span class="card-text" v-for="cifra of cifrasnidos">
                                <b><i>{{ cifra.linea }}</i></b> : {{ cifra.cantidad }}.<br>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <b><i>Porcentaje Alcance a Meta Anual</i></b>
                            <div id="chartdiv_alcance_nidos"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div id="mapdiv" hidden="hidden" style="width: 100%; background-color:#eeeeee; height: 500px;">
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
import { result } from "lodash";
export default {
    data() {
        return {
            year: "Año",
            years: [
                "2016",
                "2017",
                "2018",
                "2019",
                "2020",
                "2020-I",
                "2020-II",
                "2021"
            ],
            cuatrenio: "",
            alcance_cobertura_cuatrenio_2016: "",
            alcance_cobertura_cuatrenio_2020: "",
            totalsubdireccion: 0,
            cifrascrea: [],
            cifrasnidos: [],
            totalcrea: 0,
            totalnidos: 0,
            map: null,
            selectedValue: null,
            selected: null,
            options: [
                { value: null, text: "Please select an option" },
                { value: "a", text: "This is First option" },
                { value: "b", text: "Selected Option" },
                {
                    value: { C: "3PO" },
                    text: "This is an option with object value"
                },
                { value: "d", text: "This one is disabled", disabled: true }
            ],
            ubicacion: "Centro de Monitoreo / General"
        };
    },
    mounted() {
        var d = new Date();
        this.year = d.getFullYear();
        this.getEstadisticasAnio(this.year);
        this.getCoberturaCuatrenio("2.1.8.4", "2016-II");
        this.getCoberturaCuatrenio("2.1.8.7", "2020-II");
        this.map = window.AmCharts.makeChart("mapdiv", {
            type: "map",
            dataProvider: {
                mapURL:
                    "/sif/framework/public/images/mapas/LocalidadesBogota.svg",
                getAreasFromMap: true,
                zoomLevel: 0.95,
                areas: [
                    {
                        title: "USAQUEN",
                        id: "CO-BO1",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 1 <br><b>Crea:</b> <div id='USAQUEN' name='USAQUEN'>1005</div>"
                    },
                    {
                        title: "CHAPINERO",
                        id: "CO-BO2",
                        color: "#29abe2",
                        customData:
                            "<b>Nidos:</b> 2 <br><b>Crea:</b> <div id='CHAPINERO' name='CHAPINERO'></div>"
                    },
                    {
                        title: "BARRIOS UNIDOS",
                        id: "CO-BO3",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 3 <br><b>Crea:</b> <div id='BARRIOSUNIDOS' name='BARRIOSUNIDOS'></div>"
                    },
                    {
                        title: "TEUSAQUILLO",
                        id: "CO-BO4",
                        color: "#00a99d",
                        customData:
                            "<b>Nidos:</b> 4 <br><b>Crea:</b> <div id='TEUSAQUILLO' name='TEUSAQUILLO'></div>"
                    },
                    {
                        title: "SUBA",
                        id: "CO-BO5",
                        color: "#00a99d",
                        customData:
                            "<b>Nidos:</b> 5 <br><b>Crea:</b> <div id='SUBA' name='SUBA'></div>"
                    },
                    {
                        title: "ENGATIVA",
                        id: "CO-BO6",
                        color: "#2e3192",
                        customData:
                            "<b>Nidos:</b> 6 <br><b>Crea:</b> <div id='ENGATIVA' name='ENGATIVA'></div>"
                    },
                    {
                        title: "FONTIBON",
                        id: "CO-BO7",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 7 <br><b>Crea:</b> <div id='FONTIBON' name='FONTIBON'></div"
                    },
                    {
                        title: "CANDELARIA",
                        id: "CO-BO8",
                        color: "#5e6c68",
                        customData:
                            "<b>Nidos:</b> 8 <br><b>Crea:</b> <div id='CANDELARIA' name='CANDELARIA'></div>"
                    },
                    {
                        title: "SANTA FE",
                        id: "CO-BO9",
                        color: "#2e3192",
                        customData:
                            "<b>Nidos:</b> 9 <br><b>Crea:</b> <div id='SANTAFE' name='SANTAFE'></div>"
                    },
                    {
                        title: "MARTIRES",
                        id: "CO-BO10",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 10 <br><b>Crea:</b> <div id='MARTIRES' name='MARTIRES'></div>"
                    },
                    {
                        title: "ANTONIO NARIÑO",
                        id: "CO-BO11",
                        color: "#29abe2",
                        customData:
                            "<b>Nidos:</b> 11 <br><b>Crea:</b> <div id='ANTONIONARIÑO' name='ANTONIONARIÑO'></div>"
                    },
                    {
                        title: "PUENTE ARANDA",
                        id: "CO-BO12",
                        color: "#5e6c68",
                        customData:
                            "<b>Nidos:</b> 12 <br><b>Crea:</b> <div id='PUENTEARANDA' name='PUENTEARANDA'></div>"
                    },
                    {
                        title: "RAFAEL URIBE URIBE",
                        id: "CO-BO13",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 13 <br><b>Crea:</b> <div id='RAFAELURIBEURIBE' name='RAFAELURIBEURIBE'></div>"
                    },
                    {
                        title: "SAN CRISTOBAL",
                        id: "CO-BO14",
                        color: "#00a99d",
                        customData:
                            "<b>Nidos:</b> 14 <br><b>Crea:</b> <div id='SANCRISTOBAL' name='SANCRISTOBAL'></div>"
                    },
                    {
                        title: "SUMAPAZ",
                        id: "CO-BO15",
                        color: "#01937c",
                        customData:
                            "<b>Nidos:</b> 15 <br><b>Crea:</b> <div id='SUMAPAZ' name='SUMAPAZ'></div>"
                    },
                    {
                        title: "USME",
                        id: "CO-BO16",
                        color: "#89ddaf",
                        customData:
                            "<b>Nidos:</b> 16 <br><b>Crea:</b> <div id='USME' name='USME'>200</div>"
                    },
                    {
                        title: "TUNJUELITO",
                        id: "CO-BO17",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 17 <br><b>Crea:</b> <div id='TUNJUELITO' name='TUNJUELITO'></div>"
                    },
                    {
                        title: "CIUDAD BOLIVAR",
                        id: "CO-BO18",
                        color: "#01937c",
                        customData:
                            "<b>Nidos:</b> 18 <br><b>Crea:</b> <div id='CIUDADBOLIVAR' name='CIUDADBOLIVAR'></div>"
                    },
                    {
                        title: "KENNEDY",
                        id: "CO-BO19",
                        color: "#29abe2",
                        customData:
                            "<b>Nidos:</b> 19 <br><b>Crea:</b> <div id='KENNEDY' name='KENNEDY'></div>"
                    },
                    {
                        title: "BOSA",
                        id: "CO-BO20",
                        color: "#00547b",
                        customData:
                            "<b>Nidos:</b> 20 <br><b>Crea:</b> <div id='BOSA' name='BOSA'></div>"
                    }
                ]
            },
            areasSettings: {
                autoRotateAngle: 90,
                autoZoom: true,
                unlistedAreasColor: "#357566",
                rollOverOutlineColor: "#eeeeee",
                rollOverColor: "#357566",
                rollOutlineAlpha: 3,
                rollOutlineColor: "#eeeeee",
                rollOutlineThickness: 5,
                selectedColor: "#115f3e",
                balloonText: "<b>[[title]]</b><br> [[customData]]"
            },
            imagesSettings: {
                labelPosition: "top",
                labelFontSize: 9,
                labelColor: "#000000",
                labelRollOverColor: "#000000"
            },
            zoomControl: {
                minZoomLevel: 0.9
            },
            titles: "Bogotá"
        });

        this.map.addListener("init", () => {
            this.map.dataProvider.images = [];
            for (var x in this.map.dataProvider.areas) {
                var area = this.map.dataProvider.areas[x];
                var image = new AmCharts.MapImage();
                image.latitude = this.map.getAreaCenterLatitude(area);
                image.longitude = this.map.getAreaCenterLongitude(area);
                image.width = 30;
                image.height = 17;
                image.label = area.title;
                image.linkToObject = area;
                if (area.title == "USAQUEN") {
                    image.latitude = image.latitude + 0.2;
                }
                if (area.title == "CHAPINERO") {
                    image.latitude = image.latitude - 0.7;
                }
                if (area.title == "SUBA") {
                    image.latitude = image.latitude + 28;
                    image.longitude = image.longitude + 15;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "BARRIOS UNIDOS") {
                    image.latitude = image.latitude + 3;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "TEUSAQUILLO") {
                    image.latitude = image.latitude + 1;
                    image.longitude = image.longitude + 3;
                }
                if (area.title == "ENGATIVA") {
                    image.latitude = image.latitude + 55;
                    image.longitude = image.longitude + 15;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "FONTIBON") {
                    image.latitude = image.latitude - 15;
                    image.longitude = image.longitude - 5;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "KENNEDY") {
                    image.latitude = image.latitude + 15;
                    image.longitude = image.longitude + 10;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "BOSA") {
                    image.latitude = image.latitude - 3.1;
                    image.longitude = image.longitude + 5;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "TUNJUELITO") {
                    image.latitude = image.latitude + 8;
                    image.longitude = image.longitude - 15;
                }
                if (area.title == "CIUDAD BOLIVAR") {
                    image.latitude = image.latitude + 13;
                    image.longitude = image.longitude + 13;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "USME") {
                    image.latitude = image.latitude - 11;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "SANTA FE") {
                    image.latitude = image.latitude + 1.9;
                    image.longitude = image.longitude - 15;
                }
                if (area.title == "CANDELARIA") {
                    image.latitude = image.latitude + 2;
                }
                if (area.title == "RAFAEL URIBE URIBE") {
                    image.latitude = image.latitude + 2;
                    image.label = "RAFAEL URIBE\nURIBE";
                    image.longitude = image.longitude - 7;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "ANTONIO NARIÑO") {
                    image.latitude = image.latitude + 25;
                    image.label = "ANTONIO\nNARIÑO";
                    image.longitude = image.longitude;
                }
                if (area.title == "MARTIRES") {
                    image.latitude = image.latitude + 1;
                    image.longitude = image.longitude + 3;
                    image.imageURL =
                        "http://talento.crea.gov.co/talento/imagenes/menu/logo-crea-header.png";
                }
                if (area.title == "SUMAPAZ") {
                    image.longitude = image.longitude + 3;
                }
                this.map.dataProvider.images.push(image);
            }
            this.map.validateData();
            //console.log( this.map.dataProvider );
        });
        this.map.addListener("clickMapObject", handleMapObjectClick);
        //console.log(this.map.dataProvider);
        this.cargarMapa();
    },
    methods: {
        getEstadisticasAnio(year) {
            this.year = year;
            Swal.fire({
                title: "Cargando información",
                text: "Espere un poco por favor.",
                imageUrl: "public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false,
                backdrop: `
                    rgba(0,0,123,0.4)
                `
            });
            var d = new Date();
            var actual_year = d.getFullYear();
            var selectedyear = "" + this.year;
            if (selectedyear.includes(actual_year)) {
                this.getEstadisticasAnioActual();
            } else {
                this.getEstadisticasAnioAnterior();
            }
        },
        getCoberturaCuatrenio(numeral_indicador, filtros) {
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/executeSQLIndicador",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        indicador: numeral_indicador,
                        filtros: null
                    }
                )
                .then(response => {
                    if (filtros == "2016-II") {
                        var porcentaje = Math.trunc(
                            (response.data[0].X * 100) / response.data[0].Y
                        );
                        this.alcance_cobertura_cuatrenio_2016 +=
                            " " +
                            porcentaje +
                            "% " +
                            "COBERTURA CUATRENIO 2016-II A 2020-I (" +
                            response.data[0].X +
                            " / " +
                            response.data[0].Y +
                            ")";
                        $("#progressbar_alcance_cobertura_2016").css(
                            "width",
                            porcentaje + "%"
                        );
                    }
                    if (filtros == "2020-II") {
                        var porcentaje = Math.trunc(
                            (response.data[0].X * 100) / response.data[0].Y
                        );
                        this.alcance_cobertura_cuatrenio_2020 +=
                            " " +
                            porcentaje +
                            "% " +
                            "COBERTURA CUATRENIO 2020-II A 2024-I (" +
                            response.data[0].X +
                            " / " +
                            response.data[0].Y +
                            ")";
                        $("#progressbar_alcance_cobertura_2020").css(
                            "width",
                            porcentaje + "%"
                        );
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getEstadisticasAnioActual() {
            axios
                .post("centro-de-monitoreo/getEstadisticasAnioActual", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    year: this.year
                })
                .then(response => {
                    Swal.close();
                    var total_subdireccion = 0;
                    var total_crea = 0;
                    var total_nidos = 0;
                    this.cifrascrea = [];
                    this.cifrasnidos = [];
                    for (let index = 0; index < response.data.length; index++) {
                        total_subdireccion += response.data[index]["CANTIDAD"];
                        if (response.data[index]["PROGRAMA"] == "CREA") {
                            this.cifrascrea.push({
                                programa: response.data[index]["PROGRAMA"],
                                linea: response.data[index]["LINEA"],
                                cantidad: response.data[index]["CANTIDAD"]
                            });
                            total_crea += response.data[index]["CANTIDAD"];
                        }
                        if (response.data[index]["PROGRAMA"] == "NIDOS") {
                            this.cifrasnidos.push({
                                programa: response.data[index]["PROGRAMA"],
                                linea: response.data[index]["LINEA"],
                                cantidad: response.data[index]["CANTIDAD"]
                            });
                            total_nidos += response.data[index]["CANTIDAD"];
                        }
                        var nombre_linea = response.data[index]["LINEA"].split(
                            " "
                        );
                        var linea = response.data[index]["PROGRAMA"] + " - ";
                        for (let i = 0; i < nombre_linea.length; i++) {
                            if (
                                response.data[index]["LINEA"] !=
                                "ARTE EN LA ESCUELA"
                            ) {
                                linea += nombre_linea[i].charAt(0);
                            } else {
                                linea =
                                    response.data[index]["PROGRAMA"] +
                                    " - " +
                                    "AE";
                            }
                        }
                        response.data[index]["SIGLAS_LINEA"] = linea;
                    }
                    this.totalsubdireccion = total_subdireccion;
                    this.totalcrea = total_crea;
                    this.totalnidos = total_nidos;

                    this.cargarGraficadePie("light", "chartdiv", response.data);
                    this.getAlcanceCoberturaAnualCREA();
                    this.getAlcanceCoberturaAnualNIDOS();
                })
                .catch(error => {
                    console.log(error);
                });
            this.cargarMapa();
        },
        getEstadisticasAnioAnterior() {
            axios
                .post("centro-de-monitoreo/getEstadisticasAnioAnterior", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    year: this.year
                })
                .then(response => {
                    Swal.close();
                    var total_subdireccion = 0;
                    var total_crea = 0;
                    var total_nidos = 0;
                    this.cifrascrea = [];
                    this.cifrasnidos = [];
                    for (let index = 0; index < response.data.length; index++) {
                        total_subdireccion += response.data[index]["CANTIDAD"];
                        if (response.data[index]["PROGRAMA"] == "CREA") {
                            this.cifrascrea.push({
                                programa: response.data[index]["PROGRAMA"],
                                linea: response.data[index]["LINEA"],
                                cantidad: response.data[index]["CANTIDAD"]
                            });
                            total_crea += response.data[index]["CANTIDAD"];
                        }
                        if (response.data[index]["PROGRAMA"] == "NIDOS") {
                            this.cifrasnidos.push({
                                programa: response.data[index]["PROGRAMA"],
                                linea: response.data[index]["LINEA"],
                                cantidad: response.data[index]["CANTIDAD"]
                            });
                            total_nidos += response.data[index]["CANTIDAD"];
                        }
                        var nombre_linea = response.data[index]["LINEA"].split(
                            " "
                        );
                        var linea = response.data[index]["PROGRAMA"] + " - ";
                        for (let i = 0; i < nombre_linea.length; i++) {
                            if (
                                response.data[index]["LINEA"] !=
                                "ARTE EN LA ESCUELA"
                            ) {
                                linea += nombre_linea[i].charAt(0);
                            } else {
                                linea =
                                    response.data[index]["PROGRAMA"] +
                                    " - " +
                                    "AE";
                            }
                        }
                        response.data[index]["SIGLAS_LINEA"] = linea;
                    }
                    this.totalsubdireccion = total_subdireccion;
                    this.totalcrea = total_crea;
                    this.totalnidos = total_nidos;

                    this.cargarGraficadePie("light", "chartdiv", response.data);
                    this.getAlcanceCoberturaAnualCREA();
                    this.getAlcanceCoberturaAnualNIDOS();
                })
                .catch(error => {
                    console.log(error);
                });
            this.cargarMapa();
        },
        cargarGraficadePie(tema, chartname, datos) {
            if (tema == "dark") {
            } else {
                $(".modal-body").css("backgroundColor", "#ffffff");
                $(".modal-body").css("color", "#000");
            }
            var chart = window.AmCharts.makeChart(chartname, {
                type: "pie",
                theme: tema,
                dataProvider: datos,
                valueField: "CANTIDAD",
                titleField: "SIGLAS_LINEA",
                outlineAlpha: 0,
                depth3D: 15,
                balloonText:
                    "[[PROGRAMA]]-[[LINEA]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                angle: 50,
                export: {
                    enabled: true
                }
            });

            var chart = window.AmCharts.makeChart("chartdiv_alcance_crea", {
                type: "pie",
                theme: tema,
                dataProvider: datos,
                valueField: "CANTIDAD",
                titleField: "SIGLAS_LINEA",
                outlineAlpha: 0,
                depth3D: 15,
                balloonText:
                    "[[PROGRAMA]]-[[LINEA]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                angle: 50,
                export: {
                    enabled: true
                }
            });
        },
        getAlcanceCoberturaAnualCREA() {
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/getAlcanceCoberturaAnualCREA",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        year: this.year
                    }
                )
                .then(response => {
                    Swal.close();
                    this.graficarAlcanceCoberturaAnual(
                        "chartdiv_alcance_crea",
                        response.data["X"],
                        response.data["Y"]
                    );
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getAlcanceCoberturaAnualNIDOS() {
            axios
                .post(
                    "/sif/framework/centro-de-monitoreo/getAlcanceCoberturaAnualNIDOS",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        year: this.year
                    }
                )
                .then(response => {
                    Swal.close();
                    this.graficarAlcanceCoberturaAnual(
                        "chartdiv_alcance_nidos",
                        response.data["X"],
                        response.data["Y"]
                    );
                })
                .catch(error => {
                    console.log(error);
                });
        },
        graficarAlcanceCoberturaAnual(chartdiv, x, y) {
            var chart = window.AmCharts.makeChart(chartdiv, {
                theme: "light",
                type: "serial",
                depth3D: 100,
                angle: 10,
                autoMargins: false,
                marginBottom: 100,
                marginLeft: 40,
                marginRight: 40,
                dataProvider: [
                    {
                        category:
                            x +
                            " de " +
                            y +
                            " (" +
                            Math.round((x * 100) / y) +
                            "%)",
                        value1: parseInt(x),
                        value2: parseInt(y) - parseInt(x)
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
        cargarMapa() {
            $("#mapdiv").attr("hidden", false);
            axios
                .post("centro-de-monitoreo/getEstadisticasLocalidades", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    year: this.year
                })
                .then(response => {
                    try {
                        var json_areas = "";
                        var USAQUEN_AE = 0;
                        var CHAPINERO_AE = 0;
                        var BARRIOSUNIDOS_AE = 0;
                        var TEUSAQUILLO_AE = 0;
                        var SUBA_AE = 0;
                        var ENGATIVA_AE = 0;
                        var FONTIBON_AE = 0;
                        var CANDELARIA_AE = 0;
                        var SANTAFE_AE = 0;
                        var MARTIRES_AE = 0;
                        var ANTONIONARIÑO_AE = 0;
                        var PUENTEARANDA_AE = 0;
                        var RUU_AE = 0;
                        var SANCRISTOBAL_AE = 0;
                        var SUMAPAZ_AE = 0;
                        var USME_AE = 0;
                        var TUNJUELITO_AE = 0;
                        var CIUDADBOLIVAR_AE = 0;
                        var KENNEDY_AE = 0;
                        var BOSA_AE = 0;

                        var USAQUEN_EC = 0;
                        var CHAPINERO_EC = 0;
                        var BARRIOSUNIDOS_EC = 0;
                        var TEUSAQUILLO_EC = 0;
                        var SUBA_EC = 0;
                        var ENGATIVA_EC = 0;
                        var FONTIBON_EC = 0;
                        var CANDELARIA_EC = 0;
                        var SANTAFE_EC = 0;
                        var MARTIRES_EC = 0;
                        var ANTONIONARIÑO_EC = 0;
                        var PUENTEARANDA_EC = 0;
                        var RUU_EC = 0;
                        var SANCRISTOBAL_EC = 0;
                        var SUMAPAZ_EC = 0;
                        var USME_EC = 0;
                        var TUNJUELITO_EC = 0;
                        var CIUDADBOLIVAR_EC = 0;
                        var KENNEDY_EC = 0;
                        var BOSA_EC = 0;

                        var USAQUEN_LC = 0;
                        var CHAPINERO_LC = 0;
                        var BARRIOSUNIDOS_LC = 0;
                        var TEUSAQUILLO_LC = 0;
                        var SUBA_LC = 0;
                        var ENGATIVA_LC = 0;
                        var FONTIBON_LC = 0;
                        var CANDELARIA_LC = 0;
                        var SANTAFE_LC = 0;
                        var MARTIRES_LC = 0;
                        var ANTONIONARIÑO_LC = 0;
                        var PUENTEARANDA_LC = 0;
                        var RUU_LC = 0;
                        var SANCRISTOBAL_LC = 0;
                        var SUMAPAZ_LC = 0;
                        var USME_LC = 0;
                        var TUNJUELITO_LC = 0;
                        var CIUDADBOLIVAR_LC = 0;
                        var KENNEDY_LC = 0;
                        var BOSA_LC = 0;

                        var USAQUEN_NIDOS = 0;
                        var CHAPINERO_NIDOS = 0;
                        var BARRIOSUNIDOS_NIDOS = 0;
                        var TEUSAQUILLO_NIDOS = 0;
                        var SUBA_NIDOS = 0;
                        var ENGATIVA_NIDOS = 0;
                        var FONTIBON_NIDOS = 0;
                        var CANDELARIA_NIDOS = 0;
                        var SANTAFE_NIDOS = 0;
                        var MARTIRES_NIDOS = 0;
                        var ANTONIONARIÑO_NIDOS = 0;
                        var PUENTEARANDA_NIDOS = 0;
                        var RUU_NIDOS = 0;
                        var SANCRISTOBAL_NIDOS = 0;
                        var SUMAPAZ_NIDOS = 0;
                        var USME_NIDOS = 0;
                        var TUNJUELITO_NIDOS = 0;
                        var CIUDADBOLIVAR_NIDOS = 0;
                        var KENNEDY_NIDOS = 0;
                        var BOSA_NIDOS = 0;
                        $.each(response.data, function(i) {
                            if (response.data[i].LINEA == "AE") {
                                USAQUEN_AE +=
                                    response.data[i].LOCALIDAD == "USAQUÉN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CHAPINERO_AE +=
                                    response.data[i].LOCALIDAD == "CHAPINERO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BARRIOSUNIDOS_AE +=
                                    response.data[i].LOCALIDAD ==
                                    "BARRIOS UNIDOS"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TEUSAQUILLO_AE +=
                                    response.data[i].LOCALIDAD == "TEUSAQUILLO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUBA_AE +=
                                    response.data[i].LOCALIDAD == "SUBA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ENGATIVA_AE +=
                                    response.data[i].LOCALIDAD == "ENGATIVÁ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                FONTIBON_AE +=
                                    response.data[i].LOCALIDAD == "FONTIBÓN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CANDELARIA_AE +=
                                    response.data[i].LOCALIDAD == "CANDELARIA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANTAFE_AE +=
                                    response.data[i].LOCALIDAD == "SANTA FE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                MARTIRES_AE +=
                                    response.data[i].LOCALIDAD == "MÁRTIRES"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ANTONIONARIÑO_AE +=
                                    response.data[i].LOCALIDAD ==
                                    "ANTONIO NARIÑO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                PUENTEARANDA_AE +=
                                    response.data[i].LOCALIDAD ==
                                    "PUENTE ARANDA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                RUU_AE +=
                                    response.data[i].LOCALIDAD == "RAFAEL URIBE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANCRISTOBAL_AE +=
                                    response.data[i].LOCALIDAD ==
                                    "SAN CRISTOBAL"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUMAPAZ_AE +=
                                    response.data[i].LOCALIDAD == "SUMAPAZ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                USME_AE +=
                                    response.data[i].LOCALIDAD == "USME"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TUNJUELITO_AE +=
                                    response.data[i].LOCALIDAD == "TUNJUELITO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CIUDADBOLIVAR_AE +=
                                    response.data[i].LOCALIDAD ==
                                    "CIUDAD BOLIVAR"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                KENNEDY_AE +=
                                    response.data[i].LOCALIDAD == "KENNEDY"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BOSA_AE +=
                                    response.data[i].LOCALIDAD == "BOSA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                            }

                            if (response.data[i].LINEA == "EC") {
                                USAQUEN_EC +=
                                    response.data[i].LOCALIDAD == "USAQUÉN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CHAPINERO_EC +=
                                    response.data[i].LOCALIDAD == "CHAPINERO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BARRIOSUNIDOS_EC +=
                                    response.data[i].LOCALIDAD ==
                                    "BARRIOS UNIDOS"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TEUSAQUILLO_EC +=
                                    response.data[i].LOCALIDAD == "TEUSAQUILLO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUBA_EC +=
                                    response.data[i].LOCALIDAD == "SUBA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ENGATIVA_EC +=
                                    response.data[i].LOCALIDAD == "ENGATIVÁ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                FONTIBON_EC +=
                                    response.data[i].LOCALIDAD == "FONTIBÓN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CANDELARIA_EC +=
                                    response.data[i].LOCALIDAD == "CANDELARIA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANTAFE_EC +=
                                    response.data[i].LOCALIDAD == "SANTA FE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                MARTIRES_EC +=
                                    response.data[i].LOCALIDAD == "MÁRTIRES"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ANTONIONARIÑO_EC +=
                                    response.data[i].LOCALIDAD ==
                                    "ANTONIO NARIÑO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                PUENTEARANDA_EC +=
                                    response.data[i].LOCALIDAD ==
                                    "PUENTE ARANDA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                RUU_EC +=
                                    response.data[i].LOCALIDAD == "RAFAEL URIBE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANCRISTOBAL_EC +=
                                    response.data[i].LOCALIDAD ==
                                    "SAN CRISTOBAL"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUMAPAZ_EC +=
                                    response.data[i].LOCALIDAD == "SUMAPAZ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                USME_EC +=
                                    response.data[i].LOCALIDAD == "USME"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TUNJUELITO_EC +=
                                    response.data[i].LOCALIDAD == "TUNJUELITO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CIUDADBOLIVAR_EC +=
                                    response.data[i].LOCALIDAD ==
                                    "CIUDAD BOLIVAR"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                KENNEDY_EC +=
                                    response.data[i].LOCALIDAD == "KENNEDY"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BOSA_EC +=
                                    response.data[i].LOCALIDAD == "BOSA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                            }

                            if (response.data[i].LINEA == "LC") {
                                USAQUEN_LC +=
                                    response.data[i].LOCALIDAD == "USAQUÉN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CHAPINERO_LC +=
                                    response.data[i].LOCALIDAD == "CHAPINERO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BARRIOSUNIDOS_LC +=
                                    response.data[i].LOCALIDAD ==
                                    "BARRIOS UNIDOS"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TEUSAQUILLO_LC +=
                                    response.data[i].LOCALIDAD == "TEUSAQUILLO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUBA_LC +=
                                    response.data[i].LOCALIDAD == "SUBA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ENGATIVA_LC +=
                                    response.data[i].LOCALIDAD == "ENGATIVÁ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                FONTIBON_LC +=
                                    response.data[i].LOCALIDAD == "FONTIBÓN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CANDELARIA_LC +=
                                    response.data[i].LOCALIDAD == "CANDELARIA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANTAFE_LC +=
                                    response.data[i].LOCALIDAD == "SANTA FE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                MARTIRES_LC +=
                                    response.data[i].LOCALIDAD == "MÁRTIRES"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ANTONIONARIÑO_LC +=
                                    response.data[i].LOCALIDAD ==
                                    "ANTONIO NARIÑO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                PUENTEARANDA_LC +=
                                    response.data[i].LOCALIDAD ==
                                    "PUENTE ARANDA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                RUU_LC +=
                                    response.data[i].LOCALIDAD == "RAFAEL URIBE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANCRISTOBAL_LC +=
                                    response.data[i].LOCALIDAD ==
                                    "SAN CRISTOBAL"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUMAPAZ_LC +=
                                    response.data[i].LOCALIDAD == "SUMAPAZ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                USME_LC +=
                                    response.data[i].LOCALIDAD == "USME"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TUNJUELITO_LC +=
                                    response.data[i].LOCALIDAD == "TUNJUELITO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CIUDADBOLIVAR_LC +=
                                    response.data[i].LOCALIDAD ==
                                    "CIUDAD BOLIVAR"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                KENNEDY_LC +=
                                    response.data[i].LOCALIDAD == "KENNEDY"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BOSA_LC +=
                                    response.data[i].LOCALIDAD == "BOSA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                            }

                            if (response.data[i].LINEA == "NIDOS") {
                                USAQUEN_NIDOS +=
                                    response.data[i].LOCALIDAD == "USAQUÉN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CHAPINERO_NIDOS +=
                                    response.data[i].LOCALIDAD == "CHAPINERO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BARRIOSUNIDOS_NIDOS +=
                                    response.data[i].LOCALIDAD ==
                                    "BARRIOS UNIDOS"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TEUSAQUILLO_NIDOS +=
                                    response.data[i].LOCALIDAD == "TEUSAQUILLO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUBA_NIDOS +=
                                    response.data[i].LOCALIDAD == "SUBA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ENGATIVA_NIDOS +=
                                    response.data[i].LOCALIDAD == "ENGATIVÁ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                FONTIBON_NIDOS +=
                                    response.data[i].LOCALIDAD == "FONTIBÓN"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CANDELARIA_NIDOS +=
                                    response.data[i].LOCALIDAD == "CANDELARIA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANTAFE_NIDOS +=
                                    response.data[i].LOCALIDAD == "SANTA FE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                MARTIRES_NIDOS +=
                                    response.data[i].LOCALIDAD == "MÁRTIRES"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                ANTONIONARIÑO_NIDOS +=
                                    response.data[i].LOCALIDAD ==
                                    "ANTONIO NARIÑO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                PUENTEARANDA_NIDOS +=
                                    response.data[i].LOCALIDAD ==
                                    "PUENTE ARANDA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                RUU_NIDOS +=
                                    response.data[i].LOCALIDAD == "RAFAEL URIBE"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SANCRISTOBAL_NIDOS +=
                                    response.data[i].LOCALIDAD ==
                                    "SAN CRISTOBAL"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                SUMAPAZ_NIDOS +=
                                    response.data[i].LOCALIDAD == "SUMAPAZ"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                USME_NIDOS +=
                                    response.data[i].LOCALIDAD == "USME"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                TUNJUELITO_NIDOS +=
                                    response.data[i].LOCALIDAD == "TUNJUELITO"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                CIUDADBOLIVAR_NIDOS +=
                                    response.data[i].LOCALIDAD ==
                                    "CIUDAD BOLIVAR"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                KENNEDY_NIDOS +=
                                    response.data[i].LOCALIDAD == "KENNEDY"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                                BOSA_NIDOS +=
                                    response.data[i].LOCALIDAD == "BOSA"
                                        ? parseInt(
                                              response.data[i].BENEFICIARIOS
                                          )
                                        : 0;
                            }

                            json_areas = [
                                {
                                    title: "USAQUEN",
                                    id: "CO-BO1",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        USAQUEN_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        USAQUEN_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        USAQUEN_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        USAQUEN_LC
                                },
                                {
                                    title: "CHAPINERO",
                                    id: "CO-BO2",
                                    color: "#29abe2",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        CHAPINERO_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        CHAPINERO_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        CHAPINERO_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        CHAPINERO_LC
                                },
                                {
                                    title: "BARRIOS UNIDOS",
                                    id: "CO-BO3",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        BARRIOSUNIDOS_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        BARRIOSUNIDOS_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        BARRIOSUNIDOS_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        BARRIOSUNIDOS_LC +
                                        "<br><b>Crea 12 de Octubre</b><br>Cra 55 N° 75 - 40<br><b>Crea Santa Sofía</b><br>Cra 28a Nº 77-70<br>"
                                },
                                {
                                    title: "TEUSAQUILLO",
                                    id: "CO-BO4",
                                    color: "#00a99d",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        TEUSAQUILLO_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        TEUSAQUILLO_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        TEUSAQUILLO_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        TEUSAQUILLO_LC
                                },
                                {
                                    title: "SUBA",
                                    id: "CO-BO5",
                                    color: "#00a99d",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        SUBA_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        SUBA_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        SUBA_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        SUBA_LC +
                                        "<br><b>Crea Suba Campiña</b><br>calle 146A # 94 A-05<br><b>Crea Suba Centro</b><br>Calle 146B Nº 91 - 44<br>"
                                },
                                {
                                    title: "ENGATIVA",
                                    id: "CO-BO6",
                                    color: "#2e3192",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        ENGATIVA_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        ENGATIVA_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        ENGATIVA_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        ENGATIVA_LC +
                                        "<br><b>Crea Villas del Dorado</b><br>Cra. 107 N° 70 - 58<br><b>Crea La Granja</b><br>Calle 78 No.77B-86<br>"
                                },
                                {
                                    title: "FONTIBON",
                                    id: "CO-BO7",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        FONTIBON_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        FONTIBON_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        FONTIBON_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        FONTIBON_LC +
                                        "<br><b>Crea Villemar</b><br>Calle 20C N° 96C - 51<br><b>Crea Las Flores</b><br>Calle 23G N° 111 - 16<br>"
                                },
                                {
                                    title: "CANDELARIA",
                                    id: "CO-BO8",
                                    color: "#5e6c68",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        CANDELARIA_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        CANDELARIA_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        CANDELARIA_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        CANDELARIA_LC
                                },
                                {
                                    title: "SANTA FE",
                                    id: "CO-BO9",
                                    color: "#2e3192",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        SANTAFE_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        SANTAFE_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        SANTAFE_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        SANTAFE_LC
                                },
                                {
                                    title: "MARTIRES",
                                    id: "CO-BO10",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        MARTIRES_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        MARTIRES_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        MARTIRES_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        MARTIRES_LC +
                                        "<br><b>Crea La Pepita</b><br>Cra 25 N° 10 - 78<br>"
                                },
                                {
                                    title: "ANTONIO NARIÑO",
                                    id: "CO-BO11",
                                    color: "#29abe2",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        ANTONIONARIÑO_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        ANTONIONARIÑO_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        ANTONIONARIÑO_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        ANTONIONARIÑO_LC
                                },
                                {
                                    title: "PUENTE ARANDA",
                                    id: "CO-BO12",
                                    color: "#5e6c68",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        PUENTEARANDA_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        PUENTEARANDA_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        PUENTEARANDA_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        PUENTEARANDA_LC
                                },
                                {
                                    title: "RAFAEL URIBE URIBE",
                                    id: "CO-BO13",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        RUU_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        RUU_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        RUU_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        RUU_LC +
                                        "<br><b>Crea Rafael Uribe Uribe</b><br>Calle 27a Sur N° 13 - 51<br>"
                                },
                                {
                                    title: "SAN CRISTOBAL",
                                    id: "CO-BO14",
                                    color: "#00a99d",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        SANCRISTOBAL_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        SANCRISTOBAL_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        SANCRISTOBAL_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        SANCRISTOBAL_LC
                                },
                                {
                                    title: "SUMAPAZ",
                                    id: "CO-BO15",
                                    color: "#01937c",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        SUMAPAZ_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        SUMAPAZ_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        SUMAPAZ_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        SUMAPAZ_LC
                                },
                                {
                                    title: "USME",
                                    id: "CO-BO16",
                                    color: "#89ddaf",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        USME_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        USME_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        USME_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        USME_LC +
                                        "<br><b>Crea Cantarrana</b><br>Cra 1A Bis N° 100 - 45 Sur<br>"
                                },
                                {
                                    title: "TUNJUELITO",
                                    id: "CO-BO17",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        TUNJUELITO_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        TUNJUELITO_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        TUNJUELITO_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        TUNJUELITO_LC
                                },
                                {
                                    title: "CIUDAD BOLIVAR",
                                    id: "CO-BO18",
                                    color: "#01937c",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        CIUDADBOLIVAR_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        CIUDADBOLIVAR_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        CIUDADBOLIVAR_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        CIUDADBOLIVAR_LC +
                                        "<br><b>Crea Meissen</b><br>AV Boyacá N° 62-30 Sur<br><b>Crea Lucero Bajo</b><br>Cra 17D Bis Nº 64A - 54 Sur<br>"
                                },
                                {
                                    title: "KENNEDY",
                                    id: "CO-BO19",
                                    color: "#29abe2",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        KENNEDY_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        KENNEDY_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        KENNEDY_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        KENNEDY_LC +
                                        "<br><b>Crea Castilla</b><br>Carrera 75 Nº 8B - 89<br><b>Crea Roma</b><br>Ave. Calle 55 sur (Av primera de mayo) No. 79 G-09<br><b>Crea Las Delicias</b><br>AV Boyacá N° 43A - 62 Sur<br>"
                                },
                                {
                                    title: "BOSA",
                                    id: "CO-BO20",
                                    color: "#00547b",
                                    customData:
                                        "<b><font style='color:#5f4492 !important'>NIDOS: </font></b>" +
                                        BOSA_NIDOS +
                                        "<div style='border-top: 1px solid darkgray'></div>" +
                                        "<b><font style='color:#288881 !important'>CREA AE: </font></b>" +
                                        BOSA_AE +
                                        "<br><b><font style='color:#288881 !important'>CREA IC: </font></b>" +
                                        BOSA_EC +
                                        "<br><b><font style='color:#288881 !important'>CREA CV: </font></b>" +
                                        BOSA_LC +
                                        "<br><b>Crea Naranjos</b><br>Calle 70A sur N° 80i - 15<br><b>Crea San Pablo</b><br>Calle 68 Sur N° 78H - 37<br>"
                                }
                            ];
                            // var elemento = "#"+data[i].LOCALIDAD;
                            // var cantidad = "#"+data[i].BENEFICIARIOS;
                            // $(elemento).html(cantidad);
                            // for ( var x in this.map.dataProvider.areas ) {
                            //   this.map.dataProvider.areas[ x ].customData = "AAA";
                            // }
                            // this.map.validateData();
                        });
                        this.map.dataProvider.areas = json_areas;
                        this.map.validateData();
                        swal.close();
                    } catch (err) {
                        console.error(
                            "Error al leer estadísticas de Localidades: " +
                                err.message
                        );
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};

function handleMapObjectClick(event) {
    if (event.mapObject.title != undefined) {
        $("#content").html(event.mapObject.title);
        console.log(event.mapObject.id);
        console.log(event.mapObject.title);
    } else {
        $("#content").html(event.mapObject.linkToObject.title);
        console.log(event.mapObject.linkToObject.id);
        console.log(event.mapObject.linkToObject.title);
    }
}
</script>
