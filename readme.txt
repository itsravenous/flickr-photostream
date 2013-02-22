=== Flickr Photostream ===
Contributors: miro.mannino
Donate link: http://miromannino.com
Tags: photography, gallery, photo, flickr, photo stream, justified, grid
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt

Just your beautiful Flickr Photostream. In a Justified Grid.

== Description ==

Plugin that allows you to show your Flickr Photostream in your blog.

Awesome thumbnails disposition with a **justified grid**, calculated by a fast Javascript algorithm!

You can **configure the height of the rows** to have a grid that can be *like the justified grid of Flickr or of Google+*. But, you can do more! For example you can *configure the margin between the images*, or decide if you want to justify the last row or not!

You can configure the plugin to create rows with fixed height, or to create rows where the height depends on the bigger images.

You can decide if you want the **captions**, to show the titles of the photos, they appear when the mouse is over the photo.

You can configure a gallery to show photos with a link to Flickr or with a **Lightbox** (you must have a Colorbox plugin installed).

You can configure the *maximum number of photos per page*, then, you can **navigate between various pages**. Or if you want, you can show only the latest photos.

The plugin chooses the **right resolution for the image**, using the "Flickr size suffixes", no small images are resized to be bigger and no very big images are resized to be very smaller!


Future improvements
-------------------

In the future I'll release another plugin, based on this one, with a different name, that can show photos, sets, albums and group.


The plugin is available in English and Italian.


See a Live Demo in [Miro Mannino's Blog](http://miromannino.com/my-photos)


Remember that this plugin is not an official Flickr® plugin, any help will be greatly appreciated.

== Installation ==

1. Upload the folder `flickr-photostream` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin settings through the 'Settings > Flickr Photostream' page.
3. Create a page with the shortcode `[flickrps]` (you can add attributes in this shortcode, to have settings that are different than the default)

4. (optional) Install a Colorbox plugin to show the photostream with in a lightbox mode. (i.e. [JQuery Colorbox](http://www.techotronic.de/plugins/jquery-colorbox/))


== Frequently Asked Questions ==

= Can I have in the same blog two photostream of different Flickr's users?  =

Yes, you must use the shortcode attributes (in this case `user_id`) to have settings that are different than the default.


== Screenshots ==

1. A tipical Photosream
2. A Photostream with more pages
3. The settings
3. The captions


== Changelog ==

= 1.5 =
* updated Justified Gallery to version 1.0.2

= 1.4 =
* Now the plugin uses the [Justified Gallery](http://miromannino.com/projects/justified-gallery/) JQuery plugin to build the justified layout.
* Corrected some bugs in the default settings

= 1.3 =
* Algorithm improved, faster and now Internet Explorer compatible
* Added captions
* Now, you can add multiple instance on the same page
* Now, the CSS rules force the scrollbar to be always visible, this to prevent loops
* Fixed some errors
* Usability improved

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

= 1.5 =
* updated Justified Gallery to version 1.0.2

= 1.4 =
* Now the plugin uses the [Justified Gallery](http://miromannino.com/projects/justified-gallery/) JQuery plugin to build the justified layout.

= 1.3 =
* Algorithm improved, faster and now Internet Explorer compatible. Added captions. Now, you can add multiple instance on the same page. Fixed some errors and usability improved.

= 1.2 =
* The images fade-in only when they are completely loaded. Added a loading phase to show the images directly in a justified grid. Deleted the custom Lightbox. Now, to use a lightbox, you need to use a plugin that enable colorbox, in this way you are free to configure the style of the lightbox. Simplified the settings page.

= 1.1 =
* Lightbox, support for multiple gallery instances with different options.

= 1.0.1 =
* Justified grid algorithm disabled for IE8 or lower. Fixed some css issues. Speed improvements on images loading.

= 1.0 =
* First version.