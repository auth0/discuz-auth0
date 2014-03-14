<?php 

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

use Auth0SDK\Auth0;

// TODO: See if we find a simpler redirect
function _redirect($url) {
	header("HTTP/1.1 301 Moved Permanently");
	dheader("location: ".str_replace('&amp;', '&', $url));
	dexit();
}

$op = $_GET["op"];
if ($op == "callback") {
	// If the user is already login, show them home
	if ($_G["uid"]) {
		showmessage("You are already login", "/index.php");
	}
	// Get the user information using the auth protocol
	require_once "vendor/autoload.php";


	$auth0 = new Auth0(array(
		'domain'        => 'hrajchert.auth0.com',
		'client_id'     => 'PiUe1wTxxieYuoPhF3inu9ZEDWfAnmDW',
		'client_secret' => 'Jy37wZUINpEwUXqobsuLVqe7ArXN-zJZCs3UgXofDPt-f07IArPIdG6R6KzHOi1G',
		'redirect_uri'  => 'http://auth0-discuz.cloudapp.net/forum.php',
		'debug'         => true
	));

	$userInfo = $auth0->getUserInfo();
	if ($userInfo['code'] != 200) {
		showmessage("Authentication problem");
	}

	$auth0User = $userInfo['result'];


	require_once libfile('function/member');
	// See if we have a user already logged in, if so log the man in!
	$auth0Member = C::t('#auth0login#common_member_auth0')->findByAuth0Id($auth0User['user_id']);
	$cookietime = 1296000;
	if ($auth0Member) {
		setloginstatus($auth0Member, $cookietime);
		_redirect("/index.php");
	}
	// If not, we need to create a new account for him
	loaducenter();
	$auth0Member["username"] = $auth0User["nickname"];
	$auth0Member["password"] = md5(random(10));
	$auth0Member["email"]    = $auth0User["email"];
	$emailstatus	= $auth0User["email_verified"];
	if (trim($auth0Member["email"]) == "") {
		 $auth0Member["email"] = $auth0User["nickname"] . "@auth0.com";
		 $emailstatus = false;
	}

	//var_dump($auth0Member);
	//die("well");
	do {
		$uc_result = uc_user_register($auth0Member["username"], $auth0Member["password"], $auth0Member["email"]);
		if ($uc_result == -3) {
			$auth0Member["username"] = $auth0User["nickname"] . rand(0,100);
		}

		if ($uc_result == -6) {
			$auth0Member["email"] = $auth0User["nickname"] . rand(0,100) . "@auth0.com";
			$emailstatus = false;
		}
	} while ($uc_result == -3 || $uc_result == -6); // Try to register until we find a valid username and email
	if ($uc_result < 0 ) {
		$msg = "Cannot register new user: ";
		if ($uc_result == -1 || $uc_result == -2) {
			$msg .= "invalid username ".$auth0Member["username"]. ", code:". $uc_result;
		} else if ($uc_result == -4 || $uc_result == -5) {
			$msg .= "invalid email";
		} else if ($uc_result == -6) {
			$msg .= "There already is an account registered with this email: " . $auth0Member["email"];
		}
		showmessage($msg);
	}
	
	// If we could register, we need to actually create the user
	$auth0Member["uid"] = $uc_result;
	$extra = array("emailstatus"=>$emailstatus);
	$groupid = $_G['setting']['newusergroupid'];
	C::t('common_member')->insert($auth0Member["uid"], $auth0Member["username"], $auth0Member["password"], $auth0Member["email"], $_G['clientip'], $groupid, $init_arr);
	// Bind it to the auth0User
	C::t("#auth0login#common_member_auth0")->bindUsers($auth0User, $auth0Member);
	// And then log him in
	setloginstatus($auth0Member, $cookietime);
	_redirect("/index.php");
} else {
	showmessage("Invalid action");
}
?>

