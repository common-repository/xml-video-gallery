<?php
/*
Plugin Name: XML Video Gallery
Plugin URI: http://www.flashdo.com/item/xml-video-gallery/439
Description: Dynamic video gallery with thumbnail buttons list.
Version: 1.0.0
Author: FlashBlue
Author URI: http://www.flashdo.com/user/flashblue
License: GPL2
*/

/* start global parameters */
	$xmlvideogallery_params = array(
		'count'	=> 0, // number of XML Video Gallery embeds
	);
/* end global parameters */

/* start client side functions */
	function xmlvideogallery_get_embed_code($xmlvideogallery_attributes) {
		global $xmlvideogallery_params;
		$xmlvideogallery_params['count']++;

		$plugin_dir = get_option('xmlvideogallery_path');
		if ($plugin_dir === false) {
			$plugin_dir = 'flashdo/flashblue/xml-video-gallery';
		}
		$plugin_dir = trim($plugin_dir, '/');

		$xml_file_name = !empty($xmlvideogallery_attributes[2]) ? $xmlvideogallery_attributes[2] : 'xml/videogallery.xml';
		$xml_file_path = WP_CONTENT_DIR . "/{$plugin_dir}/{$xml_file_name}";

		if (function_exists('simplexml_load_file')) {
			if (file_exists($xml_file_path)) {
				$data = simplexml_load_file($xml_file_path);
				$width = (int)$data->globals->attributes()->width;
				$height = (int)$data->globals->attributes()->height;
			}
		} elseif ((int)$xmlvideogallery_attributes[4] > 0 && (int)$xmlvideogallery_attributes[6] > 0) {
			$width = (int)$xmlvideogallery_attributes[4];
			$height = (int)$xmlvideogallery_attributes[6];
		} else {
			return '<!-- invalid XML Video Gallery width and / or height -->';
		}

		$swf_embed = array(
			'width' => $width,
			'height' => $height,
			'text' => isset($xmlvideogallery_attributes[7]) ? trim($xmlvideogallery_attributes[7]) : '',
			'component_path' => WP_CONTENT_URL . "/{$plugin_dir}/",
			'swf_name' => 'videogallery.swf',
		);
		$swf_embed['swf_path'] = $swf_embed['component_path'].$swf_embed['swf_name'];

		if (!is_feed()) {
			$embed_code = '<div id="xmlvideogallery'.$xmlvideogallery_params['count'].'">'.$swf_embed['text'].'</div>';
			$embed_code .= '<script type="text/javascript">';
			$embed_code .= "swfobject.embedSWF('{$swf_embed['swf_path']}', 'xmlvideogallery{$xmlvideogallery_params['count']}', '{$swf_embed['width']}', '{$swf_embed['height']}', '9.0.0.0', '', {".($xml_file_name != 'xml/videogallery.xml' ? "xmlUrl: '{$xml_file_name}'" : '')."}, {base: '{$swf_embed['component_path']}', scale: 'noscale', salign: 'tl', wmode: 'transparent', allowScriptAccess: 'sameDomain', allowFullScreen: true }, {});";
			$embed_code.= '</script>';
		} else {
			$embed_code = '<object width="'.$swf_embed['width'].'" height="'.$swf_embed['height'].'">';
			$embed_code .= '<param name="base" value="'.$swf_embed['component_path'].'"></param>';
			$embed_code .= '<param name="movie" value="'.$swf_embed['swf_path'].'"></param>';
			$embed_code .= '<param name="scale" value="noscale"></param>';
			$embed_code .= '<param name="salign" value="tl"></param>';
			$embed_code .= '<param name="wmode" value="transparent"></param>';
			$embed_code .= '<param name="allowScriptAccess" value="sameDomain"></param>';
			$embed_code .= '<param name="allowFullScreen" value="true"></param>';
			$embed_code .= '<param name="sameDomain" value="true"></param>';
			$embed_code .= '<param name="flashvars" value="'.($xml_file_name != 'xml/videogallery.xml' ? '&xmlUrl='.$xml_file_name : '').'"></param>';
			$embed_code .= '<embed type="application/x-shockwave-flash" width="'.$swf_embed['width'].'" height="'.$swf_embed['height'].'" src="'.$swf_embed['swf_path'].'" scale="noscale" salign="tl" wmode="transparent" allowScriptAccess="sameDomain" allowFullScreen="true" flashvars="'.($xml_file_name != 'xml/videogallery.xml' ? '&xmlUrl='.$xml_file_name : '').'"';
			$embed_code .= '></embed>';
			$embed_code .= '</object>';
		}

		return $embed_code;
	}

	function xmlvideogallery_filter_content($content) {
		return preg_replace_callback('|\[xml-video-gallery\s*(xmlUrl="([^"]+)")?\s*(width="([0-9]+)")?\s*(height="([0-9]+)")?\s*\](.*)\[/xml-video-gallery\]|i', 'xmlvideogallery_get_embed_code', $content);
	}

	function xmlvideogallery_echo_embed_code($settings_xml_path = '', $div_text = '', $width = 0, $height = 0) {
		echo xmlvideogallery_get_embed_code(array(2 => $settings_xml_path, 7 => $div_text, 4 => $width, 6 => $height));
	}

	function xmlvideogallery_load_swfobject_lib() {
		wp_enqueue_script('swfobject');
	}
/* end client side functions */

/* start admin section functions */
	function xmlvideogallery_admin_menu() {
		add_options_page('XML Video Gallery Options', 'XML Video Gallery', 'manage_options', 'xmlvideogallery', 'xmlvideogallery_admin_options');
	}

	function xmlvideogallery_admin_options() {
		  if (!current_user_can('manage_options'))  {
	    wp_die(__('You do not have sufficient permissions to access this page.'));
	  }

	  $xmlvideogallery_default_path = get_option('xmlvideogallery_path');
	  if ($xmlvideogallery_default_path === false) {
	  	$xmlvideogallery_default_path = 'flashdo/flashblue/xml-video-gallery';
	  }
?>
<div class="wrap">
	<h2>XML Video Gallery</h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="width: 40em;">SWF and assets path is <?php echo WP_CONTENT_DIR; ?>/</th>
				<td><input type="text" style="width: 25em;" name="xmlvideogallery_path" value="<?php echo $xmlvideogallery_default_path; ?>" /></td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="xmlvideogallery_path" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
<?php
	}
/* end admin section functions */

/* start hooks */
	add_filter('the_content', 'xmlvideogallery_filter_content');
	add_action('init', 'xmlvideogallery_load_swfobject_lib');
	add_action('admin_menu', 'xmlvideogallery_admin_menu');
/* end hooks */

?>