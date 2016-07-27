<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

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
            <span><?php echo __(theme_t1163, number_format($total_count)) ?></span>
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

    <?php if ($is_checkbox) { ?>
    <div id="list_chk">
        <label for="chkall" class="sound_only">게시물 전체</label>
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
    </div>
    <?php } ?>

    <div class="ul_wrap ul_01">
        <ul>
            <?php
            for ($i=0; $i<count($list); $i++) {
            ?>
            <li class="bo_li<?php if ($is_checkbox) echo ' bo_adm'; ?>">
                <?php if ($is_checkbox) { ?>
                <div class="li_chk">
                    <label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
                    <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
                </div>
                <?php } ?>
                <div class="li_title">
                    <a href="<?php echo $list[$i]['view_href']; ?>">
                        <strong><?php echo $list[$i]['category']; ?></strong>
                        <?php echo $list[$i]['subject']; ?>
                    </a>
                </div>
                <div class="li_info">
                    <span><?php echo $list[$i]['num']; ?></span>
                    <span><?php echo $list[$i]['name']; ?></span>
                    <span><?php echo $list[$i]['date']; ?></span>
                    <span><?php echo $list[$i]['icon_file']; ?></span>
                </div>
                <div class="li_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? __(theme_t1042) : __(theme_t1043)); ?></div>
            </li>
            <?php
            }
            ?>

            <?php if ($i == 0) { echo '<li class="empty_list">' . __(theme_t672) . '</li>'; } ?>
        </ul>
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
    <label for="stx" class="sound_only"><?php echo __(theme_t598); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="15">
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
