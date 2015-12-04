<?php
include_once( G5_WS_TEMPLATE_PATH . '/backgnd/common.php' );
include_once( G5_WS_TEMPLATE_PATH . '/backgnd/' . $ws_template . '/config.php' );

$CssPath = sprintf(G5_WS_ENGINE_PATH, $ws_id ) . '/';
$JsPath = sprintf(G5_WS_ENGINE_PATH, $ws_id ) . '/';
$ImgPath = sprintf(G5_WS_ENGINE_PATH, $ws_id ) . '/';

removeDir( sprintf(G5_WS_ENGINE_PATH, $ws_id ), false );


function convert_resize( $filename, $source_path, $target_path, $thumb_width, $thumb_height )
{
	if(!$thumb_width && !$thumb_height)
        return;
      
    $source_file = "$source_path/$filename";
    if(!is_file($source_file)) // 원본 파일이 없다면
        return;
        
    $size = @getimagesize($source_file);
    if($size[2] < 1 || $size[2] > 3) // gif, jpg, png 에 대해서만 적용
        return;
    
    // 디렉토리가 존재하지 않거나 쓰기 권한이 없으면 썸네일 생성하지 않음
    if(!(is_dir($target_path) && is_writable($target_path)))
        return '';
        
	list($width, $height) = getimagesize($source_file);
	$new_width = $thumb_width;
	$new_height = $thumb_height;
	
	// Resample
	$image_p = imagecreatetruecolor($new_width, $new_height);
	
	imagealphablending($image_p, false);
	imagesavealpha($image_p,true);
	$transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
	imagecolortransparent($image_p,$transparent);
	imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);
	
	$image = imagecreatefrompng($source_file);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	// Output
	imagepng($image_p, $target_path . '/' . $filename, 9);
	imagedestroy($image_p);
	return true;
}

function content_filters( $content, $params )
{
	$keys = array_keys( (array)$params );
	$values = array_values( (array)$params );
	foreach( $keys as $index => $key )
	{
		$keys[$index] = '$' . $key . '$';
	}
	foreach ( $values as $index => $value )
	{
		if ( gettype($value) == boolean )
		{
			$value = ( $value ? 'true' : 'false' );
		}
		$values[$index] = $value;
	}

	return str_replace( $keys, $values, $content );
}
function replace_content( $src, $dest, $filters )
{
	global $params, $ImgPath;
	
	if ( isset($filters) && $filters['name'] == 'resize' )
	{
		if ( empty($dest) )
		{
			$dest = $ImgPath . basename($src);
		}
		
		$filename = basename($src);
		$source_path = dirname(dirname(__FILE__). '/templates/' . $src);
		$target_path = dirname($dest);
		
		$thumb_file = convert_resize( $filename, $source_path, $target_path, $filters['width'], $filters['height'] );
		debugout( $thumb_file );
	}
	else if ( $filters[0] == 'params' )
	{
		if ( is_file( G5_WS_ADMIN_PATH . '/templates/' . $src ) && file_exists(G5_WS_ADMIN_PATH . '/templates/' . $src) )
		{
			$content = file_get_contents( G5_WS_ADMIN_PATH . '/templates/' . $src);
			if ( !is_null($params) )
			{
				$content = content_filters( $content, $params );
			}
			$fp = fopen( $dest, 'a+');
			fwrite($fp, $content, strlen($content) ); 
			fclose($fp);
			chmod($dest, G5_FILE_PERMISSION);
		}
		else
		{
			return false;
		}
	}
	else
	{
		if ( empty($dest) )
		{
			$dest = $ImgPath . basename($src);
		}
		if ( is_file( G5_WS_ADMIN_PATH . '/templates/' . $src ) && file_exists(G5_WS_ADMIN_PATH . '/templates/' . $src) )
		{
			$content = file_get_contents( G5_WS_ADMIN_PATH . '/templates/' . $src);
			$fp = fopen( $dest, 'a+');
			fwrite($fp, $content, strlen($content) ); 
			fclose($fp);
			chmod($dest, G5_FILE_PERMISSION);
		}
		else
		{
			return false;
		}
	}
}

foreach ( $files as $file )
{
	$dest = str_replace( array('$CssPath$', '$JsPath$', '$ImgPath$'), array($CssPath, $JsPath, $ImgPath ), $file->dest );
	$content = replace_content( $file->src, $dest, $file->filters );
}

// debugout( 'exit', 1 );
?>