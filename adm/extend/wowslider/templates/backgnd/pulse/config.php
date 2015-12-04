<?php
/* config.js */
$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin' => 3, 'padding' => 5);
if (!parseInt($params->noFrame)){
	// frame border+shadow
	$border = (object)array( 'top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15 );
	$ContaienerW = $imageW + $border->left + $border->right;
	$ContaienerH = $imageH + $border->top + $border->bottom;
	$params->frameL = round(100*100*$border->left/$imageW)/100;
	$params->frameT = round(100*100*$border->top/$imageH)/100;
	$params->frameW = floor(100*100*($imageW+$border->left+$border->right)/$imageW)/100;
	$params->frameH = floor(100*100*($imageH+$border->top+$border->bottom)/$imageH)/100;
	
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bg.png', 'filters' => array('name'=>'resize', 'width' => $ContaienerW, 'height' => $ContaienerH, 'margins' => $border) ) );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName . '/style-frame.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/next_photo.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/prev_photo.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/play.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/pause.png' ) );

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bullet.png' ) );

if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/triangle-'.$params->TooltipPos.'.png', 'dest' => '$ImgPath$triangle.png') );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}

// call this function at the end of each template
finalize();	
?>