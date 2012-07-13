<?php
require "certopay.php";


$c = new CertoPay(11, '1539c6badcb42f612a59a59ab38c6e8970b10af770223f55beaf999391e2478a', false);

if ($c->verifyReceivedSignature($_REQUEST)) { print "Signature Valid";}
  else {
    print "Signature Invalid";
  }
?>
