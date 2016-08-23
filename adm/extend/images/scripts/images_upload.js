$(document).ready(function(){
	// 이미지
	$( "#image_dialog" ).dialog({
      autoOpen: false,
      height: 300,
      width: 500,
      modal: true,
      buttons : {
	      '확인' : function(){ $('#image_item_form').submit(); },
	      '취소' : function(){ $(this).dialog("close"); }
      }
    });
	$('#images a').live('click',function(){
		$('#images a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
	
	$('#images .images_wrap a').live('dblclick', function(){
		var img_id = $('#img_id').val();
		var img_item_id = $(this).attr('img_item_id');
		var param = {'image_w' : 'u', 'img_id' : img_id, 'img_item_id' : img_item_id};
		image_form(param, dialog_open);
		return false;
	});
	
	$('#images #add_image').bind('click', function(){
		var img_id = $('#img_id').val();
		var param = {'img_id' : img_id};
		image_form(param, dialog_open);
		return false;
	});
	
	$('#images #remove_image').bind('click', function(){
		var active = $('#images .images_wrap a.active');
		var img_item_id = active.attr('img_item_id');

		if ( typeof img_item_id == 'undefined' )
		{
			alert('삭제하실 이미지를 선택해 주세요.');
			return false;
		}
		else
		{
			if (confirm('선택하신 이미지를 삭제하시겠습니까?'))
			{
				$.get('ajax.image_delete.php', {'img_item_id' : img_item_id}, function(){
					image_load(); // image reload
				});
			}
		}
		
		return false;
	});

	image_load();
	
	// 이미지 정렬
	$('#images_ul').sortable({
		cursor: 'move',
		opacity: 0.65,
		revert: true,
		stop: function(){
			var sortables = $(this).sortable('toArray');
			$.post('ajax.image.sortable.php',{'sortables' : sortables});
		}
	});
	$('#images_ul').disableSelection();

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
	var img_id = $('#img_id').val();
	var param = {'img_id' : img_id};
	
	$.getJSON('ajax.image_list.php', param, function(response){
		// console.log( response );
		if ( response.error )
		{
			alert( response.error );
			return false;
		}
		else
		{
			$('#images_ul').empty();
			if ( response.length > 0 )
			{
				$.each( response, function(i, o){
					// console.log(o);
					$img = $('<img src="' + image_url + '/' + o.img_item_file + '" alt="' + o.img_item_source + '" title="' + o.img_item_title + '" />');
					$input = $('<input type="hidden" name="img_item_id[]" value="' + o.img_item_id + '" />');
					$a = $('<a />').attr({'href':'#;', 'img_item_id': o.img_item_id}).append( $img ).append($input);
					if ( o.img_item_disable == 'Y' )
					{
						$a.addClass('disable');
					}
					$li = $('<li/>').attr('id', o.img_item_id).append( $a );
					$('#images_ul').append( $li );
				});
			}
			else
			{
				$li = $('<li class="empty_item">이미지를 추가해 주세요.</li>');
				$('#images_ul').append( $li );
			}
		}
	});
}

// 이미지 입력창 오픈
function dialog_open(response){
	$('#image_dialog').html( response );
	$( "#image_dialog" ).dialog( "open" );
}


// 이미지 등록/수정 완료
function image_insert_complate(response)
{
	$('#image_dialog').html( response );
	$( "#image_dialog" ).dialog('close');
	
	image_load();	// image reload
}


