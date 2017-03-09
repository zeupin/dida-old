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
    protected static $staticalls = [];      // 映射伪类Foo到具体对象
    protected static $fqcns = [];           // 映射 Namespace\FooStaticall 到 Foo
    protected static $registerd = false;

    /*
     * 指定一个可写目录，这个目录下将会动态生成一个Staticall子目录，
     * 用来保存动态生成的Staticall定义文件。
     */
    protected static $writeable = null;


    /**
     * 初始化 Staticall 机制
     *
     * @param string $writeable 设置生成的Staticall文件的保存路径
     */
    final public static function init($writeable = null)
    {
        static::$staticalls = [];
        static::$fqcns = [];

        if (!is_string($writeable) || file_exists($writeable) || !is_dir($writeable)) {
            self::$writeable = VAR_ROOT;
        } else {
            self::$writeable = realpath($writeable) . '/';
        }

        // get_called_class()指向具体的FooStaticall类
        static::$registerd = spl_autoload_register([get_called_class(), 'autoload']);
    }


    final public static function autoload($class)
    {
        if (array_key_exists($class, static::$staticalls)) {
            static::loadStaticallClass($class);
        }
    }


    /**
     * 载入指定的 Staticall 类
     *
     * 如果服务器上eval()语句没有被禁用，那么直接用eval来生成FooStaticall的类定义。这种方法轻巧便捷。
     * 如果eval()被禁用了，那么就只能先生成一个叫FooStaticall类文件，再require这个文件。这种方法适应性强。
     *
     * 注意：eval()不是函数，而是一个语法结构，因此无法通过function_exists()来判断是否被禁用的。
     *
     * @param string $class
     */
    private static function loadStaticallClass($class)
    {
        $fqcn = "Staticall\\{$class}Staticall";      // 自定义的FQCN格式的类全名
        $def = static::createStaticallClass($class); // 按模板生成FooStaticall的类定义PHP代码

        /* 先用eval的方式执行 */
        @eval($def);

        /* 检查上面的eval是否执行成功。如果失败，尝试用生成FooStaticall.php文件的方式再试试 */
        if (!class_exists($fqcn)) {
            $target_dir = self::$writeable . 'Staticall'; // 目标目录
            $target_file = self::$writeable . $fqcn . '.php'; // 目标文件

            if (!file_exists($target_file)) {
                // 如果目标目录不存在，则先创建之
                if (!file_exists($target_dir)) {
                    @mkdir($target_dir, 0777);
                }

                // 把类文件定义代码写入到目标php文件中
                $result = file_put_contents($target_file, "<?php\n" . $def);
                if ($result === false) {
                    throw new \Exception("写入{$target_file}文件失败");
                    return false;
                }
            }

            // 引用生成的php文件
            require $target_file;
        }

        class_alias($fqcn, $class);
        self::$fqcns[$fqcn] = $class;
    }


    /**
     * 绑定指定的Staticall到目标容器的指定条目
     *
     * @param string $staticall_name  要绑定的Staticall名称，如：'Foo'
     * @param string $service_id      目标对象
     */
    final public static function bind($staticall_name, $object)
    {
        static::$staticalls[$staticall_name] = $object;
    }


    /**
     * 把伪静态方法Foo::bar()映射到实际的对象的方法上
     *
     * @param $method 要调用的静态方法名称。如果为self，则表示请求返回被链接的对象
     * @param $parameters 传入的参数数组
     */
    public static function __callStatic($method, array $parameters)
    {
        $fqcn = get_called_class();
        $class = static::$fqcns[$fqcn];
        $object = static::$staticalls[$class];

        if ($method == 'self') {
            return $object;
        } else {
            return call_user_func_array([$object, $method], $parameters);
        }
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
