<?php
include_once('./_common.php');

if ($is_guest)
    alert(__(core_a651), G5_BBS_URL.'/login.php');

/*
if ($url)
    $urlencode = urlencode($url);
else
    $urlencode = urlencode($_SERVER[REQUEST_URI]);
*/

$g5['title'] = __(theme_t781);
include_once('./_head.sub.php');

$url = clean_xss_tags($_GET['url']);

// url 체크
check_url_host($url);

$url = get_text($url);

include_once($member_skin_path.'/member_confirm.skin.php');

include_once('./_tail.sub.php');
?>
