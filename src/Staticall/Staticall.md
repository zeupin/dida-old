# Dida\Staticall

Staticall实现了在程序中无需声明就直接进行静态调用的功能，类似于Laravel的Facade，但是更加清晰简洁。

## 用法

```php
<?php
require __DIR__ . '/../autoload.php';   // composer的机制

use Dida\Staticall;

/* 随便定义的一个测试类 */
class Demo
{
    public function say($a, $b='aa')
    {
        return PHP_EOL . $a . ' and ' . $b;
    }
}

$app = new Dida\Container;            // 新容器
$app->set('demo','Demo');             // $app['demo'] = 'Demo';

// 初始化 Staticall 机制
Staticall::init($app);                // 如果eval()没有被禁用，用这个不带缓存目录的模式，比较轻巧
Staticall::init($app, '缓存目录');     // 如果eval()被禁用，就用带缓存目录的模式，通用性好

Staticall::link('Foo', 'demo');       // 告诉PHP，Foo类关联的是$app['demo']
Staticall::link('Bar', 'demo');       // 告诉PHP，Bar类也关联的是$app['demo']

echo Foo::say('hi');                  // 显示 hi and aa
echo Bar::say('foo', '222');          // 显示 foo and 222
```

酷吧！其实系统里面根本没有Foo或者Bar这两个被调用的类！实际调用的Demo类中也不存在static的静态方法say()，只有一个普通的say()方法，而且，连Laravel中要定义的DemoFacade类文件都可以省去！:)

## 什么是Staticall

首先，我承认，网上其实根本没有`Staticall`这个词，`Staticall`这个词是我杜撰出来的，表示`Static`+`Call`。虽然俗话说，取名是最困难的事情之一，但是对于文学和英语功底比较深的Macc哥来说，胡诌个靠谱的名词那都是小case。:)

`Staticall`主要目的是实现无声明静态调用，就如上面的`Foo::say()`和`Bar::say()`那样，只要你能事先启动Staticall机制，并且告诉系统`Foo`就是指`$app['demo']`，剩下的就是放心大胆的用就行。用的时候，Staticall会帮你去找到`$app['demo']`，执行调用，然后给你想要的结果。