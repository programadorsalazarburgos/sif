<form id="form_formulario_registro">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="progress">
      <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
      aria-valuenow="15" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:15%">
      15% Datos Diligenciados
      </div>
    </div>
    <hr>
    <h4 class="modal-title">2. Salud</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_tipo_afiliacion">Tipo Afiliación</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_tipo_afiliacion" data-live-search="true">
          <option value="">Ninguna</option>
          <option value="1">Contributivo</option>
          <option value="2">Subsidiado</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_eps">EPS</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_eps" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_grupo_sanguineo">Grupo Sanguineo</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" id="SL_grupo_sanguineo" data-live-search="true" title="Seleccione el grupo sanguineo"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_enfermedades">Enfermedades</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <textarea class="form-control" id="TX_enfermedades" placeholder="Enfermedades"></textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input data-tipo_accion="anterior" id="BT_submit_anterior" type="submit" class="btn btn-default siguiente_formulario" data-siguiente_formulario="DatosPersonales" data-formulario_actual="Salud" value="Anterior (1. Datos Personales)" >
    <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-formulario_actual="Salud" data-siguiente_formulario="InformacionAcademica" value="Siguiente (3. Información Academica)" />
  </div>
</form>