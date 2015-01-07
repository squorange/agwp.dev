=== wpautop control ===

Contributors: bigsmoke
Donate link: http://www.bismoke.us/donate/
Tags: wpautop, filter
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 1.3

Adds a global setting to turn the wpautop filter on and off. It also allows you to override this default for any post by adding a wpautop custom field.

== Description ==

This plugin was born out of a very simple need. Back in the day, when the wpautop filter was really sucky, I got annoyed and turned it off for my [blog](http://blog.bigsmoke.us/). However, years later, me (but mostly my co-author, Halfgaar) got equally annoyed by having to manually type in all the angle brackets. I wanted to turn on the filter again, but I didn't want this to affect all my old posts. Hence this plugin. See [this blog post](http://blog.bigsmoke.us/2010/12/09/wpautop) for more history.

== Installation ==

1. Unzip the plugin in the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I turn off automatic formatting for a post? =

Add a custom field called `wpautop` to any post. When set to `false`, `no` or `off`, WordPress will no longer attempt to add `<p>` and `<br>` tags to your posts (so you'll be responsible for adding these yourself).

= How do I turn on automatic formatting for a post? =

You can set the field's value to `true`, `yes` or `on` if you do want WordPress to use its `wpautop` filter to add `<p>` and `<br>` tags for you. (Of course, this only makes sense if you've globally disabled `wpautop` in the included option screen.)

== Changelog ==

= 1.3 =
* Updated description so that it mentions "angle brackets" instead of "curly braces".

= 1.2 =
* Improved readme.txt so that usage instructions turn up in the FAQ instead of in Other Notes.

= 1.1 =
* Clarified option screen. It seemed to be causing confusion.
* Instead of just true/false, you can now also use yes/no or on/off in the wpautop custom field.

= 1.0 =
* First release

