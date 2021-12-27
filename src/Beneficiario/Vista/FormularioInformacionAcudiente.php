<form id="form_formulario_registro">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="progress">
      <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
      aria-valuenow="45" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:45%">
      45% Datos Diligenciados
      </div>
    </div>
    <hr>
    <h4 class="modal-title">4. Información Acudiente</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_nombre_acudiente">Nombre Acudiente</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_nombre_acudiente" class="form-control" type="text" placeholder="Nombre Acudiente">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_numero_documento_acudiente">Documento Acudiente</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_numero_documento_acudiente" class="form-control" type="text" placeholder="Número Documento Acudiente">
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="TX_telefono_acudiente">Número Teléfono</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input id="TX_telefono_acudiente" class="form-control" type="text" placeholder="Número Teléfono">
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input data-tipo_accion="anterior" id="BT_submit_anterior" type="submit" class="btn btn-default siguiente_formulario" data-siguiente_formulario="InformacionAcademica" data-formulario_actual="InformacionAcudiente" value="Anterior (3. Información Academica)" >
    <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="Georeferenciacion" data-formulario_actual="InformacionAcudiente" value="Siguiente (5. Georeferenciación)" />
  </div>
</form>