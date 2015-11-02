<form class="form-plugin" id="form-plugin" action="<?php echo $config->url_current; ?>/update" method="post">
  <?php echo Form::hidden('token', $token); $cp_config = File::open(PLUGIN . DS . File::B(__DIR__) . DS . 'states' . DS . 'config.txt')->unserialize(); ?>
  <div class="grid-group">
    <h3><?php echo $speak->preview; ?></h3>
    <div id="form-plugin-preview-area" style="display:block;background-color:#FFFFAA;border:1px dashed #F0D8A7;font:normal normal 100%/1em 'Courier New',Courier,'Numbus Mono L',Monospace;color:black;padding:1.4em 1.6em;letter-spacing:0;text-shadow:none;">&hellip;</div>
  </div>
  <label class="grid-group">
    <span class="grid span-1 form-label"><?php echo $speak->plugin_custom_permalink_title_pattern; ?></span>
    <span class="grid span-5">
    <?php

    $options = array();
    $dates = explode('.', date('Y.m.d'));
    foreach(glob(PLUGIN . DS . File::B(__DIR__) . DS . 'workers' . DS . '*.php', GLOB_NOSORT) as $pattern) {
        $pattern = File::N($pattern);
        $options[$pattern] = ':' . str_replace('-', '/:', $pattern);
    }

    ksort($options);

    echo Form::select('pattern', $options, $cp_config['pattern']);

    ?>
    </span>
  </label>
  <label class="grid-group">
    <span class="grid span-1 form-label"><?php echo $speak->plugin_custom_permalink_title_extension; ?></span>
    <span class="grid span-5"><?php echo Form::text('extension', $cp_config['extension'], '.html'); ?></span>
  </label>
  <div class="grid-group">
    <span class="grid span-1"></span>
    <span class="grid span-5"><?php echo Jot::button('action', $speak->update); ?></span>
  </div>
</form>
<?php $dates = explode('.', date('Y.m.d')); ?>
<script>
(function(w, d) {
    var form = d.getElementById('form-plugin'),
        pattern = form.pattern,
        extension = form.extension,
        area = d.getElementById('form-plugin-preview-area');
    function preview() {
        w.setTimeout(function() {
            var path = pattern.value.replace(/-/g, '/').replace('base', '<?php echo $config->index->slug; ?>').replace('year', '<?php echo $dates[0]; ?>').replace('month', '<?php echo $dates[1]; ?>').replace('day', '<?php echo $dates[2]; ?>').replace('id', '<?php echo time(); ?>').replace('slug', 'lorem-ipsum');
            area.innerHTML = '<?php echo $config->url; ?>/' + path + extension.value;
        }, 1);
    };
    pattern.onchange = preview;
    extension.onkeyup = preview;
    extension.onpaste = preview;
    extension.onchange = preview;
    extension.onblur = preview;
    preview();
})(window, document);
</script>