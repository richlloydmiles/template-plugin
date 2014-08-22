<?php
/**
 * Currecy Model Class
 * @package Bootstrap Currency Converter Plugin
 */
class Currency_Model {

/**
 * Constructor Method calls cc_add_actions method
 * @return null
 */
	function __construct() {
		$this->cc_add_actions();
	}
/**
 * Gets file contents
 * @param type $file
 * @return null
 */
	function get_file($file) {
		ob_start();
		include PLUGIN_FILE.$file;
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
	}
/**
 * Registers scripts
 * @return null
 */
	function bstcc_register_scripts() {
		wp_register_script('money-js', plugins_url('assets/js/money.js', __FILE__), array('jquery'));
		wp_enqueue_script('money-js');
	}

/**
 * Adds Options Page
 * @return null
 */
	function currecy_settings_menu() {
		add_options_page('Currency Options', 'Currency', 'manage_options', 'currency-converter', array($this, 'currency_converter_options'));
	}
/**
 * Gets the View for the options (view.html.php) file
 * @return null
 */
	function currency_converter_options() {
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.'));
		}
		$this->get_file('inc/view/view.php');
	}
/**
 * Adds actions to event model of WordPress
 * @return null
 */
	function cc_add_actions() {
		add_action('wp_enqueue_scripts', array($this, 'bstcc_register_scripts'));
		add_action('admin_menu', array($this, 'currecy_settings_menu'));

		add_action('display_post', array($this, 'add_meta_money_class'), 10, 4);
	}

	function add_meta_money_class($post_id, $post) {
		$my_meta = get_post_meta($post_id, 'bs_currency_value', true);

	}
}
//end of Currency Model Class
