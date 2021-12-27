<form id="form_formulario_registro">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="progress">
      <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
      aria-valuenow="60" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:60%">
      60% Datos Diligenciados
      </div>
    </div>
    <hr>
    <h4 class="modal-title">5. Georeferenciación</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_localidad">Localidad de residencia</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select class="form-control selectpicker" id="SL_localidad" data-live-search="true" title="Seleccione una Localidad" required="required"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_Barrio">Barrio</label>
      </div>
      <div class="col-xs-12 col-md-9">
      <select class="form-control selectpicker" id="SL_Barrio" data-live-search="true" title="Seleccione un Barrio"></select>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_direccion">Dirección</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_direccion" class="form-control" type="text" placeholder="Dirección" required="required">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_email">Correo Electrónico</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_email" class="form-control" type="email" placeholder="Correo Electrónico" required="required">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_telefono_beneficiario">Número Teléfono Fijo</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_telefono_beneficiario" class="form-control" type="text" placeholder="Número Teléfono Fijo">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_celular_beneficiario">Número Celular</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_celular_beneficiario" class="form-control" type="text" placeholder="Número Celular">
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input data-tipo_accion="anterior" id="BT_submit_anterior" type="submit" class="btn btn-default siguiente_formulario" data-siguiente_formulario="InformacionAcudiente" data-formulario_actual="Georeferenciacion" value="Anterior (4. Información Acudiente)" >
    <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="Documentos" data-formulario_actual="Georeferenciacion" value="Siguiente (6. Documentos)" />
  </div>
</form>