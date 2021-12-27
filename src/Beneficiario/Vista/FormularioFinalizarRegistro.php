<form id="form_formulario_registro">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <hr>
    <h4 class="modal-title">Finalizar Registro Beneficiario</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12 col-md-12">
        
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <div class="progress">
      <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
      aria-valuenow="100" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:100%">
      100% Datos Diligenciados
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button data-tipo_accion="anterior" id="BT_submit_anterior" class="btn btn-default siguiente_formulario" data-siguiente_formulario="ExperienciaArtistica" data-formulario_actual="FinalizarRegistro">Anterior (7. Experiencia Artistica)</button>
    <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="intentarRegistrarBeneficiario" data-formulario_actual="FinalizarRegistro" value="Finalizar Registro" />
  </div>
</form>