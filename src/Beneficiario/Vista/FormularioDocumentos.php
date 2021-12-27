<form id="form_formulario_registro" enctype="multipart/form-data">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div class="progress">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
      aria-valuenow="70" id="progressbar_registro_beneficiario" aria-valuemin="0" aria-valuemax="100" style="width:70%">
      80% Datos Diligenciados
      </div>
  </div>
  <hr>
  <h4 class="modal-title">6. Documentos</h4>
</div>
<div class="modal-body">
  <h4>Estos son los documentos que debe tener el beneficiario</h4>
  <div class="row">
    <div class="col-xs-6 col-md-6">
      <label for="FILE_archivo_beneficiario_identificacion">Copia del Documento de Identificación del Estudiante.</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input id="FILE_archivo_beneficiario_identificacion" data-tipo_archivo="identificacion" name="FILE_archivo_beneficiario_identificacion" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-md-6">
      <label for="FILE_archivo_beneficiario_recibo_publico">Copia del un Recibo Público (Luz, agua o gas).</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input id="FILE_archivo_beneficiario_recibo_publico" data-tipo_archivo="recibo_publico" name="FILE_archivo_beneficiario_recibo_publico" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-md-6">
      <label for="FILE_archivo_beneficiario_eps">Certificado EPS.</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input id="FILE_archivo_beneficiario_eps" data-tipo_archivo="eps" name="FILE_archivo_beneficiario_eps" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-md-6">
      <label for="FILE_archivo_beneficiario_uso_imagen">Autorización Uso de Imagen.</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input id="FILE_archivo_beneficiario_uso_imagen" data-tipo_archivo="uso_imagen" name="FILE_archivo_beneficiario_uso_imagen" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="row" style="padding-top: 10px;">
    <div class="col-xs-6 col-md-3">
      <label for="SL_Autoriza_Uso_Imagen">¿Autoriza uso de Imagen?</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input data-toggle="toggle" data-onstyle="success" id="SL_Autoriza_Uso_Imagen" name= "SL_Autoriza_Uso_Imagen" data-offstyle="danger" data-on="SÍ" data-off="NO" type="checkbox"/>
    </div>
  </div>
  <div class="row" style="padding-top: 10px;">
    <div class="col-xs-6 col-md-3">
      <label for="SL_Autoriza_Uso_Obras">¿Autoriza uso de Obra(s)?</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input data-toggle="toggle" data-onstyle="success" id="SL_Autoriza_Uso_Obras" name= "SL_Autoriza_Uso_Obras" data-offstyle="danger" data-on="SÍ" data-off="NO" type="checkbox"/>
    </div>
  </div>
  <div class="row" style="padding-top: 10px;">
    <div class="col-xs-6 col-md-3">
      <label for="SL_Autoriza_Uso_Datos">¿Autoriza uso de Datos?</label>
    </div>
    <div class="col-xs-6 col-md-6">
      <input data-toggle="toggle" data-onstyle="success" id="SL_Autoriza_Uso_Datos" name= "SL_Autoriza_Uso_Datos" data-offstyle="danger" data-on="SÍ" data-off="NO" type="checkbox"/>
    </div>
  </div>

  <!-- <div id="div_archivo" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <input id="FILE_archivos_beneficiario" name="file[]" type="file" class="filestyle" size="2" data-max-size="10240" runat="server" multiple>
  </div> -->
  
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger" style="padding:5px; border-style: groove;">
    <strong>Estos son los archivos que se van a enviar:</strong><br>
    <div id="archivos_adjuntos_estudiante"></div>
  </div>
</div>
<div class="modal-footer">
  <button data-tipo_accion="anterior" id="BT_submit_anterior" class="btn btn-default siguiente_formulario" data-siguiente_formulario="Georeferenciacion" data-formulario_actual="Documentos">Anterior (5. Georeferenciación)</button>
  <input data-tipo_accion="siguiente" id="BT_submit_siguiente" type="submit" class="btn btn-primary siguiente_formulario" data-siguiente_formulario="ExperienciaArtistica" data-formulario_actual="Documentos" value="Siguiente (7. Experiencia e intereses)" />
</div>
</form>
