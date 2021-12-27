<template>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header text-muted">
                <h2 class="m-0">Formato Pedagógico General - Planeación</h2>
            </div>

            <div class="card-body text-center">
                <div v-show="formTable">
                    <center>
                        <div class="alert alert-light m-2 col-sm-8" role="alert">
                            <small>A continuación se detallan los procesos que actualmente se encuentran activos:</small>
                        </div>
                    </center>

                    <div class="row form-group justify-content-center">
                        <div class="col-sm-8">
                            <table id="tablePlaneacion" name="tablePlaneacion" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Grupo</th>
                                        <th>Línea de Atención</th>
                                        <th>Colegio o Crea</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(caracterizado,i) in caracterizados" :key="i">
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 1"><b>AE-{{caracterizado.FK_Grupo}}</b></td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 2"><b>IC-{{caracterizado.FK_Grupo}}</b></td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 3"><b>CV-{{caracterizado.FK_Grupo}}</b></td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 1">Arte en la escuela</td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 2">Impulso Colectivo</td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 3">Converge</td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 1">{{caracterizado.grupo_arte.colegio.VC_Nom_Colegio}}</td>
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 2">{{caracterizado.grupo_impulso.crea.VC_Nom_Clan}}</td><!--caracterizado.grupo_impulso.crea.VC_Nom_Clan-->
                                        <td v-if="caracterizado.FK_Id_Linea_Atencion == 3">{{caracterizado.grupo_converge.colegio.VC_Nom_Colegio}}</td><!--{caracterizado.grupo_converge.colegio.VC_Nom_Colegio-->
                                        <td>
                                            <span v-if="caracterizado.IN_Estado == null" class="badge badge-btn-warning">en proceso de Revisión Caracterización</span>
                                            <span v-if="caracterizado.IN_Estado == 0" class="badge badge-danger">Devuelto Caracterización</span>
                                            <span v-if="caracterizado.IN_Estado == 1" class="badge badge-success">Revisado Caracterización</span>
                                        </td>
                                        <td>
                                            <button v-bind:id="'next_'+caracterizado.PK_Id_Caracterizacion" class="btn btn-info" type="button"  @click="register(caracterizado.FK_Id_Linea_Atencion, caracterizado.FK_Grupo, caracterizado.PK_Id_Caracterizacion)" :disabled="(caracterizado.IN_Estado == null || caracterizado.IN_Estado == 0) ? true : false">Planeación</button>
                                        </td>
                                    </tr>           
                                </tbody>
                                
                            </table>
                            
                        </div>
                    </div>
                </div>
                <div v-show="formTableEdit">
                    <center>
                        <div class="alert alert-light m-2 col-sm-8" role="alert">
                            <small>A continuación se detallan los procesos de planeación que actualmente se encuentran para edición:</small>
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
                                    <tr v-for="(planeado,i) in planeaciones" :key="i">
                                        <td v-if="planeado.FK_Id_Linea_atencion == 1"><b>AE-{{planeado.FK_grupo}}</b></td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 2"><b>IC-{{planeado.FK_grupo}}</b></td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 3"><b>CV-{{planeado.FK_grupo}}</b></td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 1">Arte en la escuela</td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 2">Impulso Colectivo</td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 3">Converge</td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 1">{{planeado.grupo_arte.colegio.VC_Nom_Colegio}}</td>
                                        <td v-if="planeado.FK_Id_Linea_atencion == 2">{{planeado.grupo_impulso.crea.VC_Nom_Clan}}</td> <!--planeado.grupo_impulso.crea.VC_Nom_Clan-->
                                        <td v-if="planeado.FK_Id_Linea_atencion == 3">{{planeado.grupo_converge.colegio.VC_Nom_Colegio}}</td>
                                    
                                        <td>
                                            <span v-if="planeado.IN_Estado == null && planeado.IN_Finalizado == 1" class="badge badge-warning">en proceso de Revisión Planeación</span>
                                            <span v-if="planeado.IN_Estado == 0" class="badge badge-danger">Devuelto Planeación</span>
                                            <span v-if="planeado.IN_Estado == 1" class="badge badge-success">Revisado Planeación</span>

                                            <span v-if="planeado.IN_Finalizado == 0" class="badge badge-danger">Sin Finalizar</span>
                                            <span v-if="planeado.IN_Finalizado == 1" class="badge badge-success">Finalizado</span>
                                        </td>
                                        <td>
                                            <button v-if="planeado.IN_Finalizado == 0" v-bind:id="'edit_'+planeado.PK_Id_Planeacion" class="btn btn-warning editPlaneacion" type="button" @click="editPlaneacion(planeado.PK_Id_Planeacion, planeado.FK_grupo, planeado.FK_Id_Linea_atencion)"><span class="fa fa-edit" aria-hidden="true"></span></button>
                                            <button v-if="planeado.IN_Finalizado == 1 && (id_rol == 30 || id_rol == 35)" v-bind:id="'rev_'+planeado.PK_Id_Planeacion" class="btn btn-primary revisarPlaneacion" type="button" @click="revPlaneacion(planeado.PK_Id_Planeacion, planeado.FK_grupo, planeado.FK_Id_Linea_atencion, 1)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                            <button v-if="planeado.IN_Finalizado == 1 && (id_rol != 30 && id_rol != 35)" v-bind:id="'view_'+planeado.PK_Id_Planeacion" class="btn btn-dark visualizarPlaneacion" type="button" @click="revPlaneacion(planeado.PK_Id_Planeacion, planeado.FK_grupo, planeado.FK_Id_Linea_atencion, 0)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                        </td>
                                        <td>
                                             <button v-bind:id="'pdf_'+planeado.PK_Id_Planeacion" class="btn btn-info" type="button" @click="pdfPlaneacion(planeado.PK_Id_Planeacion, planeado.FK_Id_Linea_atencion)" :disabled="(planeado.IN_Estado == null || planeado.IN_Estado == 0) ? true : false"><span class="fa fa-file-pdf" aria-hidden="true"></span></button>
                                        </td>
                                    </tr>           
                                </tbody>
                                
                            </table>
                            
                        </div>
                    </div>
                </div>

                <div id="formPlaneacion" v-show="formPlaneacion">
                    <form id = "formPlaneacionSave">
                        <div class="row">
                            <input type="hidden" name="id_planeacion_hidden" id="id_planeacion_hidden" v-model="id_planeacion_hidden">
                            <input type="hidden" name="id_caracterizacion_hidden" id="id_caracterizacion_hidden" v-model="id_caracterizacion_hidden">
                            <input type="hidden" name="id_linea_ae_hidden" id="id_linea_ae_hidden" v-model="id_linea_ae_hidden">
                            <div class="col-md-12" v-show="detalleForm">
                                <div class="col-md-12">
                                    <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Planeación del proceso formativo</div>
                                </div>
                                <div class="col-md-12"><br><br></div>
                                <div class="row">
                                    <div class="col">
                                        <label>Fecha de inicio de planeación:</label>
                                    </div>
                                    <div class="col">
                                        <input class="form-control" v-model="formulario.dateStart" type="date" min="1900-01-01" :disabled="(flagDisable!='')? true : false" required>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <label>ORIENTACIÓN GENERAL:</label>
                                </div>
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>A partir del reconocimiento de intereses, gustos, proyecciones, oportunidades de aprendizaje, se definen en conjunto con los participantes, las rutas, formas, medios para el logro de las experiencias de aprendizaje y creación artística con el grupo.</small>
                                    </div>
                                </center>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12 text-left">
                                    <label>OBJETIVOS GENERAL DEL PROCESO DE FORMACIÓN:</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.objetivos" placeholder="Evidenciar articulaciones entre las nociones transversales y los propósitos del proceso pedagógico." :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12 text-left">
                                    <label>OBJETIVOS ESPECÍFICOS:</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.especificos" placeholder="Enunciar las metas a alcanzar que resuelven el propósito principal (objetivo general).(Debe iniciar con un verbo en infinitivo. Estas son acciones esenciales para alcanzar el objetivo general. Plantear mínimo tres o cuatro.) Para la Línea Arte en la escuela, se sugiere formular los objetivos atendiendo a las dimensiones:(maneras de pensar - cognitivo) / (maneras de socializar - Socio-Afectivo Convivencial) / (prácticas artísticas disciplinares - Físico-creativo)" :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-12"><br></div>
                                 <div class="col-md-12 text-left">
                                    <label>PREGUNTAS ORIENTADORAS:</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.preguntas" placeholder="En relación a las premisas y las nociones transversales y los propósitos del proceso. (cuerpo, Territorio, juego, creación (seleccionar una o varias),(Diseñadas en conjunto con Enlaces y Acompañamiento pedagógico)" :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12 text-left">
                                    <label>TEMAS PROPUESTOS:</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.temas" placeholder="(De acuerdo a la caracterización y acuerdos de articulación con la institución)" :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12 text-left">
                                    <label>INTENCIONALIDAD PEDAGÓGICA – PROPÓSITO</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.intencion" placeholder="¿por qué y para qué? ¿expectativas? ¿En qué se concreta o materializa? / (Breve descripción de la proyección de resultados del proceso formativos / pieza, obra, repertorio, acción, dispositivo, performance, instalación, otras__(se definen de acuerdo a las líneas y las áreas)" :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row">
                                    <div class="col-md-4" align="left">
                                    <label>METODOLOGÍAS Y MEDIACIONES DIDÁCTICAS</label>
                                    </div>
                                    <div class="col-md-4">
                                        <multiselect v-model="formulario.metodologia" label="text" :options="optionMetodologia" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :multiple="true" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" v-model="formulario.textoComp" placeholder="Texto Complementario" type="text" :disabled="(flagDisable!='')? true : false">
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12" align="left">
                                    <label>REFERENTES</label>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row">
                                    <div class="col" align="left">
                                        <textarea class="form-control" rows="2" v-model="formulario.pedagogico" placeholder="Indicar en este campo los referentes pedagógicos, disciplinares, artísticos y otros que están ligados con las preguntas orientadoras, temas u objetivos.(Defina el referente ya sea bibliografico, webgrafia u otros)" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                    <div class="col" align="left">
                                        <label>INSUMOS:</label>
                                        <textarea class="form-control" rows="2" v-model="formulario.insumos" placeholder="Materias / Materiales / Instrumentos / Herramientas" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>PLANEADOR DEL PROCESO FORMATIVO</div>
                                </div>
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>Para el diligenciamiento de las experiencias artísticas en cada semana, tenga en cuenta los momentos de la formación, y por favor escriba las acciones a realizar de acuerdo a los tiempos proyectados en su planeación.<br> Momentos de la formación:  a.Sensibilización y exploración / b. Descubrimiento/ c. Indagación y experimentación/ d. Exploración y apropiación vocacional<br>Enunciar la estrategia, acorde con los objetivos planteados y el momento del proceso.</small>
                                    </div>
                                </center>
                                <div class="col-md-12"><br></div>
                                <!--<div class="row">
                                    <div class="col-md-6">
                                        <label>Fecha de inicio:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" v-model="formulario.inicioPlan" type="date" min="1900-01-01" :disabled="(flagDisable!='')? true : false" required>
                                    </div>
                                </div>-->
                                <div class="col-md-12"><br></div>
                                <div class="col-md-4" align="left">
                                    <button class="btn btn-info" type="button" @click="agregarFila++" :disabled="(flagDisable!='')? true : false"><span class="fa fa-plus" aria-hidden="true"></span> Registrar Semana</button>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12">
                                    <div class="col-md-2">
                                        <label>Semana</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Momento</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Fecha Fin</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Descripción</label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12" v-for="(obligacion,i) in agregarFila" :key="i">  
                                    <div class="col-md-2">
                                        <label>Semana {{i+1}}</label>
                                    </div>
                                    <div class="col-md-2"> 
                                        <select class="form-control selectsMoment" v-model="moment[i]" v-bind:id="'selectsMoment'+i" v-bind:name="'selectsMoment[]'" label="text" placeholder="Seleccione una opción" :disabled="(flagDisable!='')? true : false">
                                            <option v-for="option in selectMoment" :key="option.value" :value="option.value">
                                                {{ option.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" v-model="fecha[i]" v-bind:id="'fecha'+i" v-bind:name="'fecha[]'" type="date" min="1900-01-01" required :disabled="(flagDisable!='')? true : false">
                                    </div>
                                    <div class="col-md-6">
                                        <textarea v-model="week[i]" v-bind:name="'txWeek[]'" v-bind:id="'txWeek_'+i" class="form-control" placeholder="Mencionar las acciones propuestas para esta semana de manera clara y detallada" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                    <div class="col-md-12" id="txObserRevi" v-show="txObserRevi">
                                        <div class="col-md-12">
                                            <label>OBSERVACIONES:</label>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea v-show="txObserRevi" v-model="txRevision" name="txRevision" id="txRevision" class="form-control" placeholder="Escribir aquí las observaciones generales" rows="2" :disabled="(id_rol != 30 || id_rol != 35)? true : false" required></textarea>
                                        </div>
                                    </div>
                                <div class="col-md-12"><br><br></div>
                                <div class="form-group pt-2 row justify-content-center">
                                    <div class="col-sm-4 text-center"></div>
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
                                    <div class="col-sm-4 text-center">
                                        <button v-show="btnSave" class="btn btn-info" type="button" @click="guardarInformacion()"><span class="fa fa-check-circle" aria-hidden="true"></span> Guardar</button>
                                        <button v-show="btnApprove" class="btn btn-info" type="button" @click="aprobar(flagDisable, id_linea_ae_hidden)"><span class="fa fa-check-circle" aria-hidden="true"></span> Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="formPlaneacionIc" v-show="formPlaneacionIc"> 
                    <form id = "formPlaneacionIcSave">
                        <div class="row">
                            <input type="hidden" name="id_impulso_hidden" id="id_impulso_hidden" v-model="id_impulso_hidden">
                            <input type="hidden" name="id_caracterizacion_hidden" id="id_caracterizacion_hidden" v-model="id_caracterizacion_hidden">
                            <input type="hidden" name="id_linea_ic_hidden" id="id_linea_ic_hidden" v-model="id_linea_cv_hidden">
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Estructura del proyecto artístico</div>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col">
                                <label>Fecha de inicio de planeación:</label>
                            </div>
                            <div class="col">
                                <input class="form-control" v-model="formularioIc.dateStartIc" type="date" min="1900-01-01" :disabled="(flagDisable!='')? true : false" required>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Descripción general del proyecto:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.descripcionIc" :disabled="(flagDisable!='')? true : false" placeholder="(Describa de manera general las particularidades del proyecto artístico propuesto desde la línea Impulso Colectivo, mencionando su propósito ¿En qué consiste?) este se  realizará entre el AF y el colectivo artistico."></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Justificación:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.justificacionIc" :disabled="(flagDisable!='')? true : false" placeholder="(Responde a: ¿Por qué es importante desarrollar este proyecto para el colectivo? (relación con la caracterización) ¿Cuál es el tiempo en semanas que tomará el proyecto, y por qué? ¿Cuál o cuáles son los puntos de partida?"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Objetivo general:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.generalIc" :disabled="(flagDisable!='')? true : false" placeholder="(Debe iniciar por un verbo en infinitivo, debe ser claro, concreto y coherente con el tiempo de desarrollo y temáticas propuestas) Describe de manera general la intención del proyecto a ejecutar"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Objetivos específicos:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.especificoIc" :disabled="(flagDisable!='')? true : false" placeholder="(Debe iniciar por un verbo en infinitivo. Estas son acciones esenciales para alcanzar el objetivo general. Plantear mínimo tres o cuatro.) Describa las acciones que conducirán a la ejecución del objetivo general."></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Metodología del proyecto artístico:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.metodologiaIc" :disabled="(flagDisable!='')? true : false" placeholder="(Describa las estrategias metodológicas presenciales y/o virtuales propuestas para el grupo asignado; teniendo en cuenta la población  que atenderá, Plantear fases o momentos de desarrollo, incluir la forma en que se socializará, expondrá o llegará al público. Explicar que va a suceder en cada fase o momento)"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Referentes conceptuales/teóricos/visuales/audiovisuales:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.referentesIc" :disabled="(flagDisable!='')? true : false" placeholder="(Explicar qué referentes va a usar para el desarrollo del proyecto. Organizarlos por: referentes conceptuales o teóricos. Referentes para la creación, referentes de otras áreas artísticas) Plantear las relaciones entre el proyecto y los referentes."></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Resultados esperados:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.esperadosIc" :disabled="(flagDisable!='')? true : false" placeholder="(Enunciar de manera clara el resultado esperado con el proyecto: pieza simbólica, experiencia, documentación del proceso)."></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Materiales / recursos:</label>
                                <textarea class="form-control" rows="2" v-model="formularioIc.materialesIc" :disabled="(flagDisable!='')? true : false" placeholder="(Enunciar que materiales y recursos que se van a gestionar para el desarrollo del proyecto artístico)"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>PLANEADOR DEL PROCESO FORMATIVO</div>
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>Indique una meta para cada semana y relacione en las actividades, las estrategias que utilizará para alcanzarlo tenga en cuenta los momentos de la formación Momentos de la formación:  a. Sensibilización y exploración / b. Descubrimiento/ c. Indagación y experimentación/ d. Exploración y apropiación vocacional … (investigación, busca de soluciones, argumentación, socialización</small>
                                    </div>
                                </center>
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>Enunciar la estrategia, acorde con los objetivos planteados y el momento del proceso.</small>
                                    </div>
                                </center>
                                <div class="col-md-12"><br></div>
                                <!--<div class="row">
                                    <div class="col-md-6">
                                        <label>Fecha de inicio:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" v-model="formulario.inicioPlanIC" type="date" min="1900-01-01" :disabled="(flagDisable!='')? true : false" required>
                                    </div>
                                </div>-->
                                <div class="col-md-12"><br></div>
                                <div class="col-md-4" align="left">
                                    <button class="btn btn-info" type="button" :disabled="(flagDisable!='')? true : false" @click="agregarFilaIc++"><span class="fa fa-plus" aria-hidden="true"></span> Registrar Semana</button>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12">
                                    <div class="col-md-2">
                                        <label>Semana</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Momento</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Fecha Fin</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Descripción</label>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12" v-for="(obligacion,i) in agregarFilaIc" :key="i">  
                                    <div class="col-md-2">
                                        <label>Semana {{i+1}}</label>
                                    </div>
                                    <div class="col-md-2">
                                        <!--<multiselect v-model="momentIc[i]" v-bind:id="'selectsMomentIc'+i" v-bind:name="'selectsMomentIc[]'" label="text" :options="selectMomentIc" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :multiple="true"></multiselect>-->
                                        <select class="form-control selectsMomentIc" v-model="momentIc[i]" v-bind:id="'selectsMomentIc'+i" v-bind:name="'selectsMomentIc[]'" label="text" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción">
                                            <option v-for="option in selectMomentIc" :key="option.value" :value="option.value">
                                                {{ option.text }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" v-model="fechaIC[i]" v-bind:id="'fechaIC'+i" v-bind:name="'fechaIC[]'" type="date" min="1900-01-01" :disabled="(flagDisable!='')? true : false" required>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea v-model="weekIc[i]" v-bind:name="'txWeekIc[]'" v-bind:id="'txWeekIc_'+i" class="form-control" :disabled="(flagDisable!='')? true : false" placeholder=" (Meta de la semana + Mencionar las fechas. Ejemplo: 1 al 6 de Septiembre) / (Mencionar las actividades propuestas para desarrollar la meta de la semana de manera clara y detallada)"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><br><br></div>
                                <div class="col-md-12" id="txObserRevi" v-show="txObserRevi">
                                        <div class="col-md-12">
                                            <label>OBSERVACIONES:</label>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea v-show="txObserRevi" v-model="txRevision" name="txRevision" id="txRevision" class="form-control" placeholder="Escribir aquí las observaciones generales" rows="2" required></textarea>
                                        </div>
                                    </div>
                                <div class="col-md-12"><br><br></div>
                                <div class="form-group pt-2 row justify-content-center">
                                    <div class="col-sm-4 text-center"></div>
                                    <div v-show="checkSaveIc" class="col-sm-4 text-center">
                                        <center>
                                            <table>
                                                <tr>
                                                    <td>Borrador</td>
                                                    <td>
                                                        <div class="custom-control custom-switch ml-2">
                                                            <input type="checkbox" class="custom-control-input" id="switchGuardadoIc" v-model="switch_guardado_ic">
                                                            <label class="custom-control-label" for="switchGuardadoIc"></label>
                                                        </div>
                                                    </td>
                                                    <td>Finalizado</td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                                    <div v-show="checkApproveIc" class="col-sm-4 text-center">
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
                                    <div class="col-sm-4 text-center">
                                        <button v-show="btnSaveIc" class="btn btn-info" type="button" @click="guardarInformacionIc()"><span class="fa fa-check-circle" aria-hidden="true"></span> Guardar</button>
                                        <button v-show="btnApprove" class="btn btn-info" type="button" @click="aprobar(flagDisable)"><span class="fa fa-check-circle" aria-hidden="true"></span> Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="formPlaneacionCv" v-show="formPlaneacionCv">
                    <form id = "formPlaneacionCvSave">
                        <div class="row">
                            <input type="hidden" name="id_converge_hidden" id="id_converge_hidden" v-model="id_converge_hidden">
                            <input type="hidden" name="id_caracterizacion_hidden" id="id_caracterizacion_hidden" v-model="id_caracterizacion_hidden">  
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>PLANEACIÓN DEL PROCESO FORMATIVO</div>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col">
                                <label>Fecha de inicio de planeación:</label>
                            </div>
                            <div class="col">
                                <input class="form-control" v-model="formularioCv.dateStartCv" type="date" min="1900-01-01" :disabled="(flagDisable!='')? true : false" required>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-center">
                                <label>ORIENTACIÓN GENERAL</label>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>A partir del reconocimiento de intereses, gustos, proyecciones, oportunidades de aprendizaje, se definen en conjunto con los participantes, las rutas, formas, medios para el logro de las experiencias de aprendizaje y creación artística con el grupo.</small>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>DISEÑO DE PROYECTO / BOSQUEJO CV</div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="center">
                                        <small>Metodología colaborativa participativa</small>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>Describa brevemente las problemáticas sobre las que se quiere trabajar durante la ejecución del proyecto</label>
                                <textarea class="form-control" rows="2" :disabled="(flagDisable!='')? true : false" v-model="formularioCv.descripcionunoCv" placeholder="Describa brevemente las problemáticas sobre las que se quiere trabajar durante la ejecución del proyecto"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>¿Cuáles serían las principales temáticas y contenidos a abordar durante el proceso?</label>
                                <textarea class="form-control" rows="2"  v-model="formularioCv.descripciondosCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles serían las principales temáticas y contenidos a abordar durante el proceso?"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>¿Cómo el desarrollo de este proyecto mejoraría las condiciones de los participantes o de la comunidad?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.descripciontresCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cómo el desarrollo de este proyecto mejoraría las condiciones de los participantes o de la comunidad?"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>¿Cuáles son los objetivos generales y específicos del proyecto?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.descripcioncuatroCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles son los objetivos generales y específicos del proyecto?"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-12 text-left">
                                <label>¿Cuáles fueron las formas de registro del proceso acordadas junto al grupo?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.descripcioncincoCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles fueron las formas de registro del proceso acordadas junto al grupo?"></textarea>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-4" align="left">
                                <label>METODOLOGÍAS Y MEDIACIONES DIDÁCTICAS</label>
                            </div>
                            <div class="col-md-4">
                                <multiselect v-model="formularioCv.metodologiaCv" label="text" :options="optionMetodologia" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción" :show-labels="false" :multiple="true" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" v-model="formularioCv.textoCompCv" :disabled="(flagDisable!='')? true : false" placeholder="Texto Complementario" type="text">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>REFERENTES</label>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col" align="left">
                                <textarea class="form-control" rows="2" v-model="formularioCv.pedagogicoCv" :disabled="(flagDisable!='')? true : false" placeholder="Indicar en este campo los referentes pedagógicos, disciplinares, artísticos y otros que están ligados con las preguntas orientadoras, temas u objetivos."></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col" align="left">
                                <label>INSUMOS:</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.insumosCv" :disabled="(flagDisable!='')? true : false" placeholder="Materias / Materiales / Instrumentos / Herramientas"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>PLANEADOR DE PROCESO FORMATIVO</div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>Para el diligenciamiento de la planeación del proceso de formación de la línea Converge, tenga en cuenta que este es una breve descripción de lo que el grupo se propone para cada uno de los momentos de la ruta. Tenga en cuenta que este se desarrolla de manera colaborativa y articulada con las poblaciones.</small>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>Momento - Exploración y desarrollo del proyecto</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col" align="left">
                                <label>¿Cuántas semanas durará este momento?</label>
                            </div>
                            <div class="col" align="left">
                                <input type="number" v-model="formularioCv.numSemmeCv" :disabled="(flagDisable!='')? true : false" class="form-control" id="numSemmeCv" placeholder="" required>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cuáles son los principales temas en torno a la reflexión personal o social que pretenden abordar?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles son los principales temas en torno a la reflexión personal o social que pretenden abordar?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cuáles son las técnicas o acciones disciplinares propuestas para este proceso?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaUnoCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles son las técnicas o acciones disciplinares propuestas para este proceso?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cuáles son las expectativas de este momento del proceso formativo?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaDosCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles son las expectativas de este momento del proceso formativo?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿De qué manera se sistematizarán los avances del proceso?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaTresCv" :disabled="(flagDisable!='')? true : false" placeholder="¿De qué manera se sistematizarán los avances del proceso?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>Momento - Producción</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col" align="left">
                                <label>¿Cuántas semanas durará este momento?</label>
                            </div>
                            <div class="col" align="left">
                                <input type="number" v-model="formularioCv.numSemProCv" :disabled="(flagDisable!='')? true : false" class="form-control" id="numSemProCv" placeholder="" required>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿De qué manera se realizarán los montajes, puestas en escena, exposiciones o acciones de visibilización propuestas?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaProCv" :disabled="(flagDisable!='')? true : false" placeholder="¿De qué manera se realizarán los montajes, puestas en escena, exposiciones o acciones de visibilización propuestas?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cómo se relacionan estas propuestas de visibilización con el registro del proceso?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaUnoProCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cómo se relacionan estas propuestas de visibilización con el registro del proceso?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿De qué manera la producción o el montaje se relaciona con el proceso de formación?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaDosProCv" :disabled="(flagDisable!='')? true : false" placeholder="¿De qué manera la producción o el montaje se relaciona con el proceso de formación?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>Momento - Muestra</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cuáles son las acciones de muestra o visibilización propuestas para el proceso?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaMueCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles son las acciones de muestra o visibilización propuestas para el proceso?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cuáles son los impactos que este ejercicio de muestra puede generar en la población?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaUnoMueCv" :disabled="(flagDisable!='')? true : false" placeholder="¿Cuáles son los impactos que este ejercicio de muestra puede generar en la población?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿En qué lugares o escenarios cree que podrían visibilizar el proceso?</label>
                                <textarea class="form-control" rows="2" v-model="formularioCv.preguntaDosMueCv" :disabled="(flagDisable!='')? true : false" placeholder="¿En qué lugares o escenarios cree que podrían visibilizar el proceso?"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>SEGUIMIENTO MENSUAL DEL PROCESO FORMATIVO</div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>Para el diligenciamiento de la planeación del proceso de formación de la línea Converge, tenga en cuenta que este es una breve descripción de lo que el grupo se propone para cada uno de los momentos de la ruta. Tenga en cuenta que este se desarrolla de manera colaborativa y articulada con las poblaciones.</small>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col">
                                <label>Fecha:</label>
                            </div>
                            <div class="col">
                                <input class="form-control" v-model="formularioCv.dateStartPCv" :disabled="(flagDisable!='')? true : false" type="date" min="1900-01-01" required>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <label>Momento del proceso en el que se encuentra</label>
                                <multiselect v-model="formularioCv.momentCv" label="text" :options="selectMomentCv" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción" :show-labels="false" :multiple="true" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <div class="alert alert-light m-2 col-sm-8" role="alert" align="left">
                                        <small>En una escala de 1 a 5, en donde 1 es el nivel más bajo y 5 el más alto, por favor responda las siguientes preguntas</small>
                                    </div>
                                </center>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-6" align="left">
                                <!--<label>¿Qué tanto se han fortalecido los vínculos entre los participantes a partir del proceso de formación?</label>-->
                                <label>¿Qué tanto se han fortalecido los vínculos y las relaciones entre los participantes a partir del proceso de formación?</label>
                            </div>
                            <div class="col-md-6">
                                <multiselect v-model="formularioCv.calificacionCv" label="text" :options="selectCalificaCv" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-6" align="left">
                                <!--<label>¿Qué tanto se han generado reflexiones en torno a las condiciones de vida propias de los participantes o de sus comunidades?</label>-->
                                <label>¿Qué tanto se han generado reflexiones en torno a las condiciones de vida propias de los participantes o en torno a sus comunidades?</label>
                            </div>
                            <div class="col-md-6">
                                <multiselect v-model="formularioCv.calificacionUnoCv" label="text" :options="selectCalificaCv" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-6" align="left">
                                <!--<label>¿Qué tanto se han fortalecido técnica y disciplinariamente los participantes a partir del proceso formativo?</label>-->
                                <label>¿Qué tanto se han fortalecido técnica y disciplinarmente los participantes a partir del proceso formativo?</label>
                            </div>
                            <div class="col-md-6">
                                <multiselect v-model="formularioCv.calificacionDosCv" label="text" :options="selectCalificaCv" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-6" align="left">
                                <!--<label>¿Qué tanto los participantes han transformado los imaginarios respecto a si mismos a partir del proceso?</label>-->
                                <label>¿Qué tanto se han desarrollado acciones, prácticas o proyectos colaborativos? </label>
                            </div>
                            <div class="col-md-6">
                                <multiselect v-model="formularioCv.calificacionTresCv" label="text" :options="selectCalificaCv" :disabled="(flagDisable!='')? true : false" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-12"><br></div>
                            <!--<div class="col-md-6" align="left">
                                <label>¿Qué tanto los participantes han transformado los imaginarios respecto a los otros a partir del proceso?</label>
                            </div>
                            <div class="col-md-6">
                                <multiselect v-model="formularioCv.calificacionCuatroCv" label="text" :options="selectCalificaCv" placeholder="Seleccione una opción" :show-labels="false" track-by="value"></multiselect>
                            </div>
                            <div class="col-md-12"><br></div>-->
                            <div class="col-md-12" id="txObserRevi" v-show="txObserRevi">
                                <div class="col-md-12">
                                    <label>OBSERVACIONES:</label>
                                </div>
                                <div class="col-md-12">
                                    <textarea v-show="txObserRevi" v-model="txRevision" :disabled="(flagDisable!='')? true : false" name="txRevision" id="txRevision" class="form-control" placeholder="Escribir aquí las observaciones generales" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"><br><br></div>
                            <div v-show="checkSaveCv" class="col text-center">
                                <center>
                                    <table>
                                        <tr>
                                            <td>Borrador</td>
                                            <td>
                                                <div class="custom-control custom-switch ml-2">
                                                    <input type="checkbox" class="custom-control-input" id="switch_guardado_cv" v-model="switch_guardado_cv">
                                                    <label class="custom-control-label" for="switch_guardado_cv"></label>
                                                </div>
                                            </td>
                                            <td>Finalizado</td>
                                        </tr>
                                    </table>
                                </center>
                            </div>
                            <div v-show="checkApproveCv" class="col-sm-4 text-center">
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
                            <div class="col text-center">
                                <button v-show="btnSaveCv" class="btn btn-info" type="button" @click="guardarInformacionCv"><span class="fa fa-check-circle" aria-hidden="true"></span> Guardar</button>
                                <button v-show="btnApprove" class="btn btn-info" type="button" @click="aprobar(flagDisable)"><span class="fa fa-check-circle" aria-hidden="true"></span> Confirmar</button>
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
    
    export default {
        components: { 
            Multiselect
        },
        data () {
            return {
                id_persona:"",
                formulario: {},
                formularioIc:{},
                formularioCv:{},
                formTable: true,
                formTableEdit: true,
                formPlaneacion:false,
                formPlaneacionIc:false,
                formPlaneacionCv:false,
                detalleForm: true,
                caracterizados:[],
                optionMetodologia: [],
                agregarFila: 0,
                agregarFilaIc: 0,
                agregarFilaCv: 0,
                selectMoment: [],
                selectMomentIc:[],
                selectMomentCv:[],
                selectCalificaCv:[],
                week:{},
                weekIc:{},
                weekCv:{},
                moment:{},
                momentIc:{},
                momentCv:{},
                switch_guardado: true,
                switch_guardado_ic: true,
                switch_guardado_cv: true,
                switch_aprobacion: false,
                lineaAtencion:"",
                idGrupo:"",
                id_planeacion_hidden:"",
                id_caracterizacion_hidden:"",
                id_impulso_hidden:"",
                id_caracterizacionIc_hidden:"",
                id_converge_hidden:"",
                id_caracterizacionCv_hidden:"",
                planeaciones: [],
                fecha:{},
                fechaIC:{},
                selectCalificaCv: [{"text":"1","value":1},{"text":"2","value":2},{"text":"3","value":3},{"text":"4","value":4},{"text":"5","value":5}],
                selectTipoInforme: [{"text":"Planeaciones Propias","value":0},{"text":"Planeaciones a Supervisar","value":1}],
                idTipoInforme: [],
                selectEstado: [{"text":"Revisados","value":0},{"text":"Devueltos","value":1},{"text":"En proceso de Revisión","value":2}],
                idEstado:[],
                flagDisable:"",
                btnApprove:false,
                btnSave:true,
                checkSave:true,
                checkApprove:false,
                txObserRevi:false,
                txRevision:"",
                checkSaveIc:true,
                checkApproveIc:false,
                btnSaveIc:true,
                id_linea_ae_hidden:"",
                id_linea_ic_hidden:"",
                id_linea_cv_hidden:"",
                checkSaveCv: true,
                checkApproveCv: false,
                btnSaveCv: true,
                id_rol:"",
                base:'',
            }
        },
        mounted() {
            this.getIdPersona();
            setTimeout(function(){ vm.getRolPersona(); }, 2500);

            const vm = this;
            setTimeout(function(){ vm.getInfoTable(); }, 2000);
            setTimeout(function(){ vm.getInfoTableEdit(); }, 3000);

            this.getMomentosFormacion();
            this.getMetodoligia();
            this.getMomentosFormacionIc();
            this.getMomentosFormacionCv();
        },
        methods: {
            
            tabla(){
                Vue.nextTick(function () {
                    $('#tableEdicion').DataTable();
                });
            },

            getIdPersona(){
				axios
				.post("/sif/framework/getIdPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
					this.id_persona = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},

            getRolPersona(){
				axios
				.post("/sif/framework/personas/getRolPersona", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_persona,
				})
				.then(response => {
					this.id_rol = response.data.FK_Tipo_Persona;;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener la información de la persona, por favor inténtelo nuevamente", "error");
				});
			},

            getInfoTable(){
                
				axios
                    .post("/sif/framework/componentePedagogico/getInfoTable", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_persona,
                })
                    .then(response => {
                        this.caracterizados = response.data;
                        if (this.caracterizados == "") {
                            this.formTable = false;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            register(idLinea, idGrupo, idCaracterizacion) {
                if (idLinea == 1) {
                    this.formPlaneacion = true;// formPlaneacion
                    //this.id_caracterizacion_hidden = idCaracterizacion; 
                    //this.id_caracterizacionIc_hidden = idCaracterizacion;
                    //this.id_caracterizacionCv_hidden = idCaracterizacion;
                }
                if(idLinea == 2){
                    this.formPlaneacionIc = true;
                    //this.id_caracterizacionIc_hidden = idCaracterizacion;
                }
                if(idLinea == 3){
                    this.formPlaneacionCv = true;
                    //this.id_caracterizacionCv_hidden = idCaracterizacion;
                }
                this.formTable = false;
                this.formTableEdit = false;
                this.lineaAtencion = idLinea;
                this.idGrupo = idGrupo;
                this.id_caracterizacion_hidden = idCaracterizacion;
                //this.id_caracterizacion_hidden = idCaracterizacion;
            },

            guardarInformacion(){
                
                if(this.switch_guardado === true){

                    var msg = "";
                    
                    if(this.formulario.dateStart == "")
                        msg += "Fecha de Inicio<br>";

                    if(this.formulario.objetivos == null)
                        msg += "OBJETIVOS GENERAL DEL PROCESO DE FORMACIÓN<br>";

                    if(this.formulario.preguntas == null)
                        msg += "PREGUNTAS ORIENTADORAS<br>";
                    
                    if(this.formulario.especificos == null)
                        msg += "OBJETIVOS ESPECÍFICOS<br>";
                    
                    if(this.formulario.temas == null)
                        msg += "TEMAS PROPUESTOS<br>";
                    
                    if(this.formulario.intencion == null)
                        msg += "INTENCIONALIDAD PEDAGÓGICA – PROPÓSITO<br>";
                    
                    if(this.formulario.metodologia == null)
                        msg += "METODOLOGÍAS Y MEDIACIONES DIDÁCTICAS<br>";

                    if(this.formulario.pedagogico == null)
                        msg += "Referentes<br>";

                    if(this.formulario.insumos == null)
                        msg += "INSUMOS<br>";

                    //if(this.formulario.moment == null)
                        //msg += "Registro planeación Momentos<br>";
                    
                    //if(this.formulario.week == null)
                        //msg += "Registro planeación Semanas<br>";

                    if(msg != "") {
                        
                        Swal.fire(
                            'Atención!',
                            "Los siguentes campos son de carácter obligatorio: <br>" + msg,
                            'error'
                        );
                        return false;
                    }

                }
                Swal.fire({
                    title: "Almacenando la Información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });

                const formulario = document.getElementById('formPlaneacionSave');
                var formData = new FormData(formulario);
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                formData.append("linea_atencion", this.lineaAtencion);
                formData.append("id_grupo", this.idGrupo);
                formData.append("formulario", JSON.stringify(this.formulario));
                formData.append("finalizado", this.switch_guardado);
                formData.append("id_usuario", this.id_persona);
                
                axios
				.post("/sif/framework/componentePedagogico/guardarPlaneacionGrupo",
                    formData, 
                    config,
                {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
                    if(response.data === true) {
                        Swal.fire(
                            'Información Almacenada Correctamente',
                            "La información ha sido almacenada de manera satisfactoria",
                            'success'
                        );
                        this.formTable = true;
                        this.formTableEdit = true;
                        this.formPlaneacion = false;
                        this.getInfoTable();
                        this.getInfoTableEdit();
                    }else {
                        Swal.fire(
                            'Atención!',
                            "No se puede almacenar el informe",
                            'error'
                        );
                    }
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el formulario, por favor inténtelo nuevamente", "error");
				});
            },

            getMomentosFormacion(){
				axios
                    .post("/sif/framework/componentePedagogico/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 95
                })
				.then(response => {
                    this.selectMoment = response.data;
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },

            getMomentosFormacionIc(){
				axios
                    .post("/sif/framework/componentePedagogico/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 102
                })
				.then(response => {
                    this.selectMomentIc = response.data;
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },

            getMomentosFormacionCv(){
				axios
                    .post("/sif/framework/componentePedagogico/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 97
                })
				.then(response => {
                    this.selectMomentCv = response.data;
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },

            getMetodoligia(){
				axios
                    .post("/sif/framework/componentePedagogico/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 46
                })
				.then(response => {
                    this.optionMetodologia = response.data;
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },

            getInfoTableEdit(){
                
				axios
                    .post("/sif/framework/componentePedagogico/getInfoTableEdit", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_persona,
                    "tipo": this.idTipoInforme.value,
                    "estado": this.idEstado.value,
                })
                    .then(response => {
                        this.planeaciones = response.data;
                        this.tabla();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            guardarInformacionIc(){

                if(this.switch_guardado_ic === true){

                    var msg = "";
                    
                    if(this.formularioIc.dateStartIc == "")
                        msg += "Fecha de Inicio<br>";
                    
                    if(this.formularioIc.descripcionIc == null)
                        msg += "Descripción general del proyecto<br>";

                    if(this.formularioIc.justificacionIc == null)
                        msg += "Justificación<br>";

                    if(this.formularioIc.generalIc == null)
                        msg += "Objetivo general<br>";
                    
                    if(this.formularioIc.especificoIc == null)
                        msg += "Objetivos específicos<br>";
                    
                    if(this.formularioIc.metodologiaIc == null)
                        msg += "Metodología del proyecto artístico<br>";
                    
                    if(this.formularioIc.referentesIc == null)
                        msg += "Referentes conceptuales/teóricos/visuales/audiovisuales<br>";
                    
                    if(this.formularioIc.esperadosIc == null)
                        msg += "Resultados esperados<br>";

                    if(this.formularioIc.materialesIc == null)
                        msg += "Materiales / recursos<br>";

                    if(msg != "") {
                        
                        Swal.fire(
                            'Atención!',
                            "Los siguentes campos son de carácter obligatorio: <br>" + msg,
                            'error'
                        );
                        return false;
                    }

                }
                Swal.fire({
                    title: "Almacenando la Información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });

                const formularioIc = document.getElementById('formPlaneacionIcSave');
                var formData = new FormData(formularioIc);
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                formData.append("linea_atencion", this.lineaAtencion);
                formData.append("id_grupo", this.idGrupo);
                formData.append("formulario", JSON.stringify(this.formularioIc));
                formData.append("finalizado", this.switch_guardado_ic);
                formData.append("id_usuario", this.id_persona);
                
                axios
				.post("/sif/framework/componentePedagogico/guardarPlaneacionIc",
                    formData, 
                    config,
                {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
                    if(response.data === true) {
                        Swal.fire(
                            'Información Almacenada Correctamente',
                            "La información ha sido almacenada de manera satisfactoria",
                            'success'
                        );
                        this.formTable = true;
                        this.formTableEdit = true;
                        this.formPlaneacionIc = false;
                        this.getInfoTable();
                        this.getInfoTableEdit();
                    }else {
                        Swal.fire(
                            'Atención!',
                            "No se puede almacenar el informe",
                            'error'
                        );
                    }
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el formulario, por favor inténtelo nuevamente", "error");
				});
            },

            guardarInformacionCv(){

                if(this.switch_guardado_cv === true){

                    var msg = "";
                    
                    if(this.formularioCv.dateStartCv == "")
                        msg += "Fecha de Inicio<br>";
                    
                    if(this.formularioCv.descripcionunoCv == null)
                        msg += "Metodología colaborativa participativa<br>";

                    if(this.formularioCv.descripciondosCv == null)
                        msg += "¿Cuáles serían las principales temáticas y contenidos a abordar durante el proceso?<br>";
                    
                    if(this.formularioCv.descripciontresCv == null)
                        msg += "¿Cómo el desarrollo de este proyecto mejoraría las condiciones de los participantes o de la comunidad?<br>";
                    
                    if(this.formularioCv.descripcioncuatroCv == null)
                        msg += "¿Cuáles son los objetivos generales y específicos del proyecto?<br>";
                    
                    if(this.formularioCv.descripcioncincoCv == null)
                        msg += "¿Cuáles fueron las formas de registro del proceso acordadas junto al grupo?<br>";
                    
                    if(this.formularioCv.metodologiaCv == null)
                        msg += "METODOLOGÍAS Y MEDIACIONES DIDÁCTICAS<br>";

                    if(this.formularioCv.pedagogicoCv == null)
                        msg += "REFERENTES<br>";
                    
                    if(this.formularioCv.insumosCv == null)
                        msg += "INSUMOS<br>";
                    
                    if(this.formularioCv.numSemmeCv == null)
                        msg += "¿Cuántas semanas durará este momento?<br>";
                    
                    if(this.formularioCv.preguntaCv == null)
                        msg += "¿Cuáles son los principales temas en torno a la reflexión personal o social que pretenden abordar?<br>";

                    if(this.formularioCv.preguntaUnoCv == null)
                        msg += "¿Cuáles son las técnicas o acciones disciplinares propuestas para este proceso?<br>";

                    if(this.formularioCv.preguntaDosCv == null)
                        msg += "¿Cuáles son las expectativas de este momento del proceso formativo?<br>";
                    
                    if(this.formularioCv.preguntaTresCv == null)
                        msg += "¿De qué manera se sistematizarán los avances del proceso?<br>";

                    if(this.formularioCv.numSemProCv == null)
                        msg += "¿Cuántas semanas durará este momento?<br>";

                    if(this.formularioCv.preguntaProCv == null)
                        msg += "¿De qué manera se realizarán los montajes, puestas en escena, exposiciones o acciones de visibilización propuestas?<br>";
                    
                    if(this.formularioCv.preguntaUnoProCv == null)
                        msg += "¿Cómo se relacionan estas propuestas de visibilización con el registro del proceso?<br>";
                    
                    if(this.formularioCv.preguntaDosProCv == null)
                        msg += "¿De qué manera la producción o el montaje se relaciona con el proceso de formación?<br>";
                    
                    if(this.formularioCv.preguntaMueCv == null)
                        msg += "¿Cuáles son las acciones de muestra o visibilización propuestas para el proceso?<br>";
                    
                    if(this.formularioCv.preguntaUnoMueCv == null)
                        msg += "¿Cuáles son los impactos que este ejercicio de muestra puede generar en la población?<br>";
                    
                    if(this.formularioCv.preguntaDosMueCv == null)
                        msg += "¿En qué lugares o escenarios cree que podrían visibilizar el proceso?<br>";
                    
                    if(this.formularioCv.dateStartPCv == null)
                        msg += "Fecha<br>";
                    
                    if(this.formularioCv.momentCv == null)
                        msg += "Momento del proceso en el que se encuentra<br>";
                    
                    if(this.formularioCv.calificacionCv == null)
                        msg += "¿Qué tanto se han fortalecido los vínculos entre los participantes a partir del proceso de formación?<br>";
                    
                    if(this.formularioCv.calificacionUnoCv == null)
                        msg += "¿Qué tanto se han generado reflexiones en torno a las condiciones de vida propias de los participantes o de sus comunidades?<br>";
                    
                    if(this.formularioCv.calificacionDosCv == null)
                        msg += "¿Qué tanto se han fortalecido técnica y disciplinariamente los participantes a partir del proceso formativo?<br>";
                    
                    if(this.formularioCv.calificacionTresCv == null)
                        msg += "¿Qué tanto los participantes han transformado los imaginarios respecto a si mismos a partir del proceso?<br>";

                    if(msg != "") {
                        
                        Swal.fire(
                            'Atención!',
                            "Los siguentes campos son de carácter obligatorio: <br>" + msg,
                            'error'
                        );
                        return false;
                    }

                }
                Swal.fire({
                    title: "Almacenando la Información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });

                const formularioCv = document.getElementById('formPlaneacionCvSave');
                var formData = new FormData(formularioCv);
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                formData.append("linea_atencion", this.lineaAtencion);
                formData.append("id_grupo", this.idGrupo);
                formData.append("formulario", JSON.stringify(this.formularioCv));
                formData.append("finalizado", this.switch_guardado_cv);
                formData.append("id_usuario", this.id_persona);
                
                axios
				.post("/sif/framework/componentePedagogico/guardarPlaneacionCv",
                    formData, 
                    config,
                {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				})
				.then(response => {
                    if(response.data === true) {
                        Swal.fire(
                            'Información Almacenada Correctamente',
                            "La información ha sido almacenada de manera satisfactoria",
                            'success'
                        );
                        this.formTable = true;
                        this.formTableEdit = true;
                        this.formPlaneacionCv = false;
                        this.getInfoTable();
                        this.getInfoTableEdit();
                    }else {
                        Swal.fire(
                            'Atención!',
                            "No se puede almacenar el informe",
                            'error'
                        );
                    }
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el formulario, por favor inténtelo nuevamente", "error");
				});
            },

            editPlaneacion(idPlaneacion, idGrupo, idLinea){
                
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
                .post("/sif/framework/componentePedagogico/getPlaneacion",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idPlaneacion": idPlaneacion,
                })
				.then(response => {

                    this.dataPlanea = response.data;
                    
                    if (idLinea == 1) {
                        
                        this.formulario = JSON.parse(this.dataPlanea.JSON_formulario);
                        this.formulario = JSON.parse(this.formulario);
                        this.planSemanas = JSON.parse(this.dataPlanea.json_semanas);
                        
                        if (this.planSemanas != null) {

                            this.agregarFila = this.planSemanas.length; 

                            this.planSemanas.forEach((value, index) => {
                                this.moment[index] = value.selector;
                                this.week[index] = value.planeacion;
                                this.fecha[index] = value.fechaS;
                            });

                        }
                        
                        this.formPlaneacion = true;
                        this.id_planeacion_hidden = idPlaneacion;

                    }else if(idLinea == 2) {

                        this.formularioIc = JSON.parse(this.dataPlanea.JSON_formulario);
                        this.formularioIc = JSON.parse(this.formularioIc);
                        this.planSemanas = JSON.parse(this.dataPlanea.json_semanas);

                        if (this.planSemanas != null) {

                            this.agregarFilaIc = this.planSemanas.length;

                            this.planSemanas.forEach((value, index) => {
                                this.momentIc[index] = value.selector;
                                this.weekIc[index] = value.planeacion;
                                this.fechaIC[index] = value.fechaS;
                            });

                        }

                        this.formPlaneacionIc = true;
                        this.id_impulso_hidden = idPlaneacion;

                    }else if(idLinea == 3){

                        this.formularioCv = JSON.parse(this.dataPlanea.JSON_formulario);
                        this.formularioCv = JSON.parse(this.formularioCv);

                        this.formPlaneacionCv = true;
                        this.id_converge_hidden = idPlaneacion;
                    }
                    
                    this.lineaAtencion = this.dataPlanea.FK_Id_Linea_atencion;
                    this.idGrupo = idGrupo;
                    this.formTable = false;
                    this.formTableEdit = false;
                    
                    Swal.close();
				})
				.catch(error => {
					console.log("No se puede cargar la información");
				});
            },

            revPlaneacion(idPlaneacion, idGrupo, idLinea, ident){
               
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
                .post("/sif/framework/componentePedagogico/getPlaneacion",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idPlaneacion": idPlaneacion,
                })
				.then(response => {

                    this.dataPlanea = response.data;

                    if (idLinea == '1') {
                        
                        this.formulario = JSON.parse(this.dataPlanea.JSON_formulario);
                        this.formulario = JSON.parse(this.formulario);
                        this.planSemanas = JSON.parse(this.dataPlanea.json_semanas);
                        this.agregarFila = this.planSemanas.length;
                        this.txRevision = this.dataPlanea.VC_Observacion;

                        this.planSemanas.forEach((value, index) => {
                            this.moment[index] = value.selector;
                            this.week[index] = value.planeacion;
                            this.fecha[index] = value.fechaS;
                        });

                        this.flagDisable = idPlaneacion;
                        this.id_linea_ae_hidden = idLinea;
                        this.formPlaneacion = true;

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
                    }
                    
                    if (idLinea == '2') {
                        
                        this.formularioIc = JSON.parse(this.dataPlanea.JSON_formulario);
                        this.formularioIc = JSON.parse(this.formularioIc);
                        this.planSemanas = JSON.parse(this.dataPlanea.json_semanas);
                        this.agregarFilaIc = this.planSemanas.length;
                        this.txRevision = this.dataPlanea.VC_Observacion;

                        this.planSemanas.forEach((value, index) => {
                            this.momentIc[index] = value.selector;
                            this.weekIc[index] = value.planeacion;
                            this.fechaIC[index] = value.fechaS;
                        });
                        this.flagDisable = idPlaneacion;
                        this.id_linea_ic_hidden = idLinea;
                        this.formPlaneacionIc = true;

                        if (ident == 0) {
                            this.btnApprove = false;
                            this.btnSaveIc = false;
                            this.checkSaveIc = false;
                            this.checkApproveIc = false;
                            this.txObserRevi = true;
                        }else{
                            this.btnApprove = true;
                            this.btnSaveIc = false;
                            this.checkSaveIc = false;
                            this.checkApproveIc = true;
                            this.txObserRevi = true;
                        }
                        
                    }

                    if (idLinea == '3') {
                        
                        this.formularioCv = JSON.parse(this.dataPlanea.JSON_formulario);
                        this.formularioCv = JSON.parse(this.formularioCv);
                        this.txRevision = this.dataPlanea.VC_Observacion;

                        this.flagDisable = idPlaneacion;
                        this.id_linea_cv_hidden = idLinea;
                        this.formPlaneacionCv = true;
                        
                        if (ident == 0) {
                            this.btnApprove = false;
                            this.btnSaveCv = false;
                            this.checkSaveCv = false;
                            this.checkApproveCv = false;
                            this.txObserRevi = true;
                        }else{
                            this.btnApprove = true;
                            this.btnSaveCv = false;
                            this.checkSaveCv = false;
                            this.checkApproveCv = true;
                            this.txObserRevi = true;
                        }
                        
                    }
                    
                    this.lineaAtencion = this.dataPlanea.FK_Id_Linea_atencion;
                    this.idGrupo = idGrupo;
                    this.formTable = false;
                    this.formTableEdit = false;
                    
                    Swal.close();
                })
				.catch(error => {
					console.log("No se puede cargar la información");
				});
            },

            aprobar(idPlaneacion, idLinea){
                
                this.switch_aprobacion = $("#switchAprobacion").is(':checked');

                axios
                    .post("/sif/framework/componentePedagogico/registerApproval", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_planeacion": idPlaneacion,
                    "checkApprove":this.switch_aprobacion,
                    "observacionApprove":this.txRevision,
                    "id_persona": this.id_persona,
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
                    })
                    .catch(error => {
                        console.log(error);
                    });

            },

            pdfPlaneacion(idInforme, idLinea){   
                window.open(this.base + '/sif/framework/componentePedagogico/pdfPlaneacion/'+ idInforme + '/' + idLinea);
            },

        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>