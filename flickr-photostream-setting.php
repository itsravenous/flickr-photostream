<?php
/* 
Flickr Photostream
Version: 1.6
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

//uninstall plugin, remove the options for privacy
register_uninstall_hook( __FILE__, 'flickrps_plugin_uninstall');
if(!function_exists( 'flickrps_plugin_uninstall')){
	function flickrps_plugin_uninstall(){
		if(get_option('$flickr_photostream_userID')){
			delete_option('$flickr_photostream_userID');
		}
		if(get_option('$flickr_photostream_APIKey')){
			delete_option('$flickr_photostream_APIKey');
		}
		if(get_option('$flickr_photostream_maxPhotosPP')){
			delete_option('$flickr_photostream_maxPhotosPP');
		}
		if(get_option('$flickr_photostream_imagesHeight')){
			delete_option('$flickr_photostream_imagesHeight');
		}
		if(get_option('$flickr_photostream_justifyLastRow')){
			delete_option('$flickr_photostream_justifyLastRow');
		}
		if(get_option('$flickr_photostream_fixedHeight')){
			delete_option('$flickr_photostream_fixedHeight');
		}
		if(get_option('$flickr_photostream_pagination')){
			delete_option('$flickr_photostream_pagination');
		}
		if(get_option('$flickr_photostream_lightbox')){
			delete_option('$flickr_photostream_lightbox');
		}
		if(get_option('$flickr_photostream_captions')){
			delete_option('$flickr_photostream_captions');
		}
		if(get_option('$flickr_photostream_margins')){
			delete_option('$flickr_photostream_margins');
		}
	}
}

// add the admin options page
add_action('admin_menu', 'flickr_photostream_admin_add_page');
function flickr_photostream_admin_add_page() {
	add_options_page('FlickrPhotostreamSettings', 'Flickr Photostream', 10, 'flickrps', 'flickr_photostream_setting');
}

function flickr_photostream_setting(){

	//Default values
	$flickr_photostream_imagesHeight_default = '120';
	$flickr_photostream_maxPhotosPP_default = '20';
	$flickr_photostream_justifyLastRow_default = '1';
	$flickr_photostream_fixedHeight_default = '0';
	$flickr_photostream_pagination_default = '0';
	$flickr_photostream_lightbox_default = '0';
	$flickr_photostream_captions_default = '1';
	$flickr_photostream_margins_default = '1';


	//Get Values
	$flickr_photostream_userID_saved = get_option('$flickr_photostream_userID', "");
	$flickr_photostream_APIKey_saved = get_option('$flickr_photostream_APIKey', "");
	$flickr_photostream_imagesHeight_saved = (int)get_option('$flickr_photostream_imagesHeight', $flickr_photostream_imagesHeight_default);
	$flickr_photostream_maxPhotosPP_saved = (int)get_option('$flickr_photostream_maxPhotosPP', $flickr_photostream_maxPhotosPP_default);
	$flickr_photostream_justifyLastRow_saved = (int)get_option('$flickr_photostream_justifyLastRow', $flickr_photostream_justifyLastRow_default);
	$flickr_photostream_fixedHeight_saved = (int)get_option('$flickr_photostream_fixedHeight', $flickr_photostream_fixedHeight_default);
	$flickr_photostream_pagination_saved = (int)get_option('$flickr_photostream_pagination', $flickr_photostream_pagination_default);
	$flickr_photostream_lightbox_saved = (int)get_option('$flickr_photostream_lightbox', $flickr_photostream_lightbox_default);
	$flickr_photostream_captions_saved = (int)get_option('$flickr_photostream_captions', $flickr_photostream_captions_default);
	$flickr_photostream_margins_saved = (int)get_option('$flickr_photostream_margins', $flickr_photostream_margins_default);
	    
	//Save Values
    if(isset($_POST['Submit'])){

    	$error = false;
    	$error_msg = "";

		//Check the API Key
		require_once("phpFlickr/phpFlickr.php");
		$flickr_photostream_APIKey_saved = $_POST["flickr_photostream_APIKey"];
		$f = new phpFlickr($flickr_photostream_APIKey_saved);

		if($f->test_echo() == false){
			$error = true;
			$error_msg .=  '<li>' . __('API Key is not valid', 'flickr-photostream' ) . '</li>'; 
		}

		$flickr_photostream_userID_saved = $_POST["flickr_photostream_userID"];
		if(!$error){
			if($f->urls_getUserProfile($flickr_photostream_userID_saved) == false){
				$error = true;
				$error_msg .=  '<li>' . __('Invalid UserID', 'flickr-photostream' ) . '</li>'; 		
			}
		}

        $flickr_photostream_imagesHeight_saved = (int)$_POST["flickr_photostream_imagesHeight"];
        if ($flickr_photostream_imagesHeight_saved < 30){
       		$error = true;
       		$error_msg .= '<li>' . __('The \'Images Height\' field must have a value greater than or equal to 30', 'flickr-photostream' ) . '</li>';
       	}
       	$flickr_photostream_maxPhotosPP_saved = (int)$_POST["flickr_photostream_maxPhotosPP"];
       	if ($flickr_photostream_maxPhotosPP_saved <= 0){
       		$error = true;
       		$error_msg .= '<li>' . __('The \'Photos per page\' field must have a value greater than 0', 'flickr-photostream' ) . '</li>';
       	}
        $flickr_photostream_justifyLastRow_saved = ((int)$_POST["flickr_photostream_justifyLastRow"] != 0)? 1:0;
        $flickr_photostream_fixedHeight_saved = ((int)$_POST["flickr_photostream_fixedHeight"] != 0)? 1:0;
        $flickr_photostream_pagination_saved = ((int)$_POST["flickr_photostream_pagination"] != 0)? 1:0;
        $flickr_photostream_lightbox_saved = ((int)$_POST["flickr_photostream_lightbox"] != 0)? 1:0;
        $flickr_photostream_captions_saved = ((int)$_POST["flickr_photostream_captions"] != 0)? 1:0;
        $flickr_photostream_margins_saved = (int)$_POST["flickr_photostream_margins"];
       	if ($flickr_photostream_margins_saved <= 0 || $flickr_photostream_margins_saved > 30){
       		$error = true;
       		$error_msg .= '<li>' . __('The \'Margins\' field must have a value greater than 0, and not greater than 30', 'flickr-photostream' ) . '</li>';
       	}

        if($error == false){
			update_option( '$flickr_photostream_APIKey', $flickr_photostream_APIKey_saved );
	        update_option( '$flickr_photostream_userID', $flickr_photostream_userID_saved );
			update_option( '$flickr_photostream_imagesHeight', $flickr_photostream_imagesHeight_saved );
	        update_option( '$flickr_photostream_maxPhotosPP', $flickr_photostream_maxPhotosPP_saved );
	        update_option( '$flickr_photostream_justifyLastRow', $flickr_photostream_justifyLastRow_saved );
	        update_option( '$flickr_photostream_fixedHeight', $flickr_photostream_fixedHeight_saved );
	        update_option( '$flickr_photostream_pagination', $flickr_photostream_pagination_saved );
	        update_option( '$flickr_photostream_lightbox', $flickr_photostream_lightbox_saved );
	        update_option( '$flickr_photostream_captions', $flickr_photostream_captions_saved );
	        update_option( '$flickr_photostream_margins', $flickr_photostream_margins_saved );
?>
		<div class="updated">
			<p><strong><?php _e('Settings updated.', 'flickr-photostream' ); ?></strong></p>
		</div>
<?php
	    }else{
        
?>
		<div class="updated">
			<p><strong><?php _e('Invalid values, the settings have not been updated', 'flickr-photostream' ); ?></strong></p>
			<ul style="color:red"><?php echo($error_msg); ?></ul>
		</div>
<?php
		}
	}
?>

	<style type="text/css">
		#poststuff h3 { cursor: auto; }
	</style>

		   
	<div class="wrap">
		<h2>Flickr Photostream</h2>

		<div id="poststuff">

			<div class="postbox">

				<h3><?php _e('Help', 'flickr-photostream' ); ?></h3>
				<div class="inside">
					<p>
						<?php _e('To display the default user\'s Photostream, create a page and simply write the shortcode:', 'flickr-photostream' ); ?>
						<div style="margin-left: 30px">
							<pre>[flickrps]</pre>
						</div>
					</p>
					<p>
						<?php _e('However, you can also use the attributes to have settings that are different than the defaults. For example:', 'flickr-photostream' ); ?>
						<div style="margin-left: 30px">
							<pre>[flickrps max_num_photos="50" no_pages="true"]</pre>
							<?php _e('displays the latest 50 photos of the default user Photostream, without any page navigation. (the other settings are the defaults)', 'flickr-photostream' ); ?>
						</div>
					</p>
					<p>
						<?php _e('You can also configure it to show other Photostreams. For example:', 'flickr-photostream' ); ?>
						<div style="margin-left: 30px">
							<pre>[flickrps user_id="67681714@N03"]</pre>
							<?php _e('displays the Photostream of the specified user, no matter what is the default user ID specified in the settings.', 'flickr-photostream' ); ?>
						</div>
					</p>

		
					<h4><?php _e('Sets', 'flickr-photostream' ); ?></h4>
					<p>
						<?php _e('You can also show a particular photo set. You only need to specify its <code>photoset_id</code>, located in the URL.', 'flickr-photostream' ); ?>
						<?php _e('For example, the <code>photoset_id</code> of the photo set located in the URL:', 'flickr-photostream' ); ?>
						<code>http://www.flickr.com/photos/miro-mannino/sets/72157629228993613/</code>
						<?php _e('is: ', 'flickr-photostream' ); ?>
						<code>72157629228993613</code>.
						<?php _e('You can see that it is always the number after the word \'sets\'.', 'flickr-photostream' ); ?>
						<div>
							<?php _e('To show a particular photoset, you need to specify its <code>photoset_id</code> with an attribute. For example:', 'flickr-photostream' ); ?>
							<div style="margin-left: 30px">
								<pre>[flickrps photoset_id="72157629228993613"]</pre>
							</div>
						</div>
					</p>

					<h4><?php _e('Galleries', 'flickr-photostream' ); ?></h4>
					<p>
						<?php _e('You can also show a particular gallery. You only need to specify its <code>gallery_id</code>, located in the URL.', 'flickr-photostream' ); ?>
						<?php _e('For example, the <code>gallery_id</code> of the gallery located in the URL:', 'flickr-photostream' ); ?>
						<code>http://www.flickr.com/photos/miro-mannino/galleries/72157636382842016/</code>
						<?php _e('is: ', 'flickr-photostream' ); ?>
						<code>72157636382842016</code>.
						<?php _e('You can see that it is always the number after the word \'galleries\'.', 'flickr-photostream' ); ?>
						<div>
							<?php _e('To show a particular gallery, you need to specify its <code>gallery_id</code> with an attribute. For example:', 'flickr-photostream' ); ?>
							<div style="margin-left: 30px">
								<pre>[flickrps gallery_id="72157636382842016"]</pre>
							</div>
						</div>
						<?php _e('Remember that the gallery owner is always the specified user. If you specify an user that doesn\'t own the specified gallery, the gallery will not be found.', 'flickr-photostream' ); ?>
					</p>
				</div>
			</div>

			<div class="postbox">

				<h3><?php _e('Settings', 'flickr-photostream' ); ?></h3>
				<div class="inside">

					<form method="post" name="options" target="_self">
						<h4><?php _e('Global Settings', 'flickr-photostream' ); ?></h4>

						<table class="form-table">
							<tr>
								<th scope="row">
									<label>Flickr API Key</label>
								</th>
								<td>
									<label for="flickr_photostream_APIKey">
									<input type="text" name="flickr_photostream_APIKey" 
										value="<?php echo($flickr_photostream_APIKey_saved); ?>"
										style="margin-right:10px"
									/> 	
									<?php _e('Get your Flickr API Key from ', 'flickr-photostream' ); ?><a href="http://www.flickr.com/services/api/keys/" target="_blank">Flickr API</a>
									<div><?php _e('You can\'t use an attribute to change this setting', 'flickr-photostream'); ?></div>
									</label>
								</td>
							</tr>
						</table>

						<h4><?php _e('Default Settings', 'flickr-photostream' ); ?></h4>

						<table class="form-table">
							<tr>
								<th scope="row"><?php _e('User ID', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_userID">
										<input type="text" name="flickr_photostream_userID"
											value="<?php echo($flickr_photostream_userID_saved); ?>"
											style="margin-right:10px"
										/>
										<?php _e('Get the User ID from ', 'flickr-photostream' ); ?><a href="http://idgettr.com/" target="_blank">idgettr</a>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'user_id' . __('</code> attribute to change this default value', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Images Height (in px)', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_imagesHeight">
										<input type="text" name="flickr_photostream_imagesHeight" 
											value="<?php echo($flickr_photostream_imagesHeight_saved); ?>"
										/>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'images_height' . __('</code> attribute to change this default value', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Maximum number of photos per page', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_maxPhotosPP">
										<input type="text" name="flickr_photostream_maxPhotosPP" 
											value="<?php echo($flickr_photostream_maxPhotosPP_saved); ?>"
										/>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'max_num_photos' . __('</code> attribute to change this default value', 'flickr-photostream') ); ?></div>
									</label> 	
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Justify Last Row', 'flickr-photostream' ); ?></th>
								<td>
									<label for="">
										<input type="checkbox" name="flickr_photostream_justifyLastRow" 
											<?php if($flickr_photostream_justifyLastRow_saved == 1){ echo('checked="checked"'); }; ?> 
											value="1"
											style="margin-right:5px"
										/>
										<?php _e('If enabled, the last row will be justified. In this case the last images can be very bigger than the others.', 'flickr-photostream' ); ?></li>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'justify_last_row' . __('</code> attribute to change this default value (with the value <code>true</code> or <code>false</code>)', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Fixed Height', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_fixedHeight">
										<input type="checkbox" name="flickr_photostream_fixedHeight" 
											<?php if($flickr_photostream_fixedHeight_saved == 1){ echo('checked="checked"'); }; ?> 
											value="1"
											style="margin-right:5px"
										/>
										<?php _e('If enabled, each row has the same height, but the images will be cut more.', 'flickr-photostream' ); ?></li>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'fixed_height' . __('</code> attribute to change this default value (with the value <code>true</code> or <code>false</code>)', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Pagination', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_pagination">
										<input type="checkbox" name="flickr_photostream_pagination" 
											<?php if($flickr_photostream_pagination_saved == 1){ echo('checked="checked"'); }; ?> 
											value="1" 
											style="margin-right:5px"
										/>
										<?php _e('If enabled, navigation buttons will be shown, and you can see the older photos.<br/><i>Use only one instance per page with this settings enabled!</i>', 'flickr-photostream' ); ?></li>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'pagination' . __('</code> attribute to change this default value (with the value <code>true</code> or <code>false</code>)', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Lightbox', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_lightbox">
									<input type="checkbox" name="flickr_photostream_lightbox" 
										<?php if($flickr_photostream_lightbox_saved == 1){ echo('checked="checked"'); }; ?> 
										value="1" 
										style="margin-right:5px"
									/>
									<?php echo( __('If enabled, the photo will be shown using <i>colorbox</i>, make sure that you have installed it with a plugin (i.e. ', 'flickr-photostream' ) . '<a href="http://wordpress.org/extend/plugins/jquery-colorbox/">jQuery Colorbox</a>, <a href="http://wordpress.org/extend/plugins/lightbox-plus/">Lightbox Plus</a>)'); ?></li>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'lightbox' . __('</code> attribute to change this default value (with the value <code>true</code> or <code>false</code>)', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Captions', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_captions">
									<input type="checkbox" name="flickr_photostream_captions" 
										<?php if($flickr_photostream_captions_saved == 1){ echo('checked="checked"'); }; ?> 
										value="1" 
										style="margin-right:5px"
									/>
									<?php _e('If enabled, the title of the photo will be shown over the image when the mouse is over. <i>Captions, with the images height too short, become aesthetically unpleasing</i>', 'flickr-photostream'); ?></li>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'captions' . __('</code> attribute to change this default value (with the value <code>true</code> or <code>false</code>)', 'flickr-photostream') ); ?></div>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e('Margin between the images', 'flickr-photostream' ); ?></th>
								<td>
									<label for="flickr_photostream_margins">
										<input type="text" name="flickr_photostream_margins" 
											value="<?php echo($flickr_photostream_margins_saved); ?>"
											style="margin-right:10px"
										/>
										<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'margins' . __('</code> attribute to change this default value', 'flickr-photostream') ); ?></div>
									</label> 	
								</td>
							</tr>
						</table>

						<p>
							<input type="submit" class="button-primary" name="Submit" value="<?php _e('Save Changes', 'flickr-photostream' ); ?>" />
						</p>
					</form>
				</div>
			</div>

			<div class="postbox">
				<h3><?php _e('Help the project', 'flickr-photostream' ); ?></h3>
				<div class="inside">
					<p>
						<?php _e('Help the project to grow. Donate something, or simply <a href="http://wordpress.org/plugins/flickr-photostream" target="_blank">rate the plugin on Wordpress</a>.', 'flickr-photostream' ); ?>
						<form action="https://www.paypal.com/<cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
							">
							<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
							<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
						</form>
					</p>
				</div>
			</div>

		</div>
	</div>

<?php 
}
?>