<?php
require("CalendarDB.php");

try {
    $dbh = new CalendarDB();
} catch (Exception $e) {
    die("カレンダーDBに繋がらない (".$e->getMessage().")");
}

if (isset($_POST["ok"]) || isset($_POST["cancel"])) {
    $year = $_POST["y"];
    $month = $_POST["m"];
    $day = $_POST["d"];
    $item = $_POST["item"];
    if (isset($_POST["ok"])) {
        $dbh->set_schedule($year, $month, $day, $item);
    }
    $url = "calendar.php?year={$year}&month={$month}";
    header("location: $url");
    exit;
}

function check_params($y, $m, $d)
{
    if (!ctype_digit("$y")) return "年 '$y' に数字ではない文字があります";
    if (!ctype_digit("$m")) return "月 '$m' に数字ではない文字があります";
    if (!ctype_digit("$d")) return "日 '$d' に数字ではない文字があります";
    if (!checkdate($m, $d, $y)) return "{$y}年{$m}月{$d}日は不正です";

    return true;
}

if (isset($_REQUEST["y"])) $y = $_REQUEST["y"];
if (isset($_REQUEST["m"])) $m = $_REQUEST["m"];
if (isset($_REQUEST["d"])) $d = $_REQUEST["d"];

if (($result = check_params($y, $m, $d)) !== true) {
    $error = $result;
} else {
    $year = $y;
    $month = $m;
    $day = $d;
}

$item = $dbh->get_schedule($year, $month, $day);

?>
<html>
    <head>
        <title>Schedule</title>
        <meta http-equiv=content-type content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php
        if (isset($error)) {
            echo "<p>$error</p>";
        }
        ?>
        <h1><?=$year?>年<?=$month?>月<?=$day?>日</h1>
        <form action="schedule.php" method="post">
            <textarea name="item"><?=$item?></textarea>
            <br/>
            <input type="submit" name="ok" value="OK">
            <input type="submit" name="cancel" value="Cancel">
            <input type="hidden" name="y" value="<?=$year?>">
            <input type="hidden" name="m" value="<?=$month?>">
            <input type="hidden" name="d" value="<?=$day?>">
        </form>
    </body>
</html>
