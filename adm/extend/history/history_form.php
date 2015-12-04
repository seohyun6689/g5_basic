<?php
$sub_menu = '700500';
include( './_common.php' );

auth_check($auth[$sub_menu], "r");

$history = (object)array();
if ( $w == '' && !$his_id ) {
	$history->his_output_type = 'y';
	$history->his_sort = 'asc';
	$history->his_skin = 'basic';
	$history->his_mobile_skin = 'basic';
	
	$his_id_readonly = false;
} else {
	
	$sql = "select * from `{$g5['history_master_table']}` where his_id = '{$his_id}'";
	$history = (object)sql_fetch($sql);

	$his_id_readonly = true;
}


$_history_output_type[ $history->his_output_type ] = ' checked="checked" ';
$_history_sort[ $history->his_sort ] = ' checked="checked" ';
$_history_use_group = ( $history->his_use_group == 'Y' ? ' checked="checked" ' : '' );

$g5['title'] = '연혁그룹 추가';
include_once (G5_ADMIN_PATH.'/admin.head.php');

add_stylesheet('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" /><link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />');
add_javascript('<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>');
add_javascript('<script type="text/javascript" src="' . G5_HISTORY_ADMIN_URL . '/scripts.js"></script>');
?>

<form name="frmwowmasterform" id="frmwowmasterform" action="./history_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="w" value="<?php echo $w; ?>">
	<div id="history_config">
		<h2>연혁 환경 설정</h2>
		<div class="tbl_frm01 tbl_wrap">
			<table>
				<tbody>
				<tr>
					<th scope="row"><label for="his_id">연혁아이디</label></th>
					<td>
						<input type="text" name="his_id" id="his_id" value="<?php echo $history->his_id; ?>" class="frm_input required" required <?php echo ($his_id_readonly ? 'readonly' : ''); ?> />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="his_subject">연혁제목</label></th>
					<td><input type="text" name="his_subject" id="his_subject" value="<?php echo $history->his_subject; ?>" class="frm_input required" required /></td>
				</tr>
				<tr>
					<th scope="row"><label>시작/마지막 년도</label></th>
					<td>
						<label for="his_start_year" class="sound_only">시작년도</label>
						<select name="his_start_year" id="his_start_year" class="required" required>
							<option value="">시작년도</option>
<?php for ( $i = date('Y'); $i > 1950; $i-- ) {
						$selected = ( $i == $history->his_start_year ? 'selected="selected"' : '' );
						echo '<option value="' . $i . '" ' . $selected . ' >' . $i . '</option>' . PHP_EOL;
}	
?>						
						</select> ~ 
						<label for="his_end_year" class="sound_only">마지막년도</label>
						<select name="his_end_year" id="his_end_year" class="required" required>
							<option value="">마지막년도</option>
<?php for ( $i = date('Y'); $i > 1950; $i-- ) {
						$selected = ( $i == $history->his_end_year ? 'selected="selected"' : '' );
						echo '<option value="' . $i . '" ' . $selected . ' >' . $i . '</option>' . PHP_EOL;
}	
?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="hi_output_type_1">출력형태</label></th>
					<td>
						<input type="radio" name="his_output_type" id="hi_output_type_1" value="a" <?php echo $_history_output_type['a']; ?> /> <label for="hi_output_type_1">전체</label>
						<input type="radio" name="his_output_type" id="hi_output_type_2" value="y" <?php echo $_history_output_type['y']; ?> /> <label for="hi_output_type_2">년</label>
						<input type="radio" name="his_output_type" id="hi_output_type_3"  value="m" <?php echo $_history_output_type['m']; ?> /> <label for="hi_output_type_3">월</label>
						<input type="radio" name="his_output_type" id="hi_output_type_4"  value="d" <?php echo $_history_output_type['d']; ?> /> <label for="hi_output_type_4">일</label>
						<input type="radio" name="his_output_type" id="hi_output_type_5" value="i" <?php echo $_history_output_type['i']; ?> /> <label for="hi_output_type_5">개별</label>
					</td>
				</tr>				
				<tr>
					<th scope="row"><label for="hi_sort_1">년도 순서 정렬</label></th>
					<td>
						<input type="radio" name="his_sort" id="his_sort_1" value="asc" <?php echo $_history_sort['asc']; ?> /> <label for="hi_sort_1">내림차순(ASC)</label>
						<input type="radio" name="his_sort" id="his_sort_2"  value="desc" <?php echo $_history_sort['desc']; ?> /> <label for="hi_sort_2">오름차순(DESC)</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="hi_sort_1">그룹사용여부</label></th>
					<td>
						<input type="checkbox" name="his_use_group" id="his_use_group" value="Y" <?php echo $_history_use_group; ?> /> <label for="his_use_group">항목 그룹 사용</label>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="his_skin">스킨</label></th>
					<td>
						<?php echo get_skin_select('history', 'his_skin', 'his_skin', $history->his_skin, 'required'); ?>
						
						
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label for="his_mobile_skin">모바일 스킨</label></th>
					<td>
						<?php echo get_mobile_skin_select('history', 'his_mobile_skin', 'his_mobile_skin', $history->his_mobile_skin, 'required'); ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
<?php if ( $w == 'u') : ?>
	<div class="btn_confirm01 btn_confirm">
		<input type="submit" class="btn_submit" accesskey="s" value="저장">
		<a href="history_list.php">목록</a>
	</div>
	<div id="history_item">
		<h2>
			연혁 항목 관리
			<div class="history-buttons" style="float: right;"> 
				<button id="add_history_item" class="btn_frmline">항목추가</button>
				<button id="open_history_group" class="btn_frmline">그룹관리</button>
			</div>
		</h2>
		<div class="tbl_head01 tbl_wrap">
			<table>
				<colgroup>
				<col width="120" />
				<col width="180" />
				<col width="150"/>
				<col />
				<col />
				<col />
				</colgroup>
				<thead>
				<tr>
					<th scope="col">항목그룹</th>
					<th scope="col">이벤트일자</th>
					<th scope="col">개별이벤트일자</th>
					<th scope="col">이벤트내용</th>
					<th scope="col">비고</th>
					<th scope="col">노출안함</th>
					<th scope="col">관리</th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div id="dialog"></div>
	</div>
<?php endif; ?>	
	
	<div class="btn_confirm01 btn_confirm">
		<input type="submit" class="btn_submit" accesskey="s" value="저장">
		<a href="history_list.php">목록</a>
	</div>
</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
