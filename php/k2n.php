<?php
class 漢数字
{
    const C = "class";
    const V = "value";

    const NUM = 1;
    const JHS = 2; // じゅう、ひゃく、せん
    const MOC = 3; // まん、おく、ちょう

    static public $kn = [
        "〇" => [ self::C => self::NUM, self::V => 0 ],
        "零" => [ self::C => self::NUM, self::V => 0 ],
        "一" => [ self::C => self::NUM, self::V => 1 ],
        "弌" => [ self::C => self::NUM, self::V => 1 ],
        "壱" => [ self::C => self::NUM, self::V => 1 ],
        "壹" => [ self::C => self::NUM, self::V => 1 ],
        "二" => [ self::C => self::NUM, self::V => 2 ],
        "弍" => [ self::C => self::NUM, self::V => 2 ],
        "弐" => [ self::C => self::NUM, self::V => 2 ],
        "貳" => [ self::C => self::NUM, self::V => 2 ],
        "三" => [ self::C => self::NUM, self::V => 3 ],
        "参" => [ self::C => self::NUM, self::V => 3 ],
        "參" => [ self::C => self::NUM, self::V => 3 ],
        "四" => [ self::C => self::NUM, self::V => 4 ],
        "肆" => [ self::C => self::NUM, self::V => 4 ],
        "五" => [ self::C => self::NUM, self::V => 5 ],
        "伍" => [ self::C => self::NUM, self::V => 5 ],
        "六" => [ self::C => self::NUM, self::V => 6 ],
        "陸" => [ self::C => self::NUM, self::V => 6 ],
        "七" => [ self::C => self::NUM, self::V => 7 ],
        "質" => [ self::C => self::NUM, self::V => 7 ],
        "漆" => [ self::C => self::NUM, self::V => 7 ],
        "柒" => [ self::C => self::NUM, self::V => 7 ],
        "八" => [ self::C => self::NUM, self::V => 8 ],
        "捌" => [ self::C => self::NUM, self::V => 8 ],
        "九" => [ self::C => self::NUM, self::V => 9 ],
        "玖" => [ self::C => self::NUM, self::V => 9 ],

        "十" => [ self::C => self::JHS, self::V => 10 ],
        "拾" => [ self::C => self::JHS, self::V => 10 ],
        "廿" => [ self::C => self::JHS, self::V => 20 ],
        "卅" => [ self::C => self::JHS, self::V => 30 ],
        "丗" => [ self::C => self::JHS, self::V => 30 ],
        "百" => [ self::C => self::JHS, self::V => 100 ],
        "佰" => [ self::C => self::JHS, self::V => 100 ],
        "陌" => [ self::C => self::JHS, self::V => 100 ],
        "千" => [ self::C => self::JHS, self::V => 1000 ],
        "阡" => [ self::C => self::JHS, self::V => 1000 ],
        "仟" => [ self::C => self::JHS, self::V => 1000 ],

        "万" => [ self::C => self::MOC, self::V => 10000 ],
        "萬" => [ self::C => self::MOC, self::V => 10000 ],
        "億" => [ self::C => self::MOC, self::V => 100000000 ],
        "兆" => [ self::C => self::MOC, self::V => 1000000000000 ],
        "京" => [ self::C => self::MOC, self::V => 10000000000000000 ],
        "垓" => [ self::C => self::MOC, self::V => 100000000000000000000 ],
    ];

    const S = "string";
    const N = "number";

    static public function k2n($k)
    {
        $a = [];

        if (($len = mb_strlen($k)) < 1) {
            return $a;
        }

        $s = "";
        for ($i = 0; $i < $len && !isset(self::$kn[$c = mb_substr($k, $i, 1)]); $i++) {
            $s .= $c;
        }
        if ($s != "") {
            $a[] = [ self::C => self::S, self::V => $s ];
        }

        $stack = [];
        $n = 0;
        for (; $i < $len && isset(self::$kn[$c = mb_substr($k, $i, 1)]); $i++) {
            $v = self::$kn[$c];
            switch ($v[self::C]) {
            case self::NUM:
                if (!isset($acc)) $acc = 0;
                $acc = 10 * $acc + $v[self::V];
                break;
            case self::JHS:
                if (!isset($acc)) $acc = 1;
                array_push($stack, $acc * $v[self::V]);
                unset($acc);
                break;
            case self::MOC:
                if (isset($acc)) {
                    array_push($stack, $acc);
                    unset($acc);
                }
                $n += array_sum($stack) * $v[self::V];
                $stack = [];
                break;
            default:
                die("ここに来ては困る");
            }
        }

        if (isset($acc)) array_push($stack, $acc);
        if ($n != 0) array_push($stack, $n);
        if (count($stack) > 0) {
            $a[] = [ self::C => self::N, self::V => array_sum($stack)];
        }

        return array_merge($a, self::k2n(mb_substr($k, $i)));
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
