# Lang

## 调用文件 test1.php

```php
$lang = new \Dida\Lang();
$lang->rootSet(DIDA_VAR_ROOT . 'lang')
     ->relSet('Demo')
     ->sourceLangSet('en_US')
     ->targetLangSet('zh_CN');
echo $lang['hi'];                    // 显示 你好
echo $lang['Good morning!'];         // 显示 早上好
```

## 语言文件的目录结构和文件内容

### 目录结构

```
+ lang/                                 // root，根目录
    + Demo/                             // rel，不同的模块可设置为不同的rel，加快查询效率。
	    - en_US.php                     // sourceLang，源语言的value一律为空串。
		- zh_CN.php                     // targetLang，目标语言。
```

### en_US.php

```php
<?php
return array (
    'Good morning!' => '',
    'hi'            => '',
);
```

### zh_CN.php

```php
<?php
return array (
    'Good morning!' => '早上好！',
    'hi'            => '你好',
);
```