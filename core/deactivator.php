<?php
namespace PageGeneratorPlugin;

class Deactivator
{

  public static function deactivate()
  {
    /*
    $timestamp = wp_next_scheduled('page_generator_cron');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'page_generator_cron');
    }
        */
  }

}

?>