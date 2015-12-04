<?php
require_once( './_common.php' );
// if (!defined('_GNUBOARD_')) exit;	
if ( isset( $_GET['image_w'] ) && isset($_GET['ws_id']) && isset($_GET['wsi_id']) )
{
	$sql = "select * from `{$g5['ws_images_table']}` where wsi_id = '{$wsi_id}'";
	$ws_data = sql_fetch($sql);
	$wsi_id = $ws_data['wsi_id'];
	$wsi_title = $ws_data['wsi_title'];
	$wsi_disable = ( $ws_data['wsi_disable'] == 'Y' ? ' checked="checked"' : '' );
	$wsi_link = $ws_data['wsi_link'];
	$wsi_link_target = ( $ws_data['wsi_link_target'] == 'Y' ? ' checked="checked"' : '' );
	$wsi_file = $ws_data['wsi_source'];
}
?>
<form id="image_item_form" action="image_upload.php" method="post" enctype="multipart/form-data" onsubmit="image_upload(this);return false;">
	<input type="hidden" name="w" id="w" value="<?php echo $image_w; ?>" />
	<input type="hidden" name="ws_id" value="<?php echo $_GET['ws_id']; ?>" />
	<input type="hidden" name="wsi_id" id="wsi_id" value="<?php echo $wsi_id; ?>" />
	<div class="tbl_frm01 tbl_wrap">
		<table>
			<tr>
				<th scope="row"><label for="wsi_title">타이틀</label></th>
				<td>
					<input type="text" name="wsi_title" id="wsi_title" value="<?php echo $wsi_title; ?>" class="frm_input required" required />
					<input type="checkbox" name="wsi_disable" id="wsi_disable" value="Y"<?php echo $wsi_disable; ?> /> <label for="wsi_disable">노출안함</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="wsi_link">링크</label></th>
				<td>
					<input type="text" name="wsi_link" id="wsi_link" value="<?php echo $wsi_link; ?>" class="frm_input" size="40" />
					<input type="checkbox" name="wsi_link_target" id="wsi_link_target" value="Y"<?php echo $wsi_link_target; ?> />
					<label for="wsi_link_target">새창</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="wsi_file">파일</label></th>
				<td>
					<input type="file" name="wsi_file" id="wsi_file" value="" class="frm_input<?php echo ( !$image_w ? ' required' : ''); ?>"<?php echo ( !$image_w ? ' required' : ''); ?> />
					<?php echo $wsi_file; ?>
				</td>
			</tr>
		</table>
	</div>
</form>