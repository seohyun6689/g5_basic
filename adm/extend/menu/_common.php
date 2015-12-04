<?php
define('G5_IS_ADMIN', true);
include_once ('../../../common.php');
include_once(G5_ADMIN_PATH.'/admin.lib.php');

$sub_menu = "999002";

$result = mysql_list_fields( G5_MYSQL_DB, $g5[menu_table] );
$columns = mysql_num_fields($result);
$fields = array();
for ($i = 0; $i < $columns; $i++) {
  $fields[] = mysql_field_name($result, $i);
}
if ( !in_array('me_group', $fields) )
{
	sql_query( "ALTER TABLE `{$g5[menu_table]}` ADD COLUMN `me_group` CHAR(1) NOT NULL DEFAULT 'P' AFTER `me_id` " );	
	sql_query( "ALTER TABLE `{$g5['menu_table']}` ADD INDEX `me_group` " );
}
if ( !in_array('me_sub_name', $fields) ) {
	sql_query( "ALTER TABLE `{$g5[menu_table]}` ADD COLUMN `me_sub_name` varchar(255) NOT NULL DEFAULT '' AFTER `me_name` " );
}
?>