<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if (!$config['cf_email_use'])
    alert_close(_(core_a48));

if (!$is_member && $config['cf_formmail_is_member'])
    alert_close(_(core_a49));

if ($is_member && !$member['mb_open'] && $is_admin != "super" && $member['mb_id'] != $mb_id)
    alert_close(_(core_a54));

if ($mb_id)
{
    $mb = get_member($mb_id);
    if (!$mb['mb_id'])
        alert_close(_(core_a55));

    if (!$mb['mb_open'] && $is_admin != "super")
        alert_close(_(core_a56));
}

$sendmail_count = (int)get_session('ss_sendmail_count') + 1;
if ($sendmail_count > 3)
    alert_close(_(core_a57));

$g5['title'] = _(theme_t766);
include_once(G5_PATH.'/head.sub.php');

$email = get_email_address(base64_decode($email));
if(!$email)
    alert_close(_(core_a650));

$email = base64_encode($email);

if (!$name)
    $name = base64_decode($email);
else
    $name = get_text(stripslashes($name), true);

if (!isset($type))
    $type = 0;

$type_checked[0] = $type_checked[1] = $type_checked[2] = "";
$type_checked[$type] = 'checked';

include_once($member_skin_path.'/formmail.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>
