<?php
$sub_menu = "100990";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

// 다국어 지원 여부
if (!isset($config['cf_use_i18n'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_use_i18n` tinyint(4) NOT NULL DEFAULT 0 AFTER `cf_kakao_js_apikey`,
                    ADD `cf_language` varchar(255) NOT NULL DEFAULT '' AFTER `cf_use_i18n` ");
}
if (!isset($config['cf_i18n_default'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_i18n_default` varchar(20) NOT NULL DEFAULT 'ko' AFTER `cf_use_i18n` ");
}
if (!isset($config['cf_use_i18n_layout'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_use_i18n_layout` tinyint(4) NOT NULL DEFAULT 0 AFTER `cf_use_i18n` ");
}
if (!isset($config['cf_use_i18n_board'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_use_i18n_board` tinyint(4) NOT NULL DEFAULT 0 AFTER `cf_use_i18n` ");
}

$g5['title'] = "다국어 지원";
include_once(G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="'.G5_URL.'/">메인으로</a>
</div>';
?>

<form class="" action="config_form_update.php" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section id="anc_cf_i18n">
    <h2 class="h2_frm"></h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>다국어 설정</caption>
        <tbody>
        <tr>
            <th scope="row">다국어 사용</th>
            <td><label for="cf_use_i18n"><input type="checkbox" name="cf_use_i18n" id="cf_use_i18n" value="1"<?php echo ($config['cf_use_i18n'] ? ' checked' : ''); ?> /> 다국어 사용</label></td>
        </tr>
        <tr>
            <th scope="row">다국어 기본 언어 설정</th>
            <td>
                <label for="default_ko"><input type="radio" name="cf_i18n_default" id="default_ko" value="ko"<?php echo ($config['cf_i18n_default'] == 'ko'  ? ' checked' : ''); ?> /> 한국어</label>
                <label for="default_en"><input type="radio" name="cf_i18n_default" id="default_en" value="en"<?php echo ($config['cf_i18n_default'] == 'en' ? ' checked' : ''); ?> /> 영어</label>
                <label for="default_ja"><input type="radio" name="cf_i18n_default" id="default_ja" value="ja"<?php echo ($config['cf_i18n_default'] == 'ja' ? ' checked' : ''); ?> /> 일본어</label>
                <label for="default_zh-CN"><input type="radio" name="cf_i18n_default" id="default_zh-CN" value="zh-CN"<?php echo ($config['cf_i18n_default'] == 'zh-CN' ? ' checked' : ''); ?> /> 중국어</label>
                <label for="default_ru"><input type="radio" name="cf_i18n_default" id="default_ru" value="ru"<?php echo ($config['cf_i18n_default'] == 'ru' ? ' checked' : ''); ?> /> 러시아어</label>
                <label for="default_de"><input type="radio" name="cf_i18n_default" id="default_de" value="de"<?php echo ($config['cf_i18n_default'] == 'de' ? ' checked' : ''); ?> /> 독일어</label>
            </td>
        </tr>
        <tr>
            <th scope="row">다국어 언어 설정</th>
            <td>
                <label for="language_ko"><input type="checkbox" name="language[ko]" id="language_ko" value="한국어"<?php echo (isset($config['cf_language']) && array_key_exists('ko', (array)$config['cf_language']) ? ' checked' : ''); ?> /> 한국어</label>
                <label for="language_en"><input type="checkbox" name="language[en]" id="language_en" value="English"<?php echo (isset($config['cf_language']) && array_key_exists('en', (array)$config['cf_language']) ? ' checked' : ''); ?> /> 영어</label>
                <label for="language_ja"><input type="checkbox" name="language[ja]" id="language_ja" value="日本語"<?php echo (isset($config['cf_language']) && array_key_exists('ja', (array)$config['cf_language']) ? ' checked' : ''); ?> /> 일본어</label>
                <label for="language_zh-CN"><input type="checkbox" name="language[zh-CN]" id="language_zh-CN" value="简体中文"<?php echo (isset($config['cf_language']) && array_key_exists('zh-CN', (array)$config['cf_language']) ? ' checked' : ''); ?> /> 중국어</label>
                <label for="language_ru"><input type="checkbox" name="language[ru]" id="language_ru" value="Русский"<?php echo (isset($config['cf_language']) && array_key_exists('ru', (array)$config['cf_language']) ? ' checked' : ''); ?> /> 러시아어</label>
                <label for="language_de"><input type="checkbox" name="language[de]" id="language_de" value="Deutsch"<?php echo (isset($config['cf_language']) && array_key_exists('de', (array)$config['cf_language']) ? ' checked' : ''); ?> /> 독일어</label>
            </td>
        </tr>
        <tr>
            <th scope="row">분리 사용</th>
            <td>
                <label for="cf_use_i18n_layout"><input type="checkbox" name="cf_use_i18n_layout" id="cf_use_i18n_layout" value="1"<?php echo ($config['cf_use_i18n_layout'] ? ' checked' : ''); ?>> 레이아웃 분리</label>
                <label for="cf_use_i18n_board"><input type="checkbox" name="cf_use_i18n_board" id="cf_use_i18n_board" value="1"<?php echo ($config['cf_use_i18n_board'] ? ' checked' : ''); ?>> 게시판 분리</label>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
</form>
<script>
function fconfigform_submit(f) {
    // 다국어 사용이고 다국어 언어를 사용하지 않은 경우
    if ( $('input#cf_use_i18n').is(':checked') && $('input[name^="language"]:checked').size() == 0 ) {
        alert('다국어 사용 시 언어는 하나 이상 선택해 주셔야 합니다.');
        return false;
    }
    return true;
}
</script>
<?php include_once(G5_ADMIN_PATH.'/admin.tail.php'); ?>
