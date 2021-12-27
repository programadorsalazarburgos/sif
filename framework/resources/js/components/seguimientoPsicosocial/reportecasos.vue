<template>
<div class="container-fluid" style="padding-top: 30px">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="card">
                <div class="card-header">
                    <div class="panel-heading">
                        <div class="page-header">
                            <h5 style="text-align: center">REPORTE DE SITUACIONES</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <button type="submit" v-on:click="volverAtras()" target="_blank" class="btn-danger" v-if="vista==1">
                            <i class="fas fa-hand-point-left"></i> Volver
                        </button>
                        <button @click="selectVista" type="button" class="btn-primary" v-if="vista==1">
                            Crear Reporte <i class="fa fa-plus-square"></i>
                        </button>
                        <button type="submit" v-on:click="volverAtrasHome()" target="_blank" class="btn-danger" v-if="vista==2">
                            <i class="fas fa-hand-point-left"></i> Volver
                        </button>
                        <button type="button" @click="abrirModal('data', 'reporte')" class="btn-success" v-if="vista==1">
                            Reporte Seguimiento <i class="fas fa-file-excel"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" v-if="vista==1">
                    <h4 class="card-title">
                        <label class="badge badge-success">SITUACIONES</label>
                    </h4>
                    <div class="table-responsive">
                        <table class="table dataTable no-footer" id="sampleTable">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Grupo: activate to sort column ascending" style="width: 89.7869px">
                                        # Caso
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Artista: activate to sort column ascending" style="width: 418.267px">
                                        Quien Reporta
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Fecha de Registro/Edición: activate to sort column ascending" style="width: 303.537px">
                                        Fecha de Reporte Seguimiento
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Fecha de Registro/Edición: activate to sort column ascending" style="width: 303.537px">
                                        Estado Seguimiento
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Fecha de Registro/Edición: activate to sort column ascending" style="width: 303.537px">
                                        Descripción Situación
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Fecha de Registro/Edición: activate to sort column ascending" style="width: 303.537px">
                                        Tipificación Situación
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="table_listado_informes" rowspan="1" colspan="1" aria-label="Fecha de Registro/Edición: activate to sort column ascending" style="width: 303.537px">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="data in arraySeguimientos" :key="data.pk_id_caso_psicosocial" role="row" class="odd">
                                    <td>{{data.pk_id_caso_psicosocial}}</td>
                                    <td>{{data.vc_nombre_reporta}}</td>
                                    <td>{{data.dt_fecha_reporte}}</td>
                                    <td>
                                        <template v-if="data.estado == 1">
                                            Abierto
                                        </template>
                                        <template v-if="data.estado == 0">
                                            Cerrado
                                        </template>
                                    </td>
                                    <td>
                                        <button class="btn-info" @click="abrirModal('data', 'descripcion', data)" title="Descripción Seguimiento"><i class="fas fa-meh-rolling-eyes"></i></button>
                                    </td>
                                    <td>
                                        <button class="btn-danger" @click="abrirModal('data', 'tipificacion', data)" title="Descripción Seguimiento"><i class="fas fa-address-card"></i></button>
                                    </td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <button class="btn-danger" v-if="data.estado == 1" @click="cerrarActivarCaso(data.pk_id_caso_psicosocial, false)" title="Cerrar Seguimiento">Cerrar </button>
                                            <button class="btn-success" v-if="data.estado == 0" @click="cerrarActivarCaso(data.pk_id_caso_psicosocial, true)" title="Cerrar Seguimiento">Activar </button>
                                            <button class="btn-warning" style="color:white;" @click="abrirModal('data', 'ver', data.pk_id_caso_psicosocial)" title="Ver Seguimientos">Ver</button>
                                            <button class="btn-primary" @click="abrirModal('data', 'crear', data.pk_id_caso_psicosocial)" v-if="data.estado == 1" title="Realizar Seguimiento">Realizar</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="vista==2">
                    <form-wizard @onComplete="onComplete">
                        <tab-content title="Datos Quien Reporta" :selected="true">
                            <hr>
                            <h5 style="text-align:center;"><span class="badge badge-primary">PERSONA QUE REALIZA EL REPORTE</span></h5>
                            <div class="clearfix"></div><br>
                            <div class="form-group">
                                <label for="fullName">Nombre Completo</label>
                                <input type="text" class="form-control" :class="hasError('nombre_reporta') ? 'is-invalid' : ''" placeholder="Enter your name" v-model="formData.nombre_reporta">
                                <div v-if="hasError('nombre_reporta')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.nombre_reporta.required">Campo requerido</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="numero">Número de Contacto</label>
                                <input type="text" class="form-control" :class="hasError('numero') ? 'is-invalid' : ''" placeholder="Número de contacto" v-model="formData.numero">
                                <div v-if="hasError('numero')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.numero.required">Campo requerido</div>
                                    <div class="error" v-if="!$v.formData.numero.numeric">Este campo debe ser numerico.</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="email" class="form-control" :class="hasError('email') ? 'is-invalid' : ''" placeholder="Correo electrónico" v-model="formData.email">
                                <div v-if="hasError('email')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.email.required">Campo requerido</div>
                                    <div class="error" v-if="!$v.formData.email.email">Debe estar en formato de correo electrónico</div>
                                </div>
                            </div>
                        </tab-content>
                        <tab-content title="Datos Basicos">
                            <hr>
                            <h5 style="text-align:center;"><span class="badge badge-primary">DATOS BASICOS DE QUIEN PRESENTA LA SITUACIÓN</span></h5>
                            <div class="clearfix"></div><br>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_reporte">Fecha del Reporte</label>
                                            <input type="date" class="form-control" :class="hasError('fecha_reporte') ? 'is-invalid' : ''" placeholder="Enter your Company / Organization name" v-model="formData.fecha_reporte">
                                            <div v-if="hasError('fecha_reporte')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.fecha_reporte.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullName">Rol</label>
                                            <select class="form-control" @change="selectRol()" v-model="formData.rol" :class="hasError('rol') ? 'is-invalid' : ''" id="exampleFormControlSelect1">
                                                <option value="1">Beneficiario</option>
                                                <option value="2">Colaborador</option>
                                            </select>
                                            <div v-if="hasError('rol')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.rol.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_reporte">Nombre Completo</label>
                                            <input type="text" class="form-control" :class="hasError('nombre_completo_persona') ? 'is-invalid' : ''" placeholder="Enter your Company / Organization name" v-model="formData.nombre_completo_persona">
                                            <div v-if="hasError('nombre_completo_persona')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.nombre_completo_persona.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullName">Tipo Identificacion</label>
                                            <select class="form-control" v-model="formData.tipo_identificacion" :class="hasError('tipo_identificacion') ? 'is-invalid' : ''" required>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="data in arrayTipoIdentificaciones" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Tabla, VC_Descripcion: data.VC_Descripcion}">{{data.VC_Descripcion}}</option>
                                            </select>
                                            <div v-if="hasError('tipo_identificacion')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.tipo_identificacion.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_reporte">Número Identificación</label>
                                        <input type="text" class="form-control" :class="hasError('numero_identificacion') ? 'is-invalid' : ''" placeholder="Enter your Company / Organization name" v-model="formData.numero_identificacion">
                                        <div v-if="hasError('numero_identificacion')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.numero_identificacion.required">Campo requerido</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" :class="hasError('fecha_nacimiento') ? 'is-invalid' : ''" v-model="formData.fecha_nacimiento">
                                        <div v-if="hasError('fecha_nacimiento')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.fecha_nacimiento.required">Campo requerido</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_reporte">Dirección de Residencia</label>
                                        <input type="text" class="form-control" :class="hasError('direccion') ? 'is-invalid' : ''" placeholder="Enter your Company / Organization name" v-model="formData.direccion">
                                        <div v-if="hasError('direccion')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.direccion.required">Campo requerido</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Telefono Celular</label>
                                        <input type="text" class="form-control" :class="hasError('telefono_celular') ? 'is-invalid' : ''" v-model="formData.telefono_celular">
                                        <div v-if="hasError('telefono_celular')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.telefono_celular.required">Campo requerido</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <tab-content title="Datos Vinculación">
                            <hr>
                            <h5 style="text-align:center;"><span class="badge badge-primary">DATOS VINCULACIÓN DE QUIEN PRESENTA LA SITUACIÓN</span></h5>
                            <div class="clearfix"></div><br>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Linea estrategica</label>
                                            <select class="form-control" :class="hasError('linea_estrategica') ? 'is-invalid' : ''" v-model="formData.linea_estrategica">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="data in arrayLineas" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Tabla, VC_Descripcion: data.VC_Descripcion}">{{data.VC_Descripcion}}</option>
                                            </select>
                                            <div v-if="hasError('linea_estrategica')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.linea_estrategica.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Área de formación artística</label>
                                            <select class="form-control" :class="hasError('area_artistica') ? 'is-invalid' : ''" v-model="formData.area_artistica">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="data in arrayAreas" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Tabla, VC_Descripcion: data.VC_Descripcion}">{{data.VC_Descripcion}}</option>
                                            </select>
                                            <div v-if="hasError('area_artistica')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.area_artistica.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Crea</label>
                                            <select class="form-control" :class="hasError('crea') ? 'is-invalid' : ''" v-model="formData.crea">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="data in arrayCreas" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Clan, VC_Descripcion: data.VC_Nom_Clan}">{{data.VC_Nom_Clan}}</option>
                                            </select>
                                            <div v-if="hasError('crea')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.crea.required">Campo requerido</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="datosShow==1" style="padding-top: 36px;">
                                        <label role="radio" tabindex="0">
                                            <input type="radio" @change="changed" name="r1" value="1" v-model="picked">
                                            <span>Institución educativa</span>
                                        </label>

                                        <label role="radio" tabindex="0">
                                            <input type="radio" @change="changed" name="r1" value="2" v-model="picked">
                                            <span>Institución aliada</span>
                                        </label>
                                        <br>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" v-if="datosShow==1">
                                        <div class="form-group" v-if="datosInstitucionShow==1">
                                            <label for="exampleFormControlSelect1">Institución educativa</label>
                                            <v-select :options="arrayInstituciones" v-model="formData.institucion" label="text"></v-select>
                                        </div>
                                        <div class="form-group" v-if="datosInstitucionShow==2">
                                            <label for="exampleFormControlSelect1">Institución aliada</label>
                                            <input type="text" class="form-control" v-model="formData.institucion_aliada">
                                        </div>
                                    </div>
                                </div>
                                <hr v-if="datosShow==1">
                                <h5 v-if="datosShow==1"><u>DATOS ACUDIENTE</u></h5>
                                <div class="row" v-if="datosShow==1">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nombre Completo</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1" v-model="formData.nombre_acudiente">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Tipo Identificación</label>
                                            <select class="form-control" v-model="formData.tipo_identificacion_acudiente">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="data in arrayTipoIdentificaciones" :key="data.PK_Id_Tabla" :value="{PK_Id_Tabla: data.PK_Id_Tabla, VC_Descripcion: data.VC_Descripcion}">{{data.VC_Descripcion}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="datosShow==1">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Número Identificación</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1" v-model="formData.numero_identificacion_acudiente">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Telefono y/o celular</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1" v-model="formData.telefono_celular_acudiente">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <tab-content title="Descripción Situación">
                            <p>Por favor proporcione toda la información detallada sobre la situación, incluyendo datos como ¿Qué señales identificó? ¿Cuál fue el relato del/la beneficiario? ¿En el relato del/la beneficiario mencionó al presunto agresor? ¿Qué acciones realizó el colaborador equipo Crea? ¿Alguien más conoce la situación? y demás información proporcionada por la/el beneficiario que crea pertinente referir.
                            </p>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Descripción de la situación</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" :class="hasError('descripcion') ? 'is-invalid' : ''" v-model="formData.descripcion"></textarea>
                                <div v-if="hasError('descripcion')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.descripcion.required">Campo requerido</div>
                                </div>
                            </div>
                        </tab-content>
                    </form-wizard>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-lg" aria-labelledby="myLargeModalLabel" :class="{ mostrar: modal }" role="dialog" style="display: none; height: 10000px" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="height: 712px; top: 40px">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel" style="color: black">
                        <label class="badge badge-info">{{ tituloModal }}</label>
                    </h4>
                    <button type="button" @click="cerrarModal()" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto;">
                    <form action="" method="post" @submit.prevent="registrarSeguimiento" enctype="multipart/form-data" class="form-horizontal" v-if="vistaModal==1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha Seguimiento</label>
                            <input type="date" v-model="fechaSeguimiento" class="form-control" required>
                            <small id="emailHelp" class="form-text text-muted">Elije fecha seguimiento del caso.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Descripción del seguimiento</label>
                            <textarea style="height: 200px;" v-model="descripcionSeguimiento" class="form-control" id="exampleInputPassword1" required placeholder="Descripción del seguimiento"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="bm-weburl">Anexo Seguimiento</label>
                            <input type="file" ref="fileupload" name="filename" class="form-control" v-on:change="onFileChange">
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                    <table class="table" v-if="vistaModal==2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha Seguimiento</th>
                                <th scope="col">Descripción Seguimiento</th>
                                <th scope="col">Anexo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in arraySeguimientosCasos" :key="data.pk_id_seguimiento_psicosocial" role="row" class="odd">
                                <th scope="row">{{data.pk_id_seguimiento_psicosocial}}</th>
                                <td>{{data.dt_fecha_seguimiento}}</td>
                                <td>{{data.tx_descripcion_seguimiento}}</td>
                                <td>
                                    <a :href="path + data.vc_anexo" download class="btn btn-success"><i class="fas fa-download"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="" method="post" @submit.prevent="generarReporte" enctype="multipart/form-data" class="form-horizontal" v-if="vistaModal==3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha inicial Reporte</label>
                            <input type="date" v-model="fechaInicial" class="form-control" required>
                            <small id="emailHelp" class="form-text text-muted">Elije fecha inicial del reporte.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha final Reporte</label>
                            <input type="date" v-model="fechaFinal" class="form-control" required>
                            <small id="emailHelp" class="form-text text-muted">Elije fecha final del reporte.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Reporte <i class="fas fa-file-excel"></i></button>
                        <export-excel v-if="json_data.length > 0" class="btn btn-default" :data="json_data" :fields="json_fields" worksheet="Mi reporte" :title="'Cantidad de seguimientos-' + cantidadCasos" name="reporte.xls">
                            Descargar Reporte
                        </export-excel>
                        <br>
                        <span class="badge badge-success">Cantidad de casos registrados: {{cantidadCasos}}</span>
                    </form>
                    <div v-if="vistaModal==4">
                        <p>{{descripcionData}}</p>
                    </div>
                    <form action="" method="post" @submit.prevent="generarReporte" enctype="multipart/form-data" class="form-horizontal" v-if="vistaModal==5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tipificación</label>
                            <select class="form-control" aria-label="Default select example">
                                <option selected>Seleccione</option>
                                <option value="1">Situaciones de presunta violencia intrafamiliar</option>
                                <option value="2">Situaciones de presunta violencia sexual</option>
                                <option value="3">Situaciones de presunto trabajo infantil o en riesgo de estarlo</option>
                                <option value="3">Situaciones de personas con presunto consumo de sustancias psicoactivas (spa) </option>
                                <option value="3">Situaciones de presunto incumplimiento, negligencia y/o abandono de las responsabilidades de padres, madres y cuidadores </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar <i class="fas fa-file-excel"></i></button>
                    </form>
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
import excel from 'vue-excel-export'
Vue.use(excel)
import {
    FormWizard,
    TabContent,
    ValidationHelper
} from "vue-step-wizard";
import "vue-step-wizard/dist/vue-step-wizard.css";
import {
    required
} from "vuelidate/lib/validators";
import {
    email
} from "vuelidate/lib/validators";
import {
    numeric
} from "vuelidate/lib/validators";
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import {
    ModelListSelect
} from "vue-search-select";
import "vue-select/dist/vue-select.css";
import HorizontalStepper from 'vue-stepper';

import {
    result
} from "lodash";

export default {
    mixins: [ValidationHelper],
    data() {
        return {
            json_fields: {
                '# Seguimientos': 'pk_id_caso_psicosocial',
                'Quien Reporta': 'vc_nombre_reporta',
                'Numero Quien Reporta': 'vc_numero_contacto_reporta',
                'Correo Quien Reporta': 'vc_correo_reporta',
                'Fecha Reporte': 'dt_fecha_reporte',
                'Rol': 'vc_rol',
                'Nombre Completo': 'vc_nombre_completo',
                'Identificación': 'vc_numero_identificacion',
                'Fecha Nacimiento': 'dt_fecha_nacimiento',
                'Dirección': 'vc_direccion',
                'Telefono': 'vc_telefono_celular',
                'Descripción': 'tx_descripcion'
            },
            json_data: [],
            json_meta: [
                [{
                    'key': 'charset',
                    'value': 'utf-8'
                }]
            ],
            path: "/sif/framework/public/",
            cantidadCasos: null,
            datosInstitucionShow: 0,
            picked: null,
            valueWhenClicked: null,
            valueWhenChanged: null,
            vistaModal: 0,
            idCaso: "",
            fechaInicial: "",
            fechaFinal: "",
            fechaSeguimiento: "",
            descripcionSeguimiento: "",
            modal: 0,
            tituloModal: "",
            mostrar_reporte: 1,
            arrayTipoIdentificaciones: [],
            arrayLineas: [],
            arrayAreas: [],
            arrayCreas: [],
            arraySeguimientos: [],
            arrayInstituciones: [],
            arrayColegios: [],
            arraySeguimientosCasos: [],
            item: {},
            anio: "",
            linea: 1,
            convenio: {},
            colegio: {},
            mes: "",
            tipoReporte: 0,
            loadingWizard: false,
            errorMsg: null,
            count: 0,
            nombre_reporta: "",
            descripcionData: "",
            rol: "",
            numero: "",
            correo: "",
            datosShow: 1,
            vista: 1,
            formData: {
                nombre_reporta: "",
                numero: null,
                email: null,
                fecha_reporte: null,
                email: null,
                rol: null,
                nombre_completo_persona: null,
                tipo_identificacion: null,
                numero_identificacion: null,
                fecha_nacimiento: null,
                direccion: null,
                telefono_celular: null,
                linea_estrategica: null,
                area_artistica: null,
                crea: null,
                institucion: null,
                institucion_aliada: null,
                nombre_acudiente: null,
                tipo_identificacion_acudiente: null,
                numero_identificacion_acudiente: null,
                telefono_celular_acudiente: null,
                descripcion: null
            },
            validationRules: [{
                    nombre_reporta: {
                        required
                    },
                    numero: {
                        required,
                        numeric
                    },
                    email: {
                        required,
                        email
                    }
                },
                {
                    fecha_reporte: {
                        required
                    },
                    rol: {
                        required
                    },
                    nombre_completo_persona: {
                        required
                    },
                    tipo_identificacion: {
                        required
                    },
                    numero_identificacion: {
                        required,
                        numeric
                    },
                    fecha_nacimiento: {
                        required
                    },
                    direccion: {
                        required
                    },
                    telefono_celular: {
                        required
                    },
                },
                {
                    linea_estrategica: {
                        required
                    },
                    area_artistica: {
                        required
                    },
                    crea: {
                        required
                    },
                    institucion: {

                    },
                    institucion_aliada: {

                    },
                    nombre_acudiente: {},
                    tipo_identificacion_acudiente: {},
                    numero_identificacion_acudiente: {
                        numeric
                    },
                    telefono_celular_acudiente: {},
                },
                {
                    descripcion: {
                        required
                    },

                },
                {
                    referral: {
                        required
                    },
                    terms: {
                        required
                    }
                }
            ]

        };
    },
    components: {
        ModelListSelect,
        vSelect,
        FormWizard,
        TabContent,
        HorizontalStepper

    },
    mounted() {
        this.obtenerTipoIdentificaciones();
        this.obtenerLineasEstrategicas();
        this.obtenerAreas();
        this.obtenerCreas();
        this.obtenerInstituciones();
        if (this.vista == 1) {
            this.consulta();
        }
    },
    methods: {
        generarReporte() {
            let me = this;
            me.mensaje();
            var url = "getReporte?fechaInicio=" + me.fechaInicial + '&fechaFin=' + me.fechaFinal;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.json_data = respuesta.datos;
                    me.cantidadCasos = me.json_data.length;
                    Swal.close();
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        cerrarActivarCaso(data, estado) {
            let me = this;
            var nombreEstado = (estado == false) ? "Cerrado" : "Abierto";
            axios
                .post("cerrarActivarSeguimiento", {
                    id: data,
                    estado: estado
                })
                .then(function (response) {
                    Swal.fire(
                        'Muy bien!',
                        'Seguimiento! ' + nombreEstado,
                        'success'
                    );
                    me.consulta();
                })
                .catch(function (error, otracosa) {});
        },
        onFileChange(e) {
            this.filename = "Selected File: " + e.target.files[0].name;
            this.file = e.target.files[0];
        },
        changed: function () {
            this.valueWhenChanged = this.picked;
            if (this.picked == 1) {
                this.datosInstitucionShow = 1;
            }
            if (this.picked == 2) {
                this.datosInstitucionShow = 2;
            }
        },
        changeValue: function (newValue) {
            this.selectedLabel = newValue;
        },
        registrarSeguimiento() {
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
            formData.append('idCaso', me.idCaso);
            formData.append('fechaSeguimiento', me.fechaSeguimiento);
            formData.append('descripcionSeguimiento', me.descripcionSeguimiento);
            axios.post('guardarSeguimientoPsicosocial', formData, config)
                .then(function (response) {
                    me.cerrarModal();
                    me.file = '';
                    me.filename = "";
                    me.file = '',
                        me.$refs.fileupload.value = null;
                })
                .catch(function (error) {});

        },
        tabla() {
            Vue.nextTick(function () {
                $('#sampleTable').DataTable();
            });
        },
        consulta() {
            let me = this;
            var url = 'getCasosSeguimientos';
            axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arraySeguimientos = respuesta.datos;
                    me.tabla();
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        completeStep(payload) {
            this.demoSteps.forEach((step) => {
                if (step.name === payload.name) {
                    step.completed = true;
                }
            })
        },
        isStepActive(payload) {
            this.demoSteps.forEach((step) => {
                if (step.name === payload.name) {
                    if (step.completed === true) {
                        step.completed = false;
                    }
                }
            })
        },
        alert(payload) {
            alert('end')
        },
        selectVista() {
            this.vista = 2;
        },
        selectRol() {
            this.datosShow = (this.formData.rol == 2) ? 2 : 1;
        },
        setLoading: function (value) {
            this.loadingWizard = value
        },
        handleValidation: function (isValid, tabIndex) {
            console.log('Tab: ' + tabIndex + ' valid: ' + isValid)
        },
        handleErrorMessage: function (errorMsg) {
            this.errorMsg = errorMsg
        },
        validateFormOne: function () {
            return new Promise((resolve, reject) => {
                setTimeout(() => {
                    if (this.nombre_reporta === "" || this.numero === "" || this.correo === "") {
                        reject('Verifica tus campos no deben estar vacios')
                    } else {
                        this.count = 0
                        resolve(true)
                    }
                }, 1000)
            })
        },

        beforeTabSwitch: function () {},
        volverAtras() {
            window.location.href = "/sif/framework/seguimiento/psicosocial";
        },
        volverAtrasHome() {
            this.vista = 1;
        },
        onComplete: function () {
            let me = this;
            console.log(me.formData.tipo_identificacion.PK_Id_Tabla, "formData");
            var institucion = (me.formData.institucion != null) ? me.formData.institucion.value : null;
            var tipo_identificacion_acudiente = (me.formData.tipo_identificacion_acudiente != null) ? me.formData.tipo_identificacion_acudiente.PK_Id_Tabla : null;
            axios
                .post("guardarCasoPsicosocial", {
                    nombre_reporta: me.formData.nombre_reporta,
                    numero_reporta: me.formData.numero,
                    email_reporta: me.formData.email,
                    fecha_reporte: me.formData.fecha_reporte,
                    rol: me.formData.rol,
                    nombre_completo_persona: me.formData.nombre_completo_persona,
                    tipo_identificacion: me.formData.tipo_identificacion.PK_Id_Tabla,
                    numero_identificacion: me.formData.numero_identificacion,
                    fecha_nacimiento: me.formData.fecha_nacimiento,
                    direccion: me.formData.direccion,
                    telefono_celular: me.formData.telefono_celular,
                    linea_estrategica: me.formData.linea_estrategica.PK_Id_Tabla,
                    area_artistica: me.formData.area_artistica.PK_Id_Tabla,
                    crea: me.formData.crea.PK_Id_Tabla,
                    institucion: institucion,
                    institucion_aliada: me.formData.institucion_aliada,
                    nombre_acudiente: me.formData.nombre_acudiente,
                    tipo_identificacion_acudiente: tipo_identificacion_acudiente,
                    numero_identificacion_acudiente: me.formData.numero_identificacion_acudiente,
                    telefono_celular_acudiente: me.formData.telefono_celular_acudiente,
                    descripcion: me.formData.descripcion,
                })
                .then(function (response) {
                    Swal.fire(
                        'Muy bien!',
                        'Observación registrada!',
                        'success'
                    )
                    me.formData = {
                        nombre_reporta: "",
                        numero: null,
                        email: null,
                        fecha_reporte: null,
                        email: null,
                        rol: null,
                        nombre_completo_persona: null,
                        tipo_identificacion: null,
                        numero_identificacion: null,
                        fecha_nacimiento: null,
                        direccion: null,
                        telefono_celular: null,
                        linea_estrategica: null,
                        area_artistica: null,
                        crea: null,
                        institucion: null,
                        nombre_acudiente: null,
                        tipo_identificacion_acudiente: null,
                        numero_identificacion_acudiente: null,
                        telefono_celular_acudiente: null,
                        descripcion: null
                    };
                    me.consulta();
                    me.volverAtrasHome()

                })
                .catch(function (error, otracosa) {});
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "data": {
                    switch (accion) {
                        case "crear": {
                            this.vistaModal = 1;
                            this.idCaso = data;
                            this.dataArrayDetalle = [];
                            this.modal = 1;
                            this.tituloModal = "REGISTRAR SEGUIMIENTO";
                            break;
                        }
                        case "ver": {
                            this.vistaModal = 2;
                            this.idCaso = data;
                            this.dataArrayDetalle = [];
                            this.modal = 1;
                            this.tituloModal = "SEGUIMIENTOS";
                            this.traerSeguimientos(data);
                            break;
                        }
                        case "reporte": {
                            this.vistaModal = 3;
                            this.dataArrayDetalle = [];
                            this.modal = 1;
                            this.tituloModal = "REPORTE SEGUIMIENTOS";
                            break;
                        }
                        case "descripcion": {
                            this.vistaModal = 4;
                            this.modal = 1;
                            this.tituloModal = "DESCRIPCIÓN DE LA SITUACIÓN";
                            this.descripcionData = data.tx_descripcion;
                            break;
                        }
                        case "tipificacion": {
                            this.vistaModal = 5;
                            this.modal = 1;
                            this.tituloModal = "TIPIFICACIÓN DE LA SITUACIÓN";
                            break;
                        }
                    }
                }
            }
        },
        traerSeguimientos(data) {
            let me = this;
            var url = "getSeguimientos?casoId=" + data;
            axios
                .get(url)
                .then(function (response) {
                    console.log(response, "respuesta");
                    var respuesta = response.data;
                    me.arraySeguimientosCasos = respuesta.datos;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
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

        obtenerLineasEstrategicas() {
            let me = this;
            var url = "getLineasEstrategicas";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayLineas = respuesta.datos;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        obtenerAreas() {
            let me = this;
            var url = "getAreasArtisticas";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayAreas = respuesta.datos;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        obtenerCreas() {
            let me = this;
            var url = "getCreas";
            axios
                .get(url)
                .then(function (response) {
                    me.arrayCreas = response.data;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        obtenerInstituciones() {
            let me = this;
            var url = "getInsituciones";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayInstituciones = respuesta.datos;
                })
                .catch(function (error) {
                    var response = error.response.data;
                });
        },
        obtenerTipoIdentificaciones() {
            let me = this;
            var url = "getTipoIdentificaciones";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayTipoIdentificaciones = respuesta.datos;
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

.vue-step-wizard {
    background-color: transparent !important;
    width: 1200px !important;
    margin: auto !important;
    padding: 40px !important;
}
</style>
