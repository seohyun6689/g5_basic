<?php
include_once('./_common.php');

@include_once($board_skin_path.'/good.head.skin.php');

// 자바스크립트 사용가능할 때
if($_POST['js'] == "on") {
    $error = $count = "";

    function print_result($error, $count)
    {
        echo '{ "error": "' . $error . '", "count": "' . $count . '" }';
        if($error)
            exit;
    }

    if (!$is_member)
    {
        $error = _(core_a58);
        print_result($error, $count);
    }

    if (!($bo_table && $wr_id)) {
        $error = _(core_a59);
        print_result($error, $count);
    }

    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    if (!get_session($ss_name)) {
        $error = _(core_a60);
        print_result($error, $count);
    }

    $row = sql_fetch(" select count(*) as cnt from {$g5['write_prefix']}{$bo_table} ", FALSE);
    if (!$row['cnt']) {
        $error = _(core_a61);
        print_result($error, $count);
    }

    if ($good == 'good' || $good == 'nogood')
    {
        if($write['mb_id'] == $member['mb_id']) {
            $error = _(core_a62);
            print_result($error, $count);
        }

        if (!$board['bo_use_good'] && $good == 'good') {
            $error = _(core_a63);
            print_result($error, $count);
        }

        if (!$board['bo_use_nogood'] && $good == 'nogood') {
            $error = _(core_a64);
            print_result($error, $count);
        }

        $sql = " select bg_flag from {$g5['board_good_table']}
                    where bo_table = '{$bo_table}'
                    and wr_id = '{$wr_id}'
                    and mb_id = '{$member['mb_id']}'
                    and bg_flag in ('good', 'nogood') ";
        $row = sql_fetch($sql);
        if ($row['bg_flag'])
        {
            if ($row['bg_flag'] == 'good')
                $status = _(theme_t1394);
            else
                $status = _(theme_t1395);

            $error = _(core_a65, $status);
            print_result($error, $count);
        }
        else
        {
            // 추천(찬성), 비추천(반대) 카운트 증가
            sql_query(" update {$g5['write_prefix']}{$bo_table} set wr_{$good} = wr_{$good} + 1 where wr_id = '{$wr_id}' ");
            // 내역 생성
            sql_query(" insert {$g5['board_good_table']} set bo_table = '{$bo_table}', wr_id = '{$wr_id}', mb_id = '{$member['mb_id']}', bg_flag = '{$good}', bg_datetime = '".G5_TIME_YMDHIS."' ");

            $sql = " select wr_{$good} as count from {$g5['write_prefix']}{$bo_table} where wr_id = '$wr_id' ";
            $row = sql_fetch($sql);

            $count = $row['count'];

            print_result($error, $count);
        }
    }
} else {
    include_once(G5_PATH.'/head.sub.php');

    if (!$is_member)
    {
        $href = './login.php?'.$qstr.'&amp;url='.urlencode('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);

        alert(_(core_a58), $href);
    }

    if (!($bo_table && $wr_id))
        alert(_(core_a59));

    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    if (!get_session($ss_name))
        alert(_(core_a60));

    $row = sql_fetch(" select count(*) as cnt from {$g5['write_prefix']}{$bo_table} ", FALSE);
    if (!$row['cnt'])
        alert(_(core_a61));

    if ($good == 'good' || $good == 'nogood')
    {
        if($write['mb_id'] == $member['mb_id'])
            alert(_(core_a62));

        if (!$board['bo_use_good'] && $good == 'good')
            alert(_(core_a63));

        if (!$board['bo_use_nogood'] && $good == 'nogood')
            alert(_(core_a64));

        $sql = " select bg_flag from {$g5['board_good_table']}
                    where bo_table = '{$bo_table}'
                    and wr_id = '{$wr_id}'
                    and mb_id = '{$member['mb_id']}'
                    and bg_flag in ('good', 'nogood') ";
        $row = sql_fetch($sql);
        if ($row['bg_flag'])
        {
            if ($row['bg_flag'] == 'good')
                $status = _(theme_t1394);
            else
                $status = _(theme_t1395);

            alert(_(core_a65, $status));
        }
        else
        {
            // 추천(찬성), 비추천(반대) 카운트 증가
            sql_query(" update {$g5['write_prefix']}{$bo_table} set wr_{$good} = wr_{$good} + 1 where wr_id = '{$wr_id}' ");
            // 내역 생성
            sql_query(" insert {$g5['board_good_table']} set bo_table = '{$bo_table}', wr_id = '{$wr_id}', mb_id = '{$member['mb_id']}', bg_flag = '{$good}', bg_datetime = '".G5_TIME_YMDHIS."' ");

            if ($good == 'good')
                $status = _(theme_t1394);
            else
                $status = _(theme_t1395);

            $href = './board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id;

            alert(_(core_a66, $status), '', false);
        }
    }
}

@include_once($board_skin_path.'/good.tail.skin.php');
?>
