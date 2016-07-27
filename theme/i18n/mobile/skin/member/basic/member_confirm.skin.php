<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="mb_confirm" class="mbskin">
    <h1><?php echo $g5['title'] ?></h1>

    <p>
        <strong><?php echo __(theme_t782); ?></strong>
        <?php if ($url == 'member_leave.php') { ?>
        <?php echo __(theme_t783); ?>
        <?php }else{ ?>
        <?php echo __(theme_t784); ?>
        <?php }  ?>
    </p>

    <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
    <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
    <input type="hidden" name="w" value="u">

    <fieldset>
        <?php echo __(theme_t678); ?>
        <span id="mb_confirm_id"><?php echo $member['mb_id'] ?></span>
        <input type="password" name="mb_password" id="mb_confirm_pw" placeholder="<?php echo __(theme_t471) . '(' . __(theme_t421) . ')'; ?>'" required class="frm_input" size="15" maxLength="20">
        <input type="submit" value="<?php echo __(theme_t429); ?>" id="btn_submit" class="btn_submit">
    </fieldset>

    </form>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>"><?php echo __(theme_t779); ?></a>
    </div>

</div>

<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
