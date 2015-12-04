<?php
$sub_menu = '700400';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

// 테마 스타일 목록
$templates = array();
$templates_path = scandir( './templates/backgnd/' );
foreach( $templates_path as $template )
{ 
	if (!preg_match('/\.+/', $template))
	{
		$templates[] = $template;
	}
}

// 효과 목록
$effects = array();
$effects_path = scandir('./templates/effects/');
foreach($effects_path as $effect)
{
	if ( !preg_match('/^\./', $effect) )
	{
		$effects[] = $effect;
	}
}

$g5['title'] = '이미지 슬라이드 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

add_stylesheet( '<link rel="stylesheet" href="' . G5_WS_ADMIN_URL . '/styles/style.css">', 0);
add_javascript( '<script src="' . G5_WS_ADMIN_URL . '/scripts/jquery.form.min.js"></script>', 0 );
add_javascript( '<script src="' . G5_WS_ADMIN_URL . '/scripts/common.js"></script>', 0 );

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_ws_basic">기본환경</a></li>
    <li><a href="#anc_ws_design">테마/효과</a></li>
    <li><a href="#anc_ws_images">이미지</a></li>
</ul>';

if ( $w == 'u' )
{
	$sql = 'select * from `' . $g5['ws_master_table']	. '` where ws_id = "' . $ws_id . '"';
	$ws = sql_fetch( $sql );
	$ws_id = $ws['ws_id'];
	
	$ws_auto_play = ( $ws['ws_auto_play'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_pause_on_mouseover = ( $ws['ws_pause_on_mouseover'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_stop_slideshow = ( $ws['ws_stop_slideshow'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_random_order = ( $ws['ws_random_order'] == 'Y' ? ' checked="checked" ' : '' );
	
	$ws_pause_play_button = ( $ws['ws_pause_play_button'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_full_screen_button = ( $ws['ws_full_screen_button'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_swipe_support = ( $ws['ws_swipe_support'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_preloader = ( $ws['ws_preloader'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_show_controls_mouseover = ( $ws['ws_show_controls_mouseover'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_show_prev_next_buttons = ( $ws['ws_show_prev_next_buttons'] == 'Y' ? ' checked="checked" ' : '' );
	
	$ws_captions = ( $ws['ws_captions'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_captions_effect['none'] 		= ( $ws['ws_captions_effect'] == 'none' ? ' checked="checked" ' : '' );
	$ws_captions_effect['move'] 		= ( $ws['ws_captions_effect'] == 'move' ? ' checked="checked" ' : '' );
	$ws_captions_effect['fade'] 		= ( $ws['ws_captions_effect'] == 'fade' ? ' checked="checked" ' : '' );
	$ws_captions_effect['parallax'] 	= ( $ws['ws_captions_effect'] == 'parallax' ? ' checked="checked" ' : '' );
	$ws_captions_effect['slide'] 		= ( $ws['ws_captions_effect'] == 'slide' ? ' checked="checked" ' : '' );
	$ws_captions_effect['traces'] 	= ( $ws['ws_captions_effect'] == 'traces' ? ' checked="checked" ' : '' );
	
	$ws_noframe = ( $ws['ws_noframe'] == 'Y' ? ' checked="checked" ' : '' );
	
	$ws_show_bullet = ( $ws['ws_show_bullet'] == 'Y' ? ' checked="checked" ' : '' );
	$ws_bullet_type['bullet'] = ( $ws['ws_bullet_type'] == 'bullet' ? ' checked="checked" ' : '' );
	$ws_bullet_type['filmstrip'] = ( $ws['ws_bullet_type'] == 'filmstrip' ? ' checked="checked" ' : '' );
	$ws_bullet_align['top'] = ( $ws['ws_bullet_align'] == 'top' ? ' selected="selected" ' : '' );
	$ws_bullet_align['bottom'] = ( $ws['ws_bullet_align'] == 'bottom' ? ' selected="selected" ' : '' );
	$ws_bullet_thumb_prev = ( $ws['ws_bullet_thumb_prev'] == 'Y' ? ' checked="checked" ' : '' );
	
	$ws_filmstrip_align['top'] = ( $ws['ws_filmstrip_align'] == 'top' ? ' selected="selected" ' : '');
	$ws_filmstrip_align['right'] = ( $ws['ws_filmstrip_align'] == 'right' ? ' selected="selected" ' : '');
	$ws_filmstrip_align['bottom'] = ( $ws['ws_filmstrip_align'] == 'bottom' ? ' selected="selected" ' : '');
	$ws_filmstrip_align['left'] = ( $ws['ws_filmstrip_align'] == 'left' ? ' selected="selected" ' : '');
	
	$ws_slider_layout['boxed'] = ( $ws['ws_size_style'] == 1 ? ' selected="selected" ' : '');
	$ws_slider_layout['full_width'] = ( $ws['ws_size_style'] == 2 ? ' selected="selected" ' : '');
	$ws_slider_layout['full_screen'] = ( $ws['ws_size_style'] == 3 ? ' selected="selected" ' : '');
	
	$ws_multiple_effects = ( $ws['ws_multiple_effects'] == 'Y' ? ' checked="checked" ' : '');
	$ws_image_effect = array_filter(explode( ',', $ws['ws_image_effect'] ));
	if ( count( $ws_image_effect ) <= 0 )
	{
		$ws_image_effect = array('basic');
	}
}

$ws['ws_thumbnail_width'] = ( $ws['ws_thumbnail_width'] ? $ws['ws_thumbnail_width'] : 120 );
$ws['ws_thumbnail_height'] = ( $ws['ws_thumbnail_height'] ? $ws['ws_thumbnail_height'] : 90 );
$ws['ws_image_width'] = ( $ws['ws_image_width'] ? $ws['ws_image_width'] : 640 );
$ws['ws_image_height'] = ( $ws['ws_image_height'] ? $ws['ws_image_height'] : 480 );

?>
<script>
var image_url = '<?php echo sprintf( G5_WS_IMAGES_URL, $ws_id ); ?>';
</script>
<script src="<?php echo G5_WS_ADMIN_URL; ?>/scripts/images_upload.js"></script>
<div class="local_desc01 local_desc">
    <ol>
        <li><strong>슬라이드 ID</strong>를 먼저 <strong>생성</strong>하신 후 옵션을 설정해 주시기 바랍니다.</li>
    </ol>
</div>

<form name="frmwowmasterform" action="./wowslider_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="w" value="<?php echo $w; ?>">

<section id="anc_ws_basic">
	<h2 class="h2_frm">이미지 슬라이드 기본환경 설정</h2>
	<?php echo ( $w == 'u' ? $pg_anchor : '' ); ?>
	
	<div class="tbl_frm01 tbl_wrap">
	    <table>
	    <caption>이미지 슬라이드 기본환경 설정</caption>
	    <colgroup>
	        <col class="grid_4">
	        <col>
	    </colgroup>
	    <tbody>
	    <tr>
	        <th scope="row"><label for="ws_id">슬라이드 ID</label></th>
	        <td>
				<?php if ( $w == '' ) : ?>
					<input type="text" name="ws_id" value="" id="ws_id" class="frm_input required" maxlength="20" size="20">
					<input type="submit" value="생성" class="btn_frmline" />
					영문자, 숫자, _ 만 가능 (공백없이 20자 이내)
				<?php else : ?>
					<?php echo $ws_id; ?>
					<input type="hidden" name="ws_id" id="ws_id" value="<?php echo $ws_id; ?>"> 			
				<?php endif; ?>
	        </td>
	    </tr>
	    
	    <tr>
	        <th scope="row"><label for="ws_name">슬라이드 제목</label></th>
	        <td>
	            <input type="text" name="ws_name" value="<?php echo $ws['ws_name']; ?>" id="ws_name" class="frm_input" maxlength="20" size="20">
	        </td>
	    </tr>
<?php if ( $w == 'u' ) : ?>	    
	    <tr>
		    <th scope="row"><input type="checkbox" name="ws_auto_play" id="ws_auto_play" value="Y"<?php echo $ws_auto_play; ?>/><label for="ws_auto_play"> 자동 재생</label></th>
	        <td id="auto_play_option">
		        <ul>
	            	<li><input type="checkbox" name="ws_pause_on_mouseover" id="ws_pause_on_mouseover" value="Y" disabled="disabled" <?php echo $ws_pause_on_mouseover; ?> /> <label for="ws_pause_on_mouseover">마우스 오버 일시중지</label></li>
					<li><input type="checkbox" name="ws_stop_slideshow" id="ws_stop_slideshow" value="Y" disabled="disabled" <?php echo $ws_stop_slideshow; ?> /> <label for="ws_stop_slideshow">반복 재생 없음</label></li>
					<li><input type="checkbox" name="ws_random_order" id="ws_random_order" value="Y" disabled="disabled" <?php echo $ws_random_order; ?> /> <label for="ws_random_order">임의의 순서로</label></li>
		        </ul>
	        </td>
	    </tr>
	    
	    <tr>
		    <th scope="row">컨트롤</th>
	        <td>
		        <ul>
		        	<li><input type="checkbox" name="ws_pause_play_button" id="ws_pause_play_button" value="Y" <?php echo $ws_pause_play_button; ?>/><label for="ws_pause_play_button"> 일시 정지 / 재생 버튼</label></li>
					<li><input type="checkbox" name="ws_full_screen_button" id="ws_full_screen_button" value="Y" <?php echo $ws_full_screen_button; ?>/><label for="ws_full_screen_button"> 전체 화면 버튼</label></li>
					<li><input type="checkbox" name="ws_swipe_support" id="ws_swipe_support" value="Y" <?php echo $ws_swipe_support; ?>/><label for="ws_swipe_support"> 스와이프 지원</label></li>
					<li><input type="checkbox" name="ws_preloader" id="ws_preloader" value="Y" <?php echo $ws_preloader; ?>/><label for="ws_preloader"> 로딩이미지 지원</label></li>
					<li><input type="checkbox" name="ws_show_controls_mouseover" id="ws_show_controls_mouseover" value="Y" <?php echo $ws_show_controls_mouseover; ?>/><label for="ws_show_controls_mouseover"> 마우스 오버시 컨트롤 출력</label></li>
					<li><input type="checkbox" name="ws_show_prev_next_buttons" id="ws_show_prev_next_buttons" value="Y" <?php echo $ws_show_prev_next_buttons; ?>/><label for="ws_show_prev_next_buttons"> 이전/다음 버튼</label></li>
		        </ul>
			</td>
	    </tr>
	    
	    <tr>
		    <th scope="row"><input type="checkbox" name="ws_captions" id="ws_captions" value="Y" <?php echo $ws_captions; ?>/><label for="ws_captions"> 타이틀</label></th>
	        <td id="captions_option">
		        <ul>
		        	<li><input type="radio" name="ws_captions_effect" id="ws_captions_effect" value="none" disabled="disabled" <?php echo $ws_captions_effect['none']; ?>/><label for="ws_captions_effect_none"> 없음</label></li>
					<li><input type="radio" name="ws_captions_effect" id="ws_captions_effect_move" value="move" disabled="disabled" <?php echo $ws_captions_effect['move']; ?>/><label for="ws_captions_effect_move"> 이동</label></li>
					<li><input type="radio" name="ws_captions_effect" id="ws_captions_effect_fade" value="fade" disabled="disabled" <?php echo $ws_captions_effect['fade']; ?>/><label for="ws_captions_effect_fade"> 페이드</label></li>
					<li><input type="radio" name="ws_captions_effect" id="ws_captions_effect_parallax" value="parallax" disabled="disabled" <?php echo $ws_captions_effect['parallax']; ?>/><label for="ws_captions_effect_parallax"> 시차</label></li>
					<li><input type="radio" name="ws_captions_effect" id="ws_captions_effect_slide" value="slide" disabled="disabled" <?php echo $ws_captions_effect['slide']; ?>/><label for="ws_captions_effect_slide"> 슬라이드</label></li>
					<li><input type="radio" name="ws_captions_effect" id="ws_captions_effect_traces" value="traces" disabled="disabled" <?php echo $ws_captions_effect['traces']; ?>/><label for="ws_captions_effect_traces"> 추적</label></li>
		        </ul>
			</td>
	    </tr>
	    
	    <tr>
		    <th scope="row"><label for="ws_noframe"> 이미지</label></th>
	        <td>
		        <ul>
		        	<li><input type="checkbox" name="ws_noframe" id="ws_noframe" value="Y" <?php echo $ws_noframe; ?>/><label for="ws_noframe"> 슬라이더 테두리 제거</label></li>
		        </ul>
			</td>
	    </tr>
	    
	    <tr>
		    <th scope="row"><input type="checkbox" name="ws_show_bullet" id="ws_show_bullet" value="Y" <?php echo $ws_show_bullet; ?>/> <label for="ws_show_bullet">컨트롤러</label></th>
	        <td id="bullet_option">
			    <dl>
				    <dt><input type="radio" name="ws_bullet_type" id="ws_bullet_type_bullet" value="bullet" disabled="disabled" <?php echo $ws_bullet_type['bullet']; ?>/> <label for="ws_bullet_navigation">단추</label></dt>
				    <dd>
					   	<div>
							<select name="ws_bullet_align" id="ws_bullet_align" disabled="disabled" >
								<option value="top"<?php echo $ws_bullet_align['top']; ?>>TOP</option>
								<option value="bottom"<?php echo $ws_bullet_align['bottom']; ?>>BOTTOM</option>
							</select>  
					   	</div>
					   	<div>
						   	<input type="checkbox" name="ws_bullet_thumb_prev" id="ws_bullet_thumb_prev" value="Y" disabled="disabled" <?php echo $ws_bullet_thumb_prev; ?>/> <label for="ws_bullet_thumb_prev">썸네일 미리보기</label>
					   	</div> 
				    </dd>
				    <dt>
				    	<input type="radio" name="ws_bullet_type" id="ws_bullet_type_film" value="filmstrip" disabled="disabled" <?php echo $ws_bullet_type['filmstrip']; ?>/> <label for="ws_bullet_navi">썸네일</label>
				    </dt>
				    <dd>
				    	<div>
							위치 : 
							<select name="ws_filmstrip_align" id="ws_filmstrip_align" disabled="disabled" >
								<option value="top"<?php echo $ws_filmstrip_align['top']; ?>>TOP</option>	
								<option value="right"<?php echo $ws_filmstrip_align['right']; ?>>RIGHT</option>	
								<option value="bottom"<?php echo $ws_filmstrip_align['bottom']; ?>>BOTTOM</option>	
								<option value="left"<?php echo $ws_filmstrip_align['left']; ?>>LEFT</option>	
							</select>
				    	</div>
				    </dd>
			    </dl>
			    
			    <div id="thumbnail_sizer">
				    썸네일 사이즈 : 
<!--
				    <select name="ws_thumbnail_size" id="ws_thumbnail_size" disabled="disabled">
					    <option value="120x90">120x90</option>
					    <option value="100x100">100x100</option>
					    <option value="96x72">96x72</option>
					    <option value="40x30">40x30</option>
					    <option value="32x24">32x24</option>
					    <option value="20x20">20x20</option>
					    <option value="120x?">120x?</option>
					    <option value="64x?">64x?</option>
					    <option value="?x90">?x90</option>
					    <option value="?x48" selected="selected">?x48</option>
					    <option value="None">Custom Size</option>
				    </select>
-->
				    <span id="thumbnail_custom_sizer">
					    <input type="number" name="ws_thumb_width" id="ws_thumb_width" value="<?php echo $ws['ws_thumb_width']; ?>" class="number" disabled="disabled" /> x
					    <input type="number" name="ws_thumb_height" id="ws_thumb_height" value="<?php echo $ws['ws_thumb_height']; ?>" class="number" disabled="disabled" />
				    </span>
			    </div>
			</td>
	    </tr>
<?php endif; ?>	    
	    </tbody>
	    </table>
	</div>
</section>

<?php if ( $w == 'u' ) : ?>
<section id="anc_ws_design">
	<h2 class="h2_frm">이미지 슬라이드 테마/효과 설정</h2>
	<?php echo $pg_anchor ?>
	
	<div class="tbl_frm01 tbl_wrap">
	    <table>
	    <caption>이미지 슬라이드 테마/효과 설정</caption>
	    <colgroup>
	        <col class="grid_4">
	        <col>
	    </colgroup>
	    <tbody>
	    <tr>
	        <th scope="row"><label for="ws_id">이미지 사이즈</label></th>
	        <td>
<!--
	            <select name="ws_image_size" id="ws_image_size">
			        <option value="960x360">960x360</option>
			        <option value="960x300">960x300</option>
			        <option value="830x360">830x360</option>
			        <option value="640x360" selected="selected">640x360</option>
			        <option value="320x240">320x240</option>
			        <option value="480x360">480x360</option>
			        <option value="640x480">640x480</option>
			        <option value="800x600">800x600</option>
			        <option value="None">Custom Size</option>
		        </select>
-->
		        <span id="custom_sizer" >
			        <input type="number" name="ws_image_width" id="ws_image_width" value="<?php echo $ws['ws_image_width']; ?>" class="number" /> x <input type="number" name="ws_image_height" id="ws_image_height" value="<?php echo $ws['ws_image_height']; ?>" class="number" />
			    </span>
		        <select name="ws_size_style" id="ws_size_style">
			        <option value="1"<?php echo $ws_slider_layout['boxed']; ?>>Boxed</option>
			        <option value="2"<?php echo $ws_slider_layout['full_width']; ?>>Full Width</option>
			        <option value="3"<?php echo $ws_slider_layout['full_screen']; ?>>Full Screen</option>
		        </select>
	        </td>
	    </tr>
	    <tr>
	        <th scope="row"><label for="ws_id">폰트</label></th>
	        <td>
		        <input type="text" name="ws_font_color" id="ws_font_color" value="<?php echo $ws['ws_font_color'] ? $ws['ws_font_color'] : '#000000'; ?>" class="frm_input" size="10" />
		        <select name="ws_font_family" id="ws_font_family">
<?php foreach( $fonts as $font => $font_info ) : ?>			        
					<option value="<?php echo $font; ?>"<?php echo ( $font == trim($ws['ws_font_family']) ? ' selected="selected" ' : '' ); ?>><?php echo $font; ?></option>
<?php endforeach; ?>					
		        </select>
		        <input type="number" name="ws_font_size" id="ws_font_size" value="<?php echo ( $ws['ws_font_size'] ? $ws['ws_font_size'] : 12 ); ?>" class="frm_input number" size="10" />
	        </td>
	    </tr>
	    <tr>
		    <th scope="row"><label for="ws_template">테마</label></th>
		    <td>
			    <div>
				    <select name="ws_template" id="ws_template">
<?php foreach ($templates as $template) :?>					    
				    	<option value="<?php echo $template; ?>"<?php echo ( $ws['ws_template'] == $template ? ' selected="selected" ' :'' ); ?>><?php echo $template; ?></option>
<?php endforeach; ?>
				    </select>
			    </div>
			    <div>
				    <img src="./templates/backgnd/<?php echo ( $ws['ws_template'] ? $ws['ws_template'] : 'absent' ); ?>/thumbnail.png" alt="template preview" id="template-preview" />
			    </div>
		    </td>
	    </tr>
	    
	    <tr>
		    <th scope="row"><label for="ws_effect">효과</label></th>
		    <td>
			    <label for="ws_multiple_effects"><input type="checkbox" name="ws_multiple_effects" id="ws_multiple_effects" value="Y" <?php echo $ws_multiple_effects; ?> /> 다중 선택</label>
			    <div>
				    <ul class="effects-list">
<?php foreach ( $effects as $effect) : $selected = ( in_array( $effect, $ws_image_effect ) ? ' checked="checked" ' : '' ); ?>
				    	<li><input type="<?php echo $ws['ws_multiple_effects'] == 'Y' ? 'checkbox' : 'radio'; ?>" name="<?php echo $ws['ws_multiple_effects'] == 'Y' ? 'ws_image_effect[]' : 'ws_image_effect'; ?>" id="ws_image_effect_<?php echo $effect; ?>" value="<?php echo $effect; ?>" class="effects"<?php echo $selected; ?> /> <label for="ws_image_effect_<?php echo $effect; ?>"><?php echo $effect; ?></label></li>
				    
<?php endforeach; ?>	
				    </ul>			    
			    </div>
		    </td>
	    </tr>
	    
	    <tr>
		    <th scope="row"><label for="ws_delay">시간</label></th>
		    <td>
				<dl class="clearfix ws_slide_time">
					<dt>대기시간</dt>
					<dd><input type="number" name="ws_delay" id="ws_delay" class="frm_input number" value="<?php echo ( $ws['ws_delay'] ? $ws['ws_delay'] : 20 ); ?>" /> </dd>
					<dt>이동시간</dt>
					<dd><input type="number" name="ws_duration" id="ws_duration" class="frm_input number" value="<?php echo ( $ws['ws_duration'] ? $ws['ws_duration'] : 20 ); ?>" /> </dd>
				</dl>
				<?php echo help("시간*100/1000초 단위 이므로 10단위가 1초입니다."); ?>
		    </td>
	    </tr>
	    <tr>
		    <th scope="row"><label for="ws_onstep_func">OnBefore 함수</label></th>
		    <td>
			   <input type="text" name="ws_onbefore_func" value="<?php echo $ws['ws_onbefore_func']; ?>" id="ws_onbefore_func" class="frm_input" size="50" /> 
		    </td>
	    </tr>
	    <tr>
		    <th scope="row"><label for="ws_onstep_func">OnStep 함수</label></th>
		    <td>
			   <input type="text" name="ws_onstep_func" value="<?php echo $ws['ws_onstep_func']; ?>" id="ws_onstep_func" class="frm_input" size="50" /> 
		    </td>
	    </tr>
	    
	    <tr>
		    <th scope="row"><label for="ws_override_css">추가/변경 CSS</label></th>
		    <td>
				<textarea name="ws_override_css" id="ws_override_css" style="width: 100%; height: 150px;" placeholder="style.css 하단에 입력하여 생성된 CSS를 변경 또는 재정의 한다."><?php echo $ws['ws_override_css']; ?></textarea>
				<?php echo help("style.css 하단에 입력하여 생성된 CSS를 변경 또는 재정의 한다.");?>
		    </td>
	    </tr>
	    </tbody>
	    </table>
	</div>
</section>

<section id="anc_ws_images">
	<h2 class="h2_frm">이미지 슬라이드 이미지 설정</h2>
	<?php echo $pg_anchor ?>
	<div id="ws_images" class="tbl_frm01 tbl_wrap">
		<div class="ws_images_buttons">
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>" id="add_image" class="btn_frmline" >추가</a>
			<a href="<?php echo $_SERVER['REQUEST_URI']; ?>" id="remove_image" class="btn_frmline">삭제</a>
			<span class="help">이미지를 <strong>더블클릭</strong> 하시면 수정이 가능합니다.</span>
		</div>
		<div class="ws_images_wrap">
			<ul id="ws_images_ul" class="clearfix">
				<li class="empty_item">이미지를 추가해 주세요.</li>
			</ul>
		</div>
	</div>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./wowslider_list.php">목록</a>
</div>
</form>
<div id="ws_image_dialog" title="슬라이드 이미지 설정">
	<?php require(dirname(__FILE__) . '/image_form.inc.php'); ?>
</div>
<?php endif; // if ( $w == 'u' ) ?>
<?php include_once( G5_ADMIN_PATH.'/admin.tail.php' ); ?>