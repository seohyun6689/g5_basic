<?php
$sub_menu = '700600';
include_once('./_common.php');	

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['surveys_m_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common . " where su_removed = 0  ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common where su_removed = 0 order by su_id desc ";
$result = sql_query($sql);

$g5['title'] = '설문조사 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>
<style type="text/css">
.td_mngsmall { width: 150px; }
</style>
<div class="btn_add01 btn_add"><a href="surveysform.php">설문조사 추가</a></div>

<?php if ( !is_file(G5_EXTEND_PATH . '/surveys.extend.php' ) && !file_exists(G5_EXTEND_PATH . '/surveys.extend.php') )  : ?>
	<center>/extend/surveys.extend.php 파일이 존재하지 않습니다.</center>
<?php else  : ?>
<div class="tbl_head01 tbl_wrap">
	<table>
		<thead>
			<tr>
				<th scope="col">번호</th>
				<th scope="col">설문제목</th>
				<th scope="col">시작일</th>
				<th scope="col">종료일</th>
				<th scope="col">항목수</th>
				<th scope="col">참여수</th>
				<th scope="col">등록일</th>
				<th scope="col">결과</th>
				<th scope="col">관리</th>
			</tr>
		</thead>
		<tbody>
<?php
    	for ($i=0; $row=mysql_fetch_array($result); $i++) {
?>	    			
			<tr>
				<td class="td_num"><?php echo $row['su_id']; ?></td>
				<td class="td_subject">
					<?php echo $row['su_subject']; ?>
					<a href="<?php echo '/content/surveys?su_id=' . $row['su_id']; ?>" target="_blank" class="btn_frmline">설문조사보기</a>
				</td>
				<td class="td_datetime"><?php echo $row['su_begin_time']; ?></td>
				<td class="td_datetime"><?php echo $row['su_end_time']; ?></td>
				<td class="td_num"><?php echo number_format($row['su_questions']); ?></td>
				<td class="td_num"><?php echo number_format($row['su_people']); ?></td>
				<td class="td_datetime"><?php echo $row['su_created']; ?></td>
				<td class="td_mngsmall">
					<a href="./surveysresult.php?su_id=<?php echo $row['su_id']; ?>" class="btn_frmline">결과보기</a>
				</td>
				<td class="td_mngsmall">
					<a href="./questions.php?su_id=<?php echo $row['su_id']; ?>" class="btn_frmline">항목관리</a>
					<a href="./surveysform.php?w=u&su_id=<?php echo $row['su_id']; ?>" class="btn_frmline">수정</a>
					<a href="./surveysformupdate.php?w=d&su_id=<?php echo $row['su_id']; ?>" onclick="if( confirm('삭제하시면 복구가 불가능 하실 수 있습니다.\n삭제하시겠습니까?') ) { location.href = this.href; } return false; " class="btn_frmline">삭제</a>
				</td>
			</tr>
<?php 	}
	 	if ($i == 0) {
        echo '<tr><td colspan="11" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    	}
?>			
		</tbody>
	</table>
</div>
<?php endif; ?>
<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
