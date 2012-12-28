<?php
class CalendarDB extends PDO
{
    public function __construct()
    {
        $dbhost = "localhost";
        $dbuser = "calendarman";
        $dbpass = "calendarpass";
        $dbname = "calendar";
        $dsn = "mysql:dbname={$dbname};host={$dbhost}";
        parent::__construct($dsn, $dbuser, $dbpass);
    }

    public function get_schedule($year, $month, $day)
    {
        $ymd = "{$year}-{$month}-{$day}";

        try {
            $stmt = $this->prepare("SELECT COUNT(*) FROM schedules where date=:date");
            $stmt->bindValue(":date", $ymd);
            $stmt->execute();
            $n = $stmt->fetchColumn();
            if ($n == 0) {
                return null;
            }
            if (1 < $n) {
                die("おかしい。たくさんありすぎる");
            }

            $stmt = $this->prepare("SELECT item FROM schedules where date=:date");
            $stmt->bindValue(":date", $ymd);
            $stmt->execute();
            $stmt->bindColumn('item', $item);
            $stmt->fetch(PDO::FETCH_BOUND);
        } catch (Exception $e) {
            die("スケジュールの取得に失敗しました (".$e->getMessage().")");
        }

        return $item;
    }
}
