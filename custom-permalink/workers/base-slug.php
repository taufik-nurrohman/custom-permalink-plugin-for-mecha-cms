<?php

// pattern: `http://localhost/article/slug`
if($cp_config['extension'] !== "") {
    // abort the default pattern
    if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
        if('.' . File::E($config->url_path) !== $cp_config['extension']) {
            Shield::abort('404-article');
        }
    }
    Route::accept($config->index->slug . '/(:any)' . $cp_config['extension'], function($slug = "") use($config) {
        Route::execute($config->index->slug . '/(:any)', array($slug));
    });
    if(Route::is($config->index->slug . '/(:any)' . $cp_config['extension'])) {
        $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
        Config::set('page_type', $config->page_type);
    }
}

function do_custom_permalink($url) {
    global $cp_config;
    return $url . $cp_config['extension'];
}