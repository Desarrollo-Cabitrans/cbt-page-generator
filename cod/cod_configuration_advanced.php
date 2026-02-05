<?php
  global $wpdb;
  
  $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'pages';

  $prefix_db_table = "";

  $name_db_data = "rbk_pg_data";
  $tableName = $wpdb->prefix . $name_db_data;
  if($active_tab == "descriptions")
  {
  $prefix_db_table = "Desc ";
  }
  
  if(isset($_POST['text_max_row']) && $_POST['text_max_row']!=""){
    $data=array(
      "value"=>$_POST['text_max_row'],
    );

    $wpdb->update( $tableName, $data,array("data"=>$prefix_db_table."Max Filas") );
  }

  if(isset($_POST['text_max_col']) && $_POST['text_max_col']!=""){
    $data=array(
      "value"=>$_POST['text_max_col'],
    );

    $wpdb->update( $tableName, $data,array("data"=>$prefix_db_table."Max Columnas") );
  }

  if(isset($_POST['text_max_combinations']) && $_POST['text_max_combinations']!=""){
    $data=array(
      "value"=>$_POST['text_max_combinations'],
    );

    $wpdb->update( $tableName, $data,array("data"=>$prefix_db_table."Max Combinations") );
  }

  if(isset($_POST['check_reset_index'])){
    $data=array(
      "value"=>"0",
    );

    $wpdb->update( $tableName, $data,array("data"=>$prefix_db_table."Index Sinonimos") );
  }

  //update max index
  if((isset($_POST['text_max_col']) && $_POST['text_max_col']!="") 
    && (isset($_POST['text_max_combinations']) && $_POST['text_max_combinations']!="")){

      $data=array(
        "value"=>$_POST['text_max_combinations']*$_POST['text_max_col'],
      );

      $wpdb->update( $tableName, $data,array("data"=>$prefix_db_table."Max Index") );
  }

  echo  "SELECT value FROM $tableName WHERE data='".$prefix_db_table."Max Filas'";
  $max_row_sinonimos =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='".$prefix_db_table."Max Filas'" )[0]->value;
  $max_col_sinonimos =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='".$prefix_db_table."Max Columnas'" )[0]->value;
  $max_combinations_sinonimos =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='".$prefix_db_table."Max Combinations'" )[0]->value;
  $index_sinonimos =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='".$prefix_db_table."Index Sinonimos'" )[0]->value;
?>