<?php
include_once('./_common.php');

if (!function_exists('deleteDirectory')) {
	function deleteDirectory($dir) {
	    if (!file_exists($dir)) {
	        return true;
	    }

	    if (!is_dir($dir)) {
	        return unlink($dir);
	    }

	    foreach (scandir($dir) as $item) {
	        if ($item == '.' || $item == '..') {
	            continue;
	        }

	        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
	            return false;
	        }

	    }

	    return rmdir($dir);
	}
}

$theme_path = G5_PATH . '/' . G5_THEME_DIR;
$theme = (isset($_POST['theme']) && trim($_POST['theme']) != '' ? $_POST['theme'] : '');
if (is_null($theme)) {
    die(json_encode(array('error' => '언인스톨할 테마가 존재하지 않습니다.')));
}
if (file_exists($theme_path . '/' . $theme . '/uninstall.php')) {
    @include_once($theme_path . '/' . $theme . '/uninstall.php');
    $result = deleteDirectory($theme_path . '/' . $theme);
    if ($result) {
	    die(json_encode(array('success' => '언인스톨 완료!!')));
    } else {
	    die(json_encode(array('success' => '언인스톨 실패!!')));
    }
} else {
	die(json_encode(array('error' => '언인스톨 파일이 존재하지 않습니다.')));
}
?>
