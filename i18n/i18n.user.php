<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

require_once(G5_I18N_PATH . '/i18n.class.php');

class G5_i18n extends i18n {
    public function __construct($filePath = NULL, $cachePath = NULL, $fallbackLang = NULL, $prefix = NULL)
    {
        parent::__construct($filePath, $cachePath, $fallbackLang, $prefix);
    }

    // 언어 선택 상자
    public function getLangSelectbox()
    {
        global $config;

        if (defined('G5_USE_I18N') && G5_USE_I18N && $config['cf_use_i18n']) {
            $config['cf_language'] = json_decode($config['cf_language']);
            $user_langs = $this->getUserLangs();

            $change_url = G5_I18N_URL . '/language.php?url=' . urlencode($_SERVER['REQUEST_URI']);
            if (G5_IS_ADMIN)  $change_url .= '&is_admin=1';
            $change_url .= '&lang=\'+this.value;';

            if (count($config['cf_language'])>0) {
                echo '<select onchange="location.href=\'' . $change_url . '">';
                foreach($config['cf_language'] as $key => $val) {
                    $selected = ( $user_langs[0] == $key ? ' selected' : '');
                    echo '<option value="' . $key . '"' . $selected . '>' . $val . '</option>';
                }
                echo '</select>';
            }
        }
    }
}

$i18n = new G5_i18n();
$i18n->setCachePath(G5_DATA_PATH . '/cache/i18n');
$i18n->setFilePath(G5_LANG_PATH . '/{LANGUAGE}.json'); // language file path
if ($config['cf_i18n_default']) {
    $i18n->setForcedLang($config['cf_i18n_default']);
}
if (isset($_GET['lang']) && trim($_GET['lang']) !== '') {
    $_SESSION['lang'] = $_GET['lang'];
}
$i18n->init();
$langs = $i18n->getUserLangs();
define('G5_I18N_LANG', $langs[0]);

// echo _(theme_t384);
