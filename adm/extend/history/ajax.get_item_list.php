<?php
include_once('./_common.php');
ob_start();
include_once('./ajax.get_group_json.php');
$_group = ob_get_contents();
ob_end_clean();
$groups = json_decode($_group);

if ($mode == '' && $his_id) {
	$sql = "select * from `{$g5['history_item_table']}` where his_id = '{$his_id}' order by his_group_id {$his_sort}, CONCAT(his_item_year, his_item_month, his_item_day) {$his_sort} ";
	$result = sql_query($sql);
	$items = array();
	while($row = sql_fetch_array($result)){
		$items[] = (object)$row;
	}
}
?>

<?php if ( $mode == 'add' ) : ?>
<tr>
	<td align="center">
		<select name="his_group[]">
			<option value="항목그룹">그룹선택</option>
<?php if (count($groups) > 0 ) : ?>			
<?php foreach($groups as $group) : ?>
			<option value="<?php echo $group->his_group_id; ?>"><?php echo $group->his_group_subject; ?></option>
<?php endforeach; ?>		
<?php endif; ?>	
		</select>
	</td>
	<td>
		<select name="his_item_year[]">
<?php for($i = date('Y'); $i > 1950; $i--):?>
			<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
<?php endfor; ?>			
		</select>
		<select name="his_item_month[]">
<?php for($i = 1; $i <= 12; $i++):?>
			<option value="<?php echo sprintf('%02d', $i); ?>" ><?php echo sprintf('%02d', $i); ?></option>
<?php endfor; ?>
		</select>
		<select name="his_item_day[]">
<?php for($i = 1; $i <= 31; $i++):?>
			<option value="<?php echo sprintf('%02d', $i); ?>" ><?php echo sprintf('%02d', $i); ?></option>
<?php endfor; ?>
		</select>
	</td>
	<td>
		<input type="text" name="his_item_date[]" value="" class="frm_input" style="width: 100%;" />
	</td>
	<td>
		<input type="text" name="his_item_content[]" value="" class="frm_input" style="width: 100%;" />
	</td>
	<td>
		<textarea name="his_item_note[]"></textarea>
	</td>
	<td align="center">
		<input type="checkbox" name="his_item_disable[]" value="Y" />
	</td>
	<td align="center">
		<input type="hidden" name="his_item_id[]" value="" />
		<a href="/" class="btn_frmline btn_item_remove" style="width: 25px; height: 25px;padding: 0;text-align: center;"> - </a>
	</td>
</tr>
<?php else : ?>
<?php foreach ( $items as $item ) : ?>
<tr>
	<td align="center">
		<select name="his_group[]">
			<option value="항목그룹">그룹선택</option>
<?php if (count($groups) > 0 ) : ?>			
<?php foreach($groups as $group) : $selected = ( $group->his_group_id == $item->his_group_id ? ' selected="selected" ' : '' ); ?>
			<option value="<?php echo $group->his_group_id; ?>"<?php echo $selected; ?>><?php echo $group->his_group_subject; ?></option>
<?php endforeach; ?>		
<?php endif; ?>	
		</select>
	</td>
	<td>
		<select name="his_item_year[]">
<?php for($i = date('Y'); $i > 1950; $i--): $selected = ( $item->his_item_year == $i ? ' selected="selected" ' : '' ); ?>
			<option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?></option>
<?php endfor; ?>			
		</select>
		<select name="his_item_month[]">
<?php for($i = 1; $i <= 12; $i++): $selected = ( $item->his_item_month == sprintf('%02d', $i) ? ' selected="selected" ' : '' );?>
			<option value="<?php echo sprintf('%02d', $i); ?>"<?php echo $selected; ?>><?php echo sprintf('%02d', $i); ?></option>
<?php endfor; ?>
		</select>
		<select name="his_item_day[]">
<?php for($i = 1; $i <= 31; $i++): $selected = ( $item->his_item_day == sprintf('%02d', $i) ? ' selected="selected" ' : '' );?>
			<option value="<?php echo sprintf('%02d', $i); ?>"<?php echo $selected; ?>><?php echo sprintf('%02d', $i); ?></option>
<?php endfor; ?>
		</select>
	</td>
	<td>
		<input type="text" name="his_item_date[]" value="<?php echo $item->his_item_date; ?>" class="frm_input" style="width: 200px;" />
	</td>
	<td>
		<input type="text" name="his_item_content[]" value="<?php echo $item->his_item_content; ?>" class="frm_input" style="width: 100%;" />
	</td>
	<td>
		<textarea name="his_item_note[]"><?php echo $item->his_item_note; ?></textarea>
	</td>
	<td align="center">
		<input type="checkbox" name="his_item_disable[]" value="Y" <?php echo ( $item->his_item_disable == 'Y' ? ' checked="checked" ' : '' ); ?>/>
	</td>
	<td align="center">
		<input type="hidden" name="his_item_id[]" value="<?php echo $item->his_item_id; ?>" />
		<a href="/" class="btn_frmline btn_item_remove" style="width: 25px; height: 25px;padding: 0;text-align: center;"> - </a>
	</td>
</tr>	
<?php endforeach; ?>
<?php endif; ?>
