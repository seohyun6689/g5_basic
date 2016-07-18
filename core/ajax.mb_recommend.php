<?php
include_once("./_common.php");
include_once(G5_LIB_PATH."/register.lib.php");

$mb_recommend = trim($_POST["reg_mb_recommend"]);

if ($msg = valid_mb_id($mb_recommend)) {
    die(L::recommend_validmbid);
}
if (!($msg = exist_mb_id($mb_recommend))) {
    die(L::recommend_existmbid);
}
?>
