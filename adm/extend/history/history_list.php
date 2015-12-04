<?php
include( './_common.php' );

auth_check($auth[$sub_menu], "r");

$sql = "select * from `{$g5['history_master_table']}` order by his_created desc ";
$result = sql_query($sql);
$list = array();
while ( $row = sql_fetch_array($result) ) {
	$list[] = $row;
}

$g5['title'] = '연혁 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<div class="btn_add01 btn_add">
    <a href="./history_form.php">연혁 추가</a>
</div>

<form >
<div class="tbl_head01 tbl_wrap">
	<table>
		<thead>
		<tr>
			<th scope="col">연혁아이디</th>
			<th scope="col">연혁제목</th>
			<th scope="col">스킨</th>
			<th scope="col">모바일스킨</th>
			<th scope="col">등록일</th>
			<th scope="col">관리</th>
		</tr>
		</thead>
		<tbody>
<?php foreach( $list as $row) : ?>			
		<tr>
			<td><?php echo $row['his_id']; ?></td>
			<td><?php echo $row['his_subject']; ?></td>
			<td align="center"><?php echo $row['his_skin']; ?></td>
			<td align="center"><?php echo $row['his_mobile_skin']; ?></td>
			<td><?php echo $row['his_created']; ?></td>
			<td align="center">
				<a href="./history_form.php?w=u&his_id=<?php echo $row['his_id']; ?>" class="btn_frmline">수정</a>
			</td>
		</tr>
<?php endforeach; ?>		
		</tbody>
	</table>
</div>
</form>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
