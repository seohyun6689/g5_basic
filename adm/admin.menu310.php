<?php
$menu['menu310'] = array (
	array('310000', '게시물관리', '#', 'board')
);
$ignore_board = array();
if(count($ignore_board)) {
	$sql_search .= " and bo_table not in ('" . implode("', '", $ignore_board) . "') ";
}
$sql = "select * from {$g5['board_table']} a where (1) {$sql_search} ";
$result = sql_query($sql);
$boardindex = 1;
while($row = sql_fetch_array($result)){
	$menu['menu310'][] = array('310' . sprintf('%03d', $boardindex), $row['bo_subject'], G5_ADMIN_URL.'/bbs/board.php?bo_table=' . $row['bo_table'] , 'document', $boardindex);
}
?>
