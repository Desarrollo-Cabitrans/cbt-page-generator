<?php
  require PG_PATH_CODE."/classes/content_generator.php";

  class GeneratorManager 
  {
    private array $generate;
    private int $num_executions;
    private int $num_pages_to_create;

    public function __construct($num_executions)
    {
      global $wpdb;
      $this->num_executions = $num_executions;
      $this->num_pages_to_create  = $num_executions;
      
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