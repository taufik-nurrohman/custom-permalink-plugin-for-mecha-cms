Custom Permalink Plugin for Mecha CMS
=====================================

> Custom permanent link.

Permalink is a permanent link to your blog article. By default, **Mecha** allows you to modify the article URL pattern by changing the name of the base slug of the article URL to be like what you want via the configuration page. This plugin allows you to do more, not just to change the base slug name, but also to change the structure of the URL segment totally.

### Supported Patterns

With or without extension.

~~~ .no-highlight
:base/:id
:base/:id/:slug
:base/:slug (default)
:base/:year/:month/:day/:slug
:base/:year/:month/:slug
:base/:year/:slug
:id
:id/:slug
:slug
:year/:month/:day/:slug
:year/:month/:slug
:year/:slug
~~~

Upload the `custom-permalink` folder along with its contents through the plugin uploader. You need to compress the folder into a ZIP file to simplify the uploading process. After that, go to the plugin manager page and follow the instructions on the **About** tab.