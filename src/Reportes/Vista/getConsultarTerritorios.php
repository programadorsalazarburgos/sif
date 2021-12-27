<?php foreach ($this->getVariables()['ConsultaTerritorios'] as $ts): ?>
<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" class="cargar_datos_territorio" data-id_territorio="<?= $ts['Pk_Id_Territorio'] ?>" data-parent="#acordion_territorios" href="#panel_<?= $ts['Pk_Id_Territorio'] ?>">  <?= $ts['Vc_Nom_Territorio'] ?>
          </a>
        </h4>
      </div>
    <div id="panel_<?= $ts['Pk_Id_Territorio'] ?>" class="panel-collapse collapse" data-nombre_territorio="<?= $ts['Vc_Nom_Territorio'] ?>">
      <div class="panel-body">
        <div class="table-responsive" id="div_info_detallada_dupla_<?= $ts['Pk_Id_Territorio'] ?>">
      </div>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
