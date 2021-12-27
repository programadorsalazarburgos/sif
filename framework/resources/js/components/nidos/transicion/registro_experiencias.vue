<template>
  <div class="col-lg-8 offset-lg-2">
    <div class="form-row">
      <div class="form-group col-lg-12">
        <br />
        <h2>Registro de experiencias</h2>
      </div>
    </div>

    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-link active"
          id="nav-home-tab"
          data-toggle="tab"
          href="#nav-registro"
          role="tab"
          aria-controls="nav-modulos"
          aria-selected="true"
          >Registrar Experiencia</a
        >
        <a
          class="nav-link"
          id="nav-home-tab"
          data-toggle="tab"
          href="#nav-consulta"
          role="tab"
          aria-controls="nav-modulos"
          aria-selected="true"
          >Consultar Experiencias</a
        >
      </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
      <div
        class="tab-pane fade show active"
        id="nav-registro"
        role="tabpanel"
        aria-labelledby="nav-modulos-tab"
      >
        <br />
        <div class="card">
          <form @submit="guardarRegistroExperiencia">
            <div class="card-body">
              <br />
              <div class="form-row">
                <div class="form-group col-lg-3">Seleccionar Grupo:</div>
                <div class="form-group col-lg-9">
                  <multiselect
                    v-model="form.grupo"
                    label="text"
                    :options="options_grupos"
                    placeholder="Seleccione una opción"
                    :show-labels="false"
                    @input="cargarinfogrupo"
                    track-by="value"
                    required
                  ></multiselect>
                </div>
              </div>
              
              <div id="div_registro_asistencia" style="display: none">
              
                <table
                  id="tabla_grupos_dupla"
                  name="tabla_grupos_dupla"
                  class="
                    table table-striped table-bordered table-hover
                    display
                    nowrap
                  "
                  style="width: 100%"
                >
                  <thead>
                    <tr>
                      <th style="width: 35%">Fecha del Encuentro</th>
                      <th style="width: 30%" colspan="2">Horario</th>
                      <th style="width: 35%">Nombre de la experiencia</th>
                    </tr>
                  </thead>
                  <tr>
                    <td>
                      <div class="col-xs-12">
                        <div class="input-group date">
                          <input
                            v-model="form.fecha_experiencia"
                            class="form-control"
                            type="date"
                            style="
                              border-style: solid;
                              border-width: 2px;
                              border-color: #3c763d;
                            "
                            required
                          />
                        </div>
                      </div>
                    </td>
                    <td>
                      <input
                        v-model="form.hora_inicio"
                        type="time"
                        class="form-control"
                        style="
                          border-style: solid;
                          border-width: 2px;
                          border-color: #3c763d;
                        "
                        required
                      />
                    </td>
                    <td>
                      <input
                        v-model="form.hora_finalizacion"
                        type="time"
                        class="form-control"
                        style="
                          border-style: solid;
                          border-width: 2px;
                          border-color: #3c763d;
                        "
                        required
                      />
                    </td>
                    <td>
                      <input
                        v-model="form.nombre_experiencia"
                        type="text"
                        class="form-control"
                        style="
                          border-style: solid;
                          border-width: 2px;
                          border-color: #3c763d;
                        "
                        placeholder="Nombre Experiencia"
                        required
                      />
                    </td>
                  </tr>
                </table>
                <input
                  v-model="form.lugar"
                  type="hidden"
                  class="form-control"
                />   
            
           <label style="color:#FF0000"> Por favor asegurarse de diligenciar la modalidad de todos los beneficiarios.  </label>         
                <div class="modal-body">
                  <div class="form-row">
                    <div class="form-group col-lg-12">
                      <table
                        id="tabla_beneficiarios_grupo"
                        name="tabla_beneficiarios_grupo"
                        class="
                          table table-striped table-bordered table-hover
                          display
                          nowrap
                        "
                        style="width: 100%"
                      >
                        <thead>
                          <tr>
                            <th>IDENTIFICACIÓN</th>
                            <th>NOMBRE BENEFICIARIO</th>
                            <th>GENERO</th>
                            <th>F. Nacimiento</th>
                            <th>Asistencia</th>
                            <th>Modalidad</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(b, index) in form.beneficiarios">
                            <td>{{ b.identificacion }}</td>
                            <td>{{ b.beneficiario }}</td>
                            <td>{{ b.genero }}</td>
                            <td>{{ b.nacimiento }}</td>
                            <td><center>
                              <div class="custom-control custom-switch">
                                <input
                                  type="checkbox"
                                  class="custom-control-input"
                                  name="registrar"
                                  v-bind:data-index="index"
                                  v-bind:id="'asistencia-' + index"
                                  @change="asistencia"                                 
                                  
                                />
                                <label
                                  class="custom-control-label"
                                  v-bind:for="'asistencia-' + index"
                                ></label> 
                              </div></center>
                            </td>
                            <td>
                              <multiselect
                                v-model="b.modalidad"
                                label="text"
                                :options="options_modalidad"
                                placeholder="Seleccione"
                                :show-labels="false"
                                track-by="value"
                                required
                              ></multiselect>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :data-proceso="data_proceso"
                  >
                    Guardar Asistencia
                  </button>
                </div>

              </div>
            </div>
          </form>
        </div>
      </div>
      
       <div
        class="tab-pane fade show"
        id="nav-consulta"
        role="tabpanel"
        aria-labelledby="nav-modulos-tab"
      >
<br />
        <div class="card">
      <br />
              <div class="form-row">
                <div class="form-group col-lg-3">Seleccionar mes:</div>
                <div class="form-group col-lg-9">
                  <multiselect
                  v-model="mes"
                    label="text"
                    :options="options_mes"
                    placeholder="Seleccione una opción"
                    :show-labels="false"
                    @input="cargarasistenciames"
                    track-by="value"
                    required
                  ></multiselect>
                </div>
              </div>
  <div id="div_consultar_experiencias" style="display: none">
      <div class="form-row">        
              <div class="form-group col-lg-12">
                <table
                  id="tabla_grupos_dupla"
                  name="tabla_grupos_dupla"
                  class="
                    table table-striped table-bordered table-hover
                    display
                    nowrap
                  "
                  style="width: 100%"
                >
                  <thead>
                    <tr>
                      <th> ID</th>
                      <th>COLEGIO</th>
                      <th>GRUPO</th>
                      <th>NIVEL ESCOLARIDAD</th>
                      <th>NOMBRE EXPERIENCIA</th>
                      <th>FECHA</th>
                      <th>HORARIO</th>
                      <th>BENEFICIARIOS</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(e, index) in experiencias">
                      <td>{{ e.id }}</td>
                      <td>{{ e.lugar }}</td>
                      <td>{{ e.grupo }}</td>
                      <td>{{ e.nivel }}</td>
                      <td>{{ e.experiencia }}</td>
                      <td>{{ e.fecha }}</td>
                      <td>{{ e.horario }}</td>
                      <td><center>{{ e.asistencia }}</center></td>                      
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>    
       </div>
    </div>



    </div>
  </div>
</template>

<script>
require("jszip");
require("datatables.net-dt");
require("datatables.net-buttons-dt");
require("datatables.net-buttons/js/buttons.html5.js");
require("datatables.net-responsive-dt");

import Multiselect from "vue-multiselect";
import DataTables from "datatables.net";
import Sweetalert2 from "sweetalert2";
import { forEach } from "jszip";
import ToggleButton from "vue-js-toggle-button";

Vue.use(ToggleButton);

export default {
  components: { Multiselect },
  data() {
    return {
      form: {
        grupo: "",
        fecha_experiencia: "",
        hora_inicio: "",
        hora_finalizacion: "",
        nombre_experiencia: "",
        lugar: "",
        beneficiarios: [],
      },
      modalidad: "",
      data_proceso: "",
      iddupla: "",
      idlugar: "",
      options_grupos: [],
      options_modalidad: [],
      experiencias: [],
      options_mes: [],
      mes: "",
    };
  },
  mounted() {
    //document.ready
    this.getIdPersona();
    this.getMeses();
    
  },
  methods: {
    getIdPersona() {
      axios
        .post("/sif/framework/getIdPersona", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        })
        .then((response) => {
          this.id_persona = response.data;
          this.getGruposDuplaAsistencia();
          this.getCodigoArtistasDupla();
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
            "error"
          );
        });
    },

    getMeses(){
				axios
				.post("/sif/framework/options/getParametroDetalle", {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				FK_Id_Parametro: 8
				})
				.then(response => {					
						this.options_mes = response.data;					
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente", "error");
				});
	  },

    guardarRegistroExperiencia: function (e) {
      e.preventDefault();
      axios
        .post("/sif/framework/nidos/transicion/guardarRegistroExperiencia", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          form: JSON.stringify(this.form),
          personaid: this.id_persona,
          duplaid: this.iddupla,
        })
        .then((response) => {
          Swal.fire(
            "Éxito",
            "Se ha registrado correctamente el registro de experiencia",
            "success"
          );
          Object.keys(this.form).forEach((key) => {
            this.form[key] = "";
          });
          
          $("#div_registro_asistencia").hide("refresh");
          this.resetForm();
          this.getGruposDuplaAsistencia();
                     
          
        })
        .catch((error) => {
          Swal.fire("Error", "No se pudo guardar la información, asegurece que todos los campos esten diligenciados", "error");
          $("#div_registro_asistencia").hide("refresh");
          this.resetForm(); 
        });
    },

    getGruposDuplaAsistencia() {
      axios
        .post("/sif/framework/nidos/transicion/getGruposDuplaAsistencia", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          personaid: this.id_persona,
        })
        .then((response) => {
          this.options_grupos = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente",
            "error"
          );
        });
    },

    getCodigoArtistasDupla() {
      axios
        .post("/sif/framework/getCodigoArtistasDupla", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          personaid: this.id_persona,
        })
        .then((response) => {
          this.iddupla = response.data.IdDupla;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener la dupla de la persona, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
  

    cargarinfogrupo() {
      $("#div_registro_asistencia").show("refresh");
      this.getLugarAtencionGrupo();
      this.getBeneficiariosGrupo();
      this.getModalidadAtencion();
    },

    cargarasistenciames() {
      $("#div_consultar_experiencias").show("refresh");
      this.getExperienciasRegistradasDupla();
    },

    getModalidadAtencion() {
      axios
        .post("/sif/framework/options/getParametroDetalleNidos", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          FK_Id_Parametro: 93,
        })
        .then((response) => {
          this.options_modalidad = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado modalidad de atención, por favor inténtelo nuevamente",
            "error"
          );
        });
    },

    getLugarAtencionGrupo() {
      axios
        .post("/sif/framework/nidos/transicion/getLugarAtencionGrupo", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          id_grupo: this.form.grupo.value,
        })
        .then((response) => {
          this.form.lugar = response.data.fk_id_lugar_atencion;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente",
            "error"
          );
        });
    },

    getBeneficiariosGrupo() {
    this.form.beneficiarios = [];       
      axios      
        .post("/sif/framework/nidos/transicion/getBeneficiariosGrupo", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          id_grupo: this.form.grupo.value,
        })
        .then((response) => {
          response.data.forEach((value) => {             
            this.form.beneficiarios.push({
              id: value["IdBeneficiario"],
              identificacion: value["Identificacion"],
              beneficiario: value["Beneficiario"],
              genero: value["Genero"],
              nacimiento: value["Nacimiento"],
              asistencia: false,
              modalidad: "",
            });
          });
        })
        .catch(() => {
          Swal.fire(
            "Error",
            "No se pudo obtener los beneficiarios del grupo, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
    asistencia: function (e) {
      this.form.beneficiarios[e.currentTarget.getAttribute("data-index")][
        "asistencia"
      ] = e.currentTarget.checked;
    },


    
    resetForm(){
		this.form.grupo = null;
    this.form.fecha_experiencia = null;
    this.form.hora_inicio = null;
    this.form.hora_finalizacion = null;
    this.form.nombre_experiencia = null;
    this.form.lugar = null;

    },


    getExperienciasRegistradasDupla() {
      this.experiencias = [];
      axios
        .post("/sif/framework/nidos/transicion/getExperienciasRegistradasDupla", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          personaid: this.id_persona,
          mes: this.mes.value,
        })
        .then((response) => {
          response.data.forEach((value) => {
            this.experiencias.push({
              id: value["IdExperiencia"],
              lugar: value["Lugar"],
              grupo: value["Grupo"],
              nivel: value["Nivel"],
              experiencia: value["Experiencia"],
              fecha: value["Fecha"],
              horario: value["Horario"],
              asistencia: value["Asistencia"],
            });
          });
        })
        .catch(() => {
          Swal.fire(
            "Error",
            "No se pudo guardar la información, por favor inténtelo nuevamente",
            "error"
          );
        });
    },






  },
};
</script>