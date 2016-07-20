<?php
include_once('./_common.php');

if (!$member['mb_id'])
    alert(__(core_a78));

if ($is_admin == 'super')
    alert(__(core_a79));

if (!($_POST['mb_password'] && check_password($_POST['mb_password'], $member['mb_password'])))
    alert(__(core_a28));

// 회원탈퇴일을 저장
$date = date("Ymd");
$sql = " update {$g5['member_table']} set mb_leave_date = '{$date}' where mb_id = '{$member['mb_id']}' ";
sql_query($sql);

// 3.09 수정 (로그아웃)
unset($_SESSION['ss_mb_id']);

if (!$url)
    $url = G5_URL;

alert(__(core_a80, array($member['mb_nick'], date("Y"), date("m"), date("d") )), $url);
?>
