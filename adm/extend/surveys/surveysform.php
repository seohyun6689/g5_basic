<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$mem_levels = array();
for ($i=0; $i<=$member['mb_level']; $i++) {
    if ( !$g5['mb_level'][$i] ) continue;
    $mem_levels[$i] = $g5['mb_level'][$i];
}

if ( $w == 'u' ){
	$sql = "select * from {$g5['surveys_m_table']} where su_id = '{$su_id}'";
	$surveys = sql_fetch($sql);
	$su_levels = explode(',', $surveys['su_level']);
} else {
	$su_levels = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 );	// 기본 모두 체크
}
$g5['title'] = '설문조사 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="frmnewwin" action="./surveysformupdate.php" onsubmit="return frmsurveys_check(this);" method="post">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="su_id" id="su_id" value="<?php echo $su_id; ?>" />
<div class="tbl_frm01 tbl_wrap">
	<table>
		<tbody>
			<tr>
				<th scope="row"><label for="su_subject">설문제목</label></th>
				<td><input type="text" name="su_subject" id="su_subject" class="frm_input required" required value="<?php echo $surveys['su_subject']; ?>" size="50" /></td>
			</tr>
			<tr>
				<th scope="row">참여가능레벨</th>
				<td>
<?php foreach ( $mem_levels as $level_value => $level_label) : $checked = ( in_array( $level_value , $su_levels ) ? ' checked ' : '' ); ?>					
					<input type="checkbox" name="su_level[]" id="su_level_<?php echo $level_value; ?>" class="su_level" value="<?php echo $level_value; ?>" <?php echo $checked; ?> />
					<label for="su_level_<?php echo $level_value; ?>"><?php echo $level_label; ?></label>
<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">다수등록여부</th>
				<td>
					<input type="radio" name="su_multiple" id="su_multiple_Y" value="Y"<?php echo ( $surveys == false || $surveys['su_multiple'] == 'Y' ? ' checked ' : '' ); ?> /> <label for="su_multiple_Y">한번만등록</label>
					<input type="radio" name="su_multiple" id="su_multiple_N" value="N"<?php echo ( $surveys['su_multiple'] == 'N' ? ' checked ' : '' ); ?> /> <label for="su_multiple_N">다수등록</label>
				</td>
			</tr>
			<tr>
		        <th scope="row"><label for="su_begin_time">시작일시<strong class="sound_only"> 필수</strong></label></th>
		        <td>
		            <input type="text" name="su_begin_time" value="<?php echo $surveys['su_begin_time']; ?>" id="su_begin_time" required class="frm_input required" size="21" maxlength="19">
		            <input type="checkbox" name="su_begin_chk" value="<?php echo date("Y-m-d 00:00:00", G5_SERVER_TIME); ?>" id="su_begin_chk" onclick="if (this.checked == true) this.form.su_begin_time.value=this.form.su_begin_chk.value; else this.form.su_begin_time.value = this.form.su_begin_time.defaultValue;">
		            <label for="su_begin_chk">시작일시를 오늘로</label>
		        </td>
		    </tr>
		    <tr>
		        <th scope="row"><label for="su_end_time">종료일시<strong class="sound_only"> 필수</strong></label></th>
		        <td>
		            <input type="text" name="su_end_time" value="<?php echo $surveys['su_end_time']; ?>" id="su_end_time" required class="frm_input required" size="21" maxlength="19">
		            <input type="checkbox" name="su_end_chk" value="<?php echo date("Y-m-d 23:59:59", G5_SERVER_TIME+(60*60*24*7)); ?>" id="su_end_chk" onclick="if (this.checked == true) this.form.su_end_time.value=this.form.su_end_chk.value; else this.form.su_end_time.value = this.form.su_end_time.defaultValue;">
		            <label for="su_end_chk">종료일시를 오늘로부터 7일 후로</label>
		        </td>
		    </tr>
			<tr>
				<th scope="row">설문설명</th>
				<td><?php echo editor_html('su_content', get_text($surveys['su_content'], 0)); ?></td>
			</tr>			
		</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
<?php if ( $w == '' ) :?>	
    <input type="submit" value="다음" class="btn_submit" accesskey="s">
<?php else : ?>
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
<?php endif; ?>
    <a href="./surveyslist.php">목록</a>
</div>
</form>

<script type="text/javascript">
function frmsurveys_check(f){
	
	errmsg = "";
    errfld = "";
    
	<?php echo get_editor_js('su_content'); ?>

    check_field(f.su_subject, "제목을 입력하세요.");
    
    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    return true;
}

</script>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>

