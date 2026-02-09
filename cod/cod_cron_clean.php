<?php
  $deleted = false;

  if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] === 'clean_db')
  {
    global $wpdb;

    $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}rbk_pg_cron_data");
    $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}rbk_pg_cron_generate");

    $deleted = true;
  }
?>