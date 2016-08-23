<?php
include_once('./_common.php');
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");
    
check_token();

if( !is_dir(G5_IMAGES_DATA_PATH . '/' . $img_id ) && !file_exists( G5_IMAGES_DATA_PATH . '/' . $img_id ) )
{
	$old = umask(0); 
	mkdir(G5_IMAGES_DATA_PATH . '/' . $img_id,0777); 
	mkdir( sprintf( G5_IMAGES_ITEMS_PATH , $img_id ) ,0777); 
	umask($old);
	
}


$sql_common = "
	img_name = '{$img_name}'
";
    
if ( $w == '' )
{	
	$sql = "select count(*) as cnt from `{$g5['images_master_table']}` where img_id = '{$img_id}'";
	$exists_id = sql_fetch( $sql, true );	
	if ( $exists_id['cnt'] > 0 )
	{
		alert( "요청하신 슬라이더 ID는 존재합니다. 다시 설정해 주시기 바랍니다." );
		exit;
	}
	
	$sql = "insert `{$g5['images_master_table']}` set img_id='{$img_id}', {$sql_common}";
	$result = sql_query($sql, true);
	// $ws_id = mysql_insert_id();
	
	goto_url("./images_form.php?w=u&amp;id=$img_id");
}
else if ( $w == 'u' )
{	
	$sql = "update {$g5['images_master_table']} set {$sql_common} where img_id = '{$img_id}'";
	$result = sql_query($sql);

	goto_url("./images_form.php?w=u&amp;id=$img_id");
}


?>