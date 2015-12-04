<?php
$sub_menu = '700400';
include_once('./_common.php');
if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
$upload_files = array();
if ( isset($_FILES) && count($_FILES) )
{
	foreach( $_FILES as $upload )
	{
		$filename = $upload['name'];
		$filetype = $upload['type'];
		$tmp_file = $upload['tmp_name'];
		$filesize = $upload['size'];
		if (is_uploaded_file($tmp_file)) 
		{
			if ( $filesize > 1024*1024*10 )
			{
				$msg[] = '\"'.$filename.'\" 파일의 용량('.number_format($filesize).' 바이트)이  10Mb 보다 크므로 업로드 하지 않습니다.\\n';
			}
			
			shuffle($chars_array);
			$shuffle = implode('', $chars_array);
			
			$upload['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));
			
			$dest_file = sprintf( G5_WS_IMAGES_PATH , $ws_id ) . '/' . $upload['file'];
			// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
	        $error_code = move_uploaded_file($tmp_file, $dest_file) or die($upload['error']);
			
	        // 올라간 파일의 퍼미션을 변경합니다.
	        chmod($dest_file, G5_FILE_PERMISSION);
	        
	        $upload_files[] = $upload;
		}
	}
}


if ( count( $msg ) )
{
	echo implode( PHP_EOL, $msg );
	exit();
}

$sql_common = "
	wsi_title = '{$wsi_title}',
	wsi_link = '{$wsi_link}',
	wsi_link_target = '{$wsi_link_target}',
	wsi_disable = '{$wsi_disable}'
";
if ( count( $upload_files ) > 0 )
{
	
	$sql_common .= ", wsi_file = '{$upload_files[0]['file']}'" . PHP_EOL;
	$sql_common .= ", wsi_source = '{$upload_files[0]['name']}'" . PHP_EOL;
}

if ( $w == '' && $wsi_id == '' )
{
	$sql_common .= ", ws_id = '{$ws_id}'";
	$sql = "insert {$g5['ws_images_table']} set {$sql_common}";
	$result = sql_query( $sql );
	if ( !$result )
	{
		die( mysql_error() );
	}
}
else
{
	$sql = "update {$g5['ws_images_table']} set {$sql_common} where wsi_id = '{$wsi_id}'";
	$result = sql_query( $sql );
	if ( !$result )
	{
		die( mysql_error() );
	}

	// debugout( $sql ,1 );
}
?>