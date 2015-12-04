<?php
/* config.js */
$params->ContaienerW = $imageW + $backMargins->left + $backMargins->right;

$thumbs = (object)array('margin' => 3, 'padding' => 5);
if(!parseInt($params->noFrame)){
	$params->ShadowH = round($params->ContaienerW*0.031);
	$params->pShadowH = round(100*$params->ShadowH/$params->ImageHeight);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-shadow.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/shadow.png', 'filters' => array('name'=> 'resize', 'width'=> $params->ImageWidth, 'height'=> $params->ShadowH ) ) );
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

$params->addWidth = 16; // arrow width

// call this function at the end of each template
finalize();	
?>