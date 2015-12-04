<?php
$params->AppName = 'WOW Slider';
$params->AppVersion = '7.7';
$params->ImageTemplateName = $ws_template;
$params->TemplateName = $ws_template;
$params->addCss = '';
$params->GallerySuffix = '-' . $ws_id;	
$params->ImageCount = ( isset($_POST['wsi_id']) ? count($_POST['wsi_id']) : 0 ); // 이미지 갯수
$params->JSONList = 0;

$params->AutoPlay = ( $ws_auto_play == 'Y' );	// 자동시작
$params->Preloader = ( $ws_preloader == 'Y' );	// 이미지 로딩 출력
$params->OrderRandom = ( $ws_random_order == 'Y' );	// 랜덤 출력

$params->StopOnHover = ( $ws_pause_on_mouseover == 'Y' );	// 마우스 오버 정지
$params->OneLoop = ( $ws_stop_slideshow == 'Y' );	// 반복재생
$params->PlayPause = ( $ws_pause_play_button == 'Y' ); // 일시 정지 / 재생 버튼
$params->Controls = ( $ws_show_prev_next_buttons == 'Y' ); // 좌/우 버튼
$params->SwipeSupport = ( $ws_swipe_support == 'Y' ); // 스와이프 지원
$params->FullScreen = ( $ws_full_screen_button == 'Y' );			// 전체 화면 버튼

$params->AutoPlayVideo = 'false';
$params->ShowControls = ( $ws_show_controls_mouseover == 'Y' ); 	// 마우스 오버시
$params->noFrame = ( $ws_noframe == 'Y' );							// 테두리 제거

$params->Captions = ( $ws_captions == 'Y' );						// 타이틀 노출
$params->CaptionsEffect = $ws_captions_effect;			// 타이틀 효과

$params->ShowBullets =  ( $ws_show_bullet == 'Y');
$params->ShowTooltips = ( $ws_bullet_thumb_prev == 'Y');
$params->TooltipPos = $ws_bullet_align;					// bullets 위치

$params->Thumbnails = ( $ws_bullet_type == 'filmstrip' ); 	// 썸네일 미리보기
$params->ThumbAlign = $ws_filmstrip_align; 					// 썸네일 위치

$params->ThumbWidth = $ws_thumb_width;					// 썸네일 넓이
$params->ThumbHeight = $ws_thumb_height;				// 썸네일 높이

$params->ImageWidth = $ws_image_width;						// 슬라이드 넓이
$params->ImageHeight = $ws_image_height;					// 슬라이드 폭이
$params->SizeStyle = $ws_size_style;						// 슬라이드 사이즈 스타일

$params->TemplateColor = $ws_font_color;					// 폰트 스타일
$params->TemplateFont = $ws_font_family;					// 폰트 스타일
$params->FontSize = $ws_font_size;							// 폰트 사이즈

$params->OnBeforeFunc = $ws_onbefore_func;					// 이미지 초기 설정 함수
$params->OnStepFunc = $ws_onstep_func;						// 이미지 변경 시 함수 설정
$params->OverrideCss = $ws_override_css;					// 추가/변경 CSS

$ws_image_effect = ( isset($ws_image_effect) ? $ws_image_effect : 'blinds');
$params->ImageEffect = (is_array($ws_image_effect) ? implode(',',$ws_image_effect) : $ws_image_effect ); // 이미지 효과
$params->SlideshowDuration = (int)$ws_duration;				// 이동시간
$params->SlideshowDelay = (int)$ws_delay;					// 대기시간

$backMargins = (object)array( 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0 );
$params->backMarginsLeft = 0;
$params->backMarginsTop = 0;
$params->backMarginsRight = 0;
$params->backMarginsBottom = 0;
$params->Border = 'none';
$params->addCss=''; // additional css params (will added to begin of css file)

$params->prevCaption = '';
$params->nextCaption = '';

$imageW = $params->ImageWidth*1;
$imageH = $params->ImageHeight*1;

/*
$ThumbWidth = $ws_thumbnail_width*1;
$ThumbHeight = $ws_thumbnail_height*1;
*/

if ($imageW==0) {
	$imageW = 640;
	$params->ThumbWidth = 120;
}
if ($imageH==0) {
	$imageH = 480;
	$params->ThumbHeight = 90;
}

$params->ImageWidth = $imageW;
$params->ImageHeight = $imageH;

// use in iframe
$params->fullHeight = $imageH;
$params->fullWidth = $imageW;

if ($ThumbWidth==0)
	$ThumbWidth = floor($ThumbHeight*$imageW/$imageH);
if ($ThumbHeight==0)
	$ThumbHeight = floor($ThumbWidth*$imageH/$imageW);
	
// prepare font family
$params->fontFamily = 'Arial';
if($params->TemplateFont && $fonts[$params->TemplateFont]) {
	$params->fontFamily = $fonts[$params->TemplateFont]->family ? $fonts[$params->TemplateFont]->family : $params->fontFamily;
	
	// import google font
	if($fonts[$params->TemplateFont]->import) {
		$params->addCss .= '@import url(' . $fonts[$params->TemplateFont]->import . ');';
	}
}

// prepare font size
$params->TemplateFontSize = 12;
if( empty( $paramss->FontSize) ) {
	$params->TemplateFontSize = $params->FontSize;
}
$params->TemplateFontSize = ($params->TemplateFontSize / 10) . 'em';


$params->bodyMargin = 'auto';
$params->contDisplay = 'table';
$params->contMaxWidth = $params->ImageWidth . 'px';
$params->contMaxHeight = $params->ImageHeight . 'px';

// full width/page params
if($params->SizeStyle > 1) {
	$params->bodyMargin = 0;
	$params->contMaxWidth = '100%';

	// when full page
	if($params->SizeStyle == 3) {
		$params->contMaxHeight = 'none';
		$params->contDisplay = 'block';
		$params->noFrame = 1;
	}
}

$params->contImageHeight = $params->contMaxHeight;

//$params->ImageFillColor = $params->ImageFillColor || '#FFFFFF';
$params->TooltipPos = ( $params->TooltipPos ? $params->TooltipPos : 'top' );
if ($params->OrderRandom)  {
	$onBeforeStep = ( $params->OnBeforeFunc ? $params->OnBeforeFunc . '(i,c);' : '' );
	$params->OnBeforeStep = "function(i,c){ {$onBeforeStep} return (i+1 + Math.floor((c-1)*Math.random()))}";
} else {
	$params->OnBeforeStep = ( $params->OnBeforeFunc ? $params->OnBeforeFunc : 0 );
}

if ( $params->OnStepFunc ) $params->OnStep = $params->OnStepFunc;
else $params->OnStep = 0;

$preloader = $params->Preloader || $params->ImageCount>100;

$files = array();
array_push($files, (object)array( 'src' => 'common/common.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );

if($params->FullScreen) {
	array_push($files, (object)array( 'src' => 'common/fullscreen/fullscreen.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	array_push($files, (object)array( 'src' => 'common/fullscreen/fullscreen.eot', 'dest' => '$CssPath$fullscreen.eot' ) );
	array_push($files, (object)array( 'src' => 'common/fullscreen/fullscreen.svg', 'dest' => '$CssPath$fullscreen.svg' ) );
	array_push($files, (object)array( 'src' => 'common/fullscreen/fullscreen.ttf', 'dest' => '$CssPath$fullscreen.ttf' ) );
	array_push($files, (object)array( 'src' => 'common/fullscreen/fullscreen.woff', 'dest' => '$CssPath$fullscreen.woff' ) );
}

array_push($files, (object)array( 'src' => 'backgnd/' . $params->TemplateName . '/style.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
array_push($files, (object)array( 'src' => 'backgnd/' . $params->TemplateName . '/style-' . $params->TooltipPos . '.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
array_push($files, (object)array( 'src' => 'backgnd/' . $params->TemplateName . '/style-descr-' . ( $params->CaptionsEffect=='move'||$params->CaptionsEffect=='parallax'||$params->CaptionsEffect=='traces'?'separate.css':'default.css'), 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );


if ($params->Thumbnails){
	array_push($files, (object)array( 'src' => 'common/style-thumb.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	array_push($files, (object)array( 'src' => 'common/style-thumb-' . $params->ThumbAlign . '.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	array_push($files, (object)array( 'src' => 'backgnd/' . $params->TemplateName . '/style-thumb.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );	
}

// show control styles
if ($params->ShowControls) {
	array_push($files, (object)array( 'src' => 'backgnd/' . $params->TemplateName . '/style-controls-on-hover.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );	
}

// css3 effects
// reinit params
if ($params->AutoPlay){
	$params->FullDur = ($params->ImageCount * ((float)$params->SlideshowDuration + (float)$params->SlideshowDelay))/10;// in sec

	$params->keyframes = '';
	for ( $i = 0; $i < $params->ImageCount; $i++){
		$params->keyframes .=  round(( $params->SlideshowDuration*$i + $params->SlideshowDelay*$i )*1000/$params->FullDur)/100  . "%{left:-" . ($i*100) . "%} " . round(($params->SlideshowDuration*$i + $params->SlideshowDelay*($i+1))*1000/$params->FullDur)/100 . "%{left:-" . ($i*100) . "%} ";
		
	}
	if(!$preloader) 
	{
		array_push($files, (object)array( 'src' => 'common/noscript.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	}
}

$scriptOut = '$JsPath$script.js';
$wowsliderJs='$JsPath$wowslider.js';

// copy engine
array_push($files, (object)array( 'src' => 'common/js/wowslider.js', 'dest' => $wowsliderJs, 'filters' => array('params') ) );

// extensions
array_push($files, (object)array( 'src' => 'common/js/wowslider.mod.js', 'dest' => '$JsPath$wowslider.mod.js' ) );
array_push($files, (object)array( 'src' => 'common/mod/style.mod.css', 'dest' => '$CssPath$style.mod.css', 'filters' => array('params') ) );

// animation core
array_push($files, (object)array( 'src' => 'common/js/wowslider.animate.js', 'dest' => $wowsliderJs, 'filters' => array('params') ) );

// preloader
if ($preloader){
	array_push($files, (object)array( 'src' => 'common/loading.gif', 'dest' => '$ImgPath$loading.gif' ) );
	$params->loadingMargin = (($params->ThumbHeight-11)>>1) . 'px ' . (($params->ThumbWidth-43)>>1) . 'px';  //43*11 - size of loading.gif
	array_push($files, (object)array( 'src' => 'common/loading.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
}

// caption effects
if ($params->Captions && $params->CaptionsEffect) {
	array_push($files, (object)array( 'src' => 'captions/' . $params->CaptionsEffect . '.js', 'dest' => $wowsliderJs ) );
}


// add effects and additional scripts for some effects
$effects = ( empty($params->ImageEffect) ? 'blinds' : explode( ',' , $params->ImageEffect ) );
for ( $ei = 0; $ei < count($effects); $ei++ )
{
	$effect = $effects[$ei];
	if ($effect == 'squares')
		array_push($files, (object)array( 'src' => 'effects/squares/coin-slider.js', 'dest' => $scriptOut ) );
	if ($effect == 'flip')
		array_push($files, (object)array( 'src' => 'effects/flip/jquery.2dtransform.js', 'dest' => $scriptOut ) );
	if($effect != 'basic')
		array_push($files, (object)array( 'src' => 'effects/' . $effect . '/script.js', 'dest' => $scriptOut, 'filters' => array('params') ) );
}

array_push($files, (object)array( 'src' => 'common/js/script_start.js', 'dest' => $scriptOut, 'filters' => array('params') ) );


// this function will called after template script
$border = (object)array( 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0 );
$thumbs = (object)array( 'margin' => 0, 'padding' => 0);

function parseInt($value)
{
	return (int)$value;
}
function toFixed($number, $decimals) {
  return number_format($number, $decimals, ".", "");
}
function finalize(){
	global $params, $files, $thumbs, $border;
	// correct margin with frame border
	if (!(int)$params->noFrame){
		$params->backMarginsTop  += $border->top;
		$params->backMarginsBottom += $border->bottom;
	}
	
	//correct margin with thumbnails height
	if ($params->Thumbnails){
		$thumbs->margin = $thumbs->margin ? $thumbs->margin : 0;
		$thumbs->padding = $thumbs->padding ? $thumbs->padding : 0;
		$count = (int)$params->ImageCount;
		$horizontal = $params->ThumbAlign=="top" || $params->ThumbAlign=="bottom";

		// in pixels
		$thumbFullWidth = ($thumbs->margin + $thumbs->padding) * 2 + (int)$params->ThumbWidth;
		$thumbFullHeight = ($thumbs->margin + $thumbs->padding) * 2 + (int)$params->ThumbHeight;
		
		// container width in pixels
		$params->thumbParentWidth = ceil($thumbFullWidth * ($horizontal?$count:1));
		
		// thumb padding, margin in percent
		$params->thumbMargin = toFixed(100 * $thumbs->margin / $params->thumbParentWidth, 2);
		$params->thumbPadding = toFixed(100 * $thumbs->padding / $params->thumbParentWidth, 2);

		$params->thumbOnePercent = 100 / ($horizontal?$count:1) - 2 * $params->thumbMargin - 2 * $params->thumbPadding;

	
		$params->thumbFullWidthEm  = ($thumbFullWidth + 15) / 10;
		$params->thumbFullHeightEm = ($thumbFullHeight + 15) / 10;
		
		// max width in left/right filmstrip cont
		$params->thumbContMaxWidth = 2 * $thumbs->margin + 2 * $thumbs->padding + $thumbFullWidth;
		
		// offset
		$params->thumbMarginWidthEm   = ($thumbFullWidth + 15 + $border->left) / 10;
		$params->thumbMarginHeightEm   = ($thumbFullHeight + 15 + $border->top) / 10;

		$params->thumbContWidthEm  = $params->thumbMarginWidthEm*$count;


		if ($params->contMaxHeight != 'none' && $horizontal) {
			$params->contMaxHeight = (float)$params->contMaxHeight + $thumbFullHeight + 'px';
		}

		if($params->SizeStyle <= 1 && !horizontal) {
			$params->contMaxWidth = (float)$params->contMaxWidth + $params->thumbContMaxWidth + 'px';
		}
	}
	
	$params->bulframeImageWidth = 100/(int)$params->ImageCount;
	
	$params->fullHeight += max($params->backMarginsBottom, max(-($params->BulletsBottom ? $params->BulletsBottom : 0), ($params->ShadowH ? $params->ShadowH : 0) )) + $params->backMarginsTop;
	$params->fullWidth  += max(max((!(int)$params->noFrame ? $border->right:0) + (!(int)$params->noFrame? $border->left:0), ($params->addWidth ? $params->addWidth : 0) ), ($params->ShadowW?$params->ShadowW:0));
	if (preg_match('/left|right/', $params->ThumbAlign))
		$params->fullWidth  += $params->thumbMarginWidth;
	
	$params->PageBgColor = $params->PageBgColor ? $params->PageBgColor : "transparent";

	// responsive code
	array_push($files, (object)array( 'src' => 'common/style-responsive.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
	array_push($files, (object)array( 'src' => 'common/style-override.css', 'dest' => '$CssPath$style.css', 'filters' => array('params') ) );
}

?>