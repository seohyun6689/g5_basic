<?php
include_once('./_common.php');

foreach ( $_POST['group_id'] as $i => $group_id ) {
	$group_subject = trim($_POST['group_subject'][$i]);
	$group_sort = trim($_POST['group_sort'][$i]);
	if ( $group_subject ) {
		
		$sql_common = " 
			his_group_subject = '{$group_subject}',
			his_group_sort = '{$group_sort}'
		 ";
		 
		if ( $group_id <= 0 ) {
			$sql = "insert `{$g5['history_group_table']}` set his_id = '{$his_id}', {$sql_common}";
		} else {
			$sql = "update `{$g5['history_group_table']}` set {$sql_common} where his_group_id = '{$group_id}'";
		}
		sql_query($sql);
	}
}

if ( count($_POST['delete_groups']) > 0 ) {
	foreach($_POST['delete_groups'] as $delete_group) {
		$sql = "delete from `{$g5['history_group_table']}` where his_group_id = '{$delete_group}'";
		sql_query($sql);
	}
}

?>