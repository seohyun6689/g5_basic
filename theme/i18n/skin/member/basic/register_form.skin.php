<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->
<div class="mbskin">

    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js"></script>
    <?php } ?>

    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php }  ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo __(theme_t832); ?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="reg_mb_id"><?php echo __(theme_t833); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td>
                <span class="frm_info"><?php echo __(theme_t1445); ?></span>
                <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
                <span id="msg_mb_id"></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_password"><?php echo __(theme_t471); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td><input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input <?php echo $required ?>" minlength="3" maxlength="20"></td>
        </tr>
        <tr>
            <th scope="row"><label for="reg_mb_password_re"><?php echo __(theme_t809); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td><input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input <?php echo $required ?>" minlength="3" maxlength="20"></td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo __(theme_t835); ?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="reg_mb_name"><?php echo __(theme_t452); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td>
                <?php if ($config['cf_cert_use']) { ?>
                <span class="frm_info"><?php echo __(theme_t839); ?></span>
                <?php } ?>
                <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input <?php echo $required ?> <?php echo $readonly ?>" size="10">
                <?php
                if($config['cf_cert_use']) {
                    if($config['cf_cert_ipin'])
                        echo '<button type="button" id="win_ipin_cert" class="btn_frmline">' . __(theme_t836) . '</button>'.PHP_EOL;
                    if($config['cf_cert_hp'])
                        echo '<button type="button" id="win_hp_cert" class="btn_frmline">' . __(theme_t837) . '</button>'.PHP_EOL;

                    echo '<noscript>' . __(theme_t838) . '</noscript>'.PHP_EOL;
                }
                ?>
                <?php
                if ($config['cf_cert_use'] && $member['mb_certify']) {
                    if($member['mb_certify'] == 'ipin')
                        $mb_cert = __(theme_t840);
                    else
                        $mb_cert = __(theme_t504);
                ?>
                <div id="msg_certify">
                    <strong><?php echo $mb_cert; ?> <?php echo __(theme_t841); ?></strong><?php if ($member['mb_adult']) { ?> <?php echo __(theme_t842); ?><?php } ?> 완료
                </div>
                <?php } ?>
            </td>
        </tr>
        <?php if ($req_nick) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_nick"><?php echo __(theme_t843); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td>
                <span class="frm_info">
                    <?php echo __(theme_t844, (int)$config['cf_nick_modify']); ?>
                </span>
                <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input required nospace" size="10" maxlength="20">
                <span id="msg_mb_nick"></span>
            </td>
        </tr>
        <?php }  ?>

        <tr>
            <th scope="row"><label for="reg_mb_email">E-mail<strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td>
                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo __(theme_t845); }  ?>
                    <?php if ($w=='u') { echo __(theme_t846); }  ?>
                </span>
                <?php }  ?>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email required" size="70" maxlength="100">
            </td>
        </tr>

        <?php if ($config['cf_use_homepage']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_homepage"><?php echo __(theme_t723); ?><?php if ($config['cf_req_homepage']){ ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong><?php } ?></label></th>
            <td><input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="frm_input <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255"></td>
        </tr>
        <?php }  ?>

        <?php if ($config['cf_use_tel']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_tel"><?php echo __(theme_t453); ?><?php if ($config['cf_req_tel']) { ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong><?php } ?></label></th>
            <td><input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="frm_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20"></td>
        </tr>
        <?php }  ?>

        <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_hp"><?php echo __(theme_t426); ?><?php if ($config['cf_req_hp']) { ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong><?php } ?></label></th>
            <td>
                <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20">
                <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                <?php } ?>
            </td>
        </tr>
        <?php }  ?>

        <?php if ($config['cf_use_addr']) { ?>
        <tr>
            <th scope="row">
                <?php echo __(theme_t441); ?>
                <?php if ($config['cf_req_addr']) { ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong><?php }  ?>
            </th>
            <td>
                <label for="reg_mb_zip" class="sound_only"><?php echo __(theme_t1446); ?><?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
                <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6">
                <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');"><?php echo __(theme_t476); ?></button><br>
                <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50">
                <label for="reg_mb_addr1"><?php echo __(theme_t477); ?><?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label><br>
                <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address" size="50">
                <label for="reg_mb_addr2"><?php echo __(theme_t478); ?></label>
                <br>
                <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address" size="50" readonly="readonly">
                <label for="reg_mb_addr3"><?php echo __(theme_t479); ?></label>
                <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
            </td>
        </tr>
        <?php }  ?>
        </tbody>
        </table>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo __(theme_t847); ?></caption>
        <tbody>
        <?php if ($config['cf_use_signature']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_signature"><?php echo __(theme_t848); ?><?php if ($config['cf_req_signature']){ ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong><?php } ?></label></th>
            <td><textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?>"><?php echo $member['mb_signature'] ?></textarea></td>
        </tr>
        <?php }  ?>

        <?php if ($config['cf_use_profile']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_profile"><?php echo __(theme_t849); ?></label></th>
            <td><textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?>"><?php echo $member['mb_profile'] ?></textarea></td>
        </tr>
        <?php }  ?>

        <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_icon"><?php echo __(theme_t1447); ?></label></th>
            <td>
                <span class="frm_info">
                    <?php echo __(theme_t1448, array($config['cf_member_icon_width'], $config['cf_member_icon_height'], number_format($config['cf_member_icon_size']))); ?>
                </span>
                <input type="file" name="mb_icon" id="reg_mb_icon" class="frm_input">
                <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
                <img src="<?php echo $mb_icon_url ?>" alt="<?php echo __(theme_t1447); ?>">
                <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon">
                <label for="del_mb_icon"><?php echo __(theme_t391); ?></label>
                <?php }  ?>
            </td>
        </tr>
        <?php }  ?>

        <tr>
            <th scope="row"><label for="reg_mb_mailling"><?php echo __(theme_t850); ?></label></th>
            <td>
                <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>>
                <?php echo __(theme_t851);?>
            </td>
        </tr>

        <?php if ($config['cf_use_hp']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_sms"><?php echo __(theme_t852); ?></label></th>
            <td>
                <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?>>
                <?php echo __(theme_t853); ?>
            </td>
        </tr>
        <?php }  ?>

        <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능  ?>
        <tr>
            <th scope="row"><label for="reg_mb_open"><?php echo __(theme_t854); ?></label></th>
            <td>
                <span class="frm_info">
                    <?php echo __(theme_t856, (int)$config['cf_open_modify']); ?>
                </span>
                <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
                <input type="checkbox" name="mb_open" value="1" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> id="reg_mb_open">
                <?php echo __(theme_t855); ?>
            </td>
        </tr>
        <?php } else {  ?>
        <tr>
            <th scope="row"><?php echo __(theme_t854); ?></th>
            <td>
                <span class="frm_info">
                    <?php echo __(theme_t857, array((int)$config['cf_open_modify'], date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400))); ?>
                </span>
                <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
            </td>
        </tr>
        <?php }  ?>

        <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
        <tr>
            <th scope="row"><label for="reg_mb_recommend"><?php echo __(theme_t858); ?></label></th>
            <td><input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input"></td>
        </tr>
        <?php }  ?>

        <tr>
            <th scope="row"><?php echo __(theme_t700); ?></th>
            <td><?php echo captcha_html(); ?></td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="<?php echo $w==''?__(theme_t616):__(theme_t614); ?>" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="<?php echo G5_URL ?>" class="btn_cancel"><?php echo __(theme_t513); ?></a>
    </div>
    </form>

    <script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("' . __(theme_t860) . '");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>
    });

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert(__('theme.t862'));
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert(__('theme.t863'));
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert(__('theme.t862'));
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=="") {
            if (f.mb_name.value.length < 1) {
                alert(__('theme.t864'));
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert(__('theme.a130'));
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
                    alert(__('theme.t867'));
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert(__('core.a132'));
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

</div>
<!-- } 회원정보 입력/수정 끝 -->
