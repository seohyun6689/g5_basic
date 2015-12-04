<?php
include_once('./_common.php');

$sql_common = "
	`his_subject` = '{$his_subject}',
	`his_start_year` = '{$his_start_year}',	
	`his_end_year` = '{$his_end_year}',	
	`his_output_type` = '{$his_output_type}',
	`his_sort` = '{$his_sort}',
	`his_use_group` = '{$his_use_group}',
	`his_skin` = '{$his_skin}',
	`his_mobile_skin` = '{$his_mobile_skin}'
";

if ($w == '') {
	$sql = "select count(*) cnt from `{$g5['history_master_table']}` where his_id = '{$his_id}'";
	$has_master = sql_fetch($sql);

	if ( $has_master['cnt'] > 0 ) {
		alert( "요청하신 아이디는 존재합니다. 다시 설정해 주시기 바랍니다." );
	}
	
	$sql = "insert {$g5['history_master_table']} set his_id = '{$his_id}', $sql_common, his_created = '" . G5_TIME_YMDHIS . "'";
	$result = sql_query($sql);
	if ( $result )  { alert( '등록을 완료하였습니다.', './history_form.php?w=u&his_id=' . $his_id ); }
}
else if ( $w == 'u' ) {
	$sql = "select * from `{$g5['history_master_table']}` where his_id = '{$his_id}'";
	$history = sql_fetch($sql);
	
	$sql = "update {$g5['history_master_table']} set $sql_common where his_id = '{$his_id}' ";
	$result = sql_query($sql);
	if ( $result )  { 
		
		if ( isset($_POST['his_item_id']) && is_array($_POST['his_item_id']) ) {
			foreach( $_POST['his_item_id'] as $i => $his_item_id ) {
				$his_group_id = trim($_POST['his_group'][$i]);
				$his_item_year = trim($_POST['his_item_year'][$i]);
				$his_item_month = trim($_POST['his_item_month'][$i]);
				$his_item_day = trim($_POST['his_item_day'][$i]);
				$his_item_date = trim($_POST['his_item_date'][$i]);
				$his_item_content = trim($_POST['his_item_content'][$i]);
				$his_item_note = trim($_POST['his_item_note'][$i]);
				$his_item_disable = trim($_POST['his_item_note'][$i]);
				
				if ($his_item_content) {
					$sql_common = "
						his_group_id = '{$his_group_id}',
						his_item_year = '{$his_item_year}',
						his_item_month = '{$his_item_month}',
						his_item_day = '{$his_item_day}',
						his_item_date = '{$his_item_date}',
						his_item_content = '{$his_item_content}',
						his_item_note = '{$his_item_note}',
						his_item_disable = '{$his_item_disable}'
					";
					if (!trim($his_item_id)) {
						$sql = "insert `{$g5['history_item_table']}` set {$sql_common}, his_id = '{$his_id}' ";
					} else {
						$sql = "update `{$g5['history_item_table']}` set {$sql_common} where his_item_id = '{$his_item_id}' ";
					}
					sql_query($sql);
				}
			}
		}

		// 삭제한 히스토리 항목
		if ( isset($_POST['delete_item']) && is_array($_POST['delete_item']) ) {
			foreach( $_POST['delete_item'] as $delete_item ) {
				if ($delete_item) {
					$sql = "delete from `{$g5['history_item_table']}` where his_item_id = '{$delete_item}'";
					sql_query($sql);
				}
			}
		}
			
		alert( '수정을 완료하였습니다.', './history_form.php?w=u&his_id=' . $his_id ); 
	}
	
	
}

?>
