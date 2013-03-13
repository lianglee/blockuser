<?php
/** LiangLeeBlockUser
 * Block a username
 * @package LiangLeeFramework
 * @subpackage  LiangLeeBlockuser 
 * @author Liang Lee
 * @copyright Copyright 2013, Liang Lee
 * @ide The Code is Generated by Liang Lee php IDE.
 * @File start.php
 */
elgg_register_event_handler('init', 'system', 'blockuser');

//BlockUser lib is required to run this plugin.
require_once(LiangLee_plugin_path('blockuser','lib').'LiangLeeBlockUser.php');

/**
* Register a blockuser settings to system
*/
function blockuser() {

/**
* Register a new profile page
*/
elgg_register_page_handler('profile', 'blockuser_profile_page_handler');
/**
* Register a blockuser Error page
*/
elgg_register_page_handler('blockuser', 'blockuser_handler');
/**
* Register a blockuser css to system
*/
elgg_extend_view('css/elgg', 'blockuser/css');

elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'blockuser_owner_block_menu');

elgg_extend_view('page/elements/body', 'blockuser/api');

if (elgg_is_active_plugin('friend_request')) { 
elgg_register_action("friends/add", dirname(__FILE__) . "/actions/friends/add.php");
} else {
elgg_register_action("friends/add", dirname(__FILE__) . "/actions/default/friends/add.php");

   }

}
/**
 * Profile page handler
 *
 * @param array $page Array of URL segments passed by the page handling mechanism
 * @return bool
 */

function blockuser_profile_page_handler($page) {
if (isset($page[0])) {
		$username = $page[0];
		$user = get_user_by_username($username);
		elgg_set_page_owner_guid($user->guid);
}
    blockuser_access('/blockuser', $user);
	if (!$user || ($user->isBanned() && !lee_loggedin_admin)) {
		register_error(elgg_echo('profile:notfound'));
		forward();
	}
	$action = NULL;
	if (isset($page[1])) {
		$action = $page[1];
	}
	if ($action == 'edit') {
		$base_dir = lee_www;
		require "{$base_dir}pages/profile/edit.php";
		return true;
	}
	$params = array(
		'content' => elgg_view('profile/wrapper'),
		'num_columns' => 3,
	);
	$content = elgg_view_layout('widgets', $params);
	$body = elgg_view_layout('one_column', array('content' => $content));
	echo elgg_view_page($user->name, $body);
	return true;
 }

/**
* Blockuser page handler
*/
function blockuser_handler($page) {
$base_dir = lee_wwwmod . 'blockuser/pages/blockuser';
if (!isset($page[0])) {$page = array('error');}
switch ($page[0]) {
		case "error":
			include "$base_dir/error.php";
			break;
			
		default:
			return false;
	}
	return true;
}


/**
 * Add a menu item to an ownerblock
 */
function blockuser_owner_block_menu($hook, $type, $return, $params) {
	    $url_gen = lee_framework_encode_64($params['entity']->username);
		$url = "settings/plugins/".lee_loggedin_entity_username."?block_user=".$url_gen;
	    if (elgg_is_logged_in() && lee_loggedin_entity_guid != $params['entity']->guid && elgg_in_context('profile')) {
		$opt = array(
		   'name' => 'blockuser', 
		   'text' => '<div class="LiangLee_blockuser_view_icon">'.elgg_echo('blockuser').'</div>', 
		   'href' =>  "#lianglee_blockuser",'id' => 'lianglee_blockuser_load');
		$item = ElggMenuItem::factory($opt);
		$item->setSection('action');
		$return[] = $item;
      	}
        return $return; 
}

