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
		//return ($this->showlogin)? '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">
		//	<p><a href="'.$this->href.'"><img src="'.$this->iconurl.'" class="vm" alt="Login" /></a></p>
		//	<p class="hm xg1" style="padding-top: 2px;">'.$this->comment.'</p>
		//	</div>' : '';
	}
	function global_login_text() {
		return "ccc";
		//return $this->login_link();
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