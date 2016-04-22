<?php

// pattern: `http://localhost/article/123`
if($c_cp->extension === "") {
    Route::over($config->index->slug . '/(:num)', function($id) use($config) {
        if($path = Get::articlePath($id)) {
            $article = Get::articleExtract($path);
            Route::execute($config->index->slug . '/(:any)', array($article['slug']));
        }
    });
} else {
    // abort the default pattern
    if($config->page_type === 'article' && Route::is($config->index->slug . '/(:any)')) {
        if('.' . File::E($config->url_path) !== $c_cp->extension) {
            Shield::abort('404-article');
        }
    }
    Route::accept($config->index->slug . '/(:num)' . $c_cp->extension, function($id) use($config) {
        if($path = Get::articlePath($id)) {
            $article = Get::articleExtract($path);
            Route::execute($config->index->slug . '/(:any)', array($article['slug']));
        }
    }, 1);
}

// from: `http://localhost/article/slug`
// to: `http://localhost/article/123`
function do_cp($url) {
    global $config, $c_cp;
    $path = Get::articlePath(File::B($url));
    if($path = Get::articleExtract($path)) {
        return $config->url . '/' . $config->index->slug . '/' . $path['id'] . $c_cp->extension;
    }
    return $url;
}

// fix page types
if(Route::is($config->index->slug . '/(:num)' . $c_cp->extension)) {
    $config->page_type = Get::articlePath(File::N($config->url_path)) ? 'article' : 'page';
    Config::set('page_type', $config->page_type);
}