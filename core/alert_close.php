<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');

$msg2 = str_replace("\\n", "<br>", $msg);

if($error) {
    $header2 = __(core_a643);
    $msg3 = __(core_a1);
} else {
    $header2 = __(core_a644);
    $msg3 = __(core_a2);
}
?>

<script>
alert("<?php echo $msg; ?>");
window.close();
</script>

<noscript>
<div id="validation_check">
    <h1><?php echo $header2 ?></h1>
    <p class="cbg">
        <?php echo $msg2 ?>
    </p>
    <p class="cbg">
        <?php echo $msg3 ?>
    </p>

</div>

<?php /*
<article id="validation_check">
<header>
    <hgroup>
        <!-- <h1>회원가입 정보 입력 확인</h1> --> <!-- 수행 중이던 작업 내용 -->
        <h1><?php echo $header ?></h1> <!-- 수행 중이던 작업 내용 -->
        <h2><?php echo $header2 ?></h2>
    </hgroup>
</header>
<p>
    <!-- <strong>항목</strong> 오류내역 -->
    <!--
    <strong>이름</strong> 필수 입력입니다. 한글만 입력할 수 있습니다.<br>
    <strong>이메일</strong> 올바르게 입력하지 않았습니다.<br>
    -->
    <?php echo $msg2 ?>
</p>
<p>
    <?php echo $msg3 ?>
</p>

</article>
*/ ?>

</noscript>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>
