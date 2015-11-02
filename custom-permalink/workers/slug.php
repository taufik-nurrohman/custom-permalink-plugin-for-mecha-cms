<?php

// abort the default pattern
if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
    Shield::abort('404-article');
}

// pattern: `http://localhost/slug`
if($cp_config['extension'] === "") {
    Route::over('(:any)', function($slug) use($config) {
        if( ! is_numeric($slug) && Get::articlePath($slug)) {
            Route::execute($config->index->slug . '/(:any)', array($slug));
        }
    });
} else {
    Route::accept('(:any)' . $cp_config['extension'], function($slug) use($config) {
        if( ! is_numeric($slug) && Get::articlePath($slug)) {
            Route::execute($config->index->slug . '/(:any)', array($slug));
        }
    }, 1);
}

// from: `http://localhost/article/slug`
// to: `http://localhost/slug`
function do_custom_permalink($url) {
    global $config, $cp_config;
    return str_replace('/' . $config->index->slug . '/', '/', $url) . $cp_config['extension'];
}

// fix page types
if(Route::is('(:any)')) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}