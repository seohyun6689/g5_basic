<?php
include_once('./_common.php');
header('Content-Type: application/javascript');
$langs = $i18n->getUserLangs();
$json = file_get_contents(G5_LANG_PATH . '/' . $langs[0] . '.json');
$sprintf_func = file_get_contents(G5_PATH . '/js/jquery.sprintf.js');
?>
<?php echo $sprintf_func; ?>
var lang = <?php echo $json; ?>;
function _(string, args) {
    var str = eval('lang.' + string);
    return jQuery.vsprintf(str, args);
}
