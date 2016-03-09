<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<nav id="gnb">
    <h2>메인메뉴</h2>
    <ul id="gnb_1dul">
		<?php foreach ( $rows as $d1li => $row ) : $subIndex = 0; ?>
		<li class="gnb_1dli<?php echo ( $row['me_selected'] ? ' active ' : '' ); ?>">
			<a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da m<?php echo $row['me_code']; ?><?php echo $row['me_current']; ?>"><?php echo $row['me_name'] ?></a>
			
			<?php echo ( count( $row['items'] ) > 0 ? '<ul class="gnb_2dul">' . PHP_EOL : '' ); ?>
				<?php foreach ( $row['items'] as $row2 ) : ?>
				<li class="gnb_2dli<?php echo ($row2['me_selected'] ? ' active ' : ''); ?>"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
				<?php $subIndex = 0; endforeach; ?>
			<?php echo ( count( $row['items'] ) > 0 ? '</ul>' . PHP_EOL : '' ); ?>
		</li>
		<?php
		endforeach;

		if (count($rows) == 0) {  ?>
			<li id="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <br><a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
		<?php } ?>
	</ul>
</nav>