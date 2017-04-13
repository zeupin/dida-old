<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Debug 类
 */
class Debug
{
    /**
     * 停止执行后面的程序。
     * 还可以顺带输出一个需要跟踪的变量值。
     *
     * @param mixed  $var  需要跟踪的变量
     */
    public static function halt($var = null)
    {
        if ($var !== null) {
            echo self::varDump($var);
        }
        die();
    }


    /**
     * 导出变量
     */
    public static function varDump($var)
    {
        return self::formatVar($var);
    }


    /**
     * 输出或返回一个变量的字符串表示
     *
     * @param mixed $var 变量
     * @param string $varname 变量名
     */
    public static function varExport($var, $varname = null)
    {
        // 如果不设置变量名，则等效于self::varDump()
        if (!is_string($varname) || $varname === '') {
            return self::formatVar($var);
        }

        // 变量名 = 变量值;
        $begin = $varname . ' = ';
        $leading = strlen($begin);
        $v = self::formatVar($var, $leading);
        $end = ';' . PHP_EOL;

        return $begin . $v . $end;
    }


    /**
     * 把一个变量的值，用可读性良好的格式进行输出
     *
     * @return string
     */
    protected static function formatVar($var, $leading = 0)
    {
        // 为 null
        if (is_null($var)) {
            return 'null';
        }

        // 为数组
        if (is_array($var)) {
            return self::formatArray($var, $leading);
        }

        // 其它类型
        return var_export($var, true);
    }


    /**
     * 把一个数组的值，用可读性良好的格式进行输出
     *
     * @param array $array
     * @param int $leading 前导空格的数量
     * @return string
     */
    protected static function formatArray($array, $leading = 0)
    {
        // 如果是空数组，直接返回[]
        if (empty($array)) {
            return '[]';
        }

        // 前导空格
        $leadingspaces = str_repeat(' ', $leading);

        // 找出名称最长的key
        $maxlen = 0;
        $keys = array_keys($array);
        $is_string_key = false;
        foreach ($keys as $key) {
            if (is_string($key)) {
                $is_string_key = true;
            }
            $len = mb_strwidth($key);
            if ($len > $maxlen) {
                $maxlen = $len;
            }
        }
        if ($is_string_key) {
            $maxlen = $maxlen + 2;
        }

        // 生成数组定义个每一行
        $s = [];
        $s[] = '['; // 第一行无需前导空格
        foreach ($array as $key => $value) {
            $key = (is_string($key)) ? "'$key'" : $key;
            $value = self::formatVar($value, $leading + $maxlen + 8);
            $s[] = sprintf("%s    %-{$maxlen}s => %s,", $leadingspaces, $key, $value);
        }
        $s[] = $leadingspaces . ']';    // 最后一行

        return implode(PHP_EOL, $s);
    }
}
