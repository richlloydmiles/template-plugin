<?php
/**
 * Controls the view aspects of the Boostrap Currency Converter Plugin
 * @package Bootstrap Currency Converter Plugin
 */
class Currency_View {

	public $options = array();
/**
 * Constructor Method
 * @return null
 */
	function __construct($view) {
		echo $this->get_view($view);
	}

/**
 * Creates options in a select box for the view
 * @param array $options
 * @param int $selected
 * @return string
 */
	function get_select_box($options, $selected) {
		$key = array_search($selected, $options);
		ob_start();
		?>

		<?php
		$count = 0;
		foreach ($options as $value) {
			?>
										  <option value="<?php echo $value;?>"
			<?php
			if ($count == $key) {
				echo 'selected';
			}
			?>
										  ><?php echo $value;?></option>
			<?php
			$count++;
		}
		?>
				<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

/**
 * Gets the chosen view
 * @param string $view
 * @return string
 */
	function get_view($view) {
		ob_start();
		include PLUGIN_FILE.'inc/view/'.$view;
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
/**
 * Gets a Post variable
 * @param variable $post
 * @return variable
 */
	public function get_option($post) {
		if (isset($_POST[$post])) {
			return $_POST[$post];
		}
	}

/**
 * Sets the currency_converter_options value in the wp-options table as well as the class variable - options
 * @param string $key
 * @param string $val
 * @return null
 */
	public function set_option($key, $val) {
		$this->options[$key] = $val;
		update_option('currency_converter_options', $this->options);
	}

}//end of class

//instatiates Currency_View class with the class parameter of the choen view.
$view = new Currency_View('default.view.php');
