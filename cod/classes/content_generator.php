<?php
require PG_PATH_CODE."/classes/page_generator.php";

  class ContentGenerator 
  {
    private object $generate;
    private array $sinonimos;
    private array $orden;

    public function __construct($generate)
    {
      $this->generate = $generate;
      
      $this->sinonimos = $this->getFileInfo(PG_PATH_UPLOADS_CSV.$generate->file_sinonimos);
      $this->orden = $this->getFileInfo(PG_PATH_UPLOADS_CSV.$generate->file_orden);
    }

    public function execute($num_executions)
    {
      global $wpdb;
      $max_index  = $this->generate->max_index;
      $desc_max_index  = $this->generate->desc_max_index;

      //LOAD CONTENT AND EXECUTE
        $tableName = $wpdb->prefix . "rbk_pg_cron_data";
        $pages = $wpdb->get_results( "SELECT * FROM $tableName WHERE id_generate =".$this->generate->id );

        $num_pages = count($pages);
        foreach($pages as $page)
        {
          if ($num_executions <= 0)
            break;

          $page_generator = new PageGenerator($page, $this->generate);
          $page_generator->setFilesContent($this->sinonimos, $this->orden);
          $page_generator->create();

          $this->generate->index_sinonimos++;
          $this->generate->desc_index_sinonimos++;

          if($this->generate->index_sinonimos >= $max_index){
            $this->generate->index_sinonimos=0;
          }
          if($this->generate->desc_index_sinonimos >= $this->generate->desc_max_index){
            $this->generate->desc_index_sinonimos=0;
          }
          
          $tableName = $wpdb->prefix . "rbk_pg_data";
          $data=array(
            "value"=>$this->generate->index_sinonimos,
          );
          $wpdb->update( $tableName, $data,array("data"=>"Index Sinonimos") );
          
          $tableName = $wpdb->prefix . "rbk_pg_data";
          $data=array(
            "value"=>$this->generate->desc_index_sinonimos,
          );
          $wpdb->update( $tableName, $data,array("data"=>"Desc Index Sinonimos") );

           
          $tableName = $wpdb->prefix . "rbk_pg_cron_generate";
          $data=array(
            "index_sinonimos"=>$this->generate->index_sinonimos,
            "desc_index_sinonimos"=>$this->generate->desc_index_sinonimos,
          );
          $wpdb->update( $tableName, $data, array("id"=> $this->generate->id));


          //ELIMINAR AL FINALZIAR
          $tableName = $wpdb->prefix . "rbk_pg_cron_data";
          $wpdb->delete( $tableName, array("id"=> $page->id) );

          $num_pages--;
          $num_executions--;
        }

        if($num_pages == 0 )
        {
          // borrar al finalizar  todos
          $tableName = $wpdb->prefix . "rbk_pg_cron_generate";
          $wpdb->delete( $tableName, array("id"=> $this->generate->id) );
        }

        return $num_executions;
        
    }

    public function getFileInfo($path_csv) {
      //echo $path_csv;
      $array_return[][] = array();

      $fila = 1;
      if (($gestor = fopen($path_csv, "r")) !== FALSE) {
        // para que quite la primera linea
        fgetcsv($gestor, 10000000, ";");

        while (($datos = fgetcsv($gestor, 10000000, ";")) !== FALSE)
        {
          $numero = count($datos);

          //para quitar la primera linea que es el titulo
          for ($c=1; $c < $numero; $c++) {
            $array_return[$fila-1][$c-1] = $datos[$c];
            //echo $datos[$c] . "<br />\n";
          }

          $fila++;
        }

        fclose($gestor);
      }

      return $array_return;
    }
  }
?>