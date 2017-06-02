<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...

 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */

namespace Connect_Core_WP\inc\classes;

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

/**
 * An example of how to write code to PEAR's standards
 *
 * Docblock comments start with "/**" at the top.  Notice
 *
 * @since      Class available since Release 1.2.0
 * @deprecated Class deprecated in Release 2.0.0
 */
class Debugging_Admin {
	/**
	 * Description
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'network_admin_notices', array( __CLASS__, 'echo_current_subsite' ) );
		add_action( 'admin_notices', array( __CLASS__, 'echo_current_subsite' ) );
		// add_action( 'admin_menu', array( __CLASS__, 'diagnositc_submenu_page' ) );
	}

	public static function sample_admin_notice__error() {
		$class = 'notice notice-error';
		$message = __( 'Irks! An error has occurred.', 'cmpbl-core-wp' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	/**
	 * Description
	 *
	 * @return type her.
	 */
	public static function echo_current_subsite() {
		$subsite = get_current_blog_id();
		$class = 'notice notice-info is-dismissible';
		$device = Setup_Functions::detect_mobile_device();

		if ( is_network_admin() ) {
			// echo '<h3 style="position:absolute; top:2rem; right:10%; color:#700;">You are viewing the WordPress MultiSite network administration page</h3>';
			$message = __( 'Booya! You\'re a Network Admin viewing on ' . $device, 'cmpbl-core-wp' );

		} else {
			$blog_id = get_current_blog_id();
			// echo '<h3 style="position:absolute; top:2rem; right:10%; color:#700;">You are viewing a WordPress MultiSite Subsite #' . $blog_id . ' admin page</h3>';
			$message = __( 'Boom! This is site #' . $subsite . ' viewing on ' . $device, 'cmpbl-core-wp' );

		}
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	/**
	 * Description
	 *
	 * @return type her.
	 */
	public static function dm_add_pages() {
		global $current_site, $wpdb, $wp_db_version, $wp_version;

		if ( $current_site->path != '/' ) {
			wp_die( __( 'The domain mapping plugin only works if the site is installed in /. This is a limitation of how virtual servers work and is very difficult to work around.', 'cmpbl-domain-mapping' ) );
		}

		if ( get_site_option( 'dm_user_settings' ) && $current_site->blog_id != $wpdb->blogid && ! self::dm_sunrise_warning( false ) ) {
			add_management_page( __( 'Domain Mapping', 'cmpbl-domain-mapping' ), __( 'Domain Mapping', 'cmpbl-domain-mapping' ), 'manage_options', 'domainmapping', array( __CLASS__, 'dm_manage_page' ) );
		}

	}

	// Default Messages for the users Domain Mapping management page
	// This can now be replaced by using:
	// remove_action('dm_echo_updated_msg','dm_echo_default_updated_msg');
	// add_action('dm_echo_updated_msg','my_custom_updated_msg_function');
	/**
	 * Do we need to set a text domain?
	 */
	public static function dm_echo_default_updated_msg() {
		switch ( $_GET['updated'] ) {
			case 'add':
				$msg = __( 'New domain added.', 'cmpbl-domain-mapping' );
				break;
			case 'exists':
				$msg = __( 'New domain already exists.', 'cmpbl-domain-mapping' );
				break;
			case 'primary':
				$msg = __( 'New primary domain.', 'cmpbl-domain-mapping' );
				break;
			case 'del':
				$msg = __( 'Domain deleted.', 'cmpbl-domain-mapping' );
				break;
		}
		echo "<div class='updated fade'><p>$msg</p></div>";
	}
}
