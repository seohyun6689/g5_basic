<?php
include_once('./_common.php');

if (!$is_member)
    alert(__(core_a49));

$me_id = (int)$_REQUEST['me_id'];

if ($kind == 'recv')
{
    $t = __(theme_t787);
    $unkind = 'send';

    $sql = " update {$g5['memo_table']}
                set me_read_datetime = '".G5_TIME_YMDHIS."'
                where me_id = '$me_id'
                and me_recv_mb_id = '{$member['mb_id']}'
                and me_read_datetime = '0000-00-00 00:00:00' ";
    sql_query($sql);
}
else if ($kind == 'send')
{
    $t = __(theme_t788);
    $unkind = 'recv';
}
else
{
    alert(__(core_a87, $kind));
}

$g5['title'] = $t;
include_once(G5_PATH.'/head.sub.php');

$sql = " select * from {$g5['memo_table']}
            where me_id = '$me_id'
            and me_{$kind}_mb_id = '{$member['mb_id']}' ";
$memo = sql_fetch($sql);

// 이전 쪽지
$sql = " select * from {$g5['memo_table']}
            where me_id > '{$me_id}'
            and me_{$kind}_mb_id = '{$member['mb_id']}'
            order by me_id asc
            limit 1 ";
$prev = sql_fetch($sql);
if ($prev['me_id'])
    $prev_link = './memo_view.php?kind='.$kind.'&amp;me_id='.$prev['me_id'];
else
    //$prev_link = 'javascript:alert(\'쪽지의 처음입니다.\');';
    $prev_link = '';


// 다음 쪽지
$sql = " select * from {$g5[memo_table]}
            where me_id < '{$me_id}'
            and me_{$kind}_mb_id = '{$member[mb_id]}'
            order by me_id desc
            limit 1 ";
$next = sql_fetch($sql);
if ($next[me_id])
    $next_link = './memo_view.php?kind='.$kind.'&amp;me_id='.$next[me_id];
else
    //$next_link = 'javascript:alert(\'쪽지의 마지막입니다.\');';
    $next_link = '';

$mb = get_member($memo['me_'.$unkind.'_mb_id']);

include_once($member_skin_path.'/memo_view.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>
