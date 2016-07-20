<?php
include_once('./_common.php');

$sql = " select mb_id, mb_email, mb_datetime from {$g5['member_table']} where mb_id = '{$mb_id}' ";
$row = sql_fetch($sql);
if (!$row['mb_id'])
    alert(_(core_a44), G5_URL);

if ($mb_md5) {
    $tmp_md5 = md5($row['mb_id'].$row['mb_email'].$row['mb_datetime']);
    if ($mb_md5 == $tmp_md5) {
        sql_query(" update {$g5['member_table']} set mb_mailling  = 0 where mb_id = '{$mb_id}' ");

        alert(_(core_a47), G5_URL);
    }
}

alert(_(core_a46), G5_URL);
?>
