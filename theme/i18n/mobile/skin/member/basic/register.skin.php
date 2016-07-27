<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div class="mbskin">

    <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

    <p><?php echo __(theme_t883); ?></p>

    <section id="fregister_term">
        <h2><?php echo __(theme_t884); ?></h2>
        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <fieldset class="fregister_agree">
            <label for="agree11"><?php echo __(theme_t885); ?></label>
            <input type="checkbox" name="agree" value="1" id="agree11">
        </fieldset>
    </section>

    <section id="fregister_private">
        <h2><?php echo __(theme_t427); ?></h2>
        <div class="tbl_head01 tbl_wrap">
            <table>
                <caption><?php echo __(theme_t427); ?></caption>
                <thead>
                <tr>
                    <th><?php echo __(theme_t1449); ?></th>
                    <th><?php echo __(theme_t1150); ?></th>
                    <th><?php echo __(theme_t1450); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo __(theme_t1451); ?></td>
                    <td><?php echo __(theme_t1452); ?></td>
                    <td><?php echo __(theme_t1453); ?></td>
                </tr>
                <tr>
                    <td><?php echo __(theme_t1454); ?></td>
                    <td><?php echo __(theme_t1455); ?></td>
                    <td><?php echo __(theme_t1453); ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <fieldset class="fregister_agree">
            <label for="agree21"><?php echo __(theme_t428); ?>.</label>
            <input type="checkbox" name="agree2" value="1" id="agree21">
        </fieldset>
    </section>

    <div class="btn_confirm">
        <input type="submit" class="btn_submit" value="<?php echo __(theme_t616); ?>">
    </div>

    </form>

    <script>
    function fregister_submit(f)
    {
        if (!f.agree.checked) {
            alert(__('core.a135'));
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert(__('core.a136'));
            f.agree2.focus();
            return false;
        }

        return true;
    }
    </script>

</div>
