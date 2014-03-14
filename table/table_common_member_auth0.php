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
	public function findByAuth0Id($id) {
		return DB::fetch_first('SELECT * FROM %t a JOIN %t d ON a.id = d.uid WHERE auth0_id = %s', array($this->_table,'common_member', $id));
	}

	public function bindUsers($auth0User, $auth0Member) {
		$bind = array("id" => $auth0Member["uid"], "auth0_id" => $auth0User["user_id"], "is_bound"=>1);
		return $this->insert($bind, false, true);
	}
}

