<?php
include_once( './_common.php' );

if ( empty($su_id) ) {
	alert_close('설문조사 번호가 입력되지 않았습니다.');
}

$sql = "select * from {$g5['surveys_m_table']} where su_id = '{$su_id}'";
$surveys = sql_fetch($sql);

$sql = "select * from {$g5['surveys_c_table']} where su_id = '{$su_id}'";
$result = sql_query($sql);
$su_categories = array();
while ($row = sql_fetch_array($result)){
	$su_categories[] = $row;	
}
$g5['title'] = '설문조사 분류관리';
include_once( G5_PATH . '/head.sub.php' );
?>
<h2>설문조사 분류관리</h2>

<div class="btn_add01 btn_add"><a href="categoryform.php?su_id=<?php echo $su_id; ?>">분류 추가</a></div>
<div class="tbl_head01 tbl_wrap">
	<table>
		<thead>
		<tr>
			<th scope="col">분류명</th>
			<th scope="col">분류설명</th>
			<th scope="col">순서</th>
			<th scope="col">등록일</th>
		</tr>
		</thead>
		<tbody>
<?php 
	foreach ($su_categories as $row) : 
		$href = "./categoryform.php?w=u&su_id={$su_id}&suc_id={$row['suc_id']}";
?>
		<tr>
			<td class="td_subject"><a href="<?php echo $href; ?>"><?php echo $row['suc_name']; ?></a></td>
			<td class="td_subject"><?php echo $row['suc_summary']; ?></td>
			<td class="td_num"><?php echo $row['suc_sort']; ?></td>
			<td class="td_datetime"><?php echo $row['suc_created']; ?></td>
		</tr>
<?php endforeach; ?>	
<?php if (count($su_categories) <= 0 ) : ?>
		<tr>
			<td class="empty_list" colspan="4">분류가 존재하지 않습니다.</td>
		</tr>
<?php endif; ?>	
		</tbody>
	</table>
</div>
<?php
include_once( G5_PATH . '/tail.sub.php' );
?>
