=== Brozzme Automatic Lightbox Blurb in Divi ===
Contributors: Benoti, webstartup
Tags: Divi, blurb, lightbox, automatic, module, page, builder
Donate link: https://brozzme.com/
Requires at least: 4.5
Tested up to: 4.9
Requires PHP: 5.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatic lightbox image for blurb module. Choose post by post.

== Description ==
Brozzme Automatic Lightbox Blurb in Divi add a special metabox on each post when page builder is used. Check the box and every image within a blurb module will embed the lightbox class.

In the blurb module setup, you'll need to copy/paste the image url in the url input to make it work properly. The magic comes in front-end.

There's no option to set for this plugin.

This plugin is made for Divi Theme 3.0+

Link to [Brozzme](https://brozzme.com/ "Benoti") & [Webstartup](https://webstartup.fr/ "Webstartup")


== Installation ==
1. Upload the plugin on wordpress.org and copy the archive to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.


== Frequently Asked Questions ==
= I want to add the metabox to another post types  screen =
That\'s not a matter ! Just use the filter "brozzme_automatic_blurb_lightbox".
Your dedicated function must return an array of all post types.

= I want to apply for all my blurb images to load in the lightbox without editing each page  =

You can use the filter "brozzme_blurb_lightbox_bypass", just add this on your functions.php :
add_filter('brozzme_blurb_lightbox_bypass', 'lightbox_bypass');
function lightbox_bypass(){
    return true;
}

= What else ? =
I made another plugin to add a custom module.
This module adds a Lightbox Blurb where everything is done to simplify the process. No icons, just image, loading in lightbox.

== Screenshots ==
1. Post edit panel screenshot-1.png.

== Changelog ==
= 1.0 =
* Initial release.

== Upgrade Notice ==
= 1.0 =
Initial release