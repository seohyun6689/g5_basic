<?php
include_once('./_common.php');
function error_print($msg)
{
    if (count($msg) > 0) {
        echo json_encode($msg);
        exit;
    }
}
$value = array();
$theme_path = G5_PATH . '/' . G5_THEME_DIR;
$theme = (isset($_POST['theme']) && trim($_POST['theme']) != '' ? $_POST['theme'] : null);
if (is_null($theme)) {
    error_print(array('error'=>'설치할 테마를 선택하지 않으셨습니다.'));
}

if (file_exists($theme_path . '/' . $theme) && is_dir($theme_path . '/' . $theme)) {
    error_print(array('error'=>'테마 디렉토리에 같은 테마명이 존재합니다.'));
}

$remote_theme_content = seohyun_theme_items('http://api.seohyunco.com/theme/items/id/' . $theme);
$remote_theme = json_decode($remote_theme_content);
$master_path = G5_DATA_PATH . '/master.tar.gz';
$cmd = 'curl -Lko ' . $master_path . ' ' . $remote_theme->download;
shell_exec($cmd);

$tmp_path = G5_DATA_PATH . '/tmp';
@mkdir($tmp_path);
$cmd = 'tar xzf ' . $master_path . ' -C ' . $tmp_path . ' 2>&1 ';
shell_exec($cmd);

$list = glob($tmp_path . '/theme-*-master');
foreach ($list as $tmp_theme) {
    @rename($tmp_theme, $theme_path . '/' . $theme);
}

@unlink($master_path);

if (file_exists($theme_path . '/' . $theme . '/install.php')) {
    @include_once($theme_path . '/' . $theme . '/install.php');
}
die(json_encode(array('success' => '"' . $theme . '" 테마설치를 완료하였습니다.')));
?>
