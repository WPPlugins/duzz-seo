<?php
/*
Plugin Name: DUZZ
Description: Duzz SEO Friend takes your WordPress Website to the next level
Version:     1.01
Author:      Saud Ashfaq
Author URI:  https://saudashfaq.wordpress.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

DUZZ is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
DUZZ is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with DUZZ. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


//Enqueue the style sheet and scripts
function duzz_add_style() {
	
	wp_enqueue_style( 'duzz-style', plugins_url( 'duzz-seo/css/duzz-style.css' ) );
}

add_action( 'admin_enqueue_scripts', 'duzz_add_style' );


/*============================== Starts: Meta Boxes =========================================*/
//register meta box
function duzz_register_meta_boxes( $post_type ) {
	
	if( 'post' == $post_type || 'page' == $post_type ) {

		add_meta_box( 'duzz', 'DUZZ SEO FRIEND', 'duzz_display_callback', $post_type, 'advanced', 'default' );	

	}
}

add_action( 'add_meta_boxes', 'duzz_register_meta_boxes' );



//Display meta boxes to collect user input
function duzz_display_callback( $post ) {
	
	wp_nonce_field( plugin_basename(__FILE__), 'duzz_nonce_field' );
	
	$html =		'<div id="duzz_div1">';

		$html .=	'<h4>Google Meta Boxes<h4>';

		$html .=	'<input type="text" id="post_title_tag" name="post_title_tag" value="' . esc_attr( get_post_meta( $post->ID,  'post_title_tag', true) ) . '" placeholder="Title Tag" />';

		$html .=	'<input type="text" name="post_meta_title" value="' . esc_attr( get_post_meta( $post->ID,  'post_meta_title', true) ) . '" placeholder="Meta Title" />';

		$html .=	'<input type="text" name="post_meta_description" value="' . esc_attr( get_post_meta( $post->ID,  'post_meta_description', true) ) . '" placeholder="Meta Description" />';

		$html .=	'<h4>Facebook Meta Boxes<h4>';

		$html .=	'<input type="text" name="og_title" value="' . esc_attr( get_post_meta( $post->ID,  'og_title', true) ) . '" placeholder="Title" />';

		$html .=	'<input type="text" name="og_description" value="' . esc_attr( get_post_meta( $post->ID,  'og_description', true) ) . '" placeholder="Description" />';

		$html .=	'<input type="url" name="og_url" value="' . esc_url_raw( get_post_meta( $post->ID,  'og_url', true) ) . '" placeholder="Link URL" />';

		$html .=	'<input type="text" name="og_image" value= "' . esc_url_raw( get_post_meta( $post->ID,  'og_image', true) ) . '" placeholder="Image URL" />';

	$html .=	'</div>';

	echo $html;
}

//saving meta in DB
function duzz_save_post_meta( $post_id ) {
	
	if ( duzz_user_can_save( $post_id, 'duzz_nonce_field' ) ) {
		
		if ( $_POST ) {

			$post['post_title_tag'] = sanitize_text_field( $_POST['post_title_tag'] );

			$post['post_meta_title'] = sanitize_text_field( $_POST['post_meta_title']);

			$post['post_meta_description'] = sanitize_text_field( $_POST['post_meta_description'] );

			$post['og_title'] = sanitize_text_field( $_POST['og_title'] );

			$post['og_description'] = sanitize_text_field( $_POST['og_description'] );

			$post['og_url'] = esc_url_raw( $_POST['og_url'] );

			$post['og_image'] = esc_url_raw( $_POST['og_image'] );

			foreach ( $post as $key => $val ) {

				update_post_meta($post_id, $key, $val);	
			}
		}
	}
}

add_action( 'save_post', 'duzz_save_post_meta' );
/*============================== Ends: Meta Boxes =========================================*/




/*============================ Starts: Plugin Page in WP Admin ===========================*/


//Duzz plugin menu settings and page settings
function duzz_admin_page_settings() {
	
	$page_title = 'DUZZ SEO FRIEND';

	$menu_title = 'DUZZ';

	$capability = 'administrator'; //which user role can access this page

	$menu_slug = 'duzz-seo';

	$icon_url = 'dashicons-awards';

	$position = 67;

	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, 'duzz_admin_page_func', $icon_url, $position );
}

add_action( 'admin_menu', 'duzz_admin_page_settings' );


//Register Options
function duzz_register_settings_options() {
	
	$option_group = 'analytics-fields-group';

	register_setting( $option_group, 'google_analytics_code', 'duzz_sanitize_data_of_options' );

	register_setting( $option_group, 'google_webmaster_code', 'duzz_sanitize_data_of_options' );

	register_setting( $option_group, 'pinterest_code', 'duzz_sanitize_data_of_options' );	

	register_setting( $option_group, 'bing_webmaster_code', 'duzz_sanitize_data_of_options' );	
}

add_action( 'admin_init', 'duzz_register_settings_options' );



function duzz_sanitize_data_of_options( $data ) {

	$san_data = sanitize_text_field( $data );

	$pure_data = esc_html( $san_data );

	return $pure_data;

	
}




//Function for duzz admin page display
function duzz_admin_page_func() {
	
	?>
	<div class="wrap">
		<div class="duzz_top">
			<h1>Welcome to DUZZ SEO FRIEND</h1>	
			<hr/>
			<p>
				Thank you for choosing DUZZ. We assure that we will never disappoint you. DUZZ seo is a totally free SEO plugin that enables you to perform several important tasks that you can accomplish only by using other premium SEO plugin available on the internet. This plugin is higly optimized for speed by using native WordPress Functions and Hooks for optimum web-page rendering speed. You can add severl meta tags that are highly recommended for SEO as well as for Facebook sharig, analytics and webmaster codes of different channels and much more coming soon options.
				
				<br><br><b>COMING SOON FEATURES:</b>
					<br>: SEO Score on the edit page / edit post in WP Admin.
					<br>: One Click Generate latest XML Site-Map.
					<br>: One Click Generate latest robots.txt.
					<br>: Generate Google map and insert anywhere in your website.
					<br>: Add Schema and place anywhere in your website.
					<br>: Ping tool to ping SE with any post or page

				<br><br><b>Do not forget to rate us "Five Star"!</b>
			</p>
			<hr/>
		</div> <!-- /.duzz_top -->
		<div class="duzz_mid widefat">
	
			<h3>Paste Codes Here!</h3>
			<form method="post" class="widefat" action="options.php">
			<?php settings_fields( 'analytics-fields-group' ); ?>
			<?php do_settings_sections( 'analytics-fields-group' ); ?>
				<table>
					<tr>
						<td>
							<h5><label for="google_analytics_code">Google Analytics</label></h5>
							<textarea id="google_analytics_code" name="google_analytics_code" placeholder="Google Analytics (ONLY PROPERTY ID LIKE: YY-XXXXXXXX-X)" style="width: 100%;" rows="7"><?php echo esc_attr( get_option('google_analytics_code') ); ?></textarea>
						</td>
						<td>
							<h5><label for="google_webmaster_code">Google Webmaster</label></h5>
							<textarea id="google_webmaster_code" name="google_webmaster_code" placeholder="Google Webmaster" style="width: 100%;" rows="7"><?php echo esc_attr( get_option('google_webmaster_code') ); ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<h5><label for="bing_webmaster_code">Bing Webmaster</label></h5>
							<textarea id="bing_webmaster_code" name="bing_webmaster_code" placeholder="Bing Webmaster" cols="60" rows="7"><?php echo esc_attr( get_option('bing_webmaster_code') ); ?></textarea>			
						</td>
						<td>
							<h5><label for="pinterest_code">Pinterest</label></h5>
							<textarea id="pinterest_code" name="pinterest_code" placeholder="Pinterest Code" cols="60" rows="7"><?php echo esc_attr( get_option('pinterest_code') ); ?></textarea>			
						</td>
					</tr>
				</table>

				<?php submit_button(); ?> 
			</form>
		</div> <!-- /.duzz_mid -->			

		<div class="duzz_bottom">
			<hr/>
			<p>
				We would love to hear from you: 
				<a href="http://plagiarismspy.com/contact_us.php"> 
					Report Bug / Contact us / Suggest a Feature 
				</a> 
				or  
				<a href="http://plagiarismspy.com/"> 
					Visit us 
				</a>
			</p>
		</div> <!-- /.duzz_bottom -->
	</div> <!-- /.wrap -->
	<?php
}
/*============================ Ends: Plugin Page in WP Admin ===========================*/










/*====================== Front End Functions Start ======================*/
//Adding meta tags in head section
function duzz_add_meta_tags_in_post() {
	
	global $post;

	$html = '';

	//For pages and posts the google analytics
	if ( 'post' == $post->post_type || 'page' ==  $post->post_type ) {

		if ( ! empty( $google_analytics_code = get_option( 'google_analytics_code' ) ) ) {
			
			$google_analytics_code = esc_attr( $google_analytics_code );

			$html .= "<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			  ga('create', '" . $google_analytics_code . "', 'auto');
			  ga('send', 'pageview');

			</script>" . PHP_EOL;

		}	
	}

	//Only for home page google webmaster tag
	if ( is_home() ) { 

		if( ! empty( $google_webmaster_code = get_option( 'google_webmaster_code' ) ) ) {
			
			$google_webmaster_code = esc_attr( $google_webmaster_code );

			$html .= '<meta name="google-site-verification" content="' . $google_webmaster_code . '" />' . PHP_EOL;
		}
	}

	//Only for home page bing webmaster tag
	if ( is_home() ) { 

		if ( ! empty( $bing_webmaster_code = get_option( 'bing_webmaster_code' ) ) ) {
			
			$bing_webmaster_code = esc_attr( $bing_webmaster_code );

			$html .= '<meta name="msvalidate.01" content="' . $bing_webmaster_code . '" />' . PHP_EOL;

		}
	}

	//Only for home page Pinterest Site verification
	if ( is_home() ) { 
		
		if ( !empty( $pinterest_code = get_option( 'pinterest_code' ) ) ) {
			
			$pinterest_code = esc_attr( $pinterest_code );

			$html .= '<meta name="p:domain_verify" content="' . $pinterest_code . '" />' . PHP_EOL;

		}	
	}
	
	if ( ! empty ( $meta_title = get_post_meta($post->ID, 'post_meta_title', true ) ) ) {

		$html .= '<meta name="DC.title" content="' . esc_attr( $meta_title ) . '"/>' . PHP_EOL;
	}

	if ( ! empty ( $meta_description = get_post_meta($post->ID, 'post_meta_description', true ) ) ) {

		$html .= '<meta name="description" content="' . esc_attr( $meta_description ) . '"/>' . PHP_EOL;
	}

	if ( ! empty ( $og_url = get_post_meta($post->ID, 'og_url', true ) ) ) {

		$html .= '<meta property="og:url" content="' . esc_attr( $og_url ) . '"/>' . PHP_EOL;
	} 
	else {
		
		$html .= '<meta property="og:url" content="' . get_permalink( $post->ID ) . '"/>' . PHP_EOL;
	}

	$html .= '<meta property="og:type" content="website"/>' . PHP_EOL;

	if ( ! empty ( $og_title = get_post_meta($post->ID, 'og_title', true ) ) ) {

		$html .= '<meta property="og:title" content="' . esc_attr( $og_title ) . '"/>' . PHP_EOL;
	}

	if ( ! empty ( $og_description = get_post_meta($post->ID, 'og_description', true ) ) ) {

		$html .= '<meta property="og:description" content="' . esc_attr( $og_description ) . '"/>' . PHP_EOL;
	}
	
	if ( ! empty ( $og_image = get_post_meta($post->ID, 'og_image', true ) ) ) {

		$html .= '<meta property="og:image" content="' . esc_url_raw( $og_image ) . '"/>' . PHP_EOL;
	}
	elseif ( has_post_thumbnail() ) {

		$img_url = get_the_post_thumbnail_url();
		
		$html .= '<meta property="og:image" content="' . $img_url . '"/>' . PHP_EOL;	
	}
	else {

		$html .= '';	
	}

	echo $html;
}

add_action('wp_head', 'duzz_add_meta_tags_in_post');



//Changing Title Tag
function duzz_title_tag_change() {
	
	global $post;

	if ( ! empty( $title = get_post_meta( $post->ID, 'post_title_tag', true ) ) ) {	
		
		$title = esc_attr( $title );
		
	}
	
	return $title;
}

add_filter( 'pre_get_document_title', 'duzz_title_tag_change');
/*====================== Ends: Front End Functions ======================*/



/*========================== Helper Functions ==================================*/
function duzz_user_can_save( $post_id, $nonce ) {
	
	$is_autosave = wp_is_post_autosave( $post_id );

	$is_revision = wp_is_post_revision( $post_id );

	$is_valid_nonce = ( isset( $_POST[$nonce] ) && wp_verify_nonce( $_POST[$nonce], plugin_basename(__FILE__) ) );

	//return true if the user is able to save the file
	return !( $is_autosave || $is_revision ) && $is_valid_nonce;
}


?>