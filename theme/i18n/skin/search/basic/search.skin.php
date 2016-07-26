<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);
?>

<!-- 전체검색 시작 { -->
<form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
<input type="hidden" name="srows" value="<?php echo $srows ?>">
<fieldset id="sch_res_detail">
    <legend><?php echo __(theme_t1462); ?></legend>
    <?php echo $group_select ?>
    <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>

    <label for="sfl" class="sound_only"><?php echo __(theme_t1075); ?></label>
    <select name="sfl" id="sfl">
        <option value="wr_subject||wr_content"<?php echo get_selected($_GET['sfl'], "wr_subject||wr_content") ?>><?php echo __(theme_t677); ?></option>
        <option value="wr_subject"<?php echo get_selected($_GET['sfl'], "wr_subject") ?>><?php echo __(theme_t422); ?></option>
        <option value="wr_content"<?php echo get_selected($_GET['sfl'], "wr_content") ?>><?php echo __(theme_t423); ?></option>
        <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id") ?>><?php echo __(theme_t678); ?></option>
        <option value="wr_name"<?php echo get_selected($_GET['sfl'], "wr_name") ?>><?php echo __(theme_t452); ?></option>
    </select>

    <label for="stx" class="sound_only"><?php echo __(theme_t598); ?><strong class="sound_only"> <?php echo __(theme_t421); ?></strong></label>
    <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="frm_input required" maxlength="20">
    <input type="submit" class="btn_submit" value="<?php echo __(theme_t675); ?>">

    <script>
    function fsearch_submit(f)
    {
        if (f.stx.value.length < 2) {
            alert(__('core.a351'));
            f.stx.select();
            f.stx.focus();
            return false;
        }

        // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
        var cnt = 0;
        for (var i=0; i<f.stx.value.length; i++) {
            if (f.stx.value.charAt(i) == ' ')
                cnt++;
        }

        if (cnt > 1) {
            alert(__('core.a361'));
            f.stx.select();
            f.stx.focus();
            return false;
        }

        f.action = "";
        return true;
    }
    </script>
    <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop">
    <label for="sop_or">OR</label>
    <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop">
    <label for="sop_and">AND</label>
</fieldset>
</form>

<div id="sch_result">

    <?php
    if ($stx) {
        if ($board_count) {
    ?>
    <section id="sch_res_ov">
        <h2><?php echo $stx ?> <?php echo __(theme_t1076); ?></h2>
        <dl>
            <dt><?php echo __(theme_t687); ?></dt>
            <dd><strong class="sch_word"><?php echo $board_count ?></strong></dd>
            <dt><?php echo __(theme_t1077); ?></dt>
            <dd><strong class="sch_word"><?php echo number_format($total_count) ?></strong></dd>
        </dl>
        <p><?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> <?php echo __(theme_t1078); ?></p>
    </section>
    <?php
        }
    }
    ?>

    <?php
    if ($stx) {
        if ($board_count) {
     ?>
    <ul id="sch_res_board">
        <li><a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" <?php echo $sch_all ?>><?php echo __(theme_t1079); ?></a></li>
        <?php echo $str_board_list; ?>
    </ul>
    <?php
        } else {
     ?>
    <div class="empty_list"><?php echo __(theme_t1080); ?></div>
    <?php } }  ?>

    <hr>

    <?php if ($stx && $board_count) { ?><section class="sch_res_list"><?php }  ?>
    <?php
    $k=0;
    for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
     ?>
        <h2><a href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><?php echo $bo_subject[$idx] ?> <?php echo __(theme_t1081); ?></a></h2>
        <ul>
        <?php
        for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
            if ($list[$idx][$i]['wr_is_comment'])
            {
                $comment_def = '<span class="cmt_def">' . __(theme_t671) . ' | </span>';
                $comment_href = '#c_'.$list[$idx][$i]['wr_id'];
            }
            else
            {
                $comment_def = '';
                $comment_href = '';
            }
         ?>

            <li>
                <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="sch_res_title"><?php echo $comment_def ?><?php echo $list[$idx][$i]['subject'] ?></a>
                <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank"><?php echo __(theme_t1254); ?></a>
                <p><?php echo $list[$idx][$i]['content'] ?></p>
                <?php echo $list[$idx][$i]['name'] ?>
                <span class="sch_datetime"><?php echo $list[$idx][$i]['wr_datetime'] ?></span>
            </li>
        <?php }  ?>
        </ul>
        <div class="sch_more"><a href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><strong><?php echo $bo_subject[$idx] ?></strong> <?php echo __(theme_t1082); ?></a></div>

        <hr>
    <?php }  ?>
    <?php if ($stx && $board_count) {  ?></section><?php }  ?>

    <?php echo $write_pages ?>

</div>
<!-- } 전체검색 끝 -->
