<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->
<div id="bo_v_table"><?php echo $qaconfig['qa_title']; ?></div>

<article id="bo_v">
    <header>
        <h1 id="bo_v_title">
            <?php
            echo $view['category'].' | '; // 분류 출력 끝
            echo $view['subject']; // 글제목 출력
            ?>
        </h1>
    </header>

    <section id="bo_v_info">
        <h2><?php echo __(theme_t711); ?></h2>
        <?php echo __(theme_t1421); ?> <strong><?php echo $view['name'] ?></strong>
        <span class="sound_only"><?php echo __(theme_t1438); ?></span><strong><?php echo $view['datetime']; ?></strong>
    </section>

    <?php if($view['download_count']) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2><?php echo __(theme_t712); ?></h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<$view['download_count']; $i++) {
         ?>
            <li>
                <a href="<?php echo $view['download_href'][$i];  ?>" class="view_file_download">
                    <img src="<?php echo $qa_skin_url ?>/img/icon_file.gif" alt="<?php echo __(theme_t712); ?>">
                    <strong><?php echo $view['download_source'][$i] ?></strong>
                </a>
            </li>
        <?php
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if($view['email'] || $view['hp']) { ?>
    <section id="bo_v_contact">
        <h2><?php echo __(theme_t1052); ?></h2>
        <dl>
            <?php if($view['email']) { ?>
            <dt><?php echo __(theme_t583); ?></dt>
            <dd><?php echo $view['email']; ?></dd>
            <?php } ?>
            <?php if($view['hp']) { ?>
            <dt><?php echo __(theme_t504); ?></dt>
            <dd><?php echo $view['hp']; ?></dd>
            <?php } ?>
        </dl>
    </section>
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01"><?php echo __(theme_t715); ?></a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01"><?php echo __(theme_t716); ?></a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="bo_v_com">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01"><?php echo __(theme_t690); ?></a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;"><?php echo __(theme_t391); ?></a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn_b01"><?php echo __(theme_t717); ?></a></li>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><?php echo __(theme_t663); ?></a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title"><?php echo __(theme_t719); ?></h2>

        <?php
        // 파일 출력
        if($view['img_count']) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<$view['img_count']; $i++) {
                //echo $view['img_file'][$i];
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
            }

            echo "</div>\n";
        }
         ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?></div>
        <!-- } 본문 내용 끝 -->

        <?php if($view['qa_type']) { ?>
        <div id="bo_v_addq"><a href="<?php echo $rewrite_href; ?>" class="btn_b01"><?php echo __(theme_t1045); ?></a></div>
        <?php } ?>

    </section>

    <?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($qa_skin_path.'/view.answer.skin.php');
        else
            include_once($qa_skin_path.'/view.answerform.skin.php');
    }
    ?>

    <?php if($view['rel_count']) { ?>
    <section id="bo_v_rel">
        <h2><?php echo __(theme_t1053); ?></h2>

        <div class="tbl_head01 tbl_wrap">
            <table>
            <thead>
            <tr>
                <th scope="col"><?php echo __(theme_t1040); ?></th>
                <th scope="col"><?php echo __(theme_t422); ?></th>
                <th scope="col"><?php echo __(theme_t525); ?></th>
                <th scope="col"><?php echo __(theme_t1041); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            for($i=0; $i<$view['rel_count']; $i++) {
            ?>
            <tr>
                <td class="td_category"><?php echo get_text($rel_list[$i]['category']); ?></td>
                <td>
                    <a href="<?php echo $rel_list[$i]['view_href']; ?>">
                        <?php echo $rel_list[$i]['subject']; ?>
                    </a>
                </td>
                <td class="td_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($rel_list[$i]['qa_status'] ? __(theme_t1042) : __(theme_t1043)); ?></td>
                <td class="td_date"><?php echo $rel_list[$i]['date']; ?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
            </table>
        </div>
    </section>
    <?php } ?>

    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>
