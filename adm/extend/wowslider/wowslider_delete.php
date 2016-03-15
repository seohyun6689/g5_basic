<?php
$sub_menu = '700400';
include_once('./_common.php');

auth_check($auth[$sub_menu], "d");

$sql = "select * from `{$g5['ws_master_table']}` where ws_id = '{$ws_id}'";
$data = sql_fetch( $sql );

if ( !$data )
{
	alert( "슬라이드가 삭제되었거나 존재하지 않습니다." );
}

$sql = "delete from `{$g5['ws_master_table']}` where ws_id = '{$ws_id}'";
$result = sql_query( $sql );
if ( $result )
{
	$sql = "select * from `{$g5['ws_images_table']}` where ws_id = '{$ws_id}'";
	$result = sql_query( $sql );
	while ( $row = sql_fetch_array( $result ) )
	{
		$sql = "delete from `{$g5['ws_images_table']}` where wsi_id = '{$row['wsi_id']}'";
		sql_query( $sql );
	}
	
	@removeDir( G5_WS_DATA_PATH . '/' . $ws_id );
	
	alert("선택하신 슬라이드가 삭제되었습니다.\r\n해당 슬라이드는 사용 할 수 없어 오류가 날 수 있습니다.");
}
else
{
	alert( "오류가 발생하여 삭제가 진해되지 않았습니다.\r\n관리자 또는 제작업체에 문의해 주시기 바랍니다." );
}

?>
