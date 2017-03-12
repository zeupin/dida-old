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
    private static $initialized = false;

    /* 已经登记的loader队列 */
    private static $_queue = [];           // 待查询队列

    /* 不同的查询类型 */
    private static $_classmaps = [];       // 已注册的类名对照表文件
    private static $_namespaces = [];      // 已注册的名称空间列表
    private static $_aliases = [];         // 已注册的别名列表


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
                    $result = self::loadClassmap($class, $item['classmapfile'], $item['rootpath']);
                    if ($result) {
                        return true;
                    }
                    break;
                case 'namespace':
                    $result = self::loadNamespace($class, $item['namespace'], $item['directory']);
                    if ($result) {
                        return true;
                    }
                    break;
                case 'alias':
                    $result = self::loadAlias($class, $item['alias'], $item['real']);
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
     * 新增一个类名对照表文件
     *
     * @param string $classmapfile  类的对照表文件路径
     * @param string $rootpath      根目录路径
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

        // add时，先简单把初始值设置为null
        // 第一次运行时，才去require实际文件
        self::$_classmaps[$classmapfile] = null;

        self::$_queue[] = [
            'type'         => 'classmap',
            'classmapfile' => $classmapfile,
            'rootpath'     => $rootpath,
        ];
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
    private static function matchClassmap($class, $classmapfile, $rootpath)
    {
        // 如果是第一次执行，则先载入classmap文件。这样后面就不用重复载入文件，直接查就行了。
        if (is_null(self::$_classmaps[$classmapfile])) {
            // 载入classmap文件的内容
            $classmap = require($classmapfile);

            // 检查载入的内容是否合法
            if (!is_array($classmap)) {
                self::$_classmaps[$classmapfile] = [];
                return false;
            }

            // 保存
            self::$_classmaps[$classmapfile] = $classmap;
        }

        // 获取classmap数组
        if (!isset($classmap)) {
            $classmap = self::$_classmaps[$classmapfile];
        }
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
     * 注册一个命名空间
     *
     * @param string $namespace  命名空间，形如：'your\\namespace'
     * @param string $directory  对应目录，形如：'/your/namespace/root/directory/'
     *
     * @return \Dida\Loader 链式执行
     */
    public static function addNamespace($namespace, $directory)
    {
        // 确保Loader已经init()
        self::init();

        // 对参数$namespace进行标准化，去除其前后的空白字符以及字符'\'
        $namespace = trim($namespace, "\\ \t\n\r\0\x0B");

        self::$_namespaces[$namespace] = $directory;

        self::$_queue[] = [
            'type'      => 'namespace',
            'namespace' => $namespace,
            'directory' => $directory,
        ];
    }


    /**
     * 从namespace对应的目录中，，查找类文件的所在路径
     *
     * @param string $class 要载入的类名（FQCN格式）
     * @param string $namespace 命名空间（Your\Namespace）
     * @param string $directory 命名空间对应的目录位置
     *
     * @return bool
     */
    private static function matchNamespace($class, $namespace, $directory)
    {
        // 检查$class是否属于$namespace?
        $len = strlen($namespace);
        if (strncmp($class, $namespace, $len) !== 0) {
            return false;
        }

        // 检查namespace对应的目录是否存在
        if (!file_exists($directory) || !is_dir($directory)) {
            return false;
        }
        $dir = realpath($directory);

        // 去除$class中的命名空间后的剩余部分
        $cls = substr($class, $len + 1);

        /*
         * 依次检查：
         * 1. <根目录>/Dir/Class.php 是否存在？
         * 2. <根目录>/Dir/Class/Class.php 是否存在？
         * 先找到哪个就加载哪个，要都找不到就退出
         */
        $target = "{$dir}/{$cls}.php";
        if (file_exists($target) && is_file($target)) {
            require $target;
            return true;
        }

        // 如果 $cls 中不包含 \
        if (strpos($cls, '\\') === false) {
            $target = $dir . "/{$cls}/{$cls}.php";
            if (file_exists($target) && is_file($target)) {
                require $target;
                return true;
            } else {
                return false;
            }
        }

        // 如果 $cls 中包含 \
        $array = explode('\\', $cls);
        $name = array_pop($array);
        $base = implode('\\', $array);
        $target = "{$dir}/{$base}/{$name}.php";
        $target = $dir . "/{$cls}/{$cls}.php";
        if (file_exists($target) && is_file($target)) {
            require $target;
            return true;
        } else {
            return false;
        }
    }


    /**
     * 新增一个别名
     *
     * @param string $alias  \A\Class\Alias\FQCN
     * @param string $real   \Its\Real\FQCN
     */
    public static function addAlias($alias, $real)
    {
        // 确保Loader已经init()
        self::init();

        if (array_key_exists($alias, self::$_aliases)) {
            return false;
        }

        self::$_aliases[$alias] = $real;

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
