<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#d7d7d7";

$params->circleMaxWidth = 0.7;
if($params->ImageWidth > 0 && $params->ImageWidth < 300) {
	$params->circleMaxWidth = 0.5;
}
if($params->ImageWidth >= 500 && $params->ImageWidth < 700) {
	$params->circleMaxWidth = 0.8;
}
if($params->ImageWidth >= 700 && $params->ImageWidth < 1300) {
	$params->circleMaxWidth = 0.9;
}
if($params->ImageWidth >= 1300) {
	$params->circleMaxWidth = 0.95;
}

if($params->ImageWidth > $params->ImageHeight) {
	$params->circleHeight = 0.7 * $params->ImageHeight / 10;
	$params->circleWidth = $params->circleMaxWidth * $params->ImageWidth / 10;
	$params->circleSizeShadow = $params->ImageWidth / 10;
} else {
	$params->circleHeight = 0.7 * $params->ImageWidth / 10;
	$params->circleWidth = $params->circleHeight;
	$params->circleSizeShadow = $params->ImageHeight / 10;
}
$params->circleHeightHalf = $params->circleHeight / 2;
$params->circleWidthHalf = $params->circleWidth / 2;

$params->arrowsPos = $params->circleHeightHalf / 3.9;


$slideshow_css = '$CssPath$style.css';
$thumbs = (object)array('margin' => 3, 'padding' => 1);

$params->addCss .= '@font-face {' . PHP_EOL
. '	font-family: "cs-ctrl-fill";' . PHP_EOL
. '	src: url("cs-ctrl-fill.eot");' . PHP_EOL
. '	src: url("cs-ctrl-fill.eot#iefix") format("embedded-opentype"),' . PHP_EOL
. '			url("cs-ctrl-fill.woff") format("woff"),' . PHP_EOL
. '			url("cs-ctrl-fill.ttf") format("truetype"),' . PHP_EOL
. '			url("cs-ctrl-fill.svg") format("svg");' . PHP_EOL
. '	font-weight: normal;' . PHP_EOL
. '	font-style: normal;' . PHP_EOL
. '}' . PHP_EOL;

array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/cs-ctrl-fill.eot', 'dest' => '$CssPath$cs-ctrl-fill.eot' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/cs-ctrl-fill.svg', 'dest' => '$CssPath$cs-ctrl-fill.svg' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/cs-ctrl-fill.ttf', 'dest' => '$CssPath$cs-ctrl-fill.ttf' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/cs-ctrl-fill.woff', 'dest' => '$CssPath$cs-ctrl-fill.woff' ) );


if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}

// call this function at the end of each template
finalize();	
?>