<?php

// configuration data
$cp_config = File::open(PLUGIN . DS . File::B(__DIR__) . DS . 'states' . DS . 'config.txt')->unserialize();

// include custom route
if($cp_route = File::exist(PLUGIN . DS . File::B(__DIR__) . DS . 'workers' . DS . $cp_config['pattern'] . '.php')) {
    // include ...
    require $cp_route;
    // re-write article URL
    Filter::add('article:url', 'do_custom_permalink');
    // re-write comment permalink
    Filter::add('comment:permalink', function($url) {
        $url = explode('#', $url);
        return do_custom_permalink($url[0]) . (isset($url[1]) && trim($url[1]) !== "" ? '#' . $url[1] : "");
    });
    // re-write blog pager URL
    if($config->page_type === 'article') {
        Filter::add('pager:url', 'do_custom_permalink');
    }
    // re-write internal link URL in content if possible
    Filter::add('content', function($content) use($config) {
        if( ! Text::check($content)->has(' href="' . $config->url . '/' . $config->index->slug . '/')) {
            return $content;
        }
        return preg_replace_callback('#\s+href="(' . preg_quote($config->url . '/' . $config->index->slug . '/', '/') . '[a-z0-9\-]+)(["\?\#])#', function($matches) {
            return ' href="' . do_custom_permalink($matches[1]) . $matches[2];
        }, $content);
    });
}