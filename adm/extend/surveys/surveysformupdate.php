<?php
$sub_menu = '700600';
include_once('./_common.php');

if ( !$w || $w == 'u' ) {

auth_check($auth[$sub_menu], "w");

$su_level = implode( ',', $_POST['su_level'] );
$values = array(
	'su_subject' => $su_subject,
	'su_level' => $su_level,
	'su_begin_time' => $su_begin_time,
	'su_end_time' => $su_end_time,
	'su_multiple' => $su_multiple,
	'su_content' => $su_content,
	'su_created' => G5_TIME_YMDHIS
);

$codition = null;
if ( $su_id ) {
	$condition = array('su_id' => $su_id);
}

$sql = generateQuery( $values, $g5['surveys_m_table'], null, $condition );
$result = sql_query($sql, true);
if ( !$result ) {
	die('설문조사 등록중에 오류가 발생했습니다.');
}
	
} else if ( $w == 'd' ) {
	if (empty($su_id))  {
		alert('삭제할 설문조사가 존재하지 않습니다.');
	}
	
	sql_query( "update {$g5['surveys_m_table']} set su_removed = '" . G5_TIME_YMDHIS . "' where su_id = '{$su_id}' " );
}
if ($w == '' ) {
	$uniqid = mysql_insert_id();
	goto_url( './questions.php?su_id=' . $uniqid );
} else {
	goto_url( './surveyslist.php' );
}
?>
