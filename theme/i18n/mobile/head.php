<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<header id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

    <div class="to_content"><a href="#container"><?php echo __(theme_t607); ?></a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>

    <div id="hd_wrapper">

        <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.jpg" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>

        <button type="button" id="gnb_open" class="hd_opener"><?php echo __(theme_t1465); ?><span class="sound_only"> <?php echo __(theme_t1466); ?></span></button>

        <div id="gnb" class="hd_div">
            <ul id="gnb_1dul">
            <?php
            $sql = " select *
                        from {$g5['menu_table']}
                        where me_mobile_use = '1'
                          and length(me_code) = '2'
                        order by me_order, me_id ";
            $result = sql_query($sql, false);

            for($i=0; $row=sql_fetch_array($result); $i++) {
            ?>
                <li class="gnb_1dli">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                    <?php
                    $sql2 = " select *
                                from {$g5['menu_table']}
                                where me_mobile_use = '1'
                                  and length(me_code) = '4'
                                  and substring(me_code, 1, 2) = '{$row['me_code']}'
                                order by me_order, me_id ";
                    $result2 = sql_query($sql2);

                    for ($k=0; $row2=sql_fetch_array($result2); $k++) {
                        if($k == 0)
                            echo '<ul class="gnb_2dul">'.PHP_EOL;
                    ?>
                        <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><span></span><?php echo $row2['me_name'] ?></a></li>
                    <?php
                    }

                    if($k > 0)
                        echo '</ul>'.PHP_EOL;
                    ?>
                </li>
            <?php
            }

            if ($i == 0) {  ?>
                <li id="gnb_empty"><?php echo __(theme_t1456); ?><?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하세요.<?php } ?></li>
            <?php } ?>
            </ul>
            <button type="button" id="gnb_close" class="hd_closer"><span class="sound_only"><?php echo __(theme_t1465); ?> </span><?php echo __(theme_t392); ?></button>
        </div>

        <button type="button" id="hd_sch_open" class="hd_opener"><?php echo __(theme_t675); ?><span class="sound_only"> <?php echo __(theme_t1466); ?></span></button>

        <div id="hd_sch" class="hd_div">
            <h2>사이트 내 전체검색</h2>
            <form name="fsearchbox" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);" method="get">
            <input type="hidden" name="sfl" value="wr_subject||wr_content">
            <input type="hidden" name="sop" value="and">
            <input type="text" name="stx" id="sch_stx" placeholder="<?php echo __(theme_t598); ?>" required class="required" maxlength="20">
            <input type="submit" value="<?php echo __(theme_t675); ?>" id="sch_submit">
            </form>

            <script>
            function fsearchbox_submit(f)
            {
                if (f.stx.value.length < 2) {
                    alert(__('core.a351'));
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                var cnt = 0;
                for (var i=0; i<f.stx.value.length; i++) {
                    if (f.stx.value.charAt(i) == ' ')
                        cnt++;
                }

                if (cnt > 1) {
                    alert(__('core.a361'));
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                return true;
            }
            </script>
            <button type="button" id="sch_close" class="hd_closer"><span class="sound_only"><?php echo __(theme_t675); ?> </span><?php echo __(theme_t392); ?></button>
        </div>

        <script>
        $(function () {
            $(".hd_opener").on("click", function() {
                var $this = $(this);
                var $hd_layer = $this.next(".hd_div");

                if($hd_layer.is(":visible")) {
                    $hd_layer.hide();
                    $this.find("span").text("<?php echo __(theme_t1466); ?>");
                } else {
                    var $hd_layer2 = $(".hd_div:visible");
                    $hd_layer2.prev(".hd_opener").find("span").text("<?php echo __(theme_t1466); ?>");
                    $hd_layer2.hide();

                    $hd_layer.show();
                    $this.find("span").text("<?php echo __(theme_t392); ?>");
                }
            });

            $(".hd_closer").on("click", function() {
                var idx = $(".hd_closer").index($(this));
                $(".hd_div:visible").hide();
                $(".hd_opener:eq("+idx+")").find("span").text("<?php echo __(theme_t1466); ?>");
            });
        });
        </script>

        <ul id="hd_nb">
            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php" id="snb_new"><?php echo __(theme_t619); ?></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/faq.php" id="snb_faq">FAQ</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/current_connect.php" id="snb_cnt"><?php echo __(theme_t649); ?> <?php echo connect('theme/basic'); // 현재 접속자수 ?></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/new.php" id="snb_new"><?php echo __(theme_t1399); ?></a></li>
            <?php if ($is_member) { ?>
            <?php if ($is_admin) { ?>
            <li><a href="<?php echo G5_ADMIN_URL ?>" id="snb_adm"><b><?php echo __(theme_t432); ?></b></a></li>
            <?php } ?>
            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" id="snb_modify"><?php echo __(theme_t614); ?></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php" id="snb_logout"><?php echo __(theme_t615); ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php" id="snb_join"><?php echo __(theme_t616); ?></a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php" id="snb_login"><?php echo __(theme_t617); ?></a></li>
            <?php } ?>
            <?php if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n'] && isset($i18n)) { ?>
            <li><?php echo $i18n->getLangSelectbox(); ?></li>
            <?php } ?>
        </ul>

    </div>
</header>

<hr>

<div id="wrapper">
    <div id="aside">
        <?php echo outlogin('theme/basic'); // 외부 로그인 ?>
    </div>
    <div id="container">
        <?php if ((!$bo_table || $w == 's' ) && !defined("_INDEX_")) { ?><div id="container_title"><?php echo $g5['title'] ?></div><?php } ?>
