<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css">', 0);
?>

<!-- 전체게시물 검색 시작 { -->
<fieldset id="new_sch">
    <legend>상세검색</legend>
    <form name="fnew" method="get">
    <?php echo $group_select ?>
    <label for="view" class="sound_only"><?php echo __(theme_t676); ?></label>
    <select name="view" id="view" onchange="select_change()">
        <option value=""><?php echo __(theme_t975); ?>
        <option value="w"><?php echo __(theme_t984); ?>
        <option value="c"><?php echo __(theme_t985); ?>
    </select>
    <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" placeholder="<?php echo __(theme_t598); ?>(<?php echo __(theme_t421); ?>)" required class="frm_input required">
    <input type="submit" value="<?php echo __(theme_t675); ?>" class="btn_submit">
    </form>
    <script>
    function select_change()
    {
        document.fnew.submit();
    }
    document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
    document.getElementById("view").value = "<?php echo $view ?>";
    </script>
</fieldset>
<!-- } 전체게시물 검색 끝 -->

<!-- 전체게시물 목록 시작 { -->
<div class="tbl_head01 tbl_wrap">
    <table id="new_tbl">
    <thead>
    <tr>
        <th scope="col"><?php echo __(theme_t687); ?></th>
        <th scope="col"><?php echo __(theme_t422); ?></th>
        <th scope="col"><?php echo __(theme_t816); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $i<count($list); $i++)
    {
        $gr_subject = cut_str($list[$i]['gr_subject'], 20);
        $bo_subject = cut_str($list[$i]['bo_subject'], 20);
        $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
    ?>
    <tr>
        <td class="td_board"><a href="./board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>"><?php echo $bo_subject ?></a></td>
        <td><a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a></td>
        <td class="td_date"><?php echo $list[$i]['datetime2'] ?></td>
    </tr>
    <?php } ?>

    <?php if ($i == 0)
        echo '<tr><td colspan="3" class="empty_table">' . __(theme_t672) . '</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<?php echo $write_pages ?>
<!-- } 전체게시물 목록 끝 -->
