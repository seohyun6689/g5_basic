<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<section id="bo_w">
    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="qa_id" value="<?php echo $qa_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <?php
    $option = '';
    $option_hidden = '';
    $option = '';

    if ($is_dhtml_editor) {
        $option_hidden .= '<input type="hidden" name="qa_html" value="1">';
    } else {
        $option .= "\n".'<input type="checkbox" id="qa_html" name="qa_html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="qa_html">html</label>';
    }

    echo $option_hidden;
    ?>

    <div class="tbl_frm01 tbl_wrp">
        <table>
        <tbody>
        <?php if ($category_option) { ?>
        <tr>
            <th scope="row"><label for="qa_category"><?php echo __(theme_t1040); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td>
                <select name="qa_category" id="qa_category" required class="required" >
                    <option value=""><?php echo __(theme_t724); ?></option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>

        <?php if ($option) { ?>
        <tr>
            <th scope="row"><?php echo __(theme_t1434); ?></th>
            <td><?php echo $option; ?></td>
        </tr>
        <?php } ?>

        <?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="qa_email"><?php echo __(theme_t583); ?></label></th>
            <td>
                <input type="text" name="qa_email" value="<?php echo get_text($write['qa_email']); ?>" id="qa_email" <?php echo $req_email; ?> class="<?php echo $req_email.' '; ?>frm_input email" size="50" maxlength="100">
                <input type="checkbox" name="qa_email_recv" value="1" <?php if($write['qa_email_recv']) echo 'checked="checked"'; ?>>
                <label for="qa_email_recv"><?php echo __(theme_t1054); ?></label>
            </td>
        </tr>
        <?php } ?>

        <?php if ($is_hp) { ?>
        <tr>
            <th scope="row"><label for="qa_hp"><?php echo __(theme_t504); ?></label></th>
            <td>
                <input type="text" name="qa_hp" value="<?php echo get_text($write['qa_hp']); ?>" id="qa_hp" <?php echo $req_hp; ?> class="<?php echo $req_hp.' '; ?>frm_input" size="30">
                <?php if($qaconfig['qa_use_sms']) { ?>
                <input type="checkbox" name="qa_sms_recv" value="1" <?php if($write['qa_sms_recv']) echo 'checked="checked"'; ?>> <?php echo __(theme_t1055); ?>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <th scope="row"><label for="qa_subject"><?php echo __(theme_t422); ?><strong class="sound_only"><?php echo  __(theme_t421); ?></strong></label></th>
            <td>
                <input type="text" name="qa_subject" value="<?php echo get_text($write['qa_subject']); ?>" id="qa_subject" required class="frm_input required" size="50" maxlength="255">
            </td>
        </tr>

        <tr>
            <th scope="row"><label for="qa_content"><?php echo __(theme_t423); ?><strong class="sound_only"><?php echo  __(theme_t421); ?></strong></label></th>
            <td class="wr_content">
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?php echo __(theme_t1249); ?> #1</th>
            <td>
                <input type="file" name="bf_file[1]" title="<?php echo __(theme_t1329, array(1, $upload_max_filesize)); ?>" class="frm_file frm_input">
                <?php if($w == 'u' && $write['qa_file1']) { ?>
                <input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"> <label for="bf_file_del1"><?php echo $write['qa_source1']; ?> <?php echo __(theme_t1056); ?></label>
                <?php } ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?php echo __(theme_t1249); ?> #2</th>
            <td>
                <input type="file" name="bf_file[2]" title="<?php echo __(theme_t1329, array(2, $upload_max_filesize)); ?>" class="frm_file frm_input">
                <?php if($w == 'u' && $write['qa_file2']) { ?>
                <input type="checkbox" id="bf_file_del2" name="bf_file_del[2]" value="1"> <label for="bf_file_del2"><?php echo $write['qa_source2']; ?> <?php echo __(theme_t1056); ?></label>
                <?php } ?>
            </td>
        </tr>

        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="<?php echo __(theme_t1139); ?>" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="<?php echo $list_href; ?>" class="btn_cancel"><?php echo __(theme_t717); ?></a>
    </div>
    </form>

    <script>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm(__('theme.t749'));
            if (result)
                obj.value = "2";
            else
                obj.value = "1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.qa_subject.value,
                "content": f.qa_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert(__('theme.t750', [subject]));
            f.qa_subject.focus();
            return false;
        }

        if (content) {
            alert(__('theme.t702', [content]));
            if (typeof(ed_qa_content) != "undefined")
                ed_qa_content.returnFalse();
            else
                f.qa_content.focus();
            return false;
        }

        <?php if ($is_hp) { ?>
        var hp = f.qa_hp.value.replace(/[0-9\-]/g, "");
        if(hp.length > 0) {
            alert(__('theme.t1058'));
            return false;
        }
        <?php } ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->
