<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<div id="bo_list">
    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
    <nav id="bo_cate">
        <h2><?php echo $qaconfig['qa_title'] ?> <?php echo __(theme_t659); ?></h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?><?php echo __(theme_t661); ?></span>
            <?php echo __(theme_t662, $page) ?>
        </div>

        <?php if ($admin_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><?php echo __(theme_t432); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo __(theme_t1038); ?></a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
        <caption><?php echo $board['bo_subject'] ?> <?php echo __(theme_t717); ?></caption>
        <thead>
        <tr>
            <th scope="col"><?php echo __(theme_t755); ?></th>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall" class="sound_only"><?php echo __(theme_t664); ?></label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
            <th scope="col"><?php echo __(theme_t1040); ?></th>
            <th scope="col"><?php echo __(theme_t422); ?></th>
            <th scope="col"><?php echo __(theme_t666); ?></th>
            <th scope="col"><?php echo __(theme_t525); ?></th>
            <th scope="col"><?php echo __(theme_t1041); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>
        <tr>
            <td class="td_num"><?php echo $list[$i]['num']; ?></td>
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
                <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
            </td>
            <?php } ?>
            <td class="td_category"><?php echo $list[$i]['category']; ?></td>
            <td class="td_subject">
                <a href="<?php echo $list[$i]['view_href']; ?>">
                    <?php echo $list[$i]['subject']; ?>
                </a>
                <?php echo $list[$i]['icon_file']; ?>
            </td>
            <td class="td_name"><?php echo $list[$i]['name']; ?></td>
            <td class="td_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? __(theme_t1042) : __(theme_t1043)); ?></td>
            <td class="td_date"><?php echo $list[$i]['date']; ?></td>
        </tr>
        <?php
        }
        ?>

        <?php if ($i == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">' . __(theme_t672) . '</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm">
            <li><input type="submit" name="btn_submit" value="<?php echo __(theme_t384); ?>" onclick="document.pressed=this.value"></li>
        </ul>
        <?php } ?>

        <ul class="btn_bo_user">
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01"><?php echo __(theme_t717); ?></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo __(theme_t1038); ?></a></li><?php } ?>
        </ul>
    </div>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p><?php echo __(theme_t681); ?></p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
    <legend><?php echo __(theme_t1430); ?></legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <label for="stx" class="sound_only"><?php echo __(theme_t598); ?><strong class="sound_only"> <?php echo __(theme_t421); ?></strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required  class="frm_input required" size="15" maxlength="15">
    <input type="submit" value="<?php echo __(theme_t675); ?>" class="btn_submit">
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(__('theme.t682', [document.pressed]));
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm(__('theme.t1044')))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
