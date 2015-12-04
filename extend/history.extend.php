<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
//  회사연혁 상수 모음 시작
//------------------------------------------------------------------------------

define( 'G5_HISTORY_ADMIN_DIR', 'history' );
define( 'G5_HISTORY_ADMIN_PATH', G5_ADMIN_PATH . '/extend/' . G5_HISTORY_ADMIN_DIR );
define( 'G5_HISTORY_ADMIN_URL', G5_ADMIN_URL . '/extend/' . G5_HISTORY_ADMIN_DIR );

$g5['history_master_table'] = 'history_master';
$g5['history_item_table'] = 'history_item';
$g5['history_group_table'] = 'history_group';


$master_sql = "CREATE TABLE IF NOT EXISTS `" . $g5['history_master_table'] . "` (
				`his_id` varchar(20) not null default '',
				`his_subject` varchar(200) not null default '',
				`his_start_year` int(11) not null default 0,
				`his_end_year` int(11) not null default 0,
				`his_output_type` char(1) not null default 0,
				`his_sort` varchar(20) not null default 'asc',
				`his_use_group` char(1) not null default '',
				`his_skin` varchar(255) not null default '',
				`his_mobile_skin` varchar(255) not null default '',
				`his_created` datetime not null default 0,
				primary key (`his_id`) )";
sql_query($master_sql);
$item_sql = "CREATE TABLE IF NOT EXiSTS `" . $g5['history_item_table'] . "` (
			`his_item_id` int(11) not null auto_increment,
			`his_id` varchar(20) not null default '',
			`his_group_id` int(11) not null default 0,
			`his_item_year` char(4) not null default '',
			`his_item_month` char(2) not null default '',
			`his_item_day` char(2) not null default '',
			`his_item_date` varchar(255) not null default '',
			`his_item_content` varchar(255) not null default '',
			`his_item_note` text not null default '',
			`his_item_disable` char(1) not null default '',
			primary key (`his_item_id`)
		)";
sql_query($item_sql);
$group_sql = "CREATE TABLE IF NOT EXiSTS `" . $g5['history_group_table'] . "` (
			`his_group_id` int(11) not null auto_increment,
			`his_id` varchar(20) not null default '',
			`his_group_subject` varchar(255) not null default '',
			`his_group_sort` int(11) not null default 0,
			primary key (`his_group_id`)
		)";
sql_query($group_sql);


/**
*
* 연혁 출력
*
* @param string $his_id
* @param string $skin_dir
* @return string $content
*/
function history($his_id, $skin_dir = '', $group = null) {
	global $g5;
	
	$sql = "select * from `{$g5['history_master_table']}` where his_id = '{$his_id}'";
	$history = sql_fetch($sql);
	
	if ( !$skin_dir ) {
		$skin_dir = $history['his_skin'];
	}
			
    $history_skin_path = get_skin_path( 'history', $skin_dir );
    $history_skin_url  = get_skin_url( 'history', $skin_dir );


	$sortable = "order by his_item_year " . $history['his_sort'] . ', his_item_month ' . $history['his_sort'] . ', his_item_day ' . $history['his_sort'];
    
    $histories = array();
	$group_histories = array();
    
    for ( $i = $history['his_start_year'], $y = $history['his_end_year']; $i <= $history['his_end_year'], $y >= $history['his_start_year']; $i++, $y-- ) {

	    $history_item = array();
	    
	    $conditions = array("his_item_disable = ''", "his_id = '{$his_id}'");
	    if ( !is_null($group) ){
		    $conditions['group'] = "his_group_id = '{$group}'";
	    }
	    if ( $history['his_sort'] == 'asc') {
			$item_year = $i;
		} else {
			$item_year = $y;
		}
		$conditions[] = "his_item_year = '{$item_year}'";
		
		$condition = ( count($conditions) > 0 ) ? 'where ' . implode( ' and ', $conditions ) : '' ;
		
	    $sql = "select * from `{$g5['history_item_table']}` {$condition} {$sortable}";
	    $result = sql_query($sql);
	    while( $item = sql_fetch_array($result) ) {
		    switch($history['his_output_type']) {
			    case 'a' :
				    $item['date'] = $item['his_item_year'] . '.' . $item['his_item_month'] . '.' . $item['his_item_day'];
				    break;
			    case 'y' :
				    $item['date'] = '';
					break;
				case 'm' :
					$item['date'] = $item['his_item_month'];
					break;
				case 'd' : 
					$item['date'] = $item['his_item_month'] . '.' . $item['his_item_day'];
					break;
				case 'i' : 
					$item['date'] = $item['his_item_date'];
					break;
			}
			$history_item[] = $item;
			$all_history_item[] = $item;
	    }
	    
	    $histories[$item_year] = $history_item;
	}
    $histories = array_filter($histories);

	ob_start();
    include $history_skin_path.'/history.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}
