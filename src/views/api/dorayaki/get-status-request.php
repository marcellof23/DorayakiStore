<?

require_once '../../../config/constant.php';
require_once ROOT . '/controllers/dorayaki.php';

$client = new SoapClient( "http://172.17.0.1:5000/api/dorayaki/test.wsdl", array( 'cache_wsdl' => WSDL_CACHE_NONE ) );
try {
  $responseLogin = $client->login( 'test_user', 'test_password' );
  
  echo $responseLogin;

  if($responseLogin == "success") { // if success
    $response = $client->doFilter( $params ); // call doFilter() from .wsdl
    ?>
      <pre><? print_r( $response ); ?></pre>
    <?
  }
} catch ( SoapFault $sf ) {
  echo "oi";
  echo $sf->getMessage();

}
?>
