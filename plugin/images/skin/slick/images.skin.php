<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="' . G5_IMAGES_SKIN_URL . '/slick.css" />',0);
add_stylesheet('<link rel="stylesheet" href="' . G5_IMAGES_SKIN_URL . '/slick-theme.css" />',0);
add_javascript('<script type="text/javascript" src="' . G5_IMAGES_SKIN_URL . '/slick.min.js"></script>', 0);
?>
<style type="text/css">
#slick-<?php echo $id; ?> {position: relative;}
#slick-<?php echo $id; ?> .slick {position: relative; max-width: 1170px; margin: 0 auto; }
#slick-<?php echo $id; ?> .slick-slide img{display:block;max-width:100%;height: auto;}
#slick-<?php echo $id; ?> .slick-list {overflow: visible;}
#slick-<?php echo $id; ?> .slick-list:before {
	content: "";
    position: absolute;
    width: 1170px;
    height: 100%;
    top: 0;
    left: -1170px;
    background: url('<?php echo G5_IMAGES_SKIN_URL; ?>/img/bg-main-slide.png');
    z-index: 2;
}
#slick-<?php echo $id; ?> .slick-list:after {
	content: "";
    position: absolute;
    width: 1170px;
    height: 100%;
    top: 0;
    left: 100%;
    background: url('<?php echo G5_IMAGES_SKIN_URL; ?>/img/bg-main-slide.png');
    z-index: 2;
}
#slick-<?php echo $id; ?> .title {position: absolute; left: 0; top: 0px; width: 100%; height: 100%; padding: 7% 13%; z-index: 99;}
#slick-<?php echo $id; ?> .title img {width: 100%;}
@media (min-width: 768px) {
	#slick-<?php echo $id; ?> .title {left: 50%; top: 50%; width: auto; height: auto; margin-left: -240px; margin-top: -90px; padding: 0;}
}

</style>
<?php if (count($images)) { ?>
<div id="slick-<?php echo $id; ?>">
	<div class="slick">
		<?php foreach($images as $image) { ?>
		<div><?php echo $image['image']; ?></div>
		<?php } ?>
	</div>
</div>

<?php } else { ?>

<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	$('div#slick-<?php echo $id; ?> .slick').slick({
		dots: true,
		infinite: true,
		arrows: true,
		speed: 2000,
		autoplay: true,
		autoplaySpeed: 3000,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					dots: false
				}
			},
		]
	});
});
</script>
