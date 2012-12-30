<?php
class 漢数字
{
    const C = "class";
    const V = "value";

    const NUM = 1;
    const JHS = 2; // じゅう、ひゃく、せん
    const MOC = 3; // まん、おく、ちょう

    static public $knum = [
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
        "八" => [ self::C => self::NUM, self::V => 8 ],
        "捌" => [ self::C => self::NUM, self::V => 8 ],
        "九" => [ self::C => self::NUM, self::V => 9 ],
        "玖" => [ self::C => self::NUM, self::V => 9 ],

        "十" => [ self::C => self::JHS, self::V => 10 ],
        "拾" => [ self::C => self::JHS, self::V => 10 ],
        "百" => [ self::C => self::JHS, self::V => 100 ],
        "佰" => [ self::C => self::JHS, self::V => 100 ],
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

    static private function sum($n, &$stack)
    {
        while (($i = array_pop($stack)) != null) {
           $n += $i;
        }
        return $n;
    }

    const S = "string";
    const N = "number";

    static public function k2n($k)
    {
        $a = [];

        $stack = [];
        $n = 0;

        $len = mb_strlen($k);
        for ($i = 0; $i < $len; $i++) {
            $c = mb_substr($k, $i, 1);
            if (isset(self::$knum[$c])) {
                if (isset($s)) {
                    $a[] = [ self::C => self::S, self::V => $s ];
                    unset($s);
                }
                $v = self::$knum[$c];
                switch ($v[self::C]) {
                case self::NUM:
                    $n = 10 * $n + $v[self::V];
                    break;
                case self::JHS:
                    if ($n == 0) $n = 1;
                    array_push($stack, $n * $v[self::V]);
                    $n = 0;
                    break;
                case self::MOC:
                    if (!isset($result)) $result = 0;
                    $result += self::sum($n, $stack) * $v[self::V];
                    $n = 0;
                    break;
                default:
                    die("ここに来ては困る");
                }
            } else {
                if (isset($result)) {
                    $result += self::sum($n, $stack);
                    $a[] = [ self::C => self::N, self::V => $result ];
                    unset($result);
                    $n = 0;
                }
                if (!isset($s)) $s = "";
                $s .= $c;
            }
        }
    
        if (isset($s)) {
            $a[] = [ self::C => self::S, self::V => $s ];
        } 
        if (isset($result)) {
            $result += self::sum($n, $stack);
            $a[] = [ self::C => self::N, self::V => $result ];
        }

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
