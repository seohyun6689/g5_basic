<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#f0f0f0";
$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin' => 3, 'padding' => 4);
if (!parseInt($params->noFrame)){
    // frame border+shadow
    $params->Border =  "3px solid #FFFFFF";
    array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-frame.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}

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