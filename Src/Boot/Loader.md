# Dida\Boot\Loader 类

## 目标

对一个未知类，按照设定的匹配规则，找到并自动加载对应的php类文件。

## 匹配规则

Loader支持三种查找规则：

* Classmap    类对照表方式。
* Namespace   命名空间方式。
* Alias       别名方式。

### Classmap方式

用法：

```php
Loader::addClassmap(Classmap文件, 对应的根目录);
```

代码示例：

```php
Loader::addClassmap(DIDA_ROOT . 'Classmap.php', DIDA_ROOT);    // 注册所有Dida类文件的位置对照表
```

其中，`Classmap.php` 内容为：

```php
<?php
return [
    'Dida\\Application'    => 'Application/Application.php',
    'Dida\\Config'         => 'Config/Config.php',
    'Dida\\Container'      => 'Container/Container.php',
    'Dida\\Controller'     => 'Controller/Controller.php',

    ...

    'Dida\\View'           => 'View/View.php',
];
```

### Namespace方式

用法：

```php
Loader::addNamespace(Namespace的名字，对应的根目录);
```

说明：

```
对于Root\Your\Cool\Class类，检查：
1. <rootpath>/Your/Cool/Class.php 是否存在？
2. <rootpath>/Your/Cool/Class/Class.php 是否存在？
先找到哪个就加载哪个，要都找不到就返false。
```

代码示例：

```php
Loader::addNamespace('Dida', DIDA_ROOT);     // 登记Dida命名空间
```

### ALias方式

对PHP的class_alias的一个包装。

