<?php
include_once('./_common.php');	

auth_check($auth[$sub_menu], "r");

$g5['title'] = '슬라이더 보기';
include_once(G5_PATH.'/head.sub.php');
$sql = 'select * from `' . $g5['ws_master_table'] . '` where ws_id = "' . $ws_id . '"';
$row = sql_fetch( $sql );
?>
<script>
window.onload = function(){
	this.resizeTo(<?php echo $row['ws_image_width']; ?>, <?php echo $row['ws_image_height']; ?>);
}
</script>
<?php echo wowslider($ws_id); ?>

<?php 
include_once(G5_PATH.'/tail.sub.php');
?>