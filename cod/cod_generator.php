<?php 
global $wpdb;

$name_db_data = "rbk_pg_data";
$name_db_generate = "rbk_pg_cron_generate";
$name_db_generate_data = "rbk_pg_cron_data";

$path_csv = plugin_dir_path(__FILE__).'../uploads/csv/';

//COMPROBACIONES
  $is_generate_page = false;
  $is_error_generate_page = false;
  $num_page = 0;

  $error_msg = (isset($_FILES['file_city']) && $_FILES['file_city']['size']!=0)?"ok":"Error Archivo";
  //$error_msg = (isset($_POST['id_template']) && $_POST['id_template'] != "")?"ok":"Error ID";

  if($error_msg == "ok"){

    $tableName = $wpdb->prefix . "rbk_pg_data";

    //GET DATABASE DATA
    $index_sinonimos = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Index Sinonimos'" )[0]->value;
    $name_csv_sinonimos = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Sinonimos'" )[0]->value;
    $name_csv_orden = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Orden Sinonimos'" )[0]->value;
    $name_csv_desc_sinonimos = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Descripcion Sinonimos'" )[0]->value;
    $max_row = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Filas'" )[0]->value;
    $max_col = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Columnas'" )[0]->value;
    $max_combinations = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Combinations'" )[0]->value;
    $max_index = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Index'" )[0]->value;
    $name_page =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Nombre Pagina'" )[0]->value;
    $desc_max_row =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Desc Max Filas'" )[0]->value;
    $desc_max_columns =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Desc Max Columnas'" )[0]->value;
    $desc_max_combination =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Desc Max Combinations'" )[0]->value;
    $desc_max_index =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Desc Max Index'" )[0]->value;
    $desc_index_sinonimos =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Desc Index Sinonimos'" )[0]->value;
    $desc_page =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Descripcion Pagina'" )[0]->value;
    $id_template =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='ID Template'" )[0]->value;
    $id_parent =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='ID Parent'" )[0]->value;
    $date_desde =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Date Desde'" )[0]->value;
    $date_hasta =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Date Hasta'" )[0]->value;

    $sinonimos = getFileInfo($path_csv.$name_csv_sinonimos);
    $orden = getFileInfo($path_csv.$name_csv_orden);

    //Subir el grupo de generacion
    $tableName = $wpdb->prefix . $name_db_generate;

    $data=array(
      "file_sinonimos"=> $name_csv_sinonimos,
      "file_orden"=> $name_csv_orden,
      "file_desc_sinonimos"=> $name_csv_desc_sinonimos,
      "max_row"=> $max_row,
      "max_columns"=> $max_col,
      "max_combination"=> $max_combinations,
      "max_index"=> $max_index,
      "index_sinonimos"=> $index_sinonimos,
      "name_page"=> $name_page,
      "desc_max_row"=> $desc_max_row,
      "desc_max_columns"=> $desc_max_columns,
      "desc_max_combination"=> $desc_max_combination,
      "desc_max_index"=> $desc_max_index,
      "desc_index_sinonimos"=> $desc_index_sinonimos,
      "desc_page"=> $desc_page,
      "id_template"=> $id_template,
      "id_parent"=> $id_parent,
      "date_desde"=> $date_desde,
      "date_hasta"=> $date_hasta,
    );
    $wpdb->insert( $tableName, $data );

    $id_generate = $wpdb->insert_id;

    if (($gestor = fopen($_FILES['file_city']['tmp_name'], "r")) !== FALSE)
    {
      $sql_cities = "INSERT INTO `".$wpdb->prefix."rbk_pg_cron_data` (`id_generate`, `city`) VALUES ";

      while (($datos = fgetcsv($gestor, 100000, ";")) !== FALSE) {
        //Subir las ciudades a la data
        $tableName = $wpdb->prefix . $name_db_generate_data;
        $sql_cities .= "('$id_generate', \""./*utf8_encode(*/$datos[0]/*)*/."\"),";
        
        //$data=array(
        //  "id_generate"=>$id_generate,
        //  "city"=> /*utf8_encode(*/$datos[0]/*)*/
        //);

        //$wpdb->insert( $tableName, $data );
        $num_page++;
      }

      $sql_cities = substr($sql_cities, 0, -1);
      $sql_cities .= ";";

      //echo $sql_cities;
      $wpdb->query($sql_cities);

      fclose($gestor);
    }

    if($wpdb->last_error != "")
    {
      $is_error_generate_page = true;
    }

    $is_generate_page=true;
  }

///////////////////////////////////////////////////////
//////////////////// FUNCTIONS ////////////////////////
//////////////////////////////////////////////////////

  function getFileInfo($path_csv) {
    //echo $path_csv;
    $array_return[][] = array();

    $fila = 1;

    if (($gestor = fopen($path_csv, "r")) !== FALSE)
    {
      // para que quite la primera linea
      fgetcsv($gestor, 1000, ";");

      while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE)
      {
        $numero = count($datos);
        //echo "<p> $numero de campos en la línea $fila: <br /></p>\n";

        //para quitar la primera linea que es el titulo
        for ($c=1; $c < $numero; $c++)
        {
          $array_return[$fila-1][$c-1] = $datos[$c];
          //echo $datos[$c] . "<br />\n";
        }

        $fila++;
      }

      fclose($gestor);
    }

    return $array_return;
  }

  function random_date($date_min,$date_max)
  {
    $milisecondsMin = strtotime($date_min);
    $milisecondsMax = strtotime($date_max);
    $miliseconsRandom = mt_rand($milisecondsMin, $milisecondsMax);

    return date("Y-m-d H:i:s", $miliseconsRandom);
  }
?>