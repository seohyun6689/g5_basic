<?php
include_once('./_common.php');

if ( count($sortables) <= 0 ) { return ; }
foreach ( $sortables as $sortable => $img_item_id ) {
	$sql = "update {$g5['images_items_table']} set img_item_sortable = {$sortable} where img_item_id = {$img_item_id} ";
	sql_query($sql);
}
?>