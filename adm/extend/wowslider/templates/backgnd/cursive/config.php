<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#d7d7d7";

$slideshow_css = '$CssPath$style.css';
$thumbs = (object)array('margin' => 3, 'padding' => 1);

$params->addCss .= '@font-face {' . PHP_EOL
. '	font-family: "ws-ctrl-cursive";' . PHP_EOL
. '	src: url("ws-ctrl-cursive.eot");' . PHP_EOL
. '	src: url("ws-ctrl-cursive.eot#iefix") format("embedded-opentype"),' . PHP_EOL
. '			url("ws-ctrl-cursive.woff") format("woff"),' . PHP_EOL
. '			url("ws-ctrl-cursive.ttf") format("truetype"),' . PHP_EOL
. '			url("ws-ctrl-cursive.svg") format("svg");' . PHP_EOL
. '	font-weight: normal;' . PHP_EOL
. '	font-style: normal;' . PHP_EOL
. '}' . PHP_EOL;

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-cursive.eot', 'dest' => '$CssPath$ws-ctrl-cursive.eot' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-cursive.svg', 'dest' => '$CssPath$ws-ctrl-cursive.svg' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-cursive.ttf', 'dest' => '$CssPath$ws-ctrl-cursive.ttf' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-cursive.woff', 'dest' => '$CssPath$ws-ctrl-cursive.woff' ) );

if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}

// call this function at the end of each template
finalize();	
?>