<template>
<div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header text-muted">
            <h2 class="m-0">Administración de Beneficiarios</h2>
        </div>
        <div class="card-body text-center">
            <div id="busqueda_beneficiarios" v-show="formBusqueda">
                <p>Digite el número de documento, nombre(s) o apellido(s) para realizar la búsqueda:</p>
                <form>
                    <div class="form-group row justify-content-center">
                        <div class="col-sm-4 text-center">
                            <table>
                                <tr>
                                    <td>Número de Documento</td>
                                    <td>
                                        <div class="custom-control custom-switch ml-2">
                                            <input type="checkbox" class="custom-control-input" id="switchBusqueda" v-model="switch_busqueda">
                                            <label class="custom-control-label" for="switchBusqueda"></label>
                                        </div>
                                    </td>
                                    <td>Nombres y/o Apellidos</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-sm-4">
                            <input type="text" style="text-transform: uppercase" class="form-control" id="TX_CRITERIO_BUSQUEDA" v-model="criterio_busqueda" v-on:input="tabla_beneficiarios.clear().draw();" placeholder="DIGITE CRITERIO DE BÚSQUEDA">
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" @click="buscarBeneficiarios"><span class="fa fa-search" aria-hidden="true"></span> Buscar</button>
                        </div>
                    </div>
                    
                    <div class="row form-group justify-content-center" v-show="tabla_visible" id="search_result">
                        <div class="col-sm-8">
                            <table id="tabla_beneficiarios" name="tabla_beneficiarios" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Colegio</th>
                                        <th>Grado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div id="modificacion_beneficiarios" v-show="formModificacion">
                <div class="form-group row">
                    <button type="button" class="btn btn-link" id="bt-volver" @click="volveraBusqueda"><i class="fas fa-search pr-2"></i> Volver a la búsqueda</button>
                </div>
                <form id="form-datos-basicos">
                    <div class="form-group">
                        <div class="card-header bg-info text-white text-left"><i class="fa fa-address-card pr-4"></i>Datos Básicos del Beneficiario</div>
                    </div>
                    <div class="text-left">
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Tipo de Identificación<span style="color:#cb0000"> *</span></label>
                                <multiselect v-model="id_tipo_documento" label="text" :options="lista_tipos_documento" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                            </div>
                            <div class="col-lg-3">
                                <label>Número de Identificación</label>
                                <input class="form-control" v-model.number="numero_documento" type="number" readonly required>
                            </div>
                            
                            <div class="col-lg-3">
                                <label>Fecha de Nacimiento</label>
                                <input class="form-control" v-model="fecha_nacimiento" type="date" min="1900-01-01" v-bind:max="fecha_hoy" required>
                            </div>

                            <div class="col-lg-3">
                                <label>Fecha de Registro en SIF</label>
                                <p><i class="fa fa-question-circle pr-4"></i>{{fecha_registro}}</p>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Primer Apellido<span style="color:#cb0000"> *</span></label>
                                <input class="form-control text-uppercase" v-model="primer_apellido" placeholder="Digite el primer apellido" type="text" required>
                            </div>
                            <div class="col-lg-3">
                                <label>Segundo Apellido</label>
                                <input class="form-control text-uppercase" v-model="segundo_apellido" placeholder="Digite el segundo apellido" type="text">
                            </div>
                            
                            <div class="col-lg-3">
                                <label>Primer Nombre<span style="color:#cb0000"> *</span></label>
                                <input class="form-control text-uppercase" v-model="primer_nombre" placeholder="Digite el primer nombre" type="text" required>
                            </div>

                            <div class="col-lg-3">
                                <label>Segundo Nombre</label>
                                <input class="form-control text-uppercase" v-model="segundo_nombre" placeholder="Digite el segundo nombre" type="text">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>Dirección</label>
                                <input class="form-control text-uppercase" v-model="direccion" placeholder="Digite la dirección" type="text" required>
                            </div>
                            <div class="col-lg-3">
                                <label>Teléfono</label>
                                <input class="form-control text-uppercase" v-model="telefono" placeholder="Digite el número telefónico" type="number" required> 
                            </div>
                            
                            <div class="col-lg-3">
                                <label>Celular</label>
                                <input class="form-control text-uppercase" v-model="celular" placeholder="Digite el número celular" type="number" required>
                            </div>

                            <div class="col-lg-3">
                                <label>Correo Electrónico</label>
                                <input class="form-control text-uppercase" v-model="correo" placeholder="Digite el correo electrónico" type="text" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label>¿Acepta uso de Imagen?<span style="color:#cb0000"> *</span></label>
                                <multiselect v-model="acepta_uso_imagen" label="text" :options="lista_si_no" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                            </div>
                            <div class="col-lg-3">
                                <label>¿Acepta uso de Obras?<span style="color:#cb0000"> *</span></label>
                                <multiselect v-model="acepta_uso_obras" label="text" :options="lista_si_no" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                            </div>
                            <div class="col-lg-3">
                                <label>¿Acepta uso de Datos?<span style="color:#cb0000"> *</span></label>
                                <multiselect v-model="acepta_uso_datos" label="text" :options="lista_si_no" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                            </div>
                            
                            <div class="col-lg-3">
                                <label>Género</label>
                                <p>{{genero}}</p>
                            </div>
                            <div class="col-lg-3">
                                <label>Origen</label>
                                <p>{{origen}}</p>
                            </div>
                            
                            <div class="col-lg-3 text-right pt-4 pr-4">
                                <button type="button" class="btn btn-success" id="bt-agregar" @click="guardarDatosBasicosBeneficiario"><i class="fas fa-check-circle pr-1"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
				</form>
                <div class="card">
                    <ul class="nav nav-tabs" id="tabDatos" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" @click="getAniosDetalle(beneficiario.id)" href="#historico-adicionales">Datos Adicionales por año (Histórico)</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#historico-documentos" @click="getAniosDocumentos(beneficiario.IN_Identificacion)">Documentos por año (Histórico)</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#actualizar-datos" @click="getFormDatosAdicionales(beneficiario.id, anioActual)">Actualizar Datos Adicionales {{anioActual}}</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#actualizar-documentos">Actualizar Documentos {{anioActual}}</a></li>
                    </ul>
                    
                    <div class="tab-content">
			            <div id="historico-adicionales" class="tab-pane active">
                            <div class="col-lg-3 pt-2 form-group">
                                <multiselect v-model="anio_detalle" :options="options_anio_detalle" label="text" placeholder="Seleccione Año a Buscar" :show-spans="false" track-by="value" @input="GetInfoDetalladaxAnio(beneficiario.id, anio_detalle); display = true;"></multiselect>
                            </div>
                            <div class="form-group" v-show="infoDetallada">
                                <div class="card-header bg-success text-white text-left">
                                    <i class="fa fa-user pr-4"></i>Información Detallada por Año
                                </div>
                            </div>
                            <div class="text-left" v-show="infoDetallada">
                                <div class="row form-group ml-1 mr-1">
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Grupo Poblacional:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.grupo_poblacional === null || informacionAdicional.grupo_poblacional == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.grupo_poblacional}}</div>                
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>EPS:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.eps === null || informacionAdicional.eps == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.eps}}</div>                
                                        </div>
                                    </div>  
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>RH:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.rh === null || informacionAdicional.rh == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.rh}}</div>                
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group ml-1 mr-1">
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Colegio:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.colegio === null || informacionAdicional.colegio == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.colegio}}</div>                
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Grado:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.grado === null || informacionAdicional.grado == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.grado}}</div>                
                                        </div>
                                    </div>  
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Jornada:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.jornada === null || informacionAdicional.jornada == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.jornada}}</div>                
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group ml-1 mr-1">
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Barrio:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.TX_Barrio === null || informacionAdicional.TX_Barrio == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.TX_Barrio}}</div>                
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Localidad:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.localidad === null || informacionAdicional.localidad == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.localidad}}</div>                
                                        </div>
                                    </div>  
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Crea:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.crea === null || informacionAdicional.crea == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.crea}}</div>                
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group ml-1 mr-1">
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Identificación del Acudiente:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.identificacion_acudiente === null || informacionAdicional.identificacion_acudiente == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.identificacion_acudiente}}</div>                
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Nombre del Acudiente:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.nombre_acudiente === null || informacionAdicional.nombre_acudiente == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.nombre_acudiente}}</div>                
                                        </div>
                                    </div>  
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Teléfono del Acudiente:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.telefono_acudiente === null || informacionAdicional.telefono_acudiente == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.telefono_acudiente}}</div>                
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row form-group ml-1 mr-1">
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Tipo de Afiliación:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.TX_Tipo_Afiliacion === null || informacionAdicional.TX_Tipo_Afiliacion == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.TX_Tipo_Afiliacion}}</div>                
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Enfermedades:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.TX_Enfermedades === null || informacionAdicional.TX_Enfermedades == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.TX_Enfermedades}}</div>                
                                        </div>
                                    </div>  
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Discapacidad:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.tipo_discapacidad === null || informacionAdicional.tipo_discapacidad == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.tipo_discapacidad}}</div>                
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group ml-1 mr-1">
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Etnia:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.etnia === null || informacionAdicional.etnia == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.etnia}}</div>                
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Población Víctima:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.poblacion_victima === null || informacionAdicional.poblacion_victima == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.poblacion_victima}}</div>                
                                        </div>
                                    </div>  
                                    <div class="col-lg-4">
                                        <div class="row"><small><b>Observaciones:</b></small></div>
                                        <div class="row">
                                            <div v-if="informacionAdicional.TX_observaciones === null || informacionAdicional.TX_observaciones == '' "><i style="color:#B4B4B4"><small>Información No Suministrada</small></i></div>
                                            <div v-else>{{informacionAdicional.TX_observaciones}}</div>                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-show="infoDetallada">
                                <div class="card-header bg-secondary text-white text-left">
                                    <i class="fa fa-users pr-4"></i>Información De Grupos
                                </div>
                            </div>
                            <div class="col-sm-12 form-group" v-show="infoDetallada">
                                <table id="tabla_grupos" name="tabla_grupos" class="table table-striped table-bordered table-hover display nowrap" style="width:90%">
                                    <thead>
                                        <tr>
                                            <th>Crea</th>
                                            <th>Código Grupo</th>
                                            <th>Formador</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Usuario Ingreso</th>
                                            <th>Fecha Retiro</th>
                                            <th>Usuario Retiro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="historico-documentos" class="tab-pane">
                            <div class="col-lg-3 pt-2 form-group">
                                <multiselect v-model="anio_archivos" :options="options_anio_archivos" label="text" placeholder="Seleccione Año a Buscar" :show-spans="false" track-by="value" @input="GetArchivosxAnio(beneficiario.IN_Identificacion, anio_archivos); display = true;"></multiselect>
                            </div>
                            <div class="form-group" v-show="infoDocumentos">
                                <div class="card-header bg-success text-white text-left">
                                    <i class="fa fa-folder-open pr-4"></i>Documentos Cargados por Año
                                </div>
                            </div>
                            <div class="text-left" id="grid-documentos" v-show="infoDocumentos">   
                            </div>
                        </div>
                        <div id="actualizar-datos" class="tab-pane">
                            <div class="form-group" v-show="formAdicionales">
                                <div v-if="AdicionalActual.FK_estudiante === null || AdicionalActual.FK_estudiante === undefined" class="alert alert-light m-2" role="alert">
                                    <h4 class="alert-heading">Atención! No hay registro para el año en curso.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </h4>
                                    
                                    <small>Este estudiante no tiene registro para el año {{anioActual}} por ende, se creará un nuevo registro con los datos que diligencie a continuación (podrá ser modificado en cualquier momento).</small>
                                </div>
                                <div class="card-header bg-primary mt-3 text-white text-left">
                                    <i class="fa fa-user pr-4"></i>Datos Generales
                                </div>
                                <div class="text-left">
                                    <div class="row form-group ml-2 mr-2 mt-2">
                                        <div class="col-lg-4">
                                            <label>Grupo Poblacional</label>
                                            <multiselect v-model="AdicionalActual.FK_Grupo_Poblacional" label="text" :options="lista_grupo_poblacional" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Etnia</label>
                                            <multiselect v-model="AdicionalActual.TX_etnia" label="text" :options="lista_etnia" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Tipo Población Víctima</label>
                                            <multiselect v-model="AdicionalActual.FK_tipo_poblacion_victima" label="text" :options="lista_tipo_poblacion_victima" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                    </div>
                                    <div class="row form-group  ml-2 mr-2">
                                        <div class="col-lg-4">
                                            <label>Estrato</label>
                                            <multiselect v-model="AdicionalActual.IN_estrato" label="text" :options="lista_estrato" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Tipo Discapacidad</label>
                                            <multiselect v-model="AdicionalActual.FK_tipo_discapacidad" label="text" :options="lista_tipo_discapacidad" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-show="formAdicionales">
                                <div class="card-header bg-primary text-white text-left">
                                    <i class="fa fa-heartbeat pr-4"></i>Salud
                                </div>
                                <div class="text-left">
                                    <div class="row form-group ml-2 mr-2 mt-2">
                                        <div class="col-lg-4">
                                            <label>Tipo Afiliación</label>
                                            <multiselect v-model="AdicionalActual.TX_Tipo_Afiliacion" label="text" :options="lista_tipo_afiliacion" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>EPS</label>
                                            <multiselect v-model="AdicionalActual.FK_Eps" label="text" :options="lista_eps" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Grupo Sanguíneo</label>
                                            <multiselect v-model="AdicionalActual.FK_RH" label="text" :options="lista_grupo_sanguineo" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                    </div>
                                    <div class="row form-group  ml-2 mr-2">
                                        <div class="col-lg-4">
                                            <label>Enfermedades</label>
                                            <textarea class="form-control text-uppercase" v-model="AdicionalActual.TX_Enfermedades" placeholder="Digíte Enfermedades del Beneficiario" rows="2"></textarea>
                                        </div>
                                        <div class="col-lg-8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-show="formAdicionales">
                                <div class="card-header bg-primary text-white text-left">
                                    <i class="fa fa-flask pr-4"></i>Información Académica
                                </div>
                                <div class="text-left">
                                    <div class="row form-group ml-2 mr-2 mt-2">
                                        <div class="col-lg-4">
                                            <label>CREA<span style="color:#cb0000"> *</span></label>
                                            <multiselect v-model="AdicionalActual.FK_clan" label="text" :options="lista_crea" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Colegio<span style="color:#cb0000"> *</span></label>
                                            <multiselect v-model="AdicionalActual.FK_colegio" label="text" :options="lista_colegios" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Jornada (Arte en Escuela)</label>
                                            <multiselect v-model="AdicionalActual.jornada" label="text" :options="lista_jornada" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                    </div>
                                    <div class="row form-group  ml-2 mr-2">
                                        <div class="col-lg-4">
                                            <label>Grado</label>
                                            <multiselect v-model="AdicionalActual.FK_grado" label="text" :options="lista_grados" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-8">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-show="formAdicionales">
                                <div class="card-header bg-primary text-white text-left">
                                    <i class="fa fa-child pr-4"></i>Información del Acudiente
                                </div>
                                <div class="text-left">
                                    <div class="row form-group ml-2 mr-2 mt-2">
                                        <div class="col-lg-4">
                                            <label>Nombre Acudiente</label>
                                            <input class="form-control text-uppercase" v-model="AdicionalActual.NOMBRE_ACUDIENTE" placeholder="Digite el nombre del acudiente" type="text">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Identificación Acudiente</label>
                                            <input class="form-control text-uppercase" v-model="AdicionalActual.IDENTIFICACION_ACUDIENTE" placeholder="Digite la identificación del acudiente" type="text">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Teléfono o Celular Acudiente</label>
                                            <input class="form-control text-uppercase" v-model="AdicionalActual.TELEFONO_ACUDIENTE" placeholder="Digite número telefónico del acudiente" type="number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-show="formAdicionales">
                                <div class="card-header bg-primary text-white text-left">
                                    <i class="fa fa-globe pr-4"></i>Georeferenciación del Beneficiario
                                </div>
                                <div class="text-left">
                                    <div class="row form-group ml-2 mr-2 mt-2">
                                        <div class="col-lg-4">
                                            <label>Localidad<span style="color:#cb0000"> *</span></label>
                                            <multiselect v-model="AdicionalActual.FK_Localidad" label="text" :options="lista_localidad" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Barrio</label>
                                            <input class="form-control text-uppercase" v-model="AdicionalActual.TX_Barrio" placeholder="Digite barrio de residencia" type="text">
                                        </div>
                                        <div class="col-lg-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" v-show="formAdicionales">
                                <div class="card-header bg-primary text-white text-left">
                                    <i class="fa fa-comment pr-4"></i>Observaciones del Beneficiario
                                </div>
                                <div class="text-left">
                                    <div class="row form-group  ml-2 mr-2 mt-2">
                                        <div class="col-lg-4">
                                            <label>Observaciones</label>
                                            <textarea class="form-control text-uppercase" v-model="AdicionalActual.TX_observaciones" placeholder="Digíte las Observaciones" rows="2"></textarea>
                                        </div>
                                        <div class="col-lg-8 text-right pt-4 pr-4">
                                            <button v-if="AdicionalActual.FK_estudiante === null || AdicionalActual.FK_estudiante === undefined" type="button" class="btn btn-success" id="bt-agregar" @click="guardarDatosAdicionalesBeneficiario(beneficiario.id, anioActual, id_persona)"><i class="fas fa-check-circle pr-1"></i> Guardar Información</button>
                                            <button v-else type="button" class="btn btn-warning" id="bt-agregar" @click="guardarDatosAdicionalesBeneficiario(beneficiario.id, anioActual, id_persona)"><i class="fas fa-check-circle pr-1"></i> Actualizar Información</button>
                                            <div >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="actualizar-documentos" class="tab-pane">
                            <form id="actualizar_documentos">
                                <div class="alert alert-light m-2" role="alert">
                                    <small>A continuación se detallan los documentos que se deben cargar para el año en curso ({{anioActual}}), tenga en cuenta que los puede modificar en cualquier momento:</small>
                                </div>
                                <div class="row text-left form-group ml-1 mr-1 mt-1">
                                    <div class="col-lg-6 rounded-sm border border-success">
                                        <label>Copia del Documento de Identificación</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="documentoIdentificacion" ref="documentoIdentificacion" v-on:change="cargaDI()">
                                            <label class="custom-file-label" for="documentoIdentificacion">{{ documentoIdentificacion ? documentoIdentificacion.name : 'Seleccione un archivo' }}</label>
                                        </div>
                                        <div class="mt-3"><small><b>Archivo:</b> {{ documentoIdentificacion ? documentoIdentificacion.name : 'No ha Seleccionado un Archivo' }}</small></div>
                                    </div>
                                    <div class="col-lg-6 rounded-sm border border-danger">
                                        <label>Copia de un Recibo Público (Luz, agua o gas)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="reciboPublico" ref="reciboPublico" v-on:change="cargaRP()">
                                            <label class="custom-file-label" for="reciboPublico">{{ reciboPublico ? reciboPublico.name : 'Seleccione un archivo' }}</label>
                                        </div>
                                        <div class="mt-3"><small><b>Archivo:</b> {{ reciboPublico ? reciboPublico.name : 'No ha Seleccionado un Archivo' }}</small></div>
                                    </div>
                                </div>
                                <div class="row text-left form-group ml-1 mr-1 mt-1">
                                    <div class="col-lg-6 rounded-sm border border-dark">
                                        <label>Certificado EPS</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="certificadoEPS" ref="certificadoEPS" v-on:change="cargaCE()">
                                            <label class="custom-file-label" for="certificadoEPS">{{ certificadoEPS ? certificadoEPS.name : 'Seleccione un archivo' }}</label>
                                        </div>
                                        <div class="mt-3"><small><b>Archivo:</b> {{ certificadoEPS ? certificadoEPS.name : 'No ha Seleccionado un Archivo' }}</small></div>
                                    </div>
                                    <div class="col-lg-6 rounded-sm border border-warning">
                                        <label>Autorización Uso de Imagen/Obras/Datos</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="usoImagen" ref="usoImagen" v-on:change="cargaUI()">
                                            <label class="custom-file-label" for="usoImagen">{{ usoImagen ? usoImagen.name : 'Seleccione un archivo' }}</label>
                                        </div>
                                        <div class="mt-3"><small><b>Archivo:</b> {{ usoImagen ? usoImagen.name : 'No ha Seleccionado un Archivo' }}</small></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right p-4">
                                    <button type="button" class="btn btn-success" id="bt-agregar" @click="cargarArchivosDisponibles(beneficiario.IN_Identificacion, anioActual, id_persona)"><i class="fa fa-upload pr-1"></i> Cargar Archivos</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
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
    import DataTables from "datatables.net";
    import Sweetalert2 from 'sweetalert2';
    import { forEach } from 'jszip';
    
    export default {
        components: { Multiselect },
        data () {
            return {
                criterio_busqueda: "",
                beneficiarios: [],
                config_tabla: "",
                id_persona: "",
                tabla_beneficiarios: "",
                tabla_grupos: "",
                tabla_visible: false,
                rowNode: "",
                formModificacion: false,
                formBusqueda: true,
                lista_tipos_documento: [],
                numero_documento: "",
                fecha_registro: "", 
                fecha_hoy: "",
                fecha_nacimiento: "",
                primer_apellido: "",
                segundo_apellido: "",
                primer_nombre: "",
                segundo_nombre: "",
                direccion: "",
                telefono: "",
                celular: "",
                correo: "",
                genero: "",
                origen: "",
                id_tipo_documento: [],
                FK_tipo_identificacion: 13,
                beneficiario: [],
                infoDetallada: false,
                infoDocumentos: false,
                formAdicionales: false,
                options_anio_detalle: [],
                options_anio_archivos: [],
                informacionAdicional: [], 
                anio_detalle: "",
                anio_archivos: "",
                grupos: [],
                anioActual: "",
                AdicionalActual: [],
                lista_tipo_poblacion_victima: [],
                lista_tipo_discapacidad: [],
                lista_jornada: [],
                lista_grupo_poblacional: [],
                lista_grupo_sanguineo: [],
                lista_eps: [],
                lista_localidad: [],
                lista_etnia: [],
                lista_crea: [],
                lista_colegios: [],
                lista_grados: [],
                lista_estrato: [],
                lista_tipo_afiliacion: [],
                documentoIdentificacion: undefined,
                reciboPublico: undefined,
                usoImagen: undefined,
                certificadoEPS: undefined,
                acepta_uso_imagen: {"text":"NO","value":0},
                acepta_uso_obras: {"text":"NO","value":0},
                acepta_uso_datos: {"text":"NO","value":0},
                lista_si_no: [{"text":"NO","value":0},{"text":"SI","value":1}],
                switch_busqueda: false
            }
        },
        mounted() {
            // Configuración Tabla Dinamica (DataTable)
            this.config_tabla = {
				autoWidth: false,
				responsive: true,
				pageLength: 10,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por página",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando página _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtrado de un total de _MAX_ registros)",
					"search": "Filtrar",
					"paginate": {
						"first": "Primera",
						"last": "Última",
						"next": "Siguiente",
						"previous": "Anterior"
					},
				}
			};

            this.tabla_beneficiarios = $("#tabla_beneficiarios").DataTable(this.config_tabla);
            this.tabla_grupos = $("#tabla_grupos").DataTable(this.config_tabla);

            // Evento del botón Editar
            const vm = this;
            $(".content").on("click", ".editar", function(){
                var id_beneficiario = $(this).attr("data-id-beneficiario");
                vm.getFormBeneficiario(id_beneficiario);
            });

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
            this.getIdPersona();
        },
        methods: {
            buscarBeneficiarios(e){

                this.switch_busqueda = $("#switchBusqueda").is(':checked');

                if(this.switch_busqueda && this.criterio_busqueda.split(" ").length == 1) {
                    Swal.fire("Error", "La consulta por nombres y apellidos, debe tener por lo menos dos palabras", "error");
                    return false;
                }
                
                if(!this.switch_busqueda && this.criterio_busqueda.split(" ").length > 1) {
                    Swal.fire("Error", "La consulta por número de documento no se puede realizar con más de dos criterios digitados", "error");
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
                axios
                    .post("/sif/framework/administracion/beneficiarios/getAll", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'criterio_busqueda': this.criterio_busqueda,
                        'opcion_busqueda': this.switch_busqueda ? 'nombres': 'documento',
                    })
                    .then(response => {
                        Swal.close();
                        this.beneficiarios = response.data;
						this.tabla_beneficiarios.clear().draw();
                        var colegio;
                        var grado;
                        
                        this.beneficiarios.forEach((value, index) => {
                            colegio = this.beneficiarios[index]['colegio'] != null ? this.beneficiarios[index]['colegio'] : '<i style="color:#B4B4B4">DESCONOCIDO</i>';
                            grado = this.beneficiarios[index]['grado'] != null ? this.beneficiarios[index]['grado'] : '<i style="color:#B4B4B4";>DESCONOCIDO</i>';
                            this.rowNode = this.tabla_beneficiarios.row.add([
                                this.beneficiarios[index]['identificacion'],
                                this.beneficiarios[index]['nombre'],
                                colegio,
                                grado, 
                                "<button type='button' class='btn btn-block btn-warning editar' data-action='edit' data-type='beneficiario' data-id-beneficiario='"+this.beneficiarios[index]["id"]+"'><i class='far fa-edit'></i></button>"
                            ]).draw().node();
                        });
                        
                        this.tabla_visible = true;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            GetArchivosxAnio(id_beneficiario, aniodoc) {
                this.infoDocumentos  = false;
                if(aniodoc === null) return false;
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
                    .post("/sif/framework/administracion/beneficiarios/getInfoArchivosBeneficiario", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'id_estudiante': id_beneficiario,
                        'anio': aniodoc.value,
                    })
                    .then(response => {
                        var htmlRespuesta = "<div class='form-group row'>";
                        var imagen = null;
                        var extension = null;
                        var archivo = null;
                        var nombreDocumento = null;
                        var extensiones = ["png","jpg","jpeg","bmp","gif"];
                        var documentos = {
                            'documento_identificacion': "Documento de Identificación",
                            'permiso_uso_imagen': "Permiso Uso De Imagen/Obras/Datos",
                            'eps': "Certificación EPS",
                            'recibo_publico': "Recibo Público"
                        };
                        response.data.forEach(function (item) {
                            extension = item['VC_Nombre_Archivo'].split(".");
                            archivo = extension[0];
                            extension = extension[extension.length - 1];
                            if ((extensiones.includes(extension))) {
                                var d = new Date();
                                var n = d.getMilliseconds();
                                imagen = '../../uploadedFiles/' + item['VC_Url']+'?v='+n;
                            } else
                                imagen = '../public/images/img_descargar.png';
                            nombreDocumento = documentos[archivo] === undefined ? 'Documento No Identificado' : documentos[archivo];
                            htmlRespuesta += '<div class="col-md-2 ml-4 border img-thumbnail abs-center">';
                            htmlRespuesta += '<a style="color: #000; text-decoration: none;" title="Descargar ' + nombreDocumento + '" download="' + item['FK_Id_Estudiante'] + "_" + item['VC_Nombre_Archivo'] + '" href="../../uploadedFiles/' + item['VC_Url'] + '">';
                            htmlRespuesta += '<small>' + nombreDocumento + '</small>';
                            htmlRespuesta += '<img class="img-thumbnail border-0" style="box-shadow: none;" src="' + imagen + '" alt="' + item['VC_Nombre_Archivo'] + '">';
                            htmlRespuesta += '</a>';
                            htmlRespuesta += '</div>';
                        });
                        htmlRespuesta += "</div>";
                        
                        $("#grid-documentos").html(htmlRespuesta);
                        this.infoDocumentos = true;
                        Swal.close();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            cargaDI() {
                this.documentoIdentificacion = this.$refs.documentoIdentificacion.files[0];
            },
            cargaRP() {
                this.reciboPublico = this.$refs.reciboPublico.files[0];
            },
            cargaCE() {
                this.certificadoEPS = this.$refs.certificadoEPS.files[0];
            },
            cargaUI() {
                this.usoImagen = this.$refs.usoImagen.files[0];
            },
            GetInfoDetalladaxAnio(id_beneficiario, anio) {
                this.infoDetallada = false;
                if(anio === null) return false;
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
                    .post("/sif/framework/administracion/beneficiarios/getInfoAdicionalBeneficiario", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'id_estudiante': id_beneficiario,
                        'anio': anio.value,
                    })
                    .then(response => {
                        this.informacionAdicional = response.data;
                        this.getInfoGruposAnio(id_beneficiario, anio.value);
                        this.infoDetallada = true;
                        Swal.close();
                    })
                    .catch(error => {
                        console.log(error);
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
            cargarArchivosDisponibles(id_beneficiario, anioActual, id_persona){
                var hayDocumentos = true;
                if(this.documentoIdentificacion === undefined && this.certificadoEPS === undefined  && this.reciboPublico === undefined && this.usoImagen === undefined)
                    hayDocumentos = false;

                if(!hayDocumentos){
                    Swal.fire("Error", "Debe seleccionar por lo menos un archivo para realizar la carga", "error");
                    return false;
                }

                Swal.fire({
                    title: "Guardando la información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                var informacion = new FormData();
                var i = 0;
                if(this.documentoIdentificacion !== undefined)
                    informacion.append("documentoIdentificacion", this.documentoIdentificacion);
                if(this.certificadoEPS !== undefined)
                    informacion.append("certificadoEPS", this.certificadoEPS);
                if(this.reciboPublico !== undefined)
                    informacion.append("reciboPublico", this.reciboPublico);
                if(this.usoImagen !== undefined)
                    informacion.append("usoImagen", this.usoImagen);

                informacion.append("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr("content"));
                informacion.append("id", id_beneficiario);
                informacion.append("anio", anioActual);
                informacion.append("id_persona", id_persona);
                axios
                    .post("/sif/framework/administracion/beneficiarios/saveArchivosAnioActual", 
                    informacion,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        Swal.fire(
                            'Archivos Cargados',
                            "Los archivos han sido almacenados de manera satisfactoria",
                            'info'
                        );
                        $('#tabDatos li:first-child a').tab('show');
                        this.documentoIdentificacion = undefined;
                        this.certificadoEPS = undefined;
                        this.reciboPublico = undefined;
                        this.usoImagen = undefined;
                        $("#actualizar_documentos").trigger('reset');
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getInfoGruposAnio(id_beneficiario, anio) {
                axios
                    .post("/sif/framework/administracion/beneficiarios/getInfoGruposAnio", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'id_estudiante': id_beneficiario,
                        'anio': anio,
                    })
                    .then(response => {
                        this.grupos = response.data;
						this.tabla_grupos.clear().draw();
                        
                        this.grupos.forEach((value, index) => {
                            this.rowNode = this.tabla_grupos.row.add([
                                this.grupos[index]['FK_clan'],
                                this.grupos[index]['grupo'],
                                this.grupos[index]['Artista_Formador'],
                                this.grupos[index]['DT_fecha_ingreso'],
                                this.grupos[index]['Usuario_Ingreso'],
                                this.grupos[index]['DT_fecha_retiro'],
                                this.grupos[index]['Usuario_Retiro']
                            ]).draw().node();
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            volveraBusqueda() {
                this.formBusqueda = true;
                this.formModificacion = false;
                this.options_anio_detalle = [];
                this.anio_detalle = "";
                // Reset del NavTab, para que cargue toda la información nuevamente
                $('#tabDatos li:first-child a').tab('show');
            },
            getFormBeneficiario(id_beneficiario){
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
				.post("/sif/framework/administracion/beneficiarios/get", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id": id_beneficiario
				})
				.then(response => {
                    this.beneficiario = response.data;
                    this.getInfoTipoDocumento();
                    this.getInfoAceptaTerminos();
                    this.getAniosDetalle(id_beneficiario);
                    this.numero_documento = this.beneficiario['IN_Identificacion'];
                    this.fecha_registro = this.beneficiario['DA_Fecha_Registro'];
                    this.fecha_nacimiento = this.beneficiario['DD_F_Nacimiento'];
                    this.primer_apellido = this.beneficiario['VC_Primer_Apellido'];
                    this.segundo_apellido = this.beneficiario['VC_Segundo_Apellido'];
                    this.primer_nombre = this.beneficiario['VC_Primer_Nombre'];
                    this.segundo_nombre = this.beneficiario['VC_Segundo_Nombre'];
                    this.direccion = this.beneficiario['VC_Direccion'];
                    this.telefono = this.beneficiario['VC_Telefono'];
                    this.celular = this.beneficiario['VC_Celular'];
                    this.correo = this.beneficiario['VC_Correo'];
                    this.genero = this.beneficiario['CH_Genero'];
                    this.origen = this.beneficiario['VC_Tipo_Estudiante'];
                    this.formBusqueda = false;
                    this.formModificacion = true;
                    this.infoDetallada = false;
                    this.options_anio_detalle = [];
                    this.anio_detalle = "";
                    Swal.close();
				})
				.catch(error => {
					Swal.fire("Error", "No se puede cargar la información, por favor inténtelo nuevamente", "error");
				});
			},
            getInfoAceptaTerminos() {
                this.lista_si_no.forEach((item) => {
                if(item.value == this.beneficiario['IN_Acepta_Uso_Imagen'])
                    this.acepta_uso_imagen = {text: item.text, value: item.value};

                if(item.value == this.beneficiario['IN_Acepta_Uso_Obras'])
                    this.acepta_uso_obras = {text: item.text, value: item.value};

                if(item.value == this.beneficiario['IN_Acepta_Uso_Datos'])
                    this.acepta_uso_datos = {text: item.text, value: item.value};
                });
            },
            guardarDatosBasicosBeneficiario() {
                // Validación de campos obligatorios
                var msg = "";
                if(this.id_tipo_documento === null)
                    msg += "Tipo de Documento<br>";
                
                if(this.primer_apellido == "")
                    msg += "Primer Apellido<br>";

                if(this.primer_nombre == "")
                    msg += "Primer Nombre<br>";

                if(this.acepta_uso_imagen === null)
                    msg += "Acepta Uso de Imagen<br>";

                if(this.acepta_uso_obras === null)
                    msg += "Acepta Uso de Obras<br>";

                if(this.acepta_uso_datos === null)
                    msg += "Acepta Uso de Datos<br>";

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
                axios
                    .post("/sif/framework/administracion/beneficiarios/saveBeneficiario", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_tipo_documento": this.id_tipo_documento.value,
                    "acepta_uso_imagen": this.acepta_uso_imagen.value,
                    "acepta_uso_obras": this.acepta_uso_obras.value,
                    "acepta_uso_datos": this.acepta_uso_datos.value,
                    "numero_documento": this.numero_documento,
                    "old_numero_documento": this.beneficiario['IN_numero_identificacion'],
                    "fecha_nacimiento": this.fecha_nacimiento,
                    "primer_apellido": this.primer_apellido,
                    "segundo_apellido": this.segundo_apellido,
                    "primer_nombre": this.primer_nombre,
                    "segundo_nombre": this.segundo_nombre,
                    "direccion": this.direccion,
                    "telefono": this.telefono,
                    "celular": this.celular,
                    "correo": this.correo,
                    "id": this.beneficiario.id,
                    "id_usuario": this.id_persona,
                })
				.then(response => {
                    if(response.data === true) {
                        Swal.fire(
                            'Información Actualizada',
                            "Se han actualizado los datos básicos del Beneficiario",
                            'info'
                        );
                    } else {
                        Swal.fire(
                            'Atención!',
                            "No se pudo almacenar la información",
                            'error'
                        );
                    }
				})
				.catch(error => {
					console.log("No fue posible almacenar la información");
				});
			},
            guardarDatosAdicionalesBeneficiario(id_beneficiario, anio, id_persona) {
				var listas = [
                    {'valor':"TX_Barrio"},
                    {'valor':"FK_Localidad"},
                    {'valor':"TELEFONO_ACUDIENTE"},
                    {'valor':"IDENTIFICACION_ACUDIENTE"},
                    {'valor':"NOMBRE_ACUDIENTE"},
                    {'valor':"FK_grado"},
                    {'valor':"jornada"},
                    {'valor':"FK_colegio"},
                    {'valor':"FK_clan"},
                    {'valor':"TX_Enfermedades"},
                    {'valor':"FK_RH"},
                    {'valor':"FK_Eps"},
                    {'valor':"TX_Tipo_Afiliacion"},
                    {'valor':"FK_tipo_discapacidad"},
                    {'valor':"IN_estrato"},
                    {'valor':"FK_tipo_poblacion_victima"},
                    {'valor':"TX_etnia"},
                    {'valor':"FK_Grupo_Poblacional"},
                    {'valor':"TX_observaciones"},
                ];
                var SinValidar = true;
                listas.forEach((it) => {
                    if(this.AdicionalActual[it.valor] !== undefined && this.AdicionalActual[it.valor] !== "") {
                        SinValidar = false;
                    }
                });
                
                if(SinValidar) {
                    Swal.fire("Error", "Debe seleccionar por lo menos un campo para almacenar la información", "error");
                    return false;
                }
                // Validación de campos obligatorios
                var msg = "";
                if(this.AdicionalActual['FK_clan'] === null || this.AdicionalActual['FK_clan'] === undefined)
                    msg += "Crea<br>";

                if(this.AdicionalActual['FK_colegio'] === null || this.AdicionalActual['FK_colegio'] === undefined)
                    msg += "Colegio<br>";
                
                if(this.AdicionalActual['FK_Localidad'] === null || this.AdicionalActual['FK_Localidad'] === undefined)
                    msg += "Localidad<br>";

                if(msg != "") {
                    Swal.fire(
                        'Atención!',
                        "Los siguentes campos son de carácter obligatorio: <br>" + msg,
                        'error'
                    );
                    return false;
                }
                
                Swal.fire({
                    title: "Guardando la información",
                    text: "Espere un poco por favor",
                    imageUrl: "../public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    backdrop: `rgba(0,0,123,0.4)`
                });
                axios
                .post("/sif/framework/administracion/beneficiarios/saveBeneficiarioAdicionales", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "datosAdicionales": this.AdicionalActual,
                    "anio": anio,
                    "id": id_beneficiario,
                    "id_persona": id_persona,
                })
				.then(response => {
                    this.getAniosDetalle(id_beneficiario);
                    Swal.fire(
                        'Información Actualizada',
                        "Se han Actualizado los datos básicos del Beneficiario",
                        'info'
                    );
                    $('#tabDatos li:first-child a').tab('show');
				})
				.catch(error => {
					console.log("No fue posible almacenar la información");
				});
			},
            getAniosDetalle(id_beneficiario) {
                this.options_anio_detalle = [];
                this.anio_detalle = "";
                this.infoDetallada = false;
                axios
                    .post("/sif/framework/administracion/beneficiarios/getAniosAdicionales", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Estudiante: id_beneficiario
                })
				.then(response => {
                    response.data.forEach((item) => {
						this.options_anio_detalle.push({text: item.anio, value: item.anio});
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información Años Datos Adicionales");
				});
            },
            getAniosDocumentos(id_beneficiario) {
                this.options_anio_archivos = [];
                this.anio_archivos = "";
                this.infoDocumentos = false;
                axios
                    .post("/sif/framework/administracion/beneficiarios/getAniosDocumentos", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Estudiante: id_beneficiario
                })
				.then(response => {
                    response.data.forEach((item) => {
						this.options_anio_archivos.push({text: item.anio, value: item.anio});
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información Años Datos Adicionales");
				});
            },
            getInfoTipoDocumento(){
				axios
                    .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: this.FK_tipo_identificacion
                })
				.then(response => {
                    this.lista_tipos_documento = response.data;
                    this.lista_tipos_documento.forEach((item) => {
						if(item.value == this.beneficiario['CH_Tipo_Identificacion'])
                            this.id_tipo_documento = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Documento");
				});
            },
            getInfoSelectorAdicional(Id_Parametro, arreglo, comparar){
				axios
                    .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: Id_Parametro
                })
				.then(response => {
                    response.data.forEach((item) => {
						if(item.value == this.AdicionalActual[comparar])
                            this.AdicionalActual[comparar] = {text: item.text, value: item.value};
					});
                    this[arreglo] = response.data;
                })
				.catch(error => {
					console.log("No se puede cargar la información Tipos de Documento");
				});
            },
            getInfoCrea() {
                axios
                    .post("/sif/framework/options/getCentrosCrea", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
				.then(response => {
                    this.lista_crea = response.data;
                    this.lista_crea.forEach((item) => {
						if(item.value == this.AdicionalActual.FK_clan)
                            this.AdicionalActual.FK_clan = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información Centros Crea");
				});       
            },
            getInfoColegios() {
                axios
                    .post("/sif/framework/administracion/beneficiarios/getInfoColegios", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
				.then(response => {
                    this.lista_colegios = response.data;
                    this.lista_colegios.forEach((item) => {
						if(item.value == this.AdicionalActual.FK_colegio)
                            this.AdicionalActual.FK_colegio = {text: item.text, value: item.value};
					});
				})
				.catch(error => {
					console.log("No se puede cargar la información Colegios");
				});       
            },
            getFormDatosAdicionales(id_beneficiario, anio){
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
				.post("/sif/framework/administracion/beneficiarios/getInfoAdicionales", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_estudiante": id_beneficiario,
                    "anio": anio,
				})
				.then(response => {
                    this.AdicionalActual = response.data;
                    var listas = [
                        {'i': 9, 'valor':"lista_tipo_poblacion_victima", 'comparar': "FK_tipo_poblacion_victima"},
                        {'i': 10, 'valor':"lista_tipo_discapacidad", 'comparar': "FK_tipo_discapacidad"},
                        {'i': 11, 'valor':"lista_jornada", 'comparar': "jornada"},
                        {'i': 12, 'valor':"lista_grados", 'comparar': "FK_grado"},
                        {'i': 14, 'valor':"lista_grupo_poblacional", 'comparar': "FK_Grupo_Poblacional"},
                        {'i': 15, 'valor':"lista_grupo_sanguineo", 'comparar': "FK_RH"},
                        {'i': 16, 'valor':"lista_eps", 'comparar': "FK_Eps"},
                        {'i': 19, 'valor':"lista_localidad", 'comparar': "FK_Localidad"},
                        {'i': 33, 'valor':"lista_etnia", 'comparar': "TX_etnia"},
                        {'i': 53, 'valor':"lista_estrato", 'comparar': "IN_estrato"},
                        {'i': 70, 'valor':"lista_tipo_afiliacion", 'comparar': "TX_Tipo_Afiliacion"},
                    ];
                    listas.forEach((value) => {
                        this.getInfoSelectorAdicional(value.i, value.valor, value.comparar);
                    });
                    this.getInfoCrea();
                    this.getInfoColegios();
                    this.formAdicionales = true;
                    Swal.close();
				})
				.catch(error => {
					Swal.fire("Error", "No se puede cargar la información, por favor inténtelo nuevamente", "error");
				});
			},
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>