<?php


class BS_Custom_Admin {

public $single ;
public $plural ;
public $dashicon ;
public $supports ;
public $fields;

	public function __construct()
	{	

		if ( ! class_exists('CMB_Meta_Box'))
			require_once( plugin_dir_path( __FILE__ ) . '/Custom-Meta-Boxes/custom-meta-boxes.php' );

	    add_action( 'init', array( $this, 'post_type_setup' ) );
	    add_action( 'init', array( $this, 'taxonomy_setup' ) );	    
	    add_filter( 'cmb_meta_boxes', array( $this, 'field_setup' ) );    
	}


	public function set($args , $fields) {
	extract($args);
		$this->single = $single ;
		$this->plural = $plural ;
		$this->dashicon = $dashicon ;
		$this->supports = $supports ;
		$this->fields = $fields;
	}

	public function post_type_setup() 
	{

		$single = ucfirst($this->single);
		$plural = ucfirst($this->plural);
		$labels = array(
		    "name"               => $plural,
		    "singular_name"      => $single,
		    "add_new"            => "Add New",
		    "add_new_item"       => "Add New $single",
		    "edit_item"          => "Edit $single",
		    "new_item"           => "New $single",
		    "all_items"          => "All $plural",
		    "view_item"          => "View $single",
		    "search_items"       => "Search $plural",
		    "not_found"          => "No $this->plural found",
		    "not_found_in_trash" => "No $this->plural found in Trash",
		    "parent_item_colon"  => "",
		    "menu_name"          => $plural
		);

		$args = array(
		    'labels'             => $labels,
		    'public'             => true,
		    'publicly_queryable' => true,
		    'show_ui'            => true,
		    'show_in_menu'       => true,
		    'menu_icon'			 => $this->dashicon , 
		    'query_var'          => true,
		    'rewrite'            => array( 'slug' => $this->single ),
		    'capability_type'    => 'post',
		    'has_archive'        => false,
		    'hierarchical'       => false,
		    'menu_position'      => null,
		    'supports'           => $this->supports
		);

		register_post_type( $this->single, $args );
	}

	public function taxonomy_setup()
	{
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			"name"              => _x( "$this->single Groups", "taxonomy general name" ),
			"singular_name"     => _x( "$this->single Group", "taxonomy singular name" ),
			"search_items"      => __( "Search $this->single Groups" ),
			"all_items"         => __( "All $this->single Groups" ),
			"parent_item"       => __( "Parent $this->single Group" ),
			"parent_item_colon" => __( "Parent $this->single Group:" ),
			"edit_item"         => __( "Edit $this->single Group" ),
			"update_item"       => __( "Update $this->single Group" ),
			"add_new_item"      => __( "Add New $this->single Group" ),
			"new_item_name"     => __( "New $this->single Group Name" ),
			"menu_name"         => __( "$this->single Groups" ),
		);


		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => "$this->single-group" ),
		);

		register_taxonomy( "$this->single-group", array( "$this->single" ), $args );

	}

	public function field_setup( $meta_boxes ) 
	{ 
		$single = ucfirst($this->single);

	    $meta_boxes[] = array(
			'title' => "$single Details",
			'pages' => $this->single,
			'fields' => $this->fields
		);

	    return $meta_boxes;
	}
}

