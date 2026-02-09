<?php
namespace PageGeneratorPlugin;

include PG_PATH_DATABASE."/database.php";

class Activator
{
  public static function activate()
  {
/*
    if(!wp_next_scheduled('page_generator_cron'))
    {
      wp_schedule_event( time(), 'every_minute', 'page_generator_cron' );
    }
*/
    rbk_pg_db_create_table();
  }
}

?>