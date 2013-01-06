<?php
class 漢数字
{
    const C = "class";
    const V = "value";

    const NUM = 1;
    const JHS = 2; // じゅう、ひゃく、せん
    const MOC = 3; // まん、おく、ちょう

    static private $kn = [
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
    static private $kns = null;

    static private function k2n_a($k)
    {
        $len = mb_strlen($k);
        $stack = [];
        $n = 0;
        for ($i = 0; $i < $len; $i++) {
            $v = self::$kn[mb_substr($k, $i, 1)];
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
                if (count($stack) < 1) {
                    array_push($stack, 1);
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

        return array_sum($stack);
    }

    static private function k2n_b($k)
    {
        $len = mb_strlen($k);
        $mx = 1;
        $my = 1;
        $n = 0;
        $ghost_one = false;
        for ($i = $len - 1; 0 <= $i; $i--) {
            $v = self::$kn[mb_substr($k, $i, 1)];
            switch ($v[self::C]) {
            case self::NUM:
                $n += $my * $mx * $v[self::V];
                $mx *= 10;
                $ghost_one = false;
                break;
            case self::JHS:
                if ($ghost_one) $n += $my * $mx * 1;
                $mx = $v[self::V];
                $ghost_one = true;
                break;
            case self::MOC:
                if ($ghost_one) $n += $my * $mx * 1;
                $my = $v[self::V];
                $mx = 1;
                break;
            default:
                die("ここに来ては困る");
            }
        }
        if ($ghost_one) $n += $my * $mx * 1;

        return $n;
    }

    static private function k2n_c($k)
    {
        $len = mb_strlen($k);
        $n = 0;
        for ($i = 0; $i < $len; $i++) {
            $v = self::$kn[mb_substr($k, $i, 1)];
            $c = $v[self::C];
            if ($c == self::NUM) {
                if (!isset($acc)) $acc = 0;
                $acc = 10 * $acc + $v[self::V];
            } else if ($c == self::JHS) {
                if (!isset($acc)) $acc = 1;
                $n += $acc * $v[self::V];
                unset($acc);
            } else if ($c == self::MOC) {
                if (isset($acc)) $n += $acc;
                if ($n == 0) $n = 1;
                $n = $n * $v[self::V] + self::k2n_c(mb_substr($k, $i + 1));
                unset($acc);
                break;
            } else {
                die("ここに来ては困る");
            }
        }
        if (isset($acc)) $n += $acc;

        return $n;
    }

    static private function k2n_d($k)
    {
        $len = mb_strlen($k);
        $n = 0;
        for ($i = 0; $i < $len; $i++) {
            $v = self::$kn[mb_substr($k, $i, 1)];
            $c = $v[self::C];
            if ($c == self::NUM) {
                if (!isset($acc)) $acc = 0;
                $acc = 10 * $acc + $v[self::V];
            } else if ($c == self::JHS) {
                if (!isset($acc)) $acc = 1;
                $n += $acc * $v[self::V];
                unset($acc);
            } else if ($c == self::MOC) {
                if (isset($acc)) $n += $acc;
                unset($acc);
                if ($n == 0) $n = 1;
                $n *= $v[self::V];
                break;
            } else {
                die("ここに来ては困る");
            }
        }
        if (isset($acc)) $n += $acc;

        return $n + self::k2n_c(mb_substr($k, $i + 1));
    }

    static public function k2n($k, $f)
    {
        if ($k == "") {
            return [];
        }

        if (self::$kns == null) {
            self::$kns = array_reduce(array_keys(self::$kn), function($v, $w) {
                return $v .= $w;
            });
        }
        preg_match("/([^".self::$kns."]*)([".self::$kns."]*)(.*)/u", $k, $m);

        $a = [];
        if (!empty($m[1])) $a[] = $m[1];
        if (!empty($m[2])) $a[] = self::$f($m[2]);
        if (!empty($m[3])) $a = array_merge($a, self::k2n($m[3], $f));

        return $a;
    }
}

function k2n($k, $f)
{
    return 漢数字::k2n($k, $f);
}

function n2k($n, $moc = [ "萬", "億", "兆", "京", "垓" ])
{
    $nk1 = [ "", "壱", "弐", "参", "四", "伍", "六", "七", "八", "九" ];
    $nk  = [ "", ""  , "弐", "参", "四", "伍", "六", "七", "八", "九" ];

    if ($n < 0) {
        return "マイナス".n2k(-$n);
    }
    if ($n < 10) {
        return $nk1[$n];
    }
    if ($n < 100) {
        return $nk[floor($n/10)]."拾".n2k($n % 10);
    }
    if ($n < 1000) {
        return $nk[floor($n/100)]."百".n2k($n % 100);
    }
    if ($n < 10000) {
        return $nk[floor($n/1000)]."千".n2k($n % 1000);
    }

    if (count($moc) < 1) {
        die("その数はでかすぎる");
    }

    $t = array_shift($moc);
    $u = floor($n / 10000);
    return n2k($u, $moc).($u % 10000 != 0 ? $t : "").n2k($n % 10000);
}
