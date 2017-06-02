<?php
/**
 * Plugin Name: Connect Core WP
 * Plugin URI: http://testlab.sample.com/wiki/
 * Description: The plugin to ensure proper setup of plugins for a MultiSite installation.
 * Version: 0.7.5
 * Author: pbrocks
 * Network: true
 * Author URI: http://testlab.sample.com/wiki/
 */

namespace Connect_Core_WP;

/**
 * Description
 *
 * @return type Words
 */
// include( 'inc/functions/class-central-toggle-control.php' );
require_once( 'autoload.php' );

inc\classes\Admin_Menus::init();
// inc\classes\Central_Toggle_Control::init();
inc\classes\CSC_Site_Customizer::init();
// inc\classes\Debugging_Admin::init();
inc\classes\Sample_Plugins_List::init();
inc\classes\Setup_Functions::init();

// new inc\classes\Central_Toggle_Control();
if ( ! class_exists( 'WordPress_Welcomes_You' ) ) {
	 // new inc\classes\Central_Toggle_Control();
	 new inc\classes\WordPress_Welcomes_You();
}
