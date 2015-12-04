<?php
$sub_menu = '700600';
include_once( './_common.php' );	
include_once( G5_PLUGIN_PATH . '/PHPExcel/PHPExcel.php');
auth_check($auth[$sub_menu], "r");

function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }
function is_ie() {
	if(!isset($_SERVER['HTTP_USER_AGENT']))return false;
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) return true; // IE8
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 6.1') !== false) return true; // IE11
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows NT 10.0') !== false) return true; // IE11
	return false;
}

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator('Maarten Balliauw')
							->setLastModifiedBy('Maarten Balliauw')
							->setTitle('Office 2007 XLSX Test Document')
							->setSubject('Office 2007 XLSX Test Document')
							->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.');
$objPHPExcel->setActiveSheetIndex(0);

$surveys = sql_fetch("select * from {$g5['surveys_m_table']} where su_id = '{$su_id}' ");
// 질문출력
$fields = array();
$values = array();
$sql = "select * from {$g5['surveys_q_table']} where su_id = '{$su_id}' ORDER BY suq_sort asc";
$result = sql_query($sql);
$chr_code = 65;
$objPHPExcel->getActiveSheet()->setCellValue( chr($chr_code). '1', '타임스탬프');
$objPHPExcel->getActiveSheet()->getColumnDimension(chr($chr_code))->setWidth(20);
$chr_code++;

while ( $q = sql_fetch_array($result) ){
	$column = chr($chr_code);
	$objPHPExcel->getActiveSheet()->setCellValue($column . '1', $q['suq_question']);
	$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(50);
	$search[] = " GROUP_CONCAT(IF(suq_id = " . $q['suq_id'] . ", `sur_result_value`, NULL) ) AS {$column} ";
	$fields[] = $column;
	$chr_code++;
}

$columns  = implode( ', ', $search );
$sql = "SELECT sur_created, " . $columns . "  FROM `g5_surveys_r` GROUP BY uniqid ";
$result = sql_query( $sql );
$i = 2;

while ( $data = sql_fetch_array($result) ) {
	$value = array();
	$value[ 'A' . $i ] = $data['sur_created'];
	foreach ( $fields as $field ) {
		$value[$field.$i] = $data[$field];
	} 
	$i++;
	
	array_push($values, $value);
}

$index = 2;
foreach( $values as $value ) {
	$array_keys = array_keys( $value );
	$objPHPExcel->getActiveSheet()->fromArray($value, NULL, 'A' . $index );
	$index++;
}


$filename = $surveys['su_subject'].  '_' . date('YmdHis') .'.xls';
if( is_ie() ) $filename = utf2euc($filename);


header('Content-Type: application/vnd.ms-excel;charset=utf-8');
header('Content-type: application/x-msexcel;charset=utf-8');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>