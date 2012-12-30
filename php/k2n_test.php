<?php
require("k2n.php");

if (isset($_POST["knum"])) {
    $knum = $_POST["knum"];
}

$tv = [
"五千九百弐拾参万四千弐百七拾壱円",
"金弐佰参拾玖萬質仟肆佰弐拾壱円也",
"弐百参拾九万七千四百弐拾壱円",
"弐百参拾九萬七千四百弐拾壱円",
"願いましては弐百参拾九萬七千四百弐拾壱円也、金壱萬圓也・・・",

/* 以下は、http://www.benricho.org/moji_conv/07.html より引用 */
"千百十一",
"一一一一",
"五万",
"五萬",
"一千万",
"壱千万",
"六百八十五",
"六八五",
"三万四千",
"三四〇〇〇",
"十九万六百八十七",
"一九万六八七",
"一九〇六八七",
"一億百八",
"一〇〇〇〇〇一〇八",
"二十一億四千七百四十八万三千六百四十七",
"二一四七四八三六四七",
"拾弐億参千四百五拾六萬七千八百九拾",
"一二三四五六七八九〇",
"五千九百卅参万四千弐百廿壱円",
"伍阡玖佰參拾参万肆仟弐陌貳拾壱円",
"一兆三億五千九百八十六万四千弐百七十質円",
"壹兆參億伍阡玖佰捌拾陸万肆仟弐陌漆拾柒円",
"二葉亭四迷",
"直木三十五",
"山口百恵",
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
