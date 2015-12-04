<?php 
/* config.js */
$params->ContaienerW = $imageW + $backMargins->left + $backMargins->right;
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#d7d7d7";
$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin' => 3, 'padding' => 4);
$border = (object)array( 'top' => 9, 'right' => 9, 'bottom' => 9, 'left' => 9 );

if (!parseInt($params->noFrame)){
    // frame border+shadow
    $params->Border =  "9px solid #FFFFFF";
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