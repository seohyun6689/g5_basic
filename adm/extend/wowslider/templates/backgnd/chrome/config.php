<?php
/* config.js */
$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin'=> 3, 'padding' => 3);
if (!parseInt($params->noFrame)){
	// frame border+shadow
	$border = (object)array( 'top'=> 25, 'right'=> 25, 'bottom'=> 26, 'left'=> 25 );
	
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-shadow.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	$params->Border="solid 1px white";
}

$params->ThumbWidthHalf = round($params->ThumbWidth/2);

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bullet.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/bullet.gif' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/arrows.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/arrows.gif' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/play.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/pause.png' ) );


if ($params->ShowTooltips){
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/triangle-'.$params->TooltipPos.'.png', 'dest' => '$ImgPath$triangle.png') );
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}


// call this function at the end of each template
finalize();
?>