<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str."글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str."글 삭제";
else $g5['title'] = $g5['title'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<div id="pw_confirm" class="mbskin">
    <h1><?php echo $g5['title'] ?></h1>
    <p>
        <?php if ($w == 'u') { ?>
        <?php echo __(theme_t811); ?>
        <?php } else if ($w == 'd' || $w == 'x') { ?>
        <?php echo __(theme_t812); ?>
        <?php } else { ?>
        <?php echo __(theme_t813); ?>
        <?php } ?>
    </p>

    <form name="fboardpassword" action="<?php echo $action; ?>" method="post">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">

    <fieldset>
        <input type="password" name="wr_password" id="pw_wr_password"  placeholder="<?php echo __(theme_t471); ?>(<?php echo __(theme_t421); ?>)" required class="frm_input required" maxLength="20">
        <input type="submit" class="btn_submit" value="<?php echo __(theme_t429); ?>">
    </fieldset>
    </form>

    <div class="btn_confirm">
        <a href="<?php echo $return_url ?>"><?php echo __(theme_t814); ?></a>
    </div>

</div>
