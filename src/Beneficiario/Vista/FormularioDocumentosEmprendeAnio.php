<form id="form_formulario_completar_documentos_emprende" enctype="multipart/form-data">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <hr>
  <h4 class="modal-title">Documentos</h4>
</div>
<div class="modal-body">
  <h4>Estos son los documentos que debe tener el Beneficiario</h4>
  <div class="row alert alert-danger">
    <div class="col-xs-12 col-md-6">
      <label for="FILE_archivo_beneficiario_emprende_identificacion">Copia del Documento de Identificación del Estudiante.</label>
    </div>
    <div class="col-xs-12 col-md-6">
      <input id="FILE_archivo_beneficiario_emprende_identificacion" data-tipo_archivo="identificacion" name="FILE_archivo_beneficiario_emprende_identificacion" required="required" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="row alert alert-warning">
    <div class="col-xs-12 col-md-6">
      <label for="FILE_archivo_beneficiario_emprende_recibo_publico">Copia del un Recibo Público (Luz, agua o gas).</label>
    </div>
    <div class="col-xs-12 col-md-6">
      <input id="FILE_archivo_beneficiario_emprende_recibo_publico" data-tipo_archivo="recibo_publico" name="FILE_archivo_beneficiario_emprende_recibo_publico" type="file" class="filestyle" size="2" data-max-size="10240" required="required" runat="server">
    </div>
  </div>
  <div class="row alert alert-success">
    <div class="col-xs-12 col-md-6">
      <label for="FILE_archivo_beneficiario_emprende_eps">Certificado EPS.</label>
    </div>
    <div class="col-xs-12 col-md-6">
      <input id="FILE_archivo_beneficiario_emprende_eps" data-tipo_archivo="eps" name="FILE_archivo_beneficiario_emprende_eps" required="required" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="row alert alert-info">
    <div class="col-xs-12 col-md-6">
      <label for="FILE_archivo_beneficiario_emprende_uso_imagen">Autorización Uso de Imagen.</label>
    </div>
    <div class="col-xs-12 col-md-6">
      <input id="FILE_archivo_beneficiario_emprende_uso_imagen" data-tipo_archivo="uso_imagen" name="FILE_archivo_beneficiario_emprende_uso_imagen" type="file" class="filestyle" size="2" data-max-size="10240" runat="server">
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger" style="padding:5px; border-style: groove;">
    <strong>Estos son los archivos que se van a enviar:</strong><br>
    <div id="archivos_adjuntos_beneficiario_emprende"></div>
  </div>
</div>
<div class="modal-footer">
  <input id="BT_submit_actualizar_documentos_emprende" type="submit" class="btn btn-primary" value="Actualizar Documentos (<?php echo date("Y")?>)" />
</div>
</form>
