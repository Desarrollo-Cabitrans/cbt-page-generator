<div style="margin:20px;">
  <form method="POST" enctype="multipart/form-data">
    <h3> 
      Escribe el numero maximo de sinonimos en la página
      <br/>
      <small>Es el numero de filas que tiene el archivo de sinonimos.</small>
    </h3>

    <input type="text" name="text_max_row" value="<?php echo $max_row_sinonimos; ?>"/>
    <br/><br/>

    <h3>
      Escribe el numero de combinacion por cada sinonimo
      <br/>
      <small>Es el numero de columnas que tiene el archivo de sinonimos y orden.</small>
    </h3>

    <input type="text" name="text_max_col" value="<?php echo $max_col_sinonimos; ?>"/>
    <br/><br/>

    <h3> 
      Escribe el numero maximo de combinaciones para utilizar
      <br/>
      <small>Es el numero de filas que tiene el archivo de orden de los sinonimos.</small>
    </h3>

    <input type="text" name="text_max_combinations" value="<?php echo $max_combinations_sinonimos; ?>"/>
    <br/><br/>
    <br/>

    <h3> 
      Indice de la Matriz de Orden
      <br/>
      <small>El indice ahora es </small> <?php echo $index_sinonimos; ?>
    </h3>

    <input type="checkbox" name="check_reset_index" /> Marcar si quieres resetear el index del orden de los sinonimos (<small>para que vuelva a empezar desde el principio</small>) 
    <br/>

    <br/><br/>

    <input type="submit" value="Guardar Datos" />
  </form>
</div>



