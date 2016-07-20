<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

if ($is_member) {
    alert(_(core_a93));
}

if (!chk_captcha()) {
    alert(_(core_a51));
}

$email = trim($_POST['mb_email']);

if (!$email)
    alert_close(_(core_a94));

$sql = " select count(*) as cnt from {$g5['member_table']} where mb_email = '$email' ";
$row = sql_fetch($sql);
if ($row['cnt'] > 1)
    alert(_(core_a95));

$sql = " select mb_no, mb_id, mb_name, mb_nick, mb_email, mb_datetime from {$g5['member_table']} where mb_email = '$email' ";
$mb = sql_fetch($sql);
if (!$mb['mb_id'])
    alert(_(core_a96));
else if (is_admin($mb['mb_id']))
    alert(_(core_a97));

// 임시비밀번호 발급
$change_password = rand(100000, 999999);
$mb_lost_certify = get_encrypt_string($change_password);

// 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
$mb_nonce = md5(pack('V*', rand(), rand(), rand(), rand()));

// 임시비밀번호와 난수를 mb_lost_certify 필드에 저장
$sql = " update {$g5['member_table']} set mb_lost_certify = '$mb_nonce $mb_lost_certify' where mb_id = '{$mb['mb_id']}' ";
sql_query($sql);

// 인증 링크 생성
$href = G5_BBS_URL.'/password_lost_certify.php?mb_no='.$mb['mb_no'].'&amp;mb_nonce='.$mb_nonce;

$subject = "[".$config['cf_title']."] " . _(theme_t1408);

$content = "";

$content .= '<div style="margin:30px auto;width:600px;border:10px solid #f7f7f7">';
$content .= '<div style="border:1px solid #dedede">';
$content .= '<h1 style="padding:30px 30px 0;background:#f7f7f7;color:#555;font-size:1.4em">';
$content .= _(theme_t805);
$content .= '</h1>';
$content .= '<span style="display:block;padding:10px 30px 30px;background:#f7f7f7;text-align:right">';
$content .= '<a href="'.G5_URL.'" target="_blank">'.$config['cf_title'].'</a>';
$content .= '</span>';
$content .= '<p style="margin:20px 0 0;padding:30px 30px 30px;border-bottom:1px solid #eee;line-height:1.7em">';
$content .= addslashes($mb['mb_name'])." (".addslashes($mb['mb_nick']).")"." " . _(theme_t1400, G5_TIME_YMDHIS) . "<br>";
$content .= _(theme_t1401) . '<br>';
$content .= _(theme_t1402) . ' <span style="color:#ff3061"><strong>' . _(theme_t1403) . '</strong> ' . _(theme_t1404) . '</span><br>';
$content .= _(theme_t1405) . '<br>';
$content .= _(theme_t1406);
$content .= '</p>';
$content .= '<p style="margin:0;padding:30px 30px 30px;border-bottom:1px solid #eee;line-height:1.7em">';
$content .= '<span style="display:inline-block;width:100px">' . _(theme_t678) . '</span> '.$mb['mb_id'].'<br>';
$content .= '<span style="display:inline-block;width:100px">' . _(theme_t1407) . '</span> <strong style="color:#ff3061">'.$change_password.'</strong>';
$content .= '</p>';
$content .= '<a href="'.$href.'" target="_blank" style="display:block;padding:30px 0;background:#484848;color:#fff;text-decoration:none;text-align:center">' . _(theme_t1403) . '</a>';
$content .= '</div>';
$content .= '</div>';

mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $mb['mb_email'], $subject, $content, 1);

alert_close($email. _(core_a98));
?>
