<?php

// abort the default pattern
if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
    Shield::abort('404-article');
}

// pattern: `http://localhost/article/123/slug`
Route::accept($config->index->slug . '/(:num)/(:any)' . $cp_config['extension'], function($id = "", $slug = "") use($config) {
    if( ! Get::articlePath($id)) {
        Shield::abort('404-article');
    }
    Route::execute($config->index->slug . '/(:any)', array($slug));
}, 1);

// from: `http://localhost/article/slug`
// to: `http://localhost/article/123/slug`
function do_custom_permalink($url) {
    global $config, $cp_config;
    $path = Get::articlePath(File::B($url));
    if($path = Get::articleExtract($path)) {
        return $config->url . '/' . $config->index->slug . '/' . $path['id'] . '/' . $path['slug'] . $cp_config['extension'];
    }
    return $url;
}

// fix page types
if(Route::is($config->index->slug . '/(:num)/(:any)' . $cp_config['extension'])) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}