=== One-liners ===
Contributors: thebrent
Tags: one liners, quotes, widgets, shortcodes
Requires at least: 3.0.1
Tested up to: 4.11
Stable tag: 3.1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom post type for short oneliners, including a widget and shortcode.

== Description ==

A custom post type, shortcode, and widget to display random one-line quips on your site. Can be used for random quotes, jokes, etc.

== Installation ==

1. Upload the contents of the zip file to the `/wp-content/plugins/` directory or use the WordPress plugin uploader.
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What is the format and parameters for the shortcode? =

	random-oneliner
	
The shortcode can take any parameters that the [`WP_Query()`](http://codex.wordpress.org/Class_Reference/WP_Query#Parameters) object can take, with the exception of `post_type`. The defaults are: `posts_per_page="1" orderby="rand"`

In addition, the `display_as_link` parameter can be set to `true` to output the oneliner with it's permalink.


== Changelog ==

= 3.1.0 =
* Added options for custom slug

= 3.0.0 =
* Total and complete update
* Renamed to One Liners
* Restructured the base class
* Created a dedicated widget class
* Activation/deactivation hook
* Options for displaying quote as link

= 2.0.0 =
* Updated names and post type cause it was more clear

= 1.1.1 =
* security update on shortcode

= 1.1.0 =
* added initialization hook: thebrent_oneliners_init;
* added three filter hooks: thebrent_oneliners_random_quote_args, thebrent_oneliners_random_quote, thebrent_oneliners_show;
* added the ability to parametarize the shortcode

= 1.0.0 =
* moved everything into a class; added internationalization capability

= 0.4.0 =
* added widget

= 0.3.0 =
* added shortcode

= 0.2.2 =
* added post type icon

= 0.2.1 =
* added menu icons

= 0.2.0 =
* not sure why it went to 1.1, but it did

= 0.1.0 =
* First stable working version

== Upgrade Notice ==

= 3.0.0 =
This update will completely break compatibility with previous versions. The name has been changed to prevent conflicts, and there was a complete rebuild of the class structure.

= 1.1.1 =
This update fixes a security issue where the shortcode parameters could be used to query any post type in the system.

== Use and Options ==

= Options =
Options are accessible under the 'Oneliners' menu. The only option is the slug for the post type.

= Widget =
The widget has only two options: "Title" and "Display as permalink".

= Shortcode =
	random-oneliner
	
The shortcode can take any parameters that the [`WP_Query()`](http://codex.wordpress.org/Class_Reference/WP_Query#Parameters) object can take, with the exception of `post_type`. The defaults are: `posts_per_page="1" orderby="rand"`

In addition, the `display_as_link` parameter can be set to `true` to output the oneliner with it's permalink.
