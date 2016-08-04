<?php
include_once('./_common.php');

//dbconfig파일에 $g5['content_table'] 배열변수가 있는지 체크
if( !isset($g5['content_table']) ){
    die('<meta charset="utf-8">관리자 모드에서 게시판관리->내용 관리를 먼저 확인해 주세요.');
}

// 내용
$sql = " select * from {$g5['content_table']} where co_id = '$co_id' ";
if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
    $sql .= " and co_lang = '" . G5_I18N_LANG . "'";
}
$co = sql_fetch($sql);
if (!$co['co_id'])
    // alert('등록된 내용이 없습니다.');
    goto_url(G5_URL . '/error/404.php');

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/content.php');
    return;
}

$contentpath = G5_DATA_PATH."/pages";
$content_file_path = $contentpath . "/" . $co['co_id'] . (defined('G5_I18N_LANG') && G5_I18N_LANG ? '.'  . G5_I18N_LANG : '') . ".php";
if ( is_file($content_file_path) && file_exists($content_file_path) ) {
	ob_start();
	@include_once( $content_file_path );
	$co['co_content'] = ob_get_contents();
	ob_end_clean();
}

$str = conv_content($co['co_content'], $co['co_html'], $co['co_tag_filter_use']);

// $src 를 $dst 로 변환
unset($src);
unset($dst);
$src[] = "/{{쇼핑몰명}}|{{홈페이지제목}}/";
$dst[] = $config['cf_title'];
$src[] = "/{{회사명}}|{{상호}}/";
$dst[] = $default['de_admin_company_name'];
$src[] = "/{{대표자명}}/";
$dst[] = $default['de_admin_company_owner'];
$src[] = "/{{사업자등록번호}}/";
$dst[] = $default['de_admin_company_saupja_no'];
$src[] = "/{{대표전화번호}}/";
$dst[] = $default['de_admin_company_tel'];
$src[] = "/{{팩스번호}}/";
$dst[] = $default['de_admin_company_fax'];
$src[] = "/{{통신판매업신고번호}}/";
$dst[] = $default['de_admin_company_tongsin_no'];
$src[] = "/{{사업장우편번호}}/";
$dst[] = $default['de_admin_company_zip'];
$src[] = "/{{사업장주소}}/";
$dst[] = $default['de_admin_company_addr'];
$src[] = "/{{운영자명}}|{{관리자명}}/";
$dst[] = $default['de_admin_name'];
$src[] = "/{{운영자e-mail}}|{{관리자e-mail}}/i";
$dst[] = $default['de_admin_email'];
$src[] = "/{{정보관리책임자명}}/";
$dst[] = $default['de_admin_info_name'];
$src[] = "/{{정보관리책임자e-mail}}|{{정보책임자e-mail}}/i";
$dst[] = $default['de_admin_info_email'];

$str = preg_replace($src, $dst, $str);

$g5['title'] = $co['co_subject'];

if ($co['co_include_head'])
    @include_once($co['co_include_head']);
else
    include_once( G5_PATH . '/_head.php');

// 스킨경로
if(trim($co['co_skin']) == '')
    $co['co_skin'] = 'basic';

$content_skin_path = get_skin_path('content', $co['co_skin']);
$content_skin_url  = get_skin_url('content', $co['co_skin']);
$skin_file = $content_skin_path.'/content.skin.php';

if(is_file($skin_file)) {
    $himg = G5_DATA_PATH.'/content/'.$co_id.'_h';
    if (file_exists($himg)) // 상단 이미지
        echo '<div id="ctt_himg" class="ctt_img"><img src="'.G5_DATA_URL.'/content/'.$co_id.'_h" alt=""></div>';

    include($skin_file);

    $timg = G5_DATA_PATH.'/content/'.$co_id.'_t';
    if (file_exists($timg)) // 하단 이미지
        echo '<div id="ctt_timg" class="ctt_img"><img src="'.G5_DATA_URL.'/content/'.$co_id.'_t" alt=""></div>';
} else {
    echo '<p>'. __( 'core.a648', str_replace(G5_PATH.'/', '', $skin_file)).'</p>';
}

if ($co['co_include_tail'])
    @include_once($co['co_include_tail']);
else
    include_once( G5_PATH . '/_tail.php');
?>
