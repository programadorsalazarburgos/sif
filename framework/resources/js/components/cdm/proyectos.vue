<template>
    <div class="row">
        <!-- /.col-md-12 -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-muted">
                    <h2 class="m-0">
                        Proyectos - Subdirección de Formación Artística
                    </h2>
                    <h5>Administración de Proyectos e Indicadores</h5>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="margin-bottom:0px !important">
                        <li class="nav-item" role="presentation">
                          <a class="nav-link active" id="pills-proyectos-tab" data-toggle="pill" href="#pills-proyectos" role="tab" aria-controls="pills-proyectos" aria-selected="true">Proyectos</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="pills-indicadores-tab" data-toggle="pill" href="#pills-indicadores" role="tab" aria-controls="pills-indicadores" aria-selected="false">Indicadores</a>
                        </li>
                        <li class="nav-item" role="presentation">
                          <a class="nav-link" id="pills-avances-tab" data-toggle="pill" href="#pills-avances" role="tab" aria-controls="pills-avances" aria-selected="false">Avances</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-proyectos" role="tabpanel" aria-labelledby="pills-proyectos-tab">
                                <div class="row form-group justify-content-center">
					            	<div class="col-sm-10">
					            		<table id="table_proyectos" name="table_proyectos" class="table table-bordered table-hover display nowrap" style="width:100%">
					            			<thead>
					            				<th width="20%">NOMBRE DEL PROYECTO</th>
                                                <th width="60%">DESCRIPCIÓN</th>
                                                <th width="20%">OPCIONES</th>
					            			</thead>
					            			<tbody>
                                                <tr v-for="(proyecto,i) in proyectos" :key="i">
                                                    <td>{{ proyecto.nombre }}</td>
                                                    <td>{{ proyecto.descripcion }}</td>
                                                    <td>
                                                        <button class="btn btn-default" @click="editarProyecto()" v-bind:data-index=i>
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" v-bind:data-index=i>
                                                                <path v-bind:data-index=i fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                                            </svg>
                                                        </button>
                                                        <button class="btn btn-default" @click="eliminarProyecto()" v-bind:data-index=i>
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg" v-bind:data-index=i>
                                                                <path v-bind:data-index=i d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path v-bind:data-index=i fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
					            			</tbody>
					            		</table>
					            	</div>
					            	<br>
					            	<br>
					            </div>
                            <form>
                                <div class="form-group row justify-content-center">
                                    <label for="tx_nombre_proyecto" class="col-sm-2 col-form-label text-right">NOMBRE</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" id="tx_nombre_proyecto" v-model.trim="$v.form_proyecto.nombre.$model" placeholder="Indique un nombre" :class="status($v.form_proyecto.nombre)">
                                        <div class="error" v-if="!$v.form_proyecto.nombre.required">Campo requerido</div>
                                        <div class="error" v-if="!$v.form_proyecto.nombre.minLength">Debe tener al menos {{$v.form_proyecto.nombre.$params.minLength.min}} carácteres.</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-5">
                                        <textarea rows="3" class="form-control" id="tx_descripcion_proyecto" v-model="$v.form_proyecto.descripcion.$model" placeholder="Descripción del proyecto" :class="status($v.form_proyecto.descripcion)"></textarea>
                                        <div class="error" v-if="!$v.form_proyecto.descripcion.required">Campo requerido</div>
                                        <div class="error" v-if="!$v.form_proyecto.descripcion.minLength">Debe tener al menos {{$v.form_proyecto.descripcion.$params.minLength.min}} carácteres.</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <input v-if="seen_proyecto" type="button" class="btn btn-primary" @click="guardarProyecto" value="CREAR">
                                    <input v-if="!seen_proyecto" type="button" class="btn btn-info" @click="actualizarProyecto" value="ACTUALIZAR">
                                    <input @click="resetFormProyecto" type="button" class="btn btn-danger" value="CANCELAR">
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-indicadores" role="tabpanel" aria-labelledby="pills-indicadores-tab">
                            <form>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_proyecto" class="col-sm-1 col-form-label text-right">PROYECTO</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_indicador.proyecto.$model" :options="proyectos" label="nombre" track-by="id" id="sl_proyecto" name="sl_proyecto" @input="getIndicadores()" :class="status($v.form_indicador.proyecto)"></multiselect>
                                        <div class="error" v-if="!$v.form_indicador.proyecto.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="tx_nombre_indicador" class="col-sm-1 col-form-label text-right">NOMBRE</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="tx_nombre_indicador" v-model.trim="$v.form_indicador.nombre.$model" placeholder="Nombre del indicador" :class="status($v.form_indicador.nombre)">
                                        <div class="error" v-if="!$v.form_indicador.nombre.required">Campo requerido</div>
                                        <div class="error" v-if="!$v.form_indicador.nombre.minLength">Debe tener al menos {{$v.form_indicador.nombre.$params.minLength.min}} carácteres.</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="tx_magnitud_indicador" class="col-sm-1 col-form-label text-right">MAGNITUD</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="tx_magnitud_indicador" v-model.trim="$v.form_indicador.magnitud.$model" placeholder="Indique una cifra" :class="status($v.form_indicador.magnitud)">
                                        <div class="error" v-if="!$v.form_indicador.magnitud.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_unidad" class="col-sm-1 col-form-label text-right">UNIDAD</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_indicador.unidad.$model" :options="unidades" label="text" track-by="value" id="sl_unidad" name="sl_unidad" :class="status($v.form_indicador.unidad)"></multiselect>
                                        <div class="error" v-if="!$v.form_indicador.unidad.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_tipo_avance" class="col-sm-1 col-form-label text-right">TIPO AVANCE</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_indicador.tipo_avance.$model" :options="tipo_avance" label="text" track-by="value" id="sl_tipo_avance" name="sl_tipo_avance" :class="status($v.form_indicador.tipo_avance)"></multiselect>
                                        <div class="error" v-if="!$v.form_indicador.tipo_avance.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_tipo_grafico" class="col-sm-1 col-form-label text-right">GRÁFICO</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_indicador.grafico.$model" :options="graficos" label="text" track-by="value" id="sl_grafico" name="sl_grafico" :class="status($v.form_indicador.grafico)"></multiselect>
                                        <div class="error" v-if="!$v.form_indicador.grafico.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-sm-5">
                                        <textarea rows="3" class="form-control" id="tx_descripcion_indicador" v-model="$v.form_indicador.descripcion.$model" placeholder="Descripción del indicador" :class="status($v.form_indicador.descripcion)"></textarea>
                                        <div class="error" v-if="!$v.form_indicador.descripcion.required">Campo requerido</div>
                                        <div class="error" v-if="!$v.form_indicador.descripcion.minLength">Debe tener al menos {{$v.form_indicador.descripcion.$params.minLength.min}} carácteres.</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <input v-if="seen_indicador" type="button" class="btn btn-primary" @click="guardarIndicador" value="CREAR">
                                    <input v-if="!seen_indicador" type="button" class="btn btn-info" @click="actualizarIndicador" value="ACTUALIZAR">
                                    <input @click="resetFormIndicador" type="button" class="btn btn-danger" value="CANCELAR">
                                </div>
                            </form>
                            <div class="row form-group justify-content-center">
					            	<div class="col-sm-10">
					            		<table id="table_indicadores" name="table_indicadores" class="table table-bordered table-hover display nowrap" style="width:100%">
					            			<thead>
					            				<th width="20%">PROYECTO</th>
                                                <th width="20%">INDICADOR</th>
                                                <th width="60%">DESCRIPCIÓN</th>
                                                <th width="60%">MAGNITUD</th>
                                                <th width="60%">UNIDAD</th>
                                                <th width="60%">TIPO AVANCE</th>
                                                <th width="60%">GRÁFICO</th>
                                                <th width="60%">OPCIONES</th>
					            			</thead>
					            			<tbody>
                                                <tr v-for="(indicador,i) in indicadores" :key="i">
                                                    <td>{{ indicador.nombre_proyecto }}</td>
                                                    <td>{{ indicador.VC_titulo }}</td>
                                                    <td>{{ indicador.TX_descripcion }}</td>
                                                    <td>{{ indicador.IN_magnitud }}</td>
                                                    <td>{{ indicador.nombre_unidad }}</td>
                                                    <td>{{ indicador.VC_Tipo_Avance }}</td>
                                                    <td>{{ indicador.VC_tipo_grafico }}</td>
                                                    <td>
                                                        <button title="Editar" class="btn btn-default" @click="editarIndicador()" v-bind:data-index=i>
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pen-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg" v-bind:data-index=i>
                                                                <path v-bind:data-index=i fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                                            </svg>
                                                        </button>
                                                        <button title="Eliminar" class="btn btn-default" @click="eliminarIndicador()" v-bind:data-index=i>
                                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg" v-bind:data-index=i>
                                                                <path v-bind:data-index=i d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                <path v-bind:data-index=i fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                            </svg>
                                                        </button>
                                                        <button v-b-modal.modal_avances_indicador title="Avances" class="btn btn-default" @click="getAvancesIndicador()" v-bind:data-index=i>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16" v-bind:data-index=i>
                                                                <path v-bind:data-index=i d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
					            			</tbody>
					            		</table>
					            	</div>
					            	<br>
					            	<br>
					            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-avances" role="tabpanel" aria-labelledby="pills-avances-tab">
                            <form>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_proyecto_avance" class="col-sm-1 col-form-label text-right">PROYECTO</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_indicador.proyecto.$model" :options="proyectos" label="nombre" track-by="id" id="sl_proyecto_avance" name="sl_proyecto_avance" @input="getIndicadores()" :class="status($v.form_indicador.proyecto)"></multiselect>
                                        <div class="error" v-if="!$v.form_indicador.proyecto.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_indicador_avance" class="col-sm-1 col-form-label text-right">INDICADOR</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_avance_indicador.indicador.$model" :options="indicadores" label="VC_titulo" track-by="PK_id_centro_monitoreo" id="sl_indicador_avance" name="sl_indicador_avance" :class="status($v.form_avance_indicador.indicador)"></multiselect>
                                        <div class="error" v-if="!$v.form_avance_indicador.indicador.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_year_avance" class="col-sm-1 col-form-label text-right">AÑO</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_avance_indicador.year.$model" :options="years" label="text" track-by="value" id="sl_year_avance" name="sl_year_avance" :class="status($v.form_avance_indicador.year)"></multiselect>
                                        <div class="error" v-if="!$v.form_avance_indicador.year.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="sl_mes_avance" class="col-sm-1 col-form-label text-right">MES</label>
                                    <div class="col-sm-3">
                                        <multiselect v-model.trim="$v.form_avance_indicador.mes.$model" :options="meses" label="text" track-by="value" id="sl_mes_avance" name="sl_mes_avance" :class="status($v.form_avance_indicador.indicador)"></multiselect>
                                        <div class="error" v-if="!$v.form_avance_indicador.mes.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label for="tx_valor_avance" class="col-sm-1 col-form-label text-right">VALOR</label>
                                    <div class="col-sm-3">
                                        <input class="form-control" id="tx_valor_avance" v-model.trim="$v.form_avance_indicador.valor.$model" placeholder="Indique una cifra" :class="status($v.form_avance_indicador.valor)">
                                        <div class="error" v-if="!$v.form_avance_indicador.valor.required">Campo requerido</div>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <input v-if="seen_avance" type="button" class="btn btn-primary" @click="guardarAvanceIndicador" value="GUARDAR">
                                    <input v-if="!seen_avance" type="button" class="btn btn-info" @click="actualizarAvanceIndicador" value="ACTUALIZAR">
                                    <input @click="resetFormAvance" type="button" class="btn btn-danger" value="CANCELAR">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col-md-6 -->
        <div>

  <b-modal id="modal_avances_indicador"  v-if="modalAvancesShow" centered size="xl" title="AVANCES INDICADOR" hide-footer>
    <h4 class="my-8">{{ this.datos_modal.nombre }}</h4>
    <p class="my-8">{{ this.datos_modal.descripcion }}</p>
    <div class="row form-group justify-content-center">
		<div class="col-sm-10">
			<table id="table_avances" name="table_avances" class="table table-bordered table-hover display nowrap" style="width:100%">
				<thead>
					<th>AÑO</th>
                    <th>MES</th>
                    <th>VALOR</th>
                    <th>OPCIONES</th>
				</thead>
				<tbody>
                    <tr v-for="(avance,i) in avances" :key="i">
                        <td>{{ avance.year }}</td>
                        <td>{{ avance.mes }}</td>
                        <td>{{ avance.valor }}</td>
                        <td>
                            <button title="Eliminar" class="btn btn-default" @click="eliminarAvance()" v-bind:data-index=i>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg" v-bind:data-index=i>
                                    <path v-bind:data-index=i d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path v-bind:data-index=i fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>
		<br>
		<br>
	</div>
  </b-modal>
</div>
    </div>
    <!-- /.row -->
</template>

<script>
import Multiselect from "vue-multiselect";
import DataTables from "datatables.net";
import Sweetalert2 from "sweetalert2";
import Vuelidate from 'vuelidate';
import { BButton, BModal, VBModal } from "bootstrap-vue";   
Vue.use(Vuelidate);
import { required, minLength, between } from 'vuelidate/lib/validators';

export default {
    components: {
        Multiselect,
        BButton,
        BModal
    },
    directives: { 
        'b-modal': VBModal 
    },
    data() {
        return {
            proyectos:[],
            unidades:[],
            tipo_avance:[{'text':'SUMATORIA', 'value':'SUMATORIA'}, {'text':'ACUMULADO', 'value':'ACUMULADO'}],
            id_proyecto:null,
            form_proyecto:{
                nombre:'',
                descripcion:''
            },
            seen_proyecto:true,
            indicadores:[],
            id_indicador:null,
            form_indicador:{
                proyecto:null,
                nombre:null,
                descripcion:null,
                magnitud:0,
                unidad:null,
                tipo_avance:null,
                grafico:null
            },
            datos_modal:{
                nombre:'',
                descripcion:''
            },
            sl_indicador:null,
            seen_indicador:true,
            form_avance_indicador:{
                indicador:null,
                year:null,
                mes:null,
                valor:0
            },
            seen_avance:true,
            years:[],
            meses:[],
            graficos:[{'text':'COLUMNA VERTICAL', 'value':'column-vertical'}, {'text':'COLUMNA HORIZONTAL', 'value':'column-horizontal'}, {'text':'LINEAL', 'value': 'lineal'}, {'text':'PIE', 'value': 'pie'}],
            avances:[],
            modalAvancesShow:true
        };
    },
    validations: {
        form_proyecto: {
            nombre: {
                required,
                minLength: minLength(4)
            },
            descripcion: {
                required,
                minLength: minLength(4)
            }
        },
        form_indicador:{
            proyecto:{
                required
            },
            nombre: {
                required,
                minLength: minLength(4)
            },
            descripcion: {
                required,
                minLength: minLength(4)
            },
            magnitud:{
                required
            },
            unidad:{
                required
            },
            tipo_avance:{
                required
            },
            grafico:{
                required
            },
        },
        form_avance_indicador:{
            indicador: {
                required
            },
            year: {
                required
            },
            mes: {
                required
            },
            valor:{
                required
            }
        }
    },
    mounted() {
        this.getProyectos();
        this.getUnidades();
        this.getYears();
        this.getMeses();
    },
    methods: {
        getProyectos(){
            axios
                .post("/sif/framework/administracion/proyectos/getAll", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
                .then(response => {
                    this.proyectos = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getUnidades(){
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 54
                })
                .then(response => {
                    this.unidades = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getYears(){
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 7
                })
                .then(response => {
                    this.years = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getMeses(){
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 8
                })
                .then(response => {
                    this.meses = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getIndicadores(){
            axios
                .post("/sif/framework/administracion/proyectos/indicadores/getAll", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "seccion":this.form_indicador.proyecto.id
                })
                .then(response => {
                    this.indicadores = response.data;
                    this.form_avance_indicador.indicador=null;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        guardarProyecto(){
            if(this.$v.form_proyecto.$invalid){
                Swal.fire(
                    'Ajuste los campos',
                    'Diligencie correctamente los campos<br> para poder crear el proyecto.',
                    'warning'
                );
            }
            else{
                Swal.fire({
                    title: '¿Crear el proyecto?',
                    html: 'Nombre: '+this.form_proyecto.nombre+'<br> Descripción: '+this.form_proyecto.descripcion,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, crear',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/save", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                "nombre": this.form_proyecto.nombre,
                                "descripcion": this.form_proyecto.descripcion
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Creado!',
                                        'El proyecto '+this.form_proyecto.nombre+' ha sido creado.',
                                        'success'
                                    );
                                    this.getProyectos();
                                    this.resetFormProyecto();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
            }          
        },
        actualizarProyecto(){
            if(this.$v.form_proyecto.$invalid){
                Swal.fire(
                    'Ajuste los campos',
                    'Diligencie correctamente los campos<br> para poder crear el proyecto.',
                    'warning'
                );
            }
            else{
                Swal.fire({
                    title: '¿Actualizar el proyecto?',
                    html: 'Nombre: '+this.form_proyecto.nombre+'<br> Descripción: '+this.form_proyecto.descripcion,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/update", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                id: this.id_proyecto,
                                nombre:this.form_proyecto.nombre,
                                descripcion:this.form_proyecto.descripcion
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Actualizado!',
                                        'El proyecto ha sido actualizado.',
                                        'success'
                                    );
                                    this.getProyectos();
                                    this.resetFormProyecto();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
            }
        },
        editarProyecto(){
            this.seen_proyecto = false;
            this.form_proyecto.nombre = this.proyectos[event.target.getAttribute("data-index")].nombre;
            this.form_proyecto.descripcion = this.proyectos[event.target.getAttribute("data-index")].descripcion;
            this.id_proyecto = this.proyectos[event.target.getAttribute("data-index")].id;
        },
        eliminarProyecto(){
            this.id_proyecto = this.proyectos[event.target.getAttribute("data-index")].id;
            Swal.fire({
                    title: '¿Eliminar el proyecto?',
                    html: 'Nombre: '+this.proyectos[event.target.getAttribute("data-index")].nombre+'<br> Descripción: '+this.proyectos[event.target.getAttribute("data-index")].descripcion,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/delete", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                id: this.id_proyecto
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'El proyecto fue eliminado.',
                                        'success'
                                    );
                                    this.getProyectos();
                                }
                                if(response.data == 0){
                                    Swal.fire(
                                        '',
                                        'El proyecto no pudo ser eliminado porque tiene indicadores. Debe eliminar primero los indicadores para eliminar el proyecto.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
        },
        guardarIndicador(){
            if(this.$v.form_indicador.$invalid){
                Swal.fire(
                    'Ajuste los campos',
                    'Diligencie correctamente los campos<br> para poder crear el indicador.',
                    'warning'
                );
            }
            else{
                Swal.fire({
                    title: '¿Crear el Indicador?',
                    html: 'Proyecto: '+this.form_indicador.proyecto.nombre+'<br> Nombre: '+this.form_indicador.nombre+'<br> Magnitud: '+this.form_indicador.magnitud+'<br> Unidad: '+this.form_indicador.unidad.text+'<br> Gráfico: '+this.form_indicador.grafico.text+'<br> Descripción: '+this.form_indicador.descripcion+'<br> ',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, crear',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/indicadores/save", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                "proyecto": this.form_indicador.proyecto.id,
                                "nombre": this.form_indicador.nombre,
                                "magnitud": this.form_indicador.magnitud,
                                "unidad": this.form_indicador.unidad.value,
                                "tipo_avance": this.form_indicador.tipo_avance.value,
                                "grafico": this.form_indicador.grafico.value,
                                "descripcion": this.form_indicador.descripcion
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Creado!',
                                        'El indicador '+this.form_indicador.nombre+' ha sido creado.',
                                        'success'
                                    );
                                    this.getIndicadores();
                                    this.resetFormIndicador();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
            }    
        },
        editarIndicador(){
            this.seen_indicador = false;
            this.form_indicador.nombre = this.indicadores[event.target.getAttribute("data-index")].VC_titulo;
            this.form_indicador.magnitud = this.indicadores[event.target.getAttribute("data-index")].IN_magnitud;
            var unidad = {
                text: this.indicadores[event.target.getAttribute("data-index")].nombre_unidad,
                value: this.indicadores[event.target.getAttribute("data-index")].FK_unidad
            }
            this.form_indicador.unidad = unidad;
            var tipo_avance = {
                text: this.indicadores[event.target.getAttribute("data-index")].VC_Tipo_Avance,
                value: this.indicadores[event.target.getAttribute("data-index")].VC_Tipo_Avance
            }
            this.form_indicador.tipo_avance = tipo_avance;
            
            // var tipo_grafico = {
            //     text: this.indicadores[event.target.getAttribute("data-index")].VC_tipo_grafico,
            //     value: this.indicadores[event.target.getAttribute("data-index")].VC_tipo_grafico
            // }
            // this.form_indicador.grafico = tipo_grafico;

            this.form_indicador.descripcion = this.indicadores[event.target.getAttribute("data-index")].TX_descripcion;
            this.id_indicador = this.indicadores[event.target.getAttribute("data-index")].PK_id_centro_monitoreo;
        },
        actualizarIndicador(){
            if(this.$v.form_indicador.$invalid){
                Swal.fire(
                    'Ajuste los campos',
                    'Diligencie correctamente los campos<br> para poder crear el indicador.',
                    'warning'
                );
            }
            else{
                Swal.fire({
                    title: '¿Actualizar el indicador?',
                    html: 'Nombre: '+this.form_indicador.nombre+'<br> Descripción: '+this.form_indicador.descripcion,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, actualizar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/indicadores/update", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                "id": this.id_indicador,
                                "nombre":this.form_indicador.nombre,
                                "magnitud":this.form_indicador.magnitud,
                                "unidad":this.form_indicador.unidad.value,
                                "tipo_avance":this.form_indicador.tipo_avance.value,
                                "grafico":this.form_indicador.grafico.value,
                                "descripcion":this.form_indicador.descripcion
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Actualizado!',
                                        'El indicador ha sido actualizado.',
                                        'success'
                                    );
                                    this.getIndicadores();
                                    this.resetFormIndicador();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
            }
        },
        eliminarIndicador(){
            this.id_indicador = this.indicadores[event.target.getAttribute("data-index")].PK_id_centro_monitoreo;
            Swal.fire({
                    title: '¿Eliminar el indicador?',
                    html: 'Nombre: '+this.indicadores[event.target.getAttribute("data-index")].VC_titulo+'<br> Descripción: '+this.indicadores[event.target.getAttribute("data-index")].TX_descripcion,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/indicadores/delete", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                id: this.id_indicador
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'El indicador fue eliminado.',
                                        'success'
                                    );
                                    this.getIndicadores();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
        },
        getAvancesIndicador(){
            this.avances = [];
            this.modalAvancesShow = true;
            this.id_indicador = this.indicadores[event.target.getAttribute("data-index")].PK_id_centro_monitoreo;
            this.datos_modal.nombre = this.indicadores[event.target.getAttribute("data-index")].VC_titulo;
            this.datos_modal.descripcion = this.indicadores[event.target.getAttribute("data-index")].TX_descripcion;

            axios
                .post("/sif/framework/administracion/proyectos/indicadores/getAllAvances", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "id_indicador":this.id_indicador
                })
                .then(response => {
                    let avances_indicador = JSON.parse(response.data['TX_Avance']);
                    var avance = {};
                    for (var key in avances_indicador) {
                        if (avances_indicador.hasOwnProperty(key)) {
                            for (var second_key in avances_indicador[key]) {
                                if (avances_indicador[key].hasOwnProperty(second_key)) {
                                    avance.year = key;
                                    avance.mes = second_key;
                                    avance.valor = avances_indicador[key][second_key];
                                }
                                //alert(avance.year+'-'+avance.mes+'-'+avance.valor);
                                this.avances.push(avance);
                                avance = {};
                            }
                        }
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        eliminarAvance(){
            var id_indicador = this.id_indicador;
            var year = this.avances[event.target.getAttribute("data-index")].year;
            var mes = this.avances[event.target.getAttribute("data-index")].mes;
            var valor = this.avances[event.target.getAttribute("data-index")].valor;
            Swal.fire({
                    title: '¿Eliminar el Avance?',
                    html: 'Año: '+year+'<br> Mes: '+mes+'<br> Valor: '+valor,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/indicadores/deleteAvance", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                id_indicador: id_indicador,
                                year: year,
                                mes: mes
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'El Avance fue eliminado.',
                                        'success'
                                    );
                                    this.modalAvancesShow = false;
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
        },
        guardarAvanceIndicador(){
            if(this.$v.form_avance_indicador.$invalid){
                Swal.fire(
                    'Ajuste los campos',
                    'Diligencie correctamente los campos<br> para poder guardar el avance.',
                    'warning'
                );
            }
            else{
                Swal.fire({
                    title: '¿Registrar el Avance?',
                    html: 'Proyecto: '+this.form_indicador.proyecto.nombre+'<br> Indicador: '+this.form_avance_indicador.indicador.VC_titulo+'<br> Año: '+this.form_avance_indicador.year.value+'<br> Mes: '+this.form_avance_indicador.mes.text+'<br> Valor: '+this.form_avance_indicador.valor+'<br> ',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, guardar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                  if (result.value) {
                        Swal.fire({
                          text: "Espere un poco por favor.",
                          imageUrl: "/sif/framework/public/images/cargando.gif",
                          imageWidth: 140,
                          imageHeight: 70,
                          showConfirmButton: false,
                          backdrop: `
                              rgba(0,0,123,0.4)
                          `,
                        });
                        axios
                            .post("/sif/framework/administracion/proyectos/indicadores/updateAvance", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                "id": this.form_avance_indicador.indicador.PK_id_centro_monitoreo,
                                "year": this.form_avance_indicador.year.value,
                                "mes": this.form_avance_indicador.mes.text,
                                "valor": this.form_avance_indicador.valor
                            })
                            .then(response => {
                                if(response.data == 1){
                                    Swal.fire(
                                        '¡Creado!',
                                        'El avance ha sido registrado.',
                                        'success'
                                    );
                                    this.getIndicadores();
                                    this.resetFormAvance();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                });
            }    
        },
        resetFormProyecto(){
            this.seen_proyecto = true;
            this.form_proyecto.nombre = "";
            this.form_proyecto.descripcion = "";
        },
        resetFormIndicador(){
            this.seen_indicador = true;
            this.form_indicador.nombre = "";
            this.form_indicador.magnitud = "0";
            this.form_indicador.unidad = null;
            this.form_indicador.tipo_avance = null;
            this.form_indicador.grafico = null;
            this.form_indicador.descripcion = "";
        },
        resetFormAvance(){
            this.seen_avance = true;
            this.form_indicador.proyecto = "";
            this.form_avance_indicador.indicador = "";
            this.form_avance_indicador.year = null;
            this.form_avance_indicador.mes = null;
            this.form_avance_indicador.valor = "0";
        },
        status(validation) {
    	    return {
      	        error: validation.$error,
                dirty: validation.$dirty
            }
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>