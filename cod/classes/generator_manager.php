<?php
  require PG_PATH_CODE."/classes/content_generator.php";

  class GeneratorManager 
  {
    private array $generate;
    private int $num_executions;
    private int $num_pages_to_create;

    public function __construct()
    {
      global $wpdb;
      
      $tableName = $wpdb->prefix . "rbk_pg_data";
      $this->num_executions =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Limit Data Cron'" )[0]->value;
      $this->num_pages_to_create  = $this->num_executions;
      
      $tableName = $wpdb->prefix . "rbk_pg_cron_generate";
      $this->generate = $wpdb->get_results( "SELECT * FROM $tableName" );
    }

    public function run()
    {
      global $wpdb;

      foreach ($this->generate as $gen)
      {
        if ($this->num_executions <= 0)
          break;
        
        $content_generator = new ContentGenerator($gen);
        $this->num_executions = $content_generator->execute($this->num_executions);
      }

      return $this->num_pages_to_create-$this->num_executions;
    }
  }
?>