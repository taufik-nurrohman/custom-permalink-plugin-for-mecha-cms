<?php

// pattern: `http://localhost/article/slug`
if($c_cp->extension !== "") {
    // abort the default pattern
    if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
        if('.' . File::E($config->url_path) !== $c_cp->extension) {
            Shield::abort('404-article');
        }
    }
    Route::accept($config->index->slug . '/(:any)' . $c_cp->extension, function($slug = "") use($config) {
        Route::execute($config->index->slug . '/(:any)', array($slug));
    });
    if(Route::is($config->index->slug . '/(:any)' . $c_cp->extension)) {
        $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
        Config::set('page_type', $config->page_type);
    }
}

function do_cp($url) {
    global $c_cp;
    return $url . $c_cp->extension;
}