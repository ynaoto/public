<?php
require("CalendarDB.php");

try {
    $dbh = new CalendarDB();
} catch (Exception $e) {
    die("カレンダーDBに繋がらない (".$e->getMessage().")");
}

function check_params($y, $m)
{
    if (!ctype_digit($y)) return "年 '$y' に数字ではない文字があります";
    if (!ctype_digit($m)) return "月 '$m' に数字ではない文字があります";
    if (!checkdate($m, 1, $y)) return "{$y}年{$m}月は不正です";

    return true;
}

$t = time();
$year = $y = date("Y", $t);
$month = $m = date("m", $t);

if (isset($_REQUEST["year"])) $y = $_REQUEST["year"];
if (isset($_REQUEST["month"])) $m = $_REQUEST["month"];

if (($result = check_params($y, $m)) !== true) {
    $error = $result;
} else {
    $year = $y;
    $month = $m;
}
?>
<html>
    <head>
        <title>Calendar</title>
        <meta http-equiv=content-type content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="calendar.css">
    </head>
    <body>
        <?php
        if (isset($error)) {
            echo "<p>$error</p>";
        }
        ?>
        <table>
            <caption><?=$year?>年<?=$month?>月</caption>
            <?php
            $wn = ["日", "月", "火", "水", "木", "金", "土"];
            echo "<tr>";
            $n = count($wn);
            for ($i = 0; $i < $n; $i++) {
                echo "<th>{$wn[$i]}</th>\n";
            }
            echo "</tr>";

            $t1 = mktime(0, 0, 0, $month, 1, $year);
            $w1 = date("w", $t1);
            $dz = date("t", $t1);

            $d = -$w1 + 1;
            while ($d <= $dz) {
                echo "<tr>";
                for ($w = 0; $w < 7; $w++) {
                    echo "<td>";
                    if (1 <= $d && $d <= $dz) {
                        $item = $dbh->get_schedule($year, $month, $d);
                        $url = ""; // TODO here
                        echo "<a href=\"{$url}\"";
                        if ($item) {
                            echo " title=\"{$item}\"";
                            echo " class=\"booked\"";
                        }
                        echo ">$d</a>";
                    }
                    echo "</td>";
                    $d++;
                }
                echo "</tr>";
            }
            ?>
        </table>
    </body>
</html>
