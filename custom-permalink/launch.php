<?php

// configuration data
$c_cp = $config->states->{'plugin_' . md5(File::B(__DIR__))};

// include custom route
if($r_cp = File::exist(__DIR__ . DS . 'workers' . DS . $c_cp->pattern . '.php')) {
    // include ...
    require $r_cp;
    // re-write article URL
    Filter::add('article:url', 'do_cp');
    // re-write comment permalink
    Filter::add('comment:permalink', function($url) {
        $url = explode('#', $url);
        $url[0] = do_cp($url[0]);
        return implode('#', $url);
    });
    // re-write blog pager URL
    if($config->page_type === 'article') {
        Filter::add('pager:url', 'do_cp');
    }
    // re-write internal link URL in content if possible
    Filter::add('content', function($content) use($config) {
        $s = $config->url . '/' . $config->index->slug . '/';
        if(strpos($content, ' href="' . $s) === false) return $content;
        return preg_replace_callback('#\s+href="(' . preg_quote($s, '/') . '[a-z0-9\-]+)(["/?\#])#', function($matches) {
            return ' href="' . do_cp($matches[1]) . $matches[2];
        }, $content);
    });
}