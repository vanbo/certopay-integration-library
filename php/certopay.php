<?php 

class CertoPay {
  protected $_shop_id;
  protected $_secret_key;
  protected $_debug;

  public function __construct ($shop_id, $secret_key, $debug = false) {
    $this->_shop_id = $shop_id;
    $this->_secret_key = $secret_key;
    $this->_debug = $debug;
      }

  public function submitData (array $order, array $options = array () ) {
    $signature_items = array ("shop_id$this->_shop_id");

    $inputLines = array_merge($this->processArray ($order, 'order', &$signature_items), $this->processArray ($options, 'options',&$signature_items));

    sort ($signature_items);

    $signature = '';

    foreach ($signature_items as $value) $signature .= $value;
    $signature .= $this->_secret_key;

    $inputLines[] = $this->buildLine('order[signature_v2]', hash("sha256", $signature));
    $inputLines[] = $this->buildLine('order[shop_id]', $this->_shop_id);

    if ($this->_debug) {
      print "<h1>Sorted parameters</h1>";
      print "<pre>";
      foreach ($signature_items as $value) {
        print "|$value|\n";
      }
      foreach ($inputLines as $value) print '< '. substr($value,1)."\n";
      print "</pre>";

      print "<h1>Signature</h1><pre>$signature</pre>";
    }
    return $inputLines;
  }

  private function processArray (array $data, $prefix , &$signature_elements) {
    $result = array ();
    foreach ($data as $key => $value) {
      if (is_array($data[$key])) { $result = array_merge_recursive($result,$this->processArray($data[$key], sprintf('%s[%s]', $prefix, is_integer($key)?'':$key ), &$signature_elements)) ;}
      else {
        $signature_elements[] = $key.$value;
        $result[] = $this->buildLine($prefix.'['.$key.']',$value);
      }
    }
    return $result;
  }
  private function buildLine ( $name, $value, $add_line_breaks = true) {
    return sprintf('<'.'input type="hidden" name="%s" value="%s" >', $name, $value).( $add_line_breaks ? "\n" : '');
  }

  public function verifyReceivedSignature (array $request){
    $signature_items = $this->processRequest($request);

    $s = '';
    sort($signature_items);

    foreach ($signature_items as $value) $s .= $value;

    $signature = hash('sha256',$s.$this->_secret_key);

    if ($this->_debug) {
      print "<pre>\n";
      foreach ($signature_items as $value) print "|$value|\n";
      print $s."\n";
      print "Request signature: " . $request['signature_v2']."\n";
      print "Build signature: " . $signature . "\n";
      print "</pre>\n";
    }

    return  $signature == $request['signature_v2'];

  }

  private function processRequest(array $request) {
    $result = array ();
    foreach ($request as $key => $value) {
      if ($key == 'signature_v2') continue;
      if (is_array($request[$key])) { $result = array_merge_recursive($result,$this->processRequest($request[$key])); }
      else {
        $result[] = $key.$value;
      }
    }
    return $result;
  }
}
?>
