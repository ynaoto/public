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

/* 以下は、http://www.accessclub.jp/samplefile/samplefile_140.htm より引用 */
"千六百九拾五万五千弐百 円",
"百弐拾五万五千四百五拾四 円",
"六拾五万五千百 円",
"弐万 円",
"弐百万 円",
"九万九千九百九拾九 円",
"六千九百五拾弐 円",
"四拾万 円",
"百弐拾五万六千弐百 円",
"弐拾弐万参千八百七拾九 円",
"百四 円",
"五万四千百拾 円",
"参拾弐万六千参百七拾 円",
"六百五拾弐 円",
"千九百六拾弐 円",
"百弐拾五万五千四百五拾四 円",
"六拾五万五千百 円",
"弐百拾万 円",
"四百拾弐万 円",
"七拾四 円",
"参万六千六百四拾 円",
"五百五拾六万参千 円",
"参拾弐万六千参百七拾 円",
"九千八百七拾六億五千四百参拾弐万千 円",
"九百八拾七億六千五百四拾参万弐千百 円",
"九拾八億七千六百五拾四万参千弐百拾 円",
"九億八千七百六拾五万四千参百弐拾壱 円",
"九千八百七拾六万五千四百参拾弐 円",
"九百八拾七万六千五百四拾参 円",
"九拾八万七千六百五拾四 円",
"九万八千七百六拾五 円",
"九千八百七拾六 円",
"九百八拾七 円",
"九拾八 円",
"九 円",
"兆千百拾億千百拾万千百拾壱 円",
"千百拾億千百拾万千百拾壱 円",
"百拾億千百拾万千百拾壱 円",
"拾億千百拾万千百拾壱 円",
"億千百拾万千百拾壱 円",
"千百拾万千百拾壱 円",
"百拾万千百拾壱 円",
"拾万千百拾壱 円",
"万千百拾壱 円",
"千百拾壱 円",
"百拾壱 円",
"拾壱 円",
"壱 円",
];

function k2n2s($k)
{
    return array_reduce(k2n($k), function($v, $w) {
        if (is_int($w)) {
            $v .= number_format($w);
            $v .= " [".n2k($w)."] ";
        } else {
            $v .= $w;
        }
        return $v;
    });
}
?>
<html>
    <head>
        <title>k2n test</title>
        <meta http-equiv=content-type content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php foreach ($tv as $v): ?>
            <ul>
                <li><?=$v?> → <?=k2n2s($v)?></li>
            </ul>
        <?php endforeach; ?>
        <form action="k2n_test.php" method="post">
            <input type="text" name="knum" value="" />
            <input type="submit" />
        </form>
        <?php
            if (isset($knum)) {
                echo "$knum → ".k2n2s($knum);
            }
        ?>
    </body>
</html>
