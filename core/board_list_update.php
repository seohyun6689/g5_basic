<?php
include_once('./_common.php');

$count = count($_POST['chk_wr_id']);

if(!$count) {
    alert(__(core_a4, $_POST['btn_submit']));
}

if($_POST['btn_submit'] == __(theme_t384)) {
    include './delete_all.php';
} else if($_POST['btn_submit'] == __(theme_t673)) {
    $sw = 'copy';
    include './move.php';
} else if($_POST['btn_submit'] == __(theme_t674)) {
    $sw = 'move';
    include './move.php';
} else {
    alert(__(core_a5));
}
?>
