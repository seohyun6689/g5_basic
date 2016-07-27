<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$poll_skin_url.'/style.css">', 0);
?>

<form name="fpoll" action="<?php echo G5_BBS_URL ?>/poll_update.php" onsubmit="return fpoll_submit(this);" method="post">
<input type="hidden" name="po_id" value="<?php echo $po_id ?>">
<input type="hidden" name="skin_dir" value="<?php echo urlencode($skin_dir); ?>">
<aside id="poll">
    <header>
        <h2><?php echo __(theme_t1015); ?></h2>
        <?php if ($is_admin == "super") { ?><a href="<?php echo G5_ADMIN_URL ?>/poll_form.php?w=u&amp;po_id=<?php echo $po_id ?>" class="btn_admin"><?php echo __(theme_t1015) . __(theme_t454); ?></a><?php } ?>
        <p><?php echo $po['po_subject'] ?></p>
    </header>
    <ul>
        <?php for ($i=1; $i<=9 && $po["po_poll{$i}"]; $i++) { ?>
        <li><input type="radio" name="gb_poll" value="<?php echo $i ?>" id="gb_poll_<?php echo $i ?>"> <label for="gb_poll_<?php echo $i ?>"><?php echo $po['po_poll'.$i] ?></label></li>
        <?php } ?>
    </ul>
    <footer>
        <input type="submit" value="<?php echo __(theme_t1013); ?>">
        <a href="<?php echo G5_BBS_URL."/poll_result.php?po_id=$po_id&amp;skin_dir=".urlencode($skin_dir); ?>" target="_blank" onclick="poll_result(this.href); return false;"><?php echo __(theme_t1014); ?></a>
    </footer>
</aside>
</form>

<script>
function fpoll_submit(f)
{
    <?php
    if ($member['mb_level'] < $po['po_level'])
        echo " alert('" . __(theme_t1016, $po['po_level']) . "'); return false; ";
    ?>

    var chk = false;
    for (i=0; i<f.gb_poll.length;i ++) {
        if (f.gb_poll[i].checked == true) {
            chk = f.gb_poll[i].value;
            break;
        }
    }

    if (!chk) {
        alert(__('theme.t1017'));
        return false;
    }

    var new_win = window.open("about:blank", "win_poll", "width=616,height=500,scrollbars=yes,resizable=yes");
    f.target = "win_poll";

    return true;
}

function poll_result(url)
{
    <?php
    if ($member['mb_level'] < $po['po_level'])
        echo " alert('" . __(core_a101, $po['po_level']) . "'); return false; ";
    ?>

    win_poll(url);
}
</script>
