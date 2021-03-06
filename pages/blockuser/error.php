<?php
/** LiangLeeBlockUser
 * Block a username
 * @package LiangLeeFramework
 * @subpackage  LiangLeeBlockuser 
 * @author Liang Lee
 * @copyright Copyright 2013, Liang Lee
 * @ide The Code is Generated by Liang Lee php IDE.
 * @File error.php
 */
$content = elgg_view('blockuser/error'); 
$title = elgg_echo('error');

$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
	'filter_override' => false
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
