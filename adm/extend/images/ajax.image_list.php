<?php
include_once('./_common.php');

$sldr_id = (isset($_GET['img_id']) && trim($_GET['img_id']) != '' ? $_GET['img_id'] : '');

$rows = array();

if ( !isset($sldr_id) )
{
	$error = array('error' => urlencode('슬라이더 아이디가 존재하지 않습니다.'));
	die( urldecode( json_encode( $error ) ) );
}

$sql = "select * from {$g5['images_items_table']} where img_id = '{$img_id}' order by img_item_sortable asc";
$result = sql_query( $sql , flase);
while ( $row = sql_fetch_array($result) )
{
	$rows[] = $row;
}
die( json_encode( $rows ) );
?>