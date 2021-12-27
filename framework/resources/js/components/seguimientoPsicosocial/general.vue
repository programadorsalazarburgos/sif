<template>
<div id="general">
    <div class="card-header text-muted">
        <h2 class="m-0">Módulo Seguimiento Psicosocial</h2>
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: center;">
                                            <a type="button" v-on:click="mostrarReportes(2)"><img src="/sif/framework/public/images/psicosocial.png" width="25%">
                                                <p class="iconosInicio" id="nombre-modulo" name="nombre-modulo">REPORTE DE SITUACIONES</p>
                                            </a>
                                            <a type="button" v-on:click="mostrarReportes(3)"><img src="/sif/framework/public/images/interes.png" width="25%">
                                                <p class="iconosInicio" id="nombre-modulo" name="nombre-modulo">INFORMACIÓN DE INTERÉS</p>
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
        <reportecasos></reporteCasos>
    </div>
    <div v-if="mostrar_reporte==3">
        <informacioninteres></informacioninteres>
    </div>
</div>
</template>

<script>
import Axios from "axios";
import AmMap from "ammap3";
import $ from "jquery";
import reportecasos from '../seguimientoPsicosocial/reportecasos';
import informacioninteres from '../seguimientoPsicosocial/informacioninteres';
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
        reportecasos,
        informacioninteres

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
