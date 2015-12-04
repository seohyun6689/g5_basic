<?php
$sub_menu = '700600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$values = array(
	'su_id' => $su_id,
	'suc_name' => $suc_name,
	'suc_summary' => $suc_summary,
	'suc_created' => G5_TIME_YMDHIS
);
$condition = null;
if ( isset($suc_id) && $suc_id > 0 ) {
	$condition = array('suc_id' => $suc_id);
}

$sql = generateQuery($values, $g5['surveys_c_table'], null, $condition);
sql_query( $sql, true );
goto_url( './index.php?su_id=' . $su_id );
?>