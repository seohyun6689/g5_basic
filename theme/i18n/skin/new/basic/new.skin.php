<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_admin) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css">', 0);
?>

<!-- 전체게시물 검색 시작 { -->
<fieldset id="new_sch">
    <legend><?php echo __(theme_t1462); ?></legend>
    <form name="fnew" method="get">
    <?php echo $group_select ?>
    <label for="view" class="sound_only"><?php echo __(theme_t676); ?></label>
    <select name="view" id="view">
        <option value=""><?php echo __(theme_t975); ?>
        <option value="w"><?php echo __(theme_t984); ?>
        <option value="c"><?php echo __(theme_t985); ?>
    </select>
    <label for="mb_id" class="sound_only"><?php echo __(theme_t598); ?><strong class="sound_only"> <?php echo __(theme_t421); ?></strong></label>
    <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" required class="frm_input required">
    <input type="submit" value="<?php echo __(theme_t675); ?>" class="btn_submit">
    <p><?php echo __(theme_t986); ?></p>
    </form>
    <script>
    /* 셀렉트 박스에서 자동 이동 해제
    function select_change()
    {
        document.fnew.submit();
    }
    */
    document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
    document.getElementById("view").value = "<?php echo $view ?>";
    </script>
</fieldset>
<!-- } 전체게시물 검색 끝 -->

<!-- 전체게시물 목록 시작 { -->
<form name="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
<input type="hidden" name="sw"       value="move">
<input type="hidden" name="view"     value="<?php echo $view; ?>">
<input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"      value="<?php echo $stx; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="page"     value="<?php echo $page; ?>">
<input type="hidden" name="pressed"  value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <?php if ($is_admin) { ?>
        <th scope="col">
            <label for="all_chk" class="sound_only"><?php echo __(theme_t987); ?></label>
            <input type="checkbox" id="all_chk">
        </th>
        <?php } ?>
        <th scope="col"><?php echo __(theme_t982); ?></th>
        <th scope="col"><?php echo __(theme_t687); ?></th>
        <th scope="col"><?php echo __(theme_t422); ?></th>
        <th scope="col"><?php echo __(theme_t452); ?></th>
        <th scope="col"><?php echo __(theme_t816); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $i<count($list); $i++)
    {
        $num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
        $gr_subject = cut_str($list[$i]['gr_subject'], 20);
        $bo_subject = cut_str($list[$i]['bo_subject'], 20);
        $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
    ?>
    <tr>
        <?php if ($is_admin) { ?>
        <td class="td_chk">
            <label for="chk_bn_id_<?php echo $i; ?>" class="sound_only"><?php echo $num?>번</label>
            <input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>">
            <input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
            <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
        </td>
        <?php } ?>
        <td class="td_group"><a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a></td>
        <td class="td_board"><a href="./board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>"><?php echo $bo_subject ?></a></td>
        <td><a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a></td>
        <td class="td_name"><div><?php echo $list[$i]['name'] ?></div></td>
        <td class="td_date"><?php echo $list[$i]['datetime2'] ?></td>
    </tr>
    <?php }  ?>

    <?php if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">' . __(theme_t672) . '</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<?php if ($is_admin) { ?>
<div class="sir_bw02 sir_bw">
    <input type="submit" onclick="document.pressed=this.value" value="<?php echo __(theme_t384); ?>" class="btn_submit">
</div>
<?php } ?>
</form>

<?php if ($is_admin) { ?>
<script>
$(function(){
    $('#all_chk').click(function(){
        $('[name="chk_bn_id[]"]').attr('checked', this.checked);
    });
});

function fnew_submit(f)
{
    f.pressed.value = document.pressed;

    var cnt = 0;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            cnt++;
    }

    if (!cnt) {
        alert(__('theme.t682', [document.pressed]));
        return false;
    }

    if (!confirm(__('theme.t989', [document.pressed]))) {
        return false;
    }

    f.action = "./new_delete.php";

    return true;
}
</script>
<?php } ?>

<?php echo $write_pages ?>
<!-- } 전체게시물 목록 끝 -->
