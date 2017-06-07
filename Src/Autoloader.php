<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

class Autoloader
{
    private static $_initialized = false;
    private static $_queue = [];


    /**
     * Initialization
     */
    public static function init()
    {
        // only run once
        if (self::$_initialized) {
            return;
        }

        // register the autoload() callback
        spl_autoload_register([__CLASS__, 'autoload']);

        // set the flag
        self::$_initialized = true;
    }


    /**
     * Checks the queue, autoloads if matched one.
     *
     * @param string $FQCN  Fully Qualified Class Name.
     */
    protected static function autoload($FQCN)
    {
        foreach (self::$_queue as $item) {
            switch ($item['type']) {
                case 'classmap':
                    $result = self::matchClassmap($FQCN, $item['mapfile'], $item['rootpath'], $item['map']);
                    if ($result) {
                        return true;
                    }
                    break;

                case 'namespace':
                    $result = self::matchNamespace($FQCN, $item['namespace'], $item['rootpath'], $item['len']);
                    if ($result) {
                        return true;
                    }
                    break;

                case 'psr4':
                    $result = self::matchPsr4($FQCN, $item['namespace'], $item['rootpath'], $item['len']);
                    if ($result) {
                        return true;
                    }
                    break;

                case 'alias':
                    $result = self::matchAlias($FQCN, $item['alias'], $item['real']);
                    if ($result) {
                        return true;
                    }
                    break;
            }
        }

        // Not matched anyone, return false
        return false;
    }


    /**
     * Adds a PSR-4 namespace
     *
     * @param string $namespace  Namespace. such as 'your\\namespace'
     * @param string $rootpath   Rootpath. such as '/your/namespace/root/rootpath/'
     *
     * @return bool
     */
    public static function addPsr4($namespace, $rootpath)
    {
        // Initialize
        self::init();

        // Checks $rootpath
        if (!file_exists($rootpath) || !is_dir($rootpath)) {
            return false;
        } else {
            $rootpath = realpath($rootpath);
        }

        // Preproccesses $namepsace
        $namespace = trim($namespace, " \\\t\n\r\0\x0B");

        // Adds it to $_queue
        self::$_queue[] = [
            'type'      => 'psr4',
            'namespace' => $namespace,
            'rootpath'  => $rootpath,
            'len'       => strlen($namespace),
        ];

        return true;
    }


    /**
     * Adds a namespace.
     *
     * If try to match the \Namepsace\Your\Cool\Class,
     * it will check:
     *   <rootpath>/Your/Cool/Class.php
     *   <rootpath>/Your/Cool/Class/Class.php
     *
     * @param string $namespace  Namespace. such as 'your\\namespace'
     * @param string $rootpath   Rootpath. such as '/your/namespace/root/rootpath/'
     *
     * @return bool
     */
    public static function addNamespace($namespace, $rootpath)
    {
        // Initialize
        self::init();

        // Checks $rootpath
        if (!file_exists($rootpath) || !is_dir($rootpath)) {
            return false;
        } else {
            $rootpath = realpath($rootpath);
        }

        // Preproccesses $namepsace
        $namespace = trim($namespace, " \\\t\n\r\0\x0B");

        // Adds it to $_queue
        self::$_queue[] = [
            'type'      => 'namespace',
            'namespace' => $namespace,
            'rootpath'  => $rootpath,
            'len'       => strlen($namespace),
        ];

        return true;
    }


    /**
     * Adds a class map file
     *
     * @param string $mapfile   The real path of the class map file.
     * @param string $rootpath  The root path. default uses the mapfile's directory.
     *
     * @return bool
     */
    public static function addClassmap($mapfile, $rootpath = null)
    {
        // Initialize
        self::init();

        // Checks $mapfile
        if (!file_exists($mapfile) || !is_file($mapfile)) {
            return false;
        } else {
            $mapfile = realpath($mapfile);
        }

        // Checks $rootpath
        if (is_null($rootpath)) {
            $rootpath = dirname($mapfile);
        } elseif (!is_string($rootpath) || !file_exists($rootpath) || !is_dir($rootpath)) {
            return false;
        } else {
            $rootpath = realpath($rootpath);
        }

        // Adds it to $_queue
        self::$_queue[] = [
            'type'     => 'classmap',
            'mapfile'  => $mapfile,
            'rootpath' => $rootpath,
            'map'      => null,
        ];

        return true;
    }


    /**
     * Add an alias
     *
     * @param string $alias  Your\Class\Alias
     * @param string $real   \Its\Real\FQCN
     *
     * @return bool
     */
    public static function addAlias($alias, $real)
    {
        // Initialize
        self::init();

        // Adds it to $_queue
        self::$_queue[] = [
            'type'  => 'alias',
            'alias' => $alias,
            'real'  => $real,
        ];

        return true;
    }


    /**
     * Matches a PSR-4 namespace
     */
    private static function matchPsr4($FQCN, $namespace, $rootpath, $len)
    {
        // Checks if the prefix is matched.
        if (strncmp($FQCN, $namespace . '\\', $len + 1) !== 0) {
            return false;
        }

        // Strips the namespace
        $rest = substr($FQCN, $len + 1);

        // Checks if the target php file exists.
        $target = "{$rootpath}/{$rest}.php";
        if (file_exists($target) && is_file($target)) {
            require $target;
            return true;
        } else {
            return false;
        }
    }


    /**
     * Matches a namespace
     */
    private static function matchNamespace($FQCN, $namespace, $rootpath, $len)
    {
        // Checks if the prefix is matched.
        if (strncmp($FQCN, $namespace . '\\', $len + 1) !== 0) {
            return false;
        }

        // Strips the namespace
        $rest = substr($FQCN, $len + 1);

        // Checks if the target php file exists.
        $target = "$rootpath/$rest.php";
        if (file_exists($target) && is_file($target)) {
            require $target;
            return true;
        }

        // If $rest not contain '\'
        if (strpos($rest, '\\') === false) {
            $target = "{$rootpath}/{$rest}/{$rest}.php";
            if (file_exists($target) && is_file($target)) {
                require $target;
                return true;
            } else {
                return false;
            }
        }

        // If $rest contains '\', split $rest to $base + $name, then checks files exist.
        $array = explode('\\', $rest);
        $name = array_pop($array);
        $base = implode('/', $array);
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


    /**
     * Matches FQCN from the map file
     */
    private static function matchClassmap($FQCN, $mapfile, $rootpath, &$map)
    {
        // If first run, loads the mapfile content to $map.
        if (is_null($map)) {
            $map = require($mapfile);

            // Checks $map, sets it to [] if invalid.
            if (!is_array($map)) {
                $map = [];
                return false;
            }
        }

        // Checks if $map is empty.
        if (empty($map)) {
            return false;
        }

        // Checks if FQCN exists.
        if (!array_key_exists($FQCN, $map)) {
            return false;
        }

        // Loads the target file.
        $target = $rootpath . '/' . $map[$FQCN];
        if (file_exists($target) && is_file($target)) {
            require $target;
            return true;
        } else {
            return false;
        }
    }


    /**
     * Matches an alias
     */
    private static function matchAlias($FQCN, $alias, $real)
    {
        if ($FQCN === $alias) {
            return class_alias($real, $alias);
        } else {
            return false;
        }
    }
}
