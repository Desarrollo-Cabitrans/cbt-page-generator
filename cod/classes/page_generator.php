<?php
  class PageGenerator 
  {
    private object $page;
    private string $type;
    private object $config;
    private array $sinonimos;
    private array $orden;

    public function __construct($page, $config)
    {
      $this->page = $page;
      $this->type = "elementor";
      $this->config = $config;
    }

    public function setFilesContent(&$sinonimos, &$orden)
    {
      $this->sinonimos = $sinonimos;
      $this->orden = $orden;
    }

    public function create()
    {
      $content = $this->loadContent();
      $config = [
        'index_sinonimos' => $this->config->index_sinonimos,
        'max_columns' => $this->config->max_columns,
        'max_row' => $this->config->max_row,
        'max_combination' => $this->config->max_combination
      ];
      $content = $this->generateSinonimos($content, $config);
      $pageId = $this->createPage($content);

      //echo "<br/><br/<<br/>"; 

      $content_desc = $this->config->desc_page;
      $config_desc = [
        'index_sinonimos' => $this->config->desc_index_sinonimos,
        'max_columns' => $this->config->desc_max_columns,
        'max_row' => $this->config->desc_max_row,
        'max_combination' => $this->config->desc_max_combination
      ];
      $content_desc = $this->generateSinonimos($content_desc, $config_desc);

      $this->createMetaDescripcion($pageId, $content_desc);
    }

    private function loadContent()
    {
      $id_template  = $this->config->id_template;
      return get_post_meta($id_template, '_elementor_data', true);
    }
    
    private function createPage($content)
    {
      global $wpdb;
      $id_parent    = $this->config->id_parent;
      $date_desde   = $this->config->date_desde;
      $date_hasta   = $this->config->date_hasta;
      $id_template  = $this->config->id_template;

      $name_page = $this->config->name_page;
      $temp_name_page = str_replace("[Texto_Ciudad]",$this->page->city, $name_page);

      $date = str_replace('/', '-', $date_desde);
      $date_desde = date('Y-m-d', strtotime($date));

      $date = str_replace('/', '-', $date_hasta);
      $date_hasta = date('Y-m-d', strtotime($date));

      $post_name = null;
      if($id_parent != "")
      {
        $tableName = $wpdb->prefix . "terms";
        $category_name =  $wpdb->get_results( "SELECT name FROM $tableName  WHERE `term_id` = $id_parent" )[0]->name;

        $post_name = $category_name.'-'.$this->page->city;
      }

      $my_post = array(
        'post_title'    => $temp_name_page,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_category' => array($id_parent),
        'post_type'     => 'post',//Posts
        'post_name'     => $post_name,
        'post_date'     => $this->random_date($date_desde,$date_hasta)
      );
      $pageId = wp_insert_post( $my_post );

      /// ELEMENTOR ///
      if(true || $type == "elementor")
      {
        $meta_keys = [
          '_elementor_edit_mode',
          '_elementor_version',
          '_elementor_template_type',
        ];
      
        foreach ($meta_keys as $key) {
          $value = get_post_meta($id_template, $key, true);
          if ($value) {
            update_post_meta($pageId, $key, $value);
          }
        }
        
        update_post_meta($pageId, '_elementor_data', wp_slash($content));

        if (class_exists('\Elementor\Core\Files\CSS\Post')) {
          \Elementor\Core\Files\CSS\Post::create($pageId)->update();
        }
      }

      return $pageId;
    }

    
    private function createMetaDescripcion($pageId, $content)
    {
      $updated = update_post_meta($pageId, 'rank_math_description', wp_strip_all_tags($content));
    }

    public function generateSinonimos($content, $config)
    {
      $index_sinonimos  = $config['index_sinonimos'];
      $max_col          = $config['max_columns'];
      $max_row          = $config['max_row'];
      $max_combinations = $config['max_combination'];

      $city_name = $this->page->city;
        
      $content = str_replace("[Texto Ciudad]",$city_name, $content);
      $content = str_replace("[Texto_Ciudad]",$city_name, $content);
      $content = str_replace("[TEXTO_CIUDAD]",$city_name, $content);

      $row_name = (int)($index_sinonimos/$max_col);
      $col_name = $index_sinonimos - ($max_col*$row_name);
      $name_sinonimo_index = $this->orden[$row_name][$col_name];//$index_sinonimos
      
      $row_sinonimos = 0;
      $row_orden = $row_name;

      for($i=0;$i<$max_row;$i++)
      {
        $isFind = false;

        for($j=0;$j<$max_col&& !$isFind ;$j++)
        {
          if($name_sinonimo_index == $this->orden[$row_orden][$j]){
            $isFind = true;
            $content = str_replace("[Texto_Sinonimos_".($i+1)."]",$this->sinonimos[$i][$j], $content);
        
            //echo "[Texto_Sinonimos_".($i+1)."]   ===>  ".$this->sinonimos[$i][$j]."<br/>";
          }
        }
        
        $row_orden++;
        
        if($row_orden >= $max_combinations)
        {
          $row_orden = 0;
        }
      }
      return $content;
    }
    
    public function random_date($date_min,$date_max)
    {
      $milisecondsMin = strtotime($date_min);
      $milisecondsMax = strtotime($date_max);
      $miliseconsRandom = mt_rand($milisecondsMin, $milisecondsMax);

      return date("Y-m-d H:i:s", $miliseconsRandom);
    }
  }

?>