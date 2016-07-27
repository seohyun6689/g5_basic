<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="memo_list" class="new_win mbskin">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>

    <ul class="win_ul">
        <li><a href="./memo.php?kind=recv"><?php echo __(theme_t787); ?></a></li>
        <li><a href="./memo.php?kind=send"><?php echo __(theme_t788); ?></a></li>
        <li><a href="./memo_form.php"><?php echo __(theme_t789); ?></a></li>
    </ul>

    <div class="win_desc">
        <?php echo __(theme_t660); ?> <?php echo $kind_title ?><?php echo __(theme_t646); ?> <?php echo $total_count ?><br>
    </div>

    <ul id="memo_list_ul">
        <?php for ($i=0; $i<count($list); $i++) { ?>
        <li>
            <a href="<?php echo $list[$i]['view_href'] ?>" class="memo_link"><?php echo $list[$i]['send_datetime'] ?> <?php echo  ($kind == "recv") ? __(theme_t787) : __(theme_t788);  ?></a>
            <span class="memo_read"><?php echo $list[$i]['read_datetime'] ?></span>
            <span class="memo_send"><?php echo $list[$i]['name'] ?></span>
            <a href="<?php echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;" class="memo_del"><?php echo __(theme_t391); ?></a>
        </li>
        <?php } ?>
        <?php if ($i==0) { echo "<li class=\"empty_list\">" . __(theme_t1471) . "</li>"; } ?>
    </ul>

    <p class="win_desc">
        <?php echo __(theme_t804, $config['cf_memo_del']); ?>
    </p>

    <div class="win_btn">
        <button type="button" onclick="window.close();"><?php echo __(theme_t425); ?></button>
    </div>
</div>
