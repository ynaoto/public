<?php
class CalendarDB extends PDO
{
    public function __construct()
    {
        $dbhost = "localhost";
        $dbuser = "calendarman";
        $dbpass = "calendarpass";
        $dbname = "calendar";
        $dsn = "mysql:dbname={$dbname};host={$dbhost};charset=utf8";
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

    public function set_schedule($year, $month, $day, $item)
    {
        $ymd = "{$year}-{$month}-{$day}";

        try {
            if ($item == "") {
                $stmt = $this->prepare("DELETE FROM schedules WHERE date=:date");
                $stmt->bindValue(":date", $ymd);
                if ($stmt->execute()) {
                    return true;
                }
            }

            $stmt = $this->prepare("INSERT INTO schedules (date,item) VALUES (:date,:item)");
            $stmt->bindValue(":date", $ymd);
            $stmt->bindValue(":item", $item);
            if ($stmt->execute()) {
                return true;
            }

            $stmt = $this->prepare("UPDATE schedules SET item=:item WHERE date=:date");
            $stmt->bindValue(":date", $ymd);
            $stmt->bindValue(":item", $item);
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $e) {
            die("スケジュールの設定に失敗しました (".$e->getMessage().")");
        }

        die("ここに来てはいけない");
    }
}
