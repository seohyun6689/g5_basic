<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_guest)
    alert_close(_(core_a49));

if (!$member['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id)
    alert_close(_(core_a85));

$content = "";
// 탈퇴한 회원에게 쪽지 보낼 수 없음
if ($me_recv_mb_id)
{
    $mb = get_member($me_recv_mb_id);
    if (!$mb['mb_id'])
        alert_close(_(core_a86));

    if (!$mb['mb_open'] && $is_admin != 'super')
        alert_close(_(core_a56));

    // 4.00.15
    $row = sql_fetch(" select me_memo from {$g5['memo_table']} where me_id = '{$me_id}' and (me_recv_mb_id = '{$member['mb_id']}' or me_send_mb_id = '{$member['mb_id']}') ");
    if ($row['me_memo'])
    {
        $content = "\n\n\n".' >'
                         ."\n".' >'
                         ."\n".' >'.str_replace("\n", "\n> ", get_text($row['me_memo'], 0))
                         ."\n".' >'
                         .' >';

    }
}

$g5['title'] = _(theme_t786);
include_once(G5_PATH.'/head.sub.php');

$memo_action_url = G5_HTTPS_BBS_URL."/memo_form_update.php";
include_once($member_skin_path.'/memo_form.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>
