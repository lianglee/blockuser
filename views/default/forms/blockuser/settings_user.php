<?php

$settings = elgg_get_plugin_user_setting('blockuser_get', lee_loggedin_user_guid , 'blockuser');
$get = get_input('block_user');
if(get_input('block_user') && !empty($get)){
$block_user = base64_decode(get_input('block_user'));
$value = $settings.', '.$block_user;
$msg = "<div class='LiangLee_blockuser_msg'><div class='LiangLee_blockuser_msg-text'>".elgg_echo('block:add:msg',array($block_user))."</div></div>";
foreach(lee_framework_get_options($settings) as $match){ 
if($match == $block_user){ unset($value); unset($msg); $value = $settings; }	
	} echo $msg; } else { $value = $settings;
 } echo elgg_echo('lee:blockuser:block'); 
 echo  elgg_view("input/text", array("name" => "params[blockuser_get]", "placeholder" => elgg_echo('lee:block:plc'),"value" => $value));echo elgg_echo('usernames:block'); 
lee_blockuser_view($settings);

