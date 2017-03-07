# Dida\Loader 类

对于一个未声明的类，找到并自动加载对应的php类文件。

Loader支持三种类路径查找方式：

* ClassMap    类名文件对应表方式。
* Namespace   命名空间方式。寻找对应的根目录下的某个php文件。
* Alias       别名类方式。寻找真实类名。

## Namespace类型

依次检查：

1. `<根目录>/Foo/Bar.php`     是否存在？
2. `<根目录>/Foo/Bar/Bar.php` 是否存在？

先找到哪个就加载哪个，都找不到就退出。

