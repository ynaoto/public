<?php
session_start();

if (isset($_SESSION["ans"])) {
    $ans = $_SESSION["ans"];
} else {
    $ans = rand(1, 100);
}

if (isset($_POST["num"])) {
    $num = $_POST["num"];
}
?>
<html>
    <head>
        <title>数当てゲーム</title>
        <meta http-equiv=content-type content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php if (isset($num) && $num == $ans): ?>
            正解！
            <?php $ans = null; ?>
            <a href="">リトライ</a>
        <?php else: ?>
            <?php if (!isset($num)): ?>
                1〜100! 
            <?php elseif ($num < $ans): ?>
                ちっちゃ！
            <?php elseif ($num > $ans): ?>
                でっか！
            <?php else: ?>
                なんか変・・・
            <?php endif; ?>
            <form action="numgame.php" method="post">
                 <input type="text" name="num" />
                 <input type="submit" />
            </form>
        <?php endif; ?>
    </body>
</html>
<?php
$_SESSION["ans"] = $ans;
?>
