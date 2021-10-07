<?php
require_once('plugins/login-password-less.php');

/** Set supported servers
    * @param array array($domain) or array($domain => $description) or array($category => array())
    * @param string
    */
return new AdminerLoginPasswordLess(
    $password_hash = password_hash("admin", PASSWORD_DEFAULT)
);