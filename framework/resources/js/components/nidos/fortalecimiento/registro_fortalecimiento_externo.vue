<template>
    <div class="col-lg-8 offset-lg-2">
        <div class="form-row">
            <div class="form-group col-lg-12">
                <br />
                <h2>Inscripción fortalecimiento externo</h2>
                <p>
                    El programa Nidos - Arte en primera infancia del Instituto
                    distrital de las artes del IDARTES, adelanta esta estrategia
                    de cualificación y fortalecimiento técnico basado en los
                    aprendizajes, hallazgos y descubrimientos que ha consolidado
                    lo largo de más de 7 años de atención en torno a las artes,
                    la creación, los lenguajes, los ambientes enriquecidos y los
                    derechos culturales de la primera infancia.
                </p>
                <p>
                    A través de este formulario usted podrá inscribirse para
                    participar en tres sesiones de fortalecimiento sincrónico
                    (virtual) que se darán una por semana
                    <strong>(del 20 de septiembre al 8 de octubre)</strong> en
                    la jornada am o pm según corresponda su inscripción. Los
                    módulos a trabajar corresponden a: Memoria y Cuerpo, Juego y
                    Materia, Materiales y Objetos, basados en los contenidos
                    creados por los equipos de artistas del programa. Este
                    proceso se dará a partir del diálogo de saberes, la
                    experimentación práctica, la creación de experiencias
                    artísticas y la exploración sensible para enriquecer las
                    prácticas pedagógicas y el quehacer profesional de las y los
                    participantes.
                    <br />
                    <strong
                        >*Recuerda que los cupos son limitados a 120
                        participantes</strong
                    >
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-info">
                <i class="fas fa-info"></i> Información personal
            </div>
            <div class="card-body">
                <form @submit="guardarSolicitud">
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Email
                                <small
                                    >(registre el correo que habitualmente
                                    utiliza)</small
                                ></label
                            >
                            <input
                                v-model="form.correo"
                                type="email"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="required">Confirmar Email</label>
                            <input
                                v-model="form.confirmar_correo"
                                type="email"
                                class="form-control"
                                :change="validarEmail"
                                required
                            />
                            <span class="error" v-if="errors.email">{{
                                errors.email
                            }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required">Primer nombre</label>
                            <input
                                v-model="form.primer_nombre"
                                type="text"
                                class="form-control"
                                @input="
                                    form.primer_nombre = form.primer_nombre.toUpperCase()
                                "
                                required
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Segundo nombre</label>
                            <input
                                v-model="form.segundo_nombre"
                                type="text"
                                class="form-control"
                                @input="
                                    form.segundo_nombre = form.segundo_nombre.toUpperCase()
                                "
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required">Primer apellido</label>
                            <input
                                v-model="form.primer_apellido"
                                type="text"
                                class="form-control"
                                @input="
                                    form.primer_apellido = form.primer_apellido.toUpperCase()
                                "
                                required
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Segundo apellido</label>
                            <input
                                v-model="form.segundo_apellido"
                                type="text"
                                class="form-control"
                                @input="
                                    form.segundo_apellido = form.segundo_apellido.toUpperCase()
                                "
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Tipo de identificación</label
                            >
                            <multiselect
                                v-model="form.tipo_documento"
                                label="text"
                                :options="options_tipo_documento"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Número de identificación</label
                            >
                            <input
                                v-model="form.numero_documento"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required">Fecha de nacimiento</label>
                            <input
                                v-model="form.fecha_nacimiento"
                                type="date"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="required">Número de celular</label>
                            <input
                                v-model="form.celular"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required">Género</label>
                            <multiselect
                                v-model="form.genero"
                                label="text"
                                :options="options_genero"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                                @input="validarGenero()"
                            ></multiselect>
                        </div>

                        <div class="form-group col-lg-6">
                            <label :class="{ required: required_otro_genero }"
                                >Otro género ¿Cuál?</label
                            >
                            <input
                                v-model="form.otro_genero"
                                class="form-control"
                                type="text"
                                :readonly="readonly_otro_genero"
                                :required="required_otro_genero"
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Sector social al que usted pertenece</label
                            >
                            <multiselect
                                v-model="form.sector_social"
                                label="text"
                                :options="options_sector_social"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Grupo étnico al que usted pertenece</label
                            >
                            <multiselect
                                v-model="form.grupo_etnico"
                                label="text"
                                :options="options_grupo_etnico"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-3">
                            <label>Entidad a la que está vinculado/a</label>
                            <p>{{ form.entidad }}</p>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >¿Cuál es su tipo de vinculación con la
                                Secretaría de Educación?</label
                            >
                            <multiselect
                                v-model="form.tipo_vinculacion"
                                label="text"
                                :options="options_tipo_vinculacion"
                                @input="validarVinculacion()"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                        <div class="form-group col-lg-3">
                            <label
                                :class="{
                                    required: required_otro_tipo_vinculacion
                                }"
                                >Otro tipo de vinculación ¿Cuál?</label
                            >
                            <input
                                v-model="form.otro_tipo_vinculacion"
                                class="form-control"
                                type="text"
                                :readonly="readonly_otro_tipo_vinculacion"
                                :required="required_otro_tipo_vinculacion"
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Localidad donde trabaja</label
                            >
                            <multiselect
                                v-model="form.localidad_trabajo"
                                label="text"
                                :options="options_localidad"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                                @input="getBarriosLocalidad()"
                            ></multiselect>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Barrio donde donde trabaja</label
                            >
                            <multiselect
                                v-model="form.barrio_trabajo"
                                label="text"
                                :options="options_barrio"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label class="required"
                                >Institución educativa donde trabaja</label
                            >
                            <input
                                v-model="form.sitio_trabajo"
                                class="form-control"
                                type="text"
                                @input="
                                    form.sitio_trabajo = form.sitio_trabajo.toUpperCase()
                                "
                                required
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required"
                                >Nivel o grado con el que trabaja</label
                            >
                            <multiselect
                                v-model="form.nivel"
                                multiple
                                label="text"
                                :options="options_nivel"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                                @input="validarNivel()"
                            ></multiselect>
                        </div>

                        <div class="form-group col-lg-6">
                            <label :class="{ required: required_otro_nivel }"
                                >Otro nivel o grado ¿Cuál?</label
                            >
                            <input
                                v-model="form.otro_nivel"
                                class="form-control"
                                type="text"
                                :readonly="readonly_otro_nivel"
                                :required="required_otro_nivel"
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-6">
                            <label class="required">Ocupación</label>
                            <multiselect
                                v-model="form.ocupacion"
                                label="text"
                                :options="options_ocupacion"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                                @input="validarOcupacion()"
                            ></multiselect>
                        </div>
                        <div class="form-group col-lg-6">
                            <label
                                :class="{ required: required_otra_ocupacion }"
                                >Otra ocupación ¿Cuál?</label
                            >
                            <input
                                v-model="form.otra_ocupacion"
                                class="form-control"
                                type="text"
                                :readonly="readonly_otra_ocupacion"
                                :required="required_otra_ocupacion"
                            />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label class="required"
                                >Módulo de fortalecimiento</label
                            >
                            <multiselect
                                v-model="form.modulo_fortalecimiento"
                                label="text"
                                :options="options_modulo_fortalecimiento"
                                placeholder="Seleccione esta opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label class="required"
                                >Jornada en la que puede participar en el
                                fortalecimiento
                                <small>
                                    (Por favor verifique que NO sea la jornada
                                    en la que trabaja)</small
                                ></label
                            >
                            <multiselect
                                v-model="form.jornada_fortalecimiento"
                                label="text"
                                :options="options_jornada"
                                placeholder="Seleccione una opción"
                                :show-labels="false"
                                track-by="value"
                            ></multiselect>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <button
                                    type="submit"
                                    class="btn btn-block btn-primary"
                                >
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
                //variables cuidador
                correo: "",
                confirmar_correo: "",
                primer_nombre: "",
                segundo_nombre: "",
                primer_apellido: "",
                segundo_apellido: "",
                tipo_documento: "",
                numero_documento: "",
                fecha_nacimiento: "",
                celular: "",
                genero: "",
                otro_genero: null,
                sector_social: "",
                grupo_etnico: "",
                entidad: "SECRETARIA DE EDUCACIÓN (SED)",
                tipo_vinculacion: null,
                otro_tipo_vinculacion: null,
                localidad_trabajo: "",
                barrio_trabajo: "",
                sitio_trabajo: "",
                nivel: "",
                otro_nivel: null,
                ocupacion: "",
                otra_ocupacion: null,
                modulo_fortalecimiento: "",
                jornada_fortalecimiento: ""
            },
            errors: {
                email: ""
            },

            options_tipo_documento: [],
            options_localidad: [],
            options_modulo_fortalecimiento: [],
            options_barrio: [],
            options_genero: [
                { value: "1", text: "Masculino" },
                { value: "2", text: "Femenino" },
                { value: "3", text: "Otro ¿Cuál?" }
            ],
            options_ocupacion: [
                { value: "Maestra o maestro ", text: "Maestra o maestro " },
                { value: "Docente de apoyo", text: "Docente de apoyo" },
                { value: "Directivo docente", text: "Directivo docente" },
                { value: "Otro ¿Cuál?", text: "Otro ¿Cuál?" }
            ],
            options_nivel: [
                { value: "Prejardín", text: "Prejardín" },
                { value: "Jardín", text: "Jardín" },
                { value: "Transición", text: "Transición" },
                { value: "Otro ¿Cuál?", text: "Otro ¿Cuál?" }
            ],
            options_jornada: [
                { value: "Mañana", text: "Mañana" },
                { value: "Tarde", text: "Tarde" }
            ],
            options_sector_social: [
                { value: 14, text: "COMUNIDAD RURAL Y CAMPESINA" },
                {
                    value: 18,
                    text: "PERSONAS QUE EJERCEN ACTIVIDADES SEXUALES PAGADAS"
                },
                { value: 12, text: "PERSONAS HABITANTES DE CALLE" },
                { value: 5, text: "SITUACIÓN O CONDICIÓN DE DISCAPACIDAD" },
                { value: 22, text: "SECTORES LGBTIQ" },
                { value: 4, text: "POBLACIÓN VÍCTIMA DEL CONFLICTO" },
                { value: 19, text: "POBLACIÓN MIGRANTE" },
                {
                    value: 23,
                    text: "FAMILIAS EN EMERGENCIA SOCIAL Y CATASTRÓFICA"
                },
                {
                    value: 20,
                    text: "FAMILIAS UBICADAS EN ZONAS DE DETERIORO URBANO"
                },
                { value: 26, text: "PERSONAS EN SITUACIÓN DE DESPLAZAMIENTO" },
                {
                    value: 24,
                    text: "PERSONAS CONSUMIDORAS DE SUSTANCIAS PSICOACTIVAS"
                },
                { value: 10, text: "POBLACIÓN CARCELARIA" },
                { value: 27, text: "MUJERES GESTANTES Y LACTANTES" },
                { value: 28, text: "PROFESIONALES DEL SECTOR" },
                { value: 29, text: "PERSONAS VICTIMAS DE TRATA" },
                { value: 30, text: "FAMILIAS EN SITUACIÓN DE VULNERABILIDAD" },
                { value: 6, text: "NINGUNO" }
            ],
            options_grupo_etnico: [
                { value: 2, text: "RROM" },
                { value: 3, text: "INDÍGENA" },
                { value: 25, text: "COMUNIDADES NEGRAS" },
                { value: 1, text: "AFRODESCENDIENTE" },
                { value: 21, text: "PALENQUERA" },
                { value: 13, text: "RAIZAL" },
                { value: 31, text: "PRORROM" },
                { value: 6, text: "NINGUNO" }
            ],
            options_tipo_vinculacion: [
                { value: "Planta", text: "Planta" },
                { value: "Planta provisional", text: "Planta provisional " },
                { value: "Otro ¿Cuál?", text: "Otro ¿Cuál?" }
            ],

            readonly_otro_genero: true,
            required_otro_genero: false,

            readonly_otro_nivel: true,
            required_otro_nivel: false,

            readonly_otra_ocupacion: true,
            required_otra_ocupacion: false,

            readonly_otro_tipo_vinculacion: true,
            required_otro_tipo_vinculacion: false
        };
    },
    mounted() {
        this.getParametroDetalle(5);
        this.getParametroDetalle(14);
        this.getParametroDetalle(19);
        this.getParametroDetalle(53);
        this.getOfertaActivaFortalecimientoExterno();
    },
    computed: {
        validarEmail() {
            return (this.errors.email =
                this.form.correo != this.form.confirmar_correo
                    ? "El correo electrónico no coincide"
                    : "");
        }
    },
    methods: {
        getParametroDetalle(FK_Id_Parametro) {
            //5 tipo documento
            //19 localidades
            //53 estratos
            //14 enfoques diferenciales
            axios
                .post("/sif/framework/parametros/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    FK_Id_Parametro: FK_Id_Parametro,
                    programa: "nidos"
                })
                .then(response => {
                    switch (FK_Id_Parametro) {
                        case 5:
                            this.options_tipo_documento = response.data;
                            break;
                        case 14:
                            this.options_enfoque = response.data;
                            break;
                        case 19:
                            this.options_localidad = response.data;
                            break;
                        case 53:
                            this.options_estrato = response.data;
                            break;
                    }
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener la información, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        validarGenero() {
            if (this.form.genero["value"] == 3) {
                this.readonly_otro_genero = false;
                this.required_otro_genero = true;
            } else {
                this.readonly_otro_genero = true;
                this.required_otro_genero = false;
                this.form.otro_genero = null;
            }
        },
        validarOcupacion() {
            if (this.form.ocupacion["value"] == "Otro ¿Cuál?") {
                this.readonly_otra_ocupacion = false;
                this.required_otra_ocupacion = true;
            } else {
                this.readonly_otra_ocupacion = true;
                this.required_otra_ocupacion = false;
                this.form.otra_ocupacion = null;
            }
        },
        validarNivel() {
            this.form.nivel.filter(key => {
                if (key.value == "Otro ¿Cuál?") {
                    this.readonly_otro_nivel = false;
                    this.required_otro_nivel = true;
                } else {
                    this.readonly_otro_nivel = true;
                    this.required_otro_nivel = false;
                    this.form.otro_nivel = null;
                }
            });
        },
        validarVinculacion() {
            if (this.form.tipo_vinculacion["value"] == "Otro ¿Cuál?") {
                this.readonly_otro_tipo_vinculacion = false;
                this.required_otro_tipo_vinculacion = true;
            } else {
                this.readonly_otro_tipo_vinculacion = true;
                this.required_otro_tipo_vinculacion = false;
                this.form.otro_tipo_vinculacion = null;
            }
        },
        getBarriosLocalidad() {
            this.form.barrio_trabajo = "";
            axios
                .post("/sif/framework/getBarriosLocalidad", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    id_localidad: this.form.localidad_trabajo.value
                })
                .then(response => {
                    this.options_barrio = response.data;
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de barrios, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getOfertaActivaFortalecimientoExterno() {
            axios
                .post(
                    "/sif/framework/nidos/fortalecimiento/getOfertaActivaFortalecimientoExterno",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                )
                .then(response => {
                    this.options_modulo_fortalecimiento = response.data;
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de módulos de fortalecimiento, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        guardarSolicitud: function(e) {
            e.preventDefault();
            if (this.form.correo != this.form.confirmar_correo) {
                Swal.fire(
                    "Error",
                    "El correo electrónico no coincide",
                    "error"
                );
            } else if (
                this.form.tipo_documento == "" ||
                this.form.tipo_documento == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el tipo de Identificación",
                    "error"
                );
            } else if (this.form.genero == "" || this.form.genero == null) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el género",
                    "error"
                );
            } else if (
                this.form.sector_social == "" ||
                this.form.sector_social == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el sector social",
                    "error"
                );
            } else if (
                this.form.grupo_etnico == "" ||
                this.form.grupo_etnico == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el grupo étnico",
                    "error"
                );
            } else if (
                this.form.tipo_vinculacion == "" ||
                this.form.tipo_vinculacion == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el tipo de vinculación con la Secretaría de Educación",
                    "error"
                );
            } else if (
                this.form.localidad_trabajo == "" ||
                this.form.localidad_trabajo == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado la localidad donde trabaja",
                    "error"
                );
            } else if (
                this.form.barrio_trabajo == "" ||
                this.form.barrio_trabajo == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el barrio donde trabaja",
                    "error"
                );
            } else if (
                this.form.sitio_trabajo == "" ||
                this.form.sitio_trabajo == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el sitio de trabajo",
                    "error"
                );
            } else if (this.form.nivel == "" || this.form.nivel == null) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el nivel o grado con el que trabaja",
                    "error"
                );
            } else if (
                this.form.ocupacion == "" ||
                this.form.ocupacion == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado la ocupación",
                    "error"
                );
            } else if (
                this.form.modulo_fortalecimiento == "" ||
                this.form.modulo_fortalecimiento == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado el módulo de fortalecimiento",
                    "error"
                );
            } else if (
                this.form.jornada_fortalecimiento == "" ||
                this.form.jornada_fortalecimiento == null
            ) {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado la jornada de fortalecimiento",
                    "error"
                );
            } else {
                axios
                    .post(
                        "/sif/framework/nidos/fortalecimiento/guardarSolicitud",
                        {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                            form: JSON.stringify(this.form)
                        }
                    )
                    .then(response => {
                        Swal.fire(
                            "Éxito",
                            "Su registro se ha completado correctamente",
                            "success"
                        );
                        Object.keys(this.form).forEach(key => {
                            this.form[key] = "";
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
        }
    }
};
</script>
<style type="text/css">
.required:after {
    content: " *";
    color: red;
}
.error {
    color: red;
}
</style>
