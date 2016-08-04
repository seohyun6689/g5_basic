<?php
include_once('./_common.php');
if ($is_admin) {
    // alert('언어가 변경되었습니다.', $_GET['url']);
    header("Location:" . $_GET['url']);
} else {
    header("Location:" . $_GET['url']);
}
?>
