<?php

// abort the default pattern
if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
    Shield::abort('404-article');
}

// pattern: `http://localhost/article/123/slug`
Route::accept($config->index->slug . '/(:num)/(:any)' . $c_cp->extension, function($id = "", $slug = "") use($config) {
    if( ! Get::articlePath($id)) {
        Shield::abort('404-article');
    }
    Route::execute($config->index->slug . '/(:any)', array($slug));
}, 1);

// from: `http://localhost/article/slug`
// to: `http://localhost/article/123/slug`
function do_cp($url) {
    global $config, $c_cp;
    $path = Get::articlePath(File::B($url));
    if($path = Get::articleExtract($path)) {
        return $config->url . '/' . $config->index->slug . '/' . $path['id'] . '/' . $path['slug'] . $c_cp->extension;
    }
    return $url;
}

// fix page types
if(Route::is($config->index->slug . '/(:num)/(:any)' . $c_cp->extension)) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}