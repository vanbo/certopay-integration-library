<?php
require 'certopay.php';


$order = array (
  'currency' => 'USD',
  'email' => 'admin@failsafepayments.com',
  'success_url' => 'https://www.failsafepayments.com?ok',
  'cancel_url' => 'https://www.failsafepayments.com?cancel',
  'fail_url' => 'https://www.failsafepayments.com?fail',
  'notification_url' => 'https://www.failsafepayments.com?notify',
  'billing_address_attributes' => array (
    'first_name' => 'John',
    'last_name' => 'Doe',
    'address' => 'po box 555',
    'country' => 'CY',
    'city' => 'Nicosia',
    'zip' => '1075',
  ),
  'shipping_address_attributes' => array (
    'first_name' => 'Jane',
    'last_name' => 'Dow',
    'address' => 'po box 123',
    'country' => 'DE',
    'city' => 'Berlin',
    'zip' => '1023',
  ),
  'line_items_attributes' => array (
    0 => array (
      'name' => 'Book 1',
      'amount' => 55,
      'quantity' => 1,
    ),
    1 => array (
      'name' => 'Book 2',
      'amount' => 1000,
      'quantity' => 2,
    ),
  ),
  'shipping_amount' => 1000,
  'tracking_params_attributes' => array (
    0 => array (
      'name' => 'cart_id',
      'value' => 'xc73hdbWWEHc',
    ),
    1 => array (
      'name' => 'user_id',
      'value' => 'cvwuh377434654',
    ),
  ),
);

$c = new CertoPay(11, '1539c6badcb42f612a59a59ab38c6e8970b10af770223f55beaf999391e2478a', false);
?>
<form action="https://secure.certopay.com/customer/order" method=post>
<?php
$input = $c->submitData($order);
foreach ($input as $value) print $value."\n";
?>
<input type="submit" name=sub value=Pay>
</form>

