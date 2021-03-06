<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="memo_write" class="new_win mbskin">
    <h1 id="win_title"><?php echo __(theme_t974); ?></h1>

    <ul class="win_ul">
        <li><a href="./memo.php?kind=recv"><?php echo __(theme_t787); ?></a></li>
        <li><a href="./memo.php?kind=send"><?php echo __(theme_t788); ?></a></li>
        <li><a href="./memo_form.php"><?php echo __(theme_t789); ?></a></li>
    </ul>

    <form name="fmemoform" action="./memo_form_update.php" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption><?php echo __(theme_t789); ?></caption>
        <tbody>
        <tr>
            <th scope="row"><label for="me_recv_mb_id"><?php echo __(theme_t790); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td>
                <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="frm_input required">
                <span class="frm_info"><?php echo __(theme_t791); ?></span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="me_memo"><?php echo __(theme_t423); ?></label></th>
            <td><textarea name="me_memo" id="me_memo" required><?php echo $content ?></textarea></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __(theme_t700); ?></th>
            <td>
                <?php echo captcha_html(); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="win_btn">
        <input type="submit" value="<?php echo __(theme_t424); ?>" id="btn_submit" class="btn_submit">
        <button type="button" onclick="window.close();"><?php echo __(theme_t425); ?></button>
    </div>
    </form>
</div>

<script>
function fmemoform_submit(f)
{
    <?php echo chk_captcha_js(); ?>

    return true;
}
</script>
