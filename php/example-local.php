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

$options = array (
  'language' => 'en',
);

$c = new CertoPay(2, 'c1144eb21dfc1158493cf511318688acee64827d6da044463a5e2e25d3a31deb', true);
?>
<form action="http://127.0.0.1:3000/customer/order" method=post>
<?php
$input = $c->submitData($order);
foreach ($input as $value) print $value."\n";
?>
<input type="submit" name=sub value=Pay>
</form>


