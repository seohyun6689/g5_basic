<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

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

/*
* 슬라이더 실행 함수
*/
function images($id, $skin = 'basic')
{
	global $g5, $config;
	@require_once( G5_LIB_PATH . '/thumbnail.lib.php' );
	
	$image_path = sprintf( G5_IMAGES_ITEMS_PATH, $id );
	$image_url = sprintf( G5_IMAGES_ITEMS_URL, $id );

	$sql = "select * from `{$g5['images_master_table']}` where img_id = '{$id}'";
	$row = sql_fetch( $sql );
	if ( !$row )
	{
		echo( "<p>{$id} 슬라이드가 존재하지 않습니다.</p>" );
		return false;
	}

	$images_sql = "select * from `{$g5['images_items_table']}` where img_id = '{$row['img_id']}' and img_item_disable != 'Y' order by img_item_sortable asc";
	$result = sql_query( $images_sql );
	$images = array();
	$index = 0;
	while( $row = sql_fetch_array( $result ) )
	{
		$image = '<img src="' . $image_url . '/' . $row['img_item_file'] . '" alt="' . $row['img_item_source'] . '" title="' . $row['img_item_title'] . '" id="' . $id . '_' . $index . '"/>';

		if ( $row['img_item_link'] != '' ) {
			$image = '<a href="' . $row['img_item_link'] . '" target="' . ($row['img_item_link_target'] == 'Y' ? '_blank': '_self') . '">' . $image . '</a>';
		}

		$row['image'] = $image;
		$images[] = $row;
		$index++;
	}
	if ( !empty($skin) && file_exists(G5_IMAGES_PATH . '/skin/' . $skin) && is_dir(G5_IMAGES_PATH . '/skin/' . $skin)) {
		define(G5_IMAGES_SKIN_PATH, G5_IMAGES_PATH . '/skin/' . $skin);
		define(G5_IMAGES_SKIN_URL, G5_IMAGES_URL . '/skin/' . $skin);

		if (file_exists(G5_IMAGES_SKIN_PATH . '/images.skin.php') && is_file(G5_IMAGES_SKIN_PATH . '/images.skin.php')) {
			include_once(G5_IMAGES_SKIN_PATH . '/images.skin.php');
		} else {
			echo( "<p>스킨 폴더가 존재하지 않습니다.</p>" );
			return false;
		}
	} else {
		echo( "<p>스킨 폴더가 존재하지 않습니다.</p>" );
		return false;
	}
}
