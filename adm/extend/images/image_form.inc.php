<?php
require_once( './_common.php' );

if ( isset( $_GET['image_w'] ) && isset($_GET['img_item_id']) )
{
	$sql = "select * from `{$g5['images_items_table']}` where img_item_id = '{$img_item_id}'";
	$data = sql_fetch($sql);
	$img_item_id = $data['img_item_id'];
	$img_item_title = $data['img_item_title'];
	$img_item_disable = ( $data['img_item_disable'] == 'Y' ? ' checked="checked"' : '' );
	$img_item_link = $data['img_item_link'];
	$img_item_link_target = ( $data['img_item_link_target'] == 'Y' ? ' checked="checked"' : '' );
	$img_item_file = $data['img_item_source'];
}
?>
<form id="image_item_form" action="image_upload.php" method="post" enctype="multipart/form-data" onsubmit="image_upload(this);return false;">
	<input type="hidden" name="w" id="w" value="<?php echo $image_w; ?>" />
	<input type="hidden" name="img_id" id="img_id" value="<?php echo $_GET['img_id']; ?>" />
	<input type="hidden" name="img_item_id" id="img_item_id" value="<?php echo $_GET['img_item_id']; ?>" />
	<div class="tbl_frm01 tbl_wrap">
		<table>
			<tr>
				<th scope="row"><label for="img_item_title">타이틀</label></th>
				<td>
					<input type="text" name="img_item_title" id="img_item_title" value="<?php echo $img_item_title; ?>" class="frm_input required" required />
					<input type="checkbox" name="img_item_disable" id="img_item_disable" value="Y"<?php echo $img_item_disable; ?> /> <label for="img_item_disable">노출안함</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="img_item_link">링크</label></th>
				<td>
					<input type="text" name="img_item_link" id="img_item_link" value="<?php echo $img_item_link; ?>" class="frm_input" size="40" />
					<input type="checkbox" name="img_item_link_target" id="img_item_link_target" value="Y"<?php echo $img_item_link_target; ?> />
					<label for="img_item_link_target">새창</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="wsi_file">파일</label></th>
				<td>
					<input type="file" name="img_item_file" id="img_item_file" value="" class="frm_input<?php echo ( !$image_w ? ' required' : ''); ?>"<?php echo ( !$image_w ? ' required' : ''); ?> />
					<?php echo $img_item_file; ?>
				</td>
			</tr>
		</table>
	</div>
</form>