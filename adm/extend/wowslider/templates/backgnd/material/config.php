<?php
/* config.js */
$params->PageBgColor = $params->PageBgColor?$params->PageBgColor:"#fff";

/* Color prepare */
// $params->TemplateColor2 = shade(''+$params->TemplateColor, -0.18);
// $params->TemplateColor3 = shade(''+$params->TemplateColor, -0.25);

$slideshow_css = '$CssPath$style.css';
$thumbs = (object)array('margin' => 7, 'padding' => 6);

$params->addCss .= '@font-face {' . PHP_EOL
. '	font-family: "ws-ctrl-material";' . PHP_EOL
. '	src: url("ws-ctrl-material.eot");' . PHP_EOL
. '	src: url("ws-ctrl-material.eot#iefix") format("embedded-opentype"),' . PHP_EOL
. '			url("ws-ctrl-material.woff") format("woff"),' . PHP_EOL
. '			url("ws-ctrl-material.ttf") format("truetype"),' . PHP_EOL
. '			url("ws-ctrl-material.svg") format("svg");' . PHP_EOL
. '	font-weight: normal;' . PHP_EOL
. '	font-style: normal;' . PHP_EOL
. '}' . PHP_EOL;


array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-material.eot', 'dest' => '$CssPath$ws-ctrl-material.eot' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-material.svg', 'dest' => '$CssPath$ws-ctrl-material.svg' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-material.ttf', 'dest' => '$CssPath$ws-ctrl-material.ttf' ) );
array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/fonts/ws-ctrl-material.woff', 'dest' => '$CssPath$ws-ctrl-material.woff' ) );

if ($params->ShowTooltips){
	$params->ThumbWidthHalf = round($params->ThumbWidth/2);
	array_push($files, (object)array( 'src' => 'backgnd/'.$params->TemplateName.'/style-tooltip.css', 'dest' => $slideshow_css, 'filters' => array('params') ) );
}


// call this function at the end of each template
finalize();
?>