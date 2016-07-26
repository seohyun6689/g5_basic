<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
    $kind_str = __(theme_t800);
    $kind_date = __(theme_t803);
}
else {
    $kind_str = __(theme_t801);
    $kind_date = __(theme_t802);
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지보기 시작 { -->
<div id="memo_view" class="new_win mbskin">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>

    <!-- 쪽지함 선택 시작 { -->
    <ul class="win_ul">
        <li><a href="./memo.php?kind=recv"><?php echo __(theme_t787); ?></a></li>
        <li><a href="./memo.php?kind=send"><?php echo __(theme_t788); ?></a></li>
        <li><a href="./memo_form.php"><?php echo __(theme_t789); ?></a></li>
    </ul>
    <!-- } 쪽지함 선택 끝 -->

    <article id="memo_view_contents">
        <header>
            <h1><?php echo __(theme_t792); ?></h1>
        </header>
        <ul id="memo_view_ul">
            <li class="memo_view_li">
                <span class="memo_view_subj"><?php echo $kind_str ?></span>
                <strong><?php echo $nick ?></strong>
            </li>
            <li class="memo_view_li">
                <span class="memo_view_subj"><?php echo $kind_date ?>시간</span>
                <strong><?php echo $memo['me_send_datetime'] ?></strong>
            </li>
        </ul>
        <p>
            <?php echo conv_content($memo['me_memo'], 0) ?>
        </p>
    </article>

    <div class="win_btn">
        <?php if($prev_link) {  ?>
        <a href="<?php echo $prev_link ?>"><?php echo __(theme_t795); ?></a>
        <?php }  ?>
        <?php if($next_link) {  ?>
        <a href="<?php echo $next_link ?>"><?php echo __(theme_t796); ?></a>
        <?php }  ?>
        <?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>"><?php echo __(theme_t797); ?></a><?php }  ?>
        <a href="./memo.php?kind=<?php echo $kind ?>"><?php echo __(theme_t798); ?></a>
        <button type="button" onclick="window.close();"><?php echo __(theme_t425); ?></button>
    </div>
</div>
<!-- } 쪽지보기 끝 -->
