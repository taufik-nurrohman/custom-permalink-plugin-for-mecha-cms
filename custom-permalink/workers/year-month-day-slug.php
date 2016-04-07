<?php

// abort the default pattern
if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
    Shield::abort('404-article');
}

// pattern: `http://localhost/2015/04/21/slug`
Route::accept('(:num)/(:num)/(:num)/(:any)' . $cp_config['extension'], function($year = "", $month = "", $day = "", $slug = "") use($config) {
    if($path = Get::articlePath($slug)) {
        $s = explode('_', File::N($path));
        $s = explode('-', $s[0]);
        if(
            (int) $year !== (int) $s[0] ||
            (int) $month !== (int) $s[1] ||
            (int) $day !== (int) $s[2]
        ) {
            Shield::abort('404-article');
        }
    } else {
        Shield::abort('404-article');
    }
    Route::execute($config->index->slug . '/(:any)', array($slug));
}, 1);

// from: `http://localhost/article/slug`
// to: `http://localhost/2015/04/21/slug`
function do_custom_permalink($url) {
    global $config, $cp_config;
    if($path = Get::articlePath(File::B($url))) {
        list($time, $kind, $slug) = explode('_', File::N($path), 3);
        $time = explode('-', $time);
        return $config->url . '/' . $time[0] . '/' . $time[1] . '/' . $time[2] . '/' . $slug . $cp_config['extension'];
    }
    return $url;
}

// fix page types
if(Route::is('(:num)/(:num)/(:num)/(:any)' . $cp_config['extension'])) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}