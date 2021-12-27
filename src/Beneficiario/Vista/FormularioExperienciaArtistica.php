<form id="form_formulario_registro">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div class="progress">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
      aria-valuenow="90" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:90%">
      90% Datos Diligenciados
      </div>
  </div>
  <hr>
  <h4 class="modal-title">7. Intereses y Experiencia</h4>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-xs-6 col-md-3">
      <label for="SL_area_artistica_interes">Area Artistica Interes</label>
    </div>
    <div class="col-xs-12 col-md-9">
      <select required="required" class="form-control selectpicker" id="SL_area_artistica_interes" data-live-search="true"></select>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-md-3">
      <label for="CH_area_artistica_interes_experiencia">¿Tiene experiencia?</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input data-toggle="toggle" data-onstyle="success" id="CH_area_artistica_interes_experiencia" name= "CH_area_artistica_interes_experiencia" data-offstyle="danger" data-on="SÍ TIENE EXPRIENCIA" data-off="NO TIENE EXPERIENCIA" type="checkbox" />
    </div>
  </div>
  <div id="div_tiene_experiencia">
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <label for="SL_tipo_experiencia">Tipo de experiencia</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <select required="required" class="form-control selectpicker" id="SL_tipo_experiencia" data-live-search="true">
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
        <label for="IN_experiencia_anios">Años de experiencia</label>
      </div>
      <div class="col-xs-12 col-md-9">
        <input required="required" class="form-control" id="IN_experiencia_anios" type="number" value="0" max="50" min="0" placeholder="Años de experiencia">
      </div>
  </div>
  </div>
</div>
<div class="modal-footer">
  <button data-tipo_accion="anterior" id="BT_submit_anterior" class="btn btn-default siguiente_formulario" data-siguiente_formulario="Documentos" data-formulario_actual="ExperienciaArtistica">Anterior (6. Documentos)</button>
  <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="FinalizarRegistro" data-formulario_actual="ExperienciaArtistica" value="Siguiente (Finalizar Registro)" />
</div>
</form>
