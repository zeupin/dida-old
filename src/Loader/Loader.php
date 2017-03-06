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
    private $_classmaps = [];       // 已注册的类名对照表文件
    private $_namespaces = [];      // 已注册的名称空间列表
    private $_aliases = [];         // 已注册的别名列表
    private $_queue = [];           // 待查询队列


    public function __construct()
    {
        spl_autoload_register([$this, 'autoload']);
    }


    /**
     * 根据给出的FQCN格式的类名，尝试找到并载入相应的类文件
     *
     * @param string $class 给出的FQCN格式的类名
     *
     * @return bool 载入成功返回true，载入失败返回false
     */
    protected function autoload($class)
    {
        foreach ($this->_queue as $item) {
            switch ($item['type']) {
                case 'classmap':
                    $result = $this->loadClassMap($class, $item['mapfile']);
                    if ($result) {
                        return true;
                    }
                    break;
                case 'namespace':
                    $result = $this->loadNamespace($class, $item['namespace'], $item['directory']);
                    if ($result) {
                        return true;
                    }
                    break;
                case 'alias':
                    $result = $this->loadAlias($class, $item['alias'], $item['real']);
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
     * 尝试从类名对照表中查找类的定义文件
     *
     * @param type $class
     * @param type $mapfile
     * @return boolean
     */
    private function loadClassMap($class, $mapfile)
    {
        if (is_null($this->_classmaps[$mapfile])) {
            // 如果是第一次执行，则先载入mapfile文件。这样后面就不用重复载入文件，直接查就行了。
            if (!file_exists($mapfile) || !is_file($mapfile)) {
                $this->_classmaps[$mapfile] = [];
                return false;
            }

            // 载入classmap文件
            $map = require($mapfile);

            // 检查载入的文件是否合法
            if (!is_array($map)) {
                $this->_classmaps[$mapfile] = [];
                return false;
            }

            // 保存
            $this->_classmaps[$mapfile] = $map;
        } elseif (!is_array($this->_classmaps[$mapfile])) {
            return false;
        }
        if (empty($this->_classmaps[$mapfile])) {
            return false;
        }

        $classmap = $this->_classmaps[$mapfile];

        if (!array_key_exists($class, $classmap)) {
            return false;
        }

        $mapdir = dirname($mapfile) . '/';
        $target = $mapdir . $classmap[$class];
        if (file_exists($target) && is_file($target)) {
            require $target;
        }

        // 确认是否$class已经成功载入
        if (class_exists($class)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 尝试从命名空间对应的目录
     *
     * @param string $class 要载入的类名（FQCN格式）
     * @param string $namespace 命名空间（Your\Namespace）
     * @param string $directory 命名空间对应的目录位置
     *
     * @return bool
     */
    private function loadNamespace($class, $namespace, $directory)
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

        // 去除$class中的名称空间部分
        $cls = substr($class, $len + 1);

        /*
         * 依次检查：
         * 1. <根目录>/Foo/Class.php 是否存在？
         * 2. <根目录>/Foo/Class/Class.php 是否存在？
         * 先找到哪个就加载哪个，要都找不到就退出
         */
        $target = "{$dir}/{$cls}.php";
        if (file_exists($target) && is_file($target)) {
            require($target);
        } else {
            $array = explode('\\', $cls);
            $base = array_pop($array);
            if (count($array)) {
                $target = $dir . '/' . ((count($array)) ? implode('/', $array) : '') . "/{$base}/{$base}.php";
            } else {
                $target = $dir . "/{$base}/{$base}.php";
            }
            if (file_exists($target) && is_file($target)) {
                require($target);
            } else {
                return false;
            }
        }

        // 确认是否$class已经成功载入
        if (class_exists($class)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 载入一个类的别名
     *
     * @param string $class 要载入的类名（FQCN格式）
     * @param string $alias 类的别名（FQCN格式）
     * @param string $real  实际的类名（FQCN格式）
     *
     * @return bool
     */
    private function loadAlias($class, $alias, $real)
    {
        if ($class === $alias) {
            return class_alias($real, $alias);
        } else {
            return false;
        }
    }


    /**
     *
     * @param string $mapfile 类的地图文件
     */
    public function regClassMap($mapfile)
    {
        $this->_classmaps [$mapfile] = null;

        $this->_queue[] = [
            'type'    => 'classmap',
            'mapfile' => $mapfile,
        ];

        return $this;
    }


    /**
     * 注册一个命名空间
     *
     * @param string $namespace  命名空间，形如：'your\\namespace'
     * @param string $directory  对应目录，形如：'/your/namespace/root/directory/'
     */
    public function regNamespace($namespace, $directory)
    {
        // 对参数$namespace进行标准化，去除其前后的空白字符以及字符'\'
        $namespace = trim($namespace, "\\ \t\n\r\0\x0B");

        $this->_namespaces[$namespace] = $directory;

        $this->_queue[] = [
            'type'      => 'namespace',
            'namespace' => $namespace,
            'directory' => $directory,
        ];

        return $this;
    }


    /**
     * 注册一个别名类
     *
     * @param string $alias \a\class\alias\FQCN
     * @param string $real its\real\FQCN
     *
     * @return Dida\Loader 链式执行
     */
    public function regAlias($alias, $real)
    {
        if (array_key_exists($alias, $this->_aliases)) {
            throw new \Exception('重复注册别名类');
        }

        $this->_aliases[$alias] = $real;

        $this->_queue[] = [
            'type'  => 'alias',
            'alias' => $alias,
            'real'  => $real,
        ];

        return $this;
    }
}
