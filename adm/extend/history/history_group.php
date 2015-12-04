<?php
include_once('./_common.php');

$sql = "select * from `{$g5['history_group_table']}` where his_id = '{$his_id}' order by his_group_sort desc, his_group_id asc";
$result = sql_query($sql);
$history_groups = array();
while ($row = sql_fetch_array($result)) {
	$history_groups[] = (object)$row;
}
?>
<style>
.frm_input_block { display: block; width: 100%; }
</style>
<div class="helper">
	<p>그룹명을 더블클릭하시면 삭제 됩니다.</p>
</div>
<form id="group-form" action="./history_group_update.php" method="post">
	<input type="hidden" name="his_id" value="<?php echo $his_id; ?>" />
	<div class="tbl_head01 tbl_wrap">
		<table id="history-group-list">
			<colgroup>
			<col />
			<col width="100" />
			</colgroup>
			<thead>
			<tr>
				<th scope="col">그룹명</th>
				<th scope="col">정렬</th>
			</tr>
			</thead>
			<tbody>
<?php foreach( $history_groups as $row ) : ?>				
			<tr>
				<td>
					<input type="hidden" name="group_id[]" value="<?php echo $row->his_group_id; ?>" />
					<input type="text" name="group_subject[]" value="<?php echo $row->his_group_subject; ?>" class="group_subject frm_input frm_input_block" placeholder="예) 2015~현재" />
					
				</td>				
				<td>
					<input type="text" name="group_sort[]" value="<?php echo $row->his_group_sort; ?>" class="frm_input frm_input_block" placeholder="정렬" />
				</td>
			</tr>
<?php endforeach; ?>	
<?php if (count($history_groups) <= 0) : ?>
			<tr>
				<td>
					<input type="hidden" name="group_id[]" value="" />
					<input type="text" name="group_subject[]" value="" class="group_subject frm_input frm_input_block" placeholder="예) 2015~현재" />
				</td>				
				<td>
					<input type="text" name="group_sort[]" value="" class="frm_input frm_input_block" placeholder="정렬" />
				</td>
			</tr>
<?php endif; ?>		
			</tbody>
		</table>
	</div>
</form>