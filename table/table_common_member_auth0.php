<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_member_auth0 extends discuz_table {

	public function __construct() {
		$this->_table = 'common_member_auth0';
		$this->_pk = 'uid';

		parent::__construct();
	}
	public function findByAuth0Id($uid) {
		return DB::fetch_first('SELECT * FROM %t a JOIN %t d ON a.uid = d.uid WHERE auth0_id = %s', array($this->_table,'common_member', $uid));
	}

	public function bindUsers($auth0User, $auth0Member) {
		$bind = array("uid" => $auth0Member["uid"], "auth0_id" => $auth0User["user_id"]);
		return $this->insert($bind, false, true);
	}

	public function deleteByUid($uid) { 
		return $uid ? DB::delete($this->_table, DB::field('uid', $uid)) : false;
	}
}

