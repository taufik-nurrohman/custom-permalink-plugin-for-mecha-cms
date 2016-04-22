<?php

// abort the default pattern
if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
    Shield::abort('404-article');
}

// pattern: `http://localhost/slug`
if($c_cp->extension === "") {
    Route::over('(:any)', function($slug) use($config) {
        if( ! is_numeric($slug) && Get::articlePath($slug)) {
            Route::execute($config->index->slug . '/(:any)', array($slug));
        }
    });
} else {
    Route::accept('(:any)' . $c_cp->extension, function($slug) use($config) {
        if( ! is_numeric($slug) && Get::articlePath($slug)) {
            Route::execute($config->index->slug . '/(:any)', array($slug));
        }
    }, 1);
}

// from: `http://localhost/article/slug`
// to: `http://localhost/slug`
function do_cp($url) {
    global $config, $c_cp;
    return str_replace('/' . $config->index->slug . '/', '/', $url) . $c_cp->extension;
}

// fix page types
if(Route::is('(:any)')) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}