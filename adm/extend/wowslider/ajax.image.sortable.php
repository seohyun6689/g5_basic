<?php
include_once('./_common.php');

if ( count($sortables) <= 0 ) { return ; }
foreach ( $sortables as $sortable => $wsi_id ) {
	$sql = "update {$g5['ws_images_table']} set wsi_sortable = {$sortable} where wsi_id = {$wsi_id} ";
	sql_query($sql);
}
?>