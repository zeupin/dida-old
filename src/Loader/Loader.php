<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Loader 类
 */
class Loader
{
    /* 初始化标志 */
    private static $initialized = false;

    /* 查询队列 */
    private static $_queue = [];


    /**
     * 初始化
     */
    public static function init()
    {
        // 确保本函数仅执行一次
        if (self::$initialized) {
            return;
        }

        // 注册autoload回调函数
        spl_autoload_register([__CLASS__, 'autoload']);

        // 确保本函数仅执行一次
        self::$initialized = true;
    }


    /**
     * 根据给出的FQCN格式的类名，尝试找到并载入相应的类文件
     *
     * @param string $class 给出的FQCN格式的类名
     *
     * @return bool 载入成功返回true，载入失败返回false
     */
    protected static function autoload($class)
    {
        foreach (self::$_queue as $item) {
            switch ($item['type']) {
                case 'classmap':
                    $result = self::matchClassmap($class, $item['classmapfile'], $item['rootpath'], $item['classmap']);
                    if ($result) {
                        return true;
                    }
                    break;
                case 'namespace':
                    $result = self::matchNamespace($class, $item['namespace'], $item['rootpath'], $item['len']);
                    if ($result) {
                        return true;
                    }
                    break;
                case 'alias':
                    $result = self::matchAlias($class, $item['alias'], $item['real']);
                    if ($result) {
                        return true;
                    }
                    break;
            }
        }

        // 对$class没有查到匹配记录，返回false
        return false;
    }


    /**
     * 新增类对照表
     *
     * @param string $classmapfile  类的对照表文件路径
     * @param string $rootpath      根目录路径
     *
     * @return bool 成功返回true，有问题返回false
     */
    public static function addClassmap($classmapfile, $rootpath)
    {
        // 确保Loader已经init()
        self::init();

        /* 检查参数合法性 */
        if (!file_exists($classmapfile) || !is_file($classmapfile)) {
            return false;
        }
        if (!file_exists($rootpath) || !is_dir($rootpath)) {
            return false;
        }

        // 简单预处理一下
        $classmapfile = realpath($classmapfile);
        $rootpath = realpath($rootpath);

        // 加到查询队列中
        self::$_queue[] = [
            'type'         => 'classmap',
            'classmapfile' => $classmapfile,
            'rootpath'     => $rootpath,
            'classmap'     => null,
        ];

        return true;
    }


    /**
     * 从类名对照表文件中，查找类文件的所在路径
     *
     * @param string $class     要查询的类名
     * @param string $classmap  类索引对照表的文件名
     * @param string $rootpath      对应的根目录
     *
     * @return bool
     */
    private static function matchClassmap($class, $classmapfile, $rootpath, &$classmap)
    {
        // 如果是第一次执行，则先载入classmap文件。这样后面就不用重复载入文件，直接查就行了。
        if (is_null($classmap)) {
            // 载入classmap文件的内容
            $classmap = require($classmapfile);

            // 检查载入的内容是否合法
            if (!is_array($classmap)) {
                $classmap = [];
                return false;
            }
        }

        // 检查是否为空数组
        if (count($classmap) == 0) {
            return false;
        }

        // 检查$class是否在$classmap数组中
        if (!array_key_exists($class, $classmap)) {
            return false;
        }

        // 导入对应的php文件
        $target = $rootpath . '/' . $classmap[$class];
        if (file_exists($target) && is_file($target)) {
            require $target;
            return true;
        } else {
            return false;
        }
    }


    /**
     * 新增命名空间
     *
     * @param string $namespace  命名空间，形如：'your\\namespace'
     * @param string $rootpath   对应目录，形如：'/your/namespace/root/rootpath/'
     *
     * @return bool 成功返回true，有问题返回false
     */
    public static function addNamespace($namespace, $rootpath)
    {
        // 确保Loader已经init()
        self::init();

        // 检查合法性
        if (!file_exists($rootpath) || !is_dir($rootpath)) {
            return false;
        } else {
            $rootpath = realpath($rootpath);
        }

        // 对参数$namespace进行标准化，去除其前后的空白字符以及字符'\'
        $namespace = trim($namespace, "\\ \t\n\r\0\x0B");

        // 加到查询队列中
        self::$_queue[] = [
            'type'      => 'namespace',
            'namespace' => $namespace,
            'rootpath'  => $rootpath,
            'len'       => strlen($namespace),
        ];

        return true;
    }


    /**
     * 匹配命名空间
     *
     * 对于Root\Your\Class类，检查：
     * 1. <rootpath>/Your/Class.php 是否存在？
     * 2. <rootpath>/Your/Class/Class.php 是否存在？
     * 先找到哪个就加载哪个，要都找不到就返false
     *
     * @param string $class 要载入的类名，FQCN格式。
     * @param string $namespace 命名空间（Your\Namespace）
     * @param string $rootpath 命名空间对应的目录位置
     * @param int $len 值为strlen($namespace)
     *
     * @return bool
     */
    private static function matchNamespace($class, $namespace, $rootpath, $len)
    {
        // 检查$class是否属于$namespace?
        if (strncmp($class, $namespace, $len) !== 0) {
            return false;
        }

        // 去除$class中的命名空间后的剩余部分
        $cls = substr($class, $len + 1);

        /*
         * 依次检查：
         * 1. <rootpath>/Your/Class.php 是否存在？
         * 2. <rootpath>/Your/Class/Class.php 是否存在？
         * 先找到哪个就加载哪个，要都找不到就返false
         */
        if (strpos($cls, '\\') === false) {
            // 如果 $cls 中不包含 \
            $target1 = "{$rootpath}/{$cls}.php";
            $target2 = "{$rootpath}/{$cls}/{$cls}.php";
            if (file_exists($target1) && is_file($target1)) {
                require $target1;
                return true;
            } elseif (file_exists($target2) && is_file($target2)) {
                require $target2;
                return true;
            } else {
                return false;
            }
        } else {
            // 如果 $cls 中包含 \，则先把 $cls拆分成 $base + $name
            $array = explode('\\', $cls);
            $name = array_pop($array);
            $base = implode('\\', $array);
            $target1 = "{$rootpath}/{$base}/{$name}.php";
            $target2 = "{$rootpath}/{$base}/{$name}/{$name}.php";
            if (file_exists($target1) && is_file($target1)) {
                require $target1;
                return true;
            } elseif (file_exists($target2) && is_file($target2)) {
                require $target2;
                return true;
            } else {
                return false;
            }
        }
    }


    /**
     * 新增别名
     *
     * @param string $alias  Your\Class\Alias
     * @param string $real   \Its\Real\FQCN
     *
     * @return bool 成功返回true，有问题返回false
     */
    public static function addAlias($alias, $real)
    {
        // 确保Loader已经init()
        self::init();

        // 加到查询队列中
        self::$_queue[] = [
            'type'  => 'alias',
            'alias' => $alias,
            'real'  => $real,
        ];

        return true;
    }


    /**
     * 匹配别名
     *
     * @param string $class 要载入的类名（FQCN格式）
     * @param string $alias 类的别名（FQCN格式）
     * @param string $real  实际的类名（FQCN格式）
     *
     * @return bool
     */
    private static function matchAlias($class, $alias, $real)
    {
        if ($class === $alias) {
            return class_alias($real, $alias);
        } else {
            return false;
        }
    }
}
