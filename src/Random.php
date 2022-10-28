<?php
declare(strict_types=1);

namespace boom;

/**
 * 随机函数
 */
class Random
{
    /**
     * 小写字母源串
     * @var string[]
     */
    private $lower_char = [
        "a", "b", "c", "d", "e", "f", "g",
        "h", "i", "j", "k", "l", "m", "n",
        "o", "p", "q", "r", "s", "t",
        "u", "v", "w", "x", "y", "z"
    ];

    /**
     * 大写字母源串
     * @var string[]
     */
    private $upper_char = [
        "A", "B", "C", "D", "E", "F", "G",
        "H", "I", "J", "K", "L", "M", "N",
        "O", "P", "Q", "R", "S", "T",
        "U", "V", "W", "X", "Y", "Z"
    ];

    /**
     * 数字源串
     * @var int[]
     */
    private $number = [
        0, 1, 2, 3, 4, 5, 6, 7, 8, 9
    ];

    /**
     * 排除不宜辨别的串
     * @var array
     */
    private $vague = [
        "v", "V", "o", "O", "l", "I", 0, 1
    ];

    /**
     * 是否只随机数字, 默认否
     * @var bool
     */
    private $is_number = false;

    /**
     * 是否只随机字符, 不包含数字
     * @var bool
     */
    private $is_str = false;

    /**
     * 是否排除模糊字串
     * @var bool
     */
    private $is_exclude = false;

    /**
     * 随机长度, 默认16
     * @var int
     */
    private $size = 16;

    /**
     * 是否转成大写
     * @var bool
     */
    private $to_upper = false;

    /**
     * 是否转成小写
     * @var bool
     */
    private $to_lower = false;

    /**
     * 是否需要数字
     */
    public function number(bool $is = true): Random
    {
        $this->is_number = $is;
        return $this;
    }

    /**
     * 是否随机字母
     * @param bool $is
     * @return $this
     */
    public function str(bool $is = true): Random
    {
        $this->is_str = $is;
        return $this;
    }

    /**
     * 是否排除模糊字串
     * @param bool $is
     * @return Random
     */
    public function exclude(bool $is = true): Random
    {
        $this->is_exclude = $is;
        return $this;
    }

    /**
     * 生成随机字符串长度
     * @param int $size
     * @return $this
     */
    public function size(int $size = 16): Random
    {
        $this->size = $size;
        return $this;
    }

    /**
     * 是否转成大写
     * @param bool $is
     * @return $this
     */
    public function upper(bool $is = false): Random
    {
        $this->to_upper = $is;
        return $this;
    }

    /**
     * 是否转成小写
     * @param bool $is
     * @return $this
     */
    public function lower(bool $is = false): Random
    {
        $this->to_lower = $is;
        return $this;
    }

    /**
     * 获取随机字符串
     * @return string
     */
    public function get(): string
    {
        $result = "";
        $source = $this->getSource();
        $source_count = count($source);
        for ($i = 0; $i < $this->size; $i++) {
            $mt_rand = mt_rand(0, $source_count - 1);
            $result .= $source[$mt_rand];
        }
        if ($this->to_lower == true) {
            $result = strtolower($result);
        }
        if ($this->to_upper == true) {
            $result = strtoupper($result);
        }
        return $result;
    }

    /**
     * 获取随机源串
     */
    private function getSource(): array
    {
        if ($this->is_number == true) {
            $source = $this->number;
        } else if ($this->is_str == true) {
            $source = array_merge($this->lower_char, $this->number);
        } else {
            $source = array_merge($this->upper_char, $this->lower_char, $this->number);
        }
        if ($this->is_exclude == true) {
            foreach ($source as $k => $v) {
                foreach ($this->vague as $vv) {
                    if ($v == $vv) {
                        unset($source[$k]);
                    }
                }
            }
        }
        return array_values($source);
    }
}