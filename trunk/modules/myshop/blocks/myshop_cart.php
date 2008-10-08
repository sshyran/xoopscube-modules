<?php
 /**
  * block to display items in cart
  *
  * @param integer $options[0] Count of items to show (0 = no limit)
  * @return array Block's content
  */
function b_myshop_cart_show($options)
{
	global $mod_pref, $xoopsConfig;
	include XOOPS_ROOT_PATH.'/modules/myshop/include/common.php';
	$productsCount = intval($options[0]);

	$cartForTemplate = $block = array();
	$emptyCart = false;
	$shippingAmount = $commandAmount = $vatAmount = $discountsCount = 0;
	$goOn = '';
	$commandAmountTTC = 0;
	$discountsDescription = array();
	// Calculate Amount
	$reductions = new myshop_reductions();
	$reductions->computeCart($cartForTemplate, $emptyCart, $shippingAmount, $commandAmount, $vatAmount, $goOn, $commandAmountTTC, $discountsDescription, $discountsCount);
	$dec = myshop_utils::getModuleOption('decimals_count');
	if($emptyCart) {
		return '';
	}
	$block['block_money_full'] = myshop_utils::getModuleOption('money_full');
	$block['block_money_short'] = myshop_utils::getModuleOption('money_short');
	$block['block_shippingAmount'] = sprintf("%0.".$dec.'f', $shippingAmount);		// Shipping
	$block['block_commandAmount'] = sprintf("%0.".$dec.'f', $commandAmount);		// Without Fee
	$block['block_vatAmount'] = sprintf("%0.".$dec.'f', $vatAmount);				// Vat
	$block['block_commandAmountTTC'] = sprintf("%0.".$dec.'f', $commandAmountTTC);	// ALL Fee
	$block['block_discountsDescription'] = $discountsDescription;					// Discount
	if( ($productsCount > 0) && (count($cartForTemplate) > $productsCount)) {
		array_slice($cartForTemplate, 0, $productsCount-1);
	}
	$block['block_caddieProducts'] = $cartForTemplate;								// Products in cart
	return $block;
}

function b_myshop_cart_edit($options)
{
	global $xoopsConfig;
	include XOOPS_ROOT_PATH.'/modules/myshop/include/common.php';
	$form = '';
	$form .= "<table border='0'>";
	$form .= '<tr><td>'._MB_MYSHOP_MAX_ITEMS."</td><td><input type='text' name='options[]' id='options' value='".$options[0]."' /></td></tr>";
	$form .= '</table>';
	return $form;
}
?>