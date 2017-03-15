<?php
/**
 * Dida Framework --Powered by Zeupin LLC
 * http://dida.zeupin.com
 */

namespace Dida;

/**
 * Lang 基类
 */
class Lang implements \ArrayAccess
{
    /* 主要变量 */
    protected $root = null;             // 根路径
    protected $rel = null;              // 相对路径
    protected $sourceLang = null;       // 源语言
    protected $targetLang = null;       // 目标语言
    protected $autosave = false;        // 自动保存

    /* 字典 */
    private $source = [];
    private $target = [];

    /* 状态变量 */
    private $loaded = false;
    private $sourceChanged = false;
    private $targetChanged = false;


    public function __construct($root = null, $rel = null, $sourceLang = null, $targetLang = null)
    {
        $this->rootSet($root);
        $this->relSet($rel);
        $this->sourceLangSet($sourceLang);
        $this->targetLangSet($targetLang);
    }


    public function rootSet($root)
    {
        if (is_string($root) && file_exists($root) && is_dir($root)) {
            $this->root = realpath($root);
        } else {
            $this->root = null;
        }
        return $this;
    }


    public function relSet($rel)
    {
        if (is_string($rel)) {
            $this->rel = $rel;
        } else {
            $this->rel = null;
        }
        return $this;
    }


    public function sourceLangSet($lang)
    {
        if (is_string($lang)) {
            $this->sourceLang = $lang;
        } else {
            $this->sourceLang = null;
        }
        $this->loaded = false;
        return $this;
    }


    public function targetLangSet($lang)
    {
        if (is_string($lang)) {
            $this->targetLang = $lang;
        } else {
            $this->targetLang = null;
        }
        $this->loaded = false;
        return $this;
    }


    public function autosaveSet($bool)
    {
        $this->autosave = $bool;
        return $this;
    }


    public function get($text)
    {
        if (!$this->loaded) {
            $this->load();
        }

        if ($this->autosave) {
            if (!array_key_exists($text, $this->source)) {
                $this->source[$text] = '';
                $this->sourceChanged = true;
            }
        }

        if (array_key_exists($text, $this->target)) {
            return $this->target[$text];
        } else {
            return $text;
        }
    }


    public function load()
    {
        $this->loadLang($this->sourceLang, $this->source);
        $this->loadLang($this->targetLang, $this->target);
        $this->loaded = true;
    }


    public function __destruct()
    {
        if ($this->autosave) {
            $this->save();
            return;
        }
    }


    public function save()
    {
        if (is_null($this->root) || is_null($this->rel)) {
            return;
        }

        if ($this->sourceChanged) {
            ksort($this->source);
            $this->saveLang($this->$sourceLang, $this->source);
        }

        if ($this->targetChanged) {
            ksort($this->target);
            $this->saveLang($this->targetLang, $this->target);
        }
    }


    /**
     * 载入一个指定语言文件到字典中
     *
     * @param string $lang
     * @param array  $dict
     *
     * @return bool
     */
    private function loadLang($lang, &$dict)
    {
        $dict = [];

        $root = $this->root;
        $rel = $this->rel;

        if (!is_string($root) || !is_string($rel) || !is_string($lang)) {
            return false;
        }

        $path = "{$root}/{$rel}/{$lang}.php";
        if (!file_exists($path) || !is_file($path)) {
            return false;
        }

        $result = require($path);
        if (is_array($result)) {
            $dict = $result;
            return true;
        } else {
            return false;
        }
    }


    /**
     * 保存字典数据到语言文件中
     *
     * @param string  $lang
     * @param array   $dict
     *
     * @return bool
     */
    private function saveLang($lang, &$dict)
    {
        $root = $this->root;
        $rel = $this->rel;

        if (!is_string($root) || !is_string($rel) || !is_string($lang)) {
            return false;
        }

        $dir = "{$root}/{$rel}";
        if (!file_exists($dir)) {
            if (!@mkdir($dir, 0777)) {
                return false;
            }
        } elseif (!is_dir($dir)) {
            return false;
        }

        $path = "$dir/{$lang}.php";

        $var = var_export($dict, true);
        $content = <<<EOF
<?php
return $var;
EOF;
        return @file_put_contents($path, $content);
    }


    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->source);
    }


    public function offsetGet($offset)
    {
        return $this->get($offset);
    }


    public function offsetSet($offset, $value)
    {
    }


    public function offsetUnset($offset)
    {
    }
}
