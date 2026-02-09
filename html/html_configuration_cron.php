

<div style="margin:20px;">
  <div>
    <div>Para Lanzar el archivo desde el servidor directamente, se necesita: [URL][USER][PASS]</div>
    <div>curl --data "log=[USER]&pwd=[PASS]" [URL]/wp-login.php -c wpcookie.txt >/dev/null 2>&1 && curl "[URL]/wp-admin/admin.php?page=cron_execute_page_generator_wp" -b wpcookie.txt >/dev/null 2>&1</div>
  </div>

  <div>
    <div>Para ejecutar el WP Cron de la pagina, se necesita: [URL]</div>
    <div>curl -s [URL]/wp-cron.php?doing_wp_cron >/dev/null 2>&1</div>
  </div>
  <form method="POST" enctype="multipart/form-data">
    <h3>
      Escribe el numero de ejecuciones del cron
    </h3>

    <input type="text" name="text_cron_execution" value="<?php echo $num_cron_execution; ?>"/>

    <br/><br/>
    <br/><br/>

    <input type="submit" value="Guardar Datos" />
  </form>
</div>







