<?php

Route::over($config->manager->slug . '/plugin/' . File::B(__DIR__) . '/update', function() use($config, $speak) {
    $s = preg_replace('#[^a-z0-9]#', "", $_POST['extension']);
    $_POST['extension'] = $s ? '.' . $s : "";
});