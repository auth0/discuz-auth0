<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_auth0login {
	function __construct() {
//		include 'common.php';
		global $_G;
/*		$this->identifier = $IDENTIFIER;
		$this->siteid = trim($_G['cache']['plugin'][$IDENTIFIER]['siteid']);
		$this->iconurl = trim($_G['cache']['plugin'][$IDENTIFIER]['iconurl']);
		$this->comment = trim($_G['cache']['plugin'][$IDENTIFIER]['comment']);
		$this->autobind = $_G['cache']['plugin'][$IDENTIFIER]['autobind'];
		$this->fromuid = (!empty($_G['cookie']['promotion']) && $_G['setting']['creditspolicy']['promotion_register'])? intval($_G['cookie']['promotion']) : 0;
		$this->extra = ($this->fromuid)? "&fromuid={$this->fromuid}" : '';
		$this->href = $AUTHURL.'?siteid='.$this->siteid.'&autobind='.$this->autobind.$this->extra;
		$this->showlogin = ($_G['uid'] || $_G['setting']['bbclosed'] || periodscheck('visitbanperiods', 0))? false : true;*/
	}
	function global_login_extra() {
		include_once template('auth0login:widget');	
		return tpl_auth0_login_widget();
	}

	// Hook into the global delete member function to delete the user from the auth0 db if needed	
	function deletemember($hookinfo) {
		if ($hookinfo["step"] == "delete") {
			C::t('#auth0login#common_member_auth0')->deleteByUid($hookinfo["param"][0]);		
		}
	}

}
class plugin_auth0login_member extends plugin_auth0login {
	// Hook on the logout action to clear PHP Session. This is needed because current Auth0 SDK stores data in $_SESSION, which is not
	// used by discuz. This fix a bug where you cannot log in with one account, logut and then login with a new account using the same
	// instance of the browser (cookies!)
	function logging() {
		if ($_GET['action'] == "logout") {
			session_start();
			setcookie(session_name(), '', 100);
			session_unset();
			session_destroy();
			$_SESSION = array();
		}
	}
}
/*
class plugin_darglogin_member extends plugin_darglogin {
	function logging_method() {
		return $this->login_link();
	}
	function register_logging_method() {
		return $this->login_link();
	}
}

class mobileplugin_darglogin extends plugin_darglogin {
	function __construct() {
		parent::__construct();
		global $_G;
		$this->mobilelink = addslashes(trim($_G['cache']['plugin'][$this->identifier]['mobilelink']));
		$this->touchlink = addslashes(trim($_G['cache']['plugin'][$this->identifier]['touchlink']));
	}
	function global_footer_mobile() {
		if(!$this->showlogin) return '';
		if(!defined('CURSCRIPT') || CURSCRIPT!='forum') return;
		include template($this->identifier.':login');
		return $return;
	}
}
*/
?>
