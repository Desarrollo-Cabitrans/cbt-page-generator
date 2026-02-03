<?php
  global $wpdb;

  $name_db_data = "rbk_pg_data";
  $tableName = $wpdb->prefix . $name_db_data;

  if(isset($_POST['text_cron_execution']) && $_POST['text_cron_execution']!=""){
    $data=array(
      "value"=>$_POST['text_cron_execution'],
    );

    $wpdb->update( $tableName, $data,array("data"=>"Limit Data Cron") );
  }

  $num_cron_execution =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Limit Data Cron'" )[0]->value;
?>