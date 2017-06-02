<?php
namespace Connect_Core_WP\inc\classes;

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );


class Diagnostic_Message {
	/**
	 * Blue info bubble. Will add hue-rotated for hidden templates
	 *
	 * @var string
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'diagnostic_message_scripts' ) );
		add_shortcode( 'info-message', array( __CLASS__, 'message_toggle_button' ) );
		add_shortcode( 'bootstrap-toggle-button', array( __CLASS__, 'bootstrap_toggle_button' ) );
	}

	public static function bootstrap_toggle_button() {

		$boot_toggle = '<input type="checkbox" checked data-toggle="toggle" data-on="Info Showing" data-off="Template??" data-onstyle="success" data-offstyle="danger">';

		return $boot_toggle;
	}

	public static function message_toggle_button( $message ) {
		// Attributes
		$message = shortcode_atts(
			array(
				'content' => '',
			),
			$message,
			'toggle-button'
		);
		sanitize_text_field( $atts['name'] );

		$target = '<div class="toggle-button"><img id="info-balloon" src="' . plugins_url( '../images/info-balloon.png', __FILE__ ) . '" class="white-bg" /></div><div id="toggle-target"><p class="toggle-target">' . $message['content'] . '</p></div>';
		return $target;

	}

	public static function diagnostic_message_scripts() {
		wp_enqueue_style( 'dev-diagnostic', plugins_url( '../css/dev-diagnostic.css', __FILE__ ) );
		wp_enqueue_script( 'dev-diagnostic', plugins_url( '../js/dev-diagnostic.js', __FILE__ ), array( 'jquery' ) );
		// wp_enqueue_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' );
		// wp_enqueue_style( 'bootstrap-toggle', '//gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css' );
		// wp_enqueue_script( 'bootstrap-toggle', '//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js', array( 'jquery' ) );
	}
}

// Diagnostic_Message::init();
