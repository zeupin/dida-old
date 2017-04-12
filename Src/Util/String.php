<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida\Util;

/**
 * String 工具类
 */
class String
{
    /**
     * 把一个横线分隔的字符串转换为PascalCase大驼峰模式输出
     * 例如：'foo-bar-baz' 会转化为 FooBarBaz
     *
     * @param string $string 原始字符串
     * @param string $delimiter 分隔符，默认为-，常用的还有_/\等
     */
    public static function toPascalCase($string, $delimiter = '-')
    {
        $array = explode($delimiter, $string);
        foreach ($array as $k => $v) {
            $array[$k] = ucfirst($v);
        }
        return implode('', $array);
    }


    /**
     * 把一个横线分隔的字符串转换为useCamelCase小驼峰模式输出
     * 例如：'foo-bar-baz' 会转化为 fooBarBaz
     *
     * @param string $string 原始字符串
     * @param string $delimiter 分隔符，默认为-，常用的还有_/\等
     */
    public static function toCamelCase($string, $delimiter = '-')
    {
        $array = explode($delimiter, $string);
        foreach ($array as $k => $v) {
            if ($k === 0) {
                $array[$k] = lcfirst($v);
            } else {
                $array[$k] = ucfirst($v);
            }
        }
        return implode('', $array);
    }
}
