<?php
include_once('./_common.php');

if (!$member['mb_id'])
    alert_close(__(core_a49));

if (!$member['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id)
    alert_close(__(core_a105));

$mb = get_member($mb_id);
if (!$mb['mb_id'])
    alert_close(__(core_a55));

if (!$mb['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id)
    alert_close(__(core_a56));

$g5['title'] = $mb['mb_nick'].' ' . __(theme_t849);
include_once(G5_PATH.'/head.sub.php');

$mb_nick = get_sideview($mb['mb_id'], get_text($mb['mb_nick']), $mb['mb_email'], $mb['mb_homepage'], $mb['mb_open']);

// 회원가입후 몇일째인지? + 1 은 당일을 포함한다는 뜻
$sql = " select (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS('{$mb['mb_datetime']}') + 1) as days ";
$row = sql_fetch($sql);
$mb_reg_after = $row['days'];

$mb_homepage = set_http(get_text(clean_xss_tags($mb['mb_homepage'])));
$mb_profile = $mb['mb_profile'] ? conv_content($mb['mb_profile'],0) : __(theme_t1412);

include_once($member_skin_path.'/profile.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>
