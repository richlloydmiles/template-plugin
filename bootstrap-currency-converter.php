<?php

/**
 * Plugin Name: Bootstrap Currency Converter
 * Plugin URI: http://lsdev.biz
 * Description: Converts Currency using the https://openexchangerates.org/ json api
 * Author: Richard Miles
 * Version: 1.0
 * Author URI: http://lsdev.biz
 */
// checks to see if this page was accessed directly by the browser (if it was then the page dies)
if (!defined('ABSPATH')) {
	exit;
}

//check if class alredy exists

define('PLUGIN_FILE', plugin_dir_path(__FILE__));

include PLUGIN_FILE.'inc/currency-meta-box.php';
$BS_Features_Admin = new BS_Currency_Admin();

include PLUGIN_FILE.'inc/model/model.php';
include PLUGIN_FILE.'inc/model/assets/js/script.php';
$model = new Currency_Model();
