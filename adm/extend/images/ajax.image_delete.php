<?php
include_once('./_common.php');

$rows = array();

if ( !isset($img_item_id) )
{
	exit();
}

$sql = "select * from `{$g5['images_items_table']}` where img_item_id = '{$img_item_id}'";
$image = sql_fetch( $sql );

$sql = "delete from {$g5['images_items_table']} where img_item_id = '{$img_item_id}'";
$result = sql_query( $sql );
if ( $result )
{
	@unlink( sprintf( G5_IMAGES_ITEMS_PATH, $image['img_id'] ) . '/' . $image['file_name'] );
	@unlink( sprintf( G5_IMAGES_ITEMS_PATH, $image['img_id'] ) . '/thumb/' . $image['file_name'] );
}
?>