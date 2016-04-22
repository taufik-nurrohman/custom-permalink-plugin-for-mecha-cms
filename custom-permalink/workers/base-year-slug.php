<?php

// abort the default pattern
if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
    Shield::abort('404-article');
}

// pattern: `http://localhost/article/2015/slug`
Route::accept($config->index->slug . '/(:num)/(:any)' . $c_cp->extension, function($year = "", $slug = "") use($config) {
    if($path = Get::articlePath($slug)) {
        $s = explode('_', File::N($path));
        $s = explode('-', $s[0]);
        if(File::D($config->url_path) !== $config->index->slug . '/' . $s[0]) {
            Shield::abort('404-article');
        }
    } else {
        Shield::abort('404-article');
    }
    Route::execute($config->index->slug . '/(:any)', array($slug));
}, 1);

// from: `http://localhost/article/slug`
// to: `http://localhost/article/2015/slug`
function do_cp($url) {
    global $config, $c_cp;
    if($path = Get::articlePath(File::B($url))) {
        list($t, $k, $s) = explode('_', File::N($path), 3);
        $t = explode('-', $t);
        return $config->url . '/' . $config->index->slug . '/' . $t[0] . '/' . $s . $c_cp->extension;
    }
    return $url;
}

// fix page types
if(Route::is($config->index->slug . '/(:num)/(:any)' . $c_cp->extension)) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}