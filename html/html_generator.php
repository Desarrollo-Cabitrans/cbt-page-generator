<div style="margin:20px;">
  <?php
    if(!$is_error_generate_page ){
  ?>
    <?php
      if($is_generate_page ){
    ?>
      <h1>Todas las paginas se han generado correctamente !</h1>
      <h3>Se han generado <?php echo $num_page; ?> paginas</h3>
      <button onClick="window.location.reload();">Haz click para ir a generar mas paginas</button>
    <?php
      }else{ 
    ?>
      <form method="post" enctype="multipart/form-data">
        <h1>Generar Paginas</h1><br/>
        <h3> Sube el CSV de las Ciudades</h3>
          <input type="file" name="file_city" class="dropify" data-allowed-file-extensions="csv" />
          <br/><br/>
          <input type="submit" value="Generar Paginas"/>
      </from>
    <?php
      }
    ?>
  <?php
    }
  ?>

  <?php
    if($is_error_generate_page){
  ?>
  <h3>Ha habido un error al generar paginas</h3>
  <?php
    }
  ?>
</div>



