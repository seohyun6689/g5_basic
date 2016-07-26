<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<!-- 로그인 전 아웃로그인 시작 { -->
<section id="ol_before" class="ol">
    <h2><?php echo __(theme_t1440); ?></h2>
    <form name="foutlogin" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
    <fieldset>
        <input type="hidden" name="url" value="<?php echo $outlogin_url ?>">
        <label for="ol_id" id="ol_idlabel"><?php echo __(theme_t678); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label>
        <input type="text" id="ol_id" name="mb_id" required class="required" maxlength="20">
        <label for="ol_pw" id="ol_pwlabel"><?php echo __(theme_t471); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label>
        <input type="password" name="mb_password" id="ol_pw" required class="required" maxlength="20">
        <input type="submit" id="ol_submit" value="<?php echo __(theme_t617); ?>">
        <div id="ol_svc">
            <a href="<?php echo G5_BBS_URL ?>/register.php"><b><?php echo __(theme_t616); ?></b></a>
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" id="ol_password_lost"><?php echo __(theme_t770); ?></a>
        </div>
        <div id="ol_auto">
            <input type="checkbox" name="auto_login" value="1" id="auto_login">
            <label for="auto_login" id="auto_login_label"><?php echo __(theme_t771); ?></label>
        </div>
    </fieldset>
    </form>
</section>

<script>
$omi = $('#ol_id');
$omp = $('#ol_pw');
$omp.css('display','inline-block').css('width',104);
$omi_label = $('#ol_idlabel');
$omi_label.addClass('ol_idlabel');
$omp_label = $('#ol_pwlabel');
$omp_label.addClass('ol_pwlabel');

$(function() {
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

    $("#auto_login").click(function(){
        if ($(this).is(":checked")) {
            if(!confirm(__('theme.t780')))
                return false;
        }
    });
});

function fhead_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 전 아웃로그인 끝 -->
