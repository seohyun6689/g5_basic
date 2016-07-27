<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<aside id="visit">
    <div>
        <h2><?php echo __(theme_t1459); ?></h2>
        <dl>
            <dt><?php echo __(theme_t1059); ?></dt>
            <dd><?php echo number_format($visit[1]) ?></dd>
            <dt><?php echo __(theme_t1460); ?></dt>
            <dd><?php echo number_format($visit[2]) ?></dd>
            <dt><?php echo __(theme_t506); ?></dt>
            <dd><?php echo number_format($visit[3]) ?></dd>
            <dt><?php echo __(theme_t660); ?></dt>
            <dd><?php echo number_format($visit[4]) ?></dd>
        </dl>
        <?php if ($is_admin == "super") { ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php"><?php echo __(theme_t1461); ?></a><?php } ?>
    </div>
</aside>
