<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="mb_login" class="mbskin">
    <h1><?php echo $g5['title'] ?></h1>

    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">

    <div id="login_frm">
        <label for="login_id" class="sound_only"><?php echo __(theme_t833); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label>
        <input type="text" name="mb_id" id="login_id" placeholder="<?php echo __(theme_t833).'(' . __(theme_t421) . ')'; ?>" required class="frm_input required" maxLength="20">
        <label for="login_pw" class="sound_only"><?php echo __(theme_t471); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label>
        <input type="password" name="mb_password" id="login_pw" placeholder="<?php echo __(theme_t471).'(' . __(theme_t421) . ')'; ?>" required class="frm_input required" maxLength="20">
        <input type="submit" value="<?php echo __(theme_t617); ?>" class="btn_submit">
        <div>
            <input type="checkbox" name="auto_login" id="login_auto_login">
            <label for="login_auto_login"><?php echo __(theme_t771); ?></label>
        </div>
    </div>

    <section>
        <h2><?php echo __(theme_t1441); ?></h2>
        <p>
            <?php echo __(theme_t1442); ?>
        </p>
        <div>
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost" class="btn02"><?php echo __(theme_t770); ?></a>
            <a href="./register.php" class="btn01"><?php echo __(theme_t616); ?></a>
        </div>
    </section>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>/"><?php echo __(theme_t779); ?></a>
    </div>

    </form>

</div>

<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm(__('theme.t780'));
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
