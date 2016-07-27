<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<h2 id="container_title"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?><span class="sound_only"> <?php echo __(theme_t717); ?></span></h2>

<!-- 게시판 목록 시작 -->
<div id="bo_list<?php if ($is_admin) echo "_admin"; ?>">

    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']) ?> <?php echo __(theme_t659); ?></h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>

    <div class="bo_fx">
        <div id="bo_list_total">
            <span><?php echo __(theme_t1163, number_format($total_count)) ?></span>
            <?php echo __(theme_t662, $page) ?>
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><?php echo __(theme_t432); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo __(theme_t663); ?></a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head01 tbl_wrap">
        <table>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall"><?php echo __(theme_t664); ?></label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
            <th scope="col"><?php echo __(theme_t422); ?></th>
            <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?><?php echo __(theme_t667); ?></a></th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td><?php } ?>
            <td class="td_subject">
                <?php
                echo $list[$i]['icon_reply'];
                if ($is_category && $list[$i]['ca_name']) {
                ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
                    <?php echo $list[$i]['subject'] ?>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only"><?php echo __(theme_t671); ?></span><?php echo $list[$i]['comment_cnt']; ?><span class="sound_only">개</span><?php } ?>
                    <?php
                    // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                    if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                    if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                    if (isset($list[$i]['icon_file'])) echo $list[$i]['icon_file'];
                    if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                    if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];

                    ?>
                </a>

            </td>
            <td class="td_date"><?php echo $list[$i]['datetime2'] ?></td>
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">' . __(theme_t672) . '</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <ul class="btn_bo_adm">
            <?php if ($list_href) { ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01"> <?php echo __(theme_t717); ?></a></li>
            <?php } ?>
            <?php if ($is_checkbox) { ?>
            <li><input type="submit" name="btn_submit" value="<?php echo __(theme_t384); ?>" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="<?php echo __(theme_t673); ?>" onclick="document.pressed=this.value"></li>
            <li><input type="submit" name="btn_submit" value="<?php echo __(theme_t674); ?>" onclick="document.pressed=this.value"></li>
            <?php } ?>
        </ul>

        <ul class="btn_bo_user">
            <li><?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo __(theme_t663); ?></a><?php } ?></li>
        </ul>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p><?php echo __(theme_t681); ?></p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $write_pages; ?>

<fieldset id="bo_sch">
    <legend><?php echo __(theme_t1430); ?></legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only"><?php echo __(theme_t676); ?></label>
    <select name="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>><?php echo __(theme_t422); ?></option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>><?php echo __(theme_t423); ?></option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>><?php echo __(theme_t677); ?></option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>><?php echo __(theme_t678); ?></option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>><?php echo __(theme_t679); ?></option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>><?php echo __(theme_t666); ?></option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>><?php echo __(theme_t680); ?></option>
    </select>
    <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="<?php echo __(theme_t598); ?>" required id="stx" class="required frm_input" size="15" maxlength="20">
    <input type="submit" value="검색" class="btn_submit">
    </form>
</fieldset>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(__('theme.t682', [document.pressed]));
        return false;
    }

    if(document.pressed == __('theme.t673')) {
        select_copy("copy");
        return;
    }

    if(document.pressed == __('theme.t674')) {
        select_copy("move");
        return;
    }

    if(document.pressed == __('theme.t384')) {
        if (!confirm(__('theme.t683')))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = __('theme.t684');
    else
        str = __('theme.t685');

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
