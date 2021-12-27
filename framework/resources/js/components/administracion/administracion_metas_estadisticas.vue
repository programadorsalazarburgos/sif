<template>
    <div class="row">
    <div class="col-lg-12 col-md-12 text-center">
    </div>
    <!-- /.col-md-12 -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header text-muted">
                <h2 class="m-0">Planificación Artistas Formadores y Grupos</h2><h5>Metas de Cobertura Anual, Cantidad de Artistas Formadores y Grupos por Área Artística</h5>
            </div>
            <div class="card-body text-center">
                <form>
                    <div class="form-group row justify-content-center">
                        <label for="SL_ANIO" class="col-sm-1 col-form-label text-right">AÑO</label>
                        <div class="col-sm-2">
                          <multiselect v-model="SL_ANIO" :options="options_anio" label="text" track-by="value" id="SL_ANIO" @input="cargarDatosYear($event)" name="SL_ANIO"></multiselect>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="TX_META_COBERTURA" class="col-sm-2 col-form-label text-right">META COBERTURA</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="TX_META_COBERTURA" v-model="TX_META_COBERTURA" value="0">
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="TX_META_COBERTURA_AE" class="col-sm-2 col-form-label text-right">META COBERTURA AE</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="TX_META_COBERTURA_AE" v-model="TX_META_COBERTURA_AE" value="0">
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="TX_META_COBERTURA_IC" class="col-sm-2 col-form-label text-right">META COBERTURA IC</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="TX_META_COBERTURA_IC" v-model="TX_META_COBERTURA_IC" value="0">
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="TX_META_COBERTURA_CV" class="col-sm-2 col-form-label text-right">META COBERTURA CV</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="TX_META_COBERTURA_CV" v-model="TX_META_COBERTURA_CV" value="0">
                        </div>
                    </div>
                    <div v-for="(convenio,k) in convenios_activos" :key="k" class="form-group row justify-content-center">
                        <label class="col-sm-2 col-form-label text-right">META COBERTURA {{ convenio.nombre_convenio }}</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" v-bind:id="'TX_META_COBERTURA_CONVENIO_'+convenio.valor" v-model="METAS_CONVENIOS[convenio.valor]" value="0">
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="TX_TOTAL_AF" class="col-sm-2 col-form-label text-right"># FORMADORES</label>
                        <div class="col-sm-1">
                            <input id="TX_TOTAL_AF" type="number" value="0" @change="inputChanged($event)" v-model="TX_TOTAL_AF" data-tipo="total_formadores" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group justify-content-center">
							<div class="col-sm-6">
								<table id="tabla_areas_artisticas" name="tabla_areas_artisticas" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
									<thead>
										<th>Área Artística</th>
										<th>Cantidad de Artistas Formadores</th>
                                        <th>Cantidad de Grupos AE</th>
                                        <th>Cantidad de Grupos IC</th>
                                        <th>Cantidad de Grupos CV</th>
                                        <th v-for="(convenio,m) in convenios_activos" :key="m">Cantidad de Grupos {{ convenio.nombre_convenio }}</th>
									</thead>
									<tbody>
                                        <tr v-for="(area_artistica,i) in areas_artisticas" :key="i">
                                            <td>{{ area_artistica.text }}</td>
                                            <td><input v-bind:id="'TX_Formadores_' + area_artistica.value" type="number" value="0" @change="inputChanged($event)" v-bind:data-area=area_artistica.value data-tipo="formadores" v-bind:data-index=i class="form-control formadores" style="border-radius:0px;"></td>
                                            <td><input v-bind:id="'TX_Grupos_AE_' + area_artistica.value" type="number" value="0" @change="inputChanged($event)" v-bind:data-area=area_artistica.value data-tipo="grupos_ae" v-bind:data-index=i class="form-control grupos_ae" style="border-radius:0px;"></td>
                                            <td><input v-bind:id="'TX_Grupos_IC_' + area_artistica.value" type="number" value="0" @change="inputChanged($event)" v-bind:data-area=area_artistica.value data-tipo="grupos_ic" v-bind:data-index=i class="form-control grupos_ic" style="border-radius:0px;"></td>
                                            <td><input v-bind:id="'TX_Grupos_CV_' + area_artistica.value" type="number" value="0" @change="inputChanged($event)" v-bind:data-area=area_artistica.value data-tipo="grupos_cv" v-bind:data-index=i class="form-control grupos_cv" style="border-radius:0px;"></td>
                                            <td v-for="(convenio,j) in convenios_activos" :key="j">
                                                <input v-bind:data-index=i v-bind:id="'TX_Grupos_Convenio_' + i +'_'+convenio.valor" type="number" value="0" @change="inputChanged($event)" v-bind:data-area=area_artistica.value v-bind:data-tipo="'grupos_convenio_'+convenio.valor" v-bind:data-index_convenio=j v-bind:class="'form-control grupos_convenio grupos_convenio_'+convenio.valor" style="border-radius:0px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>TOTAL</b></td>
                                            <td><b>{{ contador_formadores }}</b></td>
                                            <td><b>{{ contador_grupos_ae }}</b></td>
                                            <td><b>{{ contador_grupos_ic }}</b></td>
                                            <td><b>{{ contador_grupos_cv }}</b></td>
                                            <td v-for="(convenio,k) in convenios_activos" :key="k"><b> {{ convenio.contador_grupos }}</b></td>
                                        </tr>
                                        <tr>
                                            <td><b>DISPONIBLE</b></td>
                                            <td><b>{{ disponible_formadores }}</b></td>
                                            <td style="background-color: #dee2e6;"></td>
                                            <td style="background-color: #dee2e6;"></td>
                                            <td style="background-color: #dee2e6;"></td>
                                            <td v-for="(convenio,l) in convenios_activos" :key="l" style="background-color: #dee2e6;"></td>
                                        </tr>
									</tbody>
								</table>
							</div>
							<br>
							<br>
						</div>
                </form>
                <a href="#" class="btn btn-primary" @click="guardarEstadisticas">Guardar</a>
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->
</template>

<script>
    import Multiselect from "vue-multiselect";
    import DataTables from "datatables.net";
    import Sweetalert2 from 'sweetalert2';
    
    export default {
        components: { Multiselect },
        data () {
            return {
                SL_ANIO: null,
                TX_META_COBERTURA: 0,
                TX_META_COBERTURA_AE : 0,
                TX_META_COBERTURA_IC : 0,
                TX_META_COBERTURA_CV : 0,
                TX_TOTAL_AF: 0,
                options_anio: [],
                areas_artisticas: [],
                contador_formadores: 0,
                contador_grupos_ae: 0,
                contador_grupos_ic: 0,
                contador_grupos_cv: 0,
                disponible_formadores: 0,
                convenios_activos: [],
                METAS_CONVENIOS:{},
                id_convenios: [],
            }
        },
        mounted() {
            this.getListadoAnios();
            this.getListadoAreasArtisticas();
            this.getConveniosActivosCREA();
        },
        methods: {
            getListadoAnios(){
                axios
                    .post("/sif/framework/options/getYearsTbEstadisticaAnio", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    })
                    .then(response => {
                        this.options_anio = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getListadoAreasArtisticas(){
                axios
                    .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    FK_Id_Parametro: 6
                })
                .then(response => {
                    $.each(response.data, function(i){
                        response.data[i]['formadores'] = 0;
                        response.data[i]['grupos_ae'] = 0;
                        response.data[i]['grupos_ic'] = 0;
                        response.data[i]['grupos_cv'] = 0;
                    });
                    this.areas_artisticas = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
            },
            getConveniosActivosCREA(){
                axios
                    .post("/sif/framework/options/getConveniosActivosCREA", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    })
                    .then(response => {
                        this.convenios_activos = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            getConveniosById(){
                axios
                    .post("/sif/framework/administracion/metas-estadisticas/getConveniosById", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        id_convenios:this.id_convenios
                    })
                    .then(response => {
                        this.convenios_activos = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            inputChanged(e){
                if(e.target.id != "TX_TOTAL_AF"){
                    this.areas_artisticas[parseInt($("#"+e.target.id).data('index'))][$("#"+e.target.id).data('tipo')]= e.target.value;
                }
                else{
                    this.disponible_formadores = this.TX_TOTAL_AF;
                }
                
                if($("#"+e.target.id).data('tipo') == "formadores" || e.target.id == "TX_TOTAL_AF"){
                    var contador=0;
                    $.each($(".formadores"), function(i){
                       contador += parseInt($(this).val());
                    });
                    this.contador_formadores = contador;
                    this.disponible_formadores = this.TX_TOTAL_AF - this.contador_formadores;
                    if(this.disponible_formadores < 0){
                        Swal.fire(
                            'Excedió el número de artistas',
                            "Máximo "+this.TX_TOTAL_AF,
                            'warning'
                        )
                    }
                }
                if($("#"+e.target.id).data('tipo') == "grupos_ae" || $("#"+e.target.id).data('tipo')=="grupos_ic" || $("#"+e.target.id).data('tipo')=='grupos_cv'){
                    if($("#"+e.target.id).data('tipo') == "grupos_ae"){
                        var contador=0;
                        $.each($(".grupos_ae"), function(i){
        		    	    contador += parseInt($(this).val());
                        });
                        this.contador_grupos_ae = contador;
                    }
                    if($("#"+e.target.id).data('tipo') == "grupos_ic"){
                        var contador=0;
                        $.each($(".grupos_ic"), function(i){
        		    	    contador += parseInt($(this).val());
                        });
                        this.contador_grupos_ic = contador;
                    }
                    if($("#"+e.target.id).data('tipo') == "grupos_cv"){
                        var contador=0;
                        $.each($(".grupos_cv"), function(i){
        		    	    contador += parseInt($(this).val());
                        });
                        this.contador_grupos_cv = contador;
                    }
                }
                else{
                    var contador=0;
                    var tipo_grupo = $("#"+e.target.id).data('tipo');
                    $.each($("."+tipo_grupo), function(i){
        			    contador += parseInt($(this).val());
                    });
                    this.convenios_activos[parseInt($("#"+e.target.id).data('index_convenio'))]['contador_grupos']=contador;
                }
            },
            cargarDatosYear(e){
                this.getListadoAreasArtisticas();
                axios
                    .post("/sif/framework/administracion/metas-estadisticas/get", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        'SL_ANIO': this.SL_ANIO.value
                    })
                    .then(response => {
                        if(response.data.TX_Meta_Cobertura_Anual_Linea != null && response.data.TX_Formadores_Area != null && response.data.TX_Grupos_Area){
                            Swal.fire(
                                'Información cargada',
                                "Se ha cargado la información existente ",
                                'info'
                            )
                            this.TX_META_COBERTURA = $.parseJSON(response.data.TX_Meta_Cobertura_Anual_CREA).Y;
                            this.TX_META_COBERTURA_AE = $.parseJSON(response.data.TX_Meta_Cobertura_Anual_Linea).ae;
                            this.TX_META_COBERTURA_IC = $.parseJSON(response.data.TX_Meta_Cobertura_Anual_Linea).ic;
                            this.TX_META_COBERTURA_CV = $.parseJSON(response.data.TX_Meta_Cobertura_Anual_Linea).cv;
                            this.METAS_CONVENIOS={};
                            if(response.data.TX_Meta_Cobertura_Anual_Convenios != null){
                                this.METAS_CONVENIOS= $.parseJSON(response.data.TX_Meta_Cobertura_Anual_Convenios);
                            }
                            this.id_convenios = [];
                            for(var key in this.METAS_CONVENIOS){
                                this.id_convenios.push(key);
                            }
                            
                            if(this.SL_ANIO.value == new Date().getFullYear()){
                                this.getConveniosActivosCREA();
                            }
                            else{
                                this.getConveniosById();
                            }

                            setTimeout(() => {
                            var valor_area = null;
                            this.disponible_formadores = 0;
                            this.contador_formadores = 0;
                            this.contador_grupos_ae = 0;
                            this.contador_grupos_ic = 0;
                            this.contador_grupos_cv = 0;
                            for (let i = 0; i < this.areas_artisticas.length; i++) {
                                valor_area = this.areas_artisticas[i].value;
                                this.contador_formadores += parseInt($.parseJSON(response.data.TX_Formadores_Area)[valor_area]);
                                this.contador_grupos_ae += parseInt($.parseJSON(response.data.TX_Grupos_Area).ae[valor_area]);
                                this.contador_grupos_ic += parseInt($.parseJSON(response.data.TX_Grupos_Area).ic[valor_area]);
                                this.contador_grupos_cv += parseInt($.parseJSON(response.data.TX_Grupos_Area).cv[valor_area]);
                                $("#TX_Formadores_"+valor_area).val($.parseJSON(response.data.TX_Formadores_Area)[valor_area]);
                                this.areas_artisticas[i]["formadores"]= $.parseJSON(response.data.TX_Formadores_Area)[valor_area];
                                $("#TX_Grupos_AE_"+valor_area).val($.parseJSON(response.data.TX_Grupos_Area).ae[valor_area]);
                                this.areas_artisticas[i]["grupos_ae"]= $.parseJSON(response.data.TX_Grupos_Area).ae[valor_area];
                                $("#TX_Grupos_IC_"+valor_area).val($.parseJSON(response.data.TX_Grupos_Area).ic[valor_area]);
                                this.areas_artisticas[i]["grupos_ic"]= $.parseJSON(response.data.TX_Grupos_Area).ic[valor_area];
                                $("#TX_Grupos_CV_"+valor_area).val($.parseJSON(response.data.TX_Grupos_Area).cv[valor_area]);
                                this.areas_artisticas[i]["grupos_cv"]= $.parseJSON(response.data.TX_Grupos_Area).cv[valor_area];
                            }
                            
                            for (var key in $.parseJSON(response.data.TX_Grupos_Area)) {
                                if ($.parseJSON(response.data.TX_Grupos_Area).hasOwnProperty(key)) {
                                    var index = 0;
                                    var contador = 0;
                                        for (var keydos in $.parseJSON(response.data.TX_Grupos_Area)[key]) {
                                            if ($.parseJSON(response.data.TX_Grupos_Area).hasOwnProperty(key)) {
                                                if(key.includes('convenio')){
                                                    console.log(key+"-"+keydos+" -> " + $.parseJSON(response.data.TX_Grupos_Area)[key][keydos]);
                                                    $("#TX_Grupos_Convenio_"+index+"_"+key.replace("convenio_", "")).val($.parseJSON(response.data.TX_Grupos_Area)[key][keydos]);
                                                    this.areas_artisticas[index]["grupos_convenio_"+key.replace("convenio_", "")]= $.parseJSON(response.data.TX_Grupos_Area)[key][keydos];
                                                    contador = contador + parseInt($.parseJSON(response.data.TX_Grupos_Area)[key][keydos]);
                                                    this.convenios_activos[parseInt($("#TX_Grupos_Convenio_"+index+"_"+key.replace("convenio_", "")).data('index_convenio'))]['contador_grupos']=contador;
                                                }
                                            }
                                            index++;
                                        }
                                }
                            }
                            this.disponible_formadores = 0;
                            this.TX_TOTAL_AF = this.contador_formadores;
                            }, 1000);
                        }
                        else{
                            if(this.SL_ANIO.value == new Date().getFullYear()){
                                this.getConveniosActivosCREA();
                            }
                            else{
                                this.getConveniosById();
                            }
                            this.TX_META_COBERTURA = 0;
                            this.TX_META_COBERTURA_AE = 0;
                            this.TX_META_COBERTURA_IC = 0;
                            this.TX_META_COBERTURA_CV = 0;
                            this.METAS_CONVENIOS = {};
                            this.id_convenios = [];
                            for (let i = 0; i < this.areas_artisticas.length; i++) {
                                valor_area = this.areas_artisticas[i].value;
                                $("#TX_Formadores_"+valor_area).val(0);
                                $("#TX_Grupos_AE_"+valor_area).val(0);
                                $("#TX_Grupos_IC_"+valor_area).val(0);
                                $("#TX_Grupos_CV_"+valor_area).val(0);
                            }
                            this.getListadoAreasArtisticas();
                            this.TX_TOTAL_AF = 0;
                            this.contador_formadores = 0;
                            this.contador_grupos_ae = 0;
                            this.contador_grupos_ic = 0;
                            this.contador_grupos_cv = 0;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            guardarEstadisticas(){
                if(this.disponible_formadores < 0){
                    Swal.fire(
                        'Excedió el número de artistas',
                        "Máximo "+this.TX_TOTAL_AF,
                        'warning'
                    )
                }
                
                if(this.disponible_formadores > 0){
                    Swal.fire(
                        'Aún quedan artistas disponibles ',
                        this.disponible_formadores+" artistas disponibles.",
                        'info'
                    )
                }

                if(this.disponible_formadores == 0){
                    Swal.fire({
                        title: 'Estás seguro de guardar?',
                        text: "Se guardarán las metas y cifras para el año "+this.SL_ANIO.value,
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
                              imageUrl: "../public/images/cargando.gif",
                              imageWidth: 140,
                              imageHeight: 70,
                              showConfirmButton: false,
                              backdrop: `
                                  rgba(0,0,123,0.4)
                              `,
                            });
                          axios
                            .post("/sif/framework/administracion/metas-estadisticas/save", {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                'SL_ANIO': this.SL_ANIO.value,
                                'TX_META_COBERTURA': this.TX_META_COBERTURA,
                                'TX_META_COBERTURA_AE': this.TX_META_COBERTURA_AE,
                                'TX_META_COBERTURA_IC': this.TX_META_COBERTURA_IC,
                                'TX_META_COBERTURA_CV': this.TX_META_COBERTURA_CV,
                                'METAS_CONVENIOS': this.METAS_CONVENIOS,
                                'TX_TOTAL_AF': this.TX_TOTAL_AF,
                                'JSON_AREAS': this.areas_artisticas
                            })
                            .then(response => {
                                swal.close();
                                console.log(response.data);
                                if(response.data == 1){
                                    Swal.fire(
                                        'Guardado!',
                                        'Las cifras del año '+this.SL_ANIO.value+' han sido guardadas.',
                                        'success'
                                    )
                                    this.resetForm();
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });
                      }
                    })
                }
            },
            resetForm(){
                this.SL_ANIO = null;
                this.TX_META_COBERTURA = 0;
                this.TX_META_COBERTURA_AE = 0;
                this.TX_META_COBERTURA_IC = 0;
                this.TX_META_COBERTURA_CV = 0;
                this.TX_TOTAL_AF = 0;
                this.contador_formadores = 0;
                this.disponible_formadores = 0;
                this.contador_grupos_ae = 0;
                this.contador_grupos_ic = 0;
                this.contador_grupos_cv = 0;
                $(".formadores").val("0");
                $(".grupos_ae").val("0");
                $(".grupos_ic").val("0");
                $(".grupos_cv").val("0");
                $(".grupos_convenio").val("0");
                this.convenios_activos = [];
                this.METAS_CONVENIOS = [];
            }
        }
        }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>