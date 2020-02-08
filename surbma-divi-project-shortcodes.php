<?php

/*
Plugin Name: Surbma | Divi Project Shortcodes
Plugin URI: https://surbma.com/wordpress-plugins/
Description: Shortcodes to display Divi's Project elements, like category and tag list.

Version: 2.1

Author: Surbma
Author URI: https://surbma.com/

License: GPLv2

Text Domain: surbma-divi-project-shortcodes
Domain Path: /languages/
*/

// Prevent direct access to the plugin
if ( !defined( 'ABSPATH' ) ) exit( 'Good try! :)' );

// Localization
function surbma_divi_project_shortcodes_init() {
	load_plugin_textdomain( 'surbma-divi-project-shortcodes', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'surbma_divi_project_shortcodes_init' );

// Checks if Divi theme is used before allowing plugin to activate
function surbma_divi_project_shortcodes_activation_check() {
    if ( wp_basename( get_template_directory() ) != 'Divi' ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( sprintf( __( 'Whoa... this plugin only works, when you are using the %1$sDivi Theme%2$s by Elegant Themes.<br><br>%3$s« Go back to your plugins%4$s', 'surbma-divi-project-shortcodes' ), '<a href="http://surbma.com/go/elegantthemes/" target="_blank">', '</a>', '<a href="/wp-admin/plugins.php">', '</a>' ) );
    }
}
register_activation_hook( __FILE__, 'surbma_divi_project_shortcodes_activation_check' );

function surbma_divi_project_shortcodes_project_category_list() {
	return get_the_term_list( get_the_ID(), 'project_category', '', ', ' );
}
add_shortcode( 'project-category-list', 'surbma_divi_project_shortcodes_project_category_list' );

function surbma_divi_project_shortcodes_project_tag_list() {
	return get_the_term_list( get_the_ID(), 'project_tag', '', ', ' );
}
add_shortcode( 'project-tag-list', 'surbma_divi_project_shortcodes_project_tag_list' );

function surbma_divi_project_shortcodes_project_title() {
	ob_start();
	?>
		<div class="et_main_title">
			<h1><?php the_title(); ?></h1>
			<span class="et_project_categories"><?php echo get_the_term_list( get_the_ID(), 'project_category', '', ', ' ); ?></span>
		</div>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'project-title', 'surbma_divi_project_shortcodes_project_title' );

function surbma_divi_project_shortcodes_project_meta_box() {
	ob_start();
	?>
		<div class="et_project_meta">
			<strong class="et_project_meta_title"><?php echo esc_html__( 'Skills', 'Divi' ); ?></strong>
			<p><?php echo get_the_term_list( get_the_ID(), 'project_tag', '', ', ' ); ?></p>

			<strong class="et_project_meta_title"><?php echo esc_html__( 'Posted on', 'Divi' ); ?></strong>
			<p><?php echo get_the_date(); ?></p>
		</div>
	<?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'project-meta-box', 'surbma_divi_project_shortcodes_project_meta_box' );
