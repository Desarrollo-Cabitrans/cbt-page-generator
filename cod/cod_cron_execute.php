<?php 

  $num_total_created = rbk_cron_execution();

  if($num_total_created == 0)
  {
    echo "No se ha creado ninguna pagina! Puede que no se haya lanzado el generador";
  }
  else
  {
    echo "Se han creado ".$num_total_created." paginas";
  }