<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Staticall 类的伪静态调用
 */
abstract class Staticall
{
    public static $container = null;
    public static $cachepath = null;
    protected static $staticalls = [];      // 映射 Foo 到容器中的 service_id
    protected static $fqcns = [];           // 映射 Namespace\FooStaticall 到 Foo
    private static $registerd = false;
    private static $eval_enabled = false;


    /**
     * 初始化 Staticall 机制
     *
     * @param Container $container 指定目标容器
     * @param string $cachepath    缓存路径
     */
    final public static function init(Container $container, $cachepath = null)
    {
        static::$staticalls = [];
        static::$fqcns = [];

        // sets the container
        static::$container = $container;

        // sets the cache root directory
        if (is_string($cachepath) && file_exists($cachepath) && is_dir($cachepath)) {
            static::$cachepath = realpath($cachepath);
        } else {
            static::$cachepath = null;
        }

        // checks eval() enabled
        static::$eval_enabled = function_exists('eval');

        // register
        static::$registerd = spl_autoload_register([get_called_class(), 'autoload']);
    }


    /**
     * @param string $class
     */
    final public static function autoload($class)
    {
        if (array_key_exists($class, static::$staticalls)) {
            static::loadStaticallClass($class);
        }
    }


    /**
     * 载入指定的 Staticall 类
     *
     * 如果服务器上eval()函数没有被禁用，那么直接用eval()函数来生成FooStaticall的类定义。这种方法最便捷。
     * 如果eval()函数被禁用了，那么就只能先生成一个FooStaticall类文件，再require这个文件。这种方法适应性强。
     *
     * @param string $class
     */
    private static function loadStaticallClass($class)
    {
        $fqcn = "Staticall\\{$class}Staticall";

        $def = static::createStaticallClass($class);

        if (is_null(self::$cachepath)) {
            eval($def);
        } else {
            $cachepath = self::$cachepath;
            if ($cachepath === null || !file_exists($cachepath) || !is_dir($cachepath)) {
                throw new \Exception("目录不存在，无法创建{$class}Staticall类文件");
                return false;
            }

            $target_dir = $cachepath . '/Staticall'; // 目标目录
            $target_file = $cachepath . '/' . $fqcn . '.php'; // 目标文件

            if (!file_exists($target_file)) {
                // 如果目标目录不存在，则先创建一个
                if (!file_exists($target_dir)) {
                    @mkdir($target_dir, 0777);
                }

                // 把类文件定义写入到目标php文件中
                $result = file_put_contents($target_file, "<?php\n" . $def);
                if ($result === false) {
                    throw new \Exception("写入{$target_file}文件失败");
                    return false;
                }
            }

            require $target_file;
        }

        class_alias($fqcn, $class);
        self::$fqcns[$fqcn] = $class;
    }


    /**
     * 绑定指定的Staticall到目标容器的指定条目
     *
     * @param string $staticall_name  要绑定的Staticall名称，如：'Foo'
     * @param string $service_id      目标容器的service_id
     */
    final public static function link($staticall_name, $service_id)
    {
        static::$staticalls[$staticall_name] = $service_id;
    }


    /**
     * 把伪静态方法Foo::bar()映射到实际的对象方法上
     */
    public static function __callStatic($method, $arguments)
    {
        $fqcn = get_called_class();
        $class = static::$fqcns[$fqcn];
        $id = static::$staticalls[$class];

        if (!static::$container->has($id)) {
            throw new \Exception("Staticall {$class}::{$method} fail. Not found the corresponded service.");
        }

        $instance = static::$container->get($id);
        return call_user_func_array([$instance, $method], $arguments);
    }


    /**
     * 创建相应的Staticall的类文件定义，可供eval调用，或者写入到类定义文件中
     *
     * @param string $class
     * @return string
     */
    private static function createStaticallClass($class)
    {
        $namespace = __NAMESPACE__;

        return <<<EOB
namespace Staticall;
class {$class}Staticall extends \\{$namespace}\Staticall {}
EOB;
    }
}
