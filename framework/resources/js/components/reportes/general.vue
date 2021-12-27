<template>
<div id="general">
    <div class="card-header text-muted">
        <h2 class="m-0">Reportes Monitoreo y Seguimiento Mensual</h2>
        <h5>Generación de Reporte por Línea de Atención</h5> 
    </div>
    <div class="content-header" style="padding: 5px !important" v-if="mostrar_reporte==1">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Inicio</a>
                        </li>
                    </ol>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-0"><b>SELECCIONA POR CUAL LINEA DE ATENCIÓN DESEAS REALIZAR EL REPORTE</b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a type="button" v-on:click="mostrarReportes(4)"><img src="/sif/framework/public/images/pedagogico.png" width="25%">
                                                <p class="iconosInicio" id="nombre-modulo" name="nombre-modulo">ARTE EN LA ESCUELA</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a type="button" v-on:click="mostrarReportes(3)"><img src="/sif/framework/public/images/pedagogico.png" width="25%">
                                                <p class="iconosInicio" id="nombre-modulo" name="nombre-modulo">IMPULSO COLECTIVO</p>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a type="button" v-on:click="mostrarReportes(2)"><img src="/sif/framework/public/images/pedagogico.png" width="25%">
                                                <p class="iconosInicio" id="nombre-modulo" name="nombre-modulo">CONVERGE CREA</p>
                                            </a>
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
    <div v-if="mostrar_reporte==2">
        <reporteConverge></reporteConverge>
    </div>
    <div v-if="mostrar_reporte==3">
        <reporteImpulso></reporteImpulso>
    </div>
    <div v-if="mostrar_reporte==4">
        <reporteArteEscuela></reporteArteEscuela>
    </div>
</div>
</template>

<script>
import Axios from "axios";
import AmMap from "ammap3";
import $ from "jquery";
import reporteConverge from '../reportes/reporteConverge';
import reporteImpulso from '../reportes/reporteImpulso';
import reporteArteEscuela from '../reportes/reporteArteEscuela';
import {
    result
} from "lodash";
export default {
    data() {
        return {
            mostrar_reporte: 1,
        };
    },
    components: {
        reporteConverge,
        reporteImpulso,
        reporteArteEscuela
    },
    mounted() {

    },
    methods: {
        mostrarReportes(data) {
            this.mostrar_reporte = data;
        },
    },
};
</script>

<style scoped>
.iconosInicio {
    color: #01c2eb !important;
    padding-top: 10px;
}
</style>
