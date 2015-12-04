<?php
/* config.js */

$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin' => 3, 'padding' => 5);
if (!parseInt($params->noFrame)){
	// frame border+shadow
	$border = (object)array( 'top'=> 5, 'right'=> 5, 'bottom'=> 39, 'left'=> 5 );
	$ContaienerW = $imageW + $border->left + $border->right;
	$ContaienerH = $imageH + $border->top + $border->bottom;
	$params->frameL = round(100*100*$border->left/$imageW)/100;
	$params->frameT = round(100*100*$border->top/$imageH)/100;
	$params->frameW = floor(100*100*($imageW+$border->left+$border->right)/$imageW)/100;
	$params->frameH = floor(100*100*($imageH+$border->top+$border->bottom)/$imageH)/100;
	
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bg.png', 'filters' => array('name'=>'resize', 'width' => $ContaienerW, 'height' => $ContaienerH, 'margins' => $border) ) );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName . '/style-shadow.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
	
	$params->BulletsBottom = -24;
	$params->backMarginsTop    += $border->top;
}
else{
	$params->BulletsBottom = 5;
}

$params->decorW = $params->ImageWidth - 8*2;
$params->decorH = $params->ImageHeight - 8*2;

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bullet.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/arrows.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/play.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/pause.png' ) );


if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/triangle-'.$params->TooltipPos.'.png', 'dest' => '$ImgPath$triangle.png') );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}

$params->addWidth = 60; // arrow width

// call this function at the end of each template
finalize();
?>