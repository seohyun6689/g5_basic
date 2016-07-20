<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

if (!$config['cf_email_use'])
    alert(___(core_a649));

if (!$is_member && $config['cf_formmail_is_member'])
    alert_close(___(core_a49));

$to = base64_decode($to);

if (substr_count($to, "@") > 1)
    alert_close(___(core_a50));


if (!chk_captcha()) {
    alert(___(core_a51));
}


$file = array();
for ($i=1; $i<=$attach; $i++) {
    if ($_FILES['file'.$i]['name'])
        $file[] = attach_file($_FILES['file'.$i]['name'], $_FILES['file'.$i]['tmp_name']);
}

$content = stripslashes($content);
if ($type == 2) {
    $type = 1;
    $content = str_replace("\n", "<br>", $content);
}

// html 이면
if ($type) {
    $current_url = G5_URL;
    $mail_content = '<!doctype html><html lang="ko"><head><meta charset="utf-8"><title>메일보내기</title><link rel="stylesheet" href="'.$current_url.'/style.css"></head><body>'.$content.'</body></html>';
}
else
    $mail_content = $content;

mailer($fnick, $fmail, $to, $subject, $mail_content, $type, $file);

// 임시 첨부파일 삭제
if(!empty($file)) {
    foreach($file as $f) {
        @unlink($f['path']);
    }
}

//$html_title = $tmp_to . "님께 메일발송";
$html_title = ___(core_a649);
include_once(G5_PATH.'/head.sub.php');

alert_close(___(core_a52));

include_once(G5_PATH.'/tail.sub.php');
?>
