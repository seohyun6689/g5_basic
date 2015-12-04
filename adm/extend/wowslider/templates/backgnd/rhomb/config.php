<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#d7d7d7";

$slideshow_css = '$CssPath$style.css';
$thumbs = (object)array('margin' => 3, 'padding' => 2);

$params->addCss .= '@font-face {' . PHP_EOL
. '	font-family: "ws-ctrl-rhomb";' . PHP_EOL
. '	src: url("ws-ctrl-rhomb.eot");' . PHP_EOL
. '	src: url("ws-ctrl-rhomb.eot#iefix") format("embedded-opentype"),' . PHP_EOL
. '			url("ws-ctrl-rhomb.woff") format("woff"),' . PHP_EOL
. '			url("ws-ctrl-rhomb.ttf") format("truetype"),' . PHP_EOL
. '			url("ws-ctrl-rhomb.svg") format("svg");' . PHP_EOL
. '	font-weight: normal;' . PHP_EOL
. '	font-style: normal;' . PHP_EOL
. '}' . PHP_EOL;

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-rhomb.eot', 'dest' => '$CssPath$ws-ctrl-rhomb.eot' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-rhomb.svg', 'dest' => '$CssPath$ws-ctrl-rhomb.svg' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-rhomb.ttf', 'dest' => '$CssPath$ws-ctrl-rhomb.ttf' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-rhomb.woff', 'dest' => '$CssPath$ws-ctrl-rhomb.woff' ) );


if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}


// call this function at the end of each template
finalize();
?>