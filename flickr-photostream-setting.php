<?php
/* 
Flickr Photostream
Version: 1.3
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
		if(get_option('$flickr_photostream_noPages')){
			delete_option('$flickr_photostream_noPages');
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
	$flickr_photostream_noPages_default = '1';
	$flickr_photostream_lightbox_default = '0';
	$flickr_photostream_captions_default = '1';
	$flickr_photostream_margins_saved = '1';


	//Get Values
	$flickr_photostream_userID_saved = get_option('$flickr_photostream_userID', "");
	$flickr_photostream_APIKey_saved = get_option('$flickr_photostream_APIKey', "");
	$flickr_photostream_imagesHeight_saved = (int)get_option('$flickr_photostream_imagesHeight', $flickr_photostream_imagesHeight_saved);
	$flickr_photostream_maxPhotosPP_saved = (int)get_option('$flickr_photostream_maxPhotosPP', $flickr_photostream_maxPhotosPP_default);
	$flickr_photostream_justifyLastRow_saved = (int)get_option('$flickr_photostream_justifyLastRow', $flickr_photostream_justifyLastRow_default);
	$flickr_photostream_fixedHeight_saved = (int)get_option('$flickr_photostream_fixedHeight', $flickr_photostream_fixedHeight_default);
	$flickr_photostream_noPages_saved = (int)get_option('$flickr_photostream_noPages', $flickr_photostream_noPages_default);
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
        $flickr_photostream_noPages_saved = ((int)$_POST["flickr_photostream_noPages"] != 0)? 1:0;
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
	        update_option( '$flickr_photostream_noPages', $flickr_photostream_noPages_saved );
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
		   
	<div class="wrap">
		<h2>Flickr Photostream</h2>

		<h3><?php _e('Help', 'flickr-photostream' ); ?></h3>
		<p>
			<?php _e('To display a Photostream, with the default values, create a page and put the shortcode: <code>[flickrps]</code>', 'flickr-photostream' ); ?>
		</p>
		<p>
			<?php _e('You can use the attributes to have settings that are different than the default:', 'flickr-photostream' ); ?>
			<div>
				<?php _e('For example:', 'flickr-photostream' ); ?>
				<div style="margin-left: 30px">
					<pre>[flickrps max_num_photos="50" no_pages="true"]</pre>
					<?php _e('displays the latest 50 photos of the default user photostream, without any page navigation. (the other settings are the default)', 'flickr-photostream' ); ?>
				</div>
			</div>
		</p>

		

		<form method="post" name="options" target="_self">
			<h3><?php _e('Global Settings', 'flickr-photostream' ); ?></h3>

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

			<h3><?php _e('Default Settings', 'flickr-photostream' ); ?></h3>

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
					<th scope="row"><?php _e('No pages', 'flickr-photostream' ); ?></th>
					<td>
						<label for="flickr_photostream_noPages">
							<input type="checkbox" name="flickr_photostream_noPages" 
								<?php if($flickr_photostream_noPages_saved == 1){ echo('checked="checked"'); }; ?> 
								value="1" 
								style="margin-right:5px"
							/>
							<?php _e('If enabled, no navigation button will be shown, in this way you will show only the newer photos.<br/><i>Use only one instance per page with this settings disabled!</i>', 'flickr-photostream' ); ?></li>
							<div><?php echo( __('You can use the <code>', 'flickr-photostream') . 'no_pages' . __('</code> attribute to change this default value (with the value <code>true</code> or <code>false</code>)', 'flickr-photostream') ); ?></div>
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

			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Save Changes', 'flickr-photostream' ); ?>" />
			</p>
		</form>
	</div>

<?php 
}
?>