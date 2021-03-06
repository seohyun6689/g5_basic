<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section id="bo_v_ans">
    <?php
    if($is_admin) // 관리자이면 답변등록
    {
    ?>
    <h2><?php echo __(theme_t1048); ?></h2>

    <form name="fanswer" method="post" action="./qawrite_update.php" autocomplete="off">
    <input type="hidden" name="qa_id" value="<?php echo $view['qa_id']; ?>">
    <input type="hidden" name="w" value="a">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
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

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <?php if ($option) { ?>
        <tr>
            <th scope="row"><?php echo __(theme_t1434); ?></th>
            <td><?php echo $option; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th><label for="qa_subject"><?php echo __(theme_t422); ?></label></th>
            <td><input type="text" name="qa_subject" value="" id="qa_subject" required class="frm_input required" size="50" maxlength="255"></td>
        </tr>
        <tr>
        <th scope="row"><label for="qa_content"><?php echo __(theme_t423); ?><strong class="sound_only"><?php echo __(theme_t421); ?></strong></label></th>
            <td class="wr_content">
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="<?php echo __(theme_t1050); ?>" id="btn_submit" accesskey="s" class="btn_submit">
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

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
    <?php
    }
    else
    {
    ?>
    <p id="ans_msg"><?php echo __(theme_t1051); ?></p>
    <?php
    }
    ?>
</section>
