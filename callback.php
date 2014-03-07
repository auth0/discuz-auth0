<?php

echo "CALLBACK!";
echo $_GET['code'];
require_once "vendor/autoload.php";

use Auth0SDK\Auth0;

$auth0 = new Auth0(array(
    'domain'        => 'hrajchert.auth0.com',
    'client_id'     => 'PiUe1wTxxieYuoPhF3inu9ZEDWfAnmDW',
    'client_secret' => 'Jy37wZUINpEwUXqobsuLVqe7ArXN-zJZCs3UgXofDPt-f07IArPIdG6R6KzHOi1G',
    'redirect_uri'  => 'http://auth0-discuz.cloudapp.net/forum.php',
    'debug'         => true
));

$access_token = $auth0->getAccessToken();
var_dump($access_token);
echo "<pre>";
var_dump($auth0->getUserInfo());
echo "</pre>";
?>
