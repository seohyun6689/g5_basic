<?php
$sub_menu = '700400';
include_once('./_common.php');
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");
    
check_token();


if( !isset($ws_bullet_type) )
{
	$ws_bullet_type = 'bullet';
}
if ( !isset($ws_captions_effect) )
{
	$ws_captions_effect = 'None';
}

if ( is_array($ws_image_effect) )
{
	$ws_image_effect = implode(',', $_POST['ws_image_effect']);
}

$sql_common = "
	ws_name = '{$ws_name}',
	ws_auto_play = '{$ws_auto_play}',
	ws_pause_on_mouseover = '{$ws_pause_on_mouseover}',
	ws_stop_slideshow = '{$ws_stop_slideshow}',
	ws_random_order = '{$ws_random_order}',
	ws_pause_play_button = '{$ws_pause_play_button}',
	ws_full_screen_button = '{$ws_full_screen_button}',
	ws_swipe_support = '{$ws_swipe_support}',
	ws_preloader = '{$ws_preloader}',
	ws_show_controls_mouseover = '{$ws_show_controls_mouseover}',
	ws_show_prev_next_buttons = '{$ws_show_prev_next_buttons}',
	ws_captions = '{$ws_captions}',
	ws_captions_effect = '{$ws_captions_effect}',
	ws_noframe = '{$ws_noframe}',
	ws_show_bullet = '{$ws_show_bullet}',
	ws_bullet_type = '{$ws_bullet_type}',
	ws_bullet_align = '{$ws_bullet_align}',
	ws_bullet_thumb_prev = '{$ws_bullet_thumb_prev}',
	ws_filmstrip_align = '{$ws_filmstrip_align}',
	ws_thumb_size = '{$ws_thumb_size}',
	ws_thumb_width = '{$ws_thumb_width}',
	ws_thumb_height = '{$ws_thumb_height}',
	ws_image_size = '{$ws_image_size}',
	ws_image_width = '{$ws_image_width}',
	ws_image_height = '{$ws_image_height}',
	ws_font_color = '{$ws_font_color}',
	ws_font_family = '{$ws_font_family}',
	ws_font_size = '{$ws_font_size}',
	ws_size_style = '{$ws_size_style}',
	ws_template = '{$ws_template}',
	ws_multiple_effects = '{$ws_multiple_effects}',
	ws_image_effect = '{$ws_image_effect}',
	ws_delay = '{$ws_delay}',
	ws_duration = '{$ws_duration}',
	ws_onbefore_func = '{$ws_onbefore_func}',
	ws_onstep_func = '{$ws_onstep_func}',
	ws_override_css = '{$ws_override_css}'
";
    
if ( $w == '' )
{
	
	$sql = "select count(*) as cnt from `{$g5['ws_master_table']}` where ws_id = '{$ws_id}'";
	$exists_ws_id = sql_fetch( $sql );
	if ( $exists_ws_id['cnt'] > 0 )
	{
		alert( "요청하신 슬라이더 ID는 존재합니다. 다시 설정해 주시기 바랍니다." );
		exit;
	}
	
	$sql = "insert `{$g5['ws_master_table']}` set ws_id='{$ws_id}', {$sql_common}";
	$result = sql_query($sql);
	
	
	if( $result && !is_dir(G5_WS_DATA_PATH . '/' . $ws_id ) && !file_exists( G5_WS_DATA_PATH . '/' . $ws_id ) )
	{
		$old = umask(0); 
		mkdir(G5_WS_DATA_PATH . '/' . $ws_id,0777); 
		mkdir( sprintf( G5_WS_IMAGES_PATH , $ws_id ) ,0777); 
		mkdir( sprintf( G5_WS_ENGINE_PATH , $ws_id ) ,0777); 
		umask($old);
	}
	// $ws_id = mysql_insert_id();
	
	goto_url("./wowslider_form.php?w=u&amp;ws_id=$ws_id");
}
else if ( $w == 'u' )
{	
	$sql = "update {$g5['ws_master_table']} set {$sql_common} where ws_id = '{$ws_id}'";
	$result = sql_query($sql);
	if ( $result )
	{
		include_once( dirname(__FILE__) . '/wowslider_process.php' );
	}
	
	goto_url("./wowslider_form.php?w=u&amp;ws_id=$ws_id");
}


?>