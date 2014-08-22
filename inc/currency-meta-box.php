<?php
if (!class_exists('CMB_Meta_Box')) {
	require_once (plugin_dir_path(__FILE__).'/Custom-Meta-Boxes/custom-meta-boxes.php');
}

class Currency_Field extends CMB_Field {

	public function html() {
		?>
																<p>
																	<input class="bs_admin_currency" type="number" name="<?php echo $this->name?>" value="<?php echo esc_attr($this->get_value())?>" />
																</p>
				<script type="text/javascript">jQuery(document).ready(function($) {});</script>

		<?php
	}

	public function parse_save_value() {
		// adjust $this->value
		$this->value = '<span class="bs_currency">'.$this->value.'</span>';
	}

}

add_filter('cmb_field_types', function ($cmb_field_types) {
	$cmb_field_types['currency'] = 'Currency_Field';
	return $cmb_field_types;
});

class BS_Currency_Admin {

	public function __construct() {

		add_filter('cmb_meta_boxes', array($this, 'field_setup'));
	}

	public function field_setup($meta_boxes) {
		$prefix = 'bs_currency_';// Prefix for all fields

		$fields = array(
			array(
				'name'  => 'Value:',
				'desc'  => "Set price value for this item.",
				'id'    => $prefix.'value',
				'type'  => 'currency',
				'class' => 'boom',
			)
		);
		$meta_boxes[] = array(
			'title'  => 'Currency Details',
			'pages'  => 'post',
			'fields' => $fields,
		);
		return $meta_boxes;
	}
}
