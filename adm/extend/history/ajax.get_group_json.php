<?php
include_once('./_common.php');
$sql = "select * from `{$g5['history_group_table']}` where his_id = '{$his_id}' order by his_group_sort desc, his_group_id asc";
$result = sql_query($sql);
$groups = array();
while( $row = sql_fetch_array($result) ) {
	$row['his_group_subject'] = urlencode($row['his_group_subject']);
	$groups[] = $row;
}

echo urldecode(json_encode($groups));
?>