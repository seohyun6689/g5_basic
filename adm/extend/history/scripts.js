$(function(){
	
	// 그룹관리
	var _loading = $('<div />').attr('id', 'loading').html('<img src="./images/ajax-loader.gif" alt="loading" />').css({
		'position' : 'absolute',
		'left' : '50%',
		'top' : '50%',
		'margin-left' : -50,
		'margin-top' : -50
	});
	var _dialog = $('#dialog').dialog({
		autoOpen: false,
		modal: true,
		width: 400,
		height: 700,
		title: '그룹관리',
		buttons : { 
			'추가' : add_group_element,
			'확인' : group_submit,
			'취소' : function(){
				$(this).dialog('close');
			}
		}
	});	
	$('#open_history_group').bind('click', function(){
		_dialog.html(_loading);
		_dialog.dialog('open');
		_dialog.load('./history_group.php?his_id=' + $('#his_id').val() );
		return false;
	});
	
	$(document).on('dblclick', 'input.group_subject', function(){
		var $group = $(this).parents('tr');
		var group_id = $(this).prev('input').val();
		
		if ( group_id != '' ) {
			$('#group-form').append('<input type="hidden" name="delete_groups[]" value="' + group_id + '" />');
		}
		$group.remove();
	});
	
	function group_submit() {
		var group_serialize = $('#group-form').serialize();
		_dialog.append(_loading);
		_dialog.find('#group-form, .helper').hide();
		$.post('./history_group_update.php', group_serialize, function(response){
			_dialog.load('./history_group.php?his_id=' + $('#his_id').val() );
		});
	}
	function add_group_element() {
		var html = '<tr> \
					<td> \
						<input type="hidden" name="group_id[]" value="" /> \
						<input type="text" name="group_subject[]" value="" class="group_subject frm_input frm_input_block" placeholder="예) 2015~현재" /></td> \
					<td> \
						<input type="text" name="group_sort[]" value="" class="frm_input frm_input_block" placeholder="정렬" /> \
					</td> \
				</tr>';
		$('#history-group-list>tbody').append(html);
	}
	
	// 항목관리
	var _his_id = $('#his_id').val();
	var _groups, _group_el;
	HISTORY_ITEM = {
		init: function(){
		
			HISTORY_ITEM.setup();
			$('#add_history_item').bind('click', HISTORY_ITEM.add );
			$(document).on('click', '.btn_item_remove', HISTORY_ITEM.remove);
		},
		add: function(){
			$.get('./ajax.get_item_list.php?mode=add&his_id='+_his_id, function(response){
				$('#history_item tbody').append(response);
			});
			return false;
		},
		remove: function(){
			var item = $(this).parents('tr');
			var item_id_el = $(this).prev('input').clone();
			$('#frmwowmasterform').append( item_id_el.attr('name' , 'delete_item[]') );
			item.remove();
			return false;
		},
		setup: function(response){
			$('#history_item tbody').load('./ajax.get_item_list.php?his_id=' + _his_id);
		}
	}
	HISTORY_ITEM.init();
});