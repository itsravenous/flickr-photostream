<?php
/* 
Flickr Photostream
Version: 1.1
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
	}
}

// add the admin options page
add_action('admin_menu', 'flickr_photostream_admin_add_page');
function flickr_photostream_admin_add_page() {
	add_options_page('FlickrPhotostreamSettings', 'Flickr Photostream', 10, 'flickrps', 'flickr_photostream_setting');
}

function flickr_photostream_setting(){

	//Default values
	$flickr_photostream_maxPhotosPP_default = 20;


	//Get Values
	$flickr_photostream_userID_saved = get_option('$flickr_photostream_userID');
	$flickr_photostream_APIKey_saved = get_option('$flickr_photostream_APIKey');
	$flickr_photostream_imagesHeight_saved = get_option('$flickr_photostream_imagesHeight');
	if (strlen($flickr_photostream_imagesHeight_saved) == 0){
		$flickr_photostream_imagesHeight_saved = 'medium';
		update_option( '$flickr_photostream_imagesHeight', $flickr_photostream_imagesHeight_saved );
	}
	$flickr_photostream_maxPhotosPP_saved = (int)get_option('$flickr_photostream_maxPhotosPP');
	if ($flickr_photostream_maxPhotosPP_saved <= 0){
		$flickr_photostream_maxPhotosPP_saved = $flickr_photostream_maxPhotosPP_default;
		update_option( '$flickr_photostream_maxPhotosPP', $flickr_photostream_maxPhotosPP_saved );
	}
	$flickr_photostream_justifyLastRow_saved = (int)get_option('$flickr_photostream_justifyLastRow');
	$flickr_photostream_fixedHeight_saved = (int)get_option('$flickr_photostream_fixedHeight');
	$flickr_photostream_noPages_saved = (int)get_option('$flickr_photostream_noPages');
	$flickr_photostream_lightbox_saved = (int)get_option('$flickr_photostream_lightbox');
	    
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

        $flickr_photostream_imagesHeight_saved = $_POST["flickr_photostream_imagesHeight"];
        if ($flickr_photostream_imagesHeight_saved < 30){
       		$error = true;
       		$error_msg .= '<li>' . __('The \'Images Height\' must be a value greater than 30', 'flickr-photostream' ) . '</li>';
       	}
       	$flickr_photostream_maxPhotosPP_saved = (int)$_POST["flickr_photostream_maxPhotosPP"];
       	if ($flickr_photostream_maxPhotosPP_saved <= 0){
       		$error = true;
       		$error_msg .= '<li>' . __('The \'photos per page\' must be a value greater than 0', 'flickr-photostream' ) . '</li>';
       	}
        $flickr_photostream_justifyLastRow_saved = ((int)$_POST["flickr_photostream_justifyLastRow"] != 0)? 1:0;
        $flickr_photostream_fixedHeight_saved = ((int)$_POST["flickr_photostream_fixedHeight"] != 0)? 1:0;
        $flickr_photostream_noPages_saved = ((int)$_POST["flickr_photostream_noPages"] != 0)? 1:0;
        $flickr_photostream_lightbox_saved = ((int)$_POST["flickr_photostream_lightbox"] != 0)? 1:0;

        if($error == false){
			update_option( '$flickr_photostream_APIKey', $flickr_photostream_APIKey_saved );
	        update_option( '$flickr_photostream_userID', $flickr_photostream_userID_saved );
			update_option( '$flickr_photostream_imagesHeight', $flickr_photostream_imagesHeight_saved );
	        update_option( '$flickr_photostream_maxPhotosPP', $flickr_photostream_maxPhotosPP_saved );
	        update_option( '$flickr_photostream_justifyLastRow', $flickr_photostream_justifyLastRow_saved );
	        update_option( '$flickr_photostream_fixedHeight', $flickr_photostream_fixedHeight_saved );
	        update_option( '$flickr_photostream_noPages', $flickr_photostream_noPages_saved );
	        update_option( '$flickr_photostream_lightbox', $flickr_photostream_lightbox_saved );
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

		<form method="post" name="options" target="_self">
			<table width="10%" cellpadding="10" class="form-table">
				<tr>
					<th>
						<label>Flickr API Key</label>
					</th>
					<td style="width: 10%">
						<input type="text" name="flickr_photostream_APIKey" 
							value="<?php echo($flickr_photostream_APIKey_saved); ?>"
						/> 	
					</td>
					<td>
						<?php _e('Get your Flickr API Key from ', 'flickr-photostream' ); ?><a href="http://www.flickr.com/services/api/" target="_blank">Flickr API</a>
					</td>
				</tr>
			</table>
			
			<h3><?php _e('Default values', 'flickr-photostream' ); ?></h3>
			<table width="10%" cellpadding="10" class="form-table">
				<tr>
					<th>
						<label><?php _e('User ID', 'flickr-photostream' ); ?></label>
					</th>
					<td style="width: 10%">
						<input type="text" name="flickr_photostream_userID"
							value="<?php echo($flickr_photostream_userID_saved); ?>"
						/>
					</td>
					<td>
						<?php _e('Get the User ID from ', 'flickr-photostream' ); ?><a href="http://idgettr.com/" target="_blank">idgettr</a>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('Images Height', 'flickr-photostream' ); ?></label>
					</th>
					<td>
						<input type="text" name="flickr_photostream_imagesHeight" 
							value="<?php echo($flickr_photostream_imagesHeight_saved); ?>"
						/> 	
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('Photos per page', 'flickr-photostream' ); ?></label>
					</th>
					<td>
						<input type="text" name="flickr_photostream_maxPhotosPP" 
							value="<?php echo($flickr_photostream_maxPhotosPP_saved); ?>"
						/> 	
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('Justify Last Row', 'flickr-photostream' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="flickr_photostream_justifyLastRow" 
							<?php if($flickr_photostream_justifyLastRow_saved == 1){ echo('checked="checked"'); }; ?> 
							value="1" 
						/>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('Fixed Height', 'flickr-photostream' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="flickr_photostream_fixedHeight" 
							<?php if($flickr_photostream_fixedHeight_saved == 1){ echo('checked="checked"'); }; ?> 
							value="1" 
						/>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('No pages', 'flickr-photostream' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="flickr_photostream_noPages" 
							<?php if($flickr_photostream_noPages_saved == 1){ echo('checked="checked"'); }; ?> 
							value="1" 
						/>
					</td>
				</tr>
				<tr>
					<th>
						<label><?php _e('Lightbox', 'flickr-photostream' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="flickr_photostream_lightbox" 
							<?php if($flickr_photostream_lightbox_saved == 1){ echo('checked="checked"'); }; ?> 
							value="1" 
						/>
					</td>
				</tr>
			</table>

			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Save Changes', 'flickr-photostream' ); ?>" />
			</p>
		</form>

		<h3><?php _e('Help', 'flickr-photostream' ); ?></h3>
		<p>
			<?php _e('To display a Photostream, with the default values, create a page and put the shortcode: <code>[flickrps]</code>', 'flickr-photostream' ); ?>
		</p>
		<p>
			<?php _e('You can use the following attributes to change the instances behaviour:', 'flickr-photostream' ); ?>
			<ul>
				<li><?php _e('<code>user_id</code>: the user ID (i.e. <code>51035555243@N01</code>)', 'flickr-photostream' ); ?></li>
				<li><?php _e('<code>images_height</code>: height of the images (in px)', 'flickr-photostream' ); ?></li>
				<li><?php _e('<code>max_num_photos</code>: max number of photos per page', 'flickr-photostream' ); ?></li>
				<li><?php _e('<code>justify_last_row</code>: justify the last row (<code>true</code> or <code>false</code>). If <code>true</code> the last images can be very bigger than the others.', 'flickr-photostream' ); ?></li>
				<li><?php _e('<code>fixed_height</code>: fix the height of the row (<code>true</code> or <code>false</code>)', 'flickr-photostream' ); ?></li>
				<li><?php _e('<code>no_pages</code>: use or not the pages (<code>true</code> or <code>false</code>). In this way, you can show only the first page with the later photos.', 'flickr-photostream' ); ?></li>
				<li><?php _e('<code>lightbox</code>: lightbox or not the images (<code>true</code> or <code>false</code>).', 'flickr-photostream' ); ?></li>
			</ul>
		</p>
		<p>
			<?php _e('For example:', 'flickr-photostream' ); ?>
			<div style="margin-left: 30px">
				<pre>[flickrps max_num_photos="50" no_pages="true"]</pre>
				<?php _e('displays the latest 50 photos of the default user photostream, without any page navigation.', 'flickr-photostream' ); ?>
			</div>
		</p>
	</div>

<?php 
}
?>