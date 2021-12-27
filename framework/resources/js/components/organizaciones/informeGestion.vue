<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-muted">
                <h2 class="m-0">Informe de Gestión</h2>
            </div>
            <div class="card-body text-center">
                <div id="tableEditarInforme" v-show="tableEditarInforme">
                <form>
                    <div class="row">
                            <div class="col-md-4" align="left">
                            <label>Tipo de Informe</label>
                            </div>
                            <div class="col-md-4">
                                <multiselect v-model="idTipoInforme" label="text" :options="selectTipoInforme" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                            </div>
                            <div class="col-md-4">
                            </div> 
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4" align="left">
                                <label>Estado Informe de Gestión</label>
                            </div>
                            <div class="col-md-4">
                                <multiselect v-model="idEstado" label="text" :options="selectEstado" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4" align="left">
                                <label>Fechas de corte</label>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" v-model="dateFiltro" type="date" min="1900-01-01" v-bind:max="fecha_max" required>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" v-model="dateFiltroFin" type="date" min="1900-01-01" v-bind:max="fecha_max" required>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button class="btn btn-info" type="button" @click="getInfoTableInformesGestion()"><span class="fa fa-search" aria-hidden="true"></span> Consultar</button>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-12"><br></div>

                    </div>
                    
                    <div class="row form-group justify-content-center" id="search_result">
                        <div class="row form-group col-sm-8">
                            <button class="btn btn-info" type="button" @click="generarFormInformeGestion()"><span class="fa fa-plus" aria-hidden="true"></span> Nuevo Informe</button>
                        </div>
                        
                        <div class="col-sm-12">
                            <div v-if="informes!==''">
                            <table id="tableInformesGestion" name="tableInformesGestion" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre de la Organización o Entidad</th>
                                        <th>Num Contrato</th>
                                        <th>Periodo</th>
                                        <th>Fecha de Registro/Edición</th>
                                        <th>Opciones</th>
                                        <th>Estado</th>
                                        <th>Documento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(informe,i) in informes" :key="i">
                                        <td>{{informe.convenio.organizacion.VC_Nom_Organizacion}}</td>
                                        <td>{{informe.convenio.vc_numero_contrato}}</td>
                                        <td>{{informe.dt_periodo_ini}}--{{informe.dt_periodo_fin}}</td>
                                        <td>{{informe.updated_at}}</td>
                                        <td>
                                            <button v-if="informe.convenio.fk_id_supervisor == id_persona || informe.convenio.fk_id_apoyo == id_persona" v-bind:id="'review_'+informe.pk_id_tabla" class="btn btn-warning reviewInforme" type="button" @click="reviewInformeGestion(informe.pk_id_tabla)"><span class="fa fa-eye" aria-hidden="true"></span></button>
                                            <button v-else v-bind:id="'edit_'+informe.pk_id_tabla" class="btn btn-warning editInforme" type="button" @click="editInformeGestion(informe.pk_id_tabla)" :disabled="(informe.in_aprobacion == 1 || informe.in_estado_final == 1) ? true : false"><span class="fa fa-edit" aria-hidden="true"></span></button>
                                        </td>
                                        <td>
                                            <span v-if="informe.in_estado_final == 1" class="badge badge-success">Finalizado</span>
                                            <span v-if="informe.in_estado_final != 1" class="badge badge-warning">Sin Finalizar</span>
                                            <span v-if="informe.in_aprobacion == null" class="badge badge-warning">Sin aprobación</span>
                                            <span v-if="informe.in_aprobacion == 0" class="badge badge-danger">Rechazado</span>
                                            <span v-if="informe.in_aprobacion == 1" class="badge badge-success">Aprobado</span>
                                        </td>
                                        <td>
                                            <button v-bind:id="'pdf_'+informe.pk_id_tabla" class="btn btn-info" type="button" @click="pdfInformeGestion(informe.pk_id_tabla)" :disabled="(informe.in_aprobacion == null || informe.in_aprobacion == 0) ? true : false"><span class="fa fa-file-pdf" aria-hidden="true"></span></button>
                                        </td>
                                    </tr>  
                                    
                                </tbody>
                                
                            </table>
                            </div>
                        </div>
                    </div>
                </form>
                </div>

                <div id="formInformeGestion" v-show="formInformeGestion">
                    <form
                        id = "formInforme"
                        role = "form"
                        action = ""
                        v-on:submit.prevent="saveInformeGestion()"
                        novalidate="true"
                    >
                        <div class="row">
                            <div class="col-md-4">
                                <label>Seleccione según el caso<span style="color:#cb0000"> *</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="id_informe_hiden"  id="id_informe_hiden" v-model="idInformeHiden">
                                <input type="hidden" name="id_approve_hiden"  id="id_approve_hiden" v-model="idInformeApproveHiden">
                                <input type="hidden" name="id_convenio_hidden"  id="id_convenio_hidden" v-model="idConvenioHidden">
                                <multiselect v-model="idTipoContrato" label="text" :options="selectTipoContrato" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required :disabled="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false"></multiselect>
                            </div>
                            <div class = "col-md-4">
                                <input name="txNumeroContrato" type="text" class="form-control" id="txNumeroContrato" v-model="txNumeroContrato" placeholder="Registre número de contrato" @change="inputChanged($event)" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false">
                                <span v-show="numErr" style="color:red">{{numeroError}}</span>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-left"><i class="fa fa-book pr-4"></i>Datos Generales</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-3" align="left">
                                <label>Fecha Acta de Inicio</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="dateActaInicio" v-model="dateActaInicio" type="date" min="1900-01-01" v-bind:max="fecha_max" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false">
                            </div>
                            <div class="col-md-3">
                                <label>Fecha de Terminación</label>
                            </div>
                            <div class="col-md-3">
                                <input class="form-control" name="dateActaTerminacion" v-model="dateActaTerminacion" type="date" min="1900-01-01" v-bind:max="fecha_max" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4">
                                <label>Área(s)<span style="color:#cb0000"> *</span></label>
                            </div>
                            <div class="col-md-4">
                                <multiselect v-model="idArea" label="text" :options="selectAreas" placeholder="Seleccione una opción" :show-labels="false" track-by="value" :multiple="true" required :disabled="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false"></multiselect>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <label>Nombre del Proyecto</label>
                                <textarea name="nombreProyecto" v-model="nombreProyecto" class="form-control" placeholder="Digíte el nombre del proyecto" rows="2" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-3" align="left">
                                <label>Nombre de la Organización o Entidad</label>
                            </div>
                            <div class="col-md-3">
                                <multiselect v-model="idOrganizacion" label="text" :options="selectOrganizaciones" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required :disabled="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false"></multiselect>
                            </div>
                            <div class="col-md-3">
                                <label>Representante Legal</label>
                            </div>
                            <div class="col-md-3">
                                <input name="representanteLegal" type="text" v-model="representanteLegal" class="form-control" id="txRepresentante" placeholder="" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-3" align="left">
                                <label>Numero del presente Informe</label>
                            </div>
                            <div class="col-md-3">
                                <input name="numInforme" type="number" v-model="numInforme" class="form-control" id="txNumero" placeholder="" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!='')? true : false">
                            </div>
                            <div class="col-md-3">
                                <label>De</label>
                            </div>
                            <div class="col-md-3">
                                <input name="numInformeFin" type="number" v-model="numInformeFin" class="form-control" id="txNumeroFin" placeholder="" required :readonly="(idInformeHiden!=''||idInformeApproveHiden!=''||flagNew==1)? true : false">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-3" align="left">
                                <label>Periodo del Informe del</label>
                            </div>
                            <div class="col-md-3">
                                <input name="datePeriodoIni" class="form-control" v-model="datePeriodoIni" type="date" min="1900-01-01" v-bind:max="fecha_hoy" required :readonly="(idInformeApproveHiden!='')? true : false">
                            </div>
                            <div class="col-md-3">
                                <label>Al</label>
                            </div>
                            <div class="col-md-3">
                                <input name="datePeriodoFin" class="form-control" v-model="datePeriodoFin" type="date" min="1900-01-01" v-bind:max="fecha_hoy" required @change="validateDate(datePeriodoIni,datePeriodoFin)" :readonly="(idInformeApproveHiden!='')? true : false">
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12 alert alert-warning" align="left" role="alert">
                                <p>
                                    *NOTA IMPORTANTE: Los periodos no se pueden traslapar, entonces:<br><br>
                                    -Informe 1 de X: Desde la fecha del acta de inicio hasta el día de entrega del informe<br>
                                    -Informe 2 de X: Desde el otro día de la entrega anterior, hasta la fecha de entrega actual<br>
                                    -Informe 3 de X: Desde el otro día de la entrega anterior, hasta la fecha de terminación del contrato<br>
                                    -Incluir tantos como sea necesario según lo pactado en el contrato.
                                </p>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-3">
                                <label>SUPERVISOR(A)</label>
                            </div>
                            <div class="col-md-3">
                                <multiselect v-model="idSupervisor" label="text" :options="selectSupervisor" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required :disabled="(idInformeHiden!=''|| idInformeApproveHiden!=''||flagNew==1)? true : false"></multiselect>
                            </div>
                            <div class="col-md-3">
                                <label>APOYO A LA SUPERVISIÓN</label>
                            </div>
                            <div class="col-md-3">
                                <multiselect v-model="idApoyo" label="text" :options="selectApoyo" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required :disabled="(idInformeHiden!=''|| idInformeApproveHiden!=''||flagNew==1)? true : false"></multiselect>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-2" align="left">
                                <label>OBJETO</label>
                            </div>
                            <div class="col-md-10">
                                <textarea v-model="txObjeto" name="txObjeto" id="txObjeto" class="form-control" placeholder="Escribir aquí el objeto de su convenio o contrato" rows="2" required :readonly="(idInformeHiden!=''|| idInformeApproveHiden!=''||flagNew==1)? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-2" align="left">
                                <label>CORREO ELECTRÓNICO</label>
                            </div>
                            <div class="col-md-10">
                                <input name="txEmail" id="txEmail" type="email" class="form-control" v-model="txEmail" placeholder="Correo electrónico del responsable de la elaboración de este informe" @change="isEmailValid($event)" required :readonly="(idInformeHiden!=''|| idInformeApproveHiden!=''||flagNew==1)? true : false">
                                <span v-show="emailErr" style="color:red">{{emailError}}</span>

                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-center">1. CUMPLIMIENTO Y EVALUACIÓN DE OBLIGACIONES CONTRACTUALES (ESPECÍFICAS)</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4" align="left">
                                <button class="btn btn-info" type="button" @click="agregarFila++" :disabled="(idInformeApproveHiden!='')? true : false"><span class="fa fa-plus" aria-hidden="true"></span> Registrar Obligación</button>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-12"><br></div>
                            <div class="row col-md-12">
                                <div class="col-md-2">
                                    <label>TIPO DE OBLIGACIÓN</label>
                                </div>
                                <div class="col-md-2">
                                    <label>OBLIGACIONES DEL CONTRATO</label>
                                </div>
                                <div class="col-md-2">
                                    <label>ACTIVIDADES</label>
                                </div>
                                <div class="col-md-2">
                                    <label>DESCRIPCIÓN</label>
                                </div>
                                <div class="col" align="center">
                                    <label>SOPORTES O EVIDENCIAS</label>
                                </div>
                                
                            </div>
                            <div class="row col-md-12" v-for="(obligacion,i) in agregarFila" :key="i">  
                                <div class="col-md-2">
                                    <select class="form-control selectoresObligaciones" v-model="obl[i]" v-bind:id="'selectTipoObligacion_'+i" v-bind:name="'selectTipoObligacion[]'" label="text" placeholder="Seleccione una opción" :disabled="(idInformeApproveHiden!=''||flagNew==1)? true : false">
                                        <option v-for="option in selectTipoObli" :key="option.value" :value="option.value">
                                            {{ option.text }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <textarea v-model="obliga[i]" v-bind:name="'txObligacion[]'" v-bind:id="'txObligacion_'+i" class="form-control" placeholder="Transcriba textualmente las obligaciones tal como aparece en las condiciones adicionales)" rows="4" :readonly="(idInformeApproveHiden!=''||flagNew==1)? true : false"></textarea>
                                </div>
                                <div class="col">
                                    <textarea v-model="actividad[i]" v-bind:name="'txActividad[]'" v-bind:id="'txActividad_'+i" class="form-control" placeholder="Mencione la actividad realizada, en relación con el cumplimiento de las obligaciones contractual" rows="4" :readonly="(idInformeApproveHiden!='')? true : false"></textarea>
                                </div>
                                <div class="col">
                                    <textarea v-model="detalle[i]" v-bind:name="'txDetalle[]'" v-bind:id="'txDetalle_'+i" class="form-control" placeholder="Explique de manera detallada y ordenada como, cuando y donde y con quien se realizaron las actividades que dan cumplimiento a las obligaciones contractuales)" rows="4" :readonly="(idInformeApproveHiden!='')? true : false"></textarea>
                                </div>
                                <div class="col">
                                    <textarea v-model="soportes[i]" v-bind:name="'txAnexos[]'" v-bind:id="'txAnexos_'+i" class="form-control" placeholder="Ejemplo: Anexo 1: Fotografía obra de teatro villa mayor 14/06/2018" rows="4" :readonly="(idInformeApproveHiden!='')? true : false"></textarea>
                                </div>
                                <div class="col-md-1" aling="center">
                                    <button v-bind:id="'deleteRow_'+i" class="btn btn-danger" type="button" :data-pos="i" @click="deleteObligacion(i)" :disabled="(idInformeApproveHiden!=''||flagNew==1)? true : false"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                </div>
                            </div>
                            
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-center"><i class="fa fa-cart-plus pr-4"></i>PRODUCTOS</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4" align="left">
                                <button class="btn btn-info" type="button" @click="contProductos++" :disabled="(idInformeApproveHiden!='')? true : false"><span class="fa fa-plus" aria-hidden="true"></span></button>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <label>PRODUCTO ENTREGADO</label>
                            </div>
                            <div class="col-md-4">
                                <label>MECANISMO DE VERIFICACIÓN</label>
                            </div>
                            <div class="col-md-4">
                                <label>ACCIONES</label>
                            </div>
                            <div class="row col-md-12" v-for="(producto,i) in contProductos" :key="'A'+ i">
                                <div class="col-md-4">
                                    <input v-model="product[i]" v-bind:name="'txProducto[]'" v-bind:id="'txProducto_'+i" type="text" class="form-control" :readonly="(idInformeApproveHiden!='')? true : false">
                                </div>
                                <div class="col-md-4">
                                    <input v-model="mecanismo[i]" v-bind:name="'txMecanismo[]'+i" v-bind:id="'txMecanismo_'+i" type="text" class="form-control" :readonly="(idInformeApproveHiden!='')? true : false">
                                </div>
                                <div class="col-md-4" aling="center">
                                    <button v-bind:id="'deleteRowP_'+i" class="btn btn-danger" type="button" @click="deleteProducto(i)" :disabled="(idInformeApproveHiden!='')? true : false"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-center"><i class="fa fa-file pr-4"></i>CONCLUSIONES Y/O RECOMENDACIONES</div>
                            </div>
                            <div class="col-md-12">
                                <textarea name="txConclusiones" id="txConclusiones" v-model="conclusiones" class="form-control" placeholder="En este punto es necesario que se realice un análisis cualitativo del desarrollo del proceso, relacionando además los datos de cumplimiento de metas e indicadores definidos en la propuesta y/o proyecto, en caso de que aplique. Es importante que se identifiquen los aspectos a destacar y las dificultades presentadas en el desarrollo del proceso contractual. Se requiere que se definan las conclusiones teniendo en cuenta los objetivos propuestos para el proceso a desarrollar." rows="4" :readonly="(idInformeApproveHiden!='')? true : false"></textarea>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12">
                                <div class="card-header bg-info text-white text-center"><i class="fa fa-share-alt pr-4"></i>PÁGINAS WEB Y/O LINKS EN LOS QUE SE REALIZÓ DIFUSIÓN AL PROYECTO</div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4" align="left">
                                <button class="btn btn-info" type="button" @click="contLinks++" :disabled="(idInformeApproveHiden!='')? true : false"><span class="fa fa-plus" aria-hidden="true"></span></button>
                            </div>
                            <div class="row col-md-12"  v-for="(link,i) in contLinks" :key="'B'+ i">
                                <div class="col-md-10">
                                    <input v-model="www[i]" v-bind:name="'txLink[]'" v-bind:id="'txLink_'+i" type="text" class="form-control" placeholder="Diligencie el link de difusión" :readonly="(idInformeApproveHiden!='')? true : false"> 
                                </div>
                                <div class="col-md-2" aling="center">
                                    <button v-bind:id="'deleteRowL_'+i" class="btn btn-danger" type="button" @click="deleteLink(i)" :disabled="(idInformeApproveHiden!='')? true : false"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-12" id="txObserRevi" v-show="txObserRevi">
                                <div class="col-md-12">
                                    <label>OBSERVACIONES GENERALES</label>
                                </div>
                                <div class="col-md-12">
                                    <textarea v-show="txObserRevi" v-model="txRevision" name="txRevision" id="txRevision" class="form-control" placeholder="Escribir aquí las observaciones generales" rows="2" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12"><br></div>
                            <div class="col-md-4"></div>
                            <div class="custom-control custom-switch col-md-4" v-show="checkAprobacion">
                                <input name="check_aprobacion" type="checkbox" class="custom-control-input" id="switchAprobacion" v-model="switch_aprobacion">
                                <label class="custom-control-label" for="switchAprobacion">Aprobar</label>
                            </div>
                            <div class="custom-control custom-switch col-md-4" v-show="checkSave">
                                <input name="check" type="checkbox" class="custom-control-input" id="switchFinalizado" v-model="switch_finalizado">
                                <label class="custom-control-label" for="switchFinalizado">Finalizar</label>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-12"><br><br></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <button type="button" v-show="btnApprove" @click="aprobar(idInformeApproveHiden)" class="btn btn-info">Confirmar</button>
                                <button type="submit" v-show="btnsave" class="btn btn-info">Guardar</button>
                            </div>
                            <div class="col-md-4"></div>
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
        components: { Multiselect },
        data () {
            return {
                obl:{},
                base:'',
                obliga:{},
                actividad:{},
                detalle:{},
                soportes:{},
                product:{},
                mecanismo:{},
                www:{},
                arrayObligaciones: [],
                idTipoContrato: [],
                selectTipoContrato: [],
                FK_tipo_contrato: 85,
                fecha_hoy: "",
                anioActual: "",
                selectAreas: [],
                idArea: [],
                FK_area: 6,
                selectApoyo: [],
                idApoyo: [],
                idSupervisor:[],
                selectSupervisor: [],
                dateActaInicio: "",
                dateActaTerminacion: "",
                nombreProyecto: "",
                representanteLegal:"",
                numInforme:"",
                numInformeFin:"",
                datePeriodoIni:"",
                datePeriodoFin:"",
                txEmail:"",
                selectOrganizaciones:[],
                idOrganizacion: [],
                obligaciones: [],
                selectTipoObli: [],
                contProductos: 0,
                conclusiones:"",
                contLinks: 0,
                agregarFila: 0,
                switch_finalizado: false,
                switch_aprobacion: false,
                fecha_max: "2030-12-31",
                txNumeroContrato:"",
                txObjeto:"",
                formInformeGestion:false,
                tableEditarInforme:true,
                config_tabla:"",
                tableInformeGestion:"",
                resultInformesGestion:"",
                id_persona:"",
                numeroError:'Formato invalido de numero de contrato',
                numErr:false,
                emailError:'Dirección de correo electrónico inválida',
                emailErr:false,
                selectTipoInforme: [{"text":"Informes Propios","value":0},{"text":"Informes a Supervisar","value":1}],
                idTipoInforme: [],
                selectEstado: [{"text":"Aprobado","value":0},{"text":"Sin Aprobar","value":1},{"text":"Rechazados","value":2}],
                idEstado:[],
                dateFiltro:"",
                dateFiltroFin:"",
                grupos: [],
                informes:[],
                idInformeHiden:"",
                idInformeApproveHiden:"",
                idConvenioHidden:"",
                infoGestion: [],
                txRevision:"",
                txObserRevi:false,
                checkAprobacion:false,
                checkSave:true,
                btnApprove:false,
                btnsave:true,
                flagNew:0,
            }
        },
        mounted() { 

            this.getIdPersona();
            this.getTiposObligaciones();

            const vm = this;
            setTimeout(function(){ vm.getInfoTableInformesGestion(); }, 1500);

            var date = new Date();
			var month;
			var day;

			if((date.getMonth() + 1) < 10)
				month = "0" + (date.getMonth() + 1);
			else
				month = (date.getMonth() + 1);

			if(date.getDate() < 10)
				day = "0" + date.getDate();
			else
				day = date.getDate();

			this.fecha_hoy = date.getFullYear() + "-" + month + "-" + day;
            this.anioActual = date.getFullYear();
        },
        methods: {

            tabla(){
                Vue.nextTick(function () {
                    $('#tableInformesGestion').DataTable();
                });
            },

            getInfoTiposContratos(){
				axios
                    .post("/sif/framework/organizaciones/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: this.FK_tipo_contrato
                })
				.then(response => {
                    this.selectTipoContrato = response.data;
                    
                    this.selectTipoContrato.forEach((item) => {
						if(item.value == this.infoGestion.informeGestion.convenio['fk_id_tipo_contrato'])
                            this.idTipoContrato = {text: item.text, value: item.value};
					});
                    
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Contratos");
				});
            },

            getIdTiposContratos(){
				axios
                    .post("/sif/framework/organizaciones/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: this.FK_tipo_contrato
                })
				.then(response => {
                    this.selectTipoContrato = response.data;
                    
                    this.selectTipoContrato.forEach((item) => {
						if(item.value == this.infoGestion.convenio['fk_id_tipo_contrato'])
                            this.idTipoContrato = {text: item.text, value: item.value};
					});
                    
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Contratos");
				});
            },

            getInfoAreas(){
				axios
                    .post("/sif/framework/organizaciones/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: this.FK_area
                })
				.then(response => {
                   
                    this.selectAreas = response.data;
                    var areasSelec = this.infoGestion.informeGestion.convenio['vc_areas'].split(',');
                    
                    this.selectAreas.forEach((item) => {
            
                        areasSelec.forEach((area) => { 
                            if(item.value == area)
                                this.idArea.push({text: item.text, value: item.value});
                        });
                        
					});
                    
				})
				.catch(error => {
					console.log("No se puede cargar la información de Areas");
				});
            },

            getIdAreas(){
				axios
                    .post("/sif/framework/organizaciones/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: this.FK_area
                })
				.then(response => {
                   
                    this.selectAreas = response.data;
                    var areasSelec = this.infoGestion.convenio['vc_areas'].split(',');
                    
                    this.selectAreas.forEach((item) => {
            
                        areasSelec.forEach((area) => { 
                            if(item.value == area)
                                this.idArea.push({text: item.text, value: item.value});
                        });
                        
					});
                    
				})
				.catch(error => {
					console.log("No se puede cargar la información de Areas");
				});
            },

            getPersonaApoyo(){
				axios
                    .post("/sif/framework/personas/getApoyoSupervision", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Tipo_Persona: 12
                })
				.then(response => {

                    this.selectApoyo = response.data;
                    
                    this.selectApoyo.forEach((item) => {
						if(item.value == this.infoGestion.informeGestion.convenio['fk_id_apoyo'])
                            this.idApoyo = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información de los Apoyos a la Supervisión");
				});
            },

            getIdPersonaApoyo(){
				axios
                    .post("/sif/framework/personas/getApoyoSupervision", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Tipo_Persona: 12
                })
				.then(response => {

                    this.selectApoyo = response.data;
                    
                    this.selectApoyo.forEach((item) => {
						if(item.value == this.infoGestion.convenio['fk_id_apoyo'])
                            this.idApoyo = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información de los Apoyos a la Supervisión");
				});
            },

            getPersonaSupervisor(){
				axios
                    .post("/sif/framework/personas/getSupervision", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Tipo_Persona: 37
                })
				.then(response => {

                    this.selectSupervisor = response.data;
                    
                    this.selectSupervisor.forEach((item) => {
						if(item.value == this.infoGestion.informeGestion.convenio['fk_id_supervisor'])
                            this.idSupervisor = {text: item.text, value: item.value};
					});
                    
				})
				.catch(error => {
					console.log("No se puede cargar la información de los Supervisores");
				});
            },

            getIdPersonaSupervisor(){
				axios
                    .post("/sif/framework/personas/getSupervision", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Tipo_Persona: 37
                })
				.then(response => {

                    this.selectSupervisor = response.data;
                    
                    this.selectSupervisor.forEach((item) => {
						if(item.value == this.infoGestion.convenio['fk_id_supervisor'])
                            this.idSupervisor = {text: item.text, value: item.value};
					});
                    
				})
				.catch(error => {
					console.log("No se puede cargar la información de los Supervisores");
				});
            },

            getOrganizaciones(){
				axios
                    .post("/sif/framework/organizaciones/getOrganizaciones", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
				.then(response => {
                    this.selectOrganizaciones = response.data;
                    
                    this.selectOrganizaciones.forEach((item) => {
						if(item.value == this.infoGestion.informeGestion.convenio['fk_id_organizacion'])
                            this.idOrganizacion = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información de las organizaciones");
				});
            },

              getIdOrganizaciones(){
				axios
                    .post("/sif/framework/organizaciones/getOrganizaciones", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
				.then(response => {
                    this.selectOrganizaciones = response.data;
                    
                    this.selectOrganizaciones.forEach((item) => {
						if(item.value == this.infoGestion.convenio['fk_id_organizacion'])
                            this.idOrganizacion = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información de las organizaciones");
				});
            },

            getTiposObligaciones(){
				axios
                    .post("/sif/framework/organizaciones/obtenerParametro", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 86
                })
				.then(response => {
                    this.selectTipoObli = response.data;
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },
            
            saveInformeGestion(){
                
                var msg = "";

                if(this.idTipoContrato == "")
                    msg += "Tipo de Contrato<br>";
                
                if(this.txNumeroContrato == "")
                    msg += "Numero de Contrato<br>";

                if(this.dateActaInicio == "")
                    msg += "Fecha Acta de Inicio<br>";

                if(this.dateActaTerminacion == "")
                    msg += "Fecha de Terminación<br>";
                
                if(this.idArea == "")
                    msg += "Área(s)<br>";
                
                if(this.nombreProyecto == "")
                    msg += "Nombre del Proyecto<br>";
                
                if(this.idOrganizacion == "")
                    msg += "Nombre de la Organización o Entidad<br>";
                
                if(this.representanteLegal == "")
                    msg += "Representante Legal<br>";

                if(this.numInforme == "")
                    msg += "Numero del presente Informe<br>";

                if(this.numInformeFin == "")
                    msg += "Numero del presente Informe<br>";
                
                if(this.datePeriodoIni == "")
                    msg += "Periodo del Informe<br>";

                if(this.datePeriodoFin == "")
                    msg += "Periodo del Informe<br>";

                if(this.idSupervisor == "")
                    msg += "SUPERVISOR(A)<br>";
                
                if(this.idApoyo == "")
                    msg += "APOYO A LA SUPERVISIÓN<br>";

                if(this.txObjeto == "")
                    msg += "OBJETO<br>";
                
                if(this.txEmail == "")
                    msg += "CORREO ELECTRÓNICO<br>";

                if(msg != "") {
                    Swal.fire(
                        'Atención!',
                        "Los siguentes campos son de carácter obligatorio: <br>" + msg,
                        'error'
                    );
                    return false;
                }
                Swal.fire({
                    title: "Cargando información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });

                $(".selectoresObligaciones").attr('disabled', false);

                let ids = "";
					this.idArea.forEach(function (item) { 
						ids += item.value + ",";
					});
					ids = ids.slice(0,-1);

                const formulario = document.getElementById('formInforme');
                var formData = new FormData(formulario);
                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                
                formData.append("idTipoContrato", this.idTipoContrato.value);
                formData.append("idArea", ids);
                formData.append("idOrganizacion", this.idOrganizacion.value);
                formData.append("idSupervisor", this.idSupervisor.value);
                formData.append("idApoyo", this.idApoyo.value);

                axios
                .post("/sif/framework/organizaciones/saveInformeGestion",
                formData, 
                config,
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                })
				.then(response => {

                    if(response.data === true) {
                        Swal.fire(
                            'Información Almacenada',
                            "Se ha guardado correctamente el informe",
                            'success'
                        );
                        const vm = this;
                        setTimeout(function(){ vm.resetForm(); }, 1500);
                        this.getInfoTableInformesGestion();
                    } else {
                        Swal.fire(
                            'Atención!',
                            "No se puede almacenar el informe",
                            'error'
                        );
                    }

				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
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

            getInfoTableInformesGestion(){
				axios
                    .post("/sif/framework/organizaciones/getInfoTableInformesGestion", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_persona,
                    "tipoInforme":this.idTipoInforme.value,
                    "estado":this.idEstado.value,
                    "filtroIni":this.dateFiltro,
                    "filtroFin":this.dateFiltroFin,
                })
                    .then(response => {
                        this.informes = response.data;
                        this.tabla();
                        //console.log(this.informes);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            generarFormInformeGestion() {
            
                this.formInformeGestion = true;
                this.tableEditarInforme = false;
                axios
                    .post("/sif/framework/organizaciones/newReport", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_persona": this.id_persona,
                })
                    .then(response => {

                        if(response.data != ''){

                            this.infoGestion = response.data;
                        
                            this.getIdTiposContratos();
                            this.getIdAreas();
                            this.getIdOrganizaciones();
                            this.getIdPersonaSupervisor();
                            this.getIdPersonaApoyo();
                            
                            this.flagNew = 1
                            this.idConvenioHidden = this.infoGestion.convenio['pk_id_tabla']
                            this.txNumeroContrato = this.infoGestion.convenio['vc_numero_contrato'];
                            this.dateActaInicio = this.infoGestion.convenio['dt_acta_ini'];
                            this.dateActaTerminacion = this.infoGestion.convenio['dt_term'];
                            this.nombreProyecto = this.infoGestion.convenio['vc_proyecto'];
                            this.representanteLegal = this.infoGestion.convenio['vc_representante'];
                            this.numInformeFin = this.infoGestion.informeGestion[0]['vc_fin_info'];
                            this.txObjeto = this.infoGestion.convenio['vc_objeto'];
                            this.txEmail = this.infoGestion.convenio['vc_email'];
                            this.agregarFila = this.infoGestion.detalleActividad.length;
                            
                            this.infoGestion.detalleActividad.forEach((value, index) => {
                                this.obl[index] = value.tipo_Obligacion;
                                this.obliga[index] = value.obligaciones_Contrato;
                            });
                        }else{
                            this.getInfoTiposContratos();
                            this.getInfoAreas();
                            this.getPersonaApoyo();
                            this.getPersonaSupervisor();
                            this.getOrganizaciones();
                        }
                        
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            inputChanged(e){

                var fecha = new Date();
                var anio = fecha.getFullYear();
                var numContrato = this.txNumeroContrato;

                numContrato = numContrato+'-'+anio;
                
                this.txNumeroContrato = numContrato;
        
                if (!numContrato){
                    this.numErr = true;
                }else{
                    this.numErr = false;
                } 
            
            },

            isEmailValid(e) {

                const emailRe = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                
                if (emailRe.test(this.txEmail)) {
                    this.emailErr = false;
                } else {
                    this.emailErr = true;
                }
               
            },

            editInformeGestion(idInforme){
                
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
                .post("/sif/framework/organizaciones/getInformeGestion",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idInforme": idInforme,
                })
				.then(response => {

                    this.infoGestion = response.data;
                    
                    this.formInformeGestion = true;
                    this.tableEditarInforme = false;
                    this.getInfoTiposContratos();
                    this.getInfoAreas();
                    this.getOrganizaciones();
                    this.getPersonaSupervisor();
                    this.getPersonaApoyo();
                    this.idInformeHiden = this.infoGestion.informeGestion['pk_id_tabla'];
                    this.txNumeroContrato = this.infoGestion.informeGestion.convenio['vc_numero_contrato'];
                    this.dateActaInicio = this.infoGestion.informeGestion.convenio['dt_acta_ini'];
                    this.dateActaTerminacion = this.infoGestion.informeGestion.convenio['dt_term'];
                    this.nombreProyecto = this.infoGestion.informeGestion.convenio['vc_proyecto'];
                    this.representanteLegal = this.infoGestion.informeGestion.convenio['vc_representante'];
                    this.numInforme = this.infoGestion.informeGestion['vc_ini_info'];
                    this.numInformeFin = this.infoGestion.informeGestion['vc_fin_info'];
                    this.datePeriodoIni = this.infoGestion.informeGestion['dt_periodo_ini'];
                    this.datePeriodoFin = this.infoGestion.informeGestion['dt_periodo_fin'];
                    this.txObjeto = this.infoGestion.informeGestion.convenio['vc_objeto'];
                    this.txEmail = this.infoGestion.informeGestion.convenio['vc_email'];
                    this.conclusiones = this.infoGestion.informeGestion['vc_concluciones'];
                    this.agregarFila = this.infoGestion.detalleActividad.length;
                    this.contProductos = this.infoGestion.productos.length;
                    this.contLinks = this.infoGestion.links.length;
                    
                    this.infoGestion.detalleActividad.forEach((value, index) => {
                        this.obl[index] = value.tipo_Obligacion;
                        this.obliga[index] = value.obligaciones_Contrato;
                        this.actividad[index] = value.actividades;
                        this.detalle[index] = value.descripcion;
                        this.soportes[index] = value.soportes;
                    });

                    this.infoGestion.productos.forEach((value, index) => {
                        this.product[index] = value.Producto;
                        this.mecanismo[index] = value.Mecanismo;
                    });

                    this.infoGestion.links.forEach((value, index) => {
                        this.www[index] = value.link;
                    });
                    
                    Swal.close();
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },

            deleteObligacion(value){
                alert(value);
            },

            deleteProducto(value){
                alert(value);
            },

            deleteLink(value){
                alert(value);
            },

            resetForm() {
                this.formInformeGestion = false;
                this.tableEditarInforme = true;
            },
            reviewInformeGestion(idInforme){

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
                .post("/sif/framework/organizaciones/getInformeGestion",
                {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "idInforme": idInforme,
                })
				.then(response => {
                    this.infoGestion = response.data;
                    
                    this.formInformeGestion = true;
                    this.tableEditarInforme = false;
                    this.txObserRevi = true;
                    this.checkAprobacion = true;
                    this.checkSave = false;
                    this.btnApprove = true;
                    this.btnsave = false;
                    this.getInfoTiposContratos();
                    this.getInfoAreas();
                    this.getOrganizaciones();
                    this.getPersonaSupervisor();
                    this.getPersonaApoyo();
                    this.idInformeApproveHiden = this.infoGestion.informeGestion['pk_id_tabla'];
                    this.txNumeroContrato = this.infoGestion.informeGestion.convenio['vc_numero_contrato'];
                    this.dateActaInicio = this.infoGestion.informeGestion.convenio['dt_acta_ini'];
                    this.dateActaTerminacion = this.infoGestion.informeGestion.convenio['dt_term'];
                    this.nombreProyecto = this.infoGestion.informeGestion.convenio['vc_proyecto'];
                    this.representanteLegal = this.infoGestion.informeGestion.convenio['vc_representante'];
                    this.numInforme = this.infoGestion.informeGestion['vc_ini_info'];
                    this.numInformeFin = this.infoGestion.informeGestion['vc_fin_info'];
                    this.datePeriodoIni = this.infoGestion.informeGestion['dt_periodo_ini'];
                    this.datePeriodoFin = this.infoGestion.informeGestion['dt_periodo_fin'];
                    this.txObjeto = this.infoGestion.informeGestion.convenio['vc_objeto'];
                    this.txEmail = this.infoGestion.informeGestion.convenio['vc_email'];
                    this.conclusiones = this.infoGestion.informeGestion['vc_concluciones'];
                    this.agregarFila = this.infoGestion.detalleActividad.length;
                    this.contProductos = this.infoGestion.productos.length;
                    this.contLinks = this.infoGestion.links.length;
                    
                    this.infoGestion.detalleActividad.forEach((value, index) => {
                        this.obl[index] = value.tipo_Obligacion;
                        this.obliga[index] = value.obligaciones_Contrato;
                        this.actividad[index] = value.actividades;
                        this.detalle[index] = value.descripcion;
                        this.soportes[index] = value.soportes;
                    });

                    this.infoGestion.productos.forEach((value, index) => {
                        this.product[index] = value.Producto;
                        this.mecanismo[index] = value.Mecanismo;
                    });

                    this.infoGestion.links.forEach((value, index) => {
                        this.www[index] = value.link;
                    });
 
                    Swal.close();
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Obligaciones");
				});
            },
            aprobar(idInforme){

                this.switch_aprobacion = $("#switchAprobacion").is(':checked');

                axios
                    .post("/sif/framework/organizaciones/registerApproval", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_informe": idInforme,
                    "checkApprove":this.switch_aprobacion,
                    "observacionApprove":this.txRevision,
                })
                    .then(response => {
        
                        if(response.data === true) {
                            Swal.fire(
                                'Información Almacenada',
                                "Se ha guardado correctamente la Aprobación",
                                'success'  
                            );
                            const vm = this;
                            setTimeout(function(){ vm.resetForm(); }, 1500);
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

            pdfInformeGestion(idInforme){

                window.open(this.base + '/sif/framework/organizaciones/pdfInformeGestion/'+ idInforme);

            },

            validateDate(dateIni,dateEnd){

                axios
                    .post("/sif/framework/organizaciones/validateDate", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "fechaIni":dateIni,
                    "FechaFin":dateEnd,
                })
                    .then(response => {
        
                        if(response.data === true) {

                            Swal.fire(
                                'Atención!',
                                "Ya se encuentra registrado un informe para el periodo indicado",
                                'error'  
                            );

                            this.datePeriodoIni = "";
                            this.datePeriodoFin = "";
                        }
                      
                    })
                    .catch(error => {
                        console.log(error);
                    });

            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>