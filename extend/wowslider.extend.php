<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//------------------------------------------------------------------------------
// 와우 슬라이드 상수 모음 시작
//------------------------------------------------------------------------------

define('G5_WS_DIR',             'wowslider');
define('G5_WS_PATH',            G5_PLUGIN_PATH.'/'.G5_WS_DIR);
define('G5_WS_URL',             G5_PLUGIN_URL.'/'.G5_WS_DIR);

define('G5_WS_ADMIN_DIR',        'wowslider');
define('G5_WS_ADMIN_PATH',       G5_ADMIN_PATH.'/extend/'.G5_WS_ADMIN_DIR);
define('G5_WS_ADMIN_URL',        G5_ADMIN_URL.'/extend/'.G5_WS_ADMIN_DIR);
define('G5_WS_TEMPLATE_PATH',       G5_ADMIN_PATH.'/extend/'.G5_WS_ADMIN_DIR . '/templates');

define('G5_WS_DATA_PATH',            G5_DATA_PATH . '/_wowslider_');
define('G5_WS_DATA_URL',             G5_DATA_URL.'/_wowslider_');

define('G5_WS_IMAGES_PATH',             G5_WS_DATA_PATH . '/%s/images');
define('G5_WS_ENGINE_PATH',             G5_WS_DATA_PATH . '/%s/engine');

define('G5_WS_IMAGES_URL',             G5_WS_DATA_URL . '/%s/images');
define('G5_WS_ENGINE_URL',             G5_WS_DATA_URL . '/%s/engine');

$g5['ws_master_table'] = 'ws_master';
$g5['ws_images_table'] = 'ws_images';

if ( is_file( G5_WS_PATH . '/wowslider.lib.php' ) && file_exists(G5_WS_PATH . '/wowslider.lib.php') )
{
	$ws_master_sql = 'CREATE TABLE IF NOT EXISTS `' . $g5['ws_master_table'] . '` (
			`ws_id` varchar(20) NOT NULL comment "슬라이드ID",
			`ws_name` varchar(255) not null default "" comment "슬라이드제목",
			`ws_auto_play` char(1) not null default "" comment "자동 재생",
			`ws_pause_on_mouseover` char(1) not null default "" comment "마우스 오버 일시중지",
			`ws_stop_slideshow` char(1) not null default "" comment "반복 재생 없음",
			`ws_random_order` char(1) not null default "" comment "임의의 순서로",
			`ws_pause_play_button` char(1) not null default "" comment "일시 정지 / 재생 버튼",
			`ws_full_screen_button` char(1) not null default "" comment "전체 화면 버튼",
			`ws_swipe_support` char(1) not null default "" comment "스와이프 지원",
			`ws_preloader` char(1) not null default "" comment "로딩이미지 지원",
			`ws_show_controls_mouseover` char(1) not null default "" comment "마우스 오버시 컨트롤 출력",
			`ws_show_prev_next_buttons` char(1) not null default "Y" comment "이전/다음 버튼",
			`ws_captions` char(1) not null default "" comment "타이틀",
			`ws_captions_effect` varchar(20) not null default "None" comment "타이틀 효과",
			`ws_noframe` char(1) not null default "Y" comment "이미지 배경 사용 안함",
			`ws_show_bullet` char(1) not null default "" comment "컨트롤러 노출",
			`ws_bullet_type` varchar(20) not null default "bullet" comment "컨트롤러 형식",
			`ws_bullet_align` varchar(20) not null default "bottom" comment "단추형 위치",
			`ws_bullet_thumb_prev` char(1) not null default "" comment "단추형 썸네일",
			`ws_filmstrip_align` varchar(20) not null default "" comment "썸네일형 위치",
			`ws_thumb_size` varchar(20) not null default "None" comment "컨트롤러 썸네일 사이즈",
			`ws_thumb_width` int(11) not null default 0 comment "컨트롤러 썸네일 넓이",
			`ws_thumb_height` int(11) not null default 0 comment "컨트롤러 썸네일 높이",
			`ws_image_size` varchar(20) not null default "" comment "슬라이드 이미지 사이즈",
			`ws_image_width` int(11) not null default 0 comment "슬라이드 이미지 넓이",
			`ws_image_height` int(11) not null default 0 comment "슬라이드 이미지 높이",
			`ws_size_style` varchar(50) not null default "boxed" comment "슬라이드 레이아웃",
			`ws_font_color` varchar(20) not null default "#000000" comment "타이틀 폰트 색상",
			`ws_font_family` varchar(50) not null default "Arial" comment "타이틀 폰트 종류",
			`ws_font_size` int(11) not null default 12 comment "타이틀 폰트 사이즈",
			`ws_template` varchar(50) not null default "basic" comment "슬라이드 테마",
			`ws_multiple_effects` char(1) not null default "" comment "다중효과",
			`ws_image_effect` varchar(255) not null default "basic" comment "슬라이드 효과",
			`ws_delay` int(11) not null default 0 comment "대기시간",
			`ws_duration` int(11) not null default 0 comment "이동시간",
			`ws_onbefore_func` varchar(255) not null default "",
			`ws_onstep_func` varchar(255) not null default "",
			`ws_override_css` text not null default "",
			PRIMARY KEY ( `ws_id` )
		);';
	sql_query( $ws_master_sql );
	$ws_items_sql = 'CREATE TABLE IF NOT EXISTS `' . $g5['ws_images_table'] . '` (
					`wsi_id` int(11) not null auto_increment,
					`ws_id` varchar(20) not null default "",
					`wsi_title` varchar(100) not null default "",
					`wsi_link` varchar(255) not null default "",
					`wsi_link_target` char(1) not null default "",
					`wsi_file` varchar(255) not null default "",
					`wsi_source` varchar(255) not null default "",
					`wsi_disable` varchar(255) not null default "",
					`wsi_sortable` int(11) not null default 0,
					PRIMARY KEY ( `wsi_id` ),
					INDEX `ws_id` (`ws_id`),
					INDEX `wsi_sortable` (`wsi_sortable`)
					);';
	sql_query( $ws_items_sql );

	$fonts_json = '{
		"Arial": {
			"family": "Arial, Helvetica, sans-serif"
		},
		"Franklin Gothic Medium": {
			"family": "Franklin Gothic Medium, sans-serif"
		},
		"Halvetica": {
			"family": "Helvetica, Arial, Verdana, sans-serif"
		},
		"Helvetica Neue": {
			"family": "\'Helvetica Neue\', Helvetica, Arial, sans-serif"
		},
		"Lucida Grande": {
			"family": "\'Lucida Grande\', \'Lucida Sans Unicode\', Helvetica, Arial, Verdana, sans-serif"
		},
		"Tahoma": {
			"family": "Tahoma, Arial, Helvetica"
		},
		"Anton": {
			"family": "\'Anton\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Anton&subset=latin,latin-ext",
			"file"  : "Anton.ttf"
		},
		"Archivo Narrow": {
			"family": "\'Archivo Narrow\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Archivo+Narrow&subset=latin,latin-ext",
			"file"  : "ArchivoNarrow-Regular.ttf"
		},
		"Arimo": {
			"family": "\'Arimo\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Arimo&subset=latin,cyrillic,latin-ext",
			"file"  : "Arimo-Regular.ttf"
		},
		"Averia Sans Libre": {
			"family": "\'Averia Sans Libre\', cursive",
			"import": "https://fonts.googleapis.com/css?family=Averia+Sans+Libre",
			"file"  : "AveriaSansLibre-Regular.ttf"
		},
		"Bitter": {
			"family": "\'Bitter\', serif",
			"import": "http://fonts.googleapis.com/css?family=Bitter",
			"file"  : "Bitter-Regular.ttf"
		},
		"Cuprum": {
			"family": "\'Cuprum\', Impact, Charcoal, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Cuprum&subset=latin,latin-ext",
			"file"  : "Cuprum-Regular.ttf"
		},
		"Didact Gothic": {
			"family": "\'Didact Gothic\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Didact+Gothic&subset=latin,cyrillic,latin-ext",
			"file"  : "DidactGothic.ttf"
		},
		"Donegal One": {
			"family": "\'Donegal One\', Georgia, serif",
			"import": "https://fonts.googleapis.com/css?family=Donegal+One&subset=latin,latin-ext",
			"file"  : "DonegalOne-Regular.ttf"
		},
		"Dosis": {
			"family": "\'Dosis\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Dosis:600&subset=latin,latin-ext",
			"file"  : "Dosis-Regular.ttf"
		},
		"EB Garamond": {
			"family": "\'EB Garamond\', Georgia,serif",
			"import": "https://fonts.googleapis.com/css?family=EB+Garamond&subset=latin,cyrillic,latin-ext",
			"file"  : "EBGaramond-Regular.ttf"
		},
		"Economica": {
			"family": "\'Economica\', Trebuchet MS, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Economica&subset=latin,latin-ext",
			"file"  : "Economica-Regular.ttf"
		},
		"Exo 2": {
			"family": "\'Exo 2\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Exo+2&subset=latin,cyrillic,latin-ext",
			"file"  : "Exo2-Regular.ttf"
		},
		"Fjalla One": {
			"family": "\'Fjalla One\', Arial, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Fjalla+One&subset=latin,latin-ext",
			"file"  : "FjallaOne-Regular.ttf"
		},
		"Fresca": {
			"family": "\'Fresca\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Fresca&subset=latin,latin-ext",
			"file"  : "Fresca-Regular.ttf"
		},
		"Inder": {
			"family": "\'Inder\', Tahoma, Geneva, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Inder&subset=latin,latin-ext",
			"file"  : "Inder-Regular.ttf"
		},
		"Gurajada": {
			"family": "\'Gurajada\', serif",
			"import": "https://fonts.googleapis.com/css?family=Gurajada&subset=latin,telugu",
			"file"  : "Gurajada-Regular.ttf"
		},
		"Istok Web": {
			"family": "\'Istok Web\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Istok+Web&subset=latin,latin-ext,cyrillic",
			"file"  : "IstokWeb-Regular.ttf"
		},
		"Khula": {
			"family": "\'Khula\',sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Khula&subset=latin,devanagari,latin-ext",
			"file"	: "Khula-Regular.ttf"
		},
		"Lato": {
			"family": "\'Lato\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext",
			"file"  : "Lato-Regular.ttf"
		},
		"Ledger": {
			"family": "\'Ledger\', Georgia, serif",
			"import": "https://fonts.googleapis.com/css?family=Ledger&subset=latin,latin-ext,cyrillic",
			"file"  : "Ledger-Regular.ttf"
		},
		"Lobster": {
			"family": "\'Lobster\', Comic Sans MS, cursive",
			"import": "https://fonts.googleapis.com/css?family=Lobster&subset=latin,latin-ext,cyrillic",
			"file"  : "Lobster.ttf"
		},
		"Marck Script": {
			"family": "\'Marck Script\', \'Comic Sans MS\', cursive",
			"import": "https://fonts.googleapis.com/css?family=Marck+Script&subset=latin,cyrillic,latin-ext",
			"file"  : "MarckScript-Regular.ttf"
		},
		"Marmelad": {
			"family": "\'Marmelad\', Helvetica, Arial, Verdana, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Marmelad&subset=latin,latin-ext,cyrillic",
			"file"  : "Marmelad-Regular.ttf"
		},
		"Merriweather Sans": {
			"family": "\'Merriweather Sans\', Trebuchet MS, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Merriweather+Sans&subset=latin,latin-ext",
			"file"  : "MerriweatherSans-Regular.ttf"
		},
		"Montserrat": {
			"family": "\'Montserrat\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Montserrat",
			"file"  : "Montserrat-Regular.ttf"
		},
		"Noto Sans": {
			"family": "\'Noto Sans\', Helvetica, Arial, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Noto+Sans&subset=latin,latin-ext,cyrillic",
			"file"  : "NotoSans-Regular.ttf"
		},
		"Nunito": {
			"family": "Nunito, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Nunito",
			"file"  : "Nunito-Regular.ttf"
		},
		"Open Sans": {
			"family": "\'Open Sans\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic,latin-ext",
			"file"  : "OpenSans-Regular.ttf"
		},
		"Open Sans Condensed": {
			"family": "\'Open Sans Condensed\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,latin-ext,cyrillic",
			"file"  : "OpenSans-CondLight.ttf"
		},
		"Oranienbaum": {
			"family": "\'Oranienbaum\', Georgia, serif",
			"import": "https://fonts.googleapis.com/css?family=Oranienbaum&subset=latin,latin-ext,cyrillic",
			"file"  : "Oranienbaum-Regular.ttf"
		},
		"Oswald": {
			"family": "\'Oswald\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Oswald&subset=latin,latin-ext",
			"file"  : "Oswald-Regular.ttf"
		},
		"Play": {
			"family": "\'Play\', Verdana, Geneva, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Play&subset=latin,cyrillic,latin-ext",
			"file"  : "Play-Regular.ttf"
		},
		"Pacifico": {
			"family": "\'Pacifico\', cursive",
			"import": "http://fonts.googleapis.com/css?family=Pacifico",
			"file"  : "Pacifico.ttf"
		},
		"Playfair Display": {
			"family": "\'Playfair Display\', Palatino Linotype, Book Antiqua, Palatino, serif",
			"import": "https://fonts.googleapis.com/css?family=Playfair+Display&subset=latin,cyrillic,latin-ext",
			"file"  : "PlayfairDisplay-Regular.ttf"
		},
		"PT Sans": {
			"family": "\'PT Sans\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=PT+Sans&subset=latin,latin-ext",
			"file"  : "PT_Sans-Web-Regular.ttf"
		},
		"Roboto": {
			"family": "\'Roboto\', sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic-ext,latin-ext,cyrillic,greek-ext,greek,vietnamese",
			"file"  : "Roboto-Regular.ttf"
		},
		"Roboto Condensed": {
			"family": "\'Roboto Condensed\', \'MS Sans Serif\', Geneva, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Roboto+Condensed&subset=latin,cyrillic,latin-ext",
			"file"  : "RobotoCondensed-Regular.ttf"
		},
		"Signika": {
			"family": "\'Signika\', Tahoma, Geneva, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Signika&subset=latin,latin-ext",
			"file"  : "Signika-Regular.ttf"
		},
		"Simonetta": {
			"family": "\'Simonetta\', Comic Sans MS, cursive",
			"import": "https://fonts.googleapis.com/css?family=Simonetta&subset=latin,latin-ext",
			"file"  : "Simonetta-Regular.ttf"
		},
		"Slabo 27px": {
			"family": "\'Slabo 27px\', serif",
			"import": "http://fonts.googleapis.com/css?family=Slabo+27px&subset=latin,latin-ext",
			"file"  : "Slabo-27px.ttf"
		},
		"Source Sans Pro": {
			"family": "\'Source Sans Pro\', Arial, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Source+Sans+Pro&subset=latin,latin-ext",
			"file"  : "SourceSansPro-Regular.ttf"
		},
		"Tenor Sans": {
			"family": "\'Tenor Sans\', Arial, Helvetica, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Tenor+Sans&subset=latin,cyrillic,latin-ext",
			"file"  : "TenorSans-Regular.ttf"
		},
		"Tinos": {
			"family": "\'Tinos\', Georgia, serif",
			"import": "https://fonts.googleapis.com/css?family=Tinos&subset=latin,latin-ext,cyrillic",
			"file"  : "Tinos-Regular.ttf"
		},
		"Ubuntu Condensed": {
			"family": "\'Ubuntu Condensed\', Impact, Charcoal, sans-serif",
			"import": "https://fonts.googleapis.com/css?family=Ubuntu+Condensed&subset=latin,cyrillic,latin-ext",
			"file"  : "UbuntuCondensed-Regular.ttf"
		}
	}';
	$fonts = (array)json_decode( $fonts_json );

	if( !is_dir(G5_WS_DATA_PATH) && !file_exists( G5_WS_DATA_PATH ) )
	{
		$old = umask(0);
		mkdir(G5_WS_DATA_PATH,0777);
		umask($old);
	}
	include( G5_WS_PATH . '/wowslider.lib.php' );
}
