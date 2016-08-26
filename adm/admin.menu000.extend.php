<?php
if (!defined('_GNUBOARD_')) exit;

if (is_dir(G5_THEME_PATH . '/adm') && file_exists(G5_THEME_PATH . '/adm')) {
    $tmphandle = dir(G5_THEME_PATH . '/adm');
    while ($entry = $tmphandle->read()) {
        if (!preg_match('/^admin.menu([0-9]{3}).*\.php$/', $entry, $m))
            continue;  // 파일명이 menu 으로 시작하지 않으면 무시한다.

        $amenu[$m[1]] = $entry;
        include_once(G5_THEME_PATH.'/adm/'.$entry);
    }
}
?>
