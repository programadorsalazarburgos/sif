<form id="form_formulario_registro">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="progress">
      <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
      aria-valuenow="30" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:30%">
      30% Datos Diligenciados
      </div>
    </div>
    <hr>
    <h4 class="modal-title">3. Información Academica</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_crea_registro_beneficiario">CREA</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_crea_registro_beneficiario" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_colegio_registro_beneficiario">Colegio</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_colegio_registro_beneficiario" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_jornada_registro_beneficiario">Jornada (Arte Escuela)</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_jornada_registro_beneficiario" data-live-search="true"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_grado_registro_beneficiario">Grado</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_grado_registro_beneficiario" data-live-search="true"></select>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input data-tipo_accion="anterior" id="BT_submit_anterior" type="submit" class="btn btn-default siguiente_formulario" data-siguiente_formulario="Salud" data-formulario_actual="InformacionAcademica" value="Anterior (2. Salud)" >
    <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="InformacionAcudiente" data-formulario_actual="InformacionAcademica" value="Siguiente (4. Infomación Acudiente)" />
  </div>
</form>