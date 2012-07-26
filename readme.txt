=== Flickr Photostream ===
Contributors: miro.mannino
Donate link: http://miromannino.it
Tags: photography, gallery, photo, flickr, photo stream, justified, grid
Requires at least: 3.4
Tested up to: 3.4.1
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt

Just your beautiful Flickr Photostream. In a Justified Grid.

== Description ==

Plugin that allows you to show your Flickr Photostream in your blog. Awesome thumbnails disposition with a **justified grid**, with a Javascript algorithm, for a fast redraw. Various settings to **configure the height of the rows** and the behaviour of the last. You can configure the maximum photos per page, then, you can navigate between various pages. You can configure the plugin to create fixed height rows or to create rows where the height depends on the images. The plugin choose the right resolution for the image, using the Flickr size suffixes (for example, if you decide to justify the last row, the images in the last row can are bigger than the others, so for these photos will be used suffixes to have larger photos).

See a Live Demo in [Miro Mannino's Blog](http://miromannino.it/my-photos)

Remember that this plugin is not an official Flickr® plugin, but just a student's work, any help will be greatly appreciated.

Future improvements
-------------------

- Optional error message for IE8 or lower
- Support for multiple gallery instances
- Format options and UserID options in shortcodes (to support multiple instances)
- Option to hide the pages navigations (to only show the latest photos)
- Option to open images in a lightbox instead in Flickr
- Order for most recent, popular, commented, rated
- Show photos per Set, Album or Group

Thanks to [MacItaly](http://wordpress.org/support/profile/macitaly) for the improvements suggestions.

Compatibility
-------------

**Compatible Browsers**: Chrome, Firefox, Safari, Opera, IE9, Chrome for Android, Android Browser

**Incompatible browsers**: IE8 or lower


== Installation ==

1. Upload the folder `flickr-photostream` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create a page with the shortcode `[flickrps]`


== Frequently Asked Questions ==

= You can configure the plugin to show you more than one Flickr user's Photostream?  =

No. I will do this in the future.

= You can configure the plugin to show the titles?  =

No. I will do this in the future.

= The justified grid works in IE8 or lower? =

No. I disable the justified grid algorithm if IE is lower than 9 (and I show an error message).


== Screenshots ==

1. A tipical Photosream
2. A Photostream with more pages
3. The settings


== Changelog ==

= 1.0.1 =
* Justified grid algorithm disabled for IE8 or lower
* Error message for IE8 or lower
* Fixed some css issues
* Speed improvements to the images loading

= 1.0 =
* First version


== Upgrade Notice ==

= 1.0.1 =
* Justified grid algorithm disabled for IE8 or lower. Fixed some css issues. Speed improvements on images loading.

= 1.0 =
* First version