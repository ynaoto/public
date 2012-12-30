<?php
require("k2n.php");

if (isset($_POST["knum"])) {
    $knum = $_POST["knum"];
}

$tv = [
"五千九百弐拾参万四千弐百七拾壱円",
"弐佰参拾玖萬質仟肆佰弐拾壱円也",
"弐百参拾九万七千四百弐拾壱円",
"弐百参拾九萬七千四百弐拾壱円",
"壱萬圓",
];
?>
<html>
    <head>
        <title>k2n test</title>
        <meta http-equiv=content-type content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php foreach ($tv as $v): ?>
            <form action="k2n_test.php" method="post">
                <input type="text" name="knum" value="<?=$v?>" />
                <input type="submit" />
            </form>
        <?php endforeach; ?>
        <?php
            if (isset($knum)) {
                echo "$knum → ".k2n($knum);
            }
        ?>
    </body>
</html>
