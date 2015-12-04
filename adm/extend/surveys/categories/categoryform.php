<?php
$sub_menu = '700600';
include_once( './_common.php' );

auth_check($auth[$sub_menu], "w");

if ( $suc_id == '' ) {
	
} else {
	$sql = "select * from {$g5[surveys_c_table]} where suc_id = '{$suc_id}'";
	$su_category = sql_fetch($sql);
}

$g5['title'] = '설문조사 분류관리';
include_once( G5_PATH . '/head.sub.php' );
?>
<form action="./categoryformupdate.php" method="post" >
<input type="hidden" name="w" id="w" value="<?php echo $w; ?>" />
<input type="hidden" name="su_id" id="su_id" value="<?php echo $su_id; ?>" />
<input type="hidden" name="suc_id" id="suc_id" value="<?php echo $suc_id; ?>" />
<div class="tbl_frm01 tbl_wrap">
	<table>
		<tbody>
			<tr>
				<th scope="row"><label for="">분류명</label></th>
				<td><input type="text" name="suc_name" id="suc_name"  value="<?php echo $su_category['suc_name']; ?>" class="frm_input required" required size="40" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="">분류설명</label></th>
				<td><textarea name="suc_summary" id="suc_summary"><?php echo $su_category['suc_summary']; ?></textarea></td>
			</tr> 
		</tbody>
	</table>
	
	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit" accesskey="s">
	    <a href="./index.php?su_id=<?php echo $su_id; ?>">목록</a>
	</div>
</div>
</form>
<?php
include_once( G5_PATH . '/tail.sub.php' );
?>
