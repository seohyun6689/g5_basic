<?php
include_once('./_common.php');
header('Content-Type: application/javascript');

// 캐시가 적용되게 하는 부분
header('Cache-Control: public, max-age=604800');
header('Expires: ');
header('Pragma: ');

$last_modified_time = filemtime(G5_LANG_PATH . '/' . $langs[0] . '.json');
$etag = md5_file(G5_LANG_PATH . '/' . $langs[0] . '.json');

// always send headers
header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT");
header("Etag: $etag");
// exit if not modified


if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
    @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {
    header("HTTP/1.1 304 Not Modified");
    exit;
}

// 본문
$langs = $i18n->getUserLangs();
$json = file_get_contents(G5_LANG_PATH . '/' . $langs[0] . '.json');
$sprintf_func = file_get_contents(G5_PATH . '/js/jquery.sprintf.js');
?>
<?php echo $sprintf_func; ?>
var lang = <?php echo $json; ?>;
function __(string, args) {
    var str = eval('lang.' + string);
    return jQuery.vsprintf(str, args);
}
