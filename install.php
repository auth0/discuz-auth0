<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 33885 2013-08-27 06:28:19Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$sql = <<<EOF

CREATE TABLE `pre_common_member_auth0` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `auth0_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`uid`)
);

EOF;

runquery($sql);

