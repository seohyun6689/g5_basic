<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);
set_session("ss_cert_no",   "");
set_session("ss_cert_hash", "");
set_session("ss_cert_type", "");

if ($w == "") {

    // 회원 로그인을 한 경우 회원가입 할 수 없다
    // 경고창이 뜨는것을 막기위해 아래의 코드로 대체
    // alert("이미 로그인중이므로 회원 가입 하실 수 없습니다.", "./");
    if ($is_member) {
        goto_url(G5_URL);
    }

    // 리퍼러 체크
    referer_check();

    if (!isset($_POST['agree']) || !$_POST['agree']) {
        alert(_(core_a135), G5_BBS_URL.'/register.php');
    }

    if (!isset($_POST['agree2']) || !$_POST['agree2']) {
        alert(_(core_a136), G5_BBS_URL.'/register.php');
    }

    $agree  = preg_replace('#[^0-9]#', '', $_POST['agree']);
    $agree2 = preg_replace('#[^0-9]#', '', $_POST['agree2']);

    $member['mb_birth'] = '';
    $member['mb_sex']   = '';
    $member['mb_name']  = '';
    if (isset($_POST['birth'])) {
        $member['mb_birth'] = $_POST['birth'];
    }
    if (isset($_POST['sex'])) {
        $member['mb_sex']   = $_POST['sex'];
    }
    if (isset($_POST['mb_name'])) {
        $member['mb_name']  = $_POST['mb_name'];
    }

    $g5['title'] = _(theme_t616);

} else if ($w == 'u') {

    if ($is_admin)
        alert(_(core_a137), G5_URL);

    if (!$is_member)
        alert(_(core_a138), G5_URL);

    if ($member['mb_id'] != $_POST['mb_id'])
        alert(_(core_a139));

    /*
    if (!($member[mb_password] == sql_password($_POST[mb_password]) && $_POST[mb_password]))
        alert("비밀번호가 틀립니다.");

    // 수정 후 다시 이 폼으로 돌아오기 위해 임시로 저장해 놓음
    set_session("ss_tmp_password", $_POST[mb_password]);
    */

    if ($_POST['mb_password']) {
        // 수정된 정보를 업데이트후 되돌아 온것이라면 비밀번호가 암호화 된채로 넘어온것임
        if ($_POST['is_update'])
            $tmp_password = $_POST['mb_password'];
        else
            $tmp_password = get_encrypt_string($_POST['mb_password']);

        if ($member['mb_password'] != $tmp_password)
            alert('비밀번호가 틀립니다.');
    }

    $g5['title'] = _(theme_t434);

    set_session("ss_reg_mb_name", $member['mb_name']);
    set_session("ss_reg_mb_hp", $member['mb_hp']);

    $member['mb_email']       = get_text($member['mb_email']);
    $member['mb_homepage']    = get_text($member['mb_homepage']);
    $member['mb_birth']       = get_text($member['mb_birth']);
    $member['mb_tel']         = get_text($member['mb_tel']);
    $member['mb_hp']          = get_text($member['mb_hp']);
    $member['mb_addr1']       = get_text($member['mb_addr1']);
    $member['mb_addr2']       = get_text($member['mb_addr2']);
    $member['mb_signature']   = get_text($member['mb_signature']);
    $member['mb_recommend']   = get_text($member['mb_recommend']);
    $member['mb_profile']     = get_text($member['mb_profile']);
    $member['mb_1']           = get_text($member['mb_1']);
    $member['mb_2']           = get_text($member['mb_2']);
    $member['mb_3']           = get_text($member['mb_3']);
    $member['mb_4']           = get_text($member['mb_4']);
    $member['mb_5']           = get_text($member['mb_5']);
    $member['mb_6']           = get_text($member['mb_6']);
    $member['mb_7']           = get_text($member['mb_7']);
    $member['mb_8']           = get_text($member['mb_8']);
    $member['mb_9']           = get_text($member['mb_9']);
    $member['mb_10']          = get_text($member['mb_10']);
} else {
    alert('w ' . _(core_a59));
}

include_once('./_head.php');

// 회원아이콘 경로
$mb_icon_path = G5_DATA_PATH.'/member/'.substr($member['mb_id'],0,2).'/'.$member['mb_id'].'.gif';
$mb_icon_url  = G5_DATA_URL.'/member/'.substr($member['mb_id'],0,2).'/'.$member['mb_id'].'.gif';

$register_action_url = G5_HTTPS_BBS_URL.'/register_form_update.php';
$req_nick = !isset($member['mb_nick_date']) || (isset($member['mb_nick_date']) && $member['mb_nick_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400)));
$required = ($w=='') ? 'required' : '';
$readonly = ($w=='u') ? 'readonly' : '';

$agree  = preg_replace('#[^0-9]#', '', $agree);
$agree2 = preg_replace('#[^0-9]#', '', $agree2);

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
if ($config['cf_use_addr'])
    add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

include_once($member_skin_path.'/register_form.skin.php');
include_once('./_tail.php');
?>
