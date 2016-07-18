<?php 
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// $all_histories = 전체 연혁 출력 변수 
// $histories = 연도가 있는 연혁
add_stylesheet('<link rel="stylesheet" href="' . $history_skin_url . '/style.css" />', 0);
?>
<div class="basic-history <?php echo $history['his_id']; ?>">
	<h3><?php echo $history['his_subject']; ?></h3>
	
	<?php foreach($histories as $year => $items) : ?>
	<dl>
		<dt><?php echo $year; ?></dt>
		<dd>
			<ul>
	<?php foreach ( $items as $item) : ?>
				<li>			
					<span class="date"><?php echo $item['date'] . '.'; ?></span>
					<?php echo $item['his_item_content']; ?>
				</li>
	<?php endforeach; ?>			
			</ul>
		</dd>
	</dl>
	<?php endforeach; ?>	
	
</div>