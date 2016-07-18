<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

 error_reporting(E_ALL ^ E_NOTICE);
 ini_set("display_errors", 1);

//------------------------------------------------------------------------------
//  상수 모음 시작
//------------------------------------------------------------------------------

define('G5_USE_I18N', true);

define('G5_I18N_DIR', 'i18n');
define('G5_I18N_PATH', G5_PATH . '/' . G5_I18N_DIR);
define('G5_I18N_URL', G5_URL . '/' . G5_I18N_DIR);

define('G5_LANG_DIR', 'lang');
define('G5_LANG_PATH', G5_I18N_PATH . '/' . G5_LANG_DIR);
define('G5_LANG_URL', G5_I18N_URL . '/' . G5_LANG_DIR);

if ( ! is_dir(G5_DATA_PATH . '/cache/i18n')) mkdir(G5_DATA_PATH . '/cache/i18n');

require_once(G5_I18N_PATH.'/i18n.user.php');
