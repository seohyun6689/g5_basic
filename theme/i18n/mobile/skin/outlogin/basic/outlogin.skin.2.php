<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<!-- 로그인 후 외부로그인 시작 -->
<aside id="ol_after" class="ol">
    <header id="ol_after_hd">
        <h2><?php echo __(theme_t1457); ?></h2>
        <strong><?php echo $nick ?></strong>
        <?php if ($is_admin == 'super' || $is_auth) { ?><a href="<?php echo G5_ADMIN_URL ?>" class="btn_admin"><?php echo __(theme_t1458); ?></a><?php } ?>
    </header>
    <ul id="ol_after_private">
        <li id="ol_after_memo">
            <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank">
                <?php echo __(theme_t646); ?>
                <strong><?php echo $memo_not_read ?></strong>
            </a>
        </li>
        <li id="ol_after_pt">
            <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank">
                <?php echo __(theme_t371); ?>
                <strong><?php echo $point ?></strong>
            </a>
        </li>
        <li id="ol_after_scrap">
            <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank"><?php echo __(theme_t720); ?></a>
        </li>
    </ul>
    <footer id="ol_after_ft">
        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info"><?php echo __(theme_t614); ?></a>
        <a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout"><?php echo __(theme_t615); ?></a>
    </footer>
</aside>

<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm(__('core.a309')))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}
</script>
<!-- 로그인 후 외부로그인 끝 -->
