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
    const VAR_DUMP_MODE = 'var_dump';
    const PRINT_R_MODE = 'print_r';


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
     * 导出一个变量的值，是内置函数var_dump()的增强版
     *
     * @param mixed $var
     * @return type
     */
    public static function varDump($var)
    {
        return self::format($var);
    }


    /**
     * 输出或返回一个变量的字符串表示，是内置函数var_export()的增强版
     *
     * @param mixed $var
     * @param string $varname
     */
    public static function varExport($var, $varname = null)
    {
        if (is_string($varname) && $varname !== '') {
            $begin = $varname . ' = ';
            $end = ';' . PHP_EOL;
        } else {
            $begin = '';
            $end = '';
        }

        $s = self::format($var, 0);

        return sprintf('%s%s%s', $begin, $s, $end);
    }


    protected static function format($var, $leading = 0)
    {
        if (is_array($var)) {
            if (empty($var)) {
                return '[]';
            }
            return self::formatArray($var, $leading);
        } elseif (is_null($var)) {
            return 'null';
        } else {
            return var_export($var, true);
        }
    }


    /**
     * 格式化输出一个数组
     *
     * @param array $array
     * @param int $leading 前导空格的数量
     * @return string
     */
    protected static function formatArray($array, $leading = 0)
    {
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
            if (is_array($value)) {
                $value = self::formatArray($value, $leading+$maxlen+8);
            }
            //$s[] = $leadingspaces . str_pad('', 4) . str_pad($key, $maxlen + 2) . ' => ' . $value . ',';
            $s[] = sprintf("%{$leading}s    %-{$maxlen}s => %s,", '', $key, $value);
        }
        $s[] = $leadingspaces . ']';

        return implode(PHP_EOL, $s);
    }
}
