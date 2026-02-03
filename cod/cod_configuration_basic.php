<?php
global $wpdb;

$name_db_data = "rbk_pg_data";
$tableName = $wpdb->prefix . $name_db_data;

//Archivos Sinonimos
  if(isset($_FILES['file_sinonimos']) && $_FILES['file_sinonimos']['size']!=0){
    $tableName = $wpdb->prefix . $name_db_data;
    $sinonimos_name_old = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Sinonimos'" )[0];   

    $uploadFileOk = uploadFile('file_sinonimos',$sinonimos_name_old->value);
    var_dump($uploadFileOk);

    if($uploadFileOk != null){
      $data=array(
        "value"=>$uploadFileOk,
      );

      $wpdb->update( $tableName, $data,array("data"=>"Sinonimos") );
    }
  }


//Archivos Orden Sinonimos
  if(isset($_FILES['file_orden']) && $_FILES['file_orden']['size']!=0){
    $tableName = $wpdb->prefix . $name_db_data;
    $sinonimos_name_old = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Orden Sinonimos'" )[0];

    $uploadFileOk = uploadFile('file_orden',$sinonimos_name_old->value);

    if($uploadFileOk != null){
      $data=array(
        "value"=>$uploadFileOk,
      );

      $wpdb->update( $tableName, $data,array("data"=>"Orden Sinonimos") );
    }
  }

//Archivos meta descripcion
  if(isset($_FILES['file_desc']) && $_FILES['file_desc']['size']!=0){
    $tableName = $wpdb->prefix . $name_db_data;
    $desc_name_old = $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Descripcion Sinonimos'" )[0];

    $uploadFileOk = uploadFile('file_desc',$desc_name_old->value);

    if($uploadFileOk != null){
      $data=array(
        "value"=>$uploadFileOk,
      );

      $wpdb->update( $tableName, $data,array("data"=>"Descripcion Sinonimos") );
    }
  }

  if(isset($_POST['text_name_page']) && $_POST['text_name_page']!=""){
    $data=array(
      "value"=>$_POST['text_name_page'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Nombre Pagina") );
  }

  if(isset($_POST['text_desc_page']) && $_POST['text_desc_page']!=""){
    $data=array(
      "value"=>$_POST['text_desc_page'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Descripcion Pagina") );
  }

  if(isset($_POST['text_id_template']) && $_POST['text_id_template']!=""){
    $data=array(
      "value"=>$_POST['text_id_template'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"ID Template") );
  }

  if(isset($_POST['text_id_parent']) && $_POST['text_id_parent']!=""){
    $data=array(
      "value"=>$_POST['text_id_parent'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"ID Parent") );
  }

  if(isset($_POST['text_date_desde']) && $_POST['text_date_desde']!=""){
    $data=array(
      "value"=>$_POST['text_date_desde'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Date Desde") );
  }

  if(isset($_POST['text_date_hasta']) && $_POST['text_date_hasta']!=""){
    $data=array(
      "value"=>$_POST['text_date_hasta'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Date Hasta") );
  }

  $name_page =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Nombre Pagina'" )[0]->value;
  $desc_page =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Descripcion Pagina'" )[0]->value;
  $id_template =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='ID Template'" )[0]->value;
  $id_parent =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='ID Parent'" )[0]->value;
  $date_desde =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Date Desde'" )[0]->value;
  $date_hasta =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Date Hasta'" )[0]->value;

///////////////////////////////////////////////////////
//////////////////// FUNCTIONS ////////////////////////
//////////////////////////////////////////////////////

  function uploadFile($name_attrib, $last_file) {
    $path_upload = PG_PATH_UPLOADS ."/csv/". basename($_FILES[$name_attrib]['name']);

    //var_dump($path_upload);

    if (move_uploaded_file($_FILES[$name_attrib]['tmp_name'], $path_upload)) {
      //echo "El fichero es válido y se subió con éxito.\n";

      if($_FILES[$name_attrib]['name'] != $last_file && file_exists(PG_PATH_UPLOADS ."/csv/".$last_file) ){
        unlink( PG_PATH_UPLOADS ."/csv/".$last_file);
      }

      return $_FILES[$name_attrib]['name'];
    } else {
      //echo "¡Posible ataque de subida de ficheros!\n";

      return null;
    }
  }
?>