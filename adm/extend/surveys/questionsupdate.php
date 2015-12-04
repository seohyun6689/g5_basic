<?php
$sub_menu = '700600';
include_once('./_common.php');	

auth_check($auth[$sub_menu], "w");

$delete_suq_id = array();
$values = array();
$suq_sort = 0;
for ( $i = 0; $i <= $su_item_cnt; $i++ ) {
	$key = preg_replacE( '/\D/', '', $suq_sort_key[$i] );
	$suq_id = $_POST['_suq_id_' . $key];
	$category = $_POST['_category_' . $key];
	$type = $_POST['_type_' . $key];
	$max_select = $_POST['_amax_' . $key];
	$etc = $_POST['_etc_' . $key];
	$question = $_POST['_q_' . $key];
	$answer = $_POST['_a_' . $key];

	if ( empty($question) ){
		if ( $suq_id ) $delete_suq_id[] = $suq_id;
		continue;
	}
	
	$suq_sort++;
	$value = array(
		'su_id' => $su_id,
		'suq_id' => $suq_id,
		'suq_sort' => $suq_sort,
		'suq_category' => $category,
		'suq_type' => $type,
		'suq_max_select' => $max_select,
		'suq_question' => $question,
		'suq_enable_etc' => (is_null($etc) ? 'disabled' : 'enabled')
	);
	
	for ( $ak = 0; $ak < 10; $ak++) {
		$a = $answer[$ak];
		$value['suq_answer_'.($ak+1)] = $a;
	}
	
	array_push( $values, $value );
}

foreach ( $values as $row ) {
	$condition = null;
	if ( $row['suq_id'] ){ $condition =  array('suq_id' => $row['suq_id']); }
	else {  $row['suq_created'] = G5_TIME_YMDHIS; }
	$sql = generateQuery( $row, $g5['surveys_q_table'], null, $condition );
	sql_query( $sql );
}

if ( count($delete_suq_id) > 0 ) {
	sql_query("delete from {$g5['surveys_q_table']} where suq_id in (" . implode( ',', $delete_suq_id) . ")");
}

surveys_count_update( $su_id );

goto_url('./questions.php?su_id=' . $su_id);
?>