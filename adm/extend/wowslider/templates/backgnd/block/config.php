<?php
/* config.js */
$params->prevCaption = 'prev';
$params->nextCaption = 'next';

$slideshow_css = '$CssPath$style.css';

$thumbs = (object)array('margin' => 3, 'padding' => 2);
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/play.png', 'dest' => '$ImgPath$play.png' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/pause.png', 'dest' => '$ImgPath$pause.png' ) );


if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}

// call this function at the end of each template
finalize();	
?>