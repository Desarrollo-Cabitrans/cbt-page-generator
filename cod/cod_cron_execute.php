<?php 
global $wpdb;

$tableName = "rbk_pg_data";
$name_db_generate = "rbk_pg_cron_generate";
$name_db_generate_data = "rbk_pg_cron_data";
$name_db_data = "rbk_pg_data";

$tableName = $wpdb->prefix . $name_db_generate;
$generate = $wpdb->get_results( "SELECT * FROM $tableName" );

$tableName = $wpdb->prefix . $name_db_data;
$num_cron_execution =  $wpdb->get_results( "SELECT value FROM $tableName WHERE data='Limit Data Cron'" )[0]->value;

$num_cron_execution_original = $num_cron_execution;

$num_total=0;

for($i_g = 0; $i_g < count($generate) && ($num_cron_execution > 0); $i_g++)
{ 
  $num_page = 0;

  $index_sinonimos      =    $generate[$i_g]->index_sinonimos;
  $name_csv_sinonimos   =    $generate[$i_g]->file_sinonimos;
  $name_csv_orden       =    $generate[$i_g]->file_orden;
  $max_row              =    $generate[$i_g]->max_row;
  $max_col              =    $generate[$i_g]->max_columns;
  $max_combinations     =    $generate[$i_g]->max_combination;
  $max_index            =    $generate[$i_g]->max_index;
  $name_page            =    $generate[$i_g]->name_page;
  $desc_pag             =    $generate[$i_g]->desc_page;
  $id_template          =    $generate[$i_g]->id_template;
  $id_parent            =    $generate[$i_g]->id_parent;
  $date_desde           =    $generate[$i_g]->date_desde;
  $date_hasta           =    $generate[$i_g]->date_hasta;

  $path_csv = PG_PATH_UPLOADS."/csv/";

  $sinonimos = getFileInfo($path_csv.$name_csv_sinonimos);
  $orden = getFileInfo($path_csv.$name_csv_orden);

  //echo $path_csv.$name_csv_sinonimos."<br/>";

  $tableName = $wpdb->prefix . $name_db_generate_data;
  $data_generate = $wpdb->get_results( "SELECT * FROM $tableName WHERE id_generate =".$generate[$i_g]->id );

  $content ="";
  for($j_g = 0; $j_g < count($data_generate) && ($num_cron_execution > 0); $j_g++)
  {

    //Crear la pagina a partir de la plantilla    

    //$post_get = get_post($id_template);

    //$content = $post_get->post_content;
    //////////////////////////////////////////
    // ELEMENTOR COPY DATA ///////////////////
    //////////////////////////////////////////
    
      // Query WP to get a handle on the template were going to copy
      $query = new WP_Query([
        'post_type' => 'elementor_library',
        'name' => $id_template, // es el nombre del tempalte
        'posts_per_page' => 1
      ]);

      // No need to set up The Loop - we just want one post
      $template = $query->found_posts ? $query->posts[0] : false;
      
      //$content = $template->post_content;
      $content = get_post_meta($id_template, '_elementor_data', true);

      //////////////////////////////////////////
      //////////////////////////////////////////
      //////////////////////////////////////////

    $city_name = $data_generate[$j_g]->city;

    //Poner el Nombre de la ciudad
    $content = str_replace("[Texto_Ciudad]",htmlentities($city_name, ENT_QUOTES | ENT_HTML401, 'UTF-8'), $content);
    $content = str_replace("[TEXTO_CIUDAD]",htmlentities($city_name, ENT_QUOTES | ENT_HTML401, 'UTF-8'), $content);

    $temp_name_page = str_replace("[Texto_Ciudad]",$city_name, $name_page);

    //index in name
    //$max_col == count($orden[0]) == 12 sinonimos

    $row_name = (int)($index_sinonimos/$max_col);
    $col_name = $index_sinonimos - ($max_col*$row_name);
    $name_sinonimo_index = $orden[$row_name][$col_name];//$index_sinonimos

    //echo $name_sinonimo_index."<br/>";

    $row_sinonimos = 0;
    $row_orden = $row_name;

    // count($orden) == $max_row
    for($i=0;$i<$max_row;$i++)
    {

      $isFind = false;
      //$max_col == ount($orden[$row_orden]) == 12

      for($j=0;$j<$max_col&& !$isFind ;$j++)
      {
        //echo "(".$row_orden.";".$j.") ".$name_sinonimo_index." == ".$orden[$row_orden][$j]."<br/>";

        if($name_sinonimo_index == $orden[$row_orden][$j]){
          $isFind = true;
          $content = str_replace("[Texto_Sinonimos_".($i+1)."]",$sinonimos[$i][$j], $content);

          //echo utf8_encode($sinonimos[$row_sinonimos][$j])." ";
          //echo "[Texto_Sinonimos_".($i+1)."]   ===>  ".utf8_encode($sinonimos[$i][$j])."<br/>";
          //echo "[Texto_Sinonimos_".($i+1)."]   ===>  ".$sinonimos[$i][$j]."<br/>";
        }
      }

      $row_orden++;

      if($row_orden >= $max_combinations)
      {
        $row_orden = 0;
      }
    }

    $date = str_replace('/', '-', $date_desde);
    $date_desde = date('Y-m-d', strtotime($date));

    $date = str_replace('/', '-', $date_hasta);
    $date_hasta = date('Y-m-d', strtotime($date));

    // add vc_shortcode
    /*$shortcodes_custom_css = get_post_meta( $id_template, '_wpb_shortcodes_custom_css', true );

    if ( ! empty( $shortcodes_custom_css ) ) {
        $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
        $content.='<style type="text/css" data-type="vc_shortcodes-custom-css">';
        $content.=$shortcodes_custom_css;
        $content.='</style>';
    }*/

    $tableName = $wpdb->prefix . "terms";
    $category_name =  $wpdb->get_results( "SELECT name FROM $tableName  WHERE `term_id` = $id_parent" )[0]->name;

    //$content .= get_post_custom($id_template);
    //var_dump(get_post_custom($id_template));
    //echo $content;
    //var_dump($city_name);
    //exit;
    //$content = str_replace("[Texto_Sinonimos_1]",$datos[0], $content);  

    $my_post = array(
      'post_title'    => $temp_name_page,
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_category' => array($id_parent),
      'post_type'     => 'post',//Posts
      'post_name'     => $category_name.'-'.$city_name,
      //'post_date'     => random_date($date_desde,$date_hasta)
    );

    // Insert the post into the database
    $pageId = wp_insert_post( $my_post );

    $meta_keys = [
      '_elementor_data',
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

    // Meta Description
    $new_desc = $desc_pag;
    $new_desc = str_replace('[Texto_Ciudad]', $city_name, $new_desc);
    $new_desc = str_replace('[Texto_Sinonimos_1]', "texto_sinonsi", $new_desc);

    $updated = update_post_meta($pageId, 'rank_math_description', wp_strip_all_tags($new_desc));
    
    //////////////////////////////////////////
    // ELEMENTOR COPY DATA ///////////////////
    //////////////////////////////////////////    

      /*$page = array(
        'post_type' => 'page',
        'post_title' => 'My Dynamic Page Title',
        'post_name' => 'My Dynamic Page Title',
        // Copy the content from the template
        'post_content' => $template->post_content,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
      );*/

    //////////////////////////////////////////
    //////////////////////////////////////////
    //////////////////////////////////////////

    $index_sinonimos++;

    if($index_sinonimos >= $max_index){
      $index_sinonimos=0;
    }

    // borrar al finalizar
    $tableName = $wpdb->prefix . $name_db_generate_data;
    
    $wpdb->delete( $tableName, array("id"=> $data_generate[$j_g]->id) );

    $num_cron_execution--;
    $num_page++;
    $num_total++;
  }  

  $tableName = $wpdb->prefix . $name_db_data;
  $data=array(
    "value"=>$index_sinonimos,
  );
  $wpdb->update( $tableName, $data,array("data"=>"Index Sinonimos") );

  
  //echo "adasdadddddddddddddddddddd  ".$num_page."    ==   ".count($data_generate)."<br/><br/>";
    if($num_page >= count($data_generate)){
    // borrar al finalizar
    $tableName = $wpdb->prefix . $name_db_generate;
    $wpdb->delete( $tableName, array("id"=> $generate[$i_g]->id) );
  }
}

echo "Se han creado ".$num_total." paginas";


///////////////////////////////////////////////////////
//////////////////// FUNCTIONS ////////////////////////
//////////////////////////////////////////////////////

  function getFileInfo($path_csv) {
    //echo $path_csv;
    $array_return[][] = array();

    $fila = 1;
    if (($gestor = fopen($path_csv, "r")) !== FALSE) {
      // para que quite la primera linea
      fgetcsv($gestor, 10000000, ";");

      while (($datos = fgetcsv($gestor, 10000000, ";")) !== FALSE) {

        $numero = count($datos);

        //echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
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

  function random_date($date_min,$date_max){
    $milisecondsMin = strtotime($date_min);
    $milisecondsMax = strtotime($date_max);
    $miliseconsRandom = mt_rand($milisecondsMin, $milisecondsMax);

    return date("Y-m-d H:i:s", $miliseconsRandom);
  }
?>