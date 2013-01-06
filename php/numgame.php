<?php
session_start();

if (isset($_POST["name"])) {
    $name = $_POST["name"];
} else if (isset($_SESSION["name"])) {
    $name = $_SESSION["name"];
} else {
    $name = null;
}

if (isset($_SESSION["ans"])) {
    $ans = $_SESSION["ans"];
} else {
    $ans = rand(1, 100);
}

if (isset($_SESSION["count"])) {
    $count = $_SESSION["count"];
} else {
    $count = 1;
}

if (isset($_POST["num"])) {
    $num = $_POST["num"];
    $count++;
}

?>
<html>
    <head>
        <title>数当てゲーム</title>
        <meta http-equiv=content-type content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php if (!isset($name)): ?>
            <form action="numgame.php" method="post">
                 あなたのお名前は？<input type="text" name="name" />
                 <input type="submit" />
            </form>
        <?php elseif (isset($num) && $num == $ans): ?>
            <?=$name?>さん、<?=$count-1?>回目に正解！
            <?php
                $name = null;
                $ans = null;
                $count = null;
            ?>
            <a href="">リトライ</a>
        <?php else: ?>
            <?=$name?>さん、<?=$count?>回目の挑戦！
            <?php if (!isset($num)): ?>
                1～100の数を入れてみて
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
$_SESSION["name"] = $name;
$_SESSION["ans"] = $ans;
$_SESSION["count"] = $count;
?>
