<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

$no = (int)$no;

@include_once($board_skin_path.'/download.head.skin.php');

// 쿠키에 저장된 ID값과 넘어온 ID값을 비교하여 같지 않을 경우 오류 발생
// 다른곳에서 링크 거는것을 방지하기 위한 코드
if (!get_session('ss_view_'.$bo_table.'_'.$wr_id))
    alert(__(core_a126));

// 다운로드 차감일 때 비회원은 다운로드 불가
if($board['bo_download_point'] < 0 && $is_guest)
    alert(__(theme_t721), G5_BBS_URL.'/login.php?wr_id='.$wr_id.'&amp;'.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id));

$sql = " select bf_source, bf_file from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
$file = sql_fetch($sql);
if (!$file['bf_file'])
    alert_close(__(core_a38));

// JavaScript 불가일 때
if($js != 'on' && $board['bo_download_point'] < 0) {
    $msg = $file['bf_source']. __(core_a39, number_format($board['bo_download_point']));
    $url1 = G5_BBS_URL.'/download.php?'.clean_query_string($_SERVER['QUERY_STRING']).'&amp;js=on';
    $url2 = clean_xss_tags($_SERVER['HTTP_REFERER']);

    //$url1 = 확인link, $url2=취소link
    // 특정주소로 이동시키려면 $url3 이용
    confirm($msg, $url1, $url2);
}

if ($member['mb_level'] < $board['bo_download_level']) {
    $alert_msg = __(core_a40);
    if ($member['mb_id'])
        alert($alert_msg);
    else
        alert($alert_msg. __(core_a41), G5_BBS_URL.'/login.php?wr_id='.$wr_id.'&amp;'.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id));
}

$filepath = G5_DATA_PATH.'/file/'.$bo_table.'/'.$file['bf_file'];
$filepath = addslashes($filepath);
if (!is_file($filepath) || !file_exists($filepath))
    alert(__(core_a42));

// 사용자 코드 실행
@include_once($board_skin_path.'/download.skin.php');

// 이미 다운로드 받은 파일인지를 검사한 후 게시물당 한번만 포인트를 차감하도록 수정
$ss_name = 'ss_down_'.$bo_table.'_'.$wr_id;
if (!get_session($ss_name))
{
    // 자신의 글이라면 통과
    // 관리자인 경우 통과
    if (($write['mb_id'] && $write['mb_id'] == $member['mb_id']) || $is_admin)
        ;
    else if ($board['bo_download_level'] >= 1) // 회원이상 다운로드가 가능하다면
    {
        // 다운로드 포인트가 음수이고 회원의 포인트가 0 이거나 작다면
        if ($member['mb_point'] + $board['bo_download_point'] < 0)
            alert(__(core_a43, array(number_format($member['mb_point']), number_format($board['bo_download_point']))));

        // 게시물당 한번만 차감하도록 수정
        insert_point($member['mb_id'], $board['bo_download_point'], "{$board['bo_subject']} $wr_id 파일 다운로드", $bo_table, $wr_id, "다운로드");
    }

    // 다운로드 카운트 증가
    $sql = " update {$g5['board_file_table']} set bf_download = bf_download + 1 where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$no' ";
    sql_query($sql);

    set_session($ss_name, TRUE);
}

$g5['title'] = '다운로드 &gt; '.conv_subject($write['wr_subject'], 255);

//$original = urlencode($file['bf_source']);
$original = iconv('utf-8', 'euc-kr', $file['bf_source']); // SIR 잉끼님 제안코드

@include_once($board_skin_path.'/download.tail.skin.php');

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();
?>
