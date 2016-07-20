<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$g5['title'] = _(theme_t1414);
include_once('./_head.php');

$mb_id = substr(clean_xss_tags($_GET['mb_id']), 0, 20);
$sql = " select mb_email, mb_datetime, mb_ip, mb_email_certify from {$g5['member_table']} where mb_id = '{$mb_id}' ";
$mb = sql_fetch($sql);
if (substr($mb['mb_email_certify'],0,1)!=0) {
    alert(_(core_a122), G5_URL);
}

$ckey = trim($_GET['ckey']);
$key  = md5($mb['mb_ip'].$mb['mb_datetime']);

if(!$ckey || $ckey != $key)
    alert(_(core_a120), G5_URL);
?>

<p class="rg_em_p"><?php echo _(theme_t830); ?></p>

<form method="post" name="fregister_email" action="<?php echo G5_HTTPS_BBS_URL.'/register_email_update.php'; ?>" onsubmit="return fregister_email_submit(this);">
<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">

<div class="tbl_frm01 tbl_frm rg_em">
    <table>
    <caption><?php echo _(core_t832); ?></caption>
    <tr>
        <th scope="row"><label for="reg_mb_email">E-mail<strong class="sound_only"><?php echo _(theme_t421); ?></strong></label></th>
        <td><input type="text" name="mb_email" id="reg_mb_email" required class="frm_input email required" size="30" maxlength="100" value="<?php echo $mb['mb_email']; ?>"></td>
    </tr>
    <tr>
        <th scope="row"><?php echo _(theme_t700); ?></th>
        <td><?php echo captcha_html(); ?></td>
    </tr>
    </table>
</div>

<div class="btn_confirm">
    <input type="submit" id="btn_submit" class="btn_submit" value="<?php echo _(theme_t1209); ?>">
    <a href="<?php echo G5_URL ?>" class="btn_cancel">취소</a>
</div>

</form>

<script>
function fregister_email_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<?php
include_once('./_tail.php');
?>
