<?php
/*
Plugin Name: CompactRSS
Plugin URI: http://arnom.nl/wp/compactrss
Description: Gives you the possibility to exclude certain parts of your posts automatically from the RSS feed.
Version: 1.0
Author: Arno Moonen
Author URI: http://www.arnom.nl/

Copyright 2008 Arno Moonen  (email : arnom@itavero.nl)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// The actual filter (where the magic happens)
function filter_compactrss_rss($content) {
	$original = $content;
	if(get_option("compactrss_hide_more") == "on"){
		$StrPos = stripos($content, "<span id=\"more-");
		if($StrPos !== false) $content = substr($content,0,$StrPos);
	}
	if(get_option("compactrss_hide_crss") == "on") $content = eregi_replace("\<!--crss--\>.+\<!--/crss--\>","",$content);
	if(get_option("compactrss_show_link") == "on" && $original !== $content) $content .= "\n<br /><a href=\"".get_permalink()."\">".get_option("compactrss_link_text")."</a>";
	return $content;
}

// The content filter for the_content when it's actually  a feed
function filter_compactrss_content($content) {
	if(is_feed()) return filter_compactrss_rss($content);
	else return $content;
}

// CompactRSS Settings Page
function compactrss_page_settings() {
	if (function_exists("add_options_page")) {
		add_options_page("CompactRSS", "CompactRSS", 1, basename(__FILE__), "compactrss_output_page_settings");
	}
}

function compactrss_output_page_settings() {
	//Add options if first time running
	add_option("compactrss_hide_more","off");
	add_option("compactrss_hide_crss","on");
	add_option("compactrss_show_link","off");
	add_option("compactrss_link_text",__("Read more","compactrss"));
	
	// Output the form
	echo "<div class=\"wrap\"><h2>CompactRSS<br />".__("Settings","compactrss")."</h2>\n<form method=\"post\" action=\"options.php\">";
    wp_nonce_field('update-options');
	echo "<table class=\"form-table\">";
	echo "<tr valign=\"top\"><th scope=\"row\">".__("Hide all content after","compactrss")." <pre>".htmlspecialchars("<!--more-->")."</pre></th><td>";
    echo "<select name=\"compactrss_hide_more\"><option value=\"on\"";
	if(get_option("compactrss_hide_more") == "on") echo " selected=\"selected\"";
	echo ">".__("On","compactrss")."</option><option value=\"off\"";
	if(get_option("compactrss_hide_more") == "off") echo " selected=\"selected\"";
	echo ">".__("Off","compactrss")."</option></select></td></tr>";
	echo "<tr valign=\"top\"><th scope=\"row\">".__("Hide all content between","compactrss")." <pre>".htmlspecialchars("<!--crss-->")."</pre><pre>".htmlspecialchars("<!--/crss-->")."</pre></th><td>";
    echo "<select name=\"compactrss_hide_crss\"><option value=\"on\"";
	if(get_option("compactrss_hide_crss") == "on") echo " selected=\"selected\"";
	echo ">".__("On","compactrss")."</option><option value=\"off\"";
	if(get_option("compactrss_hide_crss") == "off") echo " selected=\"selected\"";
	echo ">".__("Off","compactrss")."</option></select></td></tr>";
	echo "<tr valign=\"top\"><th scope=\"row\">".__("Include a permalink if the post was altered","compactrss")."</th><td>";
    echo "<select name=\"compactrss_show_link\"><option value=\"on\"";
	if(get_option("compactrss_show_link") == "on") echo " selected=\"selected\"";
	echo ">".__("On","compactrss")."</option><option value=\"off\"";
	if(get_option("compactrss_show_link") == "off") echo " selected=\"selected\"";
	echo ">".__("Off","compactrss")."</option></select></td></tr>\n<tr valign=\"top\"><th scope=\"row\">".__("Text for the permalink","compactrss")."</th><td>\n<input type=\"text\" name=\"compactrss_link_text\" value=\"".get_option("compactrss_link_text")."\" /></td></tr></table>";
	echo "<input type=\"hidden\" name=\"action\" value=\"update\" /><input type=\"hidden\" name=\"page_options\" value=\"compactrss_hide_more,compactrss_hide_crss,compactrss_show_link,compactrss_link_text\" />";
	echo "<input type=\"submit\" name=\"Submit\" value=\"".__("Submit changes","compactrss")."\" /></form></div>";
}

// Hooks
add_filter("the_content_rss", "filter_compactrss_rss");
add_filter("the_content", "filter_compactrss_content");
add_action("admin_menu", "compactrss_page_settings");

// Language Files And Stuff
load_plugin_textdomain("compactrss", PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)), dirname(plugin_basename(__FILE__)));
?>