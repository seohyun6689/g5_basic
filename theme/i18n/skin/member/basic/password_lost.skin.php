<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 찾기 시작 { -->
<div id="find_info" class="new_win mbskin">
    <h1 id="win_title"><?php echo __(theme_t805); ?></h1>

    <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
    <fieldset id="info_fs">
        <p>
            <?php echo __(theme_t807); ?>
        </p>
        <label for="mb_email"><?php echo __(theme_t808); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label>
        <input type="text" name="mb_email" id="mb_email" required class="required frm_input email" size="30">
    </fieldset>
    <?php echo captcha_html();  ?>
    <div class="win_btn">
        <input type="submit" value="<?php echo __(theme_t429); ?>" class="btn_submit">
        <button type="button" onclick="window.close();"><?php echo __(theme_t425); ?></button>
    </div>
    </form>
</div>

<script>
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->
