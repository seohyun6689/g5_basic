<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="mbskin">

    <p>
        <?php echo __(theme_t873, '<strong>' .get_text($mb['mb_name']) . '</strong>'); ?><br>
    </p>

    <?php if ($config['cf_use_email_certify']) {  ?>
    <p>
        <?php echo __(theme_t874); ?><br>
        <?php echo __(theme.t875); ?>
    </p>
    <div id="result_email">
        <span><?php echo __(theme_t833); ?></span>
        <strong><?php echo $mb['mb_id'] ?></strong><br>
        <span><?php echo __(theme_t876); ?></span>
        <strong><?php echo $mb['mb_email'] ?></strong>
    </div>
    <p>
        <?php echo __(theme_t877); ?>
    </p>
    <?php }  ?>

    <p>
        <?php echo __(theme_t878); ?>
    </p>

    <p>
        <?php echo __(theme_t879); ?>
    </p>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>/" class="btn02"><?php echo __(theme_t882); ?></a>
    </div>

</div>
<!-- } 회원가입결과 끝 -->
