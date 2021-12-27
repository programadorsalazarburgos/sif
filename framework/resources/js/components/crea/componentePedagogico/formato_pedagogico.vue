<template>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header text-muted">
                <h2 class="m-0">Formato Pedagógico General - Caracterización</h2>
            </div>

            <div class="card-body text-center">
                <div v-show="formInicial">
                    <center>
                        <div class="row form-group col-sm-8">
                            <button class="btn btn-success" type="button" @click="generarFormularioIncial()"><span class="fa fa-plus" aria-hidden="true"></span> Nuevo Proceso</button>
                        </div>
                    </center>

                    <div v-show="formTableEdit">
                        <center>
                            <div class="alert alert-light m-2 col-sm-8" role="alert">
                                <small>A continuación se detallan los procesos de caracterización que actualmente se encuentran para edición:</small>
                            </div>
                        </center>
                        <div class="row">
                                <div class="col-md-4" align="right">
                                <label>Tipo</label>
                                </div>
                                <div class="col-md-4">
                                    <multiselect v-model="idTipoInforme" label="text" :options="selectTipoInforme" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-4" align="right">
                                    <label>Estado</label>
                                </div>
                                <div class="col-md-4">
                                    <multiselect v-model="idEstado" label="text" :options="selectEstado" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-info" type="button" @click="getInfoTableEdit()"><span class="fa fa-search" aria-hidden="true"></span> Consultar</button>
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-12"><br></div>
                        </div>
                        <div class="row form-group justify-content-center">
                            <div class="col-sm-12">
                                <table id="tableEdicion" name="tableEdicion" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Grupo</th>
                                            <th>Línea de Atención</th>
                                            <th>Colegio o Crea</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                            <th>Documento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(caracterizado,i) in caracterizaciones" :key="i">
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 1"><b>AE-{{caracterizado.FK_Grupo}}</b></td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 2"><b>IC-{{caracterizado.FK_Grupo}}</b></td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 3"><b>CV-{{caracterizado.FK_Grupo}}</b></td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 1">Arte en la escuela</td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 2">Impulso Colectivo</td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 3">Converge</td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 1">{{caracterizado.grupo_arte.colegio.VC_Nom_Colegio}}</td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 2">{{caracterizado.grupo_impulso.crea.VC_Nom_Clan}}</td>
                                            <td v-if="caracterizado.FK_Id_Linea_Atencion == 3">{{caracterizado.grupo_converge.colegio.VC_Nom_Colegio}}</td>
                                        
                                            <td>
                                                <span v-if="caracterizado.IN_Estado == null && caracterizado.IN_Finalizado == 1" class="badge badge-warning">en proceso de Revisión Caracterización</span>
                                                <span v-if="caracterizado.IN_Estado == 0" class="badge badge-danger">Devuelto Caracterización</span>
                                                <span v-if="caracterizado.IN_Estado == 1" class="badge badge-success">Revisado Caracterización</span>

                                                <span v-if="caracterizado.IN_Finalizado == 0" class="badge badge-danger">Sin Finalizar</span>
                                                <span v-if="caracterizado.IN_Finalizado == 1" class="badge badge-success">Finalizado</span>
                                            </td>
                                            <td>
                                                <button v-if="caracterizado.IN_Finalizado == 0" v-bind:id="'edit_'+caracterizado.PK_Id_Caracterizacion" class="btn btn-warning editCaracterizacion" type="button" @click="editCaracterizacion(caracterizado.PK_Id_Caracterizacion, caracterizado.FK_Grupo, caracterizado.FK_Id_Linea_Atencion)"><span class="fa fa-edit" aria-hidden="true"></span></button>
                                                <button v-if="caracterizado.IN_Finalizado == 1 && (id_rol == 30 || id_rol == 35)" v-bind:id="'rev_'+caracterizado.PK_Id_Caracterizacion" class="btn btn-primary revisarPlaneacion" type="button" @click="revCaracterizacion(caracterizado.PK_Id_Caracterizacion, caracterizado.FK_Grupo, caracterizado.FK_Id_Linea_Atencion, 1)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                                <button v-if="caracterizado.IN_Finalizado == 1 && (id_rol != 30 && id_rol != 35)" v-bind:id="'view_'+caracterizado.PK_Id_Caracterizacion" class="btn btn-dark visualizarPlaneacion" type="button" @click="revCaracterizacion(caracterizado.PK_Id_Caracterizacion, caracterizado.FK_Grupo, caracterizado.FK_Id_Linea_Atencion, 0)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                            </td>
                                            <td>
                                                <button v-bind:id="'pdf_'+caracterizado.PK_Id_Caracterizacion" class="btn btn-info" type="button" @click="pdfCaracterizacion(caracterizado.PK_Id_Caracterizacion, caracterizado.FK_Id_Linea_Atencion)" :disabled="(caracterizado.IN_Estado == null || caracterizado.IN_Estado == 0) ? true : false"><span class="fa fa-file-pdf" aria-hidden="true"></span></button>
                                            </td>
                                        </tr>           
                                    </tbody>
                                    
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="buscarGrupo">
                    <form id="form-datos-basicos">
                        <div class="text-left">
                            <div class="form-group">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Información general del grupo</div>
                            </div>
                            <div class="row form-group" v-show="busqueda_grupos">
                                <div class="col-lg-3">
                                    <label>Línea de Atención<span style="color:#cb0000"> *</span></label>
                                    <multiselect v-model="linea_atencion" label="text" :options="lista_lineas" placeholder="Seleccione una opción" :show-labels="false" track-by="value" @input="consultarGruposxLinea(); display = false;"></multiselect>
                                </div>

                                <div class="col-lg-3">
                                    <label>Grupo<span style="color:#cb0000"> *</span></label>
                                    <div v-show="loader_grupo" class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <multiselect v-model="id_grupo" label="text" :options="lista_grupos" placeholder="Seleccione una opción" :show-labels="false" track-by="value" @input="getFormGrupo(); display = false;"></multiselect>
                                </div>

                                <div class="col-lg-6">
                                </div>
                            </div>
                            <input type="hidden" name="id_caracterizacion_hidden" id="id_caracterizacion_hidden" v-model="id_caracterizacion_hidden">
                            <div id="formAE" v-show="FormAE">
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Fecha de Inicio del proceso<span style="color:#cb0000"> *</span></label>
                                        <input :disabled="(flagDisable!='')? true : false" class="form-control" v-model="formulario.fecha_inicio" type="date" min="1900-01-01" required>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label>Área Artística</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>{{info_grupo.areas_artisticas=== null ? '' :info_grupo.areas_artisticas.VC_Descripcion}}</small></p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Lugar de Atención</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else>{{info_grupo.lugar_atencion=== null ? '' : (linea_atencion.value === 2 ? info_grupo.lugar_atencion.VC_Nom_Clan:info_grupo.lugar_atencion.VC_Descripcion)}}</p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Artistas Formadores</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>
                                            <div v-for="(value, index) in info_grupo.artistas" :key="index.id">
                                            {{value.full_name}}
                                            </div>
                                        </small></p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>CREA al que pertenece el grupo</label>
                                        <small>
                                            <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                            <p v-else>{{info_grupo.crea.VC_Nom_Clan}}</p>
                                        </small>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label>Nombre de la IED</label>
                                        <p><small>{{infoColegio}}</small></p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Rango de Edades</label>
                                        <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.rango_edades_ae" label="text" :options="lista_rango_edades_ae" :multiple="true" placeholder="Seleccione las opciones que correspondan" :show-labels="false" track-by="value"></multiselect>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Nivel / Fase </label>
                                        <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.fase_ae" label="text" :options="lista_fase_ae" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Modalidad de Atención</label>
                                        <small>
                                            <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                            <p v-else>{{info_grupo.modalidad_atencion.VC_Descripcion}} - {{info_grupo.tipo_atencion.VC_Descripcion}}</p>
                                        </small>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Estrategias de Interacción</label>
                                        <small>
                                            <p v-if="info_grupo === null || (info_grupo.IN_modalidad_atencion in [1])"><i style="color:#B4B4B4"><small>No Aplica</small></i></p>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-else v-model="formulario.estrategias" label="text" :options="lista_estrategias_interaccion" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </small>
                                    </div>

                                <div class="col-lg-3">
                                        <label>Duración del Proceso (En semanas)</label>
                                        <input :disabled="(flagDisable!='')? true : false" v-model="formulario.duracion_proceso" class="form-control text-uppercase" placeholder="CANTIDAD SEMANAS" type="number">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Horario de Atención:</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>
                                            <div v-for="(value, index) in info_grupo.horarios" :key="index.id">
                                            {{value.IN_dia.toUpperCase() + " DE " + value.TI_hora_inicio_clase + " A " + value.TI_hora_fin_clase}}
                                            </div>
                                        </small></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="card-header bg-secondary text-white text-left"><i class="fa fa-address-card pr-4"></i>I. CARACTERIZACIÓN <small>(Se desarrolla en 4 sesiones presenciales o sincrónicas)</small></div>
                                </div>
                                <div class="alert alert-light m-2 justify-content-center" role="alert">
                                    <small><b>ORIENTACIÓN GENERAL:</b> Se parte de la posibilidad de diseñar y desarrollar diversas perspectivas de interacción con los participantes del proceso de formación, a partir de la activación de dinámicas de atenta escucha y percepción ampliada de condiciones, gustos, intereses, proyecciones, que permitan situar y contextualizar oportunidades de aprendizaje experiencial desde la exploración de diferentes lenguajes y prácticas artísticas.</small>
                                </div>
                                <div class="row m-2 pb-2 border border-success rounded">
                                    <p class="p-2 col-lg-12"><b>PRE–CARACTERIZACIÓN / INSUMOS PARA LA CARACTERIZACIÓN</b></p>
                                    <div class="row col-lg-12">
                                    </div>

                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>Tipo de Población:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.aspectos_genericos" label="text" :options="lista_aspectos_genericos" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Entidades Aliadas:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.entidades_aliadas" label="text" :options="lista_entidades_aliadas" placeholder="Seleccione una opción" :multiple="true" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Articulación Pedagógica:</label>
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" rows="2" v-model="formulario.text_articulacion_pedagogica" placeholder="CON QUÈ PROYECTO DE AULA, CICLO Y/O PROYECTO TRANSVERSAL SE DA LA ARTICULACIÓN PEDAGÓGICA"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-2 pb-2 border border-danger rounded">
                                    <p class="pt-2 pl-2 col-lg-12"><b>CARACTERIZACIÓN DEL GRUPO Y DE LOS PARTICIPANTES EN FORMACIÓN</b></p>
                                    <div class="alert alert-light ml-1 mr-1 justify-content-center" role="alert">
                                        <small>Tiene como objetivo dar cuenta de manera descriptiva de los intereses de los niños, niñas y adolescentes, relacionados con EL SER, EL CONOCER Y EL HACER: ¿Qué les gusta hacer?,¿Qué les alegra?, ¿A qué le tienen miedo?,¿Qué los sorprende?,¿Qué comen?,¿A qué juegan?,¿Qué pueden hacer?,¿Cómo pasan su tiempo?,¿Con quién comparten?,¿Cuáles son sus intereses?,¿Cómo viven la experiencia? ¿Cómo reaccionan a las provocaciones?¿ Cómo se relaciona con los demás?</small>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>Experiencia previa de formación artística:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.experiencia_previa" label="text" :options="lista_areas_artisticas" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-8">
                                            <label>Habilidades Generales e Intereses del Grupo:</label>
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" maxlenght="200" rows="2" v-model="formulario.text_habilidades_generales" placeholder="HABILIDADES GENERALES E INTERESES QUE SE IDENTIFIQUEN EN EL GRUPO (MÁXIMO 200 CARACTERES)"></textarea>
                                        </div>
                                    </div>
                                </div>   
                            </div>
                            
                            <div id="formIC" v-show="formIC">
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Fecha de Inicio del proceso<span style="color:#cb0000"> *</span></label>
                                        <input :disabled="(flagDisable!='')? true : false" class="form-control" v-model="formulario.fecha_inicio" type="date" min="1900-01-01" required>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label>Área Artística</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>{{info_grupo.areas_artisticas=== null ? '' :info_grupo.areas_artisticas.VC_Descripcion}}</small></p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Lugar de Atención</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else>{{info_grupo.lugar_atencion.VC_Nom_Clan}}</p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Artistas Formadores</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>
                                            <div v-for="(value, index) in info_grupo.artistas" :key="index.id">
                                            {{value.full_name}}
                                            </div>
                                        </small></p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>CREA al que pertenece el grupo</label>
                                        <small>
                                            <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                            <p v-else>{{info_grupo.crea.VC_Nom_Clan}}</p>
                                        </small>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label>Nombre del Colectivo</label>
                                        <input :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" v-model="formulario.text_nombre_institucion" placeholder="Nombre colectivo / entidad en alianza" type="text">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Rango de Edades</label>
                                        <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.rango_edades_ae" label="text" :options="lista_rango_edades_ae" :multiple="true" placeholder="Seleccione las opciones que correspondan" :show-labels="false" track-by="value"></multiselect>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Nivel / Fase </label>
                                        <p>{{tipoGrupo}}</p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Modalidad de Atención</label>
                                        <small>
                                            <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                            <p v-else>{{info_grupo.modalidad_atencion.VC_Descripcion}} - {{info_grupo.tipo_atencion.VC_Descripcion}}</p>
                                        </small>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Estrategias de Interacción</label>
                                        <small>
                                            <p v-if="info_grupo === null || (info_grupo.IN_modalidad_atencion in [1])"><i style="color:#B4B4B4"><small>No Aplica</small></i></p>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-else v-model="formulario.estrategias" label="text" :options="lista_estrategias_interaccion" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </small>
                                    </div>

                                <div class="col-lg-3">
                                        <label>Duración del Proceso (En semanas)</label>
                                        <input :disabled="(flagDisable!='')? true : false" v-model="formulario.duracion_proceso" class="form-control text-uppercase" placeholder="CANTIDAD SEMANAS" type="number">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Horario de Atención:</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>
                                            <div v-for="(value, index) in info_grupo.horarios" :key="index.id">
                                            {{value.IN_dia.toUpperCase() + " DE " + value.TI_hora_inicio_clase + " A " + value.TI_hora_fin_clase}}
                                            </div>
                                        </small></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="card-header bg-secondary text-white text-left"><i class="fa fa-address-card pr-4"></i>I. CARACTERIZACIÓN <small>(Se desarrolla en 4 sesiones presenciales o sincrónicas)</small></div>
                                </div>
                               <div class="alert alert-light ml-1 mr-1 justify-content-center" role="alert">
                                    <small>Lectura del grupo según sea parte de Manos a la Obra o Súbete a la Escena - Dar cuenta de antecedentes del grupo, o colectivo y sus conocimientos previos, intereses de exploración y creación artística.</small>
                                </div>
                                <div class="row m-2 pb-2 border border-success rounded">
                                    <p class="p-2 col-lg-12"><b>PRE–CARACTERIZACIÓN / INSUMOS PARA LA CARACTERIZACIÓN</b></p>
                                    <div class="row col-lg-6">
                                        <p class="p-2 col-lg-12"><b>Cercanía del CREA</b></p>
                                    </div>
                                    <div class="row col-lg-6">
                                        <p class="p-2 col-lg-12"><b>Cómo llegan al CREA</b></p>
                                    </div>
                                        <div class="row col-lg-3">
                                            <label>Muy cerca</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.mcerca" style="width : 70px;" class="form-control" id="mcerca" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Bicicleta</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.bicicleta" style="width : 70px;" class="form-control" id="bicicleta" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Cerca</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.cerca" style="width : 70px;" class="form-control" id="cerca" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Transporte público</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.publico" style="width : 70px;" class="form-control" id="publico" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Media</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.media" style="width : 70px;" class="form-control" id="media" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Transporte privado</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.privado" style="width : 70px;" class="form-control" id="privado" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Lejos</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.lejos" style="width : 70px;" class="form-control" id="lejos" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3">
                                            <label>Caminando</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.caminando" style="width : 70px;" class="form-control" id="caminando" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                         <div class="row col-lg-3">
                                            <label>Muy lejos</label>
                                        </div>
                                        <div class="row col-lg-3" align="left">
                                            <input :disabled="(flagDisable!='')? true : false" type="number" v-model="formulario.mlejos" style="width : 70px;" class="form-control" id="mlejos" placeholder="" min="0" max="100" required>
                                            <label><b>%</b></label>
                                        </div>
                                        <div class="row col-lg-3"></div>
                                        <div class="row col-lg-3" align="left"></div>
                                      
                                    <div class="row col-lg-12">
                                        <!--<div class="col-lg-4">
                                            <label>Cercanía del CREA:</label>
                                            <multiselect v-model="formulario.cercania_crea" label="text" :options="lista_cercania_crea" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Cómo llegan al CREA:</label>
                                            <multiselect v-model="formulario.llegada_crea" label="text" :options="lista_llegada_crea" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>-->
                                        <div class="col-lg-6">
                                            <label>Acceso a Internet:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.acceso_internet" label="text" :options="lista_si_no" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>¿Con qué dispositivos cuenta?:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.dispositivos" label="text" :options="lista_dispositivos" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-6">
                                            <label>¿Comparte el dispositivo?:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.comparte_dispositivo" label="text" :options="lista_si_no" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Estado de Avance del Grupo:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.estado_avance" label="text" :options="lista_estado_avance" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>Cambios del grupo y de los integrantes:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.cambio_grupo" label="text" :options="lista_cambio_grupo" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-8">
                                            <label>Comentarios Adicionales:</label>
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" rows="2" v-model="formulario.text_parrafo_complementario" placeholder="COMENTARIOS ADICIONALES"></textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row m-2 pb-2 border border-danger rounded">
                                    <p class="pt-2 pl-2 col-lg-12"><b>CARACTERIZACIÓN DEL GRUPO Y DE LOS PARTICIPANTES EN FORMACIÓN</b></p>
                                    <div class="alert alert-light ml-1 mr-1 justify-content-center" role="alert">
                                        <small>Lectura del grupo según sea parte de Manos a la Obra o Súbete a la Escena - Dar cuenta de antecedentes del grupo, o colectivo y sus conocimientos previos, intereses de exploración y creación artística</small>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>Experiencia previa de formación artística:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.experiencia_previa" label="text" :options="lista_areas_artisticas" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-8">
                                            <label>Apropiación Disciplinar:</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.apropiacion_disciplinar" label="text" :options="lista_apropiacion" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>
                                    <p class="pt-2 pl-2 col-lg-12"><b>INTERESES Y NECESIDADES DEL GRUPO</b></p>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>GENERALES</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_generales" label="text" :options="lista_intereses_generales" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>AUDIOVISUALES</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_audiovisuales" label="text" :options="lista_intereses_audiovisuales" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>TEATRO</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_teatro" label="text" :options="lista_intereses_teatro" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>DANZA</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_danza" label="text" :options="lista_intereses_danza" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>MÚSICA</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_musica" label="text" :options="lista_intereses_musica" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>ARTES PLÁSTICAS</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_artes_plasticas" label="text" :options="lista_intereses_artes_plasticas" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>CREACIÓN LITERARIA</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_creacion_literaria" label="text" :options="lista_intereses_creacion_literaria" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>ARTES ELECTRÓNICAS</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.intereses_artes_electronicas" label="text" :options="lista_intereses_artes_electronicas" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>NECESIDADES O ASPECTOS A FORTALECER</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.aspectos_fortalecer" label="text" :options="lista_aspectos_fortalecer" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>

                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>¿El grupo cuenta con un nombre?</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.grupo_tiene_nombre" label="text" :options="lista_si_no" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Identidad Gráfica</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.identidad_grafica" label="text" :options="lista_identidad_grafica" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Otros Rasgos de Identidad</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.otros_rasgos" label="text" :options="lista_otros_rasgos" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                    </div>

                                    <div class="row col-lg-12">
                                        <div class="col-lg-4">
                                            <label>Relación de los participantes con sus entornos, su territorio, sus contextos</label>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.relacion_participantes" label="text" :options="lista_relacion_participantes" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </div>
                                        <div class="col-lg-8">
                                            <label>Observaciones Adicionales:</label>
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" maxlenght="200" rows="2" v-model="formulario.text_habilidades_generales" placeholder="¿Cuál es el interés por la disciplina? (¿El interés en pertenecer a los colectivos Crea nace de ellos o de su núcleo familiar?) ¿Qué les gusta hacer? Temas sobre los que les gusta hablar/ Tipo de juego con los que suelen divertirse. Sensibilidades: ¿qué les da miedo?, ¿qué les hace sentir alegría? ¿en qué momentos se sienten tristes? ¿suelen sentirse ansiosos? ¿Cuáles son sus referentes visuales, sonoros, literarios? ¿Qué hacen en el tiempo libre?"></textarea>
                                        </div>
                                    </div>
                                </div>   
                            </div>

                            <div id="formCV" v-show="formCV">
                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Fecha de Inicio del proceso<span style="color:#cb0000"> *</span></label>
                                        <input :disabled="(flagDisable!='')? true : false" class="form-control" v-model="formulario.fecha_inicio" type="date" min="1900-01-01" required>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label>Área Artística</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>{{info_grupo.areas_artisticas=== null ? '' :info_grupo.areas_artisticas.VC_Descripcion}}</small></p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Lugar de Atención</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else>{{LugarAtencionCV}}</p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Artistas Formadores</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>
                                            <div v-for="(value, index) in info_grupo.artistas" :key="index.id">
                                            {{value.full_name}}
                                            </div>
                                        </small></p>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>CREA al que pertenece el grupo</label>
                                        <small>
                                            <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                            <p v-else>{{info_grupo.crea.VC_Nom_Clan}}</p>
                                        </small>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label>Nombre del Colectivo</label>
                                        <input :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" v-model="formulario.text_nombre_institucion" placeholder="Nombre colectivo / entidad en alianza" type="text">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Rango de Edades</label>
                                        <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.rango_edades_ae" label="text" :options="lista_rango_edades_ae" :multiple="true" placeholder="Seleccione las opciones que correspondan" :show-labels="false" track-by="value"></multiselect>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Grupo Poblacional</label>
                                        <multiselect :disabled="(flagDisable!='')? true : false" v-model="formulario.grupo_poblacional" label="text" :options="lista_grupo_poblacional_cv" :multiple="true" placeholder="Seleccione las opciones que correspondan" :show-labels="false" track-by="value"></multiselect>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label>Modalidad de Atención</label>
                                        <small>
                                            <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                            <p v-else>{{info_grupo.modalidad_atencion.VC_Descripcion}} - {{info_grupo.tipo_atencion.VC_Descripcion}}</p>
                                        </small>
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Estrategias de Interacción</label>
                                        <small>
                                            <p v-if="info_grupo === null || (info_grupo.IN_modalidad_atencion in [1])"><i style="color:#B4B4B4"><small>No Aplica</small></i></p>
                                            <multiselect :disabled="(flagDisable!='')? true : false" v-else v-model="formulario.estrategias" label="text" :options="lista_estrategias_interaccion" :multiple="true" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                                        </small>
                                    </div>

                                <div class="col-lg-3">
                                        <label>Duración del Proceso (En semanas)</label>
                                        <input :disabled="(flagDisable!='')? true : false" v-model="formulario.duracion_proceso" class="form-control text-uppercase" placeholder="CANTIDAD SEMANAS" type="number">
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Horario de Atención:</label>
                                        <p v-if="info_grupo === null"><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></p>
                                        <p v-else><small>
                                            <div v-for="(value, index) in info_grupo.horarios" :key="index.id">
                                            {{value.IN_dia.toUpperCase() + " DE " + value.TI_hora_inicio_clase + " A " + value.TI_hora_fin_clase}}
                                            </div>
                                        </small></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="card-header bg-secondary text-white text-left"><i class="fa fa-address-card pr-4"></i>I. CARACTERIZACIÓN <small>(Se desarrolla en 4 sesiones presenciales o sincrónicas)</small></div>
                                </div>
                               <div class="alert alert-light ml-1 mr-1 justify-content-center" role="alert">
                                    <small><b>ORIENTACIÓN GENERAL:</b> Se parte de la posibilidad de diseñar y desarrollar diversas perspectivas de interacción con los participantes del proceso de formación, a partir de la activación de dinámicas de atenta escucha y percepción ampliada de condiciones, gustos, intereses, proyecciones, que permitan situar y contextualizar oportunidades de aprendizaje experiencial desde la exploración de diferentes lenguajes y prácticas artísticas.</small>
                                </div>
                                <div class="row m-2 pb-2 border border-success rounded">
                                    <p class="p-2 col-lg-12"><b>PRE–CARACTERIZACIÓN / INSUMOS PARA LA CARACTERIZACIÓN</b></p>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-8">
                                            <label>Descripción sociodemográfica de la población y contexto de las poblaciones:</label>
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" maxlenght="200" rows="2" v-model="formulario.text_descripcion_contexto" placeholder="Descripción sociodemográfica de la población y contexto de las poblaciones"></textarea>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Movilidad (Cambios del grupo y de los integrantes):</label>
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" maxlenght="100" rows="2" v-model="formulario.text_movilidad" placeholder="Movilidad (Cambios del grupo y de los integrantes)"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-2 pb-2 border border-danger rounded">
                                    <p class="pt-2 pl-2 col-lg-12"><b>CARACTERIZACIÓN DEL GRUPO Y DE LOS PARTICIPANTES EN FORMACIÓN</b></p>
                                    <div class="alert alert-light ml-1 mr-1 justify-content-center" role="alert">
                                        <small>Caracterización de intereses de los participantes, situación, condición y proyección del espacio de interacción y creación artística. Experiencia y conocimientos del grupo en relación con las áreas artísticas (Danza, teatro, artes plásticas, artes electrónicas, audiovisuales, música, creación literaria, otras). Intereses, oportunidades y necesidades recurrentes del artista formador. Oportunidades y necesidades del grupo.</small>
                                    </div>
                                    <div class="row col-lg-12">
                                        <div class="col-lg-8">
                                            <textarea :disabled="(flagDisable!='')? true : false" class="form-control text-uppercase" maxlenght="200" rows="2" v-model="formulario.caracterizacion_converge" placeholder="Experiencia y conocimientos del grupo en relación con las áreas artísticas (Danza, teatro, artes plásticas, artes electrónicas, audiovisuales, música, creación literaria, otras). Intereses, oportunidades y necesidades recurrentes del artista formador. Oportunidades y necesidades del grupo. (MÁXIMO 200 CARACTERES)"></textarea>
                                        </div>
                                        <div class="col-lg-4">
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="col-md-12" id="txObserRevi" v-show="txObserRevi">
                            <div class="col-md-12">
                                <label>OBSERVACIONES:</label>
                            </div>
                            <div class="col-md-12">
                                <textarea :disabled="blockTxObserRevi" v-show="txObserRevi" v-model="txRevision" name="txRevision" id="txRevision" class="form-control" placeholder="Escribir aquí las observaciones generales" rows="2" required></textarea>
                            </div>
                        </div>
                        <div class="text-left">
                            <div class="form-group pt-2 row justify-content-center">
                                <div class="col-sm-4 text-center"></div>
                                <div v-show="checkApprove" class="col-sm-4 text-center">
                                    <center>
                                        <table>
                                            <tr>
                                                <td>Devolver</td>
                                                <td>
                                                    <div class="custom-control custom-switch ml-2">
                                                        <input type="checkbox" class="custom-control-input" id="switchAprobacion" v-model="switch_aprobacion">
                                                        <label class="custom-control-label" for="switchAprobacion"></label>
                                                    </div>
                                                </td>
                                                <td>Visto Bueno</td>
                                            </tr>
                                        </table>
                                    </center>
                                </div>
                                <div v-show="checkSave" class="col-sm-4 text-center">
                                    <center>
                                        <table>
                                            <tr>
                                                <td>Borrador</td>
                                                <td>
                                                    <div class="custom-control custom-switch ml-2">
                                                        <input type="checkbox" class="custom-control-input" id="switchGuardado" v-model="switch_guardado">
                                                        <label class="custom-control-label" for="switchGuardado"></label>
                                                    </div>
                                                </td>
                                                <td>Finalizado</td>
                                            </tr>
                                        </table>
                                    </center>
                                </div>
                                <div class="col-sm-4 text-center">
                                    <button v-show="btnSave" class="btn btn-info" type="button" @click="guardarInformacion"><span class="fa fa-check-circle" aria-hidden="true"></span> Guardar</button>
                                    <button v-show="btnApprove" class="btn btn-info" type="button" @click="aprobar(flagDisable)"><span class="fa fa-check-circle" aria-hidden="true"></span> Confirmar</button>
                                </div>
                            </div>

                        </div>
                    </form>
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
    import datatable from "datatables.net-bs4";
    import Sweetalert2 from 'sweetalert2';
    import { forEach } from 'jszip';
    import Vue from 'vue';

    export default {
        components: { 
            Multiselect
        },
        data () {
            return {
                flagDisable: "",
                FormAE: false,
                formIC: false,
                formCV: false,
                id_usuario: "",
                formulario: {},
                listado_activos: [],
                lista_lineas:[],
                lista_grupos: [],
                lista_fase_ae: [],
                lista_apropiacion:[],
                blockTxObserRevi: false,
                lista_aspectos_genericos: [],
                lista_entidades_aliadas: [],
                lista_areas_artisticas: [],
                lista_habilidades_generales: [],
                lista_intereses_grupo: [],
                lista_estrategias_interaccion: [],
                lista_intereses_generales: [],
                lista_intereses_audiovisuales: [],
                lista_intereses_teatro: [],
                lista_intereses_danza: [],
                lista_intereses_musica: [],
                lista_intereses_artes_plasticas: [],
                lista_intereses_creacion_literaria: [],
                lista_intereses_artes_electronicas: [],
                lista_aspectos_fortalecer: [],
                lista_identidad_grafica: [],
                busqueda_grupos: true,
                lista_otros_rasgos: [],
                lista_relacion_participantes: [],
                linea_atencion: "",
                fase_ae: "",
                id_caracterizacion_hidden: null,
                formInicial: true,
                buscarGrupo: false,
                tipoGrupo:"",
                id_grupo: "",
                loader_grupo: false,
                info_grupo: null,
                detalleForm: false,
                fecha_inicio: "",
                grupo_poblacional: "",
                text_otro_fase_ae: "",
                ShowTextOtroFaseAE: false,
                rango_edades_ae: "",
                lista_rango_edades_ae: [],
                caracterizaciones: [],
                duracion_proceso: "",
                lista_duracion_proceso: [],
                lista_grupo_poblacional_cv: [],
                text_otro_duracion_proceso: "",
                switch_guardado: false,
                switch_aprobacion: false,
                btnApprove:false,
                btnSave:true,
                checkSave:true,
                checkApprove:false,
                infoColegio: "",
                lista_dispositivos: [],
                lista_si_no: [], 
                lista_llegada_crea: [], 
                lista_cercania_crea: [], 
                lista_estado_avance: [], 
                lista_cambio_grupo: [],
                LugarAtencionCV: "",
                formTableEdit: true,
                idTipoInforme: "",
                selectTipoInforme: [{"text":"Caracterizaciones Propias","value":0},{"text":"Caracterizaciones a Supervisar","value":1}],
                idEstado: "", 
                selectEstado: [{"text":"Revisados","value":0},{"text":"Devueltos","value":1},{"text":"En proceso de Revisión","value":2}],
                txObserRevi:false,
                txRevision:"",
                base:'',
            }
        },
        mounted() {

            this.listado_activos = $("#procesos_activos").DataTable(this.config_tabla);
            this.getIdPersona();
            setTimeout(function(){ vm.getRolPersona(); }, 2500);

            const vm = this;
            setTimeout(function(){ vm.getInfoTableEdit(); }, 3000);
        },
        methods: {

            tabla(){
                Vue.nextTick(function () {
                    $('#tableEdicion').DataTable();
                });
            },

            getRolPersona(){
				axios
				.post("/sif/framework/personas/getRolPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_usuario,
				})
				.then(response => {
					this.id_rol = response.data.FK_Tipo_Persona;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},
            getListas() {
                var listas = [
                    {'i': 6, 'valor':"lista_areas_artisticas"},
                    {'i': 60, 'valor':"lista_lineas"},
                    {'i': 89, 'valor':"lista_fase_ae"},
                    {'i': 90, 'valor':"lista_rango_edades_ae"},
                    {'i': 91, 'valor':"lista_entidades_aliadas"},
                    {'i': 91, 'valor':"lista_entidades_aliadas"},
                    {'i': 99, 'valor':"lista_estrategias_interaccion"},
                    {'i': 100, 'valor':"lista_aspectos_genericos"},   
                    {'i': 104, 'valor':"lista_dispositivos"},
                    {'i': 105, 'valor':"lista_estado_avance"},
                    {'i': 106, 'valor':"lista_cambio_grupo"},
                    {'i': 107, 'valor':"lista_apropiacion"},
                    {'i': 108, 'valor':"lista_intereses_generales"},
                    {'i': 109, 'valor':"lista_intereses_audiovisuales"},
                    {'i': 110, 'valor':"lista_intereses_teatro"},
                    {'i': 111, 'valor':"lista_intereses_danza"},
                    {'i': 112, 'valor':"lista_intereses_musica"},
                    {'i': 113, 'valor':"lista_intereses_artes_plasticas"},
                    {'i': 114, 'valor':"lista_intereses_creacion_literaria"},
                    {'i': 115, 'valor':"lista_intereses_artes_electronicas"},
                    {'i': 116, 'valor':"lista_aspectos_fortalecer"},
                    {'i': 117, 'valor':"lista_identidad_grafica"},
                    {'i': 118, 'valor':"lista_otros_rasgos"},
                    {'i': 119, 'valor':"lista_relacion_participantes"},
                    {'i': 120, 'valor':"lista_grupo_poblacional_cv"},
                ];
                listas.forEach((value) => {
                    this.getInfoSelectorAdicional(value.i, value.valor);
                });
            },
            getInfoSelectorAdicional(Id_Parametro, arreglo){
				axios
                    .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: Id_Parametro
                })
				.then(response => {
                    this[arreglo] = response.data;
                })
				.catch(error => {
					console.log("No se puede cargar la información de Listas");
				});
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
            generarFormularioIncial(){
                this.getListas();
                this.busqueda_grupos = true;
                Swal.fire({
                    title: "Generando el fomulario",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                this.formInicial = false;
                this.detalleForm = false;
                this.buscarGrupo = true;
                Swal.close();

            },
            consultarGruposxLinea() {
                this.detalleForm = false;
                this.FormAE = false;
                this.formIC = false;
                this.formCV = false;
                this.lista_grupos = [];
                if(this.linea_atencion === null) {
                    return false;
                }
                this.loader_grupo = true;
                axios
				.post("/sif/framework/componentePedagogico/getGruposLinea", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "linea_atencion": this.linea_atencion.value,
                    "id_usuario": this.id_usuario
				})
				.then(response => {
                    this.loader_grupo = false;
                    this.lista_grupos = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "Usted no posee grupos asignados para esta línea, comuníquese con el administrador del sistema", "error");
				});
            }, 
            getFormGrupo() {
                if(this.id_grupo === null) {
                    return false;
                }
                Swal.fire({
                    title: "Consultando la Información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                axios
				.post("/sif/framework/componentePedagogico/getInformacionGrupo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "linea_atencion": this.linea_atencion.value,
                    "id_grupo": this.id_grupo.value
				})
				.then(response => {
                    this.info_grupo = response.data;
                    this.detalleForm = true;
                    if(this.linea_atencion.value === 1) {
                        this.FormAE = true;
                        this.formIC = false;
                        this.formCV = false;
                        this.infoColegio = this.info_grupo.colegio.VC_Nom_Colegio;
                    } else if(this.linea_atencion.value === 2) {
                        this.FormAE = false;
                        this.formIC = true;
                        this.formCV = false;
                        this.tipoGrupo = this.info_grupo.tipo_grupo == '1' ? 'Manos a la obra' : 'Súbete a la escena';
                        this.lista_si_no = [{"text":"SI","value":1},{"text":"NO","value":2}];
                    } else if(this.linea_atencion.value === 3) {
                        this.FormAE = false;
                        this.formIC = false;
                        this.formCV = true;
                        if(this.info_grupo.IN_modalidad_atencion === 3) {
                            this.LugarAtencionCV = this.info_grupo.lugar_atencion.VC_Descripcion;
                        } else if(this.info_grupo.IN_modalidad_atencion === 1) {
                            this.LugarAtencionCV = this.info_grupo.crea.VC_Nom_Clan;
                        } else {
                            this.LugarAtencionCV = this.info_grupo.modalidad_atencion.VC_Descripcion;
                        }
                    }
                    Swal.close();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el formulario, por favor inténtelo nuevamente", "error");
				});
            },
            getInfoGrupo(idGrupo, idLinea) {
                Swal.fire({
                    title: "Consultando la Información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                axios
				.post("/sif/framework/componentePedagogico/getInformacionGrupo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "linea_atencion": idLinea,
                    "id_grupo": idGrupo
				})
				.then(response => {
                    this.info_grupo = response.data;
                    this.detalleForm = true;
                    if(idLinea === "1") {
                        this.FormAE = true;
                        this.formIC = false;
                        this.formCV = false;
                        this.infoColegio = this.info_grupo.colegio.VC_Nom_Colegio;
                    } else if(idLinea === "2") {
                        this.FormAE = false;
                        this.formIC = true;
                        this.formCV = false;
                        this.tipoGrupo = this.info_grupo.tipo_grupo == '1' ? 'Manos a la obra' : 'Súbete a la escena';
                    } else if(idLinea === "3") {
                        this.FormAE = false;
                        this.formIC = false;
                        this.formCV = true;
                        if(this.info_grupo.IN_modalidad_atencion === 3) {
                            this.LugarAtencionCV = this.info_grupo.lugar_atencion.VC_Descripcion;
                        } else if(this.info_grupo.IN_modalidad_atencion === 1) {
                            this.LugarAtencionCV = this.info_grupo.crea.VC_Nom_Clan;
                        } else {
                            this.LugarAtencionCV = this.info_grupo.modalidad_atencion.VC_Descripcion;
                        }
                    }
                    Swal.close();
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el formulario, por favor inténtelo nuevamente", "error");
				});
            },
            getInfoTableEdit(){
				axios
                    .post("/sif/framework/componentePedagogico/getInfoTableEditCaracterizacion", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_usuario,
                    "tipo": this.idTipoInforme.value,
                    "estado": this.idEstado.value,
                })
                    .then(response => {
                        this.caracterizaciones = response.data;
                        this.tabla();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            guardarInformacion(){
                Swal.fire({
                    title: "Almacenando la Información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                
                axios
				.post("/sif/framework/componentePedagogico/guardarCaracterizacionGrupo", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "linea_atencion": this.linea_atencion.value,
                    "id_grupo": this.id_grupo.value,
                    "formulario": JSON.stringify(this.formulario),
                    "finalizado": this.switch_guardado,
                    "id_usuario": this.id_usuario,
                    "hidden_caracterizacion": this.id_caracterizacion_hidden,
				})
				.then(response => {
                    if(response.PK_Id_Caracterizacion !== null) {
                        Swal.fire(
                            'Información Almacenada Correctamente',
                            "La información ha sido almacenada de manera satisfactoria",
                            'info'
                        );
                        this.formInicial = true;
                        this.buscarGrupo = false;
                        this.getInfoTableEdit();
                    }
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el formulario, por favor inténtelo nuevamente", "error");
				});
            },
            editCaracterizacion(idCaracterizacion, idGrupo, idLinea){
                
                Swal.fire({
                    title: "Cargando información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
               
                axios
                .post("/sif/framework/componentePedagogico/getCaracterizacionEdit",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idCaracterizacion": idCaracterizacion,
                })
				.then(response => {

                    this.dataPlanea = response.data;
                    this.busqueda_grupos = false;
                    this.getListas();
                    this.getInfoGrupo(idGrupo, idLinea);
                    if(response.data.IN_Estado === 0) {
                        this.txObserRevi = true;
                        this.blockTxObserRevi = true;
                        this.txRevision = response.data.TX_Observaciones;
                    } else {
                        this.txObserRevi = false;
                        this.blockTxObserRevi = false;
                        this.txRevision = "";
                    }
                    this.formulario = JSON.parse(this.dataPlanea.JSON_formulario);
                    this.formulario = JSON.parse(this.formulario);
                    
                    this.buscarGrupo = true;
                    this.formInicial = false;
                    this.id_caracterizacion_hidden = idCaracterizacion;
                    Swal.close();
				})
				.catch(error => {
					console.log("No se puede cargar la información"+error);
				});
            },
            revCaracterizacion(idCaracterizacion, idGrupo, idLinea, ident){
               
                Swal.fire({
                    title: "Cargando información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
               
                axios
                .post("/sif/framework/componentePedagogico/getCaracterizacionEdit",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idCaracterizacion": idCaracterizacion,
                })
				.then(response => {
                    this.dataPlanea = response.data;
                    this.getListas();
                    this.getInfoGrupo(idGrupo, idLinea);

                    if (ident == 0) {
                        this.btnApprove = false;
                        this.btnSave = false;
                        this.checkSave = false;
                        this.checkApprove = false;
                        this.txObserRevi = true;
                        $("txObserRevi").prop('disabled', true);
                    }else{
                        this.btnApprove = true;
                        this.btnSave = false;
                        this.checkSave = false;
                        this.checkApprove = true;
                        this.txObserRevi = true;
                        $("txObserRevi").prop('disabled', false);
                    }
                    this.formulario = JSON.parse(this.dataPlanea.JSON_formulario);
                    this.formulario = JSON.parse(this.formulario);
                    
                    this.flagDisable = idCaracterizacion;
                    this.buscarGrupo = true;
                    this.formInicial = false;
                    this.busqueda_grupos = false;
                    this.detalleForm = false;
                    this.FormAE = false;
                    this.formIC = false;
                    this.formCV = false;
                    
                    if (idLinea == '1') {
                        this.FormAE = true;
                    } else if (idLinea == '2') {
                        this.formIC = true;
                    } else if (idLinea == '3') {
                        this.formCV = true;
                    }
                    //this.lineaAtencion = this.dataPlanea.FK_Id_Linea_atencion;
                    //this.idGrupo = idGrupo;
                    //this.formTable = false;
                    //this.formTableEdit = false;
                    
                    Swal.close();
                })
				.catch(error => {
					console.log("No se puede cargar la información");
				});
            },

            aprobar(idCaracterizacion){
                
                this.switch_aprobacion = $("#switchAprobacion").is(':checked');

                axios
                    .post("/sif/framework/componentePedagogico/registerApprovalCaracter", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_caracterizacion": idCaracterizacion,
                    "checkApprove":this.switch_aprobacion,
                    "observacionApprove":this.txRevision,
                    "id_persona": this.id_usuario,
                })
                    .then(response => {
        
                        if(response.data === true) {
                            Swal.fire(
                                'Información Almacenada',
                                "Se ha guardado correctamente la Aprobación",
                                'success'  
                            );            
                        }else {
                            Swal.fire(
                                'Atención!',
                                "No se puede almacenar la Aprobación",
                                'error'
                            );
                        }
                        this.formInicial = true;
                        this.buscarGrupo = false;
                        this.getInfoTableEdit();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            pdfCaracterizacion(idInforme, idLinea){
                window.open(this.base + '/sif/framework/componentePedagogico/pdfCaracterizacion/'+ idInforme + '/' + idLinea);
            },
            
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>