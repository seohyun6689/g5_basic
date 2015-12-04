$(function(){	
	// 자동 재생
	$('#ws_auto_play').bind('change', function(){
		if ( $(this).is(':checked') )
		{
			$('#auto_play_option input').removeAttr('disabled');
		}
		else
		{
			$('#auto_play_option input').attr('disabled', 'disabled');
		}
	});
	$('#ws_auto_play').trigger('change');
	
	// 타이틀
	$('#ws_captions').bind('change', function(){
		if ($(this).is(':checked'))
		{
			$('#captions_option input').removeAttr('disabled');
		}
		else
		{
			$('#captions_option input').attr('disabled', 'disabled');			
		}
	});
	$('#ws_captions').trigger('change');
	
	// 컨트롤러
	$('#ws_show_bullet').bind('change', function(){
		if( $(this).is(':checked') )
		{
			$('input[name=ws_bullet_type]').removeAttr('disabled');
			var bullet = $('input[name=ws_bullet_type]:checked');
			if ( bullet.val() == 'bullet' )
			{
				$('select#ws_bullet_align').removeAttr('disabled');
				$('input#ws_bullet_thumb_prev').removeAttr('disabled');
				
				$('select#ws_filmstrip_align').attr('disabled', 'disabled');
				
				if ( $('input#ws_bullet_thumb_prev').is(':checked') )
				{
					$('select#ws_thumb_size').removeAttr('disabled');
					$('input#ws_thumb_width').removeAttr('disabled');
					$('input#ws_thumb_height').removeAttr('disabled');
				}
			}
			else
			{
				$('select#ws_bullet_align').attr('disabled', 'disabled');
				$('input#ws_bullet_thumb_prev').attr('disabled', 'disabled');
				
				$('select#ws_filmstrip_align').removeAttr('disabled');
				
				$('select#ws_thumb_size').removeAttr('disabled');
				$('input#ws_thumb_width').removeAttr('disabled');
				$('input#ws_thumb_height').removeAttr('disabled');
			}
		}
		else
		{
			$('#bullet_option select, #bullet_option input').attr('disabled', 'disabled');
		}
	});
	$('#ws_show_bullet').trigger('change');
	
	$('input#ws_bullet_thumb_prev').bind('change', function(){
		if ( $('input#ws_bullet_thumb_prev').is(':checked') )
		{
			$('select#ws_thumb_size').removeAttr('disabled');
			$('input#ws_thumb_width').removeAttr('disabled');
			$('input#ws_thumb_height').removeAttr('disabled');
		}
		else
		{
			$('select#ws_thumb_size').attr('disabled','disabled');
			$('input#ws_thumb_width').attr('disabled','disabled');
			$('input#ws_thumb_height').attr('disabled','disabled');
		}
	});
	$('input#ws_bullet_thumb_prev').trigger('change');
	
	$('input[name=ws_bullet_type]').bind('change', function(){
		var bullet = $('input[name=ws_bullet_type]:checked');
		if ( !bullet.is(':disabled') )
		{
			if ( bullet.val() == 'bullet' )
			{
				$('#ws_bullet_align').removeAttr('disabled');
				$('#ws_bullet_thumb_prev').removeAttr('disabled');
				if ( $('input#ws_bullet_thumb_prev').is(':checked') )
				{
					$('select#ws_thumb_size').removeAttr('disabled');
					$('input#ws_thumb_width').removeAttr('disabled');
					$('input#ws_thumb_height').removeAttr('disabled');
				}
				else
				{
					$('select#ws_thumb_size').attr('disabled','disabled');
					$('input#ws_thumb_width').attr('disabled','disabled');
					$('input#ws_thumb_height').attr('disabled','disabled');
				}
				
				$('#ws_filmstrip_align').attr('disabled', 'disabled');
			}
			else
			{
				$('#ws_filmstrip_align').removeAttr('disabled');
				$('select#ws_thumb_size').removeAttr('disabled');
				$('input#ws_thumb_width').removeAttr('disabled');
				$('input#ws_thumb_height').removeAttr('disabled');
				
				
				$('#ws_bullet_align').attr('disabled', 'disabled');
				$('#ws_bullet_thumb_prev').attr('disabled', 'disabled');
				
			}
		}
	});
	$('input[name=ws_bullet_type]').trigger('change');
	
	// 템플릿 상세보기
	$('select#ws_template').bind('change', function(){
		var template = $(this).val();
		$('img#template-preview').attr('src', './templates/backgnd/' + template + '/thumbnail.png');
	});
	
	// 효과 다중 선택 
	$('#ws_multiple_effects').bind('change, click', function(){

		if ( $(this).is(':checked') )
		{
			$('input.effects').replaceWith(function(){
				if ( $(this).is(':checked') ) checked = ' checked="checked" ';
				else checked = '';
				return '<input type="checkbox" name="ws_effects[]" id="ws_effect_'+$(this).val()+'" value="' + $(this).val() + '" class="effects"' + checked + ' />';
			});
		}
		else
		{
			var effects = $('input.effects').replaceWith(function(){
				if ( $(this).is(':checked') ) checked = ' checked="checked" ';
				else checked = '';
				return '<input type="radio" name="ws_effects" id="ws_effect_'+$(this).val()+'" value="' + $(this).val() + '" class="effects"'+checked+' />';
			});
		}
	});
});

