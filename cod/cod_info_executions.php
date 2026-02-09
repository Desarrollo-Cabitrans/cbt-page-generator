<?php
  global $wpdb;

  $tableName = $wpdb->prefix . "rbk_pg_cron_generate";
  $generators =  $wpdb->get_results( "SELECT gen.*, COUNT(dat.id) AS pages_left FROM  ".$wpdb->prefix."rbk_pg_cron_generate AS gen LEFT JOIN ".$wpdb->prefix."rbk_pg_cron_data AS dat ON dat.id_generate = gen.id GROUP BY gen.id;" );
  
  if(!empty($generators))
  {
    $generator_execution = $generators[0];
    $created_pages = $generator_execution->pages_to_create-$generator_execution->pages_left;
  }
  function getPercentage($created, $total)
  {
    return round(($created/$total)*100);
  }
?>
