<script src="<?php echo PG_URL_PLUGIN_OTHERS; ?>/dropify-master/dist/js/dropify.min.js"></script>

<script>
  jQuery('.dropify').dropify({
    messages: {
      'default': 'Arrastra el archivo hasta aqui o haz click',
      'replace': 'Arrastra el archivo hasta aqui o haz click para remplazar',
      'remove':  'Eliminar',
      'error':   'Ooops, ha habido un error :('
    },

    error: {
      'fileExtension': 'Este archivo no esta permitido, solo extension ({{ value }}).'
    }
  });

</script>