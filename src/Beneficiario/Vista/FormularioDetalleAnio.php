<form id="form_formulario_completar_detalle_anio" action="">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Actualización Detalle Año <?php echo date("Y")?></h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_crea_detalle_anio">CREA</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_crea_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_colegio_detalle_anio">Colegio</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_colegio_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_grado_detalle_anio">Grado</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_grado_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_jornada_detalle_anio">Jornada (Arte Escuela)</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_jornada_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_nombre_acudiente_detalle_anio">Nombre Acudiente</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_nombre_acudiente_detalle_anio" class="form-control" type="text" placeholder="Nombre Acudiente">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_numero_documento_acudiente_detalle_anio">Documento Acudiente</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_numero_documento_acudiente_detalle_anio" class="form-control" type="text" placeholder="Número Documento Acudiente">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_telefono_acudiente_detalle_anio">Número Teléfono</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_telefono_acudiente_detalle_anio" class="form-control" type="text" placeholder="Número Teléfono">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_grupo_poblacional_detalle_anio">Grupo Poblacional</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" data-live-search="true" id="SL_grupo_poblacional_detalle_anio" title="Seleccione un grupo poblacional"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_tipo_afiliacion_detalle_anio">Tipo Afiliación</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" required="" id="SL_tipo_afiliacion_detalle_anio" data-live-search="true">
          <option value="">Ninguna</option>
          <option value="1">Contributivo</option>
          <option value="2">Subsidiado</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_eps_detalle_anio">EPS</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_eps_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_enfermedades_detalle_anio">Enfermedades</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <textarea class="form-control" id="TX_enfermedades_detalle_anio" placeholder="Enfermedades"></textarea>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_localidad_detalle_anio">Localidad de residencia</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_localidad_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_barrio_detalle_anio">Barrio</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_barrio_detalle_anio" class="form-control" required="required" type="text" placeholder="Barrio">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_poblacion_victima_detalle_anio">Población Victima</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" data-live-search="true" id="SL_poblacion_victima_detalle_anio" title="Seleccione un grupo poblacion victima"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_tipo_discapacidad_detalle_anio">Tipo Discapacidad</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" data-live-search="true" id="SL_tipo_discapacidad_detalle_anio" title="Seleccione un tipo de Discapacidad"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_etnia_detalle_anio">Etnia</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" data-live-search="true" id="SL_etnia_detalle_anio" title="Seleccione una etnia"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="IN_estrato_detalle_anio">Estrato</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input required="required" class="form-control" id="IN_estrato_detalle_anio" type="number" value="1" max="6" min="0" placeholder="Estrato">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="IN_puntaje_sisben_detalle_anio">Puntaje Sisben</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input class="form-control" id="IN_puntaje_sisben_detalle_anio" required="required" type="number" value="00.00" min="0" max="100" step=".01" placeholder="Puntaje Sisben">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_area_artistica_interes_detalle_anio">Area Artistica Interes</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" id="SL_area_artistica_interes_detalle_anio" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="CH_area_artistica_interes_experiencia_detalle_anio">¿Tiene experiencia?</label>
      </div>
      <div class="col-xs-6 col-md-6">
        <input data-toggle="toggle" data-onstyle="success" id="CH_area_artistica_interes_experiencia_detalle_anio" name= "CH_area_artistica_interes_experiencia_detalle_anio" data-offstyle="danger" data-on="SÍ TIENE EXPRIENCIA" data-off="NO TIENE EXPERIENCIA" type="checkbox" />
      </div>
    </div>
    <div id="div_tiene_experiencia_detalle_anio">
      <div class="row">
        <div class="col-xs-6 col-md-3">
          <label for="SL_tipo_experiencia_detalle_anio">Tipo de experiencia</label>
        </div>
        <div class="col-xs-12 col-md-9">
          <select class="form-control selectpicker" id="SL_tipo_experiencia_detalle_anio" data-live-search="true">
            <optgroup label="Unica">
              <option value="1">Empirica o autodidacta</option>
              <option value="2">Academica</option>
            </optgroup>
            <optgroup label="Conjunta">
              <option value="3">Emprica o autodidacta y Academica</option>
            </optgroup>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-6 col-md-3">
          <label for="IN_experiencia_anios_detalle_anio">Años de experiencia</label>
        </div>
        <div class="col-xs-12 col-md-9">
          <input class="form-control" id="IN_experiencia_anios_detalle_anio" type="number" value="0" max="50" min="0" placeholder="Años de experiencia">
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <input id="BT_submit_actualizar_detalle_anio" type="submit" class="btn btn-primary" value="Actualizar Detalle Año <?php echo date("Y")?>" />
  </div>
</form>