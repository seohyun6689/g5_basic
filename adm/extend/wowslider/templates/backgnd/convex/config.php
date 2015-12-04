<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#d7d7d7";

$slideshow_css = '$CssPath$style.css';
$thumbs = (object)array('margin' => 3, 'padding' => 1);

$params->addCss .= '@font-face {' . PHP_EOL
. '	font-family: "ws-ctrl-convex";' . PHP_EOL
. '	src: url("ws-ctrl-convex.eot");' . PHP_EOL
. '	src: url("ws-ctrl-convex.eot#iefix") format("embedded-opentype"),' . PHP_EOL
. '			url("ws-ctrl-convex.woff") format("woff"),' . PHP_EOL
. '			url("ws-ctrl-convex.ttf") format("truetype"),' . PHP_EOL
. '			url("ws-ctrl-convex.svg") format("svg");' . PHP_EOL
. '	font-weight: normal;' . PHP_EOL
. '	font-style: normal;' . PHP_EOL
. '}' . PHP_EOL;

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-convex.eot', 'dest' => '$CssPath$ws-ctrl-convex.eot' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-convex.svg', 'dest' => '$CssPath$ws-ctrl-convex.svg' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-convex.ttf', 'dest' => '$CssPath$ws-ctrl-convex.ttf' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-convex.woff', 'dest' => '$CssPath$ws-ctrl-convex.woff' ) );

if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}


// call this function at the end of each template
finalize();	
?>