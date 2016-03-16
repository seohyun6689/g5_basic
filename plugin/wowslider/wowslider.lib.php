<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function wowslider( $ws_id, $style=null, $script=null)
{
	global $g5;
	@require_once( G5_LIB_PATH . '/thumbnail.lib.php' );
	
	$engine_url = sprintf( G5_WS_ENGINE_URL, $ws_id );
	$image_path = sprintf( G5_WS_IMAGES_PATH, $ws_id );
	$image_url = sprintf( G5_WS_IMAGES_URL, $ws_id );
	
	$sql = "select * from `{$g5['ws_master_table']}` where ws_id = '{$ws_id}'";
	$ws = sql_fetch( $sql );
	if ( !$ws )
	{
		echo( "<p>{$ws_id} 슬라이드가 존재하지 않습니다.</p>" );
		return false;
	}
	
	if ( isset($style) && trim($style) )
	{
		add_stylesheet( '<link rel="stylesheet" href="' . $style . '">', 0 );
	}
	else
	{
		add_stylesheet( '<link rel="stylesheet" href="' . sprintf( G5_WS_ENGINE_URL, $ws_id ) . '/style.css">', 0 );
	}
	
	$images_sql = "select * from `{$g5['ws_images_table']}` where ws_id = '{$ws['ws_id']}' and wsi_disable != 'Y' order by wsi_sortable asc";
	$result = sql_query( $images_sql );
	$images = array();
	$index = 0;
	while( $row = sql_fetch_array( $result ) )
	{	
		$image = '<img src="' . $image_url . '/' . $row['wsi_file'] . '" alt="' . $row['wsi_source'] . '" title="' . $row['wsi_title'] . '" id="' . $ws_id . '_' . $index . '"/>';
		
		if ( $row['wsi_link'] != '' ) {
			$image = '<a href="' . $row['wsi_link'] . '" target="' . ($row['wsi_link_target'] == 'Y' ? '_blank': '_self') . '">' . $image . '</a>';
		}
		
		$row['image'] = $image;
		$images[] = $row;
		$index++;
	}
	
	// 퀵버튼/썸네일 출력
	$ws_bullets = '';
	if ( $ws['ws_show_bullet'] == 'Y' )
	{
		removeDir( $image_path.'/tooltips', false );
		if ( $ws['ws_bullet_type'] == 'bullet' )
		{
			$ws_bullets .= '<div class="ws_bullets">' . PHP_EOL . '<div>';
			foreach ( $images as $index => $image )
			{
				$number = $index+1;
				
				if ( $ws['ws_bullet_thumb_prev'] ) 
				{
					$tooltip_thumb = thumbnail($image['wsi_file'], $image_path, $image_path.'/tooltips', $ws['ws_thumb_width'], $ws['ws_thumb_height'], false );

					$tooltip = '<img src="' . $image_url . '/tooltips/' . $tooltip_thumb . '" alt="image"/>';
				}
				$ws_bullets .= '<a href="' . $image_url . '/' . $image['wsi_file'] . '" title="image"><span>' . $tooltip . $number . '</span></a>' . PHP_EOL;
			}
			$ws_bullets .= '</div>' . PHP_EOL . '</div>';
		}	
		else if ( $ws['ws_bullet_type'] == 'filmstrip' )
		{
			$ws_bullets .= '<div class="ws_thumbs">' . PHP_EOL
					. '<div>';
			foreach ( $images as $index => $image )
			{
				$tooltip_thumb = thumbnail($image['wsi_file'], $image_path, $image_path.'/tooltips', $ws['ws_thumb_width'], $ws['ws_thumb_height'], false );
				$ws_bullets .=	'<a href="' . $image_url . '/' . $image['wsi_file'] . '" title="image"><img src="' . $image_url . '/tooltips/' . $tooltip_thumb . '" alt="" /></a>' . PHP_EOL;
			}
			$ws_bullets .= '</div>' . PHP_EOL . '</div>';
		}
	}
	
	if ( !$ws['ws_noframe'] )
	{
		$ws_shadow = '<div class="ws_shadow"></div>';
	}
	
	ob_start();
	include( G5_WS_PATH . '/template.html' );
	$content = ob_get_contents();
    ob_end_clean();
    
    return $content;
	
}

/*
* 2015.03.04 추가
* remove chlid all drectory
* 
* @param string $path
* @return boolean 	
*/ 
if ( !function_exists('removeDir') ) {
	function removeDir ($path, $is_rmdir = true )
	{
	    // 디렉토리 구분자를 하나로 통일시킴
	    $path = str_replace('\'', '/', $path);
	     
	    // 경로 마지막에 존재하는 디렉토리 구분자는 삭제
	    if ($path[(strlen($path)-1)] == '/') {
	        $tmp = '';
	        for ($i=0; $i < (strlen($path) -1); $i++) {
	            $tmp .= $path[$i];
	        }
	        $path = $tmp;
	    }
	     
	    // 존재하는 디렉토리인지 확인
	    // 존재하지 않으면 false를 반환
	    if (!file_exists($path)) {
	        return false;
	    }
	     
	    // 디렉토리 핸들러 생성
	    $oDir = dir($path);
	     
	    // 디렉토리 하부 컨텐츠 각각에 대하여 분석하여 삭제
	    while (($entry = $oDir->read())) {
	        // 상위 디렉토리를 나타내는 문자열인 경우 처리하지 않고 continue
	        if ($entry == '.' || $entry == '..') {
	            continue;
	        }
	         
	        // 또 다른 디렉토리인 경우 함수 실행
	        // 파일인 경우 즉시 삭제
	        if (is_dir($path.'/'.$entry)) {
	            removeDir($path.'/'.$entry);
	        } else {
	            unlink($path.'/'.$entry);
	        }
	    }
	     
	    // 해당 디렉토리 삭제
	    if ( $is_rmdir == true )
	    {
	    	rmdir($path);
	    }
	    
	     
	    // 결과에 따라 해당 디렉토리가 삭제되지 않고 존재하면 false를 반환 반대의 경우에는 true를 반환
	    if (file_exists($path)) {
	        return false;
	    } else {
	        return true;
	    }
	}
}
?>