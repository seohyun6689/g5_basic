<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 폼메일 시작 { -->
<div id="formmail" class="new_win mbskin">
    <h1 id="win_title"><?php echo __(theme_t765, $name) ?></h1>

    <form name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="multipart/form-data" style="margin:0px;">
    <input type="hidden" name="to" value="<?php echo $email ?>">
    <input type="hidden" name="attach" value="2">
    <?php if ($is_member) { // 회원이면  ?>
    <input type="hidden" name="fnick" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="fmail" value="<?php echo $member['mb_email'] ?>">
    <?php }  ?>

    <div class="tbl_frm01 tbl_form">
        <table>
        <caption><?php echo __(theme_t766); ?></caption>
        <tbody>
        <?php if (!$is_member) {  ?>
        <tr>
            <th scope="row"><label for="fnick"><?php echo __(theme_t452); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td><input type="text" name="fnick" id="fnick" required class="frm_input required"></td>
        </tr>
        <tr>
            <th scope="row"><label for="fmail">E-mail<strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td><input type="text" name="fmail"  id="fmail" required class="frm_input required"></td>
        </tr>
        <?php }  ?>
        <tr>
            <th scope="row"><label for="subject"><?php echo __(theme_t422); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td><input type="text" name="subject" id="subject" required class="frm_input required"></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __(theme_t767); ?></th>
            <td>
                <input type="radio" name="type" value="0" id="type_text" checked> <label for="type_text">TEXT</label>
                <input type="radio" name="type" value="1" id="type_html"> <label for="type_html">HTML</label>
                <input type="radio" name="type" value="2" id="type_both"> <label for="type_both">TEXT+HTML</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="content"><?php echo __(theme_t423); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td><textarea name="content" id="content" required class="required"></textarea></td>
        </tr>
        <tr>
            <th scope="row"><label for="file1"><?php echo __(theme_t712); ?> 1</label></th>
            <td>
                <input type="file" name="file1"  id="file1"  class="frm_input">
                <?php echo __(theme_t1439); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="file2"><?php echo __(theme_t712); ?> 2</label></th>
            <td><input type="file" name="file2" id="file2" class="frm_input"></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __(theme_t700); ?></th>
            <td><?php echo captcha_html(); ?></td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="win_btn">
        <input type="submit" value="<?php echo __(theme_t1207); ?>" id="btn_submit" class="btn_submit">
        <button type="button" onclick="window.close();"><?php echo __(theme_t425); ?></button>
    </div>

    </form>
</div>

<script>
with (document.fformmail) {
    if (typeof fname != "undefined")
        fname.focus();
    else if (typeof subject != "undefined")
        subject.focus();
}

function fformmail_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    if (f.file1.value || f.file2.value) {
        // 4.00.11
        if (!confirm(__('theme.t769')))
            return false;
    }

    document.getElementById('btn_submit').disabled = true;

    return true;
}
</script>
<!-- } 폼메일 끝 -->
