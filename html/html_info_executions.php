<?php 
  if(empty($generators))
  {
?>
  <div style="margin:20px;">
    <div>
      No hay ningún proceso activo ahora mismo!
    </div>
  </div>
<?php
    exit;
  }
?>

<div style="margin:20px;">
  <div>
    <div><b>PORCENTAGE DE LOS PROCESO ACTTIVOS DEL MEGALODON</b></div>
     <?php 
      $total_executions = 0;
      $total_left = 0;
      $total_created = 0;
      foreach($generators as $generator){
        $total_executions += $generator->pages_to_create;
        $total_left += $generator->pages_left;
      }

      $total_created = $total_executions - $total_left;
      $total_percentage = getPercentage($total_created, $total_executions);

    ?>
    <div>
      Hay un <b><?php echo $total_percentage; ?>%</b> completado! (<small>sobre <b><?php echo count($generators);?> configuraciones</b></small>)
    </div>
    <div>
      Quedan <b><?php echo $total_left; ?> paginas</b> por crear
    </div>
    <div>
      Se han creado <b><?php echo $total_created ; ?> paginas</b> de <b><?php echo $total_executions; ?> paginas</b>
    </div>

    <br/>
    

    <div>
      <div><b>EJECUCIÓN CONFIGURACIÓN ACTUAL</b></div>
      <div>
        Hay un <b><?php echo getPercentage($created_pages, $generator->pages_to_create); ?>%</b> completado!
      </div>
      <div>
        Quedan <b><?php echo $generator_execution->pages_left; ?> paginas</b> por crear
      </div>
      <div>
        Se han creado <b><?php echo $generator_execution->pages_to_create-$generator_execution->pages_left ; ?> paginas</b> de <b><?php echo $generator_execution->pages_to_create; ?> paginas</b>
      </div>
    </div>

    <br/>

    <div>
      Hay <b><?php echo count($generators);?> configuraciones</b>:
      <div style="padding:20px;">
        <?php 
          $i = 1;
          foreach($generators as $generator){
        ?>
            <div><b>Configuración <?php echo $i; echo ($i==1)?" [En execución!]":""?></b></div> 
            <div><b>Titulo de Paginas:</b> <?php echo $generator->name_page; ?></div> 
            <div><b>Meta descripción:</b> <?php echo $generator->desc_page; ?></div> 
            <div><b>Desde:</b> <?php echo $generator->date_desde; ?> - <b>Hasta:</b> <?php echo $generator->date_hasta; ?></div>
            <div><b>Archivo Sinonimos:</b> <?php echo $generator->file_sinonimos; ?></div>
            <div><b>Archivo Descripción Sinonimos:</b> <?php echo $generator->file_desc_sinonimos; ?></div>
            <br/>
        <?php 
            $i++;
          }
  ?>
      </div>
    </div>
  </div>

  <br/>

  
</div>