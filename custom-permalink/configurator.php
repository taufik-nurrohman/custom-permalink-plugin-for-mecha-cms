<?php $c_cp = $config->states->{'plugin_' . md5(File::B(__DIR__))}; ?>
<div class="grid-group">
  <div class="grid span-6">
      <h3><?php echo $speak->preview; ?></h3>
  <div id="form-plugin-preview-area" style="display:block;background-color:#FFFFAA;border:1px dashed #F0D8A7;font:normal normal 100%/1em 'Courier New',Courier,'Numbus Mono L',Monospace;color:black;padding:1.4em 1.6em;letter-spacing:0;text-shadow:none;">&hellip;</div>
    </div>
</div>
<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->plugin_custom_permalink->title->pattern; ?></span>
  <span class="grid span-5">
  <?php

  $options = array();
  foreach(glob(__DIR__ . DS . 'workers' . DS . '*.php', GLOB_NOSORT) as $pattern) {
      $pattern = File::N($pattern);
      $options[$pattern] = ':' . str_replace('-', '/:', $pattern);
  }

  ksort($options);

  echo Form::select('pattern', $options, $c_cp->pattern);

  ?>
  </span>
</label>
<label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->plugin_custom_permalink->title->extension; ?></span>
  <span class="grid span-5"><?php echo Form::text('extension', $c_cp->extension, '.html'); ?></span>
</label>
<?php $dates = explode('.', date('Y.m.d')); ?>
<script>
(function(w, d) {
    var form = d.getElementsByClassName('form-plugin')[0],
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
    extension.oninput = preview;
    preview();
})(window, document);
</script>