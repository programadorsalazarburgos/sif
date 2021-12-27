<form id="form_formulario_registro">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="progress">
      <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
      aria-valuenow="1" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:1%">
      1% Datos Diligenciados
      </div>
    </div>
    <hr>
    <h4 class="modal-title">1. Datos Personales</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_numero_documento">Número Documento</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <div class="input-group">
          <input required="required" id="TX_numero_documento" class="form-control" type="text" placeholder="Número Documento">
          <span class="input-group-btn" title="Sin Especificar" id="SPAN_documento_sin_especificar">
            <button class="btn btn-danger" id="BT_documento_sin_especificar" data-tiene_documento="1" type="button">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_tipo_identificacion">Tipo Identificación</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" id="SL_tipo_identificacion" data-live-search="true" title="Seleccione un tipo de Identificación"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_primer_nombre">Primer Nombre</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input required="required" class="form-control" id="TX_primer_nombre" placeholder="Primer Nombre" type="text">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_segundo_nombre">Segundo Nombre</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input class="form-control" id="TX_segundo_nombre" placeholder="Segundo Nombre" type="text">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_primer_apellido">Primer Apellido</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input required="required" class="form-control" id="TX_primer_apellido" placeholder="Primer Apellido" type="text">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_segundo_apellido">Segundo Apellido</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input class="form-control" id="TX_segundo_apellido" placeholder="Segundo Apellido" type="text">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_fecha_nacimiento">Fecha Nacimiento</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <div class="input-group">
          <input required="required" class="form-control readonly" step="1" min="1980-01-01" data-date="1990-01-01" id="TX_fecha_nacimiento" type="text" placeholder="Fecha Nacimiento" value="0000-00-00">
          <span class="input-group-btn" title="Sin Especificar" id="SPAN_fecha_nacimiento_sin_especificar">
            <button class="btn btn-danger" id="BT_fecha_nacimiento_sin_especificar" type="button">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
          </span>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_sexo">Genero</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" data-live-search="true" id="SL_sexo" title="Seleccione un Genero"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_grupo_poblacional">Grupo Poblacional</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" data-live-search="true" id="SL_grupo_poblacional" title="Seleccione un grupo poblacional"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="IN_estrato">Estrato</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input required="required" class="form-control" id="IN_estrato" type="number" value="1" max="6" min="0" placeholder="Estrato">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="IN_puntaje_sisben">Puntaje Sisben</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input class="form-control" id="IN_puntaje_sisben" type="number" value="00.00" min="0" max="100" step=".01" placeholder="Puntaje Sisben">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_nacionalidad">Nacionalidad</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input class="form-control" id="TX_nacionalidad" type="text" placeholder="Nacionalidad" required="required">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_observaciones">Observaciones Adicionales</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <textarea class="form-control" id="TX_observaciones" placeholder="Observaciones Adicionales"></textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="Salud" data-formulario_actual="DatosPersonales" value="Siguiente (2. Salud)" />
  </div>
</form>