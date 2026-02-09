<?php
/*
Plugin Name: Page Generator
Plugin URI: 
Description: Generar paginas
Version: 1.0
Author: Andrés Gay Pau
Author URI: https://robertaklein.com
License:GPL
*/

//DEFINES
define('PG_PATH_PLUGIN', plugin_dir_path( __FILE__ ));
define('PG_URL_PLUGIN', plugin_dir_url( __FILE__ ));

define('PG_PATH_CODE',PG_PATH_PLUGIN.'/cod');
define('PG_PATH_DATABASE',PG_PATH_PLUGIN.'/database');


require_once PG_PATH_PLUGIN . 'core/activator.php';
require_once PG_PATH_PLUGIN . 'core/deactivator.php';
register_activation_hook(__FILE__, ['PageGeneratorPlugin\Activator', 'activate']);
register_deactivation_hook(__FILE__, ['PageGeneratorPlugin\Deactivator', 'deactivate']);



add_filter('cron_schedules', 'rbk_page_generator_cron_intervals');
function rbk_page_generator_cron_intervals($schedules) {
  $schedules['every_minute'] = array(
    'interval' => 60, // segundos
    'display'  => __('Cada Minuto'),
  );
  return $schedules;
}

if(strpos($_SERVER['REQUEST_URI'],"/wp-admin")>-1){
  $name_folder_plugin = substr(plugin_basename(__FILE__),0,strpos(plugin_basename(__FILE__), "/"));

  define('PG_URL_PLUGIN_OTHERS',PG_URL_PLUGIN.'/plugins');
  
  define('PG_PATH_UPLOADS',PG_PATH_PLUGIN.'/uploads');
  define('PG_PATH_UPLOADS_CSV',PG_PATH_UPLOADS.'/csv/');

  //WORDPRESS HOOKS
  register_activation_hook( __FILE__, 'rbk_pg_db_create_table' );
  add_action('admin_menu', 'rbk_pg_custom_menu');
}

//Add Cron actions
add_action('page_generator_cron', "rbk_cron_execution");

function rbk_cron_execution()
{
  require PG_PATH_CODE."/classes/generator_manager.php";
  $num_total_created = 0;

  $generator_manager = new GeneratorManager();
  $num_total_created = $generator_manager->run();

  return $num_total_created;
}

///////////////////////////////////////////////////////
//////////////////// FUNCTIONS ////////////////////////
//////////////////////////////////////////////////////

function rbk_pg_custom_menu() {
  add_menu_page( 
    'Generador de Elementor', 
    'Generador de Elementor', 
    'edit_posts', 
    'page_generator_wp', 
    'rbk_pg_inicio', 
    'dashicons-chart-bar'
  );

  add_submenu_page(
    'page_generator_wp',
    'Información Ejecución',
    'Información Ejecución',
    'edit_posts',
    'info_executions_page_generator_wp',
    'rbk_pg_info_executions'
  );

  add_submenu_page(
    'page_generator_wp',
    'Configuración Basica',
    'Configuración Basica',
    'edit_posts',
    'configuration_basic_page_generator_wp',
    'rbk_pg_configuracion_basica'
  );

  add_submenu_page(
    'page_generator_wp',
    'Configuración Avanzada',
    'Configuración Avanzada',
    'edit_posts',
    'configuration_advanced_page_generator_wp',
    'rbk_pg_configuracion_avanzada'
  );

  add_submenu_page(
    'page_generator_wp',
    'Configuración Cron',
    'Configuración Cron',
    'edit_posts',
    'configuration_cron_page_generator_wp',
    'rbk_pg_configuration_cron'
  );

  add_submenu_page(
    'page_generator_wp',
    'Limpiar Cron',
    'Limpiar Cron',
    'edit_posts',
    'cron_clean_page_generator_wp',
    'rbk_pg_cron_clean'
  );

  add_submenu_page(
    'page_generator_wp',
    'Ejecutar Cron',
    'Ejecutar Cron',
    'edit_posts',
    'cron_execute_page_generator_wp',
    'rbk_pg_cron_execute'
  );
}

function rbk_pg_inicio()
{
  include plugin_dir_path(__FILE__)."css/css_generator.php";
  include plugin_dir_path(__FILE__)."cod/cod_generator.php";
  include plugin_dir_path(__FILE__)."html/html_generator.php";
  include plugin_dir_path(__FILE__)."javascript/js_generator.php";
}

function rbk_pg_configuracion_basica()
{
  include plugin_dir_path(__FILE__)."css/css_configuration_basic.php";
  include plugin_dir_path(__FILE__)."cod/cod_configuration_basic.php";
  include plugin_dir_path(__FILE__)."html/html_configuration_basic.php";
  include plugin_dir_path(__FILE__)."javascript/js_configuration_basic.php";
}

function rbk_pg_configuracion_avanzada()
{
  include plugin_dir_path(__FILE__)."css/css_configuration_advanced.php";
  include plugin_dir_path(__FILE__)."cod/cod_configuration_advanced.php";
  include plugin_dir_path(__FILE__)."html/html_configuration_advanced.php";
  include plugin_dir_path(__FILE__)."javascript/js_configuration_advanced.php";
}

function rbk_pg_cron_execute()
{
  include plugin_dir_path(__FILE__)."cod/cod_cron_execute.php";
}

function rbk_pg_configuration_cron()
{
  include plugin_dir_path(__FILE__)."cod/cod_configuration_cron.php";
  include plugin_dir_path(__FILE__)."html/html_configuration_cron.php";

}

function rbk_pg_info_executions()
{
  include plugin_dir_path(__FILE__)."cod/cod_info_executions.php";
  include plugin_dir_path(__FILE__)."html/html_info_executions.php";

}

function rbk_pg_cron_clean()
{
  include plugin_dir_path(__FILE__)."cod/cod_cron_clean.php";
  include plugin_dir_path(__FILE__)."html/html_cron_clean.php";
}

?>