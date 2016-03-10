<?php
$sub_menu = "110100";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$token = get_token();

// 메뉴테이블 생성
if( !isset($g5['menu_table']) ){
    die('<meta charset="utf-8">dbconfig.php 파일에 <strong>$g5[\'menu_table\'] = G5_TABLE_PREFIX.\'menu\';</strong> 를 추가해 주세요.');
}

if(!sql_query(" DESCRIBE {$g5['menu_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['menu_table']}` (
                  `me_id` int(11) NOT NULL AUTO_INCREMENT,
                  `me_code` varchar(255) NOT NULL DEFAULT '',
                  `me_name` varchar(255) NOT NULL DEFAULT '',
                  `me_link` varchar(255) NOT NULL DEFAULT '',
                  `me_target` varchar(255) NOT NULL DEFAULT '0',
                  `me_order` int(11) NOT NULL DEFAULT '0',
                  `me_use` tinyint(4) NOT NULL DEFAULT '0',
                  `me_mobile_use` tinyint(4) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`me_id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}

$sql = " select * from {$g5['menu_table']} order by me_code,me_id ";
$result = sql_query($sql);

$g5['title'] = "메뉴설정";
include_once(G5_ADMIN_PATH .'/admin.head.php');

$colspan = 8;
?>

<div class="local_desc01 local_desc">
    <p><strong>주의!</strong> 메뉴설정 작업 후 반드시 <strong>확인</strong>을 누르셔야 저장됩니다.</p>
</div>

<form name="fmenulist" id="fmenulist" method="post" action="./menu_list_updateAll.php" onsubmit="return fmenulist_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>">

<div class="btn_add01 btn_add">
    <button type="button" onclick="return add_menu();">메뉴추가<span class="sound_only"> 새창</span></button>
</div>

<div id="menulist" class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">메뉴</th>
		<th scope="col">코드</th>
        <th scope="col">링크</th>
        <th scope="col">새창</th>
        <th scope="col">순서</th>
        <th scope="col">PC사용</th>
        <th scope="col">모바일사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $bg = 'bg'.($i%2);
        $sub_menu_class = '';
		$depth=strlen($row['me_code'])/2;
        if(strlen($row['me_code']) >= 4) {
            $sub_menu_class = ' sub_menu_class'.$depth;
            $sub_menu_info = '<span class="sound_only">'.$row['me_name'].'의 서브</span>';
            $sub_menu_ico = '<span class="sub_menu_ico"></span>';
        }

        $search  = array('"', "'");
        $replace = array('&#34;', '&#39;');
        $me_name = str_replace($search, $replace, $row['me_name']);

        // 메뉴 인덱스 탭
        $sub_menu_style = ' style="background:url(./sub_menu_ico' . $depth . '.gif) no-repeat 5px center;padding-left:' . (($depth-1)*25) . 'px" ';
    ?>
    <tr class="<?php echo $bg; ?> menu_list menu_group_<?php echo $row['me_code']; ?>">
        <td class="td_category<?php echo $sub_menu_class; ?>"<?php echo $sub_menu_style; ?>>
			<input type="hidden" name="me_id[]" value="<?php echo $row['me_id'] ?>">
            <input type="hidden" name="code[]" value="<?php echo $row['me_code'] ?>">
            <label for="me_name_<?php echo $i; ?>" class="sound_only"><?php echo $sub_menu_info; ?> 메뉴<strong class="sound_only"> 필수</strong></label>
            <?php echo $sub_icon; ?>
            <input type="text" name="me_name[]" value="<?php echo $me_name; ?>" id="me_name_<?php echo $i; ?>" required class="required frm_input full_input">
        </td>
        <td class="td_mng" style="text-align:left;letter-spacing:0px;"><h3><?php echo $row['me_code'] ?></h3></td>
        <td>
            <label for="me_link_<?php echo $i; ?>" class="sound_only">링크<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="me_link[]" value="<?php echo $row['me_link'] ?>" id="me_link_<?php echo $i; ?>" required class="required frm_input full_input">
        </td>
        <td class="td_mng">
            <label for="me_target_<?php echo $i; ?>" class="sound_only">새창</label>
            <select name="me_target[]" id="me_target_<?php echo $i; ?>">
                <option value="self"<?php echo get_selected($row['me_target'], 'self', true); ?>>사용안함</option>
                <option value="blank"<?php echo get_selected($row['me_target'], 'blank', true); ?>>사용함</option>
            </select>
        </td>
        <td class="td_num">
            <label for="me_order_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="me_order[]" value="<?php echo $row['me_order'] ?>" id="me_order_<?php echo $i; ?>" class="frm_input" size="5">
        </td>
        <td class="td_mng">
            <label for="me_use_<?php echo $i; ?>" class="sound_only">PC사용</label>
            <select name="me_use[]" id="me_use_<?php echo $i; ?>">
                <option value="1"<?php echo get_selected($row['me_use'], '1', true); ?>>사용함</option>
                <option value="0"<?php echo get_selected($row['me_use'], '0', true); ?>>사용안함</option>
            </select>
        </td>
        <td class="td_mng">
            <label for="me_mobile_use_<?php echo $i; ?>" class="sound_only">모바일사용</label>
            <select name="me_mobile_use[]" id="me_mobile_use_<?php echo $i; ?>">
                <option value="1"<?php echo get_selected($row['me_mobile_use'], '1', true); ?>>사용함</option>
                <option value="0"<?php echo get_selected($row['me_mobile_use'], '0', true); ?>>사용안함</option>
            </select>
        </td>
        <td class="td_mng">
            <?php if(strlen($row['me_code']) < 7) { ?>
            <button type="button" class="btn_add_submenu">추가</button>
            <?php } ?>
			<button type="button" class="btn_edit_menu">변경</button>
            <button type="button" class="btn_del_menu">삭제</button>
        </td>
    </tr>
    <?php
    }

    if ($i==0)
        echo '<tr id="empty_menu_list"><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" name="act_button" value="확인" class="btn_submit">
</div>

</form>

<script>
$(function() {
    $(document).on("click", ".btn_add_submenu", function() {
        var code = $(this).closest("tr").find("input[name='code[]']").val();
        add_submenu(code);
    });

    $(document).on("click", ".btn_edit_menu", function() {
        if(!confirm("메뉴를 변경하시겠습니까?"))
            return false;
		var f = document.frm_update;
		f.me_id.value = $(this).closest("tr").find("input[name='me_id[]']").val();
		f.me_name.value = $(this).closest("tr").find("input[name='me_name[]']").val();
		f.me_link.value = $(this).closest("tr").find("input[name='me_link[]']").val();
		f.me_target.value = $(this).closest("tr").find("select[name='me_target[]']").val();
		f.me_order.value = $(this).closest("tr").find("input[name='me_order[]']").val();
		f.me_use.value = $(this).closest("tr").find("select[name='me_use[]']").val();
		f.me_mobile_use.value = $(this).closest("tr").find("select[name='me_mobile_use[]']").val();
		f.submit();

    });


    $(document).on("click", ".btn_del_menu", function() {
        if(!confirm("메뉴를 삭제하시겠습니까?"))
            return false;
		var me_id = $(this).closest("tr").find("input[name='me_id[]']").val();
		assa.location.href="./menu_list_delete.php?me_id="+me_id;
    });
});

function add_menu()
{
    var max_code = base_convert(0, 10, 36);
    $("#menulist tr.menu_list").each(function() {
        var me_code = $(this).find("input[name='code[]']").val().substr(0, 2);
        if(max_code < me_code)
            max_code = me_code;
    });

    var url = "./menu_form.php?code="+max_code+"&new=new";
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function add_submenu(code)
{
    var url = "./menu_form.php?code="+code;
    window.open(url, "add_menu", "left=100,top=100,width=550,height=650,scrollbars=yes,resizable=yes");
    return false;
}

function base_convert(number, frombase, tobase) {
  //  discuss at: http://phpjs.org/functions/base_convert/
  // original by: Philippe Baumann
  // improved by: Rafał Kukawski (http://blog.kukawski.pl)
  //   example 1: base_convert('A37334', 16, 2);
  //   returns 1: '101000110111001100110100'

  return parseInt(number + '', frombase | 0)
    .toString(tobase | 0);
}

function fmenulist_submit(f)
{
	if(confirm('변경사항을 저장 하시겠습니까?')){
		return true;
	}

	return false;
}
</script>
<form name="frm_update" method="post" action="./menu_list_update.php" target="assa">
<input type="hidden" name="me_id" value="">
<input type="hidden" name="me_name" value="">
<input type="hidden" name="me_link" value="">
<input type="hidden" name="me_target" value="">
<input type="hidden" name="me_order" value="">
<input type="hidden" name="me_use" value="">
<input type="hidden" name="me_mobile_use" value="">
</form>

<iframe name="assa" src="about:blank" width="10" height="1" frameborder="0"></iframe>

<?php
include_once (G5_ADMIN_PATH .'/admin.tail.php');
?>
