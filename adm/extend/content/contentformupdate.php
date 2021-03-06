<?php
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

@mkdir(G5_DATA_PATH."/content", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/content", G5_DIR_PERMISSION);


$contentpath = G5_DATA_PATH."/pages";
@mkdir($contentpath, G5_DIR_PERMISSION);
@chmod($contentpath, G5_DIR_PERMISSION);

@mkdir($contentpath."/mobile", G5_DIR_PERMISSION);
@chmod($contentpath."/mobile", G5_DIR_PERMISSION);


if ($co_himg_del)  @unlink(G5_DATA_PATH."/content/{$co_id}_h");
if ($co_timg_del)  @unlink(G5_DATA_PATH."/content/{$co_id}_t");

$sql_common = " co_include_head     = '$co_include_head',
                co_include_tail     = '$co_include_tail',
                co_html             = '$co_html',
                co_tag_filter_use   = '$co_tag_filter_use',
                co_subject          = '$co_subject',
                co_content          = '$co_content',
                co_mobile_content   = '$co_mobile_content',
                co_skin             = '$co_skin',
                co_mobile_skin      = '$co_mobile_skin' ";

if ($w == "")
{
    if(preg_match("/[^a-z0-9_]/i", $co_id)) alert("ID 는 영문자, 숫자, _ 만 가능합니다.");

    $sql = " select co_id from {$g5['content_table']} where co_id = '$co_id' ";

    if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
        $sql .= " and co_lang = '" . G5_I18N_LANG . "' ";
        $sql_common .= ", co_lang = '" . G5_I18N_LANG . "' ";
    }

    $row = sql_fetch($sql);
    if ($row['co_id'])
        alert("이미 같은 ID로 등록된 내용이 있습니다.");

    $sql = " insert {$g5['content_table']}
                set co_id = '$co_id',
                    $sql_common ";
    sql_query($sql);
}
else if ($w == "u")
{
    $sql = " update {$g5['content_table']}
                set $sql_common
              where co_id = '$co_id' ";

    if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
        $sql .= " and co_lang = '" . G5_I18N_LANG . "' ";
    }
    sql_query($sql);
}
else if ($w == "d")
{
    @unlink(G5_DATA_PATH."/content/{$co_id}_h");
    @unlink(G5_DATA_PATH."/content/{$co_id}_t");

    $sql = " delete from {$g5['content_table']} where co_id = '$co_id' ";
    if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
        $sql .= " and co_lang = '" . G5_I18N_LANG . "' ";
    }
    $result = sql_query($sql);
	if ($result) {
		@unlink(G5_DATA_PATH . '/pages/' . $co_id . (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n'] ? '.' . G5_I18N_LANG : '') . '.php');
		@unlink(G5_DATA_PATH . '/pages/mobile/' . $co_id . (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n'] ? '.' . G5_I18N_LANG : '') . '.php');
	}
}

if ($w == "" || $w == "u")
{
	if ( $fp = fopen($contentpath . "/" . $co_id . ( defined(G5_I18N_LANG) && G5_I18N_LANG ? '.'  . G5_I18N_LANG : '' ) . '.php', 'w+' ) ) {
		fwrite($fp, stripslashes($co_content));
		fclose($fp);
	}

	if ( $fp = fopen($contentpath . "/mobile/" . $co_id . ( defined(G5_I18N_LANG) && G5_I18N_LANG ? '.'  . G5_I18N_LANG : '' ) . '.php', 'w+' ) ) {
		fwrite($fp, stripslashes($co_mobile_content));
		fclose($fp);
	}

    if ($_FILES['co_himg']['name'])
    {
        $dest_path = G5_DATA_PATH."/content/".$co_id."_h";
        @move_uploaded_file($_FILES['co_himg']['tmp_name'], $dest_path);
        @chmod($dest_path, G5_FILE_PERMISSION);
    }
    if ($_FILES['co_timg']['name'])
    {
        $dest_path = G5_DATA_PATH."/content/".$co_id."_t";
        @move_uploaded_file($_FILES['co_timg']['tmp_name'], $dest_path);
        @chmod($dest_path, G5_FILE_PERMISSION);
    }

    goto_url("./contentform.php?w=u&amp;co_id=$co_id");
}
else
{
    goto_url("./contentlist.php");
}
?>
