<style>
  .db-clean-container {
    margin: 20px 0;
  }

  #clean-db-btn {
    background-color: #ff4d4f;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.2s;
  }

  #clean-db-btn:hover {
    background-color: #ff7875;
  }

  #confirmation {
      padding: 30px 40px;
      margin-top: 15px;
      background-color: #edd4d4;
      border: 1px solid #e6c3c3;
      color: #571515;
      border-radius: 5px;
      font-weight: bold;
      font-size: 15px;
  }
</style>

<?php
  if(! $deleted)
  {
?>
  <div style="margin: 20px;">
    <h2>Limpiar el CRON de la Base de Datos</h2>
    <div>Elminiar las ciudades preparadas para que el cron las ejecute, limpiando asi el cron<br/><br/></div>
    <div style="color: #b71c1c; font-weight: bold; background-color: #ffebee; padding: 10px; border: 1px solid #f44336; border-radius: 5px;">
      Atención: Esta acción limpiará por completo el cron de la base de datos. 
      <b>No se puede deshacer una vez realizada.</b>
    </div>
    <div class="db-clean-container">
      <form id="clean-db-form" method="POST">
        <input type="hidden" name="action" value="clean_db">
        <button type="button" id="clean-db-btn">Limpiar Base de Datos</button>
      </form>
    </div>
  </div>
<?php
  } 
  else
  {
?>
  <div id="confirmation" >
    La base de datos se ha limpiado correctamente.
  </div>
<?php
  }
?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const btn = document.getElementById("clean-db-btn");
    const form = document.getElementById("clean-db-form");

    btn.addEventListener("click", function() {
      const confirmed = confirm("¿Estás seguro de que quieres limpiar la base de datos? Esta acción no se puede deshacer.");
      if (confirmed) {
        form.submit();
      }
    });
  });
</script>