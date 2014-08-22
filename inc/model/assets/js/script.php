<?php
function run_conversion() {
	$options = get_option('currency_converter_options');
	extract($options);
	echo $base_currency;

	?>

			<script>
			  jQuery(document).ready(function($) {


			  fx.base = "USD";
			  	fx.rates = {
			  		"EUR" : 0.745101, // eg. 1 USD === 0.745101 EUR
			  		"ZAR" : 10.0000,
			  		"CAN" : 1.2,
			  		"USD" : 1,        // always include the base rate (1:1)
			  		/* etc */
			  	}
			  		var input_value = jQuery('.bs_currency').html();
			  		console.log('<?php echo $base_currency;?>');
			  		console.log(input_value);
			  		var result =  fx.convert(input_value, {from: '<?php echo $base_currency;?>', to: "USD"}).toFixed(2);
			  		jQuery('.bs_currency').html(result);


			  	jQuery.getJSON('http://freegeoip.net/json/' , function(data){
			  		var location = data.country_code;
			  			console.log(data);

			  	}
			  		);

			  	   //  // Load exchange rates data via AJAX:
			      // jQuery.getJSON(
			      // 	// NB: using Open Exchange Rates here, but you can use any source!
			      //     'https://openexchangerates.org/api/latest.json?app_id=[YOUR APP ID]',
			      //     function(data) {
			      //         // Check money.js has finished loading:
			      //         if ( typeof fx !== "undefined" && fx.rates ) {
			      //             fx.rates = data.rates;
			      //             fx.base = data.base;
			      //         } else {
			      //             // If not, apply to fxSetup global:
			      //             var fxSetup = {
			      //                 rates : data.rates,
			      //                 base : data.base
			      //             }
			      //         }
			      //     }
			      // );




			  });


			</script>


	<?php
}
add_action('wp_footer', 'run_conversion', 1);
?>