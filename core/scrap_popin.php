<?php
include_once('./_common.php');

include_once(G5_PATH.'/head.sub.php');

$a670 = _(core_a670);
$a671 = _(core_a671);
if ($is_guest) {
    $href = './login.php?'.$qstr.'&amp;url='.urlencode('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);
    $href2 = str_replace('&amp;', '&', $href);
    echo <<<HEREDOC
    <script>
        alert('{$a670}');
        opener.location.href = '$href2';
        window.close();
    </script>
    <noscript>
    <p>{$a670}</p>
    <a href="$href">{$a671}</a>
    </noscript>
HEREDOC;
    exit;
}
$a141 = _(core_a141);
echo <<<HEREDOC
<script>
    if (window.name != 'win_scrap') {
        alert('{$a141}');
        window.close();
    }
</script>
HEREDOC;

if ($write['wr_is_comment'])
    alert_close(_(core_a142));

$sql = " select count(*) as cnt from {$g5['scrap_table']}
            where mb_id = '{$member['mb_id']}'
            and bo_table = '$bo_table'
            and wr_id = '$wr_id' ";
$row = sql_fetch($sql);
$a143 = _(core_a143);
$a666 = _(core_a666);
$a667 = _(core_a667);
$t814 = _(theme_t814);
if ($row['cnt']) {
    echo <<<HEREDOC
    <script>
    if (confirm('{$a143}'))
        document.location.href = './scrap.php';
    else
        window.close();
    </script>
    <noscript>
    <p>{$a666}</p>
    <a href="./scrap.php">{$a667}</a>
    <a href="./board.php?bo_table={$bo_table}&amp;wr_id=$wr_id">{$t814}</a>
    </noscript>
HEREDOC;
    exit;
}

include_once($member_skin_path.'/scrap_popin.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>
