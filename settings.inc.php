<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if (!$_GET['ac']) {
	// Show the change button template
	global $_G;
	loadcache('plugin');
	$settings = $_G['cache']['plugin']['auth0login'];
	include template("auth0login:settings");
} else if ($_GET['ac']=="changemessage") { 
	$msg = html_entity_decode( $_POST['msg']);
	$plugin = C::t('common_plugin')->fetch_by_identifier('auth0login');
	$pluginid = $plugin['pluginid'];
	C::t('common_pluginvar')->update_by_variable($pluginid, 'message', array('value' => $msg));
	updatecache(array('plugin', 'setting', 'styles'));
	cleartemplatecache();
	cpmsg('Message changed!', 'action=plugins&operation=config&do='.$pluginid, 'succeed');

} else {
	cpmsg("invalid action");
}
?>
