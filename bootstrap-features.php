<?php

/**
 * Plugin Name: Bootstrap Features
 * Plugin URI: http://lsdev.biz
 * Description: Features Plugin
 * Author: Iain Coughtrie
 * Version: 1.04
 * Author URI: http://lsdev.biz
 */
// checks to see if this page was accessed directly by the browser (if it was then the page dies)
if ( ! defined( 'ABSPATH' ) ) exit;
//check if class alredy exists
if ( ! class_exists( 'BS_Features' ) ) :

// Post Type and Custom Fields
include plugin_dir_path( __FILE__ ) . '/inc/class-bs-features-admin.php';

// Shortcode and Template Tag
include plugin_dir_path( __FILE__ ) . '/inc/class-bs-features.php';

// Widget
include plugin_dir_path( __FILE__ ) . '/inc/class-bs-features-widget.php';


//Global variables
$single = 'feature';
$plural = 'features';

$single = strtolower($single);
$plural = strtolower($plural);

//Arguments that will be used specically for the widget section
	$widget_args = array(	
		'related_class' => 'BS_Feature' ,
		'plural' => ucfirst($plural) ,
		'single' => ucfirst($single) , 
		'description' => 'Bootstrap Features Plugin'
	 	 );
//Arguments that will me used for creating the admin options, such as post type
	$admin_array = array(
		'single' => $single , 
		'plural' => $plural ,
		'dashicon' => 'dashicons-star-filled' ,
		'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
		);
//Arguments that will be passed into the BS_Custom which is used primarily for display on the frontend
	$custom_array = array(
		'single' => $single , 
		'plural' => $plural
		);
//Custom metabox fields, more values will be added to this 2d array based on what custom fields we want
	    $fields = array(
	    	     array(
	            'name' => 'Example',
	            'desc' => "Custom Meta Box Field Example",
	            'id' => $single . '_example',
	            'type' => 'text'
	        )     
	    );
//Instatiate classes an run methods
    $WP_Widget_Example_Factory = new WP_Widget_Custom_Factory();
    $WP_Widget_Example_Factory->register('BS_Example_Widget' , $widget_args);
	$BS_Example_Admin = new BS_Custom_Admin();
	$BS_Example_Admin->set($admin_array , $fields);
	$BS_Example = new BS_Custom($custom_array);

endif; //check if class alredy exists
