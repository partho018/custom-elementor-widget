<?php
/**
 * Plugin Name: Custom Elementor Widgets
 * Description: Custom high-performance & fully customizable Elementor widget for business sections.
 * Version: 1.0.0
 * Author: Custom Developer
 * Text Domain: custom-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Plugin Class
 */
final class Custom_Elementor_Widgets_Plugin {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.4';

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
		// Check if Elementor is installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Register Custom Category
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

		// Register Widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register Scripts and Styles
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'widget_styles' ] );
	}

	/**
	 * Register Custom Elementor Category
	 */
	public function add_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
			'custom-elementor-category',
			[
				'title' => esc_html__( 'Custom Widgets', 'custom-elementor-widgets' ),
				'icon'  => 'fa fa-plug',
			]
		);
	}

	/**
	 * Register Widget Scripts & Styles
	 */
	public function widget_styles() {
		wp_register_style(
			'custom-elementor-widgets-style',
			plugins_url( 'assets/css/widget-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_register_style(
			'custom-elementor-sticky-widgets-style',
			plugins_url( 'assets/css/sticky-widget-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_register_style(
			'custom-marquee-widget-style',
			plugins_url( 'assets/css/marquee-widget-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_register_style(
			'custom-process-widget-style',
			plugins_url( 'assets/css/process-widget-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_register_style(
			'custom-promo-banner-style',
			plugins_url( 'assets/css/promo-banner-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_register_style(
			'custom-uboontu-footer-style',
			plugins_url( 'assets/css/uboontu-footer-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_register_style(
			'custom-table-widget-style',
			plugins_url( 'assets/css/custom-table-style.css', __FILE__ ),
			[],
			self::VERSION
		);
		wp_enqueue_style( 'custom-elementor-widgets-style' );
		wp_enqueue_style( 'custom-elementor-sticky-widgets-style' );
		wp_enqueue_style( 'custom-marquee-widget-style' );
		wp_enqueue_style( 'custom-process-widget-style' );
		wp_enqueue_style( 'custom-promo-banner-style' );
		wp_enqueue_style( 'custom-uboontu-footer-style' );
		wp_enqueue_style( 'custom-table-widget-style' );
	}

	/**
	 * Register Widgets
	 */
	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/what-we-do-widget.php' );
		require_once( __DIR__ . '/widgets/sticky-projects-widget.php' );
		require_once( __DIR__ . '/widgets/marquee-ticker-widget.php' );
		require_once( __DIR__ . '/widgets/process-steps-widget.php' );
		require_once( __DIR__ . '/widgets/promo-banner-widget.php' );
		require_once( __DIR__ . '/widgets/uboontu-footer-widget.php' );
		require_once( __DIR__ . '/widgets/custom-table-widget.php' );
		$widgets_manager->register( new \Custom_What_We_Do_Widget() );
		$widgets_manager->register( new \Custom_Sticky_Projects_Widget() );
		$widgets_manager->register( new \Custom_Marquee_Ticker_Widget() );
		$widgets_manager->register( new \Custom_Process_Steps_Widget() );
		$widgets_manager->register( new \Custom_Promo_Banner_Widget() );
		$widgets_manager->register( new \Custom_Uboontu_Footer_Widget() );
		$widgets_manager->register( new \Custom_Table_Widget() );
	}

	/**
	 * Admin notices for missing requirements
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'custom-elementor-widgets' ),
			'<strong>' . esc_html__( 'Custom Elementor Widgets', 'custom-elementor-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'custom-elementor-widgets' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'custom-elementor-widgets' ),
			'<strong>' . esc_html__( 'Custom Elementor Widgets', 'custom-elementor-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'custom-elementor-widgets' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'custom-elementor-widgets' ),
			'<strong>' . esc_html__( 'Custom Elementor Widgets', 'custom-elementor-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'custom-elementor-widgets' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

Custom_Elementor_Widgets_Plugin::instance();
