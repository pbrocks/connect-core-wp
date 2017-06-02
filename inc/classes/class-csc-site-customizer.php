<?php

namespace Connect_Core_WP\inc\classes;

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );

class CSC_Site_Customizer {
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'customizer_manager' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'customizer_enqueue' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'customizer_enqueue' ) );
	}

		/**
		 * Customizer manager demo
		 *
		 * @param  WP_Customizer_Manager $wp_manager
		 * @return void
		 */
	public static function customizer_manager( $wp_manager ) {
		self::csc_customizer_manager( $wp_manager );
	}

	public static function customizer_enqueue() {
		wp_enqueue_style( 'customizer-section', plugins_url( '../css/customizer-section.css', __FILE__ ) );
	}
	/**
	 * Customizer manager demo
	 *
	 * @param  WP_Customizer_Manager $wp_manager
	 * @return void
	 */
	public static function csc_customizer_manager( $wp_manager ) {
		$wp_manager->add_panel( 'csc_customizer_panel', array(
			'priority' => 10,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'CSC Admin Panel', 'cmpbl-command-central' ),
		) );

		$wp_manager->add_setting( 'ce_image_https',
			array(
			'default'        => false,
		) );

		$wp_manager->add_control(
			new Central_Toggle_Control( $wp_manager,
				'ce_image_https',
				array(
					'settings'    => 'ce_image_https',
					'label'       => __( 'ce Image https URL', 'cmpbl-command-central' ),
					'title'       => __( 'Cet Image URL', 'cmpbl-command-central' ),
					'section'     => 'content_options_section',
					'type'        => 'ios',
					'description' => __( 'Configure advanced settings in %s', __FILE__ , 'cmpbl-command-central' ),
				)
			)
		);

		// add "Content Options" section
		$wp_manager->add_section( 'content_options_section' , array(
			'title'      => __( 'Content Options', 'cmpbl-command-central' ),
			'priority'   => 100,
			'panel'          => 'csc_customizer_panel',
			'description' 		=> __( 'Configure options for ' . esc_url_raw( home_url() ), 'cmpbl-command-central' ),
		) );

		// add setting for page comment toggle checkbox
		$wp_manager->add_setting( 'page_comment_toggle', array(
			'default' => 1,
		) );

		// add control for page comment toggle checkbox
		$wp_manager->add_control( 'page_comment_toggle', array(
			'label'     => __( 'Show comments on pages?', 'cmpbl-command-central' ),
			'section'   => 'content_options_section',
			'priority'  => 10,
			'type'      => 'checkbox',
		) );

		$wp_manager->add_section( 'diagnostics_section', array(
			'priority' => 10,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Diagnostics Section', 'cmpbl-command-central' ),
			'description' => __( '<h4>Turn on helpful diagnostic information.</h4>', 'cmpbl-command-central' ),
			'panel' => 'csc_customizer_panel',
		) );

		$wp_manager->add_setting( 'central_diagnostics',
			array(
			'default'    => false,
			)
		);
		$wp_manager->add_control( 
			new Central_Toggle_Control( $wp_manager,
				'central_diagnostics', array(
				'settings'    => 'central_diagnostics',
				'label'       => __( 'Central Diagnostics' ),
				'description' => 'Adds a button in upper right corner of front end pages to toggle diagnostic infomation.',
				'section'     => 'diagnostics_section',
				'type'        => 'ios',
				// 'type'        => 'checkbox',
			)
		) );
		// if ( true === get_theme_mod( 'central_diagnostics' ) ) {
			$wp_manager->add_setting( 'diagnostic_type',
				array(
					'capability' => 'edit_theme_options',
					'default'    => 'mapping',
					// 'sanitize_callback' => array(
				// __CLASS__,
				// 'customizer_sanitize_radio',
				// ),
			) );
			$wp_manager->add_control( 'diagnostic_type',
				array(
					'type'        => 'radio',
					'section'     => 'diagnostics_section',
					'label'       => __( 'Diagnostic Selection' ),
					'description' => __( 'This is a custom radio input.' ),
					'choices'     => array(
						'current'    => __( 'Current URL' ),
						'mapping'    => __( 'Domain Mapping' ),
						'mods'       => __( 'Theme Mods' ),
					),
				)
			);
		// }
	}

	/**
	 * A section to show how you use the default customizer controls in WordPress
	 *
	 * @param  Obj $wp_manager - WP Manager
	 *
	 * @return Void
	 */
	private static function themeslug_sanitize_select( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}
