<?php
  $dato = $this->getVariables();
  $return = "<div class='row'>";
  $return .= "<br>";
  $return .= "<div class='total_lugares col-xs-8 col-xs-offset-2 col-md-3 col-md-offset-2 alert alert-info' role='alert'>";
  $return .= "<center><strong>Total lugares de atención</strong><br>" . $dato['total_lugares']."</center>";
  $return .= "</div>";

  $return .= "<div class='total_duplas col-xs-8 col-xs-offset-2 col-md-3 col-md-offset-2 alert alert-success' role='alert'>";
  $return .= "<center><strong>Total duplas</strong><br>" . $dato['total_duplas']."</center>";
  $return .= "</div>";

  $return .= "<div class='total_grupos col-xs-8 col-xs-offset-2 col-md-3 col-md-offset-2 alert alert-danger' role='alert'>";
  $return .= "<center><strong>Total grupos</strong><br>" . $dato['total_grupos']."</center>";
  $return .= "</div>";

  $return .= "<div class='total_beneficiarios col-xs-8 col-xs-offset-2 col-md-3 col-md-offset-2 alert alert-warning' role='alert'>";
  $return .= "<center><strong>Total de beneficiarios</strong><br>" . $dato['total_beneficiarios']."</center>";
  $return .= "</div>";

  $return .= "</div>";
echo $return;
