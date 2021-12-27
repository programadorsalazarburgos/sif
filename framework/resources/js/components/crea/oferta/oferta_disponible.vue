<template>
    <div class="row pt-3">
        <div class="col-lg-10 offset-lg-1 col-md-12 col-xs-12">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a
                        class="nav-link active"
                        id="nav-oferta-abierta-tab"
                        data-toggle="tab"
                        href="#nav-oferta-abierta"
                        role="tab"
                        aria-controls="nav-oferta-abierta"
                        aria-selected="true"
                        @click="
                            localidad_oferta = '';
                            resetInfo();
                        "
                        >Oferta con cupos disponibles</a
                    >
                    <a
                        class="nav-link"
                        id="nav-oferta-completa-tab"
                        data-toggle="tab"
                        href="#nav-oferta-completa"
                        role="tab"
                        aria-controls="nav-oferta-completa"
                        aria-selected="false"
                        @click="
                            localidad_oferta_completa = '';
                            resetInfo();
                        "
                        >Oferta sin cupos disponibles</a
                    >
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="nav-oferta-abierta"
                    role="tabpanel"
                    aria-labelledby="nav-oferta-abierta-tab"
                >
                    <div class="text-center m-2">
                        <img
                            src="https://sif.idartes.gov.co/sif/framework/public/images/banner/banner_preinscripcion.jpg"
                            class="img-fluid"
                        />
                    </div>
                    <form @submit="guardarPreinscripcion">
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label
                                    >Seleccione una localidad para ver la oferta
                                    disponible</label
                                >
                                <multiselect
                                    v-model="localidad_oferta"
                                    label="text"
                                    :options="options_localidad"
                                    @input="
                                        getOptionsOfertaDisponible(
                                            localidad_oferta,
                                            1
                                        )
                                    "
                                    placeholder="Seleccione una opción"
                                    :show-labels="false"
                                    track-by="value"
                                ></multiselect>
                            </div>
                        </div>
                        <transition name="fade">
                            <div class="card card-grupos" v-show="card_grupos">
                                <div class="card-header bg-info">
                                    <i class="fas fa-users"></i> Grupos
                                    disponibles
                                </div>
                                <div
                                    v-for="(info, index) in info_creas"
                                    v-bind:key="index"
                                >
                                    <div class="card-body">
                                        <div
                                            class="p-3 mb-3 bg-light text-white border"
                                        >
                                            <div
                                                class="col-lg-4 offset-lg-4 text-center"
                                            >
                                                <h2>{{ info.crea }}</h2>
                                                <span>{{ info.direccion }}</span
                                                ><br />
                                                <span>{{ info.telefono }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="form-row justify-content-center"
                                        >
                                            <a
                                                href="#"
                                                class="card col-lg-3 col-md-4 col-xs-6 col-sm-6 mr-sm-1 mr-xs-1 mr-lg-1 ml-lg-1"
                                                v-bind:class="grupo.clase"
                                                v-if="
                                                    grupo.id_crea ==
                                                        info.id_crea
                                                "
                                                v-for="(grupo, index) in grupos"
                                                v-bind:key="index"
                                                :data-index="index"
                                                @click="showFormRegister"
                                            >
                                                <div class="card-header">
                                                    <strong>
                                                        {{
                                                            grupo.modalidad_area
                                                        }}</strong
                                                    >
                                                </div>
                                                <div class="card-body">
                                                    <div class="card-text">
                                                        <span
                                                            ><strong
                                                                >Área
                                                                artística:</strong
                                                            >
                                                            {{
                                                                grupo.area_artistica
                                                            }}</span
                                                        ><br />
                                                        <span
                                                            ><strong
                                                                >Modalidad:</strong
                                                            >
                                                            {{
                                                                grupo.modalidad_atencion
                                                            }}</span
                                                        ><br />
                                                        <span
                                                            ><strong
                                                                >Horario:</strong
                                                            >
                                                            {{
                                                                grupo.horario
                                                            }}</span
                                                        ><br />
                                                        <span
                                                            ><strong
                                                                >Descripción:</strong
                                                            >
                                                            {{
                                                                grupo.descripcion.substring(
                                                                    0,
                                                                    80
                                                                ) + "..."
                                                            }}
                                                            <a
                                                                href="#"
                                                                class="ver-mas"
                                                                ><strong
                                                                    >Ver
                                                                    más</strong
                                                                ></a
                                                            ></span
                                                        ><br />
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>
                        <transition-group name="slide-fade" tag="div">
                            <div
                                class="card"
                                key="card-info-grupo"
                                v-show="card_info_grupo"
                            >
                                <div class="card-header bg-info">
                                    <i class="fas fa-info fa-2x"></i>
                                    Información del grupo
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-lg-7">
                                            <p>
                                                <i
                                                    class="fas fa-book fa-2x"
                                                ></i>
                                                <span style="font-size: 30px;"
                                                    ><strong
                                                        >Descripción</strong
                                                    ></span
                                                >
                                            </p>
                                            <p>{{ form.descripcion }}</p>
                                        </div>
                                        <div class="form-group col-lg-5">
                                            <p>
                                                <i
                                                    class="fas fa-play fa-2x"
                                                ></i>
                                                {{ form.modalidad_area }}
                                            </p>
                                            <p>
                                                <i
                                                    class="fas fa-map-marker-alt fa-2x"
                                                ></i>
                                                {{ form.lugar }}
                                            </p>
                                            <p>
                                                <i
                                                    class="fas fa-clock fa-2x"
                                                ></i>
                                                {{ form.horario }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-right">
                                        <a href="#" @click="showCardGrupos()"
                                            >Regresar a la selección de
                                            grupos</a
                                        >
                                    </div>
                                </div>
                            </div>
                            <div
                                key="card-form-beneficiarios"
                                v-show="card_info_benficiario"
                            >
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <i class="fas fa-user fa-2x"></i>
                                        Información personal
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Tipo de documento</label
                                                >
                                                <multiselect
                                                    v-model="
                                                        form.tipo_documento
                                                    "
                                                    label="text"
                                                    :options="
                                                        options_tipo_documento
                                                    "
                                                    placeholder="Seleccione una opción"
                                                    :show-labels="false"
                                                    track-by="value"
                                                ></multiselect>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Número de documento</label
                                                >
                                                <input
                                                    v-model="
                                                        form.numero_documento
                                                    "
                                                    class="form-control"
                                                    type="number"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Primer nombre</label
                                                >
                                                <input
                                                    v-model="form.primer_nombre"
                                                    class="form-control"
                                                    type="text"
                                                    required
                                                    @input="
                                                        form.primer_nombre = form.primer_nombre.toUpperCase()
                                                    "
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Segundo nombre</label>
                                                <input
                                                    v-model="
                                                        form.segundo_nombre
                                                    "
                                                    class="form-control"
                                                    type="text"
                                                    @input="
                                                        form.segundo_nombre = form.segundo_nombre.toUpperCase()
                                                    "
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Primer apellido</label
                                                >
                                                <input
                                                    v-model="
                                                        form.primer_apellido
                                                    "
                                                    class="form-control"
                                                    type="text"
                                                    required
                                                    @input="
                                                        form.primer_apellido = form.primer_apellido.toUpperCase()
                                                    "
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Segundo apellido</label>
                                                <input
                                                    v-model="
                                                        form.segundo_apellido
                                                    "
                                                    class="form-control"
                                                    type="text"
                                                    @input="
                                                        form.segundo_apellido = form.segundo_apellido.toUpperCase()
                                                    "
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Fecha de nacimiento</label
                                                >
                                                <input
                                                    v-model="
                                                        form.fecha_nacimiento
                                                    "
                                                    class="form-control"
                                                    type="date"
                                                    v-bind:max="hoy"
                                                    required
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Dirección</label
                                                >
                                                <input
                                                    v-model="form.direccion"
                                                    class="form-control"
                                                    type="text"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Correo</label
                                                >
                                                <input
                                                    v-model="form.correo"
                                                    class="form-control"
                                                    type="email"
                                                    required
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Confirmar correo</label
                                                >
                                                <input
                                                    v-model="
                                                        form.confirmar_correo
                                                    "
                                                    class="form-control"
                                                    type="email"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label>Teléfono fijo</label>
                                                <input
                                                    v-model="form.telefono_fijo"
                                                    class="form-control"
                                                    type="number"
                                                />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Celular</label
                                                >
                                                <input
                                                    v-model="form.celular"
                                                    class="form-control"
                                                    type="number"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Localidad</label
                                                >
                                                <multiselect
                                                    v-model="form.localidad"
                                                    label="text"
                                                    :options="options_localidad"
                                                    placeholder="Seleccione una opción"
                                                    :show-labels="false"
                                                    track-by="value"
                                                ></multiselect>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Barrio</label
                                                >
                                                <input
                                                    v-model="form.barrio"
                                                    class="form-control"
                                                    type="text"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Género</label
                                                >
                                                <multiselect
                                                    v-model="form.genero"
                                                    label="text"
                                                    :options="options_genero"
                                                    placeholder="Seleccione una opción"
                                                    :show-labels="false"
                                                    track-by="value"
                                                >
                                                </multiselect>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="required"
                                                    >Estrato</label
                                                >
                                                <multiselect
                                                    v-model="form.estrato"
                                                    label="text"
                                                    :options="options_estrato"
                                                    placeholder="Seleccione una opción"
                                                    :show-labels="false"
                                                    track-by="value"
                                                ></multiselect>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <label class="required"
                                                    >Grupo poblacional</label
                                                >
                                                <multiselect
                                                    v-model="
                                                        form.grupo_poblacional
                                                    "
                                                    label="text"
                                                    :options="
                                                        options_grupo_poblacional
                                                    "
                                                    placeholder="Seleccione una opción"
                                                    :show-labels="false"
                                                    track-by="value"
                                                ></multiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <i class="fas fa-book fa-2x"></i>
                                        Documentación
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <label class="required"
                                                    >Fotocopia del documento de
                                                    identidad
                                                    <i
                                                        class="far fa-question-circle"
                                                        style="color:#00adff"
                                                        data-html="true"
                                                        data-toggle="tooltip"
                                                        data-placement="right"
                                                        title="En este espacio necesitamos que subas la imagen de tu documento de identidad por ambas caras, ten en cuenta que esta debe ser legible para poder hacer el registro en el formulario de inscripción. 1. Si eres ciudadano de nacionalidad venezolana, junta el P.E.P. (Permiso Especial de Permanencia) y el pasaporte en una sola imagen, esta debe ser legible para poder hacer el registro en el formulario de inscripción. 2. Si eres ciudadano extranjero debes cargar la imagen de tu pasaporte, recuerda que debe ser legible para poder hacer el registro en el formulario de inscripción. Se permiten archivos de imagen (jpg, jpeg, png) y archivos pdf."
                                                    ></i
                                                ></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-input"
                                                            id="archivoDocumentoIdentidad"
                                                            @change="
                                                                onFileChange
                                                            "
                                                            accept="application/pdf, image/jpg, image/jpeg, image/"
                                                            required
                                                        />
                                                        <label
                                                            class="custom-file-label"
                                                            >{{
                                                                label_archivo_documento_identidad
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label class="required"
                                                    >Certificado afiliación a
                                                    salud
                                                    <i
                                                        class="far fa-question-circle"
                                                        style="color:#00adff"
                                                        data-html="true"
                                                        data-toggle="tooltip"
                                                        data-placement="right"
                                                        title="Aquí debes cargar la certificación de afiliación al sistema de salud, donde aparezca tu estado como activo, ten en cuenta que esta no debe tener fecha de expedición, mayor a 1 mes. En caso de estar en proceso de afiliación, puedes cargar la carta de visita del SISBEN, esta es válida mientras sale tu certificación. Se permiten archivos de imagen (jpg, jpeg, png) y archivos pdf."
                                                    ></i
                                                ></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-input"
                                                            id="archivoEps"
                                                            @change="
                                                                onFileChange
                                                            "
                                                            accept="application/pdf, image/jpg, image/jpeg, image/"
                                                            required
                                                        />
                                                        <label
                                                            class="custom-file-label"
                                                            >{{
                                                                label_archivo_eps
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label class="required"
                                                    >Recibo servicio público
                                                    (Luz, agua o gas)
                                                    <i
                                                        class="far fa-question-circle"
                                                        style="color:#00adff"
                                                        data-html="true"
                                                        data-toggle="tooltip"
                                                        data-placement="right"
                                                        title="Puedes cargar cualquier recibo público pero ten en cuenta que la imagen debe contener la dirección de residencia y el estrato, esto para identificar tu cercanía al centro de formación. Se permiten archivos de imagen (jpg, jpeg, png) y archivos pdf."
                                                    ></i
                                                ></label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input
                                                            type="file"
                                                            class="custom-file-input"
                                                            id="archivoReciboPublico"
                                                            @change="
                                                                onFileChange
                                                            "
                                                            accept="application/pdf, image/jpg, image/jpeg, image/png"
                                                            required
                                                        />
                                                        <label
                                                            class="custom-file-label"
                                                            >{{
                                                                label_archivo_recibo_publico
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <i class="fas fa-handshake fa-2x"></i>
                                        Políticas
                                    </div>
                                    <div class="card-body">
                                        <!-- <div class="form-row">
									<div class="form-group col-lg-12">
										<h2>Autorización de uso de imagen y obras</h2>
										<p>Autorizo obrando en mi propio nombre, Por medio del presente documento, autorizo de manera voluntaria, previa, explícita, informada e inequívoca al Instituto Distrital de las Artes – Idartes para hacer uso de: la imagen, entrevista y/o material multimedia producidos en el desarrollo de las actividades y/o proyectos que promueve la entidad, los cuales no generan una retribución económica para el instituto.</p>
										<p>La presente autorización se enmarca en virtud de los derechos de imagen que me reconocen la normatividad vigente.</p>
										<p>Acepto que la reproducción del material, se realiza sin ánimo de lucro y constituye memoria institucional y comunicación pública para los fines y propósitos establecidos por la entidad.</p>
										<p>Los derechos aquí autorizados se dan sin limitación geográfica o territorial alguna. De igual forma la autorización de uso aquí establecida no implicará exclusividad, por lo que me reservo el derecho de otorgar autorizaciones de uso similares en los mismos términos en favor de terceros. El derecho de uso de imagen que se autoriza, no comporta ningún reconocimiento económico a mi favor.</p>
										<p>Siendo titular de los derechos de autor de las obras artísticas creadas en el marco del programa Crea del Idartes, autorizo al Instituto Distrital de las Artes - IDARTES, a que las utilice para la edición y publicación, en formato impreso y digital, en Colombia, y para que sea difundido sin valor comercial.</p>
										<p>Manifiesto que es de mi interés contribuir con los objetivos culturales y la misionalidad del IDARTES, razón por la cual la presente autorización de uso de todos los productos artísticos realizados por mi o en los que he participado, se realiza a título gratuito y no se pacta ningún emolumento como contraprestación económica de la cesión. Así mismo, en los aspectos no contemplados en el presente acto de cesión, se entenderá que se aplicará lo señalado en la Ley 23 de 1982 y/o las normas colombianas que la modifiquen o adicionen.</p>	
									</div>
								</div>
								<div class="form-row justify-content-center">
									<div class="form-group">
										<div class="custom-control custom-radio custom-control-inline">
											<input v-model="form.autorizacion_imagen" value="1" type="radio" id="radioButtonAutorizaUsoImagen" name="imagen" class="custom-control-input"">
											<label class="custom-control-label" for="radioButtonAutorizaUsoImagen">Si acepto la autorización de uso de imagen y obras</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input v-model="form.autorizacion_imagen" value="0" type="radio" id="radioButtonNoAutorizaUsoImagen" name="imagen" class="custom-control-input"">
											<label class="custom-control-label" for="radioButtonNoAutorizaUsoImagen">No acepto la autorización de uso de imagen y obras</label>
										</div>
									</div>
								</div> -->
                                        <div class="form-row">
                                            <div class="form-group col-lg-12">
                                                <h2>
                                                    Seguridad de la información
                                                    y protección de datos
                                                    personales.
                                                </h2>
                                                <p>
                                                    Al leer y aceptar el
                                                    presente comunicado,
                                                    considero y autorizo de
                                                    manera libre, previa,
                                                    expresa, voluntaria,
                                                    inequívoca y debidamente
                                                    informado, que mis datos
                                                    personales sean tratados
                                                    conforme a los previsto en
                                                    el presente documento y
                                                    manual de política de
                                                    seguridad de la información
                                                    del sitio web en materia de
                                                    datos personales y
                                                    protección de datos
                                                    personales recaudados en las
                                                    bases de datos creadas en la
                                                    entidad establecido por el
                                                    Idartes, el cual puede ser
                                                    consultado
                                                    <a
                                                        href="https://idartes.gov.co/sites/default/files/inline-files/Manual%20de%20Politica%20de%20seguridad%20de%20la%20informaci%C3%B3n%20Web%20-2017.pdf"
                                                        >Aquí</a
                                                    >
                                                </p>
                                                <a
                                                    href="https://idartes.gov.co/sites/default/files/inline-files/Manual%20de%20Politica%20de%20seguridad%20de%20la%20informaci%C3%B3n%20Web%20-2017.pdf"
                                                    >Manual de Seguridad de la
                                                    información y protección de
                                                    datos personales.</a
                                                >
                                            </div>
                                        </div>
                                        <div
                                            class="form-row justify-content-center"
                                        >
                                            <div class="form-group">
                                                <div
                                                    class="custom-control custom-radio custom-control-inline"
                                                >
                                                    <input
                                                        v-model="
                                                            form.autorizacion_datos
                                                        "
                                                        value="1"
                                                        type="radio"
                                                        id="radioButtonAutorizaDatos"
                                                        name="datos"
                                                        class="custom-control-input"
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="radioButtonAutorizaDatos"
                                                        >Si acepto la
                                                        información y protección
                                                        de datos
                                                        personales</label
                                                    >
                                                </div>
                                                <div
                                                    class="custom-control custom-radio custom-control-inline"
                                                >
                                                    <input
                                                        v-model="
                                                            form.autorizacion_datos
                                                        "
                                                        value="0"
                                                        type="radio"
                                                        id="radioButtonNoAutorizaDatos"
                                                        name="datos"
                                                        class="custom-control-input"
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="radioButtonNoAutorizaDatos"
                                                        >No acepto la
                                                        información y protección
                                                        de datos
                                                        personales</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-8 offset-lg-2">
                                    <button
                                        class="btn btn-block btn-primary"
                                        type="submit"
                                    >
                                        Preinscribirse
                                    </button>
                                </div>
                            </div>
                        </transition-group>
                    </form>
                </div>
                <div
                    class="tab-pane fade"
                    id="nav-oferta-completa"
                    role="tabpanel"
                    aria-labelledby="nav-oferta-completa-tab"
                >
                    <div class="pt-2">
                        <div class="form-row">
                            <div class="form-group col-lg-12">
                                <label
                                    >Seleccione una localidad para ver la oferta
                                    completa</label
                                >
                                <multiselect
                                    v-model="localidad_oferta_completa"
                                    label="text"
                                    :options="options_localidad"
                                    @input="
                                        getOptionsOfertaDisponible(
                                            localidad_oferta_completa,
                                            0
                                        )
                                    "
                                    placeholder="Seleccione una opción"
                                    :show-labels="false"
                                    track-by="value"
                                ></multiselect>
                            </div>
                        </div>
                    </div>

                    <transition name="fade">
                        <div
                            class="card card-grupos"
                            v-show="card_grupos_oferta_completa"
                        >
                            <div class="card-header bg-info">
                                <i class="fas fa-users"></i> Grupos
                            </div>
                            <div
                                v-for="(info, index) in info_creas"
                                v-bind:key="index"
                            >
                                <div class="card-body">
                                    <div
                                        class="p-3 mb-3 bg-light text-white border"
                                    >
                                        <div
                                            class="col-lg-4 offset-lg-4 text-center"
                                        >
                                            <h2>{{ info.crea }}</h2>
                                            <span>{{ info.direccion }}</span
                                            ><br />
                                            <span>{{ info.telefono }}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="form-row justify-content-center"
                                    >
                                        <a
                                            href="javascript:void(0);"
                                            class="card col-lg-3 col-md-4 col-xs-6 col-sm-6 mr-sm-1 mr-xs-1 mr-lg-1 ml-lg-1"
                                            v-bind:class="grupo.clase"
                                            v-if="grupo.id_crea == info.id_crea"
                                            v-for="(grupo, index) in grupos"
                                            v-bind:key="index"
                                            :data-index="index"
                                        >
                                            <div class="card-header">
                                                <strong>
                                                    {{
                                                        grupo.modalidad_area
                                                    }}</strong
                                                >
                                            </div>
                                            <div class="card-body">
                                                <div class="card-text">
                                                    <span
                                                        ><strong
                                                            >Área
                                                            artística:</strong
                                                        >
                                                        {{
                                                            grupo.area_artistica
                                                        }}</span
                                                    ><br />
                                                    <span
                                                        ><strong
                                                            >Modalidad:</strong
                                                        >
                                                        {{
                                                            grupo.modalidad_atencion
                                                        }}</span
                                                    ><br />
                                                    <span
                                                        ><strong
                                                            >Horario:</strong
                                                        >
                                                        {{
                                                            grupo.horario
                                                        }}</span
                                                    ><br />
                                                    <span
                                                        ><strong
                                                            >Descripción:</strong
                                                        >
                                                        {{
                                                            grupo.descripcion.substring(
                                                                0,
                                                                200
                                                            ) + "..."
                                                        }} </span
                                                    ><br />
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// require( 'jszip' );
// require( 'datatables.net-dt' );
// require( 'datatables.net-buttons-dt' );
// require( 'datatables.net-buttons/js/buttons.html5.js' );
// require( 'datatables.net-responsive-dt' );

import Multiselect from "vue-multiselect";

export default {
    components: { Multiselect },
    data() {
        return {
            //variables formulario
            form: {
                tipo_documento: null,
                numero_documento: null,
                primer_nombre: null,
                segundo_nombre: null,
                primer_apellido: null,
                segundo_apellido: null,
                fecha_nacimiento: null,
                direccion: null,
                correo: null,
                confirmar_correo: null,
                telefono_fijo: null,
                celular: null,
                localidad: null,
                barrio: null,
                genero: null,
                estrato: null,
                grupo_poblacional: null,
                archivo_documento_identidad: "",
                archivo_eps: "",
                archivo_recibo_publico: "",
                autorizacion_imagen: 0,
                autorizacion_datos: null,
                grupo: "",
                modalidad_area: "",
                lugar: "",
                horario: "",
                descripcion: "",
                telefono_lugar: "",
                correo_crea: ""
            },

            //variables para opciones de listado
            options_tipo_documento: [],
            options_estrato: [],
            options_localidad: [],
            options_grupo_poblacional: [],
            options_genero: [],
            grupos: [],
            grupos_cerrados: [],

            //variables funcionamiento del formulario
            info_creas: [],
            card_grupos: false,
            card_grupos_oferta_completa: false,
            card_info_benficiario: false,
            card_info_grupo: false,
            localidad_oferta: "",
            localidad_oferta_completa: "",
            hoy: "",
            label_archivo_documento_identidad: "Seleccionar archivo",
            label_archivo_eps: "Seleccionar archivo",
            label_archivo_recibo_publico: "Seleccionar archivo"
        };
    },
    mounted() {
        var date = new Date();
        var month;
        var day;

        if (date.getMonth() + 1 < 10) month = "0" + (date.getMonth() + 1);
        else month = date.getMonth() + 1;

        if (date.getDate() < 10) day = "0" + date.getDate();
        else day = date.getDate();

        this.hoy = date.getFullYear() + "-" + month + "-" + day;

        //this.getLocalidadesOfertaDisponible();
        this.getParametroDetalle(5);
        this.getParametroDetalle(14);
        this.getParametroDetalle(17);
        this.getParametroDetalle(19);
        this.getParametroDetalle(53);
    },
    methods: {
        // getLocalidadesOfertaDisponible(){
        // 	axios
        // 	.post("/sif/framework/crea/territorial/oferta/getLocalidadesOfertaDisponible", {
        // 		"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        // 		id_localidad: this.localidad_oferta["value"]
        // 	})
        // 	.then(response => {
        // 		this.options_localidad_oferta_disponible = response.data;
        // 	})
        // 	.catch(error => {
        // 		Swal.fire("Error", "No se pudo obtener el listado de oferta disponible, por favor inténtelo nuevamente", "error");
        // 	});
        // },
        getOptionsOfertaDisponible(localidad, abierto_publico) {
            this.resetInfo();
            axios
                .post(
                    "/sif/framework/crea/territorial/oferta/getOptionsOfertaDisponible",
                    {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        id_localidad: localidad.value,
                        abierto_publico: abierto_publico
                    }
                )
                .then(response => {
                    if (response.data.length > 0) {
                        if (abierto_publico) {
                            this.card_grupos = true;
                        } else {
                            this.card_grupos_oferta_completa = true;
                        }
                    }

                    let crea = 0;
                    response.data.forEach((value, index) => {
                        let horario_temp = "";
                        let clase = "";

                        if (value["crea"]["PK_Id_Clan"] != crea) {
                            this.info_creas.push({
                                id_crea: value["crea"]["PK_Id_Clan"],
                                crea: value["crea"]["VC_Nom_Clan"],
                                direccion: value["crea"]["VC_Direccion_Clan"],
                                telefono: value["crea"]["VC_Telefono_Clan"]
                            });
                        }
                        crea = value["crea"]["PK_Id_Clan"];

                        switch (value["area_artistica"]["FK_Value"]) {
                            case 1:
                                clase = "danza";
                                break;
                            case 2:
                                clase = "musica";
                                break;
                            case 3:
                                clase = "artes-plasticas";
                                break;
                            case 4:
                                clase = "literatura";
                                break;
                            case 5:
                                clase = "teatro";
                                break;
                            case 6:
                                clase = "audiovisuales";
                                break;
                            case 8:
                                clase = "artes-electronicas";
                                break;
                        }

                        this.grupos.push({
                            id_crea: value["crea"]["PK_Id_Clan"],
                            id_grupo: value["PK_Grupo"],
                            crea: value["crea"]["VC_Nom_Clan"],
                            direccion: value["crea"]["VC_Direccion_Clan"],
                            telefono: value["crea"]["VC_Telefono_Clan"],
                            area_artistica:
                                value["area_artistica"]["VC_Descripcion"],
                            clase: clase,
                            horario: "",
                            descripcion: value["TX_observaciones"],
                            modalidad_area:
                                value["modalidad_artistica"][
                                    "VC_Nom_Modalidad"
                                ],
                            modalidad_atencion: value["IN_modalidad_atencion"],
                            correo_crea:
                                value["crea"]["VC_Correo_Administrador"]
                        });

                        value["horarios"].forEach((value, index) => {
                            horario_temp =
                                horario_temp +
                                value["IN_dia"] +
                                " de " +
                                value["TI_hora_inicio_clase"].slice(0, -3) +
                                " a " +
                                value["TI_hora_fin_clase"].slice(0, -3) +
                                " y ";
                        });

                        this.grupos[index]["horario"] = horario_temp.slice(
                            0,
                            -3
                        );
                    });
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de oferta disponible, por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        getParametroDetalle(FK_Id_Parametro) {
            //5 tipo documento
            //14 grupo poblacional
            //17 género
            //19 localidades
            //53 estratos
            axios
                .post("/sif/framework/options/getParametroDetalle", {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    FK_Id_Parametro: FK_Id_Parametro
                })
                .then(response => {
                    let tipo_listado;
                    switch (FK_Id_Parametro) {
                        case 5:
                            this.options_tipo_documento = response.data;
                            tipo_listado = "tipos de documento";
                            break;
                        case 14:
                            this.options_grupo_poblacional = response.data;
                            tipo_listado = "grupos poblacional";
                            break;
                        case 17:
                            this.options_genero = response.data;
                            tipo_listado = "géneros";
                            break;
                        case 19:
                            this.options_localidad = response.data;
                            tipo_listado = "localidades";
                            break;
                        case 53:
                            this.options_estrato = response.data;
                            tipo_listado = "estratos";
                            break;
                    }
                })
                .catch(error => {
                    Swal.fire(
                        "Error",
                        "No se pudo obtener el listado de " +
                            tipo_listado +
                            ", por favor inténtelo nuevamente",
                        "error"
                    );
                });
        },
        showFormRegister: function(e) {
            this.card_grupos = false;
            this.card_info_grupo = true;
            this.card_info_benficiario = true;
            this.form.id_grupo = this.grupos[
                e.currentTarget.getAttribute("data-index")
            ]["id_grupo"];
            this.form.lugar =
                this.grupos[e.currentTarget.getAttribute("data-index")][
                    "crea"
                ] +
                " - " +
                this.grupos[e.currentTarget.getAttribute("data-index")][
                    "direccion"
                ];
            this.form.telefono_lugar = this.grupos[
                e.currentTarget.getAttribute("data-index")
            ]["telefono"];
            this.form.horario = this.grupos[
                e.currentTarget.getAttribute("data-index")
            ]["horario"];
            this.form.modalidad_area = this.grupos[
                e.currentTarget.getAttribute("data-index")
            ]["modalidad_area"];
            this.form.descripcion = this.grupos[
                e.currentTarget.getAttribute("data-index")
            ]["descripcion"];
            this.form.correo_crea = this.grupos[
                e.currentTarget.getAttribute("data-index")
            ]["correo_crea"];
        },
        showCardGrupos() {
            this.card_grupos = true;
            this.card_info_grupo = false;
            this.card_info_benficiario = false;
        },
        onFileChange: function(e) {
            switch (e.target.getAttribute("id")) {
                case "archivoDocumentoIdentidad":
                    this.form.archivo_documento_identidad = e.target.files[0];
                    this.label_archivo_documento_identidad =
                        e.target.files[0].name;
                    break;
                case "archivoEps":
                    this.form.archivo_eps = e.target.files[0];
                    this.label_archivo_eps = e.target.files[0].name;
                    break;
                case "archivoReciboPublico":
                    this.form.archivo_recibo_publico = e.target.files[0];
                    this.label_archivo_recibo_publico = e.target.files[0].name;
                    break;
            }
        },
        resetInfo() {
            this.info_creas = [];
            this.grupos = [];
            this.card_grupos = false;
            this.card_grupos_oferta_completa = false;
            this.card_info_grupo = false;
            this.card_info_benficiario = false;
        },
        guardarPreinscripcion: function(e) {
            e.preventDefault();

            if (this.form.tipo_documento == "") {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado su tipo de documento",
                    "error"
                );
            } else if (this.form.localidad == "") {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado su localidad de residencia",
                    "error"
                );
            } else if (this.form.genero == "") {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado su género",
                    "error"
                );
            } else if (this.form.estrato == "") {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado su estrato de su residencia",
                    "error"
                );
            } else if (this.form.grupo_poblacional == "") {
                Swal.fire(
                    "Error",
                    "Compruebe que ha seleccionado su grupo poblacional",
                    "error"
                );
            } else if (this.form.correo != this.form.confirmar_correo) {
                Swal.fire(
                    "Error",
                    "El correo electrónico no coincide",
                    "error"
                );
            } else {
                Swal.fire({
                    title: "Guardando preinscripción",
                    text: "Espere un poco por favor.",
                    imageUrl: "/sif/framework/public/images/cargando.gif",
                    imageWidth: 140,
                    imageHeight: 70,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false
                });

                let config = {
                    headers: { "content-type": "multipart/form-data" }
                };
                let datos = new FormData();

                let json = JSON.stringify(this.form);

                datos.append("data", json);
                datos.append(
                    "archivo_documento_identidad",
                    this.form.archivo_documento_identidad
                );
                datos.append("archivo_eps", this.form.archivo_eps);
                datos.append(
                    "archivo_recibo_publico",
                    this.form.archivo_recibo_publico
                );

                axios
                    .post(
                        "/sif/framework/crea/territorial/oferta/guardarPreinscripcion",
                        datos,
                        config
                    )
                    .then(response => {
                        Swal.close();
                        Swal.fire(
                            "Éxito",
                            "Se ha guardado la preinscripción correctamente, por favor revisa tu correo electrónico",
                            "success"
                        );
                        this.card_info_grupo = false;
                        this.card_info_benficiario = false;
                        this.localidad_oferta = "";
                        this.label_archivo_documento_identidad =
                            "Seleccionar archivo";
                        this.label_archivo_eps = "Seleccionar archivo";
                        this.label_archivo_recibo_publico =
                            "Seleccionar archivo";
                        Object.keys(this.form).forEach(key => {
                            this.form[key] = "";
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            "Error",
                            "No se pudo almacenar la información, por favor inténtelo nuevamente",
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
.card-grupos .danza {
    background-color: #e8ac00;
}
.card-grupos .musica {
    background-color: #a3211f;
}
.card-grupos .teatro {
    background-color: #fa5551;
}
.card-grupos .literatura {
    background-color: #0077bb;
}
.card-grupos .artes-plasticas {
    background-color: #01c3de;
}
.card-grupos .audiovisuales {
    background-color: #648101;
}
.card-grupos .artes-electronicas {
    background-color: #93b401;
}
.card-grupos a {
    color: white;
    min-height: 230px;
    border-radius: 10px;
    font-size: 14px;
}
.card-grupos a:hover {
    text-decoration: none;
    color: white;
    box-shadow: 0 5px 15px 0 rgba(0, 0, 0, 0.3);
}
.card-grupos .ver-mas:hover {
    text-decoration: underline;
    box-shadow: none;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
.slide-fade-enter-active {
    transition: all 2s ease;
}
.slide-fade-leave-active {
    transition: all 1s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}
</style>
