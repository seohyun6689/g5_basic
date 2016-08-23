<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//------------------------------------------------------------------------------
// SLDR SLIDER 상수 모음 시작
//------------------------------------------------------------------------------

define('G5_USE_IMAGES', true);

define('G5_IMAGES_DIR', 'images');
define('G5_IMAGES_PATH', G5_PLUGIN_PATH . '/' . G5_IMAGES_DIR);
define('G5_IMAGES_URL', G5_PLUGIN_URL . '/' . G5_IMAGES_DIR);

define('G5_IMAGES_ADMIN_DIR', 'images');
define('G5_IMAGES_ADMIN_PATH', G5_ADMIN_PATH . '/extend/' . G5_IMAGES_ADMIN_DIR);
define('G5_IMAGES_ADMIN_URL', G5_ADMIN_URL . '/extend/' . G5_IMAGES_ADMIN_DIR);

define('G5_IMAGES_DATA_PATH', G5_DATA_PATH . '/_images_');
define('G5_IMAGES_DATA_URL', G5_DATA_URL . '/_images_');

define('G5_IMAGES_ITEMS_PATH', G5_IMAGES_DATA_PATH . '/%s');
define('G5_IMAGES_ITEMS_URL', G5_IMAGES_DATA_URL . '/%s');


$g5['images_master_table'] = G5_TABLE_PREFIX . 'images_master';
$g5['images_items_table'] = G5_TABLE_PREFIX . 'images_items';

if ( G5_USE_IMAGES && is_file(G5_IMAGES_PATH . '/images.lib.php') && file_exists(G5_IMAGES_PATH . '/images.lib.php')) {

	$sql = 'CREATE TABLE IF NOT EXISTS `' . $g5['images_master_table'] . '` (
		`img_id` varchar(20) not null,
		`img_name` varchar(255) not null default "",
		PRIMARY KEY ( `img_id` )
		);';
	sql_query($sql, false);
	$sql = 'CREATE TABLE IF NOT EXISTS `' . $g5['images_items_table'] . '` (
					`img_item_id` int(11) not null auto_increment,
					`img_id` varchar(20) not null default "",
					`img_item_title` varchar(100) not null default "",
					`img_item_link` varchar(255) not null default "",
					`img_item_link_target` char(1) not null default "",
					`img_item_file` varchar(255) not null default "",
					`img_item_source` varchar(255) not null default "",
					`img_item_disable` varchar(255) not null default "",
					`img_item_sortable` int(11) not null default 0,
					PRIMARY KEY ( `img_item_id` ),
					INDEX `sldr_id` (`img_id`),
					INDEX `img_item_sortable` (`img_item_sortable`)
					);';
	sql_query($sql, false);

	if( !is_dir(G5_IMAGES_ITEMS_PATH) && !file_exists(G5_IMAGES_ITEMS_PATH) )
	{
		$old = umask(0);
		@mkdir(G5_IMAGES_DATA_PATH,0777);
		umask($old);
	}

	include_once(G5_IMAGES_PATH . '/images.lib.php');
}
?>
