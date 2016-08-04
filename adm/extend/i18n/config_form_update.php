<?php
$sub_menu = "100990";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

if (isset($_POST['language']) && is_array($_POST['language']) ) {
    foreach ($_POST['language'] as $key => $val) {
        $_POST['language'][$key] = urlencode($val);
    }
    $cf_language = urldecode(json_encode($_POST['language']));
}

$sql = " update {$g5['config_table']}
            set cf_use_i18n = '{$_POST['cf_use_i18n']}',
                cf_i18n_default = '{$cf_i18n_default}',
                cf_language = '{$cf_language}',
                cf_use_i18n_layout = '{$cf_use_i18n_layout}' ";
sql_query($sql);

goto_url('./config_form.php', false);
