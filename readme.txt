=== Flickr Photostream ===
Contributors: miro.mannino
Donate link: http://miromannino.it
Tags: photography, gallery, photo, flickr, photo stream, justified, grid
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt

Just your beautiful Flickr Photostream. In a Justified Grid.

== Description ==

Plugin that allows you to show your Flickr Photostream in your blog. 
Awesome thumbnails disposition with a **justified grid**, with a Javascript algorithm, for a fast redraw. 
Various settings to **configure the height of the rows** and the behaviour of the last.
You can configure a gallery to show photos with a link to Flickr or with a Lightbox (Colorbox).
You can configure the number of photos per page, then, you can navigate between various pages. 
You can configure the plugin to create fixed height rows or to create rows where the height depends on the images. 
The plugin chooses the right resolution for the image, using the Flickr size suffixes (for example, if you decide to justify the last row, the images in the last row can be bigger than the others, so for these photos will be used suffixes to have larger photos).

See a Live Demo in [Miro Mannino's Blog](http://miromannino.it/my-photos)

Remember that this plugin is not an official Flickr® plugin, any help will be greatly appreciated.

Future improvements
-------------------

- Optional error message for IE8 or lower
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

= Can I configure the plugin to show the titles?  =

No. I will do this in the future.

= Does the justified grid algorithm works in IE8 or lower? =

No. The plugin disables the justified grid algorithm if IE is lower than 9 (and it shows an error message).


== Screenshots ==

1. A tipical Photosream
2. A Photostream with more pages
3. The settings


== Changelog ==

= 1.2 =
* Deleted the custom Lightbox. Now, to use a lightbox, you need to use a plugin that enable colorbox.
* Added error message if the plugin doesn't find a plugin that enable colorbox.
* Added a loading phase to show the images directly in a justified grid.
* The images fade-in only when they are completely loaded.
* Simplified the settings page.
* Fixed an issue of the "IE8 or lower error message" in case of multiple gallery per page.

= 1.1 =
* Optional Lightbox
* Option to use or not the pages
* Support for multiple gallery instances
* All options is now "default options", every instance can have different options
* Now, you can have different instances that show different user photostreams

= 1.0.1 =
* Justified grid algorithm disabled for IE8 or lower
* Error message for IE8 or lower
* Fixed some css issues
* Speed improvements to the images loading

= 1.0 =
* First version


== Upgrade Notice ==

= 1.2 =
* The images fade-in only when they are completely loaded.
* Added a loading phase to show the images directly in a justified grid.
* Deleted the custom Lightbox. Now, to use a lightbox, you need to use a plugin that enable colorbox, in this way you are free to configure the style of the lightbox.
* Simplified the settings page.

= 1.1 =
* Lightbox, support for multiple gallery instances with different options.

= 1.0.1 =
* Justified grid algorithm disabled for IE8 or lower. Fixed some css issues. Speed improvements on images loading.

= 1.0 =
* First version