<template>
<div class="container-fluid" style="padding-top: 30px">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="card">
                <div class="card-header">
                    <div class="panel-heading">
                        <div class="page-header">
                            <h5 style="text-align: center">DOCUMENTOS INFORMACIÓN DE INTERES</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <button type="submit" v-on:click="volverAtras()" target="_blank" class="btn-danger">
                            <i class="fas fa-hand-point-left"></i> Volver
                        </button>
                        <button @click="abrirModal('data', 'crear')" type="button" class="btn-primary">
                            Subir Documentos <i class="fa fa-plus-square"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">
                        <label class="badge badge-success">DOCUMENTOS</label>
                    </h4>
                    <div class="table-responsive">
                        <table class="table dataTable no-footer" id="sampleTable">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Grupo: activate to sort column ascending" style="width: 89.7869px">
                                        Categoria
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Grupo: activate to sort column ascending" style="width: 89.7869px">
                                        Descripción Documento
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Fecha de Registro/Edición: activate to sort column ascending" style="width: 303.537px">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="data in arrayDocumentos" :key="data.pk_id_documento_interes" role="row" class="odd">
                                    <td>{{data.vc_categoria}}</td>
                                    <td>{{data.tx_descripcion}}</td>
                                    <td>
                                        <a :href="path + data.vc_anexo" download class="btn btn-success">Descargar Documento <i class="fas fa-download"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" aria-labelledby="myLargeModalLabel" :class="{ mostrar: modal }" role="dialog" style="display: none; height: 10000px" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="height: 570px; top: 40px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel" style="color: black">
                        {{ tituloModal }}
                    </h4>
                    <button type="button" @click="cerrarModal()" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto;">
                    <div class="col-12">
                        <form class="form-bookmark needs-validation" method="post" @submit.prevent="subirDocumento" enctype="multipart/form-data" id="bookmark-form" novalidate="">
                            <div class="row g-2">
                                <div class="mb-3 mt-0 col-md-12">
                                    <label for="bm-weburl">Categoria Documento</label>
                                    <input type="text" v-model="categoria" class="form-control">
                                </div>
                                <div class="mb-3 mt-0 col-md-12">
                                    <label for="exampleInputPassword1">Descripción del documento</label>
                                    <textarea style="height: 200px;" v-model="descripcion" class="form-control" id="exampleInputPassword1" required placeholder="Descripción del seguimiento"></textarea>
                                </div>
                                <div class="mb-3 mt-0 col-md-12">
                                    <label for="bm-weburl">Documento</label>
                                    <input type="file" ref="fileupload" name="filename" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>
                            <input id="index_var" type="hidden" value="6">
                            <button class="btn btn-success" id="Bookmark" type="submit">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Axios from "axios";
import Vue from "vue";
import vSelect from "vue-select";
import datatable from "datatables.net-bs4";
import $ from "jquery";
import "vue-search-select/dist/VueSearchSelect.css";
import {
    FormWizard,
    TabContent
} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import {
    ModelListSelect
} from "vue-search-select";
import "vue-select/dist/vue-select.css";
import {
    result
} from "lodash";
export default {
    data() {
        return {
            path: "/sif/framework/public/",
            modal: 0,
            tituloModal: "",
            descripcion: "",
            mostrar_reporte: 1,
            arrayAnios: [],
            arrayDocumentos: [],
            arrayLineas: [],
            arrayConvenios: [],
            arrayColegios: [],
            arrayReporte: [],
            arrayMeses: [],
            item: {},
            anio: "",
            linea: 1,
            convenio: {},
            colegio: {},
            mes: "",
            categoria: "",
            tipoReporte: 0,
            categoria: "",
        };
    },
    components: {
        ModelListSelect,
        vSelect,
        FormWizard,
        TabContent
    },
    mounted() {
        this.consulta();
    },
    methods: {
        subirDocumento() {
            let me = this;
            let currentObj = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }
            let formData = new FormData();
            formData.append('file', me.file);
            formData.append('categoria', me.categoria);
            formData.append('descripcion', me.descripcion);
            axios.post('guardarDocumentoPsicosocial', formData, config)
                .then(function (response) {
                    me.consulta();
                    me.cerrarModal();
                    me.file = '';
                    me.categoria = '';
                    me.filename = "";
                    me.file = '',
                        me.$refs.fileupload.value = null;
                })
                .catch(function (error) {});
        },
        onFileChange(e) {
            this.filename = "Selected File: " + e.target.files[0].name;
            this.file = e.target.files[0];
        },
        volverAtras() {
            window.location.href = "/sif/framework/seguimiento/psicosocial";
        },
        onComplete: function () {
            alert('¡Completado!');
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "data": {
                    switch (accion) {
                        case "crear": {
                            this.dataArrayDetalle = [];
                            this.modal = 1;
                            this.tituloModal = "Subir Documentos";
                            break;
                        }
                    }
                }
            }
        },
        cerrarModal() {
            let me = this;
            me.modal = 0;
        },
        ////PARA ABAJO BORRAR
        mensaje() {
            Swal.fire({
                title: "Generando reporte",
                text: "Espere un poco por favor",
                imageUrl: "../public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false,
                backdrop: `rgba(0,0,123,0.4)`,
            });
        },
        tipoReporteConsulta() {
            this.tipoReporte = 1;
        },
        tipoReporteDescarga() {
            this.tipoReporte = 2;
        },
        tabla() {
            Vue.nextTick(function () {
                $("#sampleTable").DataTable();
            });
        },
        consultas() {
            let me = this;
        },
        consulta() {
            let me = this;
            var url = 'getSeguimientosDocumentos';
            axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayDocumentos = respuesta.datos;
                    me.tabla();
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },

        mostrarReportes(data) {
            this.mostrar_reporte = data;
        },
        reset() {
            this.item = {};
        },
        selectFromParentComponent1() {
            // select option from parent component
            this.item = this.options[0];
        },
        reset2() {
            this.item2 = "";
        },
        selectFromParentComponent2() {
            // select option from parent component
            this.item2 = this.options2[0].value;
        },
    },
};
</script>

<style>
.btn-success,
.btn-success:hover,
.btn-success.active.focus,
.btn-success.active:focus,
.btn-success.active:hover,
.btn-success:active.focus,
.btn-success:active:focus,
.btn-success:active:hover,
.open>.dropdown-toggle.btn-success.focus,
.open>.dropdown-toggle.btn-success:focus,
.open>.dropdown-toggle.btn-success:hover,
.panel-success .panel-heading small,
.panel-success .panel-heading,
.bg-success,
table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
    background-color: #009f99 !important;
    color: #ffffff;
}

.dataTables_filter {
    position: relative;
    right: 8px;
}

.modal-content {
    width: 100% !important;
    position: absolute !important;
}

.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}

.wizard-header {
    display: none !important;
}
</style>
