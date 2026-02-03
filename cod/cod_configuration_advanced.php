<?php
  global $wpdb;

  $name_db_data = "rbk_pg_data";
  $tableName = $wpdb->prefix . $name_db_data;

  if(isset($_POST['text_max_row']) && $_POST['text_max_row']!=""){
    $data=array(
      "value"=>$_POST['text_max_row'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Max Filas") );
  }

  if(isset($_POST['text_max_col']) && $_POST['text_max_col']!=""){
    $data=array(
      "value"=>$_POST['text_max_col'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Max Columnas") );
  }

  if(isset($_POST['text_max_combinations']) && $_POST['text_max_combinations']!=""){
    $data=array(
      "value"=>$_POST['text_max_combinations'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Max Combinations") );
  }

  if(isset($_POST['check_reset_index'])){
    $data=array(
      "value"=>"0",
    );

    $wpdb->update( $tableName, $data,array("data"=>"Index Sinonimos") );
  }

  //update max index
  if((isset($_POST['text_max_col']) && $_POST['text_max_col']!="") 
    && (isset($_POST['text_max_combinations']) && $_POST['text_max_combinations']!="")){

      $data=array(
        "value"=>$_POST['text_max_combinations']*$_POST['text_max_col'],
      );

      $wpdb->update( $tableName, $data,array("data"=>"Max Index") );
  }

  $max_row_sinonimos =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Filas'" )[0]->value;
  $max_col_sinonimos =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Columnas'" )[0]->value;
  $max_combinations_sinonimos =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Max Combinations'" )[0]->value;
  $index_sinonimos =   $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Index Sinonimos'" )[0]->value;
?>