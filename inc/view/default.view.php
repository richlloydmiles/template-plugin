<div class="wrap">
 <h2>Bootstrap Tourism Currency Converter</h2>


<?php
if (isset($_POST['base_currency'])) {
	$this->set_option('base_currency', $_POST['base_currency']);
}
?>
<form action="" method="post">
  <h3>Basic Options</h3>
  <p>
    <label for="base_currency" >Select Base Currency</label>
  <select name="base_currency" id="base-currency-select-box">
<?php $currencies = array("ZAR", "USD", "EUR", "CAN");?>
    <?php echo $this->get_select_box(
	$currencies, $this->get_option('base_currency')
);?>
</select>
</p>
        <input type="submit" class="button-primary" value="Save Options">
    </form>
  </div>

