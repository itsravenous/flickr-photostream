<?php  
/* 
Plugin Name: Flickr Photostream
Plugin URI: http://miromannino.it/projects/flickr-photostream/
Description: Shows the flickr photostream
Version: 1.3
Author: Miro Mannino
Author URI: http://miromannino.it/about-me/

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
	wp_register_style('flickrPsCSS', plugins_url('css/flickr-photostream.css', __FILE__));
	wp_register_script('flickrPsJS', plugins_url('js/flickr-photostream-min.js', __FILE__));
	wp_enqueue_style('flickrPsCSS');
	wp_enqueue_script('jquery');
	wp_enqueue_script('flickrPsJS');
}

//[flickrps] shortcode
function flickr_photostream( $atts, $content = null ) {
	$ris = "";
	
	require_once("phpFlickr/phpFlickr.php");

	//Page---------
	$permalink = get_permalink();
    if (strpos($permalink,'?') === false) $permalink .= '?'; else $permalink .= '&';
	global $flickrpsp;
    if(empty($flickrpsp)){ //we use local instance of flickrpsp for the multiple instances
		$l_flickrpsp = 1;
	}else{
		$l_flickrpsp = $flickrpsp;
	}

	//Options-----------------------
	extract( shortcode_atts( array(
		'user_id' => get_option('$flickr_photostream_userID'), // Flickr User ID
		'images_height' => get_option('$flickr_photostream_imagesHeight'), // Flickr images size
		'max_num_photos' => get_option('$flickr_photostream_maxPhotosPP'), // Max number of Photos	
		'justify_last_row' => (get_option('$flickr_photostream_justifyLastRow') == 1 ? 'true' : 'false'),
		'fixed_height' => (get_option('$flickr_photostream_fixedHeight') == 1 ? 'true' : 'false'),
		'lightbox' => (get_option('$flickr_photostream_lightbox') == 1 ? 'true' : 'false'),
		'captions' => (get_option('$flickr_photostream_captions') == 1 ? 'true' : 'false'),
		'no_pages' => (get_option('$flickr_photostream_noPages') == 1 ? 'true' : 'false'),
		'margins' => get_option('$flickr_photostream_margins'),
	), $atts ) );

	$images_height = (int)$images_height;
	if($images_height < 30) $images_height = 30;

	$max_num_photos = (int)$max_num_photos;
	if ($max_num_photos < 1) $max_num_photos = 1;

	$justify_last_row = (strcmp($justify_last_row, 'true') == 0)? TRUE : FALSE;

	$fixed_height = (strcmp($fixed_height, 'true') == 0)? TRUE : FALSE;

	$lightbox = (strcmp($lightbox, 'true') == 0)? TRUE : FALSE;

	$captions = (strcmp($captions, 'true') == 0)? TRUE : FALSE;

	$margins = (int)$margins;
	if ($margins < 0) $margins = 1;
	if ($margins > 30) $margins = 30;

	$no_pages = (strcmp($no_pages, 'true') == 0) ? TRUE : FALSE;
	if($no_pages) $l_flickrpsp = 1;
	//-----------------------------

	//Inizialization---------------
	$flickrAPIKey = get_option('$flickr_photostream_APIKey'); //Flickr API Key
	
	$f = new phpFlickr($flickrAPIKey);
	$upload_dir = wp_upload_dir();
	$f->enableCache("fs", $upload_dir['basedir']."/phpFlickrCache");

	//Errors-----------------------
    if($f->test_echo() == false){
    	return('<div style="color:red">' . __('Invalid Flickr API Key', 'flickr-photostream') . '</div>');	
	}	

	if($f->urls_getUserProfile($user_id) == false){
		return('<div style="color:red">' . __('The user not exists', 'flickr-photostream') . '</div>');	
	}
	
	//Photo loading----------------
    $photos_url = $f->urls_getUserPhotos($user_id);
    $photos = $f->people_getPublicPhotos($user_id, NULL, "description", $max_num_photos, $l_flickrpsp);
    if(count((array)$photos['photos']['photo']) == 0) return(__('No photos', 'flickr-photostream'));

	$ris .= '<!-- Flickr Photostream by Miro Mannino -->'
		 .  '<div class="flickrps-container">'
		 .  '  <div class="flickrps-loading"><div class="flickrps-loading-img"></div></div>'
		 .  '  <div class="flickrps-meta">'
		 .  '    <div class="flickrps-meta-row-height">' . $images_height . '</div>'
		 .  '    <div class="flickrps-meta-justify-last-row">' . ($justify_last_row ? 'true' : 'false') . '</div>'
		 .  '    <div class="flickrps-meta-fixed-height">' . ($fixed_height ? 'true' : 'false') . '</div>'
		 .  '    <div class="flickrps-meta-lightbox">' . ($lightbox ? 'true' : 'false') . '</div>'
		 .  '    <div class="flickrps-meta-captions">' . ($captions ? 'true' : 'false') . '</div>'
		 .  '    <div class="flickrps-meta-margins">' . $margins . '</div>'
		 .  '  </div>'
		 .  '  <div class="flickrps-images">';

	if($images_height <= 75){
		$imgSize = "thumbnail"; //thumbnail (width:100)
	}else if($images_height <= 160){
		$imgSize = "small"; //small (width:240)
	}else{
		$imgSize = "small_320"; //small (width:320)
	}

	$r = 0;
	static $shortcode_unique_id = 0;
    foreach ((array)$photos['photos']['photo'] as $photo) {
		$ris .= '<div class="flickrps-image-un" style="height:' . $images_height . 'px;">';
		if($lightbox){
			$ris .=	
			    ' <a href="' . $f->buildPhotoURL($photo, "large") . '" rel="lightbox[gallery-' . $shortcode_unique_id . ']" title="' . $photo[title] . '">';
		}else{
			$ris .= 
			    ' <a href="' . $photos_url . $photo[id] . '/in/photostream/lightbox/" target="_blank" title="' . $photo[title] . '">';
		}

		$ris .= 
		  '  <img alt="' . $photo[title] . '" src="' . $f->buildPhotoURL($photo, $imgSize) . '" style="height:' . $images_height . 'px;"/>'
		. '	</a>'
		. '</div>';
    }
    $shortcode_unique_id++;

	$ris .= '  </div>' //end of <div class="flickrps-images">
		 .  '</div>'; //end of <div class="flickrps-container">

    //Navigation---------------------
    if(!$no_pages){
		
		$nextPhotos = $f->people_getPublicPhotos($user_id, NULL, "description", $max_num_photos, $l_flickrpsp + 1);
		if(sizeof($nextPhotos['photos']['photo']) > 0 || $l_flickrpsp > 1){
			$ris .= '<div class="page-link">';
		}

		if(sizeof($nextPhotos['photos']['photo']) > 0){
			$ris .= 
			  '<div class="nav-flickrps-next">'
			. '<a href="' . $permalink . 'flickrpsp=' . ((int)$l_flickrpsp + 1) . '">' . __('<span class="meta-nav">&larr;</span> Older photos', 'flickr-photostream') . '</a>'
			. '</div>';
		}

		if($l_flickrpsp > 1){
			$ris .= 
			  '<div class="nav-flickrps-prev">'
			. '<a href="' . $permalink. 'flickrpsp=' . ((int)$l_flickrpsp - 1) . '">' . __('Newer photos <span class="meta-nav">&rarr;</span>', 'flickr-photostream') . '</a>'
			. '</div>';
		}

		if(sizeof($nextPhotos['photos']['photo']) > 0 || $l_flickrpsp > 1){
			$ris .= '</div>';
		}
	}

	return($ris);
}
add_shortcode('flickrps', 'flickr_photostream');

//Options
include("flickr-photostream-setting.php");

?>