<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#d7d7d7";

$slideshow_css = '$CssPath$style.css';
$thumbs = (object)array('margin' => 3, 'padding' => 1);

$params->addCss .= '@font-face {' . PHP_EOL
. '	font-family: "ws-ctrl-twist";' . PHP_EOL
. '	src: url("ws-ctrl-twist.eot");' . PHP_EOL
. '	src: url("ws-ctrl-twist.eot#iefix") format("embedded-opentype"),' . PHP_EOL
. '			url("ws-ctrl-twist.woff") format("woff"),' . PHP_EOL
. '			url("ws-ctrl-twist.ttf") format("truetype"),' . PHP_EOL
. '			url("ws-ctrl-twist.svg") format("svg");' . PHP_EOL
. '	font-weight: normal;' . PHP_EOL
. '	font-style: normal;' . PHP_EOL
. '}' . PHP_EOL;

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-twist.eot', 'dest' => '$CssPath$ws-ctrl-twist.eot' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-twist.svg', 'dest' => '$CssPath$ws-ctrl-twist.svg' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-twist.ttf', 'dest' => '$CssPath$ws-ctrl-twist.ttf' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-twist.woff', 'dest' => '$CssPath$ws-ctrl-twist.woff' ) );


if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}


// call this function at the end of each template
finalize();
?>