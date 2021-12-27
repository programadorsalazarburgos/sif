<template>
  <div class="col-lg-8 offset-lg-2">
    <div class="form-row">
      <div class="form-group col-lg-12">
        <br />
        <h2>Administración Colegios convenio - SED</h2>
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
          >Administración Colegios</a
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
			  <div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-success"><h4>Listado Instituciones Educativas</h4>
							</div>
						</div>
				<br>
            <div class="form-row text-right">
              <div class="form-group col-lg-6 offset-lg-6">
                <button
                  class="btn btn-block btn-primary"
                  data-toggle="modal"
                  data-target="#modal-instituciones"
                  @click="crearOferta()"
                >
                  REGISTRAR NUEVA INSTITUCIÓN EDUCATIVA
                </button>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-lg-12">                
                <table
                  id="tabla_areas_artisticas"
                  name="tabla_areas_artisticas"
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
                      <th>UPZ</th>
                      <th>BARRIO</th>
                      <th>INSTITUCIÓN EDUCATIVA</th>
                      <th>DANE</th>
					  <th>EDITAR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(o, index) in oferta">
                      <td>{{ o.localidad }}</td>
                      <td>{{ o.upz }}</td>
                      <td>{{ o.barrio }}</td>
                      <td>{{ o.lugar }}</td>
                      <td>{{ o.dane }}</td>
					  <td><button class="btn btn-block btn-warning" :data-index="index" data-toggle="modal" data-target="#modal-instituciones" @click="editarOferta"><i class="fas fa-edit"></i></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

		<!-- Modal nueva oferta -->
		<div class="modal fade" id="modal-instituciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">{{ modal_title }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form @submit="procesarOferta">						
						<div class="modal-body">
							<div class="form-group">								
								<div class="row">
									<label class="col-md-4 required">Localidad:</label>
									<div class="col-md-8">
										<multiselect v-model="form.localidad" label="text" :options="options_localidad" @input="getUpzLocalidades" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
									</div>
								</div>
								<div class="row">
									<label class="col-md-4 required">Upz:</label>
									<div class="col-md-8">
										<multiselect v-model="form.upz" label="text" :options="options_upz_localidad" placeholder="Seleccione una opción" :show-labels="false" track-by="value" required></multiselect>
										
									</div>
								</div>
								<div class="row">
									<label class="col-md-4 required">Barrio:</label>
									<div class="col-md-8">
										<input v-model="form.barrio" class="form-control" type="text" required>
									</div>
								</div>
								<div class="row">
									<label class="col-md-4 required">Dirección:</label>
									<div class="col-md-8">
										<input v-model="form.direccion" class="form-control" type="text" required>
									</div>
								</div>
								<div class="row">
									<label class="col-md-4">Nombre Institución:</label>
									<div class="col-md-8">
										<input v-model="form.institucion" class="form-control" type="text" required>
									</div>
								</div>
								<div class="row">
									<label class="col-md-4 required">Codigo DANE:</label>
									<div class="col-md-8">
										<input v-model="form.dane" class="form-control" type="text" required>
									</div>
								</div>
								

							</div>
						</div> 
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary"data-dismiss="modal" ref="cerrarModalNuevaOferta">Cerrar</button>
							<button type="submit" class="btn btn-primary" :data-proceso="data_proceso">Guardar</button>
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

export default {
  components: { Multiselect },
  data() {
    return {
		form:{
			localidad: "",
			upz: "",
			barrio: "",
			direccion: "",
			institucion: "",
			dane: ""

		},
      oferta: [],
	  
      fecha_hoy: "",
	  modal_title: "",
	  data_proceso: "",
	  id_institucion: "",
	  options_localidad: [],
	  options_upz_localidad: []

    }
  },
  mounted() {
    //document.ready
    this.getColegiosConvenioSED();
	this.getLocalidades();
  },
  methods: {
    getColegiosConvenioSED() {
      this.oferta = [];
      axios
        .post("/sif/framework/nidos/transicion/getColegiosConvenioSED", {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        })
        .then((response) => {
          response.data.forEach((value) => {
            this.oferta.push({
			  id: value["IdLugar"],
			  idlocalidad: value["IdLocalidad"],
			  idupz: value["IdUpz"],
              localidad: value["Localidad"],
              upz: value["Upz"],
              barrio: value["Barrio"],
			  direccion: value["Direccion"],
              lugar: value["Lugar"],
              dane: value["Dane"],
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
			getUpzLocalidades(){
				this.form.options_upz_localidad = "";
				axios
				.post("/sif/framework/getUpzLocalidad", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"id_localidad": this.form.localidad.value
				})
				.then(response => {
					this.options_upz_localidad = response.data;
				})
				.catch(error => {
					Swal.fire("Error", "No se pudo obtener el listado de barrios, por favor inténtelo nuevamente", "error");
				});
			},

	procesarOferta: function(e){
				e.preventDefault();
				let proceso = e.currentTarget.getAttribute("data-proceso") == "crear" ? "guardado" : "actualizado";

				axios
				.post("/sif/framework/nidos/transicion/guardarInstitucion", {
					"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
					"form": JSON.stringify(this.form),
					proceso: this.data_proceso,
					id_institucion: this.id_institucion
				})
				.then(response => {
					Swal.fire("Éxito", "Se ha " +proceso+ " correctamente la información de la institución educativa", "success");
					this.$refs.cerrarModalNuevaOferta.click();
					Object.keys(this.form).forEach( key => {
						this.form[key] = "";
					});
					this.getColegiosConvenioSED();
				})
				.catch(error => {
					Swal.fire("Error", "No se ha " +proceso+ " la información, por favor inténtelo nuevamente", "error");
				});
			},

		crearOferta(){
				this.modal_title = 'Registrar institución educativa';
				this.data_proceso = 'crear';

		},
		editarOferta: function(e){
				this.modal_title = 'Modificar módulo';
				this.data_proceso = 'actualizar';
				this.id_institucion = this.oferta[e.currentTarget.getAttribute("data-index")]["id"];
				//this.form.localidad = this.oferta[e.currentTarget.getAttribute("data-index")]["idlocalidad"];
				//this.form.upz = this.oferta[e.currentTarget.getAttribute("data-index")]["idupz"];
				this.form.barrio = this.oferta[e.currentTarget.getAttribute("data-index")]["barrio"];
				this.form.direccion = this.oferta[e.currentTarget.getAttribute("data-index")]["direccion"];
				this.form.institucion = this.oferta[e.currentTarget.getAttribute("data-index")]["lugar"];
				this.form.dane = this.oferta[e.currentTarget.getAttribute("data-index")]["dane"];				
				this.setlocalidades(e.currentTarget.getAttribute("data-index"));
				this.setupz(e.currentTarget.getAttribute("data-index"));
		},
		setlocalidades(registro){
		        this.options_localidad.forEach((item) => {
                if(item.value == this.oferta[registro]['idlocalidad'])
                    this.form.localidad = {text: item.text, value: item.value};
                });		
		},
		setupz(registro){
		        this.options_upz_localidad.forEach((item) => {
                if(item.value == this.oferta[registro]['idupz'])
                    this.form.upz = {text: item.text, value: item.value};
        });		
		},
		
  },
};
</script>





