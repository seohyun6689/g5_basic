$(document).ready(function(){
	// 이미지
	$( "#ws_image_dialog" ).dialog({
      autoOpen: false,
      height: 300,
      width: 500,
      modal: true,
      buttons : {
	      '확인' : function(){ $('#image_item_form').submit(); },
	      '취소' : function(){ $(this).dialog("close"); }
      }
    });
	$('#ws_images a').live('click',function(){
		$('#ws_images a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
	
	$('#ws_images .ws_images_wrap a').live('dblclick', function(){
		var ws_id = $('#ws_id').val();
		var wsi_id = $(this).attr('wsi_id');
		var param = {'image_w' : 'u', 'ws_id' : ws_id, 'wsi_id' : wsi_id};
		image_form(param, dialog_open);
		return false;
	});
	
	$('#ws_images #add_image').bind('click', function(){
		var ws_id = $('#ws_id').val();
		var param = {'ws_id' : ws_id};
		image_form(param, dialog_open);
		return false;
	});
	
	$('#ws_images #remove_image').bind('click', function(){
		var active = $('#ws_images .ws_images_wrap a.active');
		var wsi_id = active.attr('wsi_id');
		
		if ( wsi_id == undefined )
		{
			alert('삭제하실 이미지를 선택해 주세요.');
			return false;
		}
		else
		{
			if (confirm('선택하신 이미지를 삭제하시겠습니까?'))
			{
				$.get('ajax.image_delete.php', {'wsi_id' : wsi_id}, function(){
					image_load(); // image reload
				});
			}
		}
		
		return false;
	});

	image_load();
	
	// 이미지 정렬
	$('#ws_images_ul').sortable({
		cursor: 'move',
		opacity: 0.65,
		revert: true,
		stop: function(){
			var sortables = $(this).sortable('toArray');
			$.post('ajax.image.sortable.php',{'sortables' : sortables});
		}
	});
	$('#ws_images_ul').disableSelection();

});

// 이미지 등록창 컨트롤
function image_form(param, callback)
{
	$.get('./image_form.inc.php', param, callback);
}

// 이미지 등록/수정 전송
function image_upload(form)
{
	//grab all form data  
    var ws_id = $('#ws_id').val();
	var param = { 'ws_id' : ws_id };
	$(form).ajaxSubmit({
		success : function(responseText, statusText, xhr, $form){
			if ( $.trim(responseText) != '' )
			{
				alert( responseText );
			}
			else
			{
				image_form( param, image_insert_complate );
			}
		}
	});
}

// 이미지 항목 불러오기
function image_load()
{
	var ws_id = $('#ws_id').val();
	var param = {'ws_id' : ws_id};
	
	$.getJSON('ajax.image_list.php', param, function(response){
		// console.log( response );
		if ( response.error )
		{
			alert( response.error );
			return false;
		}
		else
		{
			$('#ws_images_ul').empty();
			if ( response.length > 0 )
			{
				$.each( response, function(i, o){
					// console.log(o);
					$img = $('<img src="' + image_url + '/' + o.wsi_file + '" alt="' + o.wsi_source + '" title="' + o.wsi_title + '" />');
					$input = $('<input type="hidden" name="wsi_id[]" value="' + o.wsi_id + '" />');
					$a = $('<a />').attr({'href':'#;', 'wsi_id': o.wsi_id}).append( $img ).append($input);
					if ( o.wsi_disable == 'Y' )
					{
						$a.addClass('disable');
					}
					$li = $('<li/>').attr('id', o.wsi_id).append( $a );
					$('#ws_images_ul').append( $li );
				});
			}
			else
			{
				$li = $('<li class="empty_item">이미지를 추가해 주세요.</li>');
				$('#ws_images_ul').append( $li );
			}
		}
	});
}

// 이미지 입력창 오픈
function dialog_open(response){
	$('#ws_image_dialog').html( response );
	$( "#ws_image_dialog" ).dialog( "open" );
}


// 이미지 등록/수정 완료
function image_insert_complate(response)
{
	$('#ws_image_dialog').html( response );
	$( "#ws_image_dialog" ).dialog('close');
	
	image_load();	// image reload
}


