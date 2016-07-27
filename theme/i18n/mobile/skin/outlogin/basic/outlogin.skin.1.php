<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<aside id="ol_before" class="ol">
    <h2><?php echo __(theme_t1440); ?></h2>
    <!-- 로그인 전 외부로그인 시작 -->
    <form name="foutlogin" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
    <fieldset>
        <input type="hidden" name="url" value="<?php echo $outlogin_url ?>">
        <input type="text" name="mb_id" id="ol_id" placeholder="<?php echo __(theme_t678); ?>(<?php echo __(theme_t421); ?>)" required class="required" maxlength="20">
        <input type="password" id="ol_pw" name="mb_password" placeholder="<?php echo __(theme_t471); ?>(<?php echo __(theme_t421); ?>)" required class="required" maxlength="20">
        <input type="submit" id="ol_submit" value="<?php echo __(theme_t617); ?>">
        <div id="ol_svc">
            <input type="checkbox" id="auto_login" name="auto_login" value="1">
            <label for="auto_login" id="auto_login_label"><?php echo __(theme_t771); ?></label>
            <a href="<?php echo G5_BBS_URL ?>/register.php"><b><?php echo __(theme_t616); ?></b></a>
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" id="ol_password_lost"><?php echo __(theme_t770); ?></a>
        </div>
    </fieldset>
    </form>
</aside>

<script>
<?php if (!G5_IS_MOBILE) { ?>
$omi = $('#ol_id');
$omp = $('#ol_pw');
$omp.css('display','inline-block').css('width',104);
$omi_label = $('#ol_idlabel');
$omi_label.addClass('ol_idlabel');
$omp_label = $('#ol_pwlabel');
$omp_label.addClass('ol_pwlabel');
$omi.focus(function() {
    $omi_label.css('visibility','hidden');
});
$omp.focus(function() {
    $omp_label.css('visibility','hidden');
});
$omi.blur(function() {
    $this = $(this);
    if($this.attr('id') == "ol_id" && $this.attr('value') == "") $omi_label.css('visibility','visible');
});
$omp.blur(function() {
    $this = $(this);
    if($this.attr('id') == "ol_pw" && $this.attr('value') == "") $omp_label.css('visibility','visible');
});
<?php } ?>

$("#auto_login").click(function(){
    if (this.checked) {
        this.checked = confirm(__('theme.t780'));
    }
});

function fhead_submit(f)
{
    return true;
}
</script>
<!-- 로그인 전 외부로그인 끝 -->
