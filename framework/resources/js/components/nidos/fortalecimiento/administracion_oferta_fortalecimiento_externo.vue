<template>
    <div class="col-lg-8 offset-lg-2">
        <div class="form-row">
            <div class="form-group col-lg-12">
                <br />
                <h2>Administración oferta fortecimiento</h2>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a
                    class="nav-link active"
                    id="nav-participantes-tab"
                    data-toggle="tab"
                    href="#nav-participantes"
                    role="tab"
                    aria-controls="nav-participantes"
                    aria-selected="true"
                    >Información grupos y participantes</a
                >
                <a
                    class="nav-link"
                    id="nav-modulos-tab"
                    data-toggle="tab"
                    href="#nav-modulos"
                    role="tab"
                    aria-controls="nav-modulos"
                    aria-selected="true"
                    >Módulos</a
                >
                <a
                    class="nav-link"
                    id="nav-asignacion-grupos-tab"
                    data-toggle="tab"
                    href="#nav-asignacion-grupos"
                    role="tab"
                    aria-controls="nav-asignacion-grupos"
                    aria-selected="false"
                    >Asignación grupos</a
                >
                <a
                    class="nav-link"
                    id="nav-reporte-pandora-tab"
                    data-toggle="tab"
                    href="#nav-reporte-pandora"
                    role="tab"
                    aria-controls="nav-reporte-pandora"
                    aria-selected="false"
                    >Reporte pandora</a
                >
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div
                class="tab-pane fade show active"
                id="nav-participantes"
                role="tabpanel"
                aria-labelledby="nav-participantes-tab"
            >
                <br />
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <h3>Información grupos</h3>
                                <br />
                                <table
                                    class="table table-striped table-hover table-bordered display"
                                    id="tabla-informacion-grupos"
                                    style="width:100%"
                                >
                                    <thead>
                                        <tr>
                                            <th>Grupo</th>
                                            <th>Participantes inscritos</th>
                                            <th>Cupos disponibles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(grupo,
                                            index) in info_grupos"
                                        >
                                            <td>
                                                {{ grupo.modulo_oferta }}
                                                {{ grupo.jornada_oferta }} Grupo
                                                {{ grupo.id }}
                                            </td>
                                            <td>
                                                {{ grupo.participantes_count }}
                                            </td>
                                            <td>
                                                {{
                                                    25 -
                                                        grupo.participantes_count
                                                }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-lg-12">
                                <h3>Información participantes</h3>
                                <br />
                                <table
                                    class="table table-striped table-hover table-bordered display"
                                    id="tabla-informacion-participantes"
                                    style="width:100%"
                                >
                                    <thead>
                                        <tr>
                                            <th>Grupo</th>
                                            <th>Tipo documento</th>
                                            <th>No documento</th>
                                            <th>Nombre</th>
                                            <th>Fecha de nacimiento</th>
                                            <th>Correo</th>
                                            <th>Celular</th>
                                            <th>Género</th>
                                            <th>Sector social</th>
                                            <th>Grupo étnico</th>
                                            <th>Localidad donde trabajo</th>
                                            <th>Barrio donde trabajo</th>
                                            <th>Institución donde trabaja</th>
                                            <th>
                                                Nivel o grado con el que trabaja
                                            </th>
                                            <th>Ocupación</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade show"
                id="nav-modulos"
                role="tabpanel"
                aria-labelledby="nav-modulos-tab"
            >
                <br />
                <div class="card">
                    <div class="card-body">
                        <div class="form-row text-right">
                            <div class="form-group col-lg-1 offset-lg-11">
                                <button
                                    class="btn btn-block btn-primary"
                                    data-toggle="modal"
                                    data-target="#modal-oferta"
                                    @click="crearOferta()"
                                >
                                    <i class="fas fa-plus-square"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <h4>Módulos disponibles</h4>
                                <table
                                    class="table table-hover table-striped table-bordered"
                                >
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Editar</th>
                                            <th>Activar/Inactivar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(o, index) in oferta">
                                            <td>{{ o.modulo }}</td>
                                            <td>{{ o.descripcion }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-block btn-warning"
                                                    :data-index="index"
                                                    data-toggle="modal"
                                                    data-target="#modal-oferta"
                                                    @click="editarOferta"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <div
                                                    class="custom-control custom-switch"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        name="registrar"
                                                        :data-index="index"
                                                        v-bind:id="
                                                            'modulo-' + index
                                                        "
                                                        :checked="o.estado"
                                                        @change="
                                                            cambiarEstadoOferta
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        v-bind:for="
                                                            'modulo-' + index
                                                        "
                                                    ></label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="nav-asignacion-grupos"
                role="tabpanel"
                aria-labelledby="nav-asignacion-grupos-tab"
                @click="
                    getGruposOferta();
                    getDuplas();
                "
            >
                <br />
                <div class="card">
                    <div class="card-body">
                        <form @submit="asignarDuplaGrupo">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Grupo</label>
                                    <multiselect
                                        v-model="grupo"
                                        label="text"
                                        :options="options_grupo"
                                        placeholder="Seleccione una opción"
                                        @input="getDuplaAsignada()"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Dupla asignada</label>
                                    <multiselect
                                        v-model="dupla"
                                        label="text"
                                        :options="options_dupla"
                                        placeholder="Seleccione una opción"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6 offset-lg-3">
                                    <button
                                        type="submit"
                                        class="btn btn-block btn-primary"
                                    >
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="nav-reporte-pandora"
                role="tabpanel"
                aria-labelledby="nav-reporte-pandora-tab"
            >
                <br />
                <div class="card">
                    <div class="card-body">
                        <form @submit="getReportePandora">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Mes</label>
                                    <multiselect
                                        v-model="mes_reporte_pandora"
                                        label="text"
                                        :options="options_mes"
                                        placeholder="Seleccione una opción"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 offset-lg-3">
                                <button
                                    type="submit"
                                    class="btn btn-block btn-primary"
                                >
                                    Consultar
                                </button>
                            </div>
                        </form>
                        <transition name="fade">
                            <div
                                class="form-row"
                                v-show="mostrar_tabla_reporte_pandora"
                            >
                                <div class="form-group col-lg-12">
                                    <table
                                        class="table table-hover table-bordered table-striped"
                                        id="tabla-reporte-pandora"
                                        width="100%"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Localidad</th>
                                                <th>
                                                    Personas inscritas a la
                                                    actividad
                                                </th>
                                                <th>Mujeres</th>
                                                <th>Hombres</th>
                                                <th>Total</th>
                                                <th>Juventud 18-28 años</th>
                                                <th>
                                                    Personas Adultas 29-59 años
                                                </th>
                                                <th>
                                                    Personas Mayores 60 años en
                                                    adelante
                                                </th>
                                                <th>
                                                    Comunidades Campesinas y
                                                    Rurales
                                                </th>
                                                <th>
                                                    Mujeres Gestantes y
                                                    Lactantes
                                                </th>
                                                <th>
                                                    Personas que ejercen
                                                    actividades sexuales pagadas
                                                </th>
                                                <th>
                                                    Personas habitantes de calle
                                                </th>
                                                <th>
                                                    Personas con discapacidad
                                                </th>
                                                <th>
                                                    Personas privadas de la
                                                    libertad
                                                </th>
                                                <th>
                                                    Profesionales del Sector
                                                </th>
                                                <th>Sectores LGBTIQ</th>
                                                <th>
                                                    Personas víctimas del
                                                    conflicto armado
                                                </th>
                                                <th>Población migrante</th>
                                                <th>
                                                    Personas víctimas de trata
                                                </th>
                                                <th>
                                                    Familias En Emergencia
                                                    Social Y Catastrófica
                                                </th>
                                                <th>
                                                    Familias Ubicadas En Zonas
                                                    De Deterioro Urbano
                                                </th>
                                                <th>
                                                    Familias En Situación De
                                                    Vulnerabilidad
                                                </th>
                                                <th>
                                                    Personas En Situación De
                                                    Desplazamiento
                                                </th>
                                                <th>
                                                    Personas Consumidoras De
                                                    Sustancias Psicoactivas
                                                </th>
                                                <th>Pueblo Rrom – Gitano</th>
                                                <th>
                                                    Pueblo Rrom – Gitano
                                                    (Prorrom)
                                                </th>
                                                <th>
                                                    Pueblo y/o comunidad
                                                    indígena
                                                </th>
                                                <th>Comunidades negras</th>
                                                <th>
                                                    Población afrodescendiente
                                                </th>
                                                <th>Comunidades palenqueras</th>
                                                <th>Pueblo raizal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(i,
                                                index) in info_reporte_pandora"
                                            >
                                                <td>{{ i.LOCALIDAD }}</td>
                                                <td>{{ i.TOTAL_INSCRITOS }}</td>
                                                <td>{{ i.MUJERES }}</td>
                                                <td>{{ i.HOMBRES }}</td>
                                                <td>{{ i.TOTAL }}</td>
                                                <td>{{ i.JUVENTUD }}</td>
                                                <td>
                                                    {{ i.PERSONAS_ADULTAS }}
                                                </td>
                                                <td>{{ i.MAYORES }}</td>
                                                <td>{{ i.COMUNIDAD_RURAL }}</td>
                                                <td>
                                                    {{ i.MUJERES_GESTANTES }}
                                                </td>
                                                <td>
                                                    {{ i.ACTIVIDADES_SEXUALES }}
                                                </td>
                                                <td>
                                                    {{ i.HABITANTES_CALLE }}
                                                </td>
                                                <td>{{ i.DISCAPACIDAD }}</td>
                                                <td>
                                                    {{ i.PRIVADOS_LIBERTAD }}
                                                </td>
                                                <td>{{ i.PROFESIONALES }}</td>
                                                <td>{{ i.LGTBIQ }}</td>
                                                <td>
                                                    {{ i.VICTIMAS_CONFLICTO }}
                                                </td>
                                                <td>
                                                    {{ i.POBLACION_MIGRANTE }}
                                                </td>
                                                <td>{{ i.VICTIMAS_TRATA }}</td>
                                                <td>
                                                    {{ i.EMERGENCIA_SOCIAL }}
                                                </td>
                                                <td>{{ i.DETERIORO }}</td>
                                                <td>{{ i.VULNERABILIDAD }}</td>
                                                <td>{{ i.DESPLAZAMIENTO }}</td>
                                                <td>{{ i.CONSUMIDORAS }}</td>
                                                <td>{{ i.ROM }}</td>
                                                <td>{{ i.PROM }}</td>
                                                <td>{{ i.INDIGENA }}</td>
                                                <td>
                                                    {{ i.COMUNIDADES_NEGRAS }}
                                                </td>
                                                <td>{{ i.AFRO }}</td>
                                                <td>{{ i.PALENQUERAS }}</td>
                                                <td>{{ i.RAIZAL }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal nueva oferta -->
        <div
            class="modal fade"
            id="modal-oferta"
            tabindex="-1"
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
                    <form @submit="procesarOferta">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="required">Módulo</label>
                                    <input
                                        v-model="form.modulo"
                                        class="form-control"
                                        type="text"
                                        required
                                    />
                                </div>
                                <div class="form-group col-lg-12">
                                    <label>Descripción</label>
                                    <textarea
                                        v-model="form.descripcion"
                                        class="form-control"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                ref="cerrarModalNuevaOferta"
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
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
export default {
    components: { Multiselect },
    data() {
        return {
            form: {
                modulo: "",
                descripcion: ""
            },
            oferta: [],
            options_grupo: [],
            options_dupla: [],
            modal_title: "",
            data_proceso: "",
            id_oferta: "",
            grupo: "",
            dupla: "",
            options_grupo: [],
            options_dupla: [],
            tabla_participantes: "",
            info_grupos: "",
            options_mes: [
                { value: "01", text: "Enero" },
                { value: "02", text: "Febrero" },
                { value: "03", text: "Marzo" },
                { value: "04", text: "Abril" },
                { value: "05", text: "Mayo" },
                { value: "06", text: "Junio" },
                { value: "07", text: "Julio" },
                { value: "08", text: "Agosto" },
                { value: "09", text: "Septiembre" },
                { value: "10", text: "Octubre" },
                { value: "11", text: "Noviembre" },
                { value: "12", text: "Diciembre" }
            ],
            mes_reporte_pandora: null,
            info_reporte_pandora: "",
            mostrar_tabla_reporte_pandora: false
        };
    },
    mounted() {
        this.tabla_participantes = $(
            "#tabla-informacion-participantes"
        ).DataTable({
            responsive: true,
            pageLength: 50,
            dom: "Blfrtip",
            buttons: [
                {
                    extend: "excel",
                    text: "Descargar datos",
                    filename: "Participantes fortalecimiento externo"
                }
            ],
            language: {
                lengthMenu: "Ver _MENU_ registros por página",
                zeroRecords: "No hay información, lo sentimos.",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                search: "Filtrar",
                paginate: {
                    first: "Primera",
                    last: "Última",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

        this.getOfertaFortalecimientoExterno();
        this.getCuposGruposOferta();
        this.getParticipantesOferta();
    },
    methods: {
        getOfertaFortalecimientoExterno() {
            this.oferta = [];
            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/getOfertaFortalecimientoExterno",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                )
                .then(response => {
                    response.data.forEach((value, index) => {
                        this.oferta.push({
                            id: value["id"],
                            modulo: value["modulo"],
                            descripcion: value["descripcion"],
                            estado: value["estado"]
                        });
                    });
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo guardar la información, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        cambiarEstadoOferta: function(e) {
            this.id_oferta = this.oferta[
                e.currentTarget.getAttribute("data-index")
            ]["id"];
            let texto =
                this.oferta[e.currentTarget.getAttribute("data-index")][
                    "estado"
                ] == 0
                    ? "activado"
                    : "inactivado";

            let estado_cambio = !this.oferta[
                e.currentTarget.getAttribute("data-index")
            ]["estado"];

            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/cambiarEstadoOferta",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_oferta: this.id_oferta,
                        estado_cambio: estado_cambio
                    }
                )
                .then(response => {
                    Swal.fire(
                        "Éxito",
                        "Se ha " +
                            texto +
                            " la oferta de fortalecimiento correctamente",
                        "success"
                    );
                    this.getOfertaFortalecimientoExterno();
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo " +
                            texto +
                            " la oferta de fortalecimiento, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },

        procesarOferta: function(e) {
            e.preventDefault();
            let proceso =
                e.currentTarget.getAttribute("data-proceso") == "crear"
                    ? "guardado"
                    : "actualizado";

            axios
                .post("/sif/framework/nidos/fortalecimiento/procesarOferta", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    form: JSON.stringify(this.form),
                    proceso: this.data_proceso,
                    id_oferta: this.id_oferta
                })
                .then(response => {
                    Swal.fire(
                        "Éxito",
                        "Se ha " + proceso + " la información correctamente",
                        "success"
                    );
                    this.$refs.cerrarModalNuevaOferta.click();
                    Object.keys(this.form).forEach(key => {
                        this.form[key] = "";
                    });
                    this.getOfertaFortalecimientoExterno();
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se ha " +
                            proceso +
                            " la información, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        crearOferta() {
            this.modal_title = "Crear módulo";
            this.data_proceso = "crear";
            this.form.modulo = "";
            this.form.descripcion = "";
        },
        editarOferta: function(e) {
            this.modal_title = "Modificar módulo";
            this.data_proceso = "actualizar";
            this.id_oferta = this.oferta[
                e.currentTarget.getAttribute("data-index")
            ]["id"];
            this.form.modulo = this.oferta[
                e.currentTarget.getAttribute("data-index")
            ]["modulo"];
            this.form.descripcion = this.oferta[
                e.currentTarget.getAttribute("data-index")
            ]["descripcion"];
        },
        getGruposOferta() {
            axios
                .post("/sif/framework/nidos/fortalecimiento/getGruposOferta", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
                .then(response => {
                    this.options_grupo = response.data;
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getDuplas() {
            axios
                .post("/sif/framework/nidos/duplas/getDuplas", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    tipo_dupla: 4
                })
                .then(response => {
                    this.options_dupla = response.data;
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de duplas disponibles, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getDuplaAsignada() {
            axios
                .post("/sif/framework/nidos/duplas/getDuplaAsignada", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    id_grupo: this.grupo.value
                })
                .then(response => {
                    this.dupla = response.data;
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la dupla asignada para el grupo seleccionado, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        asignarDuplaGrupo: function(e) {
            e.preventDefault();

            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/asignarDuplaGrupo",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_grupo: this.grupo.value,
                        id_dupla: this.dupla.value
                    }
                )
                .then(response => {
                    Swal.fire(
                        "Éxito",
                        "Se ha asignado el grupo a la dupla seleccionada",
                        "success"
                    );
                    this.grupo = "";
                    this.dupla = "";
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo asignar el grupo a la dupla seleccionada, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getParticipantesOferta() {
            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/getInformacionParticipantes",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_grupo: ""
                    }
                )
                .then(response => {
                    this.tabla_participantes.clear().draw();

                    response.data.forEach((value, index) => {
                        value.participantes.forEach((v, i) => {
                            let genero =
                                value.participantes[i]["otro_genero"] == null
                                    ? value.participantes[i]["genero"]
                                    : value.participantes[i]["genero"] +
                                      " " +
                                      value.participantes[i]["otro_genero"];
                            let nivel_trabajo = value.participantes[i][
                                "nivel_trabajo"
                            ].toString();
                            let ocupacion =
                                value.participantes[i]["otra_ocupacion"] == null
                                    ? value.participantes[i]["ocupacion"]
                                    : value.participantes[i]["ocupacion"] +
                                      " " +
                                      value.participantes[i]["otra_ocupacion"];

                            this.rowNode = this.tabla_participantes.row
                                .add([
                                    value["modulo_oferta"] +
                                        " " +
                                        value["jornada_oferta"] +
                                        " Grupo " +
                                        value["id"],
                                    value.participantes[i]["tipo_documento"][
                                        "VC_Descripcion"
                                    ],
                                    value.participantes[i]["numero_documento"],
                                    value.participantes[i]["full_name"],
                                    value.participantes[i]["fecha_nacimiento"],
                                    value.participantes[i]["correo"],
                                    value.participantes[i]["celular"],
                                    genero,
                                    value.participantes[i]["sector_social"][
                                        "VC_Descripcion"
                                    ],
                                    value.participantes[i]["grupo_etnico"][
                                        "VC_Descripcion"
                                    ],
                                    value.participantes[i]["localidad_trabajo"][
                                        "VC_Descripcion"
                                    ],
                                    value.participantes[i]["barrio_trabajo"],
                                    value.participantes[i]["sitio_trabajo"],
                                    nivel_trabajo,
                                    ocupacion
                                ])
                                .draw()
                                .node();
                        });
                    });

                    $($.fn.dataTable.tables(true))
                        .DataTable()
                        .columns.adjust()
                        .responsive.recalc();
                    Swal.close();
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de los participantes, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getCuposGruposOferta() {
            Swal.fire({
                title: "Cargando información",
                text: "Espere un poco por favor.",
                imageUrl: "/sif/framework/public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false
            });

            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/getCuposGruposOferta",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                )
                .then(response => {
                    this.info_grupos = response.data;

                    if ($.fn.DataTable.isDataTable("#tabla-informacion-grupos"))
                        $("#tabla-informacion-grupos")
                            .DataTable()
                            .destroy();

                    setTimeout(function() {
                        $("#tabla-informacion-grupos").DataTable({
                            responsive: true,
                            pageLength: 50,
                            dom: "Blfrtip",
                            buttons: [
                                {
                                    extend: "excel",
                                    text: "Descargar datos",
                                    filename:
                                        "Grupos activos fortalecimiento externo"
                                }
                            ],
                            language: {
                                lengthMenu: "Ver _MENU_ registros por página",
                                zeroRecords: "No hay información, lo sentimos.",
                                info: "Mostrando página _PAGE_ de _PAGES_",
                                infoEmpty: "No hay registros disponibles",
                                infoFiltered:
                                    "(filtrado de un total de _MAX_ registros)",
                                search: "Filtrar",
                                paginate: {
                                    first: "Primera",
                                    last: "Última",
                                    next: "Siguiente",
                                    previous: "Anterior"
                                }
                            }
                        });
                    }, 500);
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener los cupos disponibles, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getReportePandora: function(e) {
            e.preventDefault();

            if (
                this.mes_reporte_pandora == "" ||
                this.mes_reporte_pandora == null
            ) {
                Swal.fire(
                    "Atención",
                    "Compruebe que ha seleccionado un mes",
                    "warning"
                );
            } else {
                Swal.fire({
                    title: "Cargando información",
                    text: "Espere un poco por favor.",
                    imageUrl: "/sif/framework/public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false
                });

                axios
                    .post(
                        "/sif/framework/nidos/fortalecimiento/getReportePandora",
                        {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            mes: this.mes_reporte_pandora.value
                        }
                    )
                    .then(response => {
                        this.info_reporte_pandora = response.data;

                        if (
                            $.fn.DataTable.isDataTable("#tabla-reporte-pandora")
                        )
                            $("#tabla-reporte-pandora")
                                .DataTable()
                                .destroy();

                        setTimeout(
                            function() {
                                $("#tabla-reporte-pandora").DataTable({
                                    paging: false,
                                    responsive: true,
                                    dom: "Blfrtip",
                                    buttons: [
                                        {
                                            extend: "excel",
                                            text: "Descargar datos",
                                            filename: "Reporte pandora"
                                        }
                                    ],
                                    language: {
                                        lengthMenu:
                                            "Ver _MENU_ registros por página",
                                        zeroRecords:
                                            "No hay información, lo sentimos.",
                                        info:
                                            "Mostrando página _PAGE_ de _PAGES_",
                                        infoEmpty:
                                            "No hay registros disponibles",
                                        infoFiltered:
                                            "(filtrado de un total de _MAX_ registros)",
                                        search: "Filtrar"
                                    }
                                });
                                Swal.close();
                            },
                            (this.mostrar_tabla_reporte_pandora = true),
                            500
                        );
                    })
                    .catch(error => {
                        Swal.fire(
                            "Error",
                            "No se pudo asignar el grupo a la dupla seleccionada, por favor inténtelo nuevamente",
                            "error"
                        );
                    });
            }
        }
    }
};
</script>
<style type="text/css">
.required:after {
    content: " *";
    color: red;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.8s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
