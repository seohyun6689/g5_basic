<?php
include_once('./_common.php');

$sql = "select SQL_CALC_FOUND_ROWS m.*, count(i.img_id) as items from {$g5['images_master_table']} m left join {$g5['images_items_table']} i on m.img_id = i.img_id group by m.img_id ";
$result = sql_query($sql);
$rows = array();
while( $row = sql_fetch_array( $result ) )
{
	$rows[] = $row;
}

$total_rows = sql_fetch( 'select FOUND_ROWS() as total_rows' );
$total_count = $total_rows['total_rows'];

$g5['title'] = '이미지관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>


<div class="local_ov01 local_ov">
    <?php if ($page > 1) {?><a href="<?php echo $_SERVER['PHP_SELF']; ?>">처음으로</a><?php } ?>
    <span>전체 슬라이드 <?php echo $total_count; ?>건</span>
</div>

<div class="btn_add01 btn_add">
    <a href="./images_form.php">이미지 슬라이드 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
<table>
	<caption><?php echo $g5['title']; ?> 목록</caption>
	<thead>
	<tr>
		<th>ID</th>
		<th>슬라이드명</th>
		<th>이미지수</th>
		<th>관리</th>
	</tr>
	</thead>
	<tbody>
	
	<?php 
	if (count($rows) > 0) :
		foreach( $rows as $row ) : 
	?>
    <tr>
        <td class="td_num"><?php echo $row['img_id']; ?></td>
        <td><?php echo $row['img_name']; ?></td>
        <td class="td_num"><?php echo $row['items']?></td>
        <td class="td_mng">
            <a href="./images_form.php?w=u&amp;id=<?php echo $row['img_id']; ?>"><span class="sound_only"><?php echo stripslashes($row['img_name']); ?> </span>수정</a>
            <a href="./images_delete.php?w=d&amp;id=<?php echo $row['img_id']; ?>" onclick="return delete_confirm();"><span class="sound_only"><?php echo stripslashes($row['img_name']); ?> </span>삭제</a>
        </td>
    </tr>
    <?php
		endforeach;
	endif;
    if (count($rows) == 0){
        echo '<tr><td colspan="5" class="empty_table"><span>자료가 한건도 없습니다.</span></td></tr>';
    }
    ?>
	</tbody>
</table>
</div>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>