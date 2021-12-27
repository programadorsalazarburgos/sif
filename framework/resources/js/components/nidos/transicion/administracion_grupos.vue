<template>
  <div class="col-lg-8 offset-lg-2">
    <div class="form-row">
      <div class="form-group col-lg-12">
        <br />
        <h2>Administración Grupos - Dupla</h2>
      </div>
    </div>

    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-link active"
          id="nav-home-tab"
          data-toggle="tab"
          href="#nav-modulos"
          role="tab"
          aria-controls="nav-modulos"
          aria-selected="true"
          >Administración Grupos</a
        >
      </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
      <div
        class="tab-pane fade show active"
        id="nav-modulos"
        role="tabpanel"
        aria-labelledby="nav-modulos-tab"
      >
        <br />
        <div class="card">
          <div class="card-body">
            <div class="row bg-info">
              <label class="col-md-3">Codigo de Dupla:</label>
              <label class="col-md-9">{{ codigodupla }}</label>
            </div>
            <div class="row bg-info">
              <label class="col-md-3">Artistas Comunitarios:</label>
              <label class="col-md-9">{{ artistasdupla }}</label>
            </div>
            <br />
            <div class="form-row text-right">
              <div class="form-group col-lg-6 offset-lg-6">
                <button
                  class="btn btn-block btn-primary"
                  data-toggle="modal"
                  data-target="#modal-grupos"
                  @click="crearGrupo()"
                >
                  CREAR NUEVO GRUPO
                </button>
              </div>
            </div>
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
                      <th>LOCALIDAD</th>
                      <th>INSTITUCIÓN EDUCATIVA</th>
                      <th>NOMBRE DEL GRUPO</th>
                      <th>NIVEL ESCOLARIDAD</th>
                      <th># BENEFICIARIOS</th>
                      <th>AGREGAR</th>
                      <th>EDITAR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(g, index) in grupo">
                      <td>{{ g.localidad }}</td>
                      <td>{{ g.lugar }}</td>
                      <td>{{ g.grupo }}</td>
                      <td>{{ g.nivel }}</td>
                      <td>
                        <button
                          class="btn btn-block btn-success"
                          :data-index="index"
                          data-toggle="modal"
                          data-target="#modal-beneficiarios-grupo"
                          @click="getBeneficiariosGrupo"
                        >
                          {{ g.beneficiarios }}
                        </button>
                      </td>
                      <td>
                        <button
                          class="btn btn-block btn-primary"
                          :data-index="index"
                          data-toggle="modal"
                          data-target="#modal-agregar-beneficiario"
						              @click="cargaridgrupo"
                        >
                          <i class="fas fa-user-plus"></i>
                        </button>
                      </td>
                      <td>
                        <button
                          class="btn btn-block btn-warning"
                          :data-index="index"
                          data-toggle="modal"
                          data-target="#modal-editar-grupo"
                          @click="editargrupo"
                        >
                          <i class="fas fa-edit"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal nueva grupo 
    class="modal-dialog modal-lg"-->
    <div
      class="modal modal-wide fade"
      id="modal-grupos"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ modal_title }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit="procesargrupo">
            <div class="modal-body">
              <div class="form-group">
                <div class="row">
                  
                  <div class="col-md-12">
                   <span class="required">Localidad:</span>
                    <multiselect v-model="form.localidad" label="text" :options="options_localidad" @input="getLugaresTransicion" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-md-12">
                    <span class="required">Institución Educativa:</span>
                    <multiselect
                      v-model="form.institucion"
                      label="text"
                      :options="options_lugares"
                      placeholder="Seleccione una opción"
                      :show-labels="false"
                      track-by="value"
                      required
                    ></multiselect>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-md-12">
                    <span class="required">Nivel Escolaridad:</span>
                    <multiselect
                      v-model="form.nivel"
                      label="text"
                      :options="options_niveles"
                      placeholder="Seleccione una opción"
                      :show-labels="false"
                      track-by="value"
                      required
                    ></multiselect>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <span class="required">Nombre del Grupo:</span>
                    <input
                      v-model="form.grupo"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                      required
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <span class="required">Responsable del grupo:</span>
                    <input
                      v-model="form.responsable"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                      required
                    />
                  </div>
                </div>
                
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                ref="cerrarModalNuevagrupo"
              >
                Cerrar
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                :data-proceso="data_proceso"
              >
                Guardar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal editar información grupo -->
    <div
      class="modal modal-wide fade"
      id="modal-editar-grupo"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              {{ modal_title }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit="procesargrupo">
            <div class="modal-body">
              <div class="form-group">                
                <div class="row">                  
                  <div class="col-md-12">
                    <span class="required">Nivel Escolaridad:</span>
                    <multiselect
                      v-model="form.nivel"
                      label="text"
                      :options="options_niveles"
                      placeholder="Seleccione una opción"
                      :show-labels="false"
                      track-by="value"
                      required
                    ></multiselect>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <span class="required">Nombre del Grupo:</span>
                    <input
                      v-model="form.grupo"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                      required
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <span class="required">Responsable del grupo:</span>
                    <input
                      v-model="form.responsable"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                      required
                    />
                  </div>
                </div>
                
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                ref="cerrarModalEditargrupo"
              >
                Cerrar
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                :data-proceso="data_proceso"
              >
                Guardar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal REGISTRAR BENEFICIARIO -->
    <div
      class="modal fade"
      id="modal-agregar-beneficiario"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Agregar beneficiario al grupo
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit="guardarbeneficiario">
            <div class="modal-body">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-3"><br /></div>
                  <div class="col-md-6">
                   <span class="required">Número de documento:</span>
                    <input
                      v-model="formbeneficiario.identificacion"
                      class="form-control"
                      type="text"
                      @change="buscarbeneficiario"
                      required
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <span class="required">Primer Nombre:</span>
                    <input
                      v-model="formbeneficiario.primer_nombre"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                      required
                    />
                  </div>
                  <div class="col-md-6">
                    Segundo Nombre:
                    <input
                      v-model="formbeneficiario.segundo_nombre"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <span class="required">Primer Apellido:</span>
                    <input
                      v-model="formbeneficiario.primer_apellido"
                      class="form-control"
                      type="text"
                      style="text-transform: uppercase"
                      required
                    />
                  </div>
                  <div class="col-md-6">
                    Segundo Apellido:
                    <input
                      v-model="formbeneficiario.segundo_apellido"
                      class="form-control"
                      style="text-transform: uppercase"
                      type="text"
                    />
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <span class="required">Fecha de Nacimiento:</span>
                    <input
                      v-model="formbeneficiario.fecha_nacimiento"
                      class="form-control"
                      type="date"
                      required
                    />
                  </div>
                  <div class="col-md-6">
                    <span class="required">Genero:</span>                    
                    <multiselect
                      v-model="formbeneficiario.genero"
                      label="text"
                      :options="options_generos"
                      placeholder="Seleccione una opción"
                      :show-labels="false"
                      track-by="value"
                      required
                    ></multiselect>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <span class="required">Sector Social:</span>
                    <multiselect
                      v-model="formbeneficiario.enfoque_diferencial"
                      label="text"
                      :options="options_sector_social"
                      placeholder="Seleccione una opción"
                      :show-labels="false"
                      track-by="value"
                      required
                    ></multiselect>
                  </div>
                  <div class="col-md-6">
                    <span class="required">Grupo Étnico:</span>
                    <multiselect
                      v-model="formbeneficiario.enfoque_social"
                      label="text"
                      :options="options_grupo_etnico"
                      placeholder="Seleccione una opción"
                      :show-labels="false"
                      track-by="value"
                      required
                    ></multiselect>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                ref="cerrarModalGrupo"
              >
                Cerrar
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                :data-proceso="data_beneficiario"
              >
                Registrar beneficiario
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal CONSULTAR BENEFICIARIOS GRUPO -->
    <div
      class="modal fade"
      id="modal-beneficiarios-grupo"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Beneficiarios registrados en el grupo
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form>
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
                        <th># ASISTENCIAS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(b, index) in beneficiarios">
                        <td>{{ b.identificacion }}</td>
                        <td>{{ b.beneficiario }}</td>
                        <td>{{ b.genero }}</td>
                        <td>{{ b.nacimiento }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
                ref="cerrarModalNuevagrupo"
              >
                Cerrar
              </button>
            </div>
          </form>
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

  $(".modal.modal-wide .modal-dialog").css({
    "width": "90%"
  });

export default {
  components: { Multiselect },
  data() {
    return {
      form: {
        localidad: "",
        institucion: "",
        nivel: "",
        grupo: "",
        responsable: "",
      },

      formbeneficiario: {
        identificacion: "",
        primer_nombre: "",
        segundo_nombre: "",
        primer_apellido: "",
        segundo_apellido: "",
        fecha_nacimiento: "",
        genero: "",
        enfoque_diferencial: "",
        enfoque_social: "",
      },
      iddupla: "",
      id_persona: "",
      codigodupla: "",
      artistasdupla: "",
      grupo: [],
      modal_title: "",
      data_proceso: "",
      data_beneficiario: "",
      id_grupo: "",
      personaid: "",
      options_localidad: [],
      options_lugares: [],
      options_niveles: [],
      options_generos: [],
      options_sector_social: [],
      options_grupo_etnico: [],
      beneficiarios: [],
    };
  },
  mounted() {
    //document.ready
    this.getIdPersona();
    this.getLocalidades();
    //this.getLugaresTransicion();
    this.getNivelesEscolaridad();
    this.getGeneros();
    this.getSectorSocial();
    this.getGruposEtnicos();
  },
  methods: {
    getIdPersona() {
      axios
        .post("/sif/framework/getIdPersona", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        })
        .then((response) => {
          this.id_persona = response.data;
          this.getCodigoArtistasDupla();
          this.getGruposDupla();
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
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
          this.codigodupla = response.data.Codigo;
          this.artistasdupla = response.data.ARTISTAS;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener la dupla de la persona, por favor inténtelo nuevamente",
            "error"
          );
        });
    },

    getGruposDupla() {
      this.grupo = [];
      axios
        .post("/sif/framework/nidos/transicion/getGruposDupla", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          personaid: this.id_persona,
        })
        .then((response) => {
          response.data.forEach((value) => {
            this.grupo.push({
              id: value["IdGrupo"],
              localidad: value["Localidad"],
              idlugar: value["IdLugar"],
              lugar: value["Lugar"],
              idescolaridad: value["IdNivelEscolaridad"],
              nivel: value["Nivel"],
              grupo: value["Grupo"],
              beneficiarios: value["Beneficiarios"],
              estado: value["Estado"],
              responsable: value["Responsable"],
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
    getLocalidades(){
				axios
				.post("/sif/framework/options/getParametroDetalle", {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
				FK_Id_Parametro: 19
				})
				.then(response => {					
						this.options_localidad = response.data;					
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente", "error");
				});
	  },
    getLugaresTransicion() {
      this.form.institucion = "";
      axios
        .post("/sif/framework/nidos/transicion/getLugaresAtenciontransicion", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          "id_localidad": this.form.localidad.value
        })
        .then((response) => {
          this.options_lugares = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
    getNivelesEscolaridad() {
      axios
        .post("/sif/framework/options/getParametroDetalleNidos", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          FK_Id_Parametro: 58,
        })
        .then((response) => {
          this.options_niveles = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de niveles de escolaridad, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
        getNivelesEscolaridad() {
      axios
        .post("/sif/framework/options/getParametroDetalleNidos", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          FK_Id_Parametro: 58,
        })
        .then((response) => {
          this.options_niveles = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de niveles de escolaridad, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
       getGeneros() {
      axios
        .post("/sif/framework/options/getParametroDetalleNidos", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          FK_Id_Parametro: 17,
        })
        .then((response) => {
          this.options_generos = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de sectores sociales, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
    getSectorSocial() {
      axios
        .post("/sif/framework/options/getParametroDetalleNidos", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          FK_Id_Parametro: 87,
        })
        .then((response) => {
          this.options_sector_social = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de sectores sociales, por favor inténtelo nuevamente",
            "error"
          );
        });
    },
    getGruposEtnicos() {
      axios
        .post("/sif/framework/options/getParametroDetalleNidos", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          FK_Id_Parametro: 88,
        })
        .then((response) => {
          this.options_grupo_etnico = response.data;
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se pudo obtener el listado de grupos etnicos, por favor inténtelo nuevamente",
            "error"
          );
        });
    },

    procesargrupo: function (e) {
      e.preventDefault();  
      let proceso =
        e.currentTarget.getAttribute("data-proceso") == "crear"
          ? "guardado"
          : "actualizado";

      axios
        .post("/sif/framework/nidos/transicion/guardarGrupoDupla", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          form: JSON.stringify(this.form),
          proceso: this.data_proceso,
          id_grupo: this.id_grupo,
          id_dupla: this.iddupla,
          id_persona: this.id_persona,
        })
        .then((response) => {
          Swal.fire(
            "Éxito",
            "Se registro correctamente la información del grupo",
            "success"
          );
          this.$refs.cerrarModalNuevagrupo.click();
          Object.keys(this.form).forEach((key) => {
            this.form[key] = "";
          });
          this.getGruposDupla();
          this.$refs.cerrarModalEditargrupo.click();
        })
        .catch((error) => {
          Swal.fire(
            "Error",
            "No se ha registro la información, asegúrese que todos los campos esten diligenciados",
            "error"
          );
        });
    },

    crearGrupo() {
      this.resetFormGrupo(); 
      this.modal_title = "Registrar información del grupo";
      this.data_proceso = "crear";
    },
    editargrupo: function (e) {
      this.modal_title = "Modificar información grupo";
      this.data_proceso = "actualizar";
      this.id_grupo = this.grupo[e.currentTarget.getAttribute("data-index")]["id"];
      this.form.grupo = this.grupo[e.currentTarget.getAttribute("data-index")]["grupo"];
      this.form.responsable = this.grupo[e.currentTarget.getAttribute("data-index")]["responsable"];
      this.setnivelescolaridad(e.currentTarget.getAttribute("data-index"));
    },
    setnivelescolaridad(registro) {
      this.options_niveles.forEach((item) => {
        if (item.value == this.grupo[registro]["idescolaridad"])
          this.form.nivel = { text: item.text, value: item.value };
      });
    },
	cargaridgrupo: function (e) {
    this.resetForm();
	console.log(this.grupo[e.currentTarget.getAttribute("data-index")]["id"]);
      this.id_grupo = this.grupo[e.currentTarget.getAttribute("data-index")]["id"];
	console.log(this.id_grupo);
    },

    buscarbeneficiario() {      
      Swal.fire({
						title: "Cargando información",
						text: "Espere un poco por favor.",
						imageUrl: "/sif/framework/public/images/cargando.gif",
						imageWidth: 140,
						imageHeight: 70,
						showConfirmButton: false,
			});
      axios                    
        .post("/sif/framework/nidos/transicion/getBeneficiariosSimat", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          identificacion: this.formbeneficiario.identificacion,                  
        })        
        .then(response => {     
          this.formbeneficiario.primer_nombre = response.data.PNombre;
          this.formbeneficiario.segundo_nombre = response.data.SNombre;
          this.formbeneficiario.primer_apellido = response.data.PApellido;
          this.formbeneficiario.segundo_apellido = response.data.SApellido;
          this.formbeneficiario.fecha_nacimiento = response.data.Nacimiento;
          this.formbeneficiario.genero = response.data.Genero;
          Swal.close();
        })
        .catch(() => {
          Swal.fire(
            "Advertencia",
            "El beneficiario no se encuentra registrado en la base de datos de SIMAT",
            "warning"
          );
        });
    },
    guardarbeneficiario: function (e) {
      e.preventDefault();
      axios
        .post("/sif/framework/nidos/transicion/guardarBeneficiarioGrupo", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          formbeneficiario: JSON.stringify(this.formbeneficiario),
          id_grupo: this.id_grupo,
        })
        .then((response) => {
          Swal.fire(
            "Éxito",
            "Se ha registrado correctamente la información del beneficiario en el grupo",
            "success"
          );
          this.$refs.cerrarModalBeneficiario.click();
          Object.keys(this.formbeneficiario).forEach((key) => {
            this.formbeneficiario[key] = "";
          });
          this.getGruposDupla();
        })
        .catch((error) => {
          Swal.fire(
            "Éxito",
            "Se ha registrado correctamente la información del beneficiario en el grupo",
            "success"
          );
		  this.resetForm();
          this.getGruposDupla();
        });
    },

	resetForm(){
		    this.formbeneficiario.identificacion = null;
        this.formbeneficiario.primer_nombre = null;
        this.formbeneficiario.segundo_nombre = null;
        this.formbeneficiario.primer_apellido = null;
        this.formbeneficiario.segundo_apellido = null;
        this.formbeneficiario.fecha_nacimiento = null;
        this.formbeneficiario.genero = null;
        this.formbeneficiario.enfoque_diferencial = null;
        this.formbeneficiario.enfoque_social = null;
  },

  	resetFormGrupo(){
		this.form.nivel = null;
    this.form.grupo = null;
    this.form.responsable = null;   
  },


    getBeneficiariosGrupo: function (e) {
      this.beneficiarios = [];
      axios
        .post("/sif/framework/nidos/transicion/getBeneficiariosGrupo", {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          id_grupo:
            this.grupo[e.currentTarget.getAttribute("data-index")]["id"],
        })
        .then((response) => {
          response.data.forEach((value) => {
            this.beneficiarios.push({
              id: value["IdBeneficiario"],
              identificacion: value["Identificacion"],
              beneficiario: value["Beneficiario"],
              genero: value["Genero"],
              fecha: value["Nacimiento"],
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