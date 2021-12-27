<template>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header text-muted">
                <h2 class="m-0">Formato Pedagógico General - Análisis y seguimiento del proceso formativo</h2>
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
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 1"><b>AE-{{caracterizado.FK_grupo}}</b></td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 2"><b>IC-{{caracterizado.FK_grupo}}</b></td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 3"><b>CV-{{caracterizado.FK_grupo}}</b></td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 1">Arte en la escuela</td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 2">Impulso Colectivo</td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 3">Converge</td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 1">{{caracterizado.grupo_arte.colegio.VC_Nom_Colegio}}</td>
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 2">{{caracterizado.grupo_impulso.crea.VC_Nom_Clan}}</td><!--caracterizado.grupo_impulso.crea.VC_Nom_Clan-->
                                        <td v-if="caracterizado.FK_Id_Linea_atencion == 3">{{caracterizado.grupo_converge.colegio.VC_Nom_Colegio}}</td>
                                        <td>
                                            <span v-if="caracterizado.IN_Estado == null" class="badge badge-btn-warning">en proceso de Revisión Planeacion</span>
                                            <span v-if="caracterizado.IN_Estado == 0" class="badge badge-danger">Devuelta Planeación</span>
                                            <span v-if="caracterizado.IN_Estado == 1" class="badge badge-success">Revisada Planeación</span>
                                        </td>
                                        <td>
                                            <button v-bind:id="'next_'+caracterizado.PK_Id_Planeacion" class="btn btn-info" type="button"  @click="register(caracterizado.FK_Id_Linea_atencion, caracterizado.FK_grupo, caracterizado.PK_Id_Planeacion)" :disabled="(caracterizado.IN_Estado == null || caracterizado.IN_Estado == 0) ? true : false">Anàlisis y Seguimiento</button>
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
                                        <th>Documento Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(planeado,i) in planeaciones" :key="i">
                                        <td v-if="planeado.FK_Linea_Atencion == 1"><b>AE-{{planeado.FK_Grupo}}</b></td>
                                        <td v-if="planeado.FK_Linea_Atencion == 2"><b>IC-{{planeado.FK_Grupo}}</b></td>
                                        <td v-if="planeado.FK_Linea_Atencion == 3"><b>CV-{{planeado.FK_Grupo}}</b></td>
                                        <td v-if="planeado.FK_Linea_Atencion == 1">Arte en la escuela</td>
                                        <td v-if="planeado.FK_Linea_Atencion == 2">Impulso Colectivo</td>
                                        <td v-if="planeado.FK_Linea_Atencion == 3">Converge</td>
                                        <td v-if="planeado.FK_Linea_Atencion == 1">{{planeado.grupo_arte.colegio.VC_Nom_Colegio}}</td>
                                        <td v-if="planeado.FK_Linea_Atencion == 2">{{planeado.grupo_impulso.crea.VC_Nom_Clan}}</td> 
                                        <td v-if="planeado.FK_Linea_Atencion == 3">{{planeado.grupo_converge.colegio.VC_Nom_Colegio}}</td>
                                    
                                        <td>
                                            <span v-if="planeado.IN_Estado == null && planeado.in_finalizado == 1" class="badge badge-warning">en proceso de Revisión Planeación</span>
                                            <span v-if="planeado.IN_Estado == 0" class="badge badge-danger">Devuelto Planeación</span>
                                            <span v-if="planeado.IN_Estado == 1" class="badge badge-success">Revisado Planeación</span>

                                            <span v-if="planeado.in_finalizado == 0" class="badge badge-danger">Sin Finalizar</span>
                                            <span v-if="planeado.in_finalizado == 1" class="badge badge-success">Finalizado</span>
                                        </td>
                                        <td>
                                            <button v-if="planeado.in_finalizado == 0" v-bind:id="'edit_'+planeado.PK_Id_Valoracion" class="btn btn-warning editPlaneacion" type="button" @click="editAnalisis(planeado.PK_Id_Valoracion, planeado.FK_Grupo, planeado.FK_Linea_Atencion)"><span class="fa fa-edit" aria-hidden="true"></span></button>
                                            <button v-if="planeado.in_finalizado == 1 && (id_rol == 30 || id_rol == 35)" v-bind:id="'rev_'+planeado.PK_Id_Valoracion" class="btn btn-primary revisarPlaneacion" type="button" @click="revAnalisis(planeado.PK_Id_Valoracion, planeado.FK_Grupo, planeado.FK_Linea_Atencion, 1)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                            <button v-if="planeado.in_finalizado == 1 && (id_rol != 30 && id_rol != 35)" v-bind:id="'view_'+planeado.PK_Id_Valoracion" class="btn btn-dark visualizarPlaneacion" type="button" @click="revAnalisis(planeado.PK_Id_Valoracion, planeado.FK_Grupo, planeado.FK_Linea_Atencion, 0)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                        </td>
                                        <td>
                                             <button v-bind:id="'pdf_'+planeado.PK_Id_Valoracion" class="btn btn-info" type="button" @click="pdfValoracion(planeado.PK_Id_Valoracion, planeado.FK_Linea_Atencion)" :disabled="(planeado.IN_Estado == null || planeado.IN_Estado == 0) ? true : false"><span class="fa fa-file-pdf" aria-hidden="true"></span></button>
                                        </td>
                                        <td>
                                             <button v-bind:id="'pdf_'+planeado.PK_Id_Valoracion" class="btn btn-success" type="button" @click="pdfProceso(planeado.PK_Id_Valoracion, planeado.FK_Linea_Atencion)" :disabled="(planeado.IN_Estado == null || planeado.IN_Estado == 0) ? true : false"><span class="fa fa-file-pdf" aria-hidden="true"></span></button>
                                        </td>
                                    </tr>           
                                </tbody>
                                
                            </table>
                            
                        </div>
                    </div>
                </div>

                <div id="formAnalisis" v-show="formAnalisis">
                    <form id = "formAnalisisSave">
                        <input type="hidden" name="flagLineaAt" id="flagLineaAt" v-model="flagLineaAt">
                        <input type="hidden" name="id_valoracion_hidden" id="id_valoracion_hidden" v-model="id_valoracion_hidden">
                        <input type="hidden" name="id_planeacion_hidden" id="id_planeacion_hidden" v-model="id_planeacion_hidden">
                        <div class="row">
                            <div class="col-md-12" align="left">
                                <label>VALORACIÓN Y SEGUIMIENTO DEL PROCESO FORMATIVO EN RELACIÓN A LA PLANEACIÓN</label>
                            </div>
                            <center>
                                <div class="alert alert-light m-2 col-sm-8" role="alert">
                                    <small>acción de conceptualización cualitativa que permite observar, acompañar, reorientar, enfocar las actividades y alcances propuestos con determinado grupo de acuerdo con los intereses y logros de los participantes, con las transformaciones de los imaginarios y formas de relación de cualquier índole, propiciados por el proceso de formación.</small>
                                </div>
                            </center>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Análisis frente a los avances del proceso</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4" align="left">
                                        <label>¿En qué medida la planeación que desarrollé para este grupo se realizó?</label>
                                    </div>
                                    <div class="col-md-4">
                                        <multiselect v-model="formulario.porcentaje" label="text" :options="optionPorcentaje" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" v-model="formulario.numPorcentaje" class="form-control" id="numPorcentaje" placeholder="Ingrese el porcentaje" min="0" max="100" required :disabled="(flagDisable!='')? true : false">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿En caso de escribir que se modificó o se realizó parcialmente exponga los motivos o circunstancias que no lo permitieron?</label>
                                <textarea class="form-control" rows="2" v-model="formulario.preguntados" placeholder="(falta de materiales, falta de continuidad del proceso, imprecisiones en la planeación, interese disimiles con el grupo, …….. entre otros). Explicar los motivos para el cambio de planeación o particularidades relevante del grupo durante el proceso" :disabled="(flagDisable!='')? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Análisis frente a los logros del proceso</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <label>¿La planeación y el desarrollo de las acciones me permitieron alcanzar los propósitos de la formación?</label>
                            </div>
                            <div class="col-md-12" align="left">
                                <label>La planeación y el desarrollo de las actividades me permitieron:</label>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>A) cumplir el objetivo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.objetivo" label="text" :options="optionSiNo" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>B) responder a la pregunta orientadora </label>
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.orientadora" label="text" :options="optionSiNo" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>¿Cuáles son los logros obtenidos durante el proceso?</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <!--Objetivos de AE-->
                            <div class="col-md-12 row" align="left" v-show="objetivosAe">

                                <div class="col-md-12">
                                    <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Objetivos de AE</div>
                                </div>
                                <div class="col-md-12"><br></div>
                                
                                    <div class="col-md-6">
                                        <label>Competencias desarrolladas</label>   
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.desarrolladas" label="text" :options="optionDesa" placeholder="Seleccione una opción" :show-labels="false" :multiple="true" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="2" v-model="formulario.otroAE" placeholder="" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                
                                <div class="col-md-12"><br></div>
                                 
                                    <div class="col-md-6">
                                        <label>Maneras</label>   
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.maneras" label="text" :options="optionManeras" placeholder="Seleccione una opción" :show-labels="false" :multiple="true" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                
                            </div>
                            <div class="col-md-12"><br></div>
                            <!--Objetivos de IC-->
                            <div class="col-md-12 row" align="left" v-show="objetivosIc">
                                <div class="col-md-12">
                                    <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Objetivos de IC</div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>Desarrollo de proyectos artísticos, acciones de gestión.</div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <label>Los/as participantes estuvieron activos/as en las diferentes etapas de desarrollo del proyecto (investigación, busca de soluciones, argumentación, socialización)</label>
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.objIcUno" label="text" :options="optionObjetivos" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="2" v-model="formulario.objIcUnoText" placeholder="Amplíe su respuesta" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <label>¿Durante la realización del proyecto se trabajó de forma colectiva?</label>
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.objIcDos" label="text" :options="optionObjetivos" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="2" v-model="formulario.objIcDosText" placeholder="Amplíe su respuesta" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>Disciplinar</div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <label>¿De acuerdo al planteamiento del proyecto, se adquirieron las habilidades técnicas, expresivas y argumentativas que hicieron posible su ejecución?</label>
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.objIcTres" label="text" :options="optionObjetivos" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="2" v-model="formulario.objIcTresText" placeholder="Amplíe su respuesta" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <div class="card-header bg-dark text-white text-left"><i class="fa fa-info-circle pr-4"></i>Relación con el público - comunidad - sector</div>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <label>La relación con la comunidad - el sector- el público se dio como se contemplaba en el proyecto.</label>
                                    </div>
                                    <div class="col-md-6">
                                        <multiselect v-model="formulario.objIcCuatro" label="text" :options="optionObjetivos" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :disabled="(flagDisable!='')? true : false"></multiselect>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="2" v-model="formulario.objIcCuatroText" placeholder="Amplíe su respuesta" :disabled="(flagDisable!='')? true : false"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--Objetivos de CV-->
                            <div class="col-md-12 row" align="left" v-show="objetivosCv">
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <div class="card-header bg-info text-white text-left"><i class="fa fa-info-circle pr-4"></i>Objetivos de CV</div>
                                </div>
                                <div class="col-md-12">
                                    <label>transformación de imaginarios</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.imaginarios" placeholder="" :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-12"><br></div>
                                <div class="col-md-12">
                                    <label>transformación de imaginarios y formas de relación.</label>
                                    <textarea class="form-control" rows="2" v-model="formulario.formasRelacion" placeholder="" :disabled="(flagDisable!='')? true : false"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Qué cambios en las formas de ser pensar y hacer se dieron en los participantes a partir del proceso de formación?</label>
                                <textarea class="form-control" rows="2" v-model="formulario.cambiosFormas" placeholder="" :disabled="(flagDisable!='')? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>¿Cuáles son las posibilidades, intereses y temáticas para continuar en el desarrollo en próximos procesos?</label>
                                <textarea class="form-control" rows="2" v-model="formulario.posibilidades" placeholder="" :disabled="(flagDisable!='')? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" align="left">
                                <label>Conclusión reflexiva: </label>
                                <textarea class="form-control" rows="2" v-model="formulario.conclusion" placeholder="Escriba la conclusión reflexiva" :disabled="(flagDisable!='')? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" id="txObserRevi" v-show="txObserRevi">
                                <div class="col-md-12">
                                    <label>OBSERVACIONES:</label>
                                </div>
                                <div class="col-md-12">
                                    <textarea v-show="txObserRevi" v-model="txRevision" name="txRevision" id="txRevision" class="form-control" placeholder="Escribir aquí las observaciones generales" rows="2" required></textarea>
                                </div>
                            </div> 
                            <div class="col-md-12"><br><br></div>
                            <div v-show="checkSave" class="col text-center">
                                <center>
                                    <table>
                                        <tr>
                                            <td>Borrador</td>
                                            <td>
                                                <div class="custom-control custom-switch ml-2">
                                                    <input type="checkbox" class="custom-control-input" id="switch_guardado" v-model="switch_guardado">
                                                    <label class="custom-control-label" for="switch_guardado"></label>
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
                            <div class="col text-center">
                                <button v-show="btnSave" class="btn btn-info" type="button" @click="guardarInformacion(flagLineaAt)"><span class="fa fa-check-circle" aria-hidden="true"></span> Guardar</button>
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
                formTable: true,
                formTableEdit: true,
                formAnalisis:false,
                caracterizados:[],
                flagDisable:"",
                optionPorcentaje:[{"text":"Parcialmente","value":1},{"text":"Totalmente","value":2},{"text":"Se modificó en un porcentaje","value":3}],
                optionSiNo:[{"text":"Si","value":1},{"text":"No","value":2}],
                objetivosCv:false,
                objetivosAe:false,
                objetivosIc:false,
                optionObjetivos:[{"text":"Totalmente","value":1},{"text":"Parcialmente","value":2}],
                checkSave:true,
                checkApprove:false,
                btnSave:true,
                btnApprove:false,
                switch_guardado: true,
                switch_aprobacion: false,
                flagLineaAt:"",
                optionDesa:[{"text":"Desarrollo de la sensibilidad estética","value":1},{"text":"Desarrollo de la expresión simbólica","value":2},{"text":"Otros","value":3}],
                optionManeras: [{"text":"Maneras de pensar - cognitivo","value":1},{"text":"Maneras de socializar - Socio-Afectivo Convivencial","value":2},{"text":"Prácticas artísticas disciplinares - Físico-creativo","value":3}],
                idGrupo:"",
                id_planeacion_hidden:"",
                selectTipoInforme: [{"text":"Planeaciones Propias","value":0},{"text":"Planeaciones a Supervisar","value":1}],
                idTipoInforme: [],
                selectEstado: [{"text":"Revisados","value":0},{"text":"Devueltos","value":1},{"text":"En proceso de Revisión","value":2}],
                idEstado:[],
                planeaciones: [],
                id_valoracion_hidden:"",
                txObserRevi:false,
                txRevision:"",
                base:'',
            }
        },
        mounted() {
            this.getIdPersona();
            setTimeout(function(){ vm.getRolPersona(); }, 1500);

            const vm = this;
            setTimeout(function(){ vm.getInfoTable(); }, 2000);
            setTimeout(function(){ vm.getInfoTableEdit(); }, 3000);
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
                    .post("/sif/framework/componentePedagogico/getInfoTableAnalisis", {
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
            
            getInfoTableEdit(){
                axios
                    .post("/sif/framework/componentePedagogico/getInfoTableEditAna", {
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

            register(idLinea, idGrupo, idPlaneacion) {
                
                this.formAnalisis = true;

                if (idLinea == 1) {
                    this.objetivosAe = true;
                }
                if (idLinea == 2) {
                    this.objetivosIc = true;
                }
                if (idLinea == 3) {
                    this.objetivosCv = true;
                }

                this.formTableEdit = false;
                this.formTable = false;
                this.flagLineaAt = idLinea;
                this.idLineaAt = idLinea;
                this.idGrupo = idGrupo;
                this.id_planeacion_hidden = idPlaneacion;
            },

            guardarInformacion(idLineaAt){
                
                if(this.switch_guardado === true){

                    var msg = "";
                    
                    if(this.formulario.valoracion == "")
                        msg += "VALORACIÓN Y SEGUIMIENTO DEL PROCESO FORMATIVO<br>";
                    
                    if(this.formulario.porcentaje == null)
                        msg += "¿En qué medida la planeación que desarrollé para este grupo se realizó?<br>";

                    if(this.formulario.objetivo == null)
                        msg += "A) cumplir el objetivo<br>";
                    
                    if(this.formulario.orientadora == null)
                        msg += "B) responder a la pregunta orientadora<br>";
                    
                    if(this.formulario.cambiosFormas == null)
                        msg += "¿Qué cambios en las formas de ser pensar y hacer se dieron en los participantes a partir del proceso de formación?<br>";
                    
                    if(this.formulario.posibilidades == null)
                        msg += "¿Cuáles son las posibilidades, intereses y temáticas para continuar en el desarrollo en próximos procesos?";
                    
                    if(this.formulario.conclusion == null)
                        msg += "Conclusión reflexiva<br>";
                
                    if(idLineaAt == 1){

                        if(this.formulario.desarrolladas == null)
                            msg += "Competencias desarrolladas<br>";
                        
                        if(this.formulario.maneras == null)
                            msg += "Maneras<br>";

                    }
                    if(idLineaAt == 2){

                        if(this.formulario.objIcUno == null)
                            msg += "Los/as participantes estuvieron activos/as en las diferentes etapas de desarrollo del proyecto (investigación, busca de soluciones, argumentación, socialización)<br>";
                        
                        if(this.formulario.objIcUnoText == null)
                            msg += "Amplíe su respuesta <br>";
                        
                        if(this.formulario.objIcDos == null)
                            msg += "¿Durante la realización del proyecto se trabajó de forma colectiva?<br>";
                        
                        if(this.formulario.objIcDosText == null)
                            msg += "Amplíe su respuesta <br>";
                        
                        if(this.formulario.objIcTres == null)
                            msg += "¿De acuerdo al planteamiento del proyecto, se adquirieron las habilidades técnicas, expresivas y argumentativas que hicieron posible su ejecución?<br>";
                        
                        if(this.formulario.objIcTresText == null)
                            msg += "Amplíe su respuesta <br>";
                        
                        if(this.formulario.objIcCuatro == null)
                            msg += "La relación con la comunidad - el sector- el público se dio como se contemplaba en el proyecto.<br>";
                        
                        if(this.formulario.objIcCuatroText == null)
                            msg += "Amplíe su respuesta <br>";

                    }
                    if(idLineaAt == 3){

                        if(this.formulario.imaginarios == null)
                            msg += "transformación de imaginarios<br>";
                        
                        if(this.formulario.formasRelacion == null)
                            msg += "transformación de imaginarios y formas de relación. <br>";
                    }

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

                const formulario = document.getElementById('formAnalisisSave');
                var formData = new FormData(formulario);
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                formData.append("linea_atencion", this.idLineaAt);
                formData.append("id_grupo", this.idGrupo);
                formData.append("formulario", JSON.stringify(this.formulario));
                formData.append("id_planeacion", this.id_planeacion_hidden);
                formData.append("finalizado", this.switch_guardado);
                formData.append("id_usuario", this.id_persona);

                axios
				.post("/sif/framework/componentePedagogico/guardarAnalisisGrupo",
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
                        this.formAnalisis = false;
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

            editAnalisis(idValoracion, idGrupo, idLinea){
                
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
                .post("/sif/framework/componentePedagogico/getAnalisis",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idValoracion": idValoracion,
                })
				.then(response => {

                    this.dataPlanea = response.data;

                    this.formAnalisis = true;
                    this.formulario = JSON.parse(this.dataPlanea.JSON_formulario);
                    this.formulario = JSON.parse(this.formulario);
                    
                    if (idLinea == 1) {
                        this.objetivosAe = true;
                    }else if(idLinea == 2) {
                        this.objetivosIc = true;
                    }else if(idLinea == 3){
                        this.objetivosCv = true;
                    }
                    
                    this.idLineaAt = idLinea;
                    this.idGrupo = idGrupo;
                    this.formTable = false;
                    this.formTableEdit = false;
                    this.id_valoracion_hidden = idValoracion;
                    
                    Swal.close();
				})
				.catch(error => {
					console.log("No se puede cargar la información");
				});
            },

            revAnalisis(idValoracion, idGrupo, idLinea, flag){
                
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
                .post("/sif/framework/componentePedagogico/getAnalisis",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idValoracion": idValoracion,
                })
				.then(response => {

                    this.dataPlanea = response.data;

                    this.formAnalisis = true;
                    this.formulario = JSON.parse(this.dataPlanea.JSON_formulario);
                    this.formulario = JSON.parse(this.formulario);
                    
                    if (idLinea == 1) {
                        this.objetivosAe = true;
                    }else if(idLinea == 2) {
                        this.objetivosIc = true;
                    }else if(idLinea == 3){
                        this.objetivosCv = true;
                    }

                    if (flag == 0) {
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
                    this.flagDisable = idValoracion;
                    this.idLineaAt = idLinea;
                    this.idGrupo = idGrupo;
                    this.formTable = false;
                    this.formTableEdit = false;
                    this.id_valoracion_hidden = idValoracion;
                    
                    Swal.close();
                })
				.catch(error => {
					console.log("No se puede cargar la información");
				});
            },

            aprobar(idValoracion){
                this.switch_aprobacion = $("#switchAprobacion").is(':checked');

                axios
                    .post("/sif/framework/componentePedagogico/registerApprovalAnalisis", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_valoracion": idValoracion,
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

            pdfValoracion(idInforme, idLinea){   
                window.open(this.base + '/sif/framework/componentePedagogico/pdfValoracion/'+ idInforme + '/' + idLinea);
            },

            pdfProceso(idInforme, idLinea){   
                window.open(this.base + '/sif/framework/componentePedagogico/pdfProceso/'+ idInforme + '/' + idLinea);
            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>