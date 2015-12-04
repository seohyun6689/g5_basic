<?php
$sub_menu = '700600';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$surveys = sql_fetch("select * from {$g5['surveys_m_table']} where su_id = '{$su_id}'");

if ($surveys['su_begin_time'] <= date('Y-m-d H:i:s') && $surveys['su_end_time'] >= date('Y-m-d H:i:s') ) {
	alert( '설문조사가 시작된 경우 항목을 수정하실 수 없습니다.' );	
}

// 분류불러오기
$sql = "select * from {$g5['surveys_c_table']} where su_id = '{$su_id}'";
$result = sql_query($sql);
$categories = array();
while ( $row = sql_fetch_array($result) ) {
	$categories[] = $row;
}

// 질문출력
$sql = "select * from {$g5['surveys_q_table']} where su_id = '{$su_id}' order by suq_sort asc";
$result = sql_query($sql);
$results = array();
while ( $row = sql_fetch_array($result)){
	$results[] = $row;
}

$g5['title'] = '설문조사 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
add_stylesheet( '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />', 0 );
?>

<style type="text/css">
ul { list-style: none; padding: 0; }
.surveys_items li{ padding: 10px 20px; border-top: 1px dashed #ccc; border-bottom: 1px dashed #ccc; }
.surveys_items dd { padding: 5px 0; }

.add_surveys_item {  }
.add_surveys_item a { display: block; height: 40px; line-height: 40px; text-align: center; }
</style>
<h2 class="sound_only">항목분류관리</h2>

<div class="local_desc01 local_desc">
	<ul>
		<li>질문삭제는 질문란에 아무것도 입력하지 않고 저장하시면 됩니다.</li>
		<li>주관식인경우 답변은 무시됩니다.</li>
	</ul>
</div>
<div class="btn_add01 btn_add"><a href="./categories/index.php?su_id=<?php echo $su_id; ?>" id="open_category_win">항목분류관리</a></div>

<form  action="questionsupdate.php"  method="post">
<input type="hidden" name="su_id" id="su_id" value="<?php echo $su_id; ?>" />
<input type="hidden" name="su_item_cnt" id="su_item_cnt" value="<?php echo count($results); ?>" />
<div class="tbl_frm01 tbl_wrap">
	<div class="add_surveys_item">
		 <a href="#" id="add_surveys_item_btn" class="btn_frmline add_surveys_item_btn">설문문항추가</a>
	</div>
	<ul id="surveys_items" class="surveys_items">
<?php foreach ($results as $index => $row) : ?>		
		<li>
			<table>
				<tbody>
				<tr>
					<th scope="row">순서</th>
					<td>
						<a href="#" class="sortable_up btn_frmline"><i class="fa fa-caret-up fa-lg"></i></a>
						<a href="#" class="sortable_down btn_frmline"><i class="fa fa-caret-down fa-lg"></i></a>
					</td>
				</tr>
			<?php if ( count($categories) > 0 ) : ?>		
				<tr>
					<th scope="row"><label>항목분류</label></th>
					<td>
						<select name="_category_<?php echo $index; ?>">
							<option value="">:: 분류선택 ::</option>
			<?php foreach( $categories as $category ) :  $selected = ( $category['suc_id'] == $row['suq_category'] ? ' selected ' : '' );  ?>							
							<option value="<?php echo $category['suc_id']; ?>"<?php echo $selected; ?>><?php echo $category['suc_name']; ?></option>
			<?php endforeach; ?>				
						</select>
					</td>
				</tr>
			<?php endif; ?>
				<tr>
					<th scope="row"><label>출력형식</label></th>
					<td>
						<label for=""><input type="radio" name="_type_<?php echo $index; ?>" value=""<?php echo ( $row['suq_type'] == '' ? ' checked ' : '' ); ?> /> 사용안함</label>
						<label for=""><input type="radio" name="_type_<?php echo $index; ?>" value="table"<?php echo ( $row['suq_type'] == 'table' ? ' checked ' : '' ); ?> /> 표형식</label>
						<label for=""><input type="radio" name="_type_<?php echo $index; ?>" value="subjective"<?php echo ( $row['suq_type'] == 'subjective' ? ' checked ' : '' ); ?> /> 주관식</label>
					</td>
				</tr>
				
				<tr>
					<th scope="row"><label>선택갯수</label></th>
					<td>
						<select name="_amax_<?php echo $index; ?>" class="a_max">
			<?php for( $i = 1; $i <= 10; $i++ ) : $selected = ( $row['suq_max_select'] == $i ? ' selected ' : '' ); ?>				
							<option value="<?php echo $i; ?>"<?php echo $selected; ?>><?php echo $i; ?>개까지 선택</option>
			<?php endfor; ?>				
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label>기타사용</label></th>
					<td>
						<label for=""><input type="checkbox" name="_etc_<?php echo $index; ?>" value="enabled"<?php echo ( $row['suq_enable_etc'] == 'enabled' ? ' checked ' : ''); ?> /> 직접입력 기타 사용</label>
					</td>
				</tr>
				
				<tr>
					<th scope="row">항목</th>
					<td>
						<dl>
							<dt>
								<label>Q.</label>
								<input type="hidden" name="_suq_id_<?php echo $index; ?>" value="<?php echo $row['suq_id']; ?>" />
								<input type="hidden" name="suq_sort_key[]" id="suq_sort_key_<?php echo $index; ?>" value="_<?php echo $index; ?>"  />
								<textarea name="_q_<?php echo $index; ?>" class="frm_textarea" style="width: 80%;" ><?php echo $row['suq_question']; ?></textarea>
							</dt>
							<dd>
								<label>1.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_1']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>2.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_2']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>3.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_3']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>4.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_4']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>5.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_5']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>6.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_6']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>7.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_7']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>8.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_8']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>9.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_9']; ?>" style="width: 80%;" />
							</dd>
							<dd>
								<label>10.</label>
								<input type="text" name="_a_<?php echo $index; ?>[]" class="frm_input" value="<?php echo $row['suq_answer_10']; ?>" style="width: 80%;" />
							</dd>
						</dl>
					</td>
				</tr>
				</tbody>
			</table>
		</li>		
<?php endforeach; ?>		
	</ul>
	<div class="add_surveys_item">
		 <a href="#" class="btn_frmline add_surveys_item_btn">설문문항추가</a>
	</div>
</div>
<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./surveyslist.php">목록</a>
</div>
</form>

<div id="hidden_item" class="sound_only">
<table>
	<tbody>
	<tr>
		<th scope="row">순서</th>
		<td>
			<a href="#" class="sortable_up btn_frmline"><i class="fa fa-caret-up fa-lg"></i></a>
			<a href="#" class="sortable_down btn_frmline"><i class="fa fa-caret-down fa-lg"></i></a>
		</td>
	</tr>
<?php if ( count($categories) > 0 ) : ?>		
	<tr>
		<th scope="row"><label>항목분류</label></th>
		<td>
			<select name="_category_0">
				<option value="">:: 분류선택 ::</option>
<?php foreach( $categories as $category ) : ?>							
				<option value="<?php echo $category['suc_id']; ?>"><?php echo $category['suc_name']; ?></option>
<?php endforeach; ?>				
			</select>
		</td>
	</tr>
<?php endif; ?>
	<tr>
		<th scope="row"><label>출력형식</label></th>
		<td>
			<label for=""><input type="radio" name="_type_0" value="" checked /> 사용안함</label>
			<label for=""><input type="radio" name="_type_0" value="table" /> 표형식</label>
			<label for=""><input type="radio" name="_type_0" value="subjective" /> 주관식</label>
		</td>
	</tr>
	
	<tr>
		<th scope="row"><label>선택갯수</label></th>
		<td>
			<select name="_amax_0" class="a_max">
<?php for( $i = 1; $i <= 10; $i++ ) : ?>				
				<option value="<?php echo $i; ?>"><?php echo $i; ?>개까지 선택</option>
<?php endfor; ?>				
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><label>기타사용</label></th>
		<td>
			<label for=""><input type="checkbox" name="_etc_0" value="enabled" /> 직접입력 기타 사용</label>
		</td>
	</tr>
	
	<tr>
		<th scope="row">항목</th>
		<td>
			<dl>
				<dt>
					<label>Q.</label>
					<input type="hidden" name="_suq_id_0" value="" />
					<input type="hidden" name="suq_sort_key[]" id="suq_sort_key_0" value="_0"  />
					<textarea name="_q_0" class="frm_textarea" style="width: 80%;" ></textarea>
				</dt>
				<dd>
					<label>1.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>2.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>3.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>4.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>5.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>6.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>7.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>8.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>9.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
				<dd>
					<label>10.</label>
					<input type="text" name="_a_0[]" class="frm_input" style="width: 80%;" />
				</dd>
			</dl>
		</td>
	</tr>
	</tbody>
</table>
</div>

<script type="text/javascript">
$(function(){
	$('#open_category_win').click(function(e){
		e.preventDefault();
		var open_category_win = window.open($(this).attr('href'), 'open_category_win', 'width=500, height=400');
		open_category_win.focus();
	});
	
	var add_item_cnt = null;
	$('.add_surveys_item_btn').click(function(e){
		e.preventDefault();
		var item = $('#hidden_item').html();
		item_cnt = parseInt($('ul#surveys_items li').size());
		item = item.replace( /_0/g, '_' + item_cnt, item );
		
		$('#surveys_items').append( '<li>' + item + '</li>' );

		$('#su_item_cnt').val( item_cnt );
	});

	if ( $('#surveys_items li').size() == 0 ) {
		$('#add_surveys_item_btn').trigger('click');
	}
	
	$('.sortable_up').live('click', function(e){
		e.preventDefault();
		var li = $(this).parents('li');
		li.prev().before(li);
	});
	$('.sortable_down').live('click', function(e){
		e.preventDefault();
		var li = $(this).parents('li');
		li.next().after(li);
	});
	
});
</script>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>