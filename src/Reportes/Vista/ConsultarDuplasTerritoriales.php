<?php foreach ($this->getVariables()['ConsultaDuplas'] as $ts): ?>
<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" class="cargar_datos_dupla" data-id_dupla="<?= $ts['Pk_Id_Dupla'] ?>" data-parent="#acordion_duplas" href="#panel_<?= $ts['Pk_Id_Dupla'] ?>">Código de Dupla: <?= $ts['VC_Codigo_Dupla'] ?>
          </a>
        </h4>
      </div>
    <div id="panel_<?= $ts['Pk_Id_Dupla'] ?>" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="table-responsive" id="div_info_detallada_dupla_<?= $ts['Pk_Id_Dupla'] ?>">
        </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
