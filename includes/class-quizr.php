<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://ja.mes
 * @since      1.0.0
 *
 * @package    Quizr
 * @subpackage Quizr/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Quizr
 * @subpackage Quizr/includes
 * @author     James <james@bestpracticeprogramming.com>
 */
class Quizr {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Quizr_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'QUIZR_VERSION' ) ) {
			$this->version = QUIZR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'quizr';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Quizr_Loader. Orchestrates the hooks of the plugin.
	 * - Quizr_i18n. Defines internationalization functionality.
	 * - Quizr_Admin. Defines all hooks for the admin area.
	 * - Quizr_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quizr-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quizr-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-quizr-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-quizr-public.php';


        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-quizr-migrate.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cpts/class-quizr-question-set-cpt.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/cpts/class-quizr-question-cpt.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/apis/class-quizr-settings-api.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/database/class-quizr-answer-table.php';





		$this->loader = new Quizr_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Quizr_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Quizr_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Quizr_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $quizr_migrate = new Quizr_Migrate();
        $this->loader->add_action( 'plugins_loaded', $quizr_migrate, 'update_db_check');

        $quizr_settings_api = new Quizr_Settings_Api();
        $this->loader->add_action( 'admin_menu', $quizr_settings_api, 'register_options_page' );
        $this->loader->add_action( 'admin_init', $quizr_settings_api, 'register_settings' );


        $quizr_question_set_cpt = new Quizr_Question_Set_Cpt();
        $this->loader->add_action( 'init', $quizr_question_set_cpt, 'register_custom_post_type' );
        $this->loader->add_action( 'add_meta_boxes', $quizr_question_set_cpt, 'add_meta_boxes' );

        $quizr_question_cpt = new Quizr_Question_Cpt( new Quizr_Answers_Table());
        $this->loader->add_action( 'init', $quizr_question_cpt, 'register_custom_post_type' );
        $this->loader->add_action( 'add_meta_boxes', $quizr_question_cpt, 'add_meta_boxes');
        $this->loader->add_action( 'save_post', $quizr_question_cpt, 'save_custom_meta_data');
        $this->loader->add_action( 'load-post-new.php', $quizr_question_cpt, 'load_query_params' );


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Quizr_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Quizr_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
