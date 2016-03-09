<?php
$sub_menu = "999002";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();

$me_id		= $_POST['me_id'];
$me_code	= $_POST['me_code'];
$me_name	= $_POST['me_name'];
$me_link	= $_POST['me_link'];

if( !$me_name || !$me_link) { alert("메뉴명이 입력되지 않았습니다."); return false; }

$start_pos = strlen($me_code)+1;
$last_pos = strlen($me_code);

$sql = " select MAX(SUBSTRING(me_code,".$start_pos.",2)) as max_me_code
			from {$g5['menu_table']}
			where SUBSTRING(me_code,1,".$last_pos.") = '$me_code' ";

$row = sql_fetch($sql);

$row['max_me_code'] = $row['max_me_code'] ? $row['max_me_code'] : 0;

$sub_code = base_convert($row['max_me_code'], 36, 10);
$sub_code += 36;
$sub_code = base_convert($sub_code, 10, 36);

$me_code = $me_code.$sub_code;

$sql = " insert into {$g5['menu_table']}
			set me_code         = '$me_code',
				me_name         = '$me_name',
				me_link         = '$me_link',
				me_target       = 'self',
				me_order        = '0',
				me_use          = '1',
				me_mobile_use   = '1' ";
sql_query($sql);

?>
<script type="text/javascript">
	opener.location.reload();
	self.close();
</script>
