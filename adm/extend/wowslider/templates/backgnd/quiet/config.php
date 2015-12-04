<?php
/* config.js */

$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin' => 3, 'padding' => 5);
if (!parseInt($params->noFrame)){
	// frame border+shadow
	$params->frameL = 0;
	$params->frameT = 100;
	$params->frameW = 100;
	$params->frameH = 20;

	// when thumbnails - fix shadow
	if ($params->Thumbnails && ($params->ThumbAlign=="top" || $params->ThumbAlign=="bottom")){
		$thumbFullHeight = ($thumbs->margin + $thumbs->padding) * 2 + parseInt($params->ThumbHeight) + 15; // 15 is magic number :)
		$thumbFullHeightPercent = 100 * $thumbFullHeight / $imageH;
		$params->frameT -= $thumbFullHeightPercent;
	}
	
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/shadow.png', 'filters' => array('name'=> 'resize', 'width'=> $imageW, 'height'=> $imageH*0.2, 'margins'=> border ) ) );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-shadow.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
	
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

// call this function at the end of each template
finalize();	
?>