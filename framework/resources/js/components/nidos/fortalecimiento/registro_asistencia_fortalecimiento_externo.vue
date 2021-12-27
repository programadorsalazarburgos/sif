<template>
    <div class="col-lg-8 offset-lg-2">
        <div class="form-row">
            <div class="form-group col-lg-12">
                <br />
                <h2>Asistencia fortalecimiento externo</h2>
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
                    aria-controls="nav-partcipantes"
                    aria-selected="true"
                    >Información participantes</a
                >
                <a
                    class="nav-link"
                    id="nav-registro-tab"
                    data-toggle="tab"
                    href="#nav-registro"
                    role="tab"
                    aria-controls="nav-registro"
                    aria-selected="true"
                    >Registro</a
                >
                <a
                    class="nav-link"
                    id="nav-consulta-edicion-tab"
                    data-toggle="tab"
                    href="#nav-consulta-edicion"
                    role="tab"
                    aria-controls="nav-consulta-edicion"
                    aria-selected="false"
                    >Consulta y edición</a
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
                        <form @submit="getInformacionParticipantes">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Grupo</label>
                                    <multiselect
                                        v-model="
                                            grupo_consulta_informacion_participantes
                                        "
                                        label="text"
                                        :options="options_grupo"
                                        placeholder="Seleccione una opción"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                                <div class="form-group col-lg-4 offset-lg-4">
                                    <button
                                        class="btn btn-block btn-primary"
                                        type="submit"
                                    >
                                        Consultar
                                    </button>
                                </div>
                            </div>
                        </form>
                        <transition name="fade">
                            <div
                                class="form-row"
                                v-show="mostrar_tabla_informacion"
                            >
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
                                                <th>
                                                    Institución donde trabaja
                                                </th>
                                                <th>
                                                    Nivel o grado con el que
                                                    trabaja
                                                </th>
                                                <th>Ocupación</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(info,
                                                index) in informacion_participantes"
                                            >
                                                <td>
                                                    {{
                                                        info.tipo_documento
                                                            .VC_Descripcion
                                                    }}
                                                </td>
                                                <td>
                                                    {{ info.numero_documento }}
                                                </td>
                                                <td>{{ info.full_name }}</td>
                                                <td>
                                                    {{ info.fecha_nacimiento }}
                                                </td>
                                                <td>{{ info.correo }}</td>
                                                <td>{{ info.celular }}</td>
                                                <td>
                                                    {{ info.genero }}
                                                    {{ info.otro_genero }}
                                                </td>
                                                <td>
                                                    {{
                                                        info.sector_social
                                                            .VC_Descripcion
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        info.grupo_etnico
                                                            .VC_Descripcion
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        info.localidad_trabajo
                                                            .VC_Descripcion
                                                    }}
                                                </td>
                                                <td>
                                                    {{ info.barrio_trabajo }}
                                                </td>
                                                <td>
                                                    {{ info.sitio_trabajo }}
                                                </td>
                                                <td>
                                                    {{
                                                        info.nivel_trabajo.toString()
                                                    }}
                                                    {{
                                                        info.otro_nivel_trabajo
                                                    }}
                                                </td>
                                                <td>
                                                    {{ info.ocupacion }}
                                                    {{ info.otra_ocupacion }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade show"
                id="nav-registro"
                role="tabpanel"
                aria-labelledby="nav-registro-tab"
            >
                <br />
                <div class="card">
                    <div class="card-body">
                        <form
                            @submit="guardarAsistencia"
                            id="form-guardar-asistencia"
                        >
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Grupo</label>
                                    <multiselect
                                        v-model="form.grupo"
                                        label="text"
                                        :options="options_grupo"
                                        @input="
                                            getSesionesGrupo(
                                                form.grupo,
                                                'count'
                                            )
                                        "
                                        placeholder="Seleccione una opción"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Fecha sesión</label>
                                    <input
                                        v-model="form.fecha_sesion"
                                        class="form-control"
                                        type="date"
                                        v-bind:disabled="cantidad_sesiones == 5"
                                        required
                                        @input="
                                            getParticipantesGrupo();
                                            validarFechaSesion();
                                        "
                                    />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <div class="p-3 mb-2 bg-info text-white">
                                        Sesiones realizadas:
                                        {{ cantidad_sesiones }}
                                    </div>
                                </div>
                            </div>
                            <transition name="fade">
                                <div
                                    class="form-row"
                                    v-show="mostrar_tabla_registro"
                                >
                                    <div class="form-group col-lg-12">
                                        <h3>Participantes</h3>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-hover table-bordered"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th>No documento</th>
                                                        <th>Nombres</th>
                                                        <th>Asistencia</th>
                                                        <th
                                                            v-if="
                                                                cantidad_sesiones ==
                                                                    4
                                                            "
                                                        >
                                                            Entrega classroom 1
                                                        </th>
                                                        <th
                                                            v-if="
                                                                cantidad_sesiones ==
                                                                    4
                                                            "
                                                        >
                                                            Entrega classroom 1
                                                        </th>
                                                        <th
                                                            v-if="
                                                                cantidad_sesiones ==
                                                                    4
                                                            "
                                                        >
                                                            Entrega classroom 3
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="(participante,
                                                        index) in form.participantes"
                                                    >
                                                        <td>
                                                            {{
                                                                participante.numero_documento
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                participante.primer_nombre
                                                            }}
                                                            {{
                                                                participante.primer_apellido
                                                            }}
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="custom-control custom-switch"
                                                            >
                                                                <input
                                                                    type="checkbox"
                                                                    class="custom-control-input"
                                                                    name="registrar"
                                                                    v-bind:data-index="
                                                                        index
                                                                    "
                                                                    v-bind:id="
                                                                        'asistencia-' +
                                                                            index
                                                                    "
                                                                    @change="
                                                                        asistencia
                                                                    "
                                                                />
                                                                <label
                                                                    class="custom-control-label"
                                                                    v-bind:for="
                                                                        'asistencia-' +
                                                                            index
                                                                    "
                                                                ></label>
                                                            </div>
                                                        </td>

                                                        <td
                                                            v-if="
                                                                cantidad_sesiones ==
                                                                    4
                                                            "
                                                        >
                                                            <div
                                                                class="input-group input-group-sm mb-3"
                                                            >
                                                                <input
                                                                    type="date"
                                                                    v-bind:name="
                                                                        'fecha-classroom-' +
                                                                            index
                                                                    "
                                                                    class="form-control"
                                                                />
                                                            </div>
                                                        </td>
                                                        <td
                                                            v-if="
                                                                cantidad_sesiones ==
                                                                    4
                                                            "
                                                        >
                                                            <div
                                                                class="input-group input-group-sm mb-3"
                                                            >
                                                                <input
                                                                    type="date"
                                                                    v-bind:name="
                                                                        'fecha-classroom-' +
                                                                            index
                                                                    "
                                                                    class="form-control"
                                                                />
                                                            </div>
                                                        </td>
                                                        <td
                                                            v-if="
                                                                cantidad_sesiones ==
                                                                    4
                                                            "
                                                        >
                                                            <div
                                                                class="input-group input-group-sm mb-3"
                                                            >
                                                                <input
                                                                    type="date"
                                                                    v-bind:name="
                                                                        'fecha-classroom-' +
                                                                            index
                                                                    "
                                                                    class="form-control"
                                                                />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group col-lg-4 offset-lg-4"
                                    >
                                        <button
                                            class="btn btn-block btn-primary"
                                            type="submit"
                                        >
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </transition>
                        </form>
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="nav-consulta-edicion"
                role="tabpanel"
                aria-labelledby="nav-consulta-edicion-tab"
            >
                <br />
                <div class="card">
                    <div class="card-body">
                        <form
                            @submit="guardarAsistencia"
                            id="form-actualizar-asistencia"
                        >
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Grupo</label>
                                    <multiselect
                                        v-model="form_editar.grupo"
                                        label="text"
                                        :options="options_grupo"
                                        @input="
                                            getSesionesGrupo(
                                                form_editar.grupo,
                                                'listado'
                                            )
                                        "
                                        placeholder="Seleccione una opción"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label>Fecha sesión</label>
                                    <multiselect
                                        v-model="form_editar.fecha_sesion"
                                        label="text"
                                        :options="options_fecha_sesion"
                                        @input="consultaEdicionAsistencia()"
                                        placeholder="Seleccione una opción"
                                        :show-labels="false"
                                        track-by="value"
                                    ></multiselect>
                                </div>
                            </div>
                            <br />
                            <transition name="fade">
                                <div
                                    class="form-row"
                                    v-show="mostrar_tabla_actualizacion"
                                >
                                    <div class="form-group col-lg-3 col-10">
                                        <h3>Participantes</h3>
                                    </div>
                                    <div
                                        class="form-group col-lg-1 offset-lg-8 col-2"
                                    >
                                        <button
                                            class="btn btn-block"
                                            type="button"
                                            :class="[
                                                editar == false
                                                    ? 'btn-warning'
                                                    : 'btn-danger'
                                            ]"
                                            @click="editar = !editar"
                                        >
                                            <i
                                                :class="[
                                                    editar == false
                                                        ? 'fas fa-edit'
                                                        : 'fas fa-times'
                                                ]"
                                            ></i>
                                        </button>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <table
                                            class="table table-striped table-hover table-bordered"
                                        >
                                            <thead>
                                                <tr>
                                                    <th>No documento</th>
                                                    <th>Nombres</th>
                                                    <th>Asistencia</th>
                                                    <th
                                                        v-if="
                                                            verificar_sesion_classroom !=
                                                                0
                                                        "
                                                    >
                                                        Entrega classroom 1
                                                    </th>
                                                    <th
                                                        v-if="
                                                            verificar_sesion_classroom !=
                                                                0
                                                        "
                                                    >
                                                        Entrega classroom 2
                                                    </th>
                                                    <th
                                                        v-if="
                                                            verificar_sesion_classroom !=
                                                                0
                                                        "
                                                    >
                                                        Entrega classroom 3
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(participante,
                                                    index) in form_editar.participantes"
                                                >
                                                    <td>
                                                        {{
                                                            participante.numero_documento
                                                        }}
                                                    </td>
                                                    <td>
                                                        {{
                                                            participante.primer_nombre
                                                        }}
                                                        {{
                                                            participante.primer_apellido
                                                        }}
                                                    </td>
                                                    <td v-if="editar == false">
                                                        {{
                                                            participante.texto_asistencia
                                                        }}
                                                    </td>
                                                    <td v-else>
                                                        <div
                                                            class="custom-control custom-switch"
                                                        >
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                name="actualizar"
                                                                v-bind:data-index="
                                                                    index
                                                                "
                                                                :checked="
                                                                    participante.asistencia
                                                                "
                                                                v-bind:id="
                                                                    'asistencia-' +
                                                                        index
                                                                "
                                                                @change="
                                                                    asistencia
                                                                "
                                                            />
                                                            <label
                                                                class="custom-control-label"
                                                                v-bind:for="
                                                                    'asistencia-' +
                                                                        index
                                                                "
                                                            ></label>
                                                        </div>
                                                    </td>
                                                    <td
                                                        v-if="
                                                            verificar_sesion_classroom !=
                                                                0
                                                        "
                                                    >
                                                        <input
                                                            type="date"
                                                            v-bind:name="
                                                                'fecha-classroom-actualizar-' +
                                                                    index
                                                            "
                                                            class="form-control"
                                                            :value="
                                                                participante
                                                                    .fechas_classroom[0]
                                                            "
                                                            :readonly="!editar"
                                                        />
                                                    </td>
                                                    <td
                                                        v-if="
                                                            verificar_sesion_classroom !=
                                                                0
                                                        "
                                                    >
                                                        <input
                                                            type="date"
                                                            v-bind:name="
                                                                'fecha-classroom-actualizar-' +
                                                                    index
                                                            "
                                                            class="form-control"
                                                            :value="
                                                                participante
                                                                    .fechas_classroom[1]
                                                            "
                                                            :readonly="!editar"
                                                        />
                                                    </td>
                                                    <td
                                                        v-if="
                                                            verificar_sesion_classroom !=
                                                                0
                                                        "
                                                    >
                                                        <input
                                                            type="date"
                                                            v-bind:name="
                                                                'fecha-classroom-actualizar-' +
                                                                    index
                                                            "
                                                            class="form-control"
                                                            :value="
                                                                participante
                                                                    .fechas_classroom[2]
                                                            "
                                                            :readonly="!editar"
                                                        />
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div
                                        class="form-group col-lg-4 offset-lg-4"
                                        v-show="editar"
                                    >
                                        <button
                                            class="btn btn-block btn-primary"
                                            type="submit"
                                        >
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </transition>
                        </form>
                    </div>
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
                grupo: "",
                id_dupla: "",
                fecha_sesion: "",
                participantes: [],
                id_persona: ""
            },
            form_editar: {
                grupo: "",
                fecha_sesion: "",
                participantes: []
            },
            grupo_consulta_informacion_participantes: "",
            informacion_participantes: "",
            cantidad_sesiones: "",
            options_grupo: [],
            options_fecha_sesion: [],
            verificar_sesion_classroom: 0,
            editar: false,
            mostrar_tabla_informacion: false,
            mostrar_tabla_registro: false,
            mostrar_tabla_actualizacion: false
        };
    },
    mounted() {
        this.getIdPersona();
    },
    methods: {
        getIdPersona() {
            axios
                .post("/sif/framework/getIdPersona", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                })
                .then(response => {
                    this.form.id_persona = response.data;
                    this.getDuplaPersona();
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información de la persona, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getDuplaPersona() {
            axios
                .post("/sif/framework/nidos/duplas/getDuplaPersona", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    id_persona: this.form.id_persona
                })
                .then(response => {
                    this.form.id_dupla = response.data.Pk_Id_Dupla;
                    this.getGruposOferta();
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la dupla de la persona, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getGruposOferta() {
            axios
                .post("/sif/framework/nidos/fortalecimiento/getGruposOferta", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    id_dupla: this.form.id_dupla
                })
                .then(response => {
                    if (response.data == "") {
                        Swal.fire(
                            "Atención",
                            "No tiene grupos asignados",
                            "warning"
                        );
                    } else {
                        this.options_grupo = response.data;
                    }
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de grupos disponibles, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getSesionesGrupo(grupo, tipo_consulta) {
            this.form_editar.fecha_sesion = "";
            axios
                .post("/sif/framework/nidos/fortalecimiento/getSesionesGrupo", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    id_grupo: grupo.value,
                    tipo_consulta: tipo_consulta
                })
                .then(response => {
                    if (tipo_consulta == "count") {
                        this.cantidad_sesiones = response.data;
                        if (this.cantidad_sesiones == 2) {
                            Swal.fire(
                                "Atención",
                                "Ya no se pueden registrar más sesiones de fortalecimiento para el grupo seleccionado",
                                "warning"
                            );
                        }
                    } else {
                        this.options_fecha_sesion = response.data;
                    }
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo guardar la información, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getParticipantesGrupo() {
            this.form.participantes = [];
            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/getParticipantesGrupo",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_grupo: this.form.grupo.value
                    }
                )
                .then(response => {
                    response.data.participantes.forEach((value, index) => {
                        this.form.participantes.push({
                            id: value["id"],
                            numero_documento: value["numero_documento"],
                            primer_nombre: value["primer_nombre"],
                            primer_apellido: value["primer_apellido"],
                            asistencia: false,
                            fechas_classroom: []
                        });
                    });
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener los participantes del grupo, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        asistencia: function(e) {
            if (e.currentTarget.getAttribute("name") == "registrar") {
                this.form.participantes[
                    e.currentTarget.getAttribute("data-index")
                ]["asistencia"] = e.currentTarget.checked;
            } else {
                this.form_editar.participantes[
                    e.currentTarget.getAttribute("data-index")
                ]["asistencia"] = e.currentTarget.checked;
            }
        },
        validarFechaSesion() {
            this.mostrar_tabla_registro = false;
            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/validarFechaSesion",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_grupo: this.form.grupo.value,
                        fecha_sesion: this.form.fecha_sesion
                    }
                )
                .then(response => {
                    if (this.form.fecha_sesion == response.data) {
                        Swal.fire(
                            "Advertencia",
                            "Ya se ha registrado una sesión para la fecha seleccionada, por favor elija otra",
                            "warning"
                        );
                    }
                    if (response.data == 0) {
                        this.mostrar_tabla_registro = true;
                    }
                })
                .catch(error => {});
        },
        guardarAsistencia: function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Guardando asistencia",
                text: "Espere un poco por favor.",
                imageUrl: "/sif/framework/public/images/cargando.gif",
                imageWidth: 140,
                imageHeight: 70,
                showConfirmButton: false
            });

            let form =
                e.target.id == "form-guardar-asistencia"
                    ? this.form
                    : this.form_editar;
            let inputs_name =
                e.target.id == "form-guardar-asistencia"
                    ? "fecha-classroom-"
                    : "fecha-classroom-actualizar-";
            let accion =
                e.target.id == "form-guardar-asistencia"
                    ? "guardar"
                    : "actualizar";

            for (var i = 0; i < form.participantes.length; i++) {
                form.participantes[i]["fechas_classroom"] = [];
                document.getElementsByName(inputs_name + i).forEach(el => {
                    form.participantes[i]["fechas_classroom"].push(el.value);
                });
            }

            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/guardarAsistencia",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        form: JSON.stringify(form),
                        accion: accion
                    }
                )
                .then(response => {
                    Swal.close();
                    Swal.fire(
                        "Éxito",
                        "Se ha guardado la asistencia correctamente",
                        "success"
                    );
                    this.mostrar_tabla_registro = false;
                    this.mostrar_tabla_actualizacion = false;
                    this.form.grupo = "";
                    this.form.fecha_sesion = "";
                    this.form_editar.grupo = "";
                    this.form_editar.fecha_sesion = "";
                    this.cantidad_sesiones = "";
                    this.editar = false;
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo guardar la información, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        consultaEdicionAsistencia() {
            if (this.form_editar.grupo == "") {
                Swal.fire(
                    "Advertencia",
                    "Compruebe que ha seleccionado un grupo",
                    "warning"
                );
            } else if (this.form_editar.fecha_sesion == "") {
                Swal.fire(
                    "Advertencia",
                    "Compruebe que ha seleccionado una fecha de sesión",
                    "warning"
                );
            } else {
                this.form_editar.participantes = [];
                this.mostrar_tabla_actualizacion = true;

                axios
                    .post(
                        "/sif/framework/nidos/fortalecimiento/consultaEdicionAsistencia",
                        {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            id_sesion: this.form_editar.fecha_sesion.value
                        }
                    )
                    .then(response => {
                        this.verificar_sesion_classroom = 0;

                        response.data.forEach((value, index) => {
                            if (value["fechas_classroom"].length != 0) {
                                this.verificar_sesion_classroom = 1;
                            }
                        });

                        response.data.forEach((value, index) => {
                            let asistencia =
                                value["asistencia"] == "Si" ? true : false;
                            this.form_editar.participantes.push({
                                id: value["participantes"][0]["id"],
                                numero_documento:
                                    value["participantes"][0][
                                        "numero_documento"
                                    ],
                                primer_nombre:
                                    value["participantes"][0]["primer_nombre"],
                                primer_apellido:
                                    value["participantes"][0][
                                        "primer_apellido"
                                    ],
                                texto_asistencia: value["asistencia"],
                                asistencia: asistencia,
                                fechas_classroom: value["fechas_classroom"]
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
            }
        },
        getInformacionParticipantes: function(e) {
            e.preventDefault();

            if (
                this.grupo_consulta_informacion_participantes != "" &&
                this.grupo_consulta_informacion_participantes != null
            ) {
                this.mostrar_tabla_informacion = false;
                let nombre_grupo_archivo = this
                    .grupo_consulta_informacion_participantes.text;

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
                        "/sif/framework/nidos/fortalecimiento/getInformacionParticipantes",
                        {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            id_grupo: this
                                .grupo_consulta_informacion_participantes.value
                        }
                    )
                    .then(response => {
                        this.informacion_participantes =
                            response.data[0].participantes;

                        if (
                            $.fn.DataTable.isDataTable(
                                "#tabla-informacion-participantes"
                            )
                        )
                            $("#tabla-informacion-participantes")
                                .DataTable()
                                .destroy();

                        setTimeout(
                            function() {
                                $("#tabla-informacion-participantes").DataTable(
                                    {
                                        responsive: true,
                                        pageLength: 50,
                                        dom: "Blfrtip",
                                        buttons: [
                                            {
                                                extend: "excel",
                                                text: "Descargar datos",
                                                filename:
                                                    "Participantes " +
                                                    nombre_grupo_archivo +
                                                    " fortalecimiento externo"
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
                                            search: "Filtrar",
                                            paginate: {
                                                first: "Primera",
                                                last: "Última",
                                                next: "Siguiente",
                                                previous: "Anterior"
                                            }
                                        }
                                    }
                                );
                                $($.fn.dataTable.tables(true))
                                    .DataTable()
                                    .columns.adjust()
                                    .responsive.recalc();
                                Swal.close();
                            },
                            (this.mostrar_tabla_informacion = true),
                            500
                        );
                    })
                    .catch(error => {
                        Swal.fire(
                            "Error",
                            "No se pudo obtener la información de los participantes, por favor inténtelo nuevamente",
                            "error"
                        );
                    });
            } else {
                Swal.fire(
                    "Atención",
                    "Compruebe que ha seleccionado un grupo",
                    "warning"
                );
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
