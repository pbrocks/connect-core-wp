<?php
namespace Connect_Core_WP\inc\classes;

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class Admin_Menus {

	public static function init() {

		add_filter( 'the_content', array( __CLASS__, 'replace_content_on_the_fly' ) );
		// add_filter( 'the_excerpt', array( __CLASS__, 'replace_content_on_the_fly' ) );
		add_action( 'network_admin_menu', array( __CLASS__, 'core_wp_menu' ) );
		add_action( 'admin_menu', array( __CLASS__, 'core_wp_menu' ) );
		// add_action( 'admin_menu', array( __CLASS__, 'dev_menu' ) );
		add_action( 'admin_menu', array( __CLASS__, 'move_spacer1_admin_menu_item' ) );
		add_action( 'admin_menu', array( __CLASS__, 'move_spacer2_admin_menu_item' ) );
		// add_action( 'admin_menu', array( __CLASS__, 'change_pages_label_to_something_else' ) );
		add_action( 'admin_menu', array( __CLASS__, 'change_posts_label_to_updates' ) );
		add_action( 'admin_menu', array( __CLASS__, 'remove_some_admin_menus' ), 990 );
	}


	/**
	 *	function dm_network_pages() {
	 * Adding menus
	 * dashicons-admin-multisite
	 */
	public static function replace_content_on_the_fly( $text ) {
		$replace = array(
			// 'words to find' => 'replace with this'
			'baked with care' => 'baked with care = <a href="http://www.wordpress.org/">wordpress</a>',
			'google' => '<a href="http://www.google.com/">excerpt</a>',
			'function' => '<a href="#">function</a>',
		);
		$text = str_replace( array_keys( $replace ), $replace, $text );
		return $text;
	}

	/**
	 *	function dm_network_pages() {
	 * Adding menus
	 * dashicons-admin-multisite
	 */
	public static function core_wp_menu() {
		$sites = get_sites();
		add_menu_page( 'Core WordPress', 'Core WordPress', 'manage_options', 'wp-csc-welcome-page.php',  array( __CLASS__, 'welcome_message' ), 'dashicons-info', 9 );
		add_submenu_page( 'wp-csc-welcome-page.php', 'Core WP', 'Core WP on ' . $sites[0]->domain, 'manage_options', 'connect-to-multisite.php',  array( __CLASS__, 'list_table_page' ) );
		// add_menu_page( 'CSC List Table', 'CSC List Table', 'manage_options', 'csc-list-table.php', array( __CLASS__, 'list_table_page' ), 'dashicons-info', 9 );
		// add_submenu_page( 'wp-csc-welcome-page.php', 'CSC List Table', 'CSC List Table', 'manage_options', 'csc-list-table.php', array( __CLASS__, 'list_table_page' ) );
		add_submenu_page( 'wp-csc-welcome-page.php', $sites[0]->domain . ' Sites', 'Sites on this MultiSite', 'manage_options', 'csc-list-table-submenu.php',  array( __CLASS__, 'csc_submenu_page' ) );

	}

	/**
	 * Add Submenu page
	 **/
	public static function welcome_message() {
		$welcome = new WordPress_Welcomes_You();
		$welcome->welcome_message();
	}

	/**
	 * Add Submenu page
	 **/
	public static function list_table_page() {
		Sample_Plugins_List::list_table_page();
	}

	/**
	 * Add Submenu page
	 **/
	public static function csc_submenu_page() {
		echo '<div class="wrap">';
		echo '<h2>' . __FUNCTION__ . '<h2>';
			global $current_site, $wpdb;
			$sites = get_sites();
			$site_details = get_blog_details( 5 );
			echo '<h3>' . $sites[0]->domain . '</h3>';
			echo '<pre>';
			print_r( $sites );
			echo '</pre>';
			echo '<pre>';
			print_r( $site_details );
			echo '</pre>';
			echo '</div>';
	}

	/**
	 * Add Menu page
	 **/
	public static function core_wp_main_page() {
		echo '<div class="wrap">';
		echo '<h2>' . __FUNCTION__ . '<h2>';
			global $current_site, $wpdb;

		if ( is_network_admin() ) {
			echo '<h3 style="color:#700;">You are viewing the WordPress MultiSite network administration page</h3>';
		} else {
			$blog_id = get_current_blog_id();
			echo '<h3 style="color:#700;">You are viewing a WordPress MultiSite subsite #' . $blog_id . ' admin page</h3>';
			if ( $blog_id ) {
				echo '<pre>';
				// var_dump( $var );
				print_r( get_blog_details( $blog_id ) );
				echo '</pre>';
			}
		}

		if ( get_site_option( 'dm_user_settings' ) && $current_site->blog_id != $wpdb->blogid && ! self::dm_sunrise_warning( false ) ) {
			add_management_page( __( 'Domain Mapping', 'cmpbl-domain-mapping' ), __( 'Domain Mapping', 'cmpbl-domain-mapping' ), 'manage_options', 'domainmapping', array( __CLASS__, 'dm_manage_page' ) );
		}
		echo '</div>';
	}

	public static function move_spacer1_admin_menu_item( $menu_order ) {
		global $menu;

		$spacer_admin_menu = $menu[4];

		if ( ! empty( $spacer_admin_menu ) ) {

			// Add 'woocommerce' to bottom of menu
			 $menu[15] = $spacer_admin_menu;

			// Remove initial 'woocommerce' appearance
			unset( $menu[4] );
		}
		return $menu_order;
	}

	public static function move_spacer2_admin_menu_item( $menu_order ) {
		global $menu;

		// $spacer_admin_menu = $menu[4];
		// if ( ! empty( $spacer_admin_menu ) ) {
		// Add 'woocommerce' to bottom of menu
		// $menu[15] = $spacer_admin_menu;
		// Remove initial 'woocommerce' appearance
		// unset( $menu[4] );
		// }
		// return $menu_order;
	}


	public static function change_pages_label_to_something_else() {
		global $menu;

		$menu[20][0] = 'Home Panels';
	}

	public static function change_s_label_to_something_else() {
		global $menu;

		$menu[20][0] = 'Home ';
	}

	public static function change_posts_label_to_updates() {
		global $menu;

		$menu[5][0] = 'Current Updates';

	}


	public static function remove_some_admin_menus() {
		global $menu, $submenu;
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'edit.php' );
		remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
	}


	public static function dev_menu() {
		// if ( current_user_can( 'manage_network' ) ) { // for multisite
		if ( current_user_can( 'manage_options' ) ) {
			add_menu_page( 'Dev Admin', 'Dev Admin', 'edit_posts', 'dev-admin-menu.php',  array( __CLASS__, 'dev_menu_page' ), 'dashicons-tickets', 13 );
			add_submenu_page( 'dev-admin-menu.php', 'Dev Arrays', 'Arrays', 'edit_posts', 'dev-arrays.php',  array( __CLASS__, 'dev_arrays_page' ) );
			add_submenu_page( 'dev-admin-menu.php', 'Dev Submenu', 'Menus/Submenus', 'edit_posts', 'dev-submenu.php',  array( __CLASS__, 'dev_submenu_page' ) );
		}
	}

	public static function dev_arrays_page() {
		global $menu;
		echo '<h1>' . basename( __FUNCTION__ ) . '</h1>';
		echo '<pre>';
		echo 'You can find this file in  <br>';
		echo plugins_url( '/', __FILE__ );
		print_r( $menu );
		echo '<br>';
		echo '</pre>';

	}

	public static function dev_submenu_page() {
		echo '<h1>' . basename( __FUNCTION__ ) . '</h1>';
		echo '<pre>';
		echo 'You can find this file in  <br>';
		echo plugins_url( '/', __FILE__ );
		echo '<br>';
		echo '<br>ACF path =>' . plugin_dir_path( __FILE__ ) . 'acf-json<br>';
		echo '</pre>';

	}

	public static function dev_menu_page() {
		echo '<h1>' . basename( __FUNCTION__ ) . '</h1>';
			echo '<h1>Dev Admin Menu</h1>';
			echo '<pre>';

			echo '<p>get_stylesheet_directory => ' . get_stylesheet_directory();
			echo '<p>get_stylesheet_directory_uri => ' . get_stylesheet_directory_uri();
			echo '<p>get_stylesheet_uri => ' . get_stylesheet_uri();

			echo 'You can find this file in  <br>';
			echo esc_url( plugins_url( '/', __FILE__ ) );
			echo '<br>';
			echo '</pre>';

			$mods = get_theme_mods();
			echo '<pre>';
			var_dump( $mods );
			echo '</pre>';
	}
}
