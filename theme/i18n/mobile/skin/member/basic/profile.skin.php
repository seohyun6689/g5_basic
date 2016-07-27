<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="profile" class="new_win mbskin">
    <h1 id="win_title"><?php echo __(theme_t822, $mb_nick) ?></h1>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <tr>
            <th scope="row"><?php echo __(theme_t824); ?></th>
            <td><?php echo $mb['mb_level'] ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __(theme_t371); ?></th>
            <td><?php echo number_format($mb['mb_point']) ?></td>
        </tr>
        <?php if ($mb_homepage) { ?>
        <tr>
            <th scope="row"><?php echo __(theme_t723); ?></th>
            <td><a href="<?php echo $mb_homepage ?>" target="_blank"><?php echo $mb_homepage ?></a></td>
        </tr>
        <?php } ?>
        <tr>
            <th scope="row"><?php echo __(theme_t825); ?></th>
            <td><?php echo ($member['mb_level'] >= $mb['mb_level']) ?  substr($mb['mb_datetime'],0,10) ." (".number_format($mb_reg_after)." " . __(theme_t827) . ")" : __(theme_t826); ?></td>
        </tr>
        <tr>
            <th scope="row"><?php echo __(theme_t828); ?></th>
            <td><?php echo ($member['mb_level'] >= $mb['mb_level']) ? $mb['mb_today_login'] : __(theme_t826); ?></td>
        </tr>
        </tbody>
        </table>
    </div>

    <section>
        <h2><?php echo __(theme_t829); ?></h2>
        <p><?php echo $mb_profile ?></p>
    </section>

    <div class="win_btn">
        <button type="button" onclick="window.close();"><?php echo __(theme_t425); ?></button>
    </div>
</div>
