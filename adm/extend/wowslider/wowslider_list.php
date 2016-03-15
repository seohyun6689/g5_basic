<?php
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '이미지 슬라이드 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql = "select SQL_CALC_FOUND_ROWS m.*, count(i.wsi_id) as ws_items from {$g5['ws_master_table']} m left join {$g5['ws_images_table']} i on m.ws_id = i.ws_id group by m.ws_id ";
$result = sql_query( $sql );
$rows = array();
while( $row = sql_fetch_array( $result ) )
{
	$rows[] = $row;
}

$total_rows = sql_fetch( 'select FOUND_ROWS() as total_rows' );
$total_count = $total_rows['total_rows'];
?>

<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['PHP_SELF']; ?>">처음으로</a><?php } ?>
    <span>전체 슬라이드 <?php echo $total_count; ?>건</span>
</div>

<div class="btn_add01 btn_add">
    <a href="./wowslider_form.php">이미지 슬라이드 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">제목</th>
        <th scope="col">이미지수</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach( $rows as $row ) : ?>
    <tr>
        <td class="td_num"><?php echo $row['ws_id']; ?></td>
        <td><?php echo $row['ws_name']; ?></td>
        <td class="td_num"><?php echo $row['ws_items']?></td>
        <td class="td_mng">
            <a href="./wowslider_form.php?w=u&amp;ws_id=<?php echo $row['ws_id']; ?>"><span class="sound_only"><?php echo stripslashes($row['ws_name']); ?> </span>수정</a>
            <a href="wowslider_view.php?ws_id=<?php echo $row['ws_id']; ?>" onclick="open_view(this);return false;"><span class="sound_only"><?php echo stripslashes($row['ws_name']); ?> </span>보기</a>
            <a href="./wowslider_delete.php?w=d&amp;ws_id=<?php echo $row['ws_id']; ?>" onclick="return delete_confirm();"><span class="sound_only"><?php echo stripslashes($row['ws_name']); ?> </span>삭제</a>
        </td>
    </tr>
    <?php
	endforeach;

    if (count($rows) == 0){
        echo '<tr><td colspan="5" class="empty_table"><span>자료가 한건도 없습니다.</span></td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>
<script>
function open_view( $this )
{
	var url = $this.href
	window.open(url, 'ws_view', 'left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes');
}
</script>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>