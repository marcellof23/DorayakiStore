<?
  ini_set( "soap.wsdl_cache_enabled", 0 );
  ini_set( 'soap.wsdl_cache_ttl', 0 );

  function login( $login, $password )
  {
    echo "some string";
    return "some string";
  }

  function statusReq( $recipe_id, $recipe_name, $qty )
  {
    $controller = new DorayakiController();

    $controller->updateDorayaki();
  }

  $server = new SoapServer( "test.wsdl" );
  $server->addFunction( "login" );
  $server->addFunction( "statusReq" );
  $server->handle();
?>
