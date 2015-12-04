<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//------------------------------------------------------------------------------
// 설문조사 상수 모음 시작
//------------------------------------------------------------------------------

define( 'G5_SURVEYS_DIR', 'surveys' );
define( 'G5_SURVEYS_PATH', G5_PATH . '/' . G5_SURVEYS_DIR);
define( 'G5_SURVEYS_URL', G5_URL . '/' . G5_SURVEYS_DIR);

define('G5_SURVEYS_ADMIN_DIR',        'serveys');
define('G5_SURVEYS_ADMIN_PATH',       G5_ADMIN_PATH.'/extend/'.G5_SURVEYS_ADMIN_DIR);
define('G5_SURVEYS_ADMIN_URL',        G5_ADMIN_URL.'/extend/'.G5_SURVEYS_ADMIN_DIR);

$g5['surveys_m_table'] = G5_TABLE_PREFIX . 'surveys';	// 설문조사 마스터테이블
$g5['surveys_c_table'] = G5_TABLE_PREFIX . 'surveys_c'; // 설문조사 
$g5['surveys_q_table'] = G5_TABLE_PREFIX . 'surveys_q'; // 설문조사 
$g5['surveys_r_table'] = G5_TABLE_PREFIX . 'surveys_r';
$g5['surveys_a_table'] = G5_TABLE_PREFIX . 'surveys_a';

if ( is_file(G5_LIB_PATH . '/surveys.lib.php') && file_exists(G5_LIB_PATH . '/surveys.lib.php') )
{
	@include_once( G5_LIB_PATH . '/surveys.lib.php' );
	
	$tableScheme = "CREATE TABLE IF NOT EXISTS `{$g5['surveys_m_table']}` (
					  `su_id` int(11) NOT NULL AUTO_INCREMENT,
					  `su_subject` varchar(255) NOT NULL DEFAULT '',
					  `su_level` varchar(255) NOT NULL DEFAULT '',
					  `su_content` text NOT NULL,
					  `su_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `su_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `su_questions` tinyint(3) NOT NULL DEFAULT '0',
					  `su_multiple` char(1) NOT NULL DEFAULT 'N',
					  `su_people` int(11) NOT NULL DEFAULT '0',
					  `su_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `su_removed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`su_id`)
					)";
	sql_query( $tableScheme );
	
	
	$tableScheme = "CREATE TABLE IF NOT EXISTS `{$g5['surveys_c_table']}` (
					  `suc_id` int(11) NOT NULL AUTO_INCREMENT,
					  `su_id` int(11) NOT NULL DEFAULT '0',
					  `suc_name` varchar(255) NOT NULL DEFAULT '',
					  `suc_summary` text NOT NULL,
					  `suc_sort` int(11) NOT NULL DEFAULT '0',
					  `suc_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`suc_id`)
					)";
	sql_query( $tableScheme );
	
	$tableScheme = "CREATE TABLE IF NOT EXISTS `{$g5['surveys_q_table']}` (
					  `suq_id` int(11) NOT NULL AUTO_INCREMENT,
					  `su_id` int(11) NOT NULL DEFAULT '0',
					  `suq_sort` tinyint(3) NOT NULL DEFAULT '0',
					  `suq_question` text NOT NULL,
					  `suq_answer_1` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_2` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_3` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_4` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_5` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_6` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_7` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_8` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_9` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_10` varchar(255) NOT NULL DEFAULT '',
					  `suq_answer_etc` varchar(255) NOT NULL DEFAULT '',
					  `suq_enable_etc` enum('enabled','disabled') NOT NULL DEFAULT 'enabled',
					  `suq_max_select` tinyint(1) NOT NULL DEFAULT '1',
					  `suq_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  `suq_category` int(11) NOT NULL DEFAULT '0',
					  `suq_type` varchar(50) NOT NULL DEFAULT '',
					  PRIMARY KEY (`suq_id`)
					)";
	sql_query( $tableScheme );
	
	$tableScheme = "CREATE TABLE IF NOT EXISTS `{$g5['surveys_r_table']}` (
					  `sur_id` int(11) NOT NULL AUTO_INCREMENT,
					  `su_id` int(11) NOT NULL DEFAULT '0',
					  `uniqid` varchar(20) NOT NULL,
					  `suq_id` int(11) NOT NULL DEFAULT '0',
					  `mb_id` varchar(30) NOT NULL DEFAULT '',
					  `sua_id` int(11) NOT NULL DEFAULT '0',
					  `sur_result` varchar(255) DEFAULT NULL,
					  `sur_result_value` text NOT NULL,
					  `sur_etc_result` text NOT NULL,
					  `sur_ip` varchar(39) NOT NULL DEFAULT '',
					  `sur_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`sur_id`)
					)";
	sql_query( $tableScheme );
	
	$tableScheme = "CREATE TABLE IF NOT EXISTS `g5_surveys_a` (
					  `sua_id` int(11) NOT NULL AUTO_INCREMENT,
					  `su_id` int(11) NOT NULL,
					  `mb_id` varchar(100) NOT NULL,
					  `sua_applicant_1` varchar(255) NOT NULL,
					  `sua_applicant_2` varchar(255) NOT NULL,
					  `sua_applicant_3` varchar(255) NOT NULL,
					  `sua_applicant_4` varchar(255) NOT NULL,
					  `sua_applicant_5` varchar(255) NOT NULL,
					  `sua_applicant_6` varchar(255) NOT NULL,
					  `sua_applicant_7` varchar(255) NOT NULL,
					  `sua_applicant_8` varchar(255) NOT NULL,
					  `sua_applicant_9` varchar(255) NOT NULL,
					  `sua_applicant_10` varchar(255) NOT NULL,
					  `sua_created` datetime NOT NULL,
					  PRIMARY KEY (`sua_id`)
					)";
	sql_query( $tableScheme );

}

?>