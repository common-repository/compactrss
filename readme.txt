=== CompactRSS ===
Contributors: arnomnl
Tags: rss, filter, feed, gadget, widget, hide
Requires at least: 2.0
Tested up to: 2.9.2
Stable tag: 1.0

Gives you the possibility to exclude certain parts of your posts automatically from the RSS feed.

== Description ==

This plug-in makes it possible to exclude certain parts of your posts in your feeds.
It uses the filterhooks `the_content` (in combination with `is_feed()`) and `the_content_rss`.

You have several options to determine what must be excluded; you can hide everything after the *More*-tag and/or hide everything between `<!--crss-->` and `<!--/crss-->`
Since update 1.1 you may use multiple CRSS-tags in a post.

== Installation ==

1. Uploaded the extracted folder to your WordPress plug-ins directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Edit the CompactRSS settings (Settings, CompactRSS).

== Frequently Asked Questions ==

= I have a question that's not listed. =

Try to figure it out yourself, or contact the author!

== Changelog ==

= 1.1 =
* Changed the filter so it is possible to use multiple CRSS-tags in a single post

== Screenshots ==

1. CompactRSS 1.0 Settings