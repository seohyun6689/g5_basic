<?php
$sub_menu = '700600';
include_once( './_common.php' );	

auth_check($auth[$sub_menu], "r");

// 설문조사
$sql = "select * from {$g5['surveys_m_table']} where su_id = '{$su_id}' ";
$surveys = sql_fetch($sql);

// 질문&보기
$sql = "select * from {$g5['surveys_q_table']} where su_id = '{$su_id}' order by suq_sort asc ";
$result = sql_query( $sql );
$questions = array();
while ($row = sql_fetch_array($result)){
	$answer = array();
	for ($i = 1; $i <= 10; $i++ ) {
		$answer[] = $row['suq_answer_'.$i];
	}
	$answer = array_filter($answer);
	$row['answer'] = $answer;
	$questions[] = $row;
}

$g5['title'] = '설문조사 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
add_stylesheet( '<link rel="stylesheet" href="./style.css" />' , 0 );
?>
<h2>설문조사 결과</h2>

<div id="surveys_result" class="tbl_frm01 tbl_wrap">
	<h3><?php echo $surveys['su_subject']; ?> <a href="./surveysresult.save.php?su_id=<?php echo $su_id; ?>" class="btn_frmline">결과 엑셀 저장</a></h3>
	<table>
		<tbody>
			<tr>
				<th width="120" scope="row">설문기간</th>
				<td>
					<?php echo $surveys['su_begin_time']; ?> ~ <?php echo $surveys['su_end_time']; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">설문참여건수</th>
				<td>
					<?php echo number_format($surveys['su_people']) . '건'; ?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<dl>
<?php foreach ( $questions as $question ) : ?>		
		<dt>Q. <?php echo $question['suq_question']; ?><?php echo ( $question['suq_type'] == 'subjective' ? '&nbsp;(주관식)' : ''); ?><?php echo ( $question['suq_max_select'] > 1 ? '&nbsp;(' . $question['suq_max_select'] . '개 까지)' : '' ); ?></dt>
		<dd>
			<?php echo answer_result( $surveys , $question ); ?>
		</dd>
<?php endforeach; ?>		
	</dl>
</div>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
