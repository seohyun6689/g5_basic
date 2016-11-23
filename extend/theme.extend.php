<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


/**************************************************************************/
// http://kr1.php.net/manual/en/function.curl-setopt-array.php 참고
if (!function_exists('curl_setopt_array')) {
   function curl_setopt_array(&$ch, $curl_options)
   {
       foreach ($curl_options as $option => $value) {
           if (!curl_setopt($ch, $option, $value)) {
               return false;
           }
       }
       return true;
   }
}

function seohyun_theme_items($url = '')
{
	if (!$url) return false;

	// curl library 가 지원되어야 합니다.
    if (!function_exists('curl_init')) return -3;
    $client_opt = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 10,
		// CURLOPT_HTTPHEADER => array("Host: apis.naver.com", "Pragma: no-cache", "Accept: */*")
    );
    $ch = curl_init();
    curl_setopt_array($ch, $client_opt);
    $response = curl_exec($ch);

	return $response;
}
/**************************************************************************/
