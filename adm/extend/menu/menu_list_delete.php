<?php
$sub_menu = "999002";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_token();


if($me_id){
    $sql = " delete  from {$g5['menu_table']}  where me_id='$me_id' ";
	sql_query($sql);
}

?>
<script type="text/javascript">
	parent.location.reload();
</script>
