<div style="margin:20px;">
  <form method="POST" enctype="multipart/form-data">
    <div class="half">
      <h3> Escribe el id de la pagina que quieres utilizar como plantilla (Usa ELEMENTOR)</h3>
      <input type="text" name="text_id_template" value="<?php echo $id_template; ?>"/>
    </div>

    <div class="half">
      <h3> Escribe el ID de la categoria del post</h3>
      <input type="text" name="text_id_parent" value="<?php echo $id_parent; ?>"/>
    </div>

    <div style="clear:both"></div>


    <h3> Escribe el nombre de como se llamaran las paginas <small> (pon [Texto_Ciudad] donde quieras que vaya el nombre de la ciudad) </small></h3>
    <input type="text" name="text_name_page" value="<?php echo $name_page; ?>"  style="width:100%;"/>
    <br/><br/>

    <h3> Escribe Meta Descripción de las paginas </h3>
    <textarea name="text_desc_page" style="width:100%;min-height: 100px;"><?php echo $desc_page; ?></textarea>
    <br/><br/>

    <h3 style="margin-bottom:-10px">Rango de Fechas</h3>
    <div class="half_date">
      <h4> Escribe Fecha desde</h4>
      <div class="flatpickr">
        <input class="rbk_date" name="text_date_desde" value="<?php echo $date_desde; ?>" placeholder="Seleccione la fecha ..."  data-input>
        <a class="input-button" title="toggle" data-toggle>
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-event" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
              <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
          </svg>
        </a>

        <a class="input-button" title="clear" data-clear>
          <svg style="color: red;"  width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-octagon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
              <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
          </svg>
        </a>
      </div>
    </div>

    <div class="half">
      <h4> Escribe Fecha hasta <small> (fecha no incluida) </small></h4>
      <div class="flatpickr" >
        <input class="rbk_date" name="text_date_hasta" value="<?php echo $date_hasta; ?>" placeholder="Seleccione la fecha ..."  data-input>
        <a class="input-button" title="toggle" data-toggle>
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar-event" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
              <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
          </svg>
        </a>

        <a class="input-button" title="clear" data-clear>
          <svg style="color: red;"  width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-octagon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1L1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
              <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
          </svg>
        </a>
      </div>
    </div>
    <div style="clear:both"></div>

    <h3> Sube el CSV de los Sinonimos <small>(separado por punto y coma)</small></h3>
    <input type="file" name="file_sinonimos" class="dropify" data-allowed-file-extensions="csv" />

    <h3> Sube el CSV de la Matriz de Orden <small>(separado por punto y coma)</small></h3>
    <input type="file" name="file_orden" class="dropify" data-allowed-file-extensions="csv" />

    <h3> Sube el CSV de Sinonimos para la Meta Descripción <small>(separado por punto y coma)</small></h3>
    <input type="file" name="file_desc" class="dropify" data-allowed-file-extensions="csv" />

    <br/>

    <input type="submit" value="Guardar Datos" />
  </form>
</div>



