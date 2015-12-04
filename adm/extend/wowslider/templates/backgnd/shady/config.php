<?php
/* config.js */
$params->ContaienerW = $imageW + $backMargins->left + $backMargins->right;
$params->ContaienerH = $imageH + $backMargins->bottom;

$thumbs = (object)array('margin' => 3, 'padding' => 5);
if(!parseInt($params->noFrame)){
	$params->ShadowW = round($params->ContaienerW*1.4);
	$params->ShadowH = round($params->ContaienerH/2.12);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName . '/style-shadow.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/shadow.png', 'filters' => array('name'=> 'resize', 'width'=> $params->ShadowW, 'height'=> $params->ShadowH) ) );
}

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bullet.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/arrows.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/play.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/pause.png' ) );


if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/triangle-'.$params->TooltipPos.'.png', 'dest' => '$ImgPath$triangle.png') );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
}

// call this function at the end of each template
finalize();
?>