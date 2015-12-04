<?php
$sub_menu = '700400';
include_once('./_common.php');

$rows = array();

if ( !isset($wsi_id) )
{
	exit();
}
$sql = "select * from `{$g5['ws_images_table']}` where wsi_id = '{$wsi_id}'";
$image = sql_fetch( $sql );

$sql = "delete from {$g5['ws_images_table']} where wsi_id = '{$wsi_id}'";
$result = sql_query( $sql );
if ( $result )
{
	@unlink( sprintf( G5_WS_IMAGES_PATH, $image['ws_id'] ) . '/' . $image['wsi_file'] );
	@unlink( sprintf( G5_WS_IMAGES_PATH, $image['ws_id'] ) . '/thumb/' . $image['wsi_file'] );
}
?>