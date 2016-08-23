<?php
include_once('./_common.php'); 
$sub_menu = '999005';

$id = (isset($_GET['id']) && trim($_GET['id']) != '' ? $_GET['id'] : '');

if ($w == 'u') {
	$sql = 'select * from `' . $g5['images_master_table']	. '` where img_id = "' . $id . '"';
	$row = sql_fetch( $sql );
	$sldr_id = $row['img_id'];
}

include_once(G5_ADMIN_PATH . '/admin.head.php');

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

add_stylesheet( '<link rel="stylesheet" href="' . G5_IMAGES_ADMIN_URL . '/styles/style.css">', 0);
add_javascript( '<script src="' . G5_IMAGES_ADMIN_URL . '/scripts/jquery.form.min.js"></script>', 0);
add_javascript( '<script src="' . G5_IMAGES_ADMIN_URL . '/scripts/common.js"></script>', 0);
add_javascript( '<script type="text/javascript">var image_url = "' . sprintf( G5_IMAGES_ITEMS_URL, $id ) . '";</script>', 0 );
add_javascript( '<script src="' . G5_IMAGES_ADMIN_URL . '/scripts/images_upload.js"></script>', 1);
?>
<style type="text/css">
#sldr_css {display: none;}
#css_editor {width: 100%; height: 400px;}
</style>
<div class="local_desc01 local_desc">
    <ol>
        <li><strong>슬라이드 ID</strong>를 먼저 <strong>생성</strong>하신 후 옵션을 설정해 주시기 바랍니다.</li>
    </ol>
</div>

<form name="frmwowmasterform" action="./images_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="w" value="<?php echo $w; ?>">

<section id="anc_ws_basic">
<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption>이미지 슬라이드 기본환경 설정</caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="sldr_id">슬라이드 ID</label></th>
        <td>
			<?php if ( $w == '' ) : ?>
				<input type="text" name="img_id" value="" id="img_id" class="frm_input required" maxlength="20" size="20">
				<input type="submit" value="생성" class="btn_frmline" />
				영문자, 숫자, _ 만 가능 (공백없이 20자 이내)
			<?php else : ?>
				<?php echo $id; ?>
				<input type="hidden" name="img_id" id="img_id" value="<?php echo $id; ?>"> 			
			<?php endif; ?>
        </td>
    </tr>
    
    <tr>
        <th scope="row"><label for="img_name">슬라이드 제목</label></th>
        <td>
            <input type="text" name="img_name" value="<?php echo $row['img_name']; ?>" id="img_name" class="frm_input" maxlength="20" size="20">
        </td>
    </tr> 
    
    </tbody>
    </table>
</div>
</section>

<?php if ($w == 'u' && $id) { ?>
<section id="anc_images">
	<h2 class="h2_frm">이미지 슬라이드 이미지 설정</h2>
	<?php echo $pg_anchor ?>
	<div id="images" class="tbl_frm01 tbl_wrap">
		<div class="images_buttons">
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>" id="add_image" class="btn_frmline" >추가</a>
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>" id="remove_image" class="btn_frmline">삭제</a>
			<span class="help">이미지를 <strong>더블클릭</strong> 하시면 수정이 가능합니다.</span>
		</div>
		<div class="images_wrap">
			<ul id="images_ul" class="clearfix">
				<li class="empty_item">이미지를 추가해 주세요.</li>
			</ul>
		</div>
	</div>
</section>
<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./images_list.php">목록</a>
</div>
</form>

<?php } else { ?>
</form>
<?php } ?>

<?php if ($w == 'u' && $id) { ?>
<div id="image_dialog" title="슬라이드 이미지 설정">
	<?php require(dirname(__FILE__) . '/image_form.inc.php'); ?>
</div>
<?php } ?>
<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php'); 
?>