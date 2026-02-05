<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// esta en el archivo principal
//register_activation_hook( __FILE__, 'db_plugin_create_table' );

///////////////////////////////////////////////////////
//////////////////// FUNCTIONS ////////////////////////
//////////////////////////////////////////////////////

// crea la table en wordpress 
function rbk_pg_db_create_table() {
  global $wpdb;

  // CREATE TABLE
  $tableName = $wpdb->prefix . "rbk_pg_data";

  //$wpdb->query( "DROP TABLE IF EXISTS ".$tableName );

  $created = dbDelta(  
    "CREATE TABLE $tableName (
      id bigint(20) unsigned AUTO_INCREMENT,
      data varchar(190) UNIQUE,
      value varchar(255),
      PRIMARY KEY (id)
    )"
  );
  
  //INSER DATA
  $data=array(
    "id"=>1,
    "data"=>"Sinonimos",
    "value"=>"sinonimos.csv",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "id"=>2,
    "data"=>"Orden Sinonimos",
    "value"=>"orden.csv",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Descripcion Sinonimos",
    "value"=>"",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Index Sinonimos",
    "value"=>"0",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"ID Template",
    "value"=>"",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"ID Parent",
    "value"=>"",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Max Filas",
    "value"=>"44",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Max Columnas",
    "value"=>"12",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Max Combinations",
    "value"=>"88",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Max Index",
    "value"=>"1056",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Desc Index Sinonimos",
    "value"=>"0",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Nombre Pagina",
    "value"=>"Enviar Palets [Texto_Ciudad] | 962403354 | Envíos Nacionales e Internacionales",
  );
  $wpdb->insert( $tableName, $data );

  
  $data=array(
    "data"=>"Desc Max Filas",
    "value"=>"44",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Desc Max Columnas",
    "value"=>"12",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Desc Max Combinations",
    "value"=>"88",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Desc Max Index",
    "value"=>"1056",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Descripcion Pagina",
    "value"=>"",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Date Desde",
    "value"=>"",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Date Hasta",
    "value"=>"",
  );
  $wpdb->insert( $tableName, $data );

  $data=array(
    "data"=>"Limit Data Cron",
    "value"=>"5",
  );
  $wpdb->insert( $tableName, $data );

  $tableName = $wpdb->prefix . "rbk_pg_cron_generate";
  $wpdb->query( "DROP TABLE IF EXISTS ".$tableName );
  $created = dbDelta(
    "CREATE TABLE $tableName (
      id bigint(20) unsigned AUTO_INCREMENT,
      file_sinonimos varchar(255),
      file_desc_sinonimos varchar(255),
      file_orden varchar(255),
      max_row varchar(255),
      max_columns varchar(255),
      max_combination varchar(255),
      max_index varchar(255),
      index_sinonimos varchar(255),
      name_page varchar(255),
      desc_max_row varchar(255),
      desc_max_columns varchar(255),
      desc_max_combination varchar(255),
      desc_max_index varchar(255),
      desc_index_sinonimos varchar(255),
      desc_page varchar(255),
      id_template varchar(255),
      id_parent varchar(255),
      date_desde varchar(255),
      date_hasta varchar(255),
      PRIMARY KEY (id)
    )"
  );

  $tableName = $wpdb->prefix . "rbk_pg_cron_data";
  $wpdb->query( "DROP TABLE IF EXISTS ".$tableName );

  $created = dbDelta(  
    "CREATE TABLE $tableName (
      id bigint(20) unsigned AUTO_INCREMENT,
      city varchar(255),
      id_generate int,
      PRIMARY KEY (id)
    )"
  );
}
?>