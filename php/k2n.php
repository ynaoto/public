<?php
class 漢数字
{
    static public $knum = [
        "〇" => 0, "零" => 0,
        "一" => 1, "弌" => 1, "壱" => 1, "壹" => 1,
        "二" => 2, "弍" => 2, "弐" => 2, "貳" => 2,
        "三" => 3, "参" => 3, "參" => 3,
        "四" => 4, "肆" => 4,
        "五" => 5, "伍" => 5,
        "六" => 6, "陸" => 6,
        "七" => 7, "質" => 7,
        "八" => 8, "捌" => 8,
        "九" => 9, "玖" => 9,
    ];
    static public $kunit1 = [
        "十" => 10, "拾" => 10,
        "百" => 100, "佰" => 100,
        "千" => 1000, "阡" => 1000, "仟" => 1000,
    ];
    static public $kunit2 = [
        "万" => 10000, "萬" => 10000,
        "億" => 100000000,
        "兆" => 1000000000000,
        "京" => 10000000000000000,
        "垓" => 100000000000000000000,
    ];

    static private function sum($n, &$stack)
    {
        $n += array_reduce($stack, function($result, $item) {
            $result += $item;
            return $result;
        });
        $stack = [];

        return $n;
    }

    const HEAD = 1;
    const PNUM = 2;
    const TAIL = 3;

    const STR = "string";
    const NUM = "number";

    const C = "class";
    const V = "value";

    static public function k2n($k)
    {
        $a = [];

        $pos = HEAD;
        $s1 = $s2 = "";

        $stack = [];
        $n = 0;
    
        $len = mb_strlen($k);
        for ($i = 0; $i < $len; $i++) {
            $c = mb_substr($k, $i, 1);
            if ($pos == TAIL) {
                $s2 .= $c;
            } else if (isset(self::$knum[$c])) {
                $pos = PNUM;
                $n = 10 * $n + self::$knum[$c];
            } else if (isset(self::$kunit1[$c])) {
                $pos = PNUM;
                if ($n == 0) $n = 1;
                array_push($stack, $n * self::$kunit1[$c]);
                $n = 0;
            } else if (isset(self::$kunit2[$c])) {
                $pos = PNUM;
                if (!isset($result)) $result = 0;
                $result += self::sum($n, $stack) * self::$kunit2[$c];
                $n = 0;
            } else if ($pos == HEAD) {
                $s1 .= $c;
            } else {
                $pos = TAIL;
                $s2 = $c;
                $result += self::sum($n, $stack);
            }
        }
    
        if ($s1 != "") $a[] = [ self::C => self::STR, self::V => $s1 ];
        $a[] = [ self::C => self::NUM, self::V => $result ];
        if ($s2 != "") $a[] = [ self::C => self::STR, self::V => $s2 ];

        return $a;
    }
}

function k2n($k)
{
    $a = 漢数字::k2n($k);
    $s = "";
    while (($i = array_shift($a)) != null) {
        $t = $i['value'];
        if ($i['class'] == 'number') {
            $t = number_format($t);
        }
        $s .= $t;
    }
    return $s;
}
