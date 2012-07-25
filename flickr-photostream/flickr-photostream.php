<?php  
/* 
Plugin Name: Flickr Photostream
Plugin URI: http://miromannino.it/...
Description: Shows the flickr photostream
Version: 1.0
Author: Miro Mannino
Author URI: http://miromannino.it

Copyright 2012 Miro Mannino (miro.mannino@gmail.com)
thanks to Dan Coulter for phpFlickr Class (dan@dancoulter.com)

This file is part of Flickr Photostream.

Flickr Photostream is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

Flickr Photostream is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with Flickr 
Photostream Wordpress Plugin.  If not, see <http://www.gnu.org/licenses/>.
*/

//Add the link to the plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'flickrps_plugin_settings_link' );
function flickrps_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=flickrps.php">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

//Activation hook, we check that the upload dir is writable
register_activation_hook( __FILE__ , 'flickrps_plugin_activate');
if(!function_exists( 'flickrps_plugin_uninstall')){
	function flickrps_plugin_activate(){
		$upload_dir = wp_upload_dir();
		@mkdir($upload_dir['basedir'].'/phpFlickrCache');
		if(!is_writable($upload_dir['basedir'].'/phpFlickrCache')){
			deactivate_plugins(basename(__FILE__)); // Deactivate ourself
        	wp_die(__('Flickr Photostream can\'t be activated: the cache Folder is not writable', 'flickr-photostream') 
        		. ' (' . $upload_dir['basedir'] .'/phpFlickrCache' . ')'
        	);
		}
	}
}

//Add the language and the permalink
add_action('init', 'flickrps_init');
function flickrps_init() {
	/* languages */
	load_plugin_textdomain('flickr-photostream', false, dirname(plugin_basename( __FILE__ )) . '/languages/');
	
	/* add custom permalink */
	/*global $wp_rewrite;
	$wp_rewrite->add_rule('flickr-photostream/page/([0-9]+)/?$', 'index.php?pagename=flickr-photostream&flickrpsp=$matches[1]', 'top');
	$wp_rewrite->add_rule('flickr-photostream/page/([0-9]+)?$', 'index.php?pagename=flickr-photostream&flickrpsp=$matches[1]', 'top');
	$wp_rewrite->flush_rules();*/
}

//Add the vars so that WP recognizes it
add_filter('query_vars','flickrps_insert_query_vars');
function flickrps_insert_query_vars( $vars ) {
    array_push($vars, 'flickrpsp');
    return $vars;
}

//Register with hook 'wp_enqueue_scripts' which can be used for front end CSS and JavaScript
add_action('wp_enqueue_scripts', 'addFlickrPhotostreamCSSandJS');
function addFlickrPhotostreamCSSandJS() {
	wp_register_style('flickrPhotostreamCSS', plugins_url('css/flickr-photostream.css', __FILE__));
	wp_register_script('flickrPhotostreamJS', plugins_url('js/flickr-photostream-min.js', __FILE__));
	wp_enqueue_style('flickrPhotostreamCSS');
	wp_enqueue_script('jquery');
	wp_enqueue_script('flickrPhotostreamJS');
}

//Substitute the [flickrps] shortcode with the gallery
add_shortcode('flickrps', 'flickr_photostream');
function flickr_photostream() {  

	require_once("phpFlickr.php");
	$ris = "";

	$permalink = get_permalink();
    if (strpos($permalink,'?') === false) $permalink .= '?'; else $permalink .= '&';

	/* Page */
	global $flickrpsp;
    if(empty($flickrpsp)) $flickrpsp = 1;

	/* Options */
	$userID = get_option('$flickr_photostream_userID'); // Flickr User ID
	$flickrAPIKey = get_option('$flickr_photostream_APIKey'); //Flickr API Key
	$imagesHeight = (int)get_option('$flickr_photostream_imagesHeight'); //Flickr images size
	$maxNumPhotos = (int)get_option('$flickr_photostream_maxPhotosPP'); // Max number of Photos
	$justifyLastRow = (int)get_option('$flickr_photostream_justifyLastRow'); 
	$fixedHeight = (int)get_option('$flickr_photostream_fixedHeight'); 

	$f = new phpFlickr($flickrAPIKey);
	$upload_dir = wp_upload_dir();
	$f->enableCache("fs", $upload_dir['basedir']."/phpFlickrCache");
	
    $photos_url = $f->urls_getUserPhotos($userID);
    $photos = $f->people_getPublicPhotos($userID, NULL, "description", $maxNumPhotos, $flickrpsp);

	$ris .= 
	  '<script type="text/javascript">'
	. '	var rowHeight = ' . $imagesHeight . ';' 
	. '	var justifyLastRow = ' . (($justifyLastRow != 0)?"true":"false") . ';'
	. ' var fixedHeight = ' . (($fixedHeight != 0)?"true":"false") . ';'
	. '</script>'
	. '<style type="text/css">'
	. '	.flickrps-image-un { height: ' . $imagesHeight . 'px; }'
	. '	.flickrps-image-un img { height: ' . $imagesHeight . 'px; }'
	. '	#flickrps-row { height: ' . $imagesHeight . 'px; }'
	. '</style>';

	$ris .= '<div id="content-flickrps">';

	$r = 0;
    foreach ((array)$photos['photos']['photo'] as $photo) {
		$ris .= 
		  '<div class="flickrps-image-un">'
		. '	<a href="' . $photos_url . $photo[id] . '/in/photostream/lightbox/" target="_blank">'
		. '		<img alt="' . $photo[title] . '" src="' . $f->buildPhotoURL($photo, 'thumbnail') . '"/>'
		. '	</a>'
		. '</div>';
    }

    $ris .= '</div>';

	//Navigation
	$nextPhotos = $f->people_getPublicPhotos($userID, NULL, "description", $maxNumPhotos, $flickrpsp + 1);
	if(sizeof($nextPhotos['photos']['photo']) > 0 || $flickrpsp > 1){
		$ris .= '<div class="page-link">';
	}

	if(sizeof($nextPhotos['photos']['photo']) > 0){
		$ris .= 
		  '<div class="nav-flickrps-next">'
		. '<a href="' . $permalink . 'flickrpsp=' . ((int)$flickrpsp + 1) . '">' . __('<span class="meta-nav">&larr;</span> Older photos', 'flickr-photostream') . '</a>'
		. '</div>';
	}

	if($flickrpsp > 1){
		$ris .= 
		  '<div class="nav-flickrps-prev">'
		. '<a href="' . $permalink. 'flickrpsp=' . ((int)$flickrpsp - 1) . '">' . __('Newer photos <span class="meta-nav">&rarr;</span>', 'flickr-photostream') . '</a>'
		. '</div>';
	}

	if(sizeof($nextPhotos['photos']['photo']) > 0 || $flickrpsp > 1){
		$ris .= '</div>';
	}

	return($ris);
}  

//Options
include("flickr-photostream-setting.php");

?>